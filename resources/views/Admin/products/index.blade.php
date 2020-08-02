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
            <h4 class="float-right">محصولات</h4>
            <div class="btn-group float-left">
                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">ایجاد محصول</a>
            </div>
        </div>
        <div class="dropdown-divider float-right w-100 bg-dark"></div>
        <div class="float-right w-100">
            <div class="w-100" style="border-radius: 5px;border: 1px solid #aaa;background: #ccc;float: right;padding: 1% 1% 0 1%;margin-bottom: 1%">
                <form action="{{route('products.index')}}">
                    <div class="col-md-3 float-right" style="direction: ltr">
                        <div class="input-group">
                            <div class="input-group-prepend">
                         <span class="input-group-text cursor-pointer" id="beginDateTimeButton" style="direction: rtl">
                            <i class="fa fa-calendar"></i>
                         </span>
                            </div>
                            <input autocomplete="off" class="form-control" placeholder="ازتاریخ؟" name="beginDateTime" id="beginDateTime" value="{{request('beginDateTime')}}" style="direction:ltr" />
                        </div>
                    </div>
                    <div class="col-md-3 float-right" style="direction: ltr">
                        <div class="input-group">
                            <div class="input-group-prepend">
                         <span class="input-group-text cursor-pointer" id="endDateTimeButton" style="direction: rtl">
                            <i class="fa fa-calendar"></i>
                         </span>
                            </div>
                            <input autocomplete="off" class="form-control" name="endDateTime" id="endDateTime"  placeholder="تا تاریخ؟" value="{{request('endDateTime')}}" style="direction:ltr" />
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
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>شناسه محصول</th>
                        <th>عنوان</th>
                        <th>دسته ها</th>
                        <th>وضعیت</th>
                        <th>تاریخ آخرین تغییرات</th>
                        <th>تنظیمات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$row++}}</td>
                            <td>{{$product->id}}</td>
                            <td>{{$product->title}}</td>
                            <td>
                                @foreach($product->categories as $category)
                                    {{ $category->title}} <br>
                                @endforeach
                            </td>
                            <td>{{$product->status == 1 ? 'فعال' : 'غیرفعال'}}</td>
                            <td>{{ jdate($product->updated_at)->format('H:i:s y/m/d') }}</td>
                            <td>
                                <form action="{{ route('products.destroy'  , ['product' => $product->slug ]) }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="btn-group btn-group-sm btn-group-lg">
                                        <a href="{{ route('products.edit' , ['product' => $product->slug ]) }}"  class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
                                        <button title="فعال/غیرفعال" type="submit" class="btn btn-sm {{$product->status == 0 ? 'btn-danger' : 'btn-success'}}">
                                            @if($product->status == 0)
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
                {!! $products->appends(request()->all())->render() !!}
            </div>
        @else
            <div class="bg-warning p-3 float-right w-100" style="border-radius: 5px">
                <h6 class="text-danger">محصولی یافت نشد!!!</h6>
            </div>
        @endif
    </div>
@endsection
