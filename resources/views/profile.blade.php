@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4 class="text-black-50">ویرایش اطلاعات</h4>
        </div>
        <div class="dropdown-divider bg-dark mb-5"></div>
        <form autocomplete="off" class="form-horizontal" action="{{ route('profile.update') }}" method="post">
            {{ csrf_field() }}
            @include('Admin.section.errors')
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="username">نام کاربری</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="نام کاربری؟" value="{{ $user->username }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="mobile">موبایل</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="موبایل؟" value="{{ $user->mobile }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="email">ایمیل</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="ایمیل؟" value="{{ $user->email }}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="file" class="control-label">تصویر</label>
                    <input type="file" class="form-control" name="file" id="file" value="{{asset('users/'.$user->picurl)}}">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="password">رمز عبور</label>
                    <input autocapitalize="off" onautocomplete="off" autocomplete="off" type="password" class="form-control" name="password" id="password" placeholder="رمز عبور؟" value="">
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-12">
                    <label for="confirmPassword">تایید رمز عبور</label>
                    <input autocomplete="nope" type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="تایید رمز عبور؟" value="">
                </div>
            </div>
            <div class="form-group col-lg-12 float-right">
                <div class="col-lg-2 float-left">
                    <button type="submit" class="btn btn-primary float-left">ویرایش</button>
                </div>
            </div>
        </form>
    </div>
@endsection

