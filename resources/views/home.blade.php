<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title >{{config('app.name')}}</title>
        <link rel="icon" type="image/png" href="{{asset('cnc-favicon.png')}}">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <script src="/packageSource/sweetalert2/sweetalert2.min.js"></script>
    </head>
    <body>
        <div id="app">
            <my-header></my-header>
                <div class="row" style="margin: 0 1% 1% 1%">
                    <!-- Blog Entries Column -->
                    <router-view></router-view>
                    <!-- Blog Sidebar Widgets Column -->
                </div>
                <!-- /.row -->
                <hr>
                <!-- Footer -->
            <my-footer></my-footer>
        </div>

        <script>
            window.Laravel = {};
            window.Laravel.authUser = '{!! json_encode(auth()->user()) !!}';
            window.Laravel.csrfToken = '{{ csrf_token() }}';
            window.Laravel.projectName = '{{env('APP_NAME')}}'
        </script>
        <script src="/js/app.js"></script>
    </body>
</html>
