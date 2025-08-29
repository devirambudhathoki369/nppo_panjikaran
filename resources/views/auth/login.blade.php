@extends('layouts.auth')

@section('content')
    <div class="auth-content my-auto">
        <div class="text-center">
            <h5 class="mb-0">Welcome Back !</h5>
            <p class="text-muted mt-2">Sign in to continue or Register if you are new.</p>
        </div>
        <form class="mt-4 pt-2" method="POST" action="{{ route('custom.login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input tabindex="1" id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email"
                    autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <label class="form-label">Password</label>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="flex-shrink-0">
                            <div class="">
                                <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="input-group auth-pass-inputgroup">
                    <input tabindex="2" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password"
                        aria-label="Password" required autocomplete="current-password" aria-describedby="password-addon">
                    <button tabindex="3" class="btn btn-light shadow-none ms-0" type="button" id="password-addon">
                        <i class="mdi mdi-eye-outline"></i>
                    </button>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember-check"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember-check">
                            Remember me
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
            </div>
        </form>

        {{-- @if (Route::has('register'))
            <div class="mt-5 text-center">
                <p class="text-muted mb-0">Don't have an account ? <a href="{{ route('register') }}"
                        class="text-primary fw-semibold"> Register Now </a> </p>
            </div>
        @endif --}}
    </div>

    @push('scripts')
        <script>
            document.getElementById('password-addon').addEventListener('click', function() {
                const passwordInput = document.querySelector('input[name="password"]');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="mdi mdi-eye-off-outline"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="mdi mdi-eye-outline"></i>';
                }
            });
        </script>
    @endpush
@endsection
