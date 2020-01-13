<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.html-header')
    </head>
    <body>
        <div id="app">
            @include('partials.site-header')
            <router-view></router-view>

            @include('partials.site-footer')
        </div>

        @include('partials.scripts')
    </body>
</html>
