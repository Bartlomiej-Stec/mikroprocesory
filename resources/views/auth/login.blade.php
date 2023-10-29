@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h1 class="h3 mb-3 fw-normal">Logowanie</h1>
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

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                Zapamiętaj mnie
            </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Zaloguj</button>
        <a class="mt-5 mb-3 text-body-secondary" href="{{route('register')}}">Rejestracja</a>
    </form>
@endsection
