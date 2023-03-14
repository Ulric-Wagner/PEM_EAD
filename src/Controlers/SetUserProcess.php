<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class SetUserProcess
{
    public function __construct()
    {
        $view = $_GET['view'];
        $this->db = new DataBase();
        $this->NOK = "Location: ?view=$view&error=nok";
    }

    public function valid()
    {
        if (isset($_POST['ValidatedUser'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $validation = new DataBase();
        $validation->validUser($_POST['ValidatedUser']);
        
        } else {
            header($this->NOK);
        }
    }

    public function reject()
    {
        if (isset($_POST['RejectedUser'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $validation = new DataBase();
        $validation->rejectUser($_POST['RejectedUser']);
        
        } else {
            header($this->NOK);
        }
    }

    public function updatePassword()
    {
        if (isset($_POST['CurrentPassword'])
        && $this->verifyPassword($_SESSION['Mail'], $_POST['CurrentPassword'])
        && isset($_POST['NewPassword'])
        && $this->verifyPasswordComplexity($_POST['NewPassword'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
            $this->db->updateUserPassword($_SESSION['Mail'], $_POST['NewPassword']);
        } elseif (!$this->verifyPasswordComplexity($_POST['NewPassword'])) {
            header('Location: ?view=setPassword&error=passwordComplexity');
        }
    }

    public function verifyPassword($mail, $password)
    {
        return $this->db->verifyPassword($mail, $password);
    }

    public function verifyPasswordComplexity($password)
    {
        /*
        Explication de l'expression régulière :

        ^ : Début de la chaîne de caractères.
        (?=.*[a-z]) : Au moins une lettre minuscule.
        (?=.*[A-Z]) : Au moins une lettre majuscule.
        (?=.*\d) : Au moins un chiffre.
        (?=.*[!@\#$%^&*()_+={}[\]\\|:;'<>,.?/~])` : Au moins un caractère spécial
        (\ devant le # qui est utilisé comme délimiter).
        (?!.*\s) : Aucun espace blanc autorisé.
        .{8,} : Au moins 8 caractères.
        $ : Fin de la chaîne de caractères.
        */
        $patern = "#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@\#$%^&*()_+={}[\]\\|:;'<>,.?/~`])(?!.*\s).{8,}$#";
        return preg_match($patern, $password);
    }

    public function verifyCSRF($token)
    {
        return $token === $_SESSION['CSRFToken'];
    }

    public function enrol()
    {
        if (isset($_POST['RegisterNom'])
        && isset($_POST['RegisterPrenom'])
        && isset($_POST['RegisterMatricule'])
        && isset($_POST['RegisterMail'])
        && $this->verifyMailFormat($_POST['RegisterMail'])
        && isset($_POST['RegisterPassword'])
        && $this->verifyPasswordComplexity($_POST['RegisterPassword'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
            $this->db->createUser(
                strtoupper($_POST['RegisterGrade']),
                strtoupper($_POST['RegisterNom']),
                ucfirst($_POST['RegisterPrenom']),
                $_POST['RegisterMatricule'],
                $_POST['RegisterRole'],
                $_POST['RegisterCourse'],
                $_POST['RegisterPromotion'],
                strtolower($_POST['RegisterMail']),
                $_POST['RegisterPassword']
            );
        } elseif (!$this->verifyMailFormat($_POST['RegisterMail'])) {
            header('Location: ?view=register&error=mailFormat');
        } elseif (!$this->verifyPasswordComplexity($_POST['RegisterPassword'])) {
            header('Location: ?view=register&error=passwordComplexity');
        }
    }

    public function verifyMailFormat($mail)
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    public function disable()
    {
        if (isset($_POST['DisabledUser'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $disable = new DataBase();
        $disable->disableUser($_POST['DisabledUser']);
        
        } else {
            header($this->NOK);
        }
    }

}
