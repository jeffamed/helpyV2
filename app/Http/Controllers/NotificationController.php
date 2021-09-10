<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $notify = Notification::orderBy('id', 'DESC')->where('notifiable_id',$user)->get();

        foreach ($notify as $key => $noti){
            $notifyToArray = array_map('intval', explode(',', $noti->notify_to));
            if(!is_null($noti->read_at)){
                unset($notify[$key]);
            }
        }  

        return $notify;
    }

    public function allNotification()
    {
        $user = Auth::user()->id;


        $notifications = Notification::orderBy('id', 'DESC')
                    ->join('users','notifications.notifiable_id','=','users.id')
                    ->join('departments', 'users.department_id', '=', 'departments.id')
                    ->select('notifications.*','users.name','departments.title as department')
                    ->where('notifiable_id', $user)
                    ->paginate();


        return view('notification.index', compact('notifications'));
    }

    public function update(Request $request, $id)
    {
        $notifcations = Notification::find($id);

        if(!in_array(Auth::user()->id,explode(',',$notifcations->read_by))  )
        {
            $notifcations->read_by = $notifcations->read_by. ',' .$request->read_by;


            $notifcations->save();

            return  response()->json(['success'=> true, 'success'=> Lang::get('lang.notification_open')]);

        }
        else{
            return  response()->json(['success'=> false, 'errors'=> 'Error']);
        }
        $notifcations->save();
    }

    public function count()
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function countUp($id)
    {
        $time = date('Y-m-d H:i:s');
        $updated = User::where('id',$id)->update(['notification_check'=>$time]);
        if ($updated) {
            return response()->json('success', 200);
        }

    }
}
