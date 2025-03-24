@extends('layouts.auth')
@section('content')
    <!-- Log In page -->
    <div class="row">
        <div class="col-lg-3 pe-0">
            <div class="card mb-0 shadow-none">
                <div class="card-body">

                    <h3 class="text-center m-0">
                        <a href="{{ '/' }}" class="logo logo-admin"><img
                                src="{{ asset('logo/' . $settings->path_logo) }}" height="60" alt="logo"
                                class="my-3"></a>
                    </h3>

                    <div class="px-2 mt-2">
                        <h4 class="font-size-18 mb-2 text-center">Welcome Back !</h4>
                        <p class="text-muted text-center">Sign in to continue to {{ $settings->nama_aplikasi }}.</p>
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                {!! $error !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="form-horizontal my-4" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group">

                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>

                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" placeholder="Enter email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="userpassword">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-key"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="userpassword" placeholder="Enter password">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="mb-3 mb-0 row">
                                <div class="col-12 mt-2">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                        In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </form>
                        <!-- end form -->
                    </div>
                    <div class="mt-4 text-center">
                        <p class="mb-0">©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> {{ $settings->nama_aplikasi }}. Crafted with <i
                                class="mdi mdi-heart text-danger"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-lg-9 p-0 vh-100  d-flex justify-content-center">
            <div class="accountbg d-flex align-items-center">
                <div class="account-title text-center text-white">
                    <h4 class="mt-3 text-white">Welcome To <span class="text-warning"> {{ $settings->nama_aplikasi }}</span>
                    </h4>
                    <h1 class="text-white">Let's Get Started</h1>
                    <div class="border w-25 mx-auto border-warning"></div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- End Log In page -->
@endsection
