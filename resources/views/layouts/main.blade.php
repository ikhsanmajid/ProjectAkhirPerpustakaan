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
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid px-3 py-1 d-flex justify-content-between">
            <a class="navbar-brand mb-0 h1 text-white" href="/">Perpustakaan</a>
            <!-- Toggle button for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links and items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/riwayat">Riwayat</a>
                    </li>
                </ul>
                <ul class="navbar-nav d-flex">
                    <li class="nav-item">
                        @if (Auth::check())
                            <a href="/logout" class="text-white text-decoration-none">
                                Logout
                            </a>
                        @else
                            <a href="/login" class="text-white text-decoration-none">
                                Login
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container-fluid">
        <div class="row w-100 h-100 my-3 mx-2 pe-3">
            @yield('content')
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    
    @yield('script-js')

</body>

</html>
