<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 0;
        $count = 6;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $users = User::where('id','>',1)->filter()->with('role')->skip($row)->paginate($count);

        return view('Admin.users.index',compact('users','row'));
    }

    public function create()
    {
        return view('Admin.users.create');
    }
    public function store(UserRequest $request)
    {
        $request->merge([
            'password' => bcrypt($request->input('password')),
        ]);
        $user = User::create($request->all());
        if ($request->file('file')){
            $result = $this->saveFile($request,$user->id,'users','image');
            $user->picUrl = $result['path'];
            $user->save();
        }
        return redirect(route('users.index'));
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        if ($user->id > 1)
            return view('Admin.users.edit',compact('user'));
        else
            return view('errors.404');
    }

    public function update(UserRequest $request, User $user)
    {
        if ($user->username != $request->username)
            $request->validate(['username' => 'unique:users']);
        if ($user->mobile != $request->mobile)
            $request->validate(['mobile' => 'unique:users']);
        $user->update($request->all());
        if ($request->file('file')){
            unlink(public_path($user->picUrl));
            $result = $this->saveFile($request,$user->id,'users');
            $user->picUrl = $result['path'];
            $user->save();
        }
        return redirect(route('users.index'));
    }

    public function destroy(User $user)
    {
        if ($user->status == 0){
            $user->status = 1;
        }else{
            $user->status = 0;
        }
        $user->save();
        return back();
    }
}
