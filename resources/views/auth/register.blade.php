@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h1 class="h3 mb-3 fw-normal">Rejestracja</h1>
        <div class="form-floating">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Login">
            <label for="name">Login</label>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Adres email">
            <label for="email">Adres email</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
                autocomplete="current-password" id="password" placeholder="Hasło">
            <label for="password">Hasło</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password_confirmation" required
                autocomplete="current-password" id="password_confirmation" placeholder="Hasło">
            <label for="password_confirmation">Powtórz hasło</label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Zarejestruj</button>
        <a class="mt-5 mb-3 text-body-secondary" href="{{ route('login') }}">Logowanie</a>
    </form>
@endsection
