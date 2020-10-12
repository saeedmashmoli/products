<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title >{{config('app.name')}}</title>
        <link rel="icon" type="image/png" href="{{asset('cnc-favicon.png')}}">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <script src="{{asset('packageSource/sweetalert2/sweetalert2.min.js')}}"></script>
    </head>
    <body>
        <div id="app">
            <my-header></my-header>
                <div class="row" style="margin: 0 1% 1% 1%">
                    <router-view></router-view>
                </div>
                <hr>
            <my-footer></my-footer>
        </div>

        <script>
            window.Laravel = {};
            window.Laravel.authUser = '{!! json_encode(auth()->user()) !!}';
            window.Laravel.projectName = '{{env('APP_NAME')}}'
        </script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
