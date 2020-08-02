@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4>ویرایش سمت</h4>
        </div>

        <form class="form-horizontal" action="{{ route('roles.update' , ['role' => $role->id ]) }}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('Admin.section.errors')
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="title" class="control-label">عنوان سمت</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان را وارد کنید"
                           value="{{ $role->title }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="permission_id" class="control-label">دسترسی ها</label>
                    <select class="form-control selectpicker" name="permission_id[]" id="permission_id" title='انتخاب کنید' multiple>
                        @foreach(\App\Permission::all() as $permission)
                            <option value="{{ $permission->id }}"
                                {{ in_array(trim($permission->id) ,$role->permissions->pluck('id')->toArray()) ? 'selected' : ''  }}>
                                {{ $permission->title }} - {{ $permission->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="label" class="control-label">توضیحات کوتاه</label>
                    <textarea rows="5" class="form-control" name="label" id="label" placeholder="توضیحات را وارد کنید">{{ $role->label  }}</textarea>
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
