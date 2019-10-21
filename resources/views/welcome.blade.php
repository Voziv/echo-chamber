<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
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
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            {{ config('app.name') }}
        </div>
        <div class="links">
            <a href="https://www.voziv.com">Voziv</a>
            <a href="https://www.leerobert.ca">Lee Robert</a>
            <a href="https://www.kingstondevelopers.ca">Kingston Developers</a>
            <a href="https://www.oneleveldeeper.com">1LD</a>
            <a href="https://github.com/Voziv">GitHub</a>
        </div>
        <br>
        <hr>
        <br>
        <p>Note: This app is just for testing a k8s helm chart.</p>
        <p>Scroll down for more info</p>
    </div>
</div>
<div style="padding: 2em;">
    <p>Test info</p>
    <table border="1" cellpadding="5" width="800" style="text-align: left">
        <tr>
            <th>Property</th>
            <th>Value</th>
        </tr>
        <tr><td>K8S Node</td><td>{{ env('MY_NODE_NAME') }}</td></tr>
        <tr><td>K8S Pod</td><td>{{ env('MY_POD_NAME') }}</td></tr>
        <tr><td>Database Status</td><td>{{ $database_is_healthy ? 'Healthy' : 'Error!' }}</td></tr>
        <tr><td>Redis Status</td><td>{{ $redis_is_healthy ? 'Healthy' : 'Error!' }}</td></tr>
        <tr><td>Cron Last Run</td><td>{{ $last_command }}</td></tr>
        <tr><td>Queue Job Last Run</td><td>{{ $last_job }}</td></tr>
    </table>

    <p>Echos</p>
    <table border="1" cellpadding="5" width="800" style="text-align: left">
        <tr><th>Index</th><th>Run At</th><th>By Pod</th><th>On Node</th></tr>
        @foreach ($echos as $key => $echo)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $echo['run_at'] ?? 'Old entry' }}</td>
                <td>{{ $echo['pod'] ?? 'Old entry' }}</td>
                <td>{{ $echo['node'] ?? 'Old entry'}}</td>
            </tr>
        @endforeach
    </table>

    <p>Echo Jobs</p>
    <table border="1" cellpadding="5" width="800" style="text-align: left">
        <tr><th>Index</th><th>Run At</th><th>By Pod</th><th>On Node</th></tr>
        @foreach ($echo_jobs as $key => $echo)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $echo['run_at'] ?? 'Old entry' }}</td>
                <td>{{ $echo['pod'] ?? 'Old entry' }}</td>
                <td>{{ $echo['node'] ?? 'Old entry'}}</td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
