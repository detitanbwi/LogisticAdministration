<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <title>{{ config('app.name') }} || @yield('title')</title>
    <!--! BEGIN: Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('back/assets/images/logo-scj.png') }}">
    <!--! END: Favicon-->
    <!--! BEGIN: Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/bootstrap.min.css') }}">
    <!--! END: Bootstrap CSS-->
    <!--! BEGIN: Vendors CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/vendors/css/vendors.min.css') }}">
    <!--! END: Vendors CSS-->
    <!--! BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/vendors/css/sweetalert2.min.css') }}">
    <!--! END: Custom CSS-->
    <!--! HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries !-->
    <!--! WARNING: Respond.js doesn"t work if you view the page via file: !-->
    <!--[if lt IE 9]>
            <script src="https:oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https:oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <main class="auth-cover-wrapper">
        <div class="auth-cover-content-inner">
            <div class="auth-cover-content-wrapper p-0 m-0"
                style="background-image: url('https://images.unsplash.com/photo-1494412651409-8963ce7935a7?auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; position: relative; height: 100%;">
                <div
                    style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(6,56,128,0.85) 0%, rgba(13,110,253,0.5) 100%);">
                </div>

                <div
                    style="position: absolute; inset: 0; display: flex; flex-direction: column; justify-content: center; align-items: center; z-index: 2; padding: 2rem; text-align: center;">
                    <h1 class="text-white fw-bolder mb-4"
                        style="font-size: 3.5rem; text-shadow: 0 4px 15px rgba(0,0,0,0.5);">Pioneering <br> Maritime
                        Logistics</h1>
                    <p class="text-white fs-16"
                        style="max-width: 500px; text-shadow: 0 2px 8px rgba(0,0,0,0.5); opacity: 0.9;">
                        Platform administrasi dan manajemen invoice kapal terdepan. Kami memastikan setiap proses
                        berjalan akurat, aman, dan efisien.
                    </p>
                </div>
            </div>
        </div>
        <div class="auth-cover-sidebar-inner">
            <div class="auth-cover-card-wrapper">
                <div class="auth-cover-card p-4 p-sm-5 shadow-none border-0 mb-5">

                    <!-- Branding Section -->
                    <div class="text-center mb-5">
                        <img src="{{ asset('back/assets/images/logo-scj.png') }}" alt="SCJ Logo" class="img-fluid mb-3"
                            style="height: 100px; object-fit: contain;">
                        <h2 class="fw-black mb-1" style="font-size: 1.5rem; letter-spacing: 0.5px; color: #1e293b;">
                            PT. SINAR <span style="color: #ef4444;">CEMARA</span> JAYA
                        </h2>
                        <span class="fs-12 fw-medium text-muted text-uppercase tracking-wider">Shipping & Logistics
                            Operations</span>
                    </div>

                    @yield('content')

                </div>
            </div>
        </div>
    </main>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! Footer Script !-->
    <!--! ================================================================ !-->
    <!--! BEGIN: Vendors JS !-->
    <script src="{{ asset('back/assets/vendors/js/vendors.min.js') }}"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="{{ asset('back/assets/js/common-init.min.js') }}"></script>
    <!--! END: Apps Init !-->
    <!--! BEGIN: Theme Customizer  !-->
    <script src="{{ asset('back/assets/js/theme-customizer-init.min.js') }}"></script>
    <script src="{{ asset('back/assets/vendors/js/sweetalert2.min.js') }}"></script>
    <!--! END: Theme Customizer !-->
    <x-back.alert />
    @stack('scripts')
</body>

</html>