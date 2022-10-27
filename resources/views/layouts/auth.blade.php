<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', env('APP_NAME'))</title>

    @vite([ 'resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js', ])

</head>
<body class="antialiased">

@if (session()->has('message'))
    {{ session('message') }}
@endif
<!-- Page heading -->
<div class="text-center">
    <a href="index.html" class="inline-block" rel="home">
        <img src="{{ \Illuminate\Support\Facades\Vite::image('logo.svg') }}"
             class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]" alt="CutCode">
    </a>
</div>
    @yield('content')
</body>
</html>
