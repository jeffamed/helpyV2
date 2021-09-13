<?php

namespace App\Exports;

use App\Models\CustomField;
use App\Models\Ticket;
use App\Models\TicketCustomField;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClosedTicketsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $idCustom = CustomField::where('name','Issue Type')->first();
        $idType = CustomField::where('name','Type')->first();
        $tickets = Ticket::join('departments','tickets.department_id','=','departments.id')
                   ->join('users','tickets.user_id','=','users.id')
                   ->select('tickets.*','departments.title as departments','users.name as users')->addSelect(
                    ['value' => TicketCustomField::select('value')
                    ->where('custom_field_id', $idCustom->id)
                    ->whereColumn('ticket_id','tickets.id'), 
                    'valueType' => TicketCustomField::select('value')
                    ->where('custom_field_id', $idType->id)
                    ->whereColumn('ticket_id','tickets.id')]
                )->where('tickets.status','closed')->get();
                
        return view('export.close-tickets',['tickets' => $tickets]);
    }
}
