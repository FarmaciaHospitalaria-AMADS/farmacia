<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar la vista del formulario
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar las credenciales
public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Verificamos si el checkbox fue marcado. 
        // Si el usuario lo marcó, $remember será true.
        $remember = $request->filled('remember');

        // Pasamos $remember como segundo parámetro al Auth::attempt
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            return match ($user->role_id) {
                1 => redirect()->route('admin.dashboard'),
                2 => redirect()->route('farmacia.dashboard'),
                3 => redirect()->route('enfermeria.dashboard'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }
    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
