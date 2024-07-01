<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class Rolcontroller extends Controller
{

function role(){
$permissions = Permission::all();
$users = User::all();
$roles = Role::all();
return view('admin.Role.role',[
'permissions'=>$permissions,
'roles'=>$roles,
'users'=>$users,
]);

}

function permission_store(Request $request){
    Permission::create([
        'name' => $request->permission_name,
    ]);
    return back();
}

function role_store(Request $request){
    $role = Role::create(['name' => $request->role_name]);
    $role->syncPermissions($request->permission);
    return back();
}

function assign_role(Request $request){
    $user = User::find($request->user_id);
    $user->assignRole($request->role_id);
    return back();
}

function remove_role($user_id){
    $user = User::find($user_id);
    $user->syncRoles([]);
    $user->syncPermissions([]);
    return back();
}

function user_role_permission($user_id){
    $users = User::find($user_id);
    $permissions = Permission::all();
    return view('admin.Role.edit_user_per',[
       'users'=>$users,
       'permissions'=>$permissions,
    ]);
}

function permission_update(Request $request){
  $user = User::find($request->user_id);
  $user->syncPermissions($request->permission);
  return back();
}

}
