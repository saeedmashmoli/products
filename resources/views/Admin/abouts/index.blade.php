@extends('Admin.master')
@section('content')
    <div class="col-lg-12">
        <div class="page-header head-section">
            <h4>ارتباط با ما</h4>
        </div>
        <div class="dropdown-divider bg-dark mb-5"></div>
        <form class="form-horizontal" action="{{ route('changeAboutMe') }}" method="post">
            {{ csrf_field() }}
            @include('Admin.section.errors')
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="mobile" class="control-label">شماره تماس</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="شماره تماس را وارد کنید" value="{{ $about ? $about->mobile : old('mobile') }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="email" class="control-label">ایمیل</label>
                    <input style="direction: rtl !important;" type="text" class="form-control" name="email" id="email" placeholder="ایمیل را وارد کنید" value="{{ $about ? $about->email : old('email') }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="whatsUp" class="control-label">واتس آپ</label>
                    <input style="direction: rtl !important;" type="text" class="form-control" name="whatsUp" id="whatsUp" placeholder="آدرس واتس آپ را وارد کنید" value="{{ $about ? $about->whatsUp : old('whatsUp') }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="telegram" class="control-label">تلگرام</label>
                    <input style="direction: rtl !important;" type="text" class="form-control" name="telegram" id="telegram" placeholder="آدرس تلگرام را وارد کنید" value="{{ $about ? $about->telegram : old('telegram') }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="instagram" class="control-label">اینستاگرام</label>
                    <input style="direction: rtl !important;" type="text" class="form-control" name="instagram" id="instagram" placeholder="آدرس اینستاگرام را وارد کنید" value="{{ $about ? $about->instagram : old('instagram') }}">
                </div>
            </div>
            <div class="form-group col-12">
                <div class="col-lg-6">
                    <label for="address" class="control-label">آدرس محل فعالیت</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="آدرس را وارد کنید" value="{{ $about ? $about->address : old('address') }}">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="col-lg-10">
                    <label for="aboutUs" class="control-label">درباره ما</label>
                    <textarea rows="5" class="form-control" name="aboutUs" id="aboutUs" placeholder="متن درباره را وارد کنید">{{ $about ? $about->aboutUs : old('aboutUs') }}</textarea>
                </div>
            </div>
            <div class="form-group col-lg-10 float-right">
                <div class="col-lg-2 float-left">
                    <button type="submit" class="btn btn-success float-left">ذخیره</button>
                </div>
            </div>
        </form>
    </div>
@endsection
