@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4>ایجاد دسترسی</h4>
        </div>
        <form class="form-horizontal" action="{{ route('permissions.store') }}" method="post">
            {{ csrf_field() }}
            @include('Admin.section.errors')
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="title" class="control-label">عنوان دسترسی</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان را وارد کنید" value="{{ old('title') }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="label" class="control-label">توضیحات کوتاه</label>
                    <textarea rows="5" class="form-control" name="label" id="label" placeholder="توضیحات را وارد کنید">{{ old('label') }}</textarea>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-2 float-left">
                    <button type="submit" class="btn btn-success">ذخیره</button>
                </div>
            </div>
        </form>
    </div>
@endsection
