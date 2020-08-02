@extends('Admin.master')
@section('content')
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
        <div class="page-header head-section">
            <h4 class="float-right">سمت ها</h4>
            <div class="btn-group btn-group-sm float-left">
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-danger">سمت  جدید</a>
                <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-info">دسترسی ها</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> شرح دسترسی</th>
                    <th>توضیحات</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->title }}</td>
                        <td>{{ $role->label }}</td>
                        <td>
                            <form action="{{ route('roles.destroy'  , ['role' => $role->id ]) }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="btn-group btn-group-sm btn-group-lg">
                                    <a href="{{ route('roles.edit' , ['role' => $role->id ]) }}"  class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center">
            {!! $roles->render() !!}
        </div>
    </div>
@endsection
