<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 5px 25px 5px 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                border: 1px solid #0E0E0E;
                border-radius: 5px;
                margin-left: 10px;
                margin-right: 10px;
            }

            .links > a:hover {
                color: #FAF72D;
                background-color: #489BED;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                @auth
                    <div class="top-right links">
                        <a href="{{ url('/home') }}">Home</a>
                    </div>
                @else
                    <div class="top-right links">
                        <a href="{{ route('login') }}">Admin Login</a>
                        {{-- <a href="{{ route('register') }}">Register</a> --}}
                    </div>
                @endauth
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{ config('app.name') }}
                </div>

                <div class="links">
                    <em>Principe Orazio - php senior software developer</em>
                </div>

                @auth
                @else
                    <p>
                    <div class="links">
                        <a href="{{ route('customer.login') }}">Customer Login</a>
                    </div>
                    </p>
                @endauth

            </div>
        </div>
    </body>
</html>
