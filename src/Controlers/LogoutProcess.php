<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\Session;

class LogoutProcess
{
    public function logout()
    {
        $session = new Session();
        $session->close();
        header('Location: ?view=signup&warning=disconnected');
    }

}

