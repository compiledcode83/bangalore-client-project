<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.html-header')
    </head>
    <body>
        <div id="app">
            <layout></layout>

            @include('partials.site-header')
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>

            <site-footer></site-footer>
        </div>

        @include('partials.scripts')
    </body>
</html>
