<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="{{ Spark::usesRightToLeftTheme() ? 'css/app-rtl.css' : 'css/app.css' }}" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/{{env('BRAND')}}/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/{{env('BRAND')}}/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/{{env('BRAND')}}/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/{{env('BRAND')}}/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/{{env('BRAND')}}/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/{{env('BRAND')}}/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/{{env('BRAND')}}/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/{{env('BRAND')}}/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/{{env('BRAND')}}/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/{{env('BRAND')}}/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/{{env('BRAND')}}/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="/{{env('BRAND')}}/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="/{{env('BRAND')}}/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="/{{env('BRAND')}}/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="/{{env('BRAND')}}/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="/{{env('BRAND')}}/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="/{{env('BRAND')}}/mstile-310x310.png" />

    <!-- Scripts -->
    @yield('scripts', '')

    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(
            Spark::scriptVariables(), []
        )); ?>;
    </script>
</head>
<body class="with-navbar">
    <div>
        <!-- Navigation -->
        @if (Auth::check())
            @include('spark::nav.blade.user')
        @else
            @include('spark::nav.guest')
        @endif

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- JavaScript -->
        <script src="/js/app.js"></script>
    </div>
</body>
</html>
