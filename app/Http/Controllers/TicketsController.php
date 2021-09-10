<?php

namespace App\Http\Controllers;

use App\Events\TicketEvent;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllTicketsExport;
use App\Exports\ClosedTicketsExport;
use App\Exports\OpenedTicketsExport;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\CustomField;
use App\Models\FieldsOption;
use App\Traits\EmailTrait;
use App\Traits\CustomFieldTrait;
use Illuminate\Http\Request;
use App\Mailers\AppMailer;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\TicketCustomField;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Notifications\TicketNotification;
use App\Models\User;
use Faker\Provider\ar_SA\Color;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class TicketsController extends Controller
{
    use EmailTrait, CustomFieldTrait;

	public function __construct()
	{
	    //$this->middleware('auth');
	}

	public function index()
	{
        $departments = Department::all();
        $idCustom = CustomField::where('name', 'Issue Type')->first();
        $idType = CustomField::where('name', 'Type')->first();
        $options = $idCustom->options;
        $optType = $idType->options;

	    return view('tickets.index', compact('departments','options','optType'));
	}

	public function getTicketData(Request $request)
    {
        //$user = Auth::user(1);
        $user = User::find(1);
        $idCustom = CustomField::where('name','Issue Type')->first();
        $idType = CustomField::where('name','Type')->first();
        
        if ($user->is_admin){
            $data = Ticket::addSelect(
                ['value' => TicketCustomField::select('value')
                ->where('custom_field_id', $idCustom->id)
                ->whereColumn('ticket_id','tickets.id'), 
                'valueType' => TicketCustomField::select('value')
                ->where('custom_field_id', $idType->id)
                ->whereColumn('ticket_id','tickets.id'),
                'comment' => Comment::select('comment')
                ->where('public',0)
                ->whereColumn('ticket_id','tickets.id')
                ->orderBy('id', 'desc')
                ->limit(1),
                'UserComment' => User::join('comments','users.id','=','comments.user_id')
                ->select('users.name')
                ->where('public',0)
                ->whereColumn('ticket_id','tickets.id')
                ->orderBy('comments.id', 'desc')
                ->limit(1)]
            );
        }else if ($user->user_type == 1){
            $data = Ticket::addSelect(
                ['value' => TicketCustomField::select('value')
                ->where('custom_field_id', $idCustom->id)
                ->whereColumn('ticket_id','tickets.id'),
                'valueType' => TicketCustomField::select('value')
                ->where('custom_field_id', $idType->id)
                ->whereColumn('ticket_id','tickets.id'),
                'comment' => Comment::select('comment')
                ->where('public',0)
                ->whereColumn('ticket_id','tickets.id')
                ->orderBy('id', 'desc')
                ->limit(1),
                'UserComment' => User::join('comments','users.id','=','comments.user_id')
                ->select('users.name')
                ->where('public',0)
                ->whereColumn('ticket_id','tickets.id')
                ->orderBy('comments.id', 'desc')
                ->limit(1)])
                ->where('department_id', $user->department_id);
        }else{
            $data = Ticket::addSelect(
                ['value' => TicketCustomField::select('value')
                ->where('custom_field_id', $idCustom->id)
                ->whereColumn('ticket_id','tickets.id'),
                'valueType' => TicketCustomField::select('value')
                ->where('custom_field_id', $idType->id)
                ->whereColumn('ticket_id','tickets.id')])
                ->where('user_id', $user->id);
        }

        if (($request->has('ticketOptType')) && ($request->ticketOptType !='all')){
            $data->whereHas('ticketCustomField', function (Builder $query) use ($request, $idCustom) {
                $query->where([['value', $request->ticketOptType], ['custom_field_id', $idCustom->id ]]);
            });
        }

        if (($request->has('ticketOptType2')) && ($request->ticketOptType2 !='all')){
            $data->whereHas('ticketCustomField', function (Builder $query) use ($request, $idType) {
                $query->where([['value', $request->ticketOptType2], ['custom_field_id', $idType->id]]);
            });
        }
        return Datatables::of($data->when($request->ticketType != 'all', function ($q) use($request){
            $q->where('status',$request->ticketType);
        }))
            ->filter( function ($query) use ($request, $user){
                $search = $request->search['value'];
                if (($request->has('startDate')) && ($request->has('endDate'))) {
                    $query->whereBetween(DB::raw('DATE(tickets.created_at)'), [$request->startDate, $request->endDate]);
                }
                if (($request->has('ticketDepartment')) && ($request->ticketDepartment !='all')){
                    $query->where('department_id', $request->ticketDepartment);
                }
                if (($request->has('ticketPriority')) && ($request->ticketPriority !='all')){
                    $query->where('priority', $request->ticketPriority);
                }
                if($request->has('search') && $user->user_type == 0 && $user->is_admin == 0){
                    $query->where('user_id', $user->id)
                        ->Where('ticket_id', 'LIKE', "%$search%")
                        ->Where('title','LIKE',"%$search%");
                }else{
                    if ($request->has('search') && $search != null){
                        $query->where('title', 'LIKE', "%$search%")
                            ->orWhere('ticket_id', 'LIKE', "%$search%")
                            ->orWhere('priority', 'LIKE', "%$search%");
                    }
                }
            })
            ->addColumn('ticket_title', function ($data) {
                $ticketRoute = route('ticket.show', $data->ticket_id);
                $val = '<a href="' . $ticketRoute . '">'.$data->title.'</a>';
                $comments = Auth::user()->is_admin || (Auth::user()->role != null && Auth::user()->role->title === 'Admin')?
                 '<p><b><em style="color:gray; font-size: 12px; line-height: 1.25;">'.$data->comment.'</em></b></p>':'';
                return $val.$comments;
            })
            ->addColumn('department', function ($data) {
                return $data->department->title;
            })
            ->addColumn('user_name', function ($data) {
                $users = 0;
                if (Auth::user()->is_admin || (Auth::user()->role != null && Auth::user()->role->title === 'Admin')){
                    if ($data->UserComment != null){
                        $users=optional($data->user)->name.' / '.$data->UserComment;
                    }
                    else{
                        $users=optional($data->user)->name;
                    }
                }
                else{
                    $users=optional($data->user)->name;
                }
                return $users;
            })
            ->addColumn('value', function ($data) {
                return $data->valueType." / ".$data->value;
            })
            ->addColumn('ticket_status', function ($data) {
                if ($data->status === "Open") {
                    $statusValue = '<span class="badge badge-warning">'.$data->status.'</span>';
                } else {
                    $statusValue = '<span class="badge badge-success">'.$data->status.'</span>';
                }
                return $statusValue;
            })
            ->addColumn('submitted', function ($data) {
                return $data->created_at->format('Y m d, h:i A');
            })
            ->addColumn('updated', function ($data) {
                return $data->updated_at->format('Y m d, h:i A');
            })
            ->addColumn('jira', function ($data){
                $title = str_replace("https://implementhit.atlassian.net/browse/","",$data->jira);
                $url = '<a href="'.$data->jira.'" target="_blank">'.$title.'</a>';
                return $url;
            })
            ->addColumn('action', function ($data) use($user) {
                $closeRoute = route('close_ticket.close', $data->ticket_id);
                $viewRoute = route('ticket.show', $data->ticket_id);
                $reopenRoute = route('ticketReOpen', $data->ticket_id);
                $jira = '';
                $assign = '';
                $reopen = '';

                $close = '<button type="button" class="badge bg-red pointer" id="btnCloseTicket" data-ticket="'.$data->ticket_id.'" data-id="' . $data->id . '" title="Close">'.__("lang.close").'</button>';
                $jira = $user->is_admin ? '<button type="button" class="badge bg-warning pointer" id="getJiraData" data-jira="'.$data->jira.'" data-id="'.$data->id.'" title="JIRA">JIRA</button>': '';
                $assign = $user->is_admin ?'<button type="button" class="badge bg-info pointer" id="getAssignedTicketData" data-id="'.$data->id.'" title="Re-Assign Department">'.__('lang.reassign').'</button>': '';
                $reopen = $user->is_admin ||  $data->user_id === auth()->user()->id  || $user->role->title == 'Admin'? '<form action="' . $reopenRoute . '" method="post" id="reopen_form_' . $data->id . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <button title="Reopen Ticket" type="submit"  class="badge bg-red pointer" data-id="reopen_form_' . $data->id . '">'.__("lang.reopen").'</button>
                            </form>': '';

                if ($data->status === "Open") {
                    $jira = '<button type="button" class="badge bg-warning pointer" id="getJiraData" data-jira="'.$data->jira.'" data-id="'.$data->id.'" title="JIRA">JIRA</button>';
                    $value = $data->user_id === auth()->user()->id ? '<a href="' . $viewRoute . '"
                    class="badge bg-primary text-white" title="Reply">'.__("lang.reply").'</a>
                    '.$close.$assign.$jira : ( $user->is_admin ? 
                        '<a href="' . $viewRoute . '" class="badge bg-primary text-white" title="Reply">'.__("lang.reply").'</a>
                        '.$close.$jira 
                    :   '<a href="' . $viewRoute . '"
                           class="badge bg-primary text-white" title="Reply">'.__("lang.reply").'</a>'.$jira);
                } else {
                    $jira = '<button type="button" class="badge bg-warning pointer" id="getJiraData" data-jira="'.$data->jira.'" data-id="'.$data->id.'" title="JIRA">JIRA</button>';
                    $value = $reopen.$jira;
                }

                return $value;
            })
            ->rawColumns(['ticket_title','action','ticket_status',"jira"])->make(true);
    }

	public function openedTickets()
	{
        $departments = Department::all();
        $idCustom = CustomField::where('name','Issue Type')->first();
        $idType = CustomField::where('name','Type')->first();
        $options = $idCustom->options;
        $optType = $idType->options;

	    return view('tickets.opened', compact('departments','options','optType'));
	}

	public function ClosedTickets()
	{
        $departments = Department::all();
        $idCustom = CustomField::where('name','Issue Type')->first();
        $idType = CustomField::where('name','Type')->first();
        $options = $idCustom->options;
        $optType = $idType->options;

	    return view('tickets.closed', compact('departments','options','optType'));
	}

    public function create()
	{
        $departments = Department::all();
        $fields = CustomField::with('options')->where("status", CustomField::ACTIVE)->get();

	    return view('tickets.create', compact('departments','fields'));
	}

	public function store(Request $request)
	{
	    $this->validate($request, [
            'title'     => 'required',
            'department'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

	    $authUser = Auth::user();

        $deptUser = Department::with('user')->findOrFail($request->input('department'));


        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => $authUser->id,
            'ticket_id' => strtoupper(str_random(10)),
            'department_id'  => $request->input('department'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "Open",
            'jira' => ''
        ]);
        
        if ($ticket->save()) {

            $this->customFieldStoreLogic($request, $ticket->id);

            $mailText = $this->newTicketSubmitTemplate($authUser,$ticket);

            $subject = "[Ticket ID: $ticket->ticket_id] $ticket->title";
            $ticketLink = \Request::root().'/ticket/'.$ticket->ticket_id;
            $authUser['link'] = $ticketLink;

            $settingSendEmail = [
                'mailText' => $mailText,
                'user' => $authUser,
                'subject' => $subject,
                'status' => 'create',
                'ticket' => NULL,
                'dpto_ticket' => $ticket->department_id
            ];

            //event(new TicketEvent($settingSendEmail));

           $details = ['title' => $subject, 'ticket_id' => $ticket->ticket_id];
            // send notification
            if ($deptUser->user->isNotEmpty()){
                for ($i=0; $i < count($deptUser->user); $i++) { 
                    $deptUser->user[$i]->notify(new TicketNotification($details));
                }
            }else{
                $authUser->isAdmin()->notify(new TicketNotification($details));
            }
            $notify = storeNotify('Ticket');

        }else{
            $notify = errorNotify("Ticket submit");
        }
        return redirect()->back()->with($notify);

	}

	public function show($ticket_id)
	{
	    $ticket = Ticket::with('ticketCustomField')->where('ticket_id', $ticket_id)->firstOrFail();
        $comments = $ticket->comments;
	    $department = $ticket->department;
	    $departments = Department::all();
        $user = Auth::user();
        foreach ($user->unreadNotifications as $notification) {
            $data = $notification->data;
            if ($ticket_id === $data['ticket_id']){
                $notification->markAsRead();
            }
        }
	    return view('tickets.show', compact('ticket', 'department', 'comments','departments'));
	}

	public function close($ticket_id)
	{
	    $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

	    $ticket->status = 'Closed';

        $deptUser = User::where('department_id',$ticket->department_id)->get();

        if ($ticket->save()) {
            $ticketOwner = $ticket->user;
            $mailText = $this->sendTicketStatusNotification($ticketOwner, $ticket);

            $email = $ticketOwner->email;
            $subject = "Your ticket status changed";

            $details = ['title' => $subject, 'ticket_id' => $ticket_id];
            // send notification
            $settingSendEmail = [
                'mailText' => $mailText,
                'user' => $ticketOwner,
                'subject' => $subject,
                'status' => 'close',
                'ticket' => $ticket,
                'dpto_ticket' => $ticket->department_id
            ];

            event(new TicketEvent($settingSendEmail));

            $notify = storeNotify('Ticket closed');

            if (!empty($deptUser)){
                foreach ($deptUser as $key => $value) {
                    \Notification::send($deptUser[$key], new TicketNotification($details));
                }
            }
        }else{
            $notify = errorNotify("Ticket submit");
        }

	    return redirect()->back()->with($notify);

	}

    public function reOpen($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Open';

        if ($ticket->save()) {
            $notify = storeNotify('Ticket Re-Open');
        }else{
            $notify = errorNotify("Ticket Re-Open");
        }

        return redirect()->route('ticket.show',$ticket_id);
    }

    public function assignTo($id)
    {
        $data = Ticket::with('department')->findOrFail($id);
        $departments = Department::all();

        $html = view('tickets.change-dept', compact('data','departments'))->render();

        return response()->json(['html'=>$html]);
    }

    public function assignToDepartment(Request $request,$id)
    {
        $validator = \Validator::make($request->all(), [
            'department' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $ticket = Ticket::find($id);
        $ticket->department_id = $request->department;

        $ticket->save();

        return response()->json(['success'=>'Ticket assigned successfully']);

    }

    public function updateJira(Request $request, $id)    
    {
        $ticket = Ticket::find($id);
        $ticket->jira = $request->jira;

        $ticket->save();
        return response()->json('Jira assigned successfully');
    }

    public function exportAll()
    {
        return Excel::download(new AllTicketsExport, 'all-tickets.xlsx');
    }

    public function exportOpen()
    {
        return Excel::download(new OpenedTicketsExport, 'open-tickets.xlsx');
    }
    
    public function exportClosed()
    {
        return Excel::download(new ClosedTicketsExport, 'closed-tickets.xlsx');
    }
}

