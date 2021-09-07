<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    protected $fillable = [
    'ticket_id', 'user_id', 'comment','public'
	];

	public function ticket()
	{
	    return $this->belongsTo(Ticket::class);
	}

	public function user()
	{
	    return $this->belongsTo(User::class);
	}

}
