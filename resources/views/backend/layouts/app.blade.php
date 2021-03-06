<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'Laravel 5 Boilerplate')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(mix('css/backend.css')) }}

    <link rel="stylesheet" href="/js/bootstrap-select-1.13.7/dist/css/bootstrap-select.min.css">


    <link rel="stylesheet" href="/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/css/datatables.bootstrap.css">
    <link rel="stylesheet" href="/js/chosen/chosen.css">
    @stack('styles')
    @stack('after-styles')
</head>

<body class="{{ config('backend.body_classes') }}">
    @include('backend.includes.header')

    <div class="app-body">
        @include('backend.includes.sidebar')

        <main class="main">
            @include('includes.partials.logged-in-as')
            {!! Breadcrumbs::render() !!}

            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="content-header">
                        @yield('page-header')
                    </div><!--content-header-->

                    @include('includes.partials.messages')
                    @yield('content')
                </div><!--animated-->
            </div><!--container-fluid-->
        </main><!--main-->

        @include('backend.includes.aside')
    </div><!--app-body-->

    @include('backend.includes.footer')

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/backend.js')) !!}

    <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap-select-1.13.7/dist/js/bootstrap-select.min.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/handlebars.min.js"></script>
    <script src="/js/bootbox.all.min.js"></script>
    <script src="/js/chosen/chosen.jquery.min.js"></script>

    @stack('after-scripts')

    <script type="text/javascript">
        jQuery(document).ready(function(){
            function refreshToken(){
                $.get('{{route('admin.refreshcsrf')}}').done(function(data){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': data
                        }
                    });
                });
            }
            setInterval(refreshToken, 5000);//1 hour
            refreshToken();
            $(".chosen-select").chosen();
        });
    </script>
    @stack('scripts')
</body>
</html>
