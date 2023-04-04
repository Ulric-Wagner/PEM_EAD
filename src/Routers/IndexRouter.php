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
use Csupcyber\Pemead\Controlers\GroupementsManagement;
use Csupcyber\Pemead\Controlers\CoursesManagement;
use Csupcyber\Pemead\Controlers\SetUserProcess;
use Csupcyber\Pemead\Controlers\SetCourseProcess;
use Csupcyber\Pemead\Controlers\PromotionsManagement;
use Csupcyber\Pemead\Controlers\MatieresCreation;
use Csupcyber\Pemead\Controlers\MatieresManagement;
use Csupcyber\Pemead\Controlers\SupportsSubmition;
use Csupcyber\Pemead\Controlers\FilesManagement;
use Csupcyber\Pemead\Controlers\MatieresFeeding;
use Csupcyber\Pemead\Controlers\MatieresValidation;
use Csupcyber\Pemead\Controlers\Learning;
use Csupcyber\Pemead\Controlers\EvalTemplate;


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
        } elseif (isset($_GET['process'])
        && ($_GET['process'] === 'setUser')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetUserProcess();
            $process->edit();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'validUser')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetUserProcess();
            $process->valid();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'rejectUser')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetUserProcess();
            $process->reject();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'disableUser')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetUserProcess();
            $process->disable();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'createCourse')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetCourseProcess();
            $process->createCourse();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'createGroupement')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetCourseProcess();
            $process->createGroupement();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'renameGroupement')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetCourseProcess();
            $process->renameGroupement();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'removeGroupement')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetCourseProcess();
            $process->removeGroupement();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'renameCourse')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetCourseProcess();
            $process->renameCourse();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'removeCourse')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
            $process = new SetCourseProcess();
            $process->removeCourse();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'createPromotion')
        && isset($_SESSION['Pilote'])
        && ($_SESSION['Pilote'] === 'Pilote')) {
            $process = new SetCourseProcess();
            $process->createPromotion();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'createMatiere')
        && isset($_SESSION['Instructeur'])
        && ($_SESSION['Instructeur'] === 'Instructeur')) {
            $process = new SetCourseProcess();
            $process->createMatiere();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'renamePromotion')
        && isset($_SESSION['Pilote'])
        && ($_SESSION['Pilote'] === 'Pilote')) {
            $process = new SetCourseProcess();
            $process->renamePromotion();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'removePromotion')
        && isset($_SESSION['Pilote'])
        && ($_SESSION['Pilote'] === 'Pilote')) {
            $process = new SetCourseProcess();
            $process->removePromotion();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'sendFile')
        && isset($_SESSION['Instructeur'])
        && ($_SESSION['Instructeur'] === 'Instructeur')) {
            $process = new FilesManagement();
            $process->fileUpload();
        } elseif (isset($_GET['process']) && ($_GET['process'] === 'download')) {
            $process = new FilesManagement();
            $process->download();
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
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
        $accounts = new AccountsManagement();
        $accounts->header();
        $accounts->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $accounts->body();
        $accounts->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'coursesManagement')
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
        $courses = new CoursesManagement();
        $courses->header();
        $courses->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $courses->body();
        $courses->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'groupementsManagement')
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Admin'])
        && ($_SESSION['Admin'] === 'Admin')) {
        $courses = new GroupementsManagement();
        $courses->header();
        $courses->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $courses->body();
        $courses->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'promotionsManagement')
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Pilote'])
        && ($_SESSION['Pilote'] === 'Pilote')) {
        $promotions = new PromotionsManagement();
        $promotions->header();
        $promotions->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $promotions->body();
        $promotions->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'matieresCreation')
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Instructeur'])
        && ($_SESSION['Instructeur'] === 'Instructeur')) {
        $matieres = new MatieresCreation();
        $matieres->header();
        $matieres->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $matieres->body();
        $matieres->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'matieresManagement')
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Instructeur'])
        && ($_SESSION['Instructeur'] === 'Instructeur')) {
        $matieres = new MatieresManagement();
        $matieres->header();
        $matieres->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $matieres->body();
        $matieres->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'supportsSubmition')
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Instructeur'])
        && ($_SESSION['Instructeur'] === 'Instructeur')) {
        $supports = new SupportsSubmition();
        $supports->header();
        $supports->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $supports->body();
        $supports->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'matieresFeeding')
        && ($_SESSION['authentication'] === 'authenticated')
        && isset($_SESSION['Instructeur'])
        && ($_SESSION['Instructeur'] === 'Instructeur')) {
        $matieres = new MatieresFeeding();
        $matieres->header();
        $matieres->navbar();
        $msg->error();
        $msg->warning();
        $msg->success();
        $matieres->body();
        $matieres->footer();
    } elseif (isset($_GET['view']) && ($_GET['view'] === 'matieresValidation')
    && ($_SESSION['authentication'] === 'authenticated')
    && isset($_SESSION['Pilote'])
        && ($_SESSION['Pilote'] === 'Pilote')) {
    $matieres = new MatieresValidation();
    $matieres->header();
    $matieres->navbar();
    $msg->error();
    $msg->warning();
    $msg->success();
    $matieres->body();
    $matieres->footer();
} elseif (isset($_GET['view']) && ($_GET['view'] === 'learning')
    && ($_SESSION['authentication'] === 'authenticated')
    && isset($_SESSION['Student'])
        && ($_SESSION['Student'] === 'Student')) {
    $matieres = new Learning();
    $matieres->header();
    $matieres->navbar();
    $msg->error();
    $msg->warning();
    $msg->success();
    $matieres->body();
    $matieres->footer();
} elseif (isset($_GET['view']) && ($_GET['view'] === 'evalTemplate')
    && ($_SESSION['authentication'] === 'authenticated')
    && isset($_SESSION['Instructeur'])
        && ($_SESSION['Instructeur'] === 'Instructeur')) {
    $eval = new EvalTemplate();
    $eval->header();
    $eval->navbar();
    $msg->error();
    $msg->warning();
    $msg->success();
    $eval->body();
    $eval->footer();
} elseif (isset($_GET['view'])
    && ($_GET['view'] === 'signup')
    && ($_SESSION['authentication'] === 'authenticated')) {
    header('Location: ?view=office');
    } elseif (!isset($_GET['view'])
    && isset($_GET['process'])
    && ($_SESSION['authentication'] === 'authenticated')) {
        //pass
    } else {
        header('Location: ?view=signup');
    }
        
    }
}


