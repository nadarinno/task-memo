@extends('layouts.app')

@section('content')
    <h2>Login</h2>

    <form action="{{ route('login.store') }}" method="POST">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>
            <input type="checkbox" name="remember" value="1" style="width:auto;">
            Remember me
        </label>

        <button type="submit">Login</button>
    </form>

    <p style="margin-top: 15px;">
        Don't have an account?
        <a href="{{ route('register') }}">Create account</a>
    </p>
@endsection