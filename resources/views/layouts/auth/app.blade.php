<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - authentication</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img') }}/musamus.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('backend_theme') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_theme') }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_theme') }}/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend_theme') }}/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend_theme') }}/assets/css/forms/switches.css">
</head>

<body class="form">


    <div class="form-container outer">
        @yield('content')
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('backend_theme') }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{ asset('backend_theme') }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ asset('backend_theme') }}/bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('backend_theme') }}/assets/js/authentication/form-2.js"></script>

</body>

</html>
