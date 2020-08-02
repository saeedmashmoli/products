@extends('Admin.master')
@section('script')
    <script>
        $('#beginDateTime').MdPersianDateTimePicker({
            targetTextSelector:"#beginDateTime",
            enableTimePicker: true
        });
        $("#beginDateTime").inputmask("(n999|zmmm)/(0n|10|11|12|۰z|۱۰|۱۱|۱۲)/(0n|19|29|30|31|۰z|۱m|۲m|۳۰|۳۱) hm:mm:ss",{"placeholder":"_"});
        $('#endDateTime').MdPersianDateTimePicker({
            targetTextSelector:"#endDateTime",
            enableTimePicker: true
        });
        $("#endDateTime").inputmask("(n999|zmmm)/(0n|10|11|12|۰z|۱۰|۱۱|۱۲)/(0n|19|29|30|31|۰z|۱m|۲m|۳۰|۳۱) hm:mm:ss",{"placeholder":"_"});
    </script>
@endsection
@section('content')
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
        <div class="page-header head-section">
            <h4 class="float-right">ویدئو ها</h4>
            <div class="btn-group float-left">
                <a href="{{ route('videos.create') }}" class="btn btn-sm btn-primary">ایجاد ویدئو</a>
            </div>
        </div>
        <div class="dropdown-divider float-right w-100 bg-dark"></div>
        <div class="float-right w-100">
            <div class="w-100" style="border-radius: 5px;border: 1px solid #aaa;background: #ccc;float: right;padding: 1% 1% 0 1%;margin-bottom: 1%">
                <form action="{{route('videos.index')}}">
                    <div class="col-md-3 float-right" style="direction: ltr">
                        <div class="input-group">
                            <div class="input-group-prepend">
                             <span class="input-group-text cursor-pointer" id="beginDateTimeButton" style="direction: rtl">
                                <i class="fa fa-calendar"></i>
                             </span>
                            </div>
                            <input autocomplete="off" class="form-control" placeholder="ازتاریخ؟" name="beginDateTime" id="beginDateTime" value="{{old('beginDateTime')}}" style="direction:ltr" />
                        </div>
                    </div>
                    <div class="col-md-3 float-right" style="direction: ltr">
                        <div class="input-group">
                            <div class="input-group-prepend">
                             <span class="input-group-text cursor-pointer" id="endDateTimeButton" style="direction: rtl">
                                <i class="fa fa-calendar"></i>
                             </span>
                            </div>
                            <input autocomplete="off" class="form-control" name="endDateTime" id="endDateTime"  placeholder="تا تاریخ؟" value="{{old('endDateTime')}}" style="direction:ltr" />
                        </div>
                    </div>
                    <div  class="form-group col-md-4 col-sm-4 col-lg-4 col-xs-4 float-right">
                        <input name="title"  id="title" class="form-control" placeholder="محصول مورد نظر را وارد نمائید" autocomplete="off">
                    </div>

                    <div class="form-group  col-md-2 col-sm-2 col-lg-2 col-xs-2 float-right">
                        <button class="btn btn-dark col-md-7 col-lg-7 col-sx-7 col-xs-7" type="submit">جستجو</button>
                    </div>
                </form>
            </div>
        </div>
        @if($videos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>تاریخ آخرین تغییرات</th>
                        <th>تنظیمات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($videos as $video)
                        <tr>
                            <td>{{$row++}}</td>
                            <td>{{$video->id}}</td>
                            <td>{{$video->title}}</td>
                            <td>{{$video->isPublish == 1 ? 'منتشر شده' : 'پیش نویس'}}</td>
                            <td>{{ jdate($video->created_at) }}</td>
                            <td>{{ jdate($video->updated_at)->format('H:i:s y/m/d') }}</td>
                            <td>
                                <form action="{{ route('videos.destroy'  , ['video' => $video->slug ]) }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="btn-group btn-group-xs btn-group-xs">
                                        <a href="{{ route('videos.edit' , ['video' => $video->slug ]) }}"  class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
                                        <button title="پیش نویس/انتشار" type="submit" class="btn btn-sm {{$video->isPublish == 0 ? 'btn-danger' : 'btn-success'}}">
                                            @if($video->isPublish == 0)
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
                {!! $videos->appends(request()->all())->render() !!}
            </div>
        @else
            <div class="bg-warning p-3 float-right w-100" style="border-radius: 5px">
                <h6 class="text-danger">ویدئویی یافت نشد!!!</h6>
            </div>
        @endif
    </div>
@endsection
