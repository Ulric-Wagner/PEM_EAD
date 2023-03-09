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

        if (!isset($_GET['action'])) {
            $login = new LoginForm();
            $login->header();
            $login->navbar();
            $login->body();
            $login->footer();
        }
    }
}


