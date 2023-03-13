<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class SetPasswordProcess
{
    public function __construct()
    {
        $this->db = new DataBase();
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

}