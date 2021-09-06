<?php

namespace App\Http\Controllers\Api;

use App\Events\TicketEvent;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Ticket;
use App\Mailers\AppMailer;
use App\Models\TicketCustomField;
use App\Notifications\TicketNotification;
use App\Traits\CustomFieldTrait;
use App\Traits\EmailTrait;
use App\Traits\ApiResponseTrait;
use App\User;
use Illuminate\Http\Request;


class TicketsController extends Controller
{
    use CustomFieldTrait, EmailTrait, ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'user' => 'required|integer',
            'title'     => 'required',
            'department'  => 'required|integer',
            'priority'  => 'required',
            'message'   => 'required'
        ]);
        
	    $authUser = User::find($request->user);
        
        $deptUser = Department::with('user')->findOrFail($request->department);
        
        $ticket = new Ticket([
            'title'     => $request->title,
            'user_id'   => $request->user,
            'ticket_id' => strtoupper(str_random(10)),
            'department_id'  => $request->department,
            'priority'  => $request->priority,
            'message'   => $request->message,
            'status'    => "Open",
        ]);

        $customs=  array_filter(explode(",", $request->custom_id));
        $values=  array_filter(explode(",", $request->value));
        
        if (count($customs) != count($values)) {
           return $this->errorResponse("Not all custom field is fully", 404);
        }
        
        if ($ticket->save()) {

            if(count($customs) && count($values)){
                for ($i=0; $i < count($customs); $i++) { 
                    $data = [
                        'ticket_id' => $ticket->id,
                        'custom_field_id' => $customs[$i],
                        'value' => $values[$i],
                        'created_at' => now()
                    ];
        
                    TicketCustomField::insert($data);
                }
            }
            
            $mailText = $this->newTicketSubmitTemplate($authUser,$ticket);

            $ticketLink = \Request::root().'/ticket/'.$ticket->ticket_id;
            $authUser->link = $ticketLink;
            
            $subject = "[Ticket ID: $ticket->ticket_id] $ticket->title";
            
            $settingSendEmail = [
                'mailText' => $mailText,
                'user' => $authUser,
                'subject' => $subject,
                'status' => 'create',
                'dpto_ticket' => $ticket->department_id
            ];

            event(new TicketEvent($settingSendEmail));

            $details = ['title' => $subject, 'ticket_id' => $ticket->ticket_id];
            // send notification
            if ($deptUser->user->isNotEmpty()){
                for ($i=0; $i < count($deptUser->user); $i++) { 
                    $deptUser->user[$i]->notify(new TicketNotification($details));
                }
            }else{
                $authUser->isAdmin()->notify(new TicketNotification($details));
            }
            
        }
        
        return $this->successReponse(["Registered Success"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
