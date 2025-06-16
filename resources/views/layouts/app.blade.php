<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Casa de Apuestas')</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Tema Oscuro y Animaciones -->
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            animation: fadeIn 0.6s ease-in-out;
        }

        .form-control {
            background-color: #2c2c2c;
            color: #ffffff;
            border: 1px solid #444;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #00bcd4;
            border-color: #00bcd4;
            transition: transform 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            background-color: #0097a7;
        }

        .btn-secondary {
            background-color: #757575;
            border-color: #757575;
            color: #fff;
            transition: transform 0.3s ease;
        }

        .btn-secondary:hover {
            transform: scale(1.05);
            background-color: #616161;
        }

        .navbar {
            background-color: #1c1c1c !important;
        }

        .nav-link {
            color: #ffffff !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #00bcd4 !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Casa de Apuestas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="display:inline; padding:0; border:none; background:none;">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Ingresar</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS Bundle CDN (popper + js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
