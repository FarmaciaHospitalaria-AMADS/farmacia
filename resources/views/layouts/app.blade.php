<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Salud')</title>

    <style>
        /* Estilos súper básicos solo para visualizar la estructura */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        nav {
            background-color: #333;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }

        .user-menu {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        main {
            padding: 20px;
        }

        button.logout-btn {
            background: #ff4c4c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <nav>
        <div class="brand">
            <strong>Mi Proyecto</strong>
        </div>

        @auth
        <div class="nav-links">
            @if(Auth::user()->role_id === 1)
            <a href="{{ route('admin.dashboard') }}">Inicio Admin</a>
            <a href="#">Gestionar Usuarios</a>
            <a href="#">Reportes Generales</a>
            <a href="{{ route('alertas.index') }}">Alertas</a>

            @elseif(Auth::user()->role_id === 2)
            <a href="{{ route('farmacia.dashboard') }}">Inicio Farmacia</a>
            <a href="#">Inventario</a>
            <a href="#">Despacho de Recetas</a>
            <a href="{{ route('alertas.index') }}">Alertas</a>

            @elseif(Auth::user()->role_id === 3)
            <a href="{{ route('enfermeria.dashboard') }}">Inicio Enfermería</a>
            <a href="#">Pacientes</a>
            <a href="#">Toma de Signos</a>
            @endif
        </div>

        <div class="user-menu">
            <span>Hola, {{ Auth::user()->name }}</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Cerrar Sesión</button>
            </form>
        </div>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

</body>

</html>