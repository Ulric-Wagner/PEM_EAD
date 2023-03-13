<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class LoginProcess
{
    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function login()
    {
        if (isset($_POST['LoginEmail'])
        && $this->verifyMailFormat($_POST['LoginEmail'])
        && isset($_POST['LoginPassword'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])
        && $this->verifyRegistration($_POST['LoginEmail'])
        && $this->verifyStatus($_POST['LoginEmail'])
        && $this->verifyPassword($_POST['LoginEmail'], $_POST['LoginPassword'])) {
            header('location: ?view=office&success=logedIn');
            $_SESSION['authentication'] = 'authenticated';
            $_SESSION['Mail'] = $_POST['LoginEmail'];
            $this->getUserInfos($_SESSION['Mail']);
        } elseif (!$this->verifyMailFormat($_POST['LoginEmail'])) {
            header('Location: ?view=signup&error=mailFormat');
        } elseif (!$this->verifyRegistration($_POST['LoginEmail'])) {
            header('Location: ?view=signup&error=RejectedAuth');
        } elseif (!$this->verifyStatus($_POST['LoginEmail'])) {
            header('Location: ?view=signup&error=unvalidatedUser');
        } elseif (!$this->verifyPassword($_POST['LoginEmail'], $_POST['LoginPassword'])) {
            header('Location: ?view=signup&error=RejectedAuth');
        }
    }

    public function verifyMailFormat($mail)
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    public function verifyCSRF($token)
    {
        return $token === $_SESSION['CSRFToken'];
    }

    public function verifyRegistration($mail)
    {
        return $this->db->verifyRegistration($mail);
    }

    public function verifyStatus($mail)
    {
        return $this->db->verifyStatus($mail);
    }

    public function verifyPassword($mail, $password)
    {
        return $this->db->verifyPassword($mail, $password);
    }

    public function getUserInfos($mail)
    {
        return $this->db->getUserInfos($mail);
    }

}

