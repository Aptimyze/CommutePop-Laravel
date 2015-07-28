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

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
    </body>
</html>

