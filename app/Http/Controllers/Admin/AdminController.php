<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function contactMessage()
    {
    	$messages = Contact::latest()->paginate(15);

    	return view('inbox.index', compact('messages'));
    }

    public function readMessage(Contact $contact)
    {
    	if ($contact->status == 0) {
    		Contact::where('id', $contact->id)->update(['status' => 1]);
    	}

    	return view('inbox.view', compact('contact'));
    }

    public function destroy($id)
    {
    	$message = Contact::find($id);
    	$done = $message->delete();
    	
        if ($done) {
            $notify = deleteNotify('Contact message');
        }else{
            $notify = errorNotify('Contact message');
        }

    	return redirect()->back()->with($notify);
    }

    public function createUser()
    {
        return view('users.create');
    }

    public function saveUser(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'status' => 'required',
        ]);

        $saved = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        if ($saved) {
            $notify = storeNotify('User');
        }else{
            $notify = errorNotify('User add');
        }

        return redirect()->back()->with($notify);
    }

    public function userEdit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'status' => 'required',
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $status = $request->status;

        $user = User::find($id);

        if ($user->email == $email){
            $user->name = $name;
            $user->password = Hash::make($password);
            $user->status = $status;
        } else {
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->status = $status;
        }

        if ($user->save()) {
            $notify = updateNotify('User info');
        }else{
            $notify = errorNotify('User info update');
        }

        return redirect()->back()->with($notify);
    }
}
