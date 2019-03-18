<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Urban') }}</title>

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/data-table/buttons.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/menubar/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/customs-css.css') }}" rel="stylesheet">
    <script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
        
	</script>
</head>
<body>
    
        @include('admin/sidebar')
        @include('admin/header')
        @include('admin/body')
        
    

    
    <!-- jquery vendor -->

    
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('public/js/jquery.nanoscroller.min.js') }}"></script>
    <!-- nano scroller --> 
    <script src="{{ asset('public/js/menubar/sidebar.js') }}"></script>
    <script src="{{ asset('public/js/preloader/pace.min.js') }}"></script>
    <!-- sidebar -->
    <!-- bootstrap -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
   
    <!-- <script src="{{ asset('js/scripts.js') }}"></script> -->
    <!-- Scripts -->
   
    <!-- scripit init-->
    <script src="{{asset('public/js/data-table/datatables.min.js')}}"></script>
    <script src="{{asset('public/js/data-table/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/js/data-table/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/js/data-table/jszip.min.js')}}"></script>
    <script src="{{asset('public/js/data-table/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/js/data-table/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/js/data-table/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/js/data-table/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/js/data-table/datatables-init.js')}}"></script>
    
     
    <script type="text/javascript">
        $(document).ready(function(){
            $('.header li, .sidebar li').on('click', function() {
                $(".header li.active, .sidebar li.active").removeClass("active");
                $(this).addClass('active');
            });

            $(".header li").on("click", function(event) {
                event.stopPropagation();
            });

            $(document).on("click", function() {
                $(".header li").removeClass("active");

            });                                                 
        })

        $('.page-refresh').on("click", function() {
            location.reload();
        });
    </script>

    @yield('script')
</body>
</html>
