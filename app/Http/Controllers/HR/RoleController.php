<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\RoleHasPermission;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use DB;

class RoleController extends Controller
{
    public function role()
    {
        if(Auth::user()->role_id == 1){
            $roles = Role::where('id','>',1)->orderBy('role','ASC')->get();
        }else{
            $roles = Role::where('id','>',2)->orderBy('role','ASC')->get();
        }
        $data = compact('roles');
        return view('hr.role')->with($data);
    }
    public function permission()
    {
        $title = 'Permission';
        $t1 = 'Permission List';
        $t2 = 'Add Permission';
        $form = ['permissions'];
        $head = ['Sl. No.', 'Permissions'];
        $btn['name'] = 'Add Permissions';
        $btn['action'] = Route('hr.insert-permission');
        $edit['data'] = null;
        $edit['url'] = null;
        $response = Permission::orderBy('permissions', 'ASC')->get();
        $table = "permissions";
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('hr.master-from')->with($data);
    }
    public function permission_assign($role_id)
    {
        $role_id = ed($role_id, false);
        $role = Role::find($role_id);
        Cache::forget('role_permissions_' . $role_id);
        $permission =  Permission::orderBy('permissions', 'ASC')->get();
        $PermissionOfRole = RoleHasPermission::where('role_id', $role_id)->pluck('permission_id');
        $data = compact('role','PermissionOfRole','permission');
        // dd($data);
        return view('hr.permission-assign', $data);
    }
    public function asign_permission(Request $request)
    {
        $check = RoleHasPermission::where('permission_id',$request->permission)->where('role_id',$request->role)->first();
        if($check){
            RoleHasPermission::where('permission_id',$request->permission)->where('role_id',$request->role)->delete();
            return 0;
        }else{
            RoleHasPermission::create([
                'permission_id' => $request->permission,
                'role_id' => $request->role
            ]);
            return 1;
        }
    }
    public function insert_role(Request $request)
    {
        $request->validate([
            'role' => 'required|max:100',
        ]);

        $data = new Role();
        $data->role = strtoupper($request->role);
        if($data->save()){
            return redirect()->route('hr.role')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('hr.role')->with('error', 'Something wrong try again!');
        }
    }
    public function insert_permission(Request $request)
    {
        $request->validate([
            'permissions' => 'required|max:100',
        ]);

        $data = new Permission();
        $data->permissions = strtoupper($request->permissions);
        if($data->save()){
            DB::table('role_has_permissions')->insert([
                'permission_id' => $data->id,
                'role_id' => 1
            ]);
            return redirect()->route('hr.permission')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('hr.permission')->with('error', 'Something wrong try again!');
        }
    }
}
