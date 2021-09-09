<?php

namespace App\Http\Controllers;

use App\Events\TicketEvent;
use App\Models\Comment;
use App\Models\Ticket;
use App\Traits\EmailTrait;
use Illuminate\Http\Request;
use App\Mailers\AppMailer;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TicketNotification;
use App\Models\User;

class CommentsController extends Controller
{
    use EmailTrait;

    public function postComment(Request $request, AppMailer $mailer)
	{
	    $ticketId = $request->input('ticket_id');
	    $status = $request->input('status');
        $ticket = Ticket::find($ticketId);

        if (!empty($request->jira)){
            $text = $request->jira;
            $jiraUrl = 'https://implementhit.atlassian.net/browse/';
            $chain = strrpos($text,$jiraUrl);
            if ($chain === false){
                $jiraUrl = 'https://implementhit.atlassian.net/browse/'.$request->jira;
                $ticket->jira = $jiraUrl;
                $ticket->save();
            }
            else {
                $ticket->jira = $text;
                $ticket->save();
            }
        }

        $this->validate($request, [
	        'comment'   => 'required'
	    ]);

        $comment = $request->input('comment');
        $public = $request->input('private') === null ? 1 : 0;

        $comment = Comment::create([
            'ticket_id' => $ticketId,
            'user_id'   => Auth::user()->id,
            'comment'   => $comment,
            'public'    => $public
        ]);
    
        
        if ($status == 'Closed'){
            $ticket->update(['status' => 'Closed']);
        }

        $ticketOwner = $comment->ticket->user;
        $authUser = Auth::user();
        $subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";
        $deptUser = User::where('department_id',$ticket->department_id)->get();
        $subject = "[Commented Ticket: $ticket->ticket_id]";
        $details = ['title' => $subject, 'ticket_id' => $ticket->ticket_id];
        if (!empty($deptUser)){
            foreach ($deptUser as $key => $value) {
                \Notification::send($deptUser[$key], new TicketNotification($details));
            }
        }

        // send mail if the user commenting is not the ticket owner
        if ($comment->ticket->user->id !== $authUser->id) {
            $mailText = $this->commentTemplate($authUser, $ticket, $subject, $comment);
            $settingSendEmail = [
                'mailText' => $mailText,
                'user' => $ticketOwner,
                'subject' => $subject,
                'status' => 'comment',
            ];

            event(new TicketEvent($settingSendEmail));
        }
        

        $notify = updateNotify('Your comment has been submitted');

        return redirect()->back()->with($notify);
	}
}
