<?php
declare(strict_types=1);

namespace Controllers;

use Core\Pages;
use Core\Session;
use Models\UserModel;

final class AuthController
{
    public function showLogin(): void
    {
        (new Pages())->render('auth/login', ['error' => null, 'info' => null]);
    }

    public function login(): void
    {
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        $usuario = (new UserModel())->findByEmail($email);

        // OJO: Abre src/Models/UserModel.php y mira si el campo se llama 'password' o 'password_hash'.
        // Si se llama 'password_hash', cambia $usuario['password'] por $usuario['password_hash'] aquí abajo:
        if ($usuario && password_verify($password, $usuario['password'])) {
            Session::set('user_id', $usuario['id']);
            redirect('perfil');
        }

        redirect('login');
    }

    public function logout(): void
    {
        Session::destruir();
        redirect('login');
    }
}