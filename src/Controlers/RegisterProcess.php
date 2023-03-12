<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class RegisterProcess
{
    public function __construct()
    {
        $this->db = new DataBase();
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
                strtoupper($_POST['RegisterNom']),
                ucfirst($_POST['RegisterPrenom']),
                $_POST['RegisterMatricule'],
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