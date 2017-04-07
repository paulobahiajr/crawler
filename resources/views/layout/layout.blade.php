<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/style.css')}}">
    <title>Desafio Negócios</title>

</head>
<body style="margin:0px">
<div class="container">
    <div class="content">
        @yield('content')
    </div>
</div>

<script type="text/javascript" src="{{url('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/bootstrap.min.js')}}"></script>

@yield('scripts')
</body>
</html>
