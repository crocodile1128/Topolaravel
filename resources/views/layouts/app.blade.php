<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Topology</title>
</head>
<body class="bg-gray-200">
    <!--Title & Nav bar-->
    <nav class="p-6 bg-white flex justify-between">
        <ul class="flex items-center">
            {{-- <li>
                <a href="/" class="p-3">Home</a>
            </li> --}}
            <li>
                <a href="{{ route('dashboard') }}" class="p-3">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('host') }}" class="p-3">Host</a>
            </li>
            <li>
                <a href="{{ route('graph0') }}" class="p-3">Graph</a>
            </li>
            {{-- <li>
                <a href="{{ route('graph1') }}" class="p-3">Graph - By Session</a>
            </li> --}}
        </ul>
        {{-- <ul class="flex items-center">
            @if (auth()->user())
                <li>
                    <a href="" class="p-3">Hi~{{ auth()->user()->name }}</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post" class="inline p-3">
                        @csrf
                        <button type=>Logout</button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}" class="p-3">Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="p-3">Register</a>
                </li>
            @endif

        </ul> --}}
    </nav>
    @yield('content')
    @yield('extend-js')
</body>
</html>
