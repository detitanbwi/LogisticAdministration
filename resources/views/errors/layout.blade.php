<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('back/assets/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/theme.min.css') }}">
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>
    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div
                        class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('back/assets/images/logo-abbr.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="card-body p-sm-5 text-center">
                        <h2 class="fw-bolder mb-4" style="font-size: 120px">
                            @yield('code')
                        </h2>
                        <h4 class="fw-bold mb-2">@yield('message')</h4>
                        <p class="fs-12 fw-medium text-muted">@yield('description')</p>
                        <div class="mt-5">
                            <a href="{{ url()->previous() ?? '/' }}" class="btn btn-light-brand w-100">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('back/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/common-init.min.js') }}"></script>
</body>

</html>
