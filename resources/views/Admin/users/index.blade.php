@extends('Admin.master')
@section('content')
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
        <div class="page-header">
            <h4 class="float-right">کاربران</h4>
            <div class="btn-group btn-group-sm float-left">
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">ایجاد کاربر</a>
            </div>
        </div>
        <div class="dropdown-divider float-right w-100 bg-dark"></div>
        <div class="float-right w-100">
            <div class="w-100" style="border-radius: 5px;border: 1px solid #aaa;background: #ccc;float: right;padding: 1% 1% 0 1%;margin-bottom: 1%">
                <form action="{{route('users.index')}}">
                    <div  class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6 float-right">
                        <input name="fullname"  id="fullname" class="form-control" placeholder="نام کاربر را وارد نمائید" autocomplete="off">
                    </div>
                    <div class="form-group  col-lg-2 float-right">
                        <button class="btn btn-dark col-md-7 col-lg-7 col-sx-7 col-xs-7" type="submit">جستجو</button>
                    </div>
                </form>
            </div>
        </div>
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>شناسه کاربری</th>
                        <th>نام کاربری</th>
                        <th>سمت</th>
                        <th>موبایل</th>
                        <th>تنظیمات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$row++}}</td>
                            <td>{{$user->id}}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role->title }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>
                                <form action="{{ route('users.destroy'  , ['user' => $user->id ]) }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="btn-group btn-group-sm btn-group-lg">
                                        <a href="{{ route('users.edit' , ['user' => $user->id ]) }}"  class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
                                        <button title="فعال/غیرفعال" type="submit" class="btn btn-sm {{$user->status == 0 ? 'btn-danger' : 'btn-success'}}">
                                            @if($user->status == 0)
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
                {!! $users->appends(request()->all())->render() !!}
            </div>
        @else
            <div class="bg-warning p-3 float-right w-100" style="border-radius: 5px">
                <h6 class="text-danger mb-0">کاربری یافت نشد!!!</h6>
            </div>
        @endif
    </div>
@endsection
