<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 welcome-section">
        <h2>Welcome to <span class="pink-highlight">Canvas</span></h2>
    </div>
    <!-- Form to Login -->
    <div class="col-md-6 login-form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Student Number -->
            <div class="form-group">
                <label for="s_number">S-Number</label>
                <input id="s_number" type="text" class="form-control @error('s_number') is-invalid @enderror" name="s_number" value="{{ old('s_number') }}" required autofocus>

                @error('s_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!-- Remember details -->
            <div class="form-group remember-me">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember Me</label>
            </div>
            <!-- Login btn -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <!-- register btn links to register form -->
            <div class="form-group">
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            </div>
            <!-- Forgot pass -->
            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            @endif
        </form>
    </div>
</div>
@endsection
