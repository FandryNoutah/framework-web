@extends('authentication.app')

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form action="{{ route('register-store') }}" method="POST" class="user">

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="form-label ml-3" for="firstname">First Name</label>
                                    <input type="text" class="form-control form-control-user" id="firstname" name="firstname" placeholder="First Name">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label ml-3" for="lastname">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-user @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Last Name">
                                    @error('lastname')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label ml-3" for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address">
                                @error('email')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="form-label ml-3" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                                    @error('password')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label ml-3" for="password_confirmation">Password confirmation <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control form-control-user" id="password_confirmation" name="password_confirmation" placeholder="Repeat Password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
