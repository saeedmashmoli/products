@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4 class="text-black-50">ویرایش کاربر</h4>
        </div>
        <form class="form-horizontal" action="{{ route('users.update' , ['user' => $user->id ]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('Admin.section.errors')
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="username">نام کاربری</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="نام کاربری کاربر را وارد کنید" value="{{ $user->username }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="role">سمت</label>
                    <select name="role_id" id="role_id" class="select2 form-control">
                        <option value="">انتخاب کنید</option>
                        @foreach(\App\Role::where('id','>',1)->get() as $role)
                            <option value="{{$role->id}}" {{$user->role_id == $role->id ? 'selected' : ''}}>{{$role->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="mobile">موبایل</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="موبایل کاربر را وارد کنید" value="{{ $user->mobile }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="email">ایمیل</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="ایمیل کاربر را وارد کنید" value="{{ $user->email }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="file" class="control-label">تصویر کاربر</label>
                    <input type="file" class="form-control" name="file" id="file" value="">
                </div>
            </div>
            <div class="form-group col-lg-10 float-right">
                <div class="col-lg-2 float-left">
                    <button type="submit" class="btn btn-primary float-left">ویرایش</button>
                </div>
            </div>
        </form>
    </div>
@endsection
