@extends('layouts.main')
@section('content')
    <div class="large-6 large-centered columns auth-container">
        <h4 class="text-center">Log in to CommutePop</h4>
          <div class="auth-box">
          <div class="row">
          <div class="large-12 columns">
              <a href="/auth/facebook">Log in with Facebook</a>
            <form method="POST" action="/auth/login">
                {!! csrf_field() !!}

                <div class="row">
                    <div class="large-12 columns">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 columns">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>                    
                </div>

                <div class="row">
                    <div class="large-12 columns">
                        <input type="checkbox" name="remember"> Remember Me
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 large-centered columns">
                        <button type="submit" class="expand radius">Log in</button>
                    </div>
                </div>
                <a href="/password/email">Forget your password?</a>
            </form>
            </div>
            </div>
            </div>

            <div class="after-box text-center">
                        <p>First time here? <a href="/auth/register">Sign up! It's easy.</a></p>
            </div>
    </div>
@stop