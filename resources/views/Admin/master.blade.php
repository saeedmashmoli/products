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
    <link rel="stylesheet" href="{{asset('packageSource/plyr-master/dist/plyr.css')}}">
    <script src="{{asset('packageSource/plyr-master/dist/plyr.min.js')}}"></script>
    <script src="/packageSource/sweetalert2/sweetalert2.min.js"></script>
    <script src="/ckeditor/ckeditor.js"></script>

</head>
<body class="body">
<div id="app">
    @include('Admin.section.header')
    <main class="page-content active">
        @yield('content')
    </main>
</div>

</div>

<script src="/packageSource/jquery.js"></script>

<script>
    window.Laravel = {};
    window.Laravel.Auth = '{{ Auth::check() }}' == '' ? false : true;
    window.Laravel.csrfToken = '{{ csrf_token() }}'
</script>
<script src="/js/app.js"></script>

<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });
    function closeError() {
        $('#errors').css('display' , 'none');
    }
</script>
<script>
    Inputmask.extendDefinitions({
        'f': {
            validator: "[۰-۹\u060C-\u0638\u0639-\u0648\u06A9\u06AF\u06CC\u067E\u0686\u064A\u0649\u0626\u0698 ]",
            cardinality: 1
        },
        'n':
            {
                validator:"[1-9]",
            },
        'm':
            {
                validator:"[۰-۹]",
            },
        'z':
            {
                validator:"[۱-۹]",
            },
        'h': {
            validator: "[۰-۲]",
        },
        'i':{
            validator:"[۰-۳]",
        },
        's':{
            validator:"[۰-۵]",
        }
    });
    // $("#title").inputmask( "f{*}");
</script>
<script>
    var homeIcon = $('.page-wrapper');
    var pageContent = $('.page-content');
    $(window).ready(function() {
        if (window.innerWidth <= 600) {
            homeIcon.removeClass('toggled');
            pageContent.removeClass('active');
        }else homeIcon.addBack('toggled');
    });
    $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-dropdown").toggleClass("active");
        $(this).next(".sidebar-submenu").slideToggle(200);
    });

    $("#close-sidebar").click(function() {
        homeIcon.removeClass("toggled");
        pageContent.removeClass('active');
    });
    $("#show-sidebar").click(function() {
        homeIcon.addClass("toggled");
        pageContent.addClass('active');
    });
</script>
@yield('script')
@yield('style')
</body>
</html>
