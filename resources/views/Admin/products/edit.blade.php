@extends('Admin.master')
@include('Admin.products._Files')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4>ویرایش محصول</h4>
        </div>
        <form class="form-horizontal" action="{{ route('products.update' , ['product' => $product->slug ]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('Admin.section.errors')
            <div class="form-group col-lg-12">
                <div class="col-lg-6">
                    <label for="title" class="control-label">عنوان محصول</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان محصول را وارد کنید" value="{{ $product->title }}">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="col-lg-6">
                    <label for="category_id" class="control-label">دسته محصول</label>
                    <select name="category_id[]" class="selectpicker" title='انتخاب کنید' multiple>
                        @foreach(\App\Category::whereStatus(1)->get() as $category)
                            <option value="{{$category->id}}" {{in_array($category->id,$product->categories->pluck('id')->toArray()) ? 'selected' : ''}}>{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="col-lg-10">
                    <label for="text" class="control-label">توضیحات</label>
                    <textarea rows="5" class="form-control" name="text" id="text" placeholder="توضیحات محصول را وارد کنید">{{ $product->text }}</textarea>
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-3" style="direction: ltr">
                    <label for="poster" class="control-label">پوستر</label>
                    <input type="file" class="form-control" name="file" id="posterEdit">
                </div>
            </div>
            @if($product->galleries->count() > 0)
            <div class="form-group col-lg-6">
                <div class="form-group col-lg-12 p-3 border" style="direction: ltr">
                    <label class="w-100">تصاویر محصول</label>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr >
                                @php($j=1)
                                @foreach($product->galleries as $gallery)
                                    <td id="gallery{{$gallery->id}}">
                                        <div class="btn-group btn-group-xs btn-group-xs">
                                            <img src="{{asset('files/products/'.$product->id.'/32p/'.$gallery->url)}}" style="width: 30px;height: 30px ;margin-right: 20%" />
                                            <a style="color: white" class="btn btn-sm btn-danger btn-icon" onclick="removeProductImage({{$gallery->id}})"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
            @endif
            <div class="form-group col-lg-12">
                <div class="form-group col-lg-12 p-3 border" style="direction: ltr">
                    @if($product->galleries->count() == 0)
                    <label class="w-100">تصاویر محصول</label>
                    @endif
                    <input type="file" class="form-control" name="files[]" id="files" multiple>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="form-group col-lg-6 m-0">
                    <label for="gender">وضعیت</label>
                    <div class="col-lg-4">
                        <label class="custom-toggle">
                            <input type="radio" name="status" value="1" {{$product->status == 1 ? 'checked' : ''}}>
                            <span class="custom-toggle-slider" style="border-radius: 10% !important;"></span>
                        </label>
                        <label style="vertical-align:top; width: 30%;text-align: center">فعال</label>
                        <span class="clearfix"></span>
                    </div>
                    <div class="col-lg-4">
                        <label class="custom-toggle">
                            <input type="radio" name="status" value="0" {{$product->status == 0 ? 'checked' : ''}}>
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
