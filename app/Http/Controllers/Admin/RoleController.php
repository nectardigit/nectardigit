<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $role;
    public function __construct(Role $role)
    {
        $this->middleware(['role:Super Admin|Admin']);
        $this->middleware(['role:Super Admin|Admin']);
        $this->middleware(['role:Super Admin|Admin']);
        $this->middleware(['role:Super Admin|Admin']);
        $this->role=$role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = request()->user()->roles->first()->name;
        $this->role = $this->role->orderBy('id', 'ASC')->paginate();

        if($userRole == 'Admin'){
        $this->role = Role::where('name','!=','Super Admin')->orderBy('id','ASC')->paginate();
        }
        return view('admin.roles.role-list')->with('data',$this->role);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('admin.roles.role-form',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'nullable',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        //$status=$role->syncPermissions($request->input('permission'));
        if($role){
            $role->syncPermissions($request->input('permission'));
            $request->session()->flash('success',"User Role Created Successfully");
        }else{
            $request->session()->flash('error',"Sorry! Error While Adding the new User Role");
        }
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->role = $this->role->find($id);
        if(!$this->role){
            request()->session()->flash('error','Error ! Role Not Found');
            return redirect()->back();
        }
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.role-form',compact('permission','rolePermissions'))->with('role_data',$this->role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'sometimes',
        ]);
        $this->role = $this->role->find($id);
        $this->role->name = ($this->role->name=='Super Admin')?$this->role->name:$request->name;
        $status=$this->role->save();
        if($status){
            $this->role->syncPermissions($request->input('permission'));
            $request->session()->flash('success',"User Role Updated Successfully");
        }else{
            $request->session()->flash('error',"Sorry! Error While Updating the new User Role");
        }
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
