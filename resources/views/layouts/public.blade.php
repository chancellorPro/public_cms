<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('pageTitle')</title>

        <link href="{{ asset("app/css/vendor.css") }}" rel="stylesheet">
        <link href="{{ asset("app/css/main.css") }}" rel="stylesheet">

        @stack('stylesheets')

    </head>

    @php
        $moduleName = '';
        $pathParts = explode('/', Route::getCurrentRoute()->uri());
        if (!empty($pathParts[0])) {
            $moduleName = $pathParts[0];
        }
    @endphp
    <body class="nav-sm{{ !empty($moduleName) ? ' module-' . $moduleName : '' }}">
        <div class="container body">
            <div class="header_wrapper">
                <div class="icon public-head"></div>
            </div>

            <div class="main_container">
                @include('includes/public/sidebar')

                @yield('main_container')

            </div>
        </div>

        <div class="x_panel">
            <div class="col-sm-1 col-sm-offset-5">
                <a class="pull-right" href="/admin">Admin panel</a>
            </div>
        </div>

        @stack('globals')
        <script>
            var CSRF_TOKEN = '{{ csrf_token() }}';
        </script>
        <script src="{{ asset("app/js/vendor.js") }}"></script>
        <script src="{{ asset("app/js/main.js") }}"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
        </script>

        @stack('scripts')

        @include('includes/notify')
    </body>
</html>
