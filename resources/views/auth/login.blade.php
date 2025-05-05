<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('landing/images/logo/icon.png') }}">

    <!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('css/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom/common.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="loading authentication-bg-1" style="background-image: url(landing/images/background/bg-1.webp)">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="javascript:void(0)" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('landing/images/logo/dreamcapvc-dark.jpg') }}" alt="" height="100">
                                        </span>
                                    </a>

                                    <a href="javascript:void(0)" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('landing/images/logo/dreamcapvc-dark.jpg') }}" alt="" height="100">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Enter your email address and password to access.</p>
                            </div>
                            <form method="POST" action="{{ route('login') }}" novalidate>
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="email">Email address</label>
                                    <input class="form-control" type="email" id="email" name="email" required="" placeholder="Enter your email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary-bn btn-block" type="submit"> {{ __('Login') }} </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <footer class="footer footer-alt">
        2020 - <script>
            document.write(new Date().getFullYear())
        </script> &copy; by <a href="https://dreamcapvc.com" target="_blank">dreamcapvc</a>
    </footer>

    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
</body>

</html>