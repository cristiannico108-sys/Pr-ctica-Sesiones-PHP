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

        if ($usuario && password_verify($password, $usuario['hash'])) {
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