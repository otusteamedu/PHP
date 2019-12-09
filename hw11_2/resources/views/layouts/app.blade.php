<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>Application</title>

    <meta charset="utf-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ mix('css/app.css', 'build') }}">
    @stack('styles')
</head>

<body>
<div class="pb-5">
    @include('layouts._parts.navbar')

    <div id="app" class="container mt-5" v-cloak>
        @include('_parts.success-message')
        @include('_parts.error-message')
        @yield('content')
    </div>
</div>

<script src="{{ mix('js/manifest.js', 'build') }}"></script>
<script src="{{ mix('js/vendor.js', 'build') }}"></script>
<script src="{{ mix('js/app.js', 'build') }}"></script>
@stack('scripts')
</body>

</html>
