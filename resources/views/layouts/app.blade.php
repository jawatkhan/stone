<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title id="title"></title>

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    
    <link href="{{ asset('public/fonts/solaimanLipi/font.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/data-table/buttons.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/menubar/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/customs-css.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!--  <link rel="stylesheet" href="{{asset('public/css/multiple-select.css')}}" /> -->

   @yield('style')
    <script type="text/javascript">
            $(window).on('load',function(){
                $.get('{!!URL::to('/organization_load')!!}', function(data){
                    //console.log(data);
                    $('#title').html(data.org_name);
                    $('#app_name').html(data.org_name);
                    var images = '{!!URL::to('/storage/app/public/images/')!!}'+'/'+ data.logo;
                    $('#imglogo').attr('src',images);
                })
            });
        </script>
</head>
<body>
    
        @include('layouts/sidebar')
        @include('layouts/header')
        @include('layouts/body')
        
    


    <!-- jquery vendor -->
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.nanoscroller.min.js') }}"></script>
    <!-- nano scroller --> 
    <script src="{{ asset('public/js/menubar/sidebar.js') }}"></script>
    <script src="{{ asset('public/js/preloader/pace.min.js') }}"></script>
    <!-- sidebar -->
    <!-- bootstrap -->
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="{{ asset('js/scripts.js') }}"></script> -->
    <!-- Scripts -->
   
    <script src="{{ asset('public/js/bootbox.min.js') }}"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
      $( function() {
        $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
      } );
    </script>
    
    
    @yield('script')
</body>
</html>
