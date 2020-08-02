<?php

namespace App\Http\Controllers\Admin;

use App\About;
use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('Admin.permissions.index',compact('permissions'));
    }

    public function create()
    {
        return view('Admin.permissions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request , [
            'title' => 'required',
            'label' => 'required'
        ]);
        Permission::create($request->all());
        return redirect(route('permissions.index'));
    }

    public function show(Permission $permission)
    {
        //
    }

    public function edit(Permission $permission)
    {
        return view('Admin.permissions.edit',compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->validate($request , [
            'title' => 'required',
            'label' => 'required'
        ]);
        $permission->update($request->all());
        return redirect(route('permissions.index'));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back();
    }
    public function about(){
        $about = About::first();
        return view('Admin.abouts.index',compact('about'));
    }
    public function changeAboutMe(Request $request){
        $about = About::first();
        if ( !$about){
            About::create($request->all());
        }else{
            $about->update($request->all());
        }

        return redirect(route('aboutMe'));
    }




}
