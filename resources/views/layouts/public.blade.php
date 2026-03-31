<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'منصة البلاغات') - {{ config('app.name', 'CleanStreets') }}</title>
        <meta
            name="description"
            content="منصة إلكترونية لاستقبال بلاغات المواطنين حول السيارات المدمرة أو المحروقة أو المتروكة في الشوارع."
        >
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=tajawal:400,500,700,800" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="public-body text-slate-900 antialiased">
        <div class="public-shell min-h-screen">
            @yield('content')
        </div>

        @stack('scripts')
    </body>
</html>
