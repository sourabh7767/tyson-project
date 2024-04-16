<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <meta name="_token" content="0X9psEfpOEex2u3aL7FKpwEjrJu1gfi793SNSOe6">
    <link media="all" type="text/css" rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .header {
            min-height: 80px;
            width: 100%;
            / background-color: #488AEC !important; /
            / background: url('assets/img/bannerBg.png') no-repeat; /
            position: relative;
            padding: 10px 0;
            margin-bottom: 30px;
            background-size: cover;
            background: #c8deff !important;
        }

        .navbar {
            min-height: 45px;
            / background: transparent !important; /
            padding: 0;
        }

        .navbar-brand {
            height: auto;
            margin: 0 0;
            padding: 10px 15px 10px 0;
        }

        .navbar-nav {
            margin: 0 0 0;
        }

        .navbar-nav li {
            padding: 0 15px;
            margin-bottom: 10px;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #333;
            font-size: 16px;
            line-height: 20px;
            padding: 0;
            text-decoration: none;
            text-transform: capitalize;
            font-weight: 600;
        }

        .navbar-expand-lg .navbar-collapse {
            justify-content: end;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 16px;
            line-height: 20px;
            padding: 0;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 500 !important;
            font-family: 'Sifonn';
        }

        .navbar-nav {
            margin: 0 0 0;
            align-items: center;
        }

        .navbar-light .navbar-nav .nav-link.active,
        .navbar-light .navbar-nav .show.nav-link {
            color: #dce9fb !important;
            font-weight: 500 !important;
        }

        .navbar-light .navbar-nav .nav-link:focus,
        .navbar-light .navbar-nav .nav-link:hover {
            color: #dce9fb !important;
        }

        .navbar-toggler-icon i::before {
            content: "" !important;
        }

        .privacyLogo {
            width: 180px;
        }

        .mainPrivacy {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        / End Header Css /
        / Start Footer Section Css /
        footer {
            background: #c8deff !important;
            padding: 20px 0;
            /* position: fixed;
        bottom: 0; */
            width: 100%;
            color: #0066f300;
        }

        .copirigtCommon ul {
            display: flex;
            padding: 0;
            margin: 13px 0 0;
        }

        .link__ ul li {
            display: inline-block;
            padding: 0 10px;
        }

        .link__ ul li a {
            color: #ffffff;
            text-transform: capitalize;
            text-decoration: none !important;
        }

        .footerLinks {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .copirigtCommon ul li a {
            background: transparent;
            border-radius: 50%;
            height: 36px;
            position: relative;
            text-decoration: none;
            width: 36px;
            color: #FFF;
            text-align: center;
            border: 1px solid #fff;
            margin: 0 9px 0 0;
            display: inline-block;
        }

        .copirigtCommon ul li i {
            color: #fff;
            font-size: 14px;
            left: 50%;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .copirigtCommon p {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 30px;
            color: #2e53eefa;
        }

        .copirigtCommon {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .copirigtCommon li {
            list-style: none !important;
        }

        .formBtns {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ticketBtn {
            background: transparent linear-gradient(14deg, #0E0BFD 0%, #3692FF 100%) 0% 0% no-repeat padding-box;
            padding: 6px 28px;
        }

        .innerTicketForm {
            height: 50vh;
            overflow-y: scroll
        }

        .ticketformControl ::-webkit-scrollbar {
            display: none;
        }

        ::-webkit-inner-spin-button {
            display: none
        }

        .required {
            color: red;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="mainPrivacy">
        <div class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <a class="navbar-brand" href="">
                        <img src="{{ asset('images/theme/logo/adminloginLogo.svg') }}" alt=""
                            class="logo privacyLogo">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    </div>
                </nav>
            </div>
        </div>
        <div class="container login-signin bg-white rounded-lg">
            @yield('content')
        </div>

        <footer class="mt-auto">
            <div class="container">
                <div class="row text-center">
                    <div class="copirigtCommon d-block mt-3">
                        <p class="order-1 text-center">Copyright {{ date('Y') }} , All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Check if toastr is defined before using it
        if (typeof toastr !== 'undefined') {
            // Initialize Toastr.js with default options
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
    
            // Check if there's a success message and display a success toast
            @if(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
    
            // Check if there's an error message and display an error toast
            @if(Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @endif
    
            // Check if there's an error message and display an error toast
        } else {
            console.error('Toastr.js is not loaded or properly included.');
        }
    </script>
</body>

</html>
