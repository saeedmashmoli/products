@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4>ویرایش دسته</h4>
        </div>
        <form class="form-horizontal" action="{{ route('categories.update' , ['category' => $category->id ]) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('Admin.section.errors')
            <div class="form-group col-lg-12">
                <div class="col-lg-6">
                    <label for="title" class="control-label">عنوان دسته</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان دسته را وارد کنید" value="{{ $category->title }}">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="col-lg-6">
                    <label for="parent_id" class="control-label">دسته پدر</label>
                    <select name="parent_id" id="parent_id" class="form-control selectpicker">
                        <option value="">انتخاب کنید</option>
                        @foreach(\App\Category::whereStatus(1)->get() as $parent)
                            <option value="{{$parent->id}}" {{$category->parent_id == $parent->id ? 'selected' : ''}}>{{$parent->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="form-group col-lg-6 m-0">
                    <label for="gender">وضعیت</label>
                    <div class="col-lg-4">
                        <label class="custom-toggle">
                            <input type="radio" name="status" value="1" {{$category->status == 1 ? 'checked' : ''}}>
                            <span class="custom-toggle-slider" style="border-radius: 10% !important;"></span>
                        </label>
                        <label style="vertical-align:top; width: 30%;text-align: center">فعال</label>
                        <span class="clearfix"></span>
                    </div>
                    <div class="col-lg-4">
                        <label class="custom-toggle">
                            <input type="radio" name="status" value="0" {{$category->status == 0 ? 'checked' : ''}}>
                            <span class="custom-toggle-slider" style="border-radius: 10% !important;"></span>
                        </label>
                        <label style="vertical-align:top; width: 30%;text-align: center">غیرفعال</label>
                        <span class="clearfix"></span>
                    </div>
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
