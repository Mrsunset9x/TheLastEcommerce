<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{  csrf_token()}}">
    <title>Clothes Shop</title>
    <link href=" {{ mix('css/app.css') }}" rel="stylesheet">
          <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
   <link href="{{ asset('css/jquery-ui.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="{{ asset('css/font-awesome.min.css')}}" rel="stylesheet">
{{--  <link href="{{ asset('css/elegant-icons.css')}}" rel="stylesheet">--}}
  <link href="{{ asset('css/nice-select.css')}}" rel="stylesheet">
  <link href="{{ asset('css/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{ asset('css/slicknav.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <!--===============================================================================================-->
<body>
    <div id="app">
        <app></app>
    </div>

{{--    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>--}}
    <script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>

    <script src="{{ mix('js/bootstrap.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

{{--    <!--===============================================================================================-->--}}
   <!-- Mainly scripts -->
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.js')}}"></script>

</body>
</html>
