@extends('layout.master-mini')

@section('content')
    <div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
         style="background-image: url({{ url('assets/images/auth/register.jpg') }}); background-size: cover;">
        <div class="row w-100">
            <div class="col-lg-4 mx-auto">
                <h2 class="text-center mb-4">{{ __('Register') }}</h2>
                <div class="auto-form-wrapper">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                      <i class="mdi mdi-check-circle-outline"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Username" name="name" value="{{ old('name') }}" required>
                                <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                                <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                                <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <div class="form-check form-check-flat mt-0">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" checked> I agree to the terms
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary submit-btn btn-block">Register</button>
                        </div>
                        <div class="text-block text-center my-3">
                            <span class="text-small font-weight-semibold">Already have and account ?</span>
                            <a href="{{ url('/user-pages/login') }}" class="text-black text-small">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
