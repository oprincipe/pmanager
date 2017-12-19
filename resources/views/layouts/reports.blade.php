<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/reports.css') }}" rel="stylesheet">

    <title>{{ config('app.name', 'Laravel') }}</title>

</head>
<body>
    <div class="header">
        <table class="table_header" cellspacing="0" cellpadding="5">
            <tr>
                <td>
                    {{ config('app.name') }}
                </td>
            </tr>
        </table>
    </div>
    <div id="app">
        @yield('content')
    </div>
</body>
</html>
