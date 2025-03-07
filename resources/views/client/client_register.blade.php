<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Client Register </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

        <!-- preloader css -->
        <link rel="stylesheet" href="{{ asset('backend/assets/css/preloader.min.css') }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>




    <!-- <body data-layout="horizontal"> -->
<div class="auth-page d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="auth-full-page-content p-sm-5 p-4 shadow rounded bg-white">
                    <div class="text-center">
                        <a href="index.html" class="d-block auth-logo">
                            <img src="{{ asset('backend/assets/images/logo-sm.svg') }}" alt="" height="28">
                            <span class="logo-txt">Client Register</span>
                        </a>
                    </div>
                    <div class="auth-content my-auto">
                        <div class="text-center">
                            <h5 class="mb-0">Welcome Back!</h5>
                            <p class="text-muted mt-2">Sign in to continue to Client.</p>
                        </div>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif     

                        <form class="mt-4 pt-2" action="{{ route('client.register.submit') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Restaurant Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Enter password">
                                    <button class="btn btn-light shadow-none ms-0" type="button">
                                        <i class="mdi mdi-eye-outline"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">Register</button>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <h5 class="font-size-14 text-muted">- Sign in with -</h5>
                            <div>
                                <a href="#" class="btn btn-primary btn-sm"><i class="mdi mdi-facebook"></i></a>
                                <a href="#" class="btn btn-info btn-sm"><i class="mdi mdi-twitter"></i></a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="mdi mdi-google"></i></a>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-muted">Already have an account? <a href="./client_register.blade.php" class="text-primary fw-semibold">Sign In</a></p>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Cravings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



        <!-- JAVASCRIPT -->
        <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
        <!-- pace js -->
        <script src="{{ asset('backend/assets/libs/pace-js/pace.min.js') }}"></script>
        <!-- password addon init -->
        <script src="{{ asset('backend/assets/js/pages/pass-addon.init.js') }}"></script>

    </body>

</html>