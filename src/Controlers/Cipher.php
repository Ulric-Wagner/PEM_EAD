<?php
namespace Csupcyber\Pemead\Controlers;

class Cipher
{
    public function generateKey()
    {
        //lecture du fichier ini/encrypt.ini
        $iniArray = parse_ini_file("ini/encrypt.ini");
        $salt = $iniArray['salt'];
        $keyLength = $iniArray['keylength'] / 2;
        $iterations = $iniArray['iterations'];
        $digestAlgo = $iniArray['digest_algo'];
        //génération d'un password aléatoire
        $password = openssl_random_pseudo_bytes(14);
        return bin2hex(openssl_pbkdf2($password, $salt, $keyLength, $iterations, $digestAlgo));
    }
    
    public function generateToken()
    {
        //génération d'un Token qui sera utiliser pour la protection anti-CSRF
        $_SESSION['CSRFToken'] = $this->generateKey();
    }

    public function verifyToken()
    {
        if (!empty($_POST) && (strval($_POST['CSRFToken']) !== strval($_SESSION['CSRFToken']))){
            //vérification du token anti CSRF
            echo '<H4> Erreur, accès refusé </H4>';
            exit();
        }
    }

}
