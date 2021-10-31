<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ciesto - @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/jquery.dataTables.min.css')}}">

    <script src="{{asset('public/assets/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('public/assets/popper.min.js')}}"></script>
    <script src="{{asset('public/assets/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/assets/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/assets/dataTables.bootstrap4.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="#">Ciesto</a>

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{url('shop')}}">Shop</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('product')}}">Product</a>
        </li>
    </ul>
</nav>


@yield('content')


<?php
if (!empty(Session::get('response')) &&  !empty(Session::get('msg')) ){
$response = Session::get('response');
$alt_msg = Session::get('msg');
?>
<script type="text/javascript">
    $(function () {
        <?php if($response !="success"){?>
        <?php }else{ ?>
        Swal.fire(
            '',
            '{{$alt_msg}}',
            'success'
        );
        <?php } ?>
    });
</script>
<?php } ?>

</body>
</html>
