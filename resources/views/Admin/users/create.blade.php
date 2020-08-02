@extends('Admin.master')
@section('content')
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="page-header head-section">
            <h4 class="text-black-50">ایجاد کاربر جدید</h4>
        </div>
        <div class="dropdown-divider bg-dark mb-3"></div>
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include('Admin.section.errors')
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="username">نام</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="نام کاربری را وارد کنید" value="{{ old('username') }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="role">سمت</label>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">انتخاب کنید</option>
                        @foreach(\App\Role::where('id','>',1)->get() as $role)
                            <option value="{{$role->id}}" {{old('role_id') == $role->id ? 'selected' : ''}}>{{$role->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="mobile">موبایل</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="موبایل کاربر را وارد کنید" value="{{ old('mobile') }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="email">ایمیل</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="ایمیل کاربر را وارد کنید" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="password">رمز عبور</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="رمز عبور کاربر را وارد کنید" value="{{ old('password') }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="file" class="control-label">تصویر کاربر</label>
                    <input type="file" class="form-control" name="file" id="file">
                </div>
            </div>
            <div class="form-group col-lg-10 float-right">
                <div class="col-lg-2 float-left">
                    <button type="submit" class="btn btn-success float-left">ذخیره</button>
                </div>
            </div>
        </form>
    </div>
@endsection
