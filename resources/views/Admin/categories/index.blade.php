@extends('Admin.master')
@section('content')
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
        <div class="page-header head-section">
            <h4 class="float-right">دسته ها</h4>
            <div class="btn-group float-left">
                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">ایجاد دسته</a>
            </div>
        </div>
        <div class="dropdown-divider float-right w-100 bg-dark"></div>
        <div class="float-right w-100">
            <div class="w-100" style="border-radius: 5px;border: 1px solid #aaa;background: #ccc;float: right;padding: 1% 1% 0 1%;margin-bottom: 1%">
                <form action="{{route('categories.index')}}">
                    <div  class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6 float-right">
                        <input name="title"  id="title" class="form-control" placeholder="دسته مورد نظر را وارد نمائید" autocomplete="off">
                    </div>
                    <div class="form-group  col-md-2 col-sm-2 col-lg-2 col-xs-2 float-right">
                        <button class="btn btn-dark col-md-7 col-lg-7 col-sx-7 col-xs-7" type="submit">جستجو</button>
                    </div>
                </form>
            </div>
        </div>
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان دسته</th>
                        <th>دسته پدر</th>
                        <th>وضعیت دسته</th>
                        <th>تاریخ آخرین تغییرات</th>
                        <th>تنظیمات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$row++}}</td>
                            <td>{{$category->title}}</td>
                            <td>{{ $category->parent_id != null ? $category->category->title : '-' }}</td>
                            <td>{{$category->status == 1 ? 'فعال' : 'غیرفعال'}}</td>
                            <td>{{ jdate($category->updated_at)->format('H:i:s y/m/d') }}</td>
                            <td>
                                <form action="{{ route('categories.destroy'  , ['category' => $category->id ]) }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="btn-group btn-group-sm btn-group-lg">
                                        <a href="{{ route('categories.edit' , ['category' => $category->id ]) }}"  class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
                                        <button title="فعال/غیرفعال" type="submit" class="btn btn-sm {{$category->status == 0 ? 'btn-danger' : 'btn-success'}}">
                                            @if($category->status == 0)
                                                <i class="fa fa-exclamation-triangle"></i>
                                            @else
                                                <i class="fa fa-check-square"></i>
                                            @endif
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! $categories->appends(request()->all())->render() !!}
            </div>
        @else
            <div class="bg-warning p-3 float-right w-100" style="border-radius: 5px">
                <h6 class="text-danger">دسته ای یافت نشد!!!</h6>
            </div>
        @endif
    </div>
@endsection
