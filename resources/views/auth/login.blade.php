@extends('layouts.main')
@section('content')
    <h3>Log in to manage your alerts or create new ones.</h3>
    <form method="POST" action="/auth/login">
        {!! csrf_field() !!}

        <div>
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            Password
            <input type="password" name="password" id="password">
            <a href="/password/email">Forgot?</a>
        </div>

        <div>
            <input type="checkbox" name="remember"> Remember Me
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    <p>First time here? <a href="/auth/register">Register!</a> It's easy.</p>
@stop