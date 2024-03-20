<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Welcome | {{ env('APP_NAME') }}</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

  @include('backend.layouts.css')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="nav-md layout-fixed">
    <div id="app">
        <router-view></router-view>
    </div>
  @include('backend.layouts.js')
</body>

</html>