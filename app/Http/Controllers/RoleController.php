<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::where('name','!=','Customer')->where('name','!=','Service Provider')->latest()->get();
        return view('backend.role.index',compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('backend.role.create',compact('permission'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);


        $role = Role::create(['name' => $request->input('name')]);
        //$role = Role::create(['id' => $request->input('id')]);
        $role->syncPermissions($request->input('permission'));
//dd($role);

        Toastr::success('Role Created Successfully');
        return redirect()->route('roles.index');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
        //dd($rolePermissions);


        return view('backend.role.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();


        return view('backend.role.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
//            'permission' => 'required',
        ]);


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();


        $role->syncPermissions($request->input('permission'));


        Toastr::success('Role Updated Successfully');
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        Toastr::success('Role Deleted Successfully');
        return redirect()->route('roles.index');
    }

    public function create_permission(Request $request)
    {
        /*$this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->input('name')]);*/

        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
            'controller_name' => 'required',
        ]);

        Permission::create(['controller_name' => $request->input('controller_name'),'name' => $request->input('name')]);

        Toastr::success('Role List Created Successfully');
        return redirect()->route('roles.create');
    }
}
