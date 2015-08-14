@extends('layouts.main')
@section('content')
    <div class="large-6 large-centered columns auth-container">
        <h4 class="text-center">Sign up to start using CommutePop</h4>
          <div class="auth-box">
              <div class="row">
                  <div class="medium-7 columns medium-centered">
                      <a href="/auth/facebook" class="facebook left-icon button split"> <span></span>Log in with Facebook</a>
                  </div>
              </div>
          </div>
              <p class="text-center">OR</p>
          <div class="auth-box">
          <div class="row">
          <div class="large-12 columns">
          <h5 class="text-center">Register</h5>
        <form method="POST" action="/auth/register">
            {!! csrf_field() !!}

                <div>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Name">
                </div>

                <div>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">

            </div>

                <div>
                <input type="password" name="password" placeholder="Password">
            </div>

                <div>
                <input type="password" name="password_confirmation" placeholder="Confirm Password">
            </div>

                <div>
                <button type="submit" class="expand radius">Sign Up</button>
            </div>
        </form>
        </div>
        </div>
        </div>

        <div class="after-box text-center">
            <p>Done this before? <a href="/auth/login">Log in</a></p>
        </div>
    </div>
@stop