<?php

namespace App\Widgets;

use App\Models\Department;
use App\Models\KnowledgeBase;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vote;
use Arrilot\Widgets\AbstractWidget;

class DasboardCounterStatus extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = [];
        $countUser = User::where('user_type',0)->where('is_admin',0)->count();
        $countStaff = User::where('user_type',1)->where('is_admin',0)->count();
        $countDept = Department::count();
        $countKB = KnowledgeBase::count();

        $totalTicket = Ticket::count();
        $openTickets = Ticket::where('status','Open')->count();
        $closeTickets = Ticket::where('status',"Closed")->count();
        
        $vote = Vote::where('satisfied', Vote::SATISFIED)->count();

        $count = [
            'countUser' => $countUser,
            'countStaff' => $countStaff,
            'countDept' => $countDept,
            'countKB' => $countKB,
            'totalTicket' => $totalTicket,
            'openTickets' => $openTickets,
            'closeTickets' => $closeTickets,
            'vote' => $vote
        ];

        return view('widgets.dasboard_counter_status', [
            'count' => $count,
        ]);
    }
}
