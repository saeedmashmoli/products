<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title >{{config('app.name')}}</title>
    <link rel="icon" type="image/png" href="{{asset('cnc-favicon.png')}}">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
    <body class="body">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">فرم ورود</h5>
                            <form class="form-signin" action="{{route('checkLogin')}}" method="post">
                                @csrf
                                <div class="form-label-group">
                                    <input type="text" id="username" name="username" class="form-control" placeholder="نام کاربری" required autofocus>
                                    <label for="username">نام کاربری</label>
                                </div>

                                <div class="form-label-group">
                                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                                    <label for="inputPassword">رمز عبور</label>
                                </div>

                                <div class="custom-control mb-3">
                                    <a href="" style="cursor: pointer">فراموشی رمز عبور</a>
                                </div>
                                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">ورود</button>
                                <hr class="my-4">
{{--                                <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Sign in with Google</button>--}}
{{--                                <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook</button>--}}
                            </form>
                            @include('Admin.section.errors')
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </body>
</html>
