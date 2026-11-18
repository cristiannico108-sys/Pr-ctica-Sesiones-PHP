<?php
declare(strict_types=1);

namespace Controllers;

use Core\Pages;
use Core\Session;
use Models\UserModel;

final class UserController
{
    public function perfil(): void
    {
        // if (!Session::has('user_id')) {
        //     redirect('login');              LOS ELIMINO EN LA ETAPA 3
        // } 

        $usuario = (new UserModel())->findById((int) Session::get('user_id'));

        (new Pages())->render('user/perfil', ['usuario' => $usuario]);
    }
}