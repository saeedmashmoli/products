<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('id',[1])->paginate(10);
        return view('Admin.roles.index',compact('roles'));
    }

    public function create()
    {
        return view('Admin.roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request , [
            'title' => 'required',
            'label' => 'required'
        ]);
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permission_id'));
        return redirect(route('roles.index'));
    }

    public function show(Role $role)
    {
        //
    }
    public function edit(Role $role)
    {

        $role = Role::whereId($role->id)->with('permissions')->first();
        return view('Admin.roles.edit',compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request , [
            'title' => 'required',
            'label' => 'required'
        ]);
        $role->update($request->all());
        $role->permissions()->sync($request->input('permission_id'));
        return redirect(route('roles.index'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back();
    }
}
