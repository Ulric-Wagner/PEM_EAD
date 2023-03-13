<?php
namespace Csupcyber\Pemead\Routers;

use Csupcyber\Pemead\Controlers\Session;
use Csupcyber\Pemead\Controlers\IOCleaner;
use Csupcyber\Pemead\Controlers\MessageToUser;
use Csupcyber\Pemead\Controlers\LoginForm;
use Csupcyber\Pemead\Controlers\LoginProcess;
use Csupcyber\Pemead\Controlers\RegisterForm;
use Csupcyber\Pemead\Controlers\SetPasswordForm;
use Csupcyber\Pemead\Controlers\Office;
use Csupcyber\Pemead\Controlers\AccountsManagement;
use Csupcyber\Pemead\Controlers\CoursesManagement;
use Csupcyber\Pemead\Controlers\SetUserProcess;
use Csupcyber\Pemead\Controlers\SetCourseProcess;


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
            $process = new SetUserProcess();
            $process->enrol();


        } elseif (isset($_GET['process']) && ($_GET['process'] === 'login')) {
            $process = new LoginProcess();
            $process->login();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'logout')) {
            $process = new LoginProcess();
            $process->logout();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'setPassword')) {
            $process = new SetUserProcess();
            $process->updatePassword();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'validUser')) {
            $process = new SetUserProcess();
            $process->valid();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'rejectUser')) {
            $process = new SetUserProcess();
            $process->reject();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'disableUser')) {
            $process = new SetUserProcess();
            $process->disable();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'createCourse')) {
            $process = new SetCourseProcess();
            $process->create();
        }

        if ((!isset($_GET['view'])
            || ($_GET['view'] === 'signup'))
            && ($_SESSION['authentication'] === 'none')) {
            $login = new LoginForm();
            $login->header();
            $login->navbar();
            $msg->error();
            $msg->warning();
            $msg->success();
            $login->body();
            $login->footer();
        } elseif (isset($_GET['view']) && ($_GET['view'] === 'setPassword')
            && ($_SESSION['authentication'] === 'authenticated')) {
            $setPassword = new SetPasswordForm();
            $setPassword->header();
            $setPassword->navbar();
            $msg->error();
            $msg->warning();
            $msg->success();
            $setPassword->body();
            $setPassword->footer();
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
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'accountsManagement')
        && ($_SESSION['authentication'] === 'authenticated')) {
        $accounts = new AccountsManagement();
        $accounts->header();
        $accounts->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $accounts->body();
        $accounts->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'coursesManagement')
        && ($_SESSION['authentication'] === 'authenticated')) {
        $courses = new CoursesManagement();
        $courses->header();
        $courses->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $courses->body();
        $courses->footer();
    } elseif (isset($_GET['view'])
    && ($_GET['view'] === 'signup')
    && ($_SESSION['authentication'] === 'authenticated')) {
    header('Location: ?view=office');
    } else {
        header('Location: ?view=signup');
    }
        
    }
}


