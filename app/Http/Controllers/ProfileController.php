<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        //$user = Auth::user();
        $user = User::find(1);
        return view('profile.index', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|string|email|max:255',
        ]);

        //$user = Auth::id();
        $user = User::find(1);
        $profile = User::find($user->id);
        $profile->name = $request->name;
        $profile->email = $request->email;

        $oldImage = $profile->image;
        $img = $request->file('avatar');
            if($img)
                $profile->avatar = storeThumb($img);

            if ($oldImage)
                Storage::delete("/public/" . $oldImage);

        if ($profile->save()) {
            $notify = updateNotify('Profile');
        }else{
            $notify = errorNotify('Profile update');
        }

        return redirect()->back()->with($notify);
    }

    public function changedPassword(Request $request)
    {
        $this->validate($request,[
            'password' => 'required|string|min:6|confirmed',
        ]);

        $password = $request->password;

        //$user = Auth::user();
        $user = User::find(1);
        $user->password = Hash::make($password);

        if ($user->save()) {
            $notify = updateNotify('Password');
        }else{
            $notify = errorNotify('Password update');
        }

        return redirect()->back()->with($notify);
    }
}

