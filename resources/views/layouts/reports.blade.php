<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/reports.css') }}" rel="stylesheet">

    <title>{{ env('app.name', 'Laravel') }}</title>

</head>
<body>
    <div class="page_header">
        <div class="header">
            <table class="table_header" cellspacing="0" cellpadding="5">
                <tr>
                    <td>
                        {{ config('app.name') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page_footer">Page: <span class="pageenum"></span></div>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
