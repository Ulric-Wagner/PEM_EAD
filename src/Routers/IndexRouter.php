<?php
namespace Csupcyber\Pemead\Routers;

use Csupcyber\Pemead\Controlers\Session;
use Csupcyber\Pemead\Controlers\IOCleaner;
use Csupcyber\Pemead\Controlers\LoginForm;
use Csupcyber\Pemead\Controlers\RegisterForm;

class IndexRouter{
    public function __construct()
    {
        $session = new Session();
        $session->open();

        $ioCleaner = new IOCleaner();
        $ioCleaner->sqliFilter();
        $ioCleaner->xssFilter();

        if (!isset($_GET['action'])
            || ($_GET['action'] === 'signup')
            && $_SESSION['authentication'] === 'none') {
            $login = new LoginForm();
            $login->header();
            $login->navbar();
            $login->body();
            $login->footer();
        } elseif (($_GET['action'] === 'register')
            && ($_SESSION['authentication'] === 'none')) {
            $register = new RegisterForm();
            $register->header();
            $register->navbar();
            $register->body();
            $register->footer();
        }
    }
}


