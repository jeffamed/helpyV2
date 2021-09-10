<?php

namespace App\Jobs;

use App\Mail\CloseTicket;
use App\Mail\TicketStoreEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class TicketStoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $info;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {    
        $email = $this->info['email'];
        $subject = $this->info['subject'];
        $mailText = $this->info['mailText'];
        
        if ($this->info['status'] === 'create') {
            $users = User::where([['user_type', 1],['status', 1],['department_id', $this->info['dpto_ticket']]])->get();

            foreach ($users as $userinfo) {
                //send email to user staff of the department
                Mail::to($userinfo->email)->send(new TicketStoreEmail($this->info['user']));
            }
        }else if($this->info['status'] === 'close'){
            $users = User::where([['user_type', 1],['status', 1],['department_id', $this->info['dpto_ticket']]])->get();

            foreach ($users as $userinfo) {
                Mail::to($userinfo->email)->send(new CloseTicket($this->info['ticket']));
            }
        }

        Mail::send([],[], function($message) use ($email, $subject, $mailText)
        {
            $message->to($email)->subject($subject)->setBody($mailText, 'text/html');
        });
    }
}
