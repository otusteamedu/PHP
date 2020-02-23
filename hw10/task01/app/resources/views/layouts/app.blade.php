<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/css/app.css"/>
</head>
<body>
    @include('inc.navbar')
    <div class="container">
        @include('inc.messages')
        @yield('content')
    </div>

    <footer id="footer" class="text-center mt-4 pt-4 pb-2">
        <p>Copyright {{date('Y')}} &copy; Youtube channels</p>
    </footer>
</body>
</html>
