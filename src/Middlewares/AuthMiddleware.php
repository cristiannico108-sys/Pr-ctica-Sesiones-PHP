<?php
declare(strict_types=1);

namespace Middlewares;

use Core\Session;

final class AuthMiddleware
{
    // Envuelve una acción con el middleware.
    public static function proteger(array $accion): callable
    {
        return function (...$params) use ($accion) {
            (new self())->handle();   // 1º el middleware
            $accion[0] = new $accion[0]();  // si le ha dejado pasar, esta línea crea el objeto del controlador
            return call_user_func_array($accion, $params);
        };
    }

    public function handle(): void
    {
        // Si no ha iniciado sesión --> login
        if (!Session::has('user_id')) {
            redirect('login');
        }
    }
}