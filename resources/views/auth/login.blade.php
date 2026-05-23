<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Salud</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* Animaciones */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(15, 23, 42, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(15, 23, 42, 0); }
            100% { box-shadow: 0 0 0 0 rgba(15, 23, 42, 0); }
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top right, #f1f5f9, #e2e8f0);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .login-card {
            background: #ffffff;
            padding: 3rem;
            border-radius: 24px;
            /* Sombra Premium Multinivel */
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                0 10px 10px -5px rgba(0, 0, 0, 0.04),
                0 0 40px rgba(15, 23, 42, 0.05);
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            animation: fadeInUp 0.8s ease-out; /* Animación de entrada */
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.05em;
        }

        .login-header p {
            color: #64748b;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .input-wrapper {
            position: relative;
            transition: all 0.3s ease;
        }

        .input-wrapper i {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.4rem;
            transition: color 0.3s ease;
        }

        .input-wrapper input {
            width: 100%;
            padding: 1rem 1rem 1rem 3.2rem;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            font-size: 1rem;
            color: #1e293b;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-sizing: border-box;
            background-color: #f8fafc;
        }

        .input-wrapper input:focus {
            background-color: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.1);
        }

        .input-wrapper input:focus + i {
            color: #0f172a;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #64748b;
            cursor: pointer;
            margin: 1.5rem 0;
            font-weight: 500;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            accent-color: #0f172a;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            background-color: #0f172a;
            color: #ffffff;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background-color: #1e293b;
            transform: translateY(-2px);
            animation: pulse 1.5s infinite; /* Animación de pulso al pasar el mouse */
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-container {
            background-color: #fff1f2;
            border-left: 4px solid #e11d48;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
            animation: fadeInUp 0.4s ease;
        }

        .error-container ul {
            margin: 0;
            padding-left: 1rem;
            color: #9f1239;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h2>¡Hola de nuevo!</h2>
            <p>Accede a tu panel de control</p>
        </div>

        @if ($errors->any())
            <div class="error-container">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf 
            
            <div class="form-group">
                <label for="email">Usuario / Email</label>
                <div class="input-wrapper">
                    <i class='bx bx-user-circle'></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="correo@dominio.com" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-wrapper">
                    <i class='bx bx-key'></i>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <label class="remember-me">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                Mantener sesión iniciada
            </label>

            <button type="submit" class="btn-login">
                Entrar ahora <i class='bx bx-right-arrow-alt'></i>
            </button>
        </form>
    </div>

</body>
</html>