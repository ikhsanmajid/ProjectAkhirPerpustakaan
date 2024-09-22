<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            padding-top: 72px;
            background-image: url('{{ asset('storage/images/background.png') }}');
            background-repeat: no-repeat;
            background-size: cover;

        }

        .backdrop-bg {
            height: inherit;
            background-color: rgba(255, 255, 255, 0.4);
            -webkit-backdrop-filter: blur(3px);
            backdrop-filter: blur(3px);
        }
    </style>
</head>

<body class="vh-100 backdrop-bg">
        <nav class="navbar fixed-top bg-primary">
            <div class="container-fluid px-3 py-1 d-flex justify-content-between">
                <div class="navbar-brand mb-0 h1 text-white">Navbar</div>
                <div>
                    @if (Auth::check())
                        <a href="/logout" class="text-white text-decoration-none">
                            Logout
                        </a>
                    @else
                        <a href="/login" class="text-white text-decoration-none">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </nav>
        @yield('content')

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    @yield('script-js')

</body>

</html>
