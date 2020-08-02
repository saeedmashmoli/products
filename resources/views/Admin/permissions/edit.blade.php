@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4>ویرایش دسترسی</h4>
        </div>
        <form class="form-horizontal" action="{{ route('permissions.update' , ['permission' => $permission->id ]) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('Admin.section.errors')
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="title" class="control-label">عنوان دسترسی</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان را وارد کنید"
                           value="{{ $permission->title }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="label" class="control-label">توضیحات کوتاه</label>
                    <textarea rows="5" class="form-control" name="label" id="label" placeholder="توضیحات را وارد کنید">{{ $permission->label }}</textarea>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-2 float-left">
                    <button type="submit" class="btn btn-primary float-left">ویرایش</button>
                </div>
            </div>
        </form>
    </div>
@endsection
