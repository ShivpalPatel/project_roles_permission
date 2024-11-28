<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller  implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('permission:view roles', only:['index']),
            new Middleware('permission:update roles', only:['edit']),
            new Middleware('permission:create roles', only:['create']),
            new Middleware('permission:delete roles', only:['destroy']),
        ];
    }
    //this method will show roles page
    public function index(){
      $roles = Role::orderBy('name','ASC')->paginate(10);
        return view('roles.list',['roles'=>$roles]);
    }
    // this method will show create role page
    public function create(){
       $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.create',['permissions'=>$permissions]);
    }
    //create/insert role in db
    public function store(Request $request){
       $validator = Validator::make($request->all(),
            ['name'=>'required|unique:roles|min:3']);

        if($validator->passes()){
            //dd($request->permission);
           $role =  Role::create(['name'=>$request->name]);
            if(!empty($request->permission)){
                foreach($request->permission as $name){
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with('success','Role added successfully.');
        } else{
            return redirect()->route('roles.index')->withInput()->withErrors($validator);
        }
    }
    //baad m
    public function show($id){

    }

    public function edit($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::orderBy('name','ASC')->get();
        $hasPermissions = $role->permissions->pluck('name');
        // dd($hasPermissions);
        return view('roles.edit',
              ['role'=> $role,'permissions'=>$permissions,
              'hasPermissions'=>$hasPermissions]);

    }
    public function update(Request $request, $id){
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(),
        ['name'=>'required|unique:roles,name,'.$id]);

    if($validator->passes()){

       $role->name = $request->name;
       $role->save();

        if(!empty($request->permission)){
         $role->syncPermissions($request->permission);

        }else{
            $role->syncPermissions([]);
        }
         return redirect()->route('roles.index')->with('success','Role Updaated successfully.');
    } else{
        return redirect()->route('roles.edit',$id)->withInput()->withErrors($validator);
    }
    }
    public function destroy($id){
        $role = Role::findOrFail( $id);
        if($role){
            $role->delete();
            return redirect()->route('roles.index')->with('success','Role deleted successfully');
        }else{
            return redirect()->route('roles.index')->with('error','Failed! ,Role not Found ');
        }
    }

}
