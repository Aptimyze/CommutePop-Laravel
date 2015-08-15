<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CommutePop | Let us get you home</title>
        <link rel="stylesheet" href="{!! asset('css/foundation.css') !!}" />
        <link rel="stylesheet" type="text/css" href="{!! asset('css/extrastyles.css') !!}">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">
        <script src="{!! asset('js/vendor/modernizr.js') !!}"></script>
    </head>

<body>

    <!-- Header and Nav -->

 <div class="contain-to-grid">
     <nav class="top-bar" data-topbar role="navigation">
         <ul class="title-area">
             <li class="name">
                 <h1><a href="/home">CommutePop</a></h1>
             </li>
             <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
         </ul>
 
         <section class="top-bar-section">
             <ul class="right">
                 @if (Auth::guest())
                     <li class="divider"></li>
                     <li><a href="/auth/login">Log in</a></li>
                     <li class="divider"></li>
                     <li><a href="/auth/register">Sign up</a></li>
                     <li class="divider"></li>
                 @else
                     @if (!is_null(Auth::user()->facebook_id))
                         <li>
                             <img src="//graph.facebook.com/v2.4/{!! Auth::user()->facebook_id !!}/picture?type=normal" style="height: 55px;">
                         </li>
                     @endif
                     <li class="divider"></li>
                     <li class="has-dropdown">
                         <a href="#"><span style="font-size: 0.95rem;">{!! Auth::user()->name !!}</span></a>
                         <ul class="dropdown">
                             <li><a href="/alerts">My alerts</a></li>
                             <li><a href="/auth/logout">Log out</a></li>
                         </ul>
                     </li>
                     <li class="divider"></li>
                 @endif
             </ul>
         </section>
     </nav>
  </div>

    <!-- End Header and Nav -->

    <div data-alert class="alert-box info text-center">
        Reminder: CommutePop is currently in beta! Use with caution, and please <a href="mailto:beta@commutepop.com">email us</a> if you spot issues.
    </div>
    @if (Session::has('message'))
        <div data-alert class="alert-box success" style="margin-top: -1.5rem;">
            {{{ Session::get('message') }}}
            <a href="#" class="close">&times;</a>
        </div>
    @endif

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
                    <p>&copy; Greg Kaleka</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{!! asset('js/vendor/jquery.js') !!}"></script>
    <script src="{!! asset('js/foundation.min.js') !!}"></script>
    <script src="{!! asset('js/app.js') !!}"></script>
    <script>
        $(document).foundation();
    </script>
    </body>
</html>

