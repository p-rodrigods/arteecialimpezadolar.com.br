<?php

namespace mf\Controller;

session_start();

define('SESSION_TIMEOUT', 1800); // 30 minutes
define('BASE_URL', '/admin');

if(isset($_SESSION['ultimoAcesso'])) {
    if(time() - $_SESSION['ultimoAcesso'] > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL);
        exit();
    }
}

class Auth 
{
   public static function isLogged()
   {
       return isset($_SESSION['usuario']);
   }

    public static function requireLogin()
    {
         if (!self::isLogged()) {
              header('Location: /admin');
              exit();
         }
    }

    public static function login($usuario)
    {
         $_SESSION['usuario'] = $usuario['id'];
         $_SESSION['ultimoAcesso'] = time();
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /admin');
        exit();
    }


}