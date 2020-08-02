@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4>ایجاد دسته</h4>
        </div>
        <form class="form-horizontal" action="{{ route('categories.store') }}" method="post">
            {{ csrf_field() }}
            @include('Admin.section.errors')
            <div class="form-group col-lg-12">
                <div class="col-lg-6">
                    <label for="title" class="control-label">عنوان دسته</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان دسته را وارد کنید" value="{{ old('title') }}">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="col-lg-6">
                    <label for="parent_id" class="control-label">دسته پدر</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">انتخاب کنید</option>
                        @foreach(\App\Category::whereStatus(1)->get() as $category)
                            <option value="{{$category->id}}" {{old('parent_id') == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="form-group col-lg-6 m-0">
                    <label for="gender">وضعیت</label>
                    <div class="col-lg-4">
                        <label class="custom-toggle">
                            <input type="radio" name="status" value="1" {{old('status') == 1 ? 'checked' : ''}}>
                            <span class="custom-toggle-slider" style="border-radius: 10% !important;"></span>
                        </label>
                        <label style="vertical-align:top; width: 30%;text-align: center">فعال</label>
                        <span class="clearfix"></span>
                    </div>
                    <div class="col-lg-4">
                        <label class="custom-toggle">
                            <input type="radio" name="status" value="0" {{old('status') == 0 ? 'checked' : ''}}>
                            <span class="custom-toggle-slider" style="border-radius: 10% !important;"></span>
                        </label>
                        <label style="vertical-align:top; width: 30%;text-align: center">غیرفعال</label>
                        <span class="clearfix"></span>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <div class="col-lg-2 float-left">
                    <button type="submit" class="btn btn-success float-left">ذخیره</button>
                </div>
            </div>
        </form>
    </div>
@endsection



