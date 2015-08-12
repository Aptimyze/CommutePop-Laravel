<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CommutePop | Let us get you home</title>
        <link rel="stylesheet" href="{!! asset('css/foundation.css') !!}" />
        <link rel="stylesheet" type="text/css" href="{!! asset('css/extrastyles.css') !!}">
        <script src="{!! asset('js/vendor/modernizr.js') !!}"></script>
    </head>

<body>

    <!-- Header and Nav -->
 
    <nav class="top-bar" data-topbar>
        <ul class="title-area">
            <li class="name">
                <h1><a href="/">CommutePop</a></h1>
            </li>
        </ul>

        <section class="top-bar-section">
            <ul class="right">
                @if (Auth::guest())
                    <li><a href="/auth/login">Login</a></li>
                    <li><a href="/auth/register">Register</a></li>
                @else
                    <li class="has-dropdown">
                        <a href="#">{!! Auth::user()->name !!}</a>
                        <ul class="dropdown">
                            <li><a href="/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </section>
    </nav>
 
    <!-- End Header and Nav -->

    <div class="row">
        <div class="large-12">
            <div class="columns">
                @yield('content')
            </div>
        </div>
    </div>
 
 
    <!-- Footer -->
 
    <footer class="row">
        <div class="large-12 columns">
            <hr />
            <div class="row">
                <div class="large-6 columns">
                    <p>© Greg Kaleka</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{!! asset('js/vendor/jquery.js') !!}"></script>
    <script src="{!! asset('js/foundation.min.js') !!}"></script>
    <script>
      $(document).foundation();
    </script>
    </body>
</html>

