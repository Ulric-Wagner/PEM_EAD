<?php
namespace Csupcyber\Pemead\Routers;

use Csupcyber\Pemead\Controlers\Session;
use Csupcyber\Pemead\Controlers\IOCleaner;
use Csupcyber\Pemead\Controlers\MessageToUser;
use Csupcyber\Pemead\Controlers\LoginForm;
use Csupcyber\Pemead\Controlers\LoginProcess;
use Csupcyber\Pemead\Controlers\LogoutProcess;
use Csupcyber\Pemead\Controlers\RegisterForm;
use Csupcyber\Pemead\Controlers\RegisterProcess;
use Csupcyber\Pemead\Controlers\Office;


class IndexRouter{
    public function __construct()
    {
        $session = new Session();
        $session->open();

        $ioCleaner = new IOCleaner();
        $ioCleaner->sqliFilter();
        $ioCleaner->xssFilter();

        $msg = new MessageToUser();

        if (isset($_GET['process']) && ($_GET['process'] === 'register')) {
            $process = new RegisterProcess();
            $process->enrol();


        } elseif (isset($_GET['process']) && ($_GET['process'] === 'login')) {
            $process = new LoginProcess();
            $process->login();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'logout')) {
            $process = new LogoutProcess();
            $process->logout();
        }

        if (!isset($_GET['view'])
            || ($_GET['view'] === 'signup')
            && $_SESSION['authentication'] === 'none') {
            $login = new LoginForm();
            $login->header();
            $login->navbar();
            $msg->error();
            $msg->warning();
            $msg->success();
            $login->body();
            $login->footer();
        } elseif (isset($_GET['view']) && ($_GET['view'] === 'register')
            && ($_SESSION['authentication'] === 'none')) {
            $register = new RegisterForm();
            $register->header();
            $register->navbar();
            $msg->error();
            $msg->warning();
            $msg->success();
            $register->body();
            $register->footer();
        } elseif (isset($_GET['view']) && ($_GET['view'] === 'office')
        && ($_SESSION['authentication'] === 'authenticated')) {
        $office = new Office();
        $office->header();
        $office->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $office->body();
        $office->footer();
    }
        
    }
}


