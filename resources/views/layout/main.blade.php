
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JOLT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
    </script>
    <style>
        .error{
            color: red!important;
        }
        .hide{
            display: none;
        }
        .modal-dialog {
            min-height: calc(100vh - 60px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: auto;
        }
        @media(max-width: 768px) {
            .modal-dialog {
                min-height: calc(100vh - 20px);
            }
        }
        .bg-black{
            background: black;
        }
        ul li a{
            color: white !important;
        }
    </style>

</head>
<body>
@include('layout.partials.component2')
<nav class="navbar navbar-expand-lg navbar-light bg-black bg-black">
    <a class="navbar-brand" href="https://ridejolt.co.uk/">
        <img src="https://cdn.shopify.com/s/files/1/0654/0958/1314/files/MainLogo.png?v=1659693748&width=190" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="https://ridejolt.co.uk/collections/jolt-electric-bikes">The Bikes <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="https://ridejolt.co.uk/pages/monthly-plans">Monthly Plans <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="https://ridejolt.co.uk/pages/contact">Contact <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="https://ridejolt.co.uk/blogs/news">Media <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="https://ridejolt.co.uk/pages/faq">Faq <span class="sr-only">(current)</span></a>
            </li>

            @auth()
                <li class="nav-item active">
                    <a class="nav-link" href="{{url('logout')}}">Logout</a>
                </li>
            @endauth

            @guest()

                <li class="nav-item active">
                    <a class="nav-link" href="{{url('login')}}">Login</a>
                </li>
            @endguest




        </ul>
    </div>
</nav>

<div class="container">
@yield('content')
</div>

<div class="container-fluid">
    @yield('content2')
</div>


</body>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script>
    $(document).ready(function () {
        $('#formvalidate').validate();
    });
</script>

@yield('js')

</html>
