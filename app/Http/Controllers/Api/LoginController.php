<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ApiResponseTrait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $email = $request->email;
        $verified = User::where([["email", $email], ['status', 1]])->firstOrFail();
        return $this->successReponse(["message"=>"Found email","id"=>$verified->id,"name"=>$verified->name],200);
    }
}
