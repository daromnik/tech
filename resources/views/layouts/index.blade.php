<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include("layouts.header")
        <link rel="stylesheet" href="/css/bootstrap-4-signin.css">
    </head>
    <body class="text-center">

        @yield("content")

        @include("layouts.footer")
    </body>
</html>
