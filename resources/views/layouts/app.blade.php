<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-fixed-side.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Project Management') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Register</a></li>
                        @else

                            <li><a href="{{ route('companies.index') }}"><i class="fa fa-building"></i> Companies</a></li>
                            <li><a href="{{ route('projects.index') }}"><i class="fa fa-briefcase"></i> Projects</a></li>
                            <li><a href="{{ route('tasks.index') }}"><i class="fa fa-tasks"></i> Tasks</a></li>

                            @if( Auth::user()->role_id == 1)
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="fa fa-key"></i> Admin <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ route('companies.index') }}"><i class="fa fa-building-o"></i> All companies</a></li>
                                        <li><a href="{{ route('projects.index') }}"><i class="fa fa-briefcase"></i> All projects</a></li>
                                        <li><a href="{{ route('tasks.index') }}"><i class="fa fa-tasks"></i> All tasks</a></li>
                                        <li><a href="{{ route('users.index') }}"><i class="fa fa-user-o"></i> All users</a></li>
                                        <li><a href="{{ route('roles.index') }}"><i class="fa fa-key"></i> All roles</a></li>
                                    </ul>
                                </li>
                            @endif

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa fa-user"></i> {{ Auth::user()->fullName() }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('menu')

        <div class="container">

            @include('partials.errors')
            @include('partials.success')

            <div class="row">
                @yield('content')
            </div>
        </div>

    </div>


    @yield('add_script')

</body>
</html>
