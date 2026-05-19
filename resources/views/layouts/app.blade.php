<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Salud')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            -webkit-font-smoothing: antialiased;
        }

        .navbar-premium {
            background-color: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand strong {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .brand strong i {
            color: #2563eb;
            font-size: 1.5rem;
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex: 1;
        }

        .nav-links {
            display: flex;
            gap: 0.2rem;
            align-items: center;
            margin: 0 auto;
        }

        .nav-links a {
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
        }

        .nav-links a i {
            font-size: 1.15rem;
        }

        .nav-links a:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .nav-links a.active-link {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.2);
        }

        /* Dropdown Reportes */
        .nav-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .nav-dropdown-btn {
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
            cursor: pointer;
            background: none;
            border: none;
        }

        .nav-dropdown-btn:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .nav-dropdown-btn.active-dropdown {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 700;
        }

        .nav-dropdown-btn i {
            font-size: 1.15rem;
        }

        .nav-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            z-index: 200;
            overflow: hidden;
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1rem;
            color: #334155;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
        }

        .nav-dropdown-menu a:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .nav-dropdown-menu a.active-link {
            background-color: #0f172a;
            color: #ffffff;
        }

        .nav-dropdown.open .nav-dropdown-menu {
            display: block;
        }

        .user-menu {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .user-greeting {
            color: #334155;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .user-avatar-icon {
            background: #e2e8f0;
            color: #475569;
            padding: 0.4rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .logout-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .menu-toggle {
            display: none;
            background: transparent;
            border: none;
            font-size: 2rem;
            color: #0f172a;
            cursor: pointer;
            padding: 0;
        }

        @media (max-width: 1100px) {
            .navbar-premium {
                padding: 1rem;
            }

            .menu-toggle {
                display: block;
            }

            .nav-wrapper {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: #ffffff;
                padding: 1.5rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                border-top: 1px solid #e2e8f0;
                gap: 1rem;
                align-items: stretch;
            }

            .nav-wrapper.active {
                display: flex;
            }

            .nav-links {
                flex-direction: column;
                width: 100%;
            }

            .nav-links a {
                width: 100%;
                padding: 0.8rem 1rem;
                font-size: 0.95rem;
            }

            .nav-dropdown {
                flex-direction: column;
                width: 100%;
            }

            .nav-dropdown-btn {
                width: 100%;
                padding: 0.8rem 1rem;
                font-size: 0.95rem;
            }

            .nav-dropdown-menu {
                position: static;
                box-shadow: none;
                border: none;
                border-left: 3px solid #e2e8f0;
                border-radius: 0;
                margin-left: 1rem;
            }

            .user-menu {
                flex-direction: column;
                width: 100%;
                border-top: 1px solid #e2e8f0;
                padding-top: 1rem;
                gap: 1rem;
            }

            .user-greeting {
                justify-content: center;
            }

            .logout-btn {
                width: 100%;
                justify-content: center;
                padding: 0.8rem;
                font-size: 0.95rem;
            }
            .nav-wrapper.active { display: flex; }
            .nav-links { flex-direction: column; width: 100%; }
            .nav-links a { width: 100%; padding: 0.8rem 1rem; font-size: 0.95rem; }
            .user-menu { flex-direction: column; width: 100%; border-top: 1px solid #e2e8f0; padding-top: 1rem; gap: 1rem; }
            .user-greeting { justify-content: center; }
            .logout-btn { width: 100%; justify-content: center; padding: 0.8rem; font-size: 0.95rem; }
        }
    </style>
</head>

<body>

    <nav class="navbar-premium">
        <div class="brand">
            <strong><i class='bx bx-plus-medical'></i> F A R M A C I A</strong>
        </div>

        @auth
        <button class="menu-toggle" id="mobile-menu-btn">
            <i class='bx bx-menu'></i>
        </button>

        <div class="nav-wrapper" id="nav-wrapper">
            <div class="nav-links">

                @if(Auth::user()->role_id === 1)
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active-link' : '' }}">
                    <i class='bx bx-home-alt'></i> Inicio Admin
                </a>
                <a href="#" class="{{ request()->is('admin/usuarios*') ? 'active-link' : '' }}">
                    <i class='bx bx-group'></i> Usuarios
                </a>
                <a href="{{ url('/admin/proveedores') }}" class="{{ request()->is('admin/proveedores*') ? 'active-link' : '' }}">
                    <i class='bx bxs-truck'></i> Proveedores
                </a>
                <a href="{{ url('/admin/insumos') }}" class="{{ request()->is('admin/insumos*') ? 'active-link' : '' }}">
                    <i class='bx bx-box'></i> Insumos
                </a>
                <a href="{{ route('inventario.lotes.index') }}" class="{{ request()->is('inventario/lotes*') ? 'active-link' : '' }}">
                    <i class='bx bx-layer'></i> Lotes
                </a>
                <a href="{{ route('inventario.movimientos.historial') }}" class="{{ request()->is('inventario/movimientos*') ? 'active-link' : '' }}">
                    <i class='bx bx-transfer'></i> Movimientos
                </a>

                {{-- Dropdown Alertas y Reportes --}}
                <div class="nav-dropdown" id="dropdown-alertas-reportes">
                    <button class="nav-dropdown-btn {{ request()->is('alertas*') || request()->is('reportes*') ? 'active-dropdown' : '' }}"
                        onclick="toggleDropdown('dropdown-alertas-reportes')">
                        <i class='bx bx-bell'></i> Alertas y Reportes <i class='bx bx-chevron-down'></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('alertas.index') }}" class="{{ request()->is('alertas*') ? 'active-link' : '' }}">
                            <i class='bx bx-bell'></i> Alertas
                        </a>
                        <a href="{{ route('reportes.stock') }}" class="{{ request()->is('reportes/stock*') ? 'active-link' : '' }}">
                            <i class='bx bx-package'></i> Stock Actual
                        </a>
                        <a href="{{ route('reportes.consumo') }}" class="{{ request()->is('reportes/consumo*') ? 'active-link' : '' }}">
                            <i class='bx bx-history'></i> Consumo
                        </a>
                        <a href="{{ route('reportes.ingresos') }}" class="{{ request()->is('reportes/ingresos*') ? 'active-link' : '' }}">
                            <i class='bx bx-download'></i> Ingresos
                        </a>
                    </div>
                </div>

                <a href="{{ url('/admin/configuraciones') }}" class="{{ request()->is('admin/configuraciones*') ? 'active-link' : '' }}">
                    <i class='bx bx-cog'></i> Configuraciones
                </a>

                @elseif(Auth::user()->role_id === 2)
                <a href="{{ route('farmacia.dashboard') }}" class="{{ request()->is('farmacia/dashboard') ? 'active-link' : '' }}">
                    <i class='bx bx-home-alt'></i> Inicio Farmacia
                </a>
                <a href="{{ url('/admin/insumos') }}" class="{{ request()->is('admin/insumos*') ? 'active-link' : '' }}">
                    <i class='bx bx-box'></i> Insumos
                </a>
                <a href="{{ url('/admin/proveedores') }}" class="{{ request()->is('admin/proveedores*') ? 'active-link' : '' }}">
                    <i class='bx bxs-truck'></i> Proveedores
                </a>
                <a href="{{ route('inventario.lotes.index') }}" class="{{ request()->is('inventario/lotes*') ? 'active-link' : '' }}">
                    <i class='bx bx-layer'></i> Lotes
                </a>
                <a href="{{ route('inventario.movimientos.historial') }}" class="{{ request()->is('inventario/movimientos*') ? 'active-link' : '' }}">
                    <i class='bx bx-transfer'></i> Movimientos
                </a>

                {{-- Dropdown Alertas y Reportes --}}
                <div class="nav-dropdown" id="dropdown-alertas-reportes-farm">
                    <button class="nav-dropdown-btn {{ request()->is('alertas*') || request()->is('reportes*') ? 'active-dropdown' : '' }}"
                        onclick="toggleDropdown('dropdown-alertas-reportes-farm')">
                        <i class='bx bx-bell'></i> Alertas y Reportes <i class='bx bx-chevron-down'></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('alertas.index') }}" class="{{ request()->is('alertas*') ? 'active-link' : '' }}">
                            <i class='bx bx-bell'></i> Alertas
                        </a>
                        <a href="{{ route('reportes.stock') }}" class="{{ request()->is('reportes/stock*') ? 'active-link' : '' }}">
                            <i class='bx bx-package'></i> Stock Actual
                        </a>
                        <a href="{{ route('reportes.consumo') }}" class="{{ request()->is('reportes/consumo*') ? 'active-link' : '' }}">
                            <i class='bx bx-history'></i> Consumo
                        </a>
                        <a href="{{ route('reportes.ingresos') }}" class="{{ request()->is('reportes/ingresos*') ? 'active-link' : '' }}">
                            <i class='bx bx-download'></i> Ingresos
                        </a>
                    </div>
                </div>

                @elseif(Auth::user()->role_id === 3)
                <a href="{{ route('enfermeria.dashboard') }}" class="{{ request()->is('enfermeria/dashboard') ? 'active-link' : '' }}">
                    <i class='bx bx-home-alt'></i> Inicio Enfermería
                </a>
                <a href="#" class="{{ request()->is('enfermeria/pacientes*') ? 'active-link' : '' }}">
                    <i class='bx bx-user-plus'></i> Pacientes
                </a>
                <a href="{{ route('inventario.lotes.index') }}" class="{{ request()->is('inventario/lotes*') ? 'active-link' : '' }}">
                    <i class='bx bx-layer'></i> Lotes
                </a>
                <a href="{{ route('inventario.movimientos.historial') }}" class="{{ request()->is('inventario/movimientos*') ? 'active-link' : '' }}">
                    <i class='bx bx-transfer'></i> Movimientos
                </a>
                @endif

            </div>

            <div class="user-menu">
                <span class="user-greeting">
                    <div class="user-avatar-icon"><i class='bx bx-user'></i></div>
                    Hola, {{ Auth::user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
                    @csrf
                    <button type="submit" class="logout-btn"><i class='bx bx-log-out-circle'></i> Cerrar Sesión</button>
                </form>
            </div>
        </div>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

    <script>
        // Dropdown toggle
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('open');
        }

        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });

        // Hamburguesa mobile
        document.addEventListener('DOMContentLoaded', function() {
            const btnMenu = document.getElementById('mobile-menu-btn');
            const navWrapper = document.getElementById('nav-wrapper');
            if (btnMenu && navWrapper) {
                btnMenu.addEventListener('click', function() {
                    navWrapper.classList.toggle('active');
                    const icono = btnMenu.querySelector('i');
                    if (icono.classList.contains('bx-menu')) {
                        icono.classList.remove('bx-menu');
                        icono.classList.add('bx-x');
                    } else {
                        icono.classList.remove('bx-x');
                        icono.classList.add('bx-menu');
                    }
                });
            }
        });
    </script>
</body>

</html>