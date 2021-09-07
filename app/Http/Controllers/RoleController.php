<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id','desc')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $title = $request->input('title');
        $permissions = $request->input('permissions');
        $serializePermission ='';
        if ($permissions == null){
            $serializePermission = 'a:1:{i:0;s:15:"can_manage_null";}';
        }else{
            $serializePermission = serialize($permissions);
        }

        $created_by = Auth::user()->id;

        $role = new Role(
            [
                'title' => $title,
                'permissions' => $serializePermission,
                'created_by' => $created_by
            ]
        );

        if ($role->save()) {
            $notify = storeNotify('Role permission');
        }else{
            $notify = errorNotify('Role permission update');
        }

        return redirect()->route('roles.index')->with($notify);
    }

    public function editPermission($id)
    {
        $data = Role::find($id);
        $permissions = unserialize($data->permissions);
        $data->permissions = $permissions;

        $role = Role::select('title','permissions')->where('id', $id)->first();

        return view('roles.edit', compact('role','data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $title = $request->input('title');
        $permissions = serialize($request->input('permissions'));

        $role = Role::findOrFail($id);

        if ($role) {
            $role->title = $title;
            $role->permissions = $permissions;

            $role->save();

            $notify = updateNotify('Role');
        
            return redirect()->back()->with($notify);

        } else {

            $notify = errorNotify('Role update');

            return redirect()->back()->with($notify);
        }
    }

    public function delete($id)
    {
        $role = Role::find($id);

        $user = User::where('role_id', $role->id)->count();

        if ($user == 0) {
            $role->delete();
            $notify = deleteNotify('Role');
        }else{
            $notify = errorNotify("This role is used, you can't delete this!");
        }

        return redirect()->back()->with($notify);
    }
}
