@extends('layout.master-mini')
@section('content')

    <div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
         style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">
        <div class="row w-100">
            <div class="col-lg-4 mx-auto">
                <div class="auto-form-wrapper">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="label" for="email">Email</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                      <i class="mdi mdi-check-circle-outline"></i>
                                    </span>
                                </div>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="label" for="password">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="*********">
                                <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary submit-btn btn-block">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <div class="form-check form-check-flat mt-0">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" checked> Keep me signed in </label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-small forgot-password text-black">Forgot Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
