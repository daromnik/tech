<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include("layouts.header")
    </head>
    <body>

        @include("layouts.nav")

        <div class="container-fluid">
            <div class="row">

                @include("layouts.sidebar")

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

                    @yield("content")

                </main>
            </div>
        </div>

        @include("layouts.footer")

    </body>
</html>
