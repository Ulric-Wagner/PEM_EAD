<?php
namespace Csupcyber\Pemead\Routers;

use Csupcyber\Pemead\Controlers\Session;
use Csupcyber\Pemead\Controlers\IOCleaner;

class IndexRouter{
    public function __construct()
    {
        $session = new Session();
        $session->open();

        $ioCleaner = new IOCleaner();
        $ioCleaner->sqliFilter();
        $ioCleaner->xssFilter();
    }
}


