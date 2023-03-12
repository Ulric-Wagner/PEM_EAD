<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\IOCleaner;
use Csupcyber\Pemead\Controlers\Cipher;
use \PDO;
use \PDOException;

class DataBase
{
    public function __construct()
    {
        $this->iocleaner = new IOCleaner();
        $this->cipher = new Cipher();
        $this->connect();
    }

    public function connect()
    {
        //lecture du fichier ini/bdd.ini
        $iniArray = parse_ini_file("ini/bdd.ini");
        $dbHost = $iniArray['dbhost'];
        $dbName = $iniArray['dbname'];
        $dbCharSet = $iniArray['dbcharset'];
        $dblogin = $iniArray['dblogin'];
        $dbPW = $iniArray['dbPW'];
        
        
        try {
        $this->bdd = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.';charset='.$dbCharSet.'', $dblogin, $dbPW);
        $this->bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            header("location: ?view=signup&error=dbConnect");
        }
    }

    public function createUser($nom, $prenom, $matricule, $mail, $password)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sha256 = $this->cipher->sha256($password);
        $sql = 'INSERT INTO users (`Nom`, `Prenom`, `Matricule`, `Mail`, `Sha256`)
                VALUES (:Nom, :Prenom, :Matricule, :Mail, :Sha256);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header("location: ?view=register&error=dbPrepare");
        }
        try {
            $insert->execute(array('Nom' => $this->iocleaner->inputFilter($nom),
                                   'Prenom' => $this->iocleaner->inputFilter($prenom),
                                   'Matricule' => $this->iocleaner->inputFilter($matricule),
                                   'Mail' => $this->iocleaner->inputFilter($mail),
                                   'Sha256' => $this->iocleaner->inputFilter($sha256)));
            header('location: ?view=signup&success=registred');
        } catch (PDOException $e) {

            //Mail déjà existant
            $patern = "#pour la clef 'Mail'$#";
            $mailAlreadyUsed = preg_match($patern, $e->getMessage());
            if ($mailAlreadyUsed) {
                header("location: ?view=register&error=mailAlreadyUsed&mail=$mail");
            }

            //Matricule déjà existant
            $patern = "#pour la clef 'Matricule'$#";
            $matriculeAlreadyUsed = preg_match($patern, $e->getMessage());
            if ($matriculeAlreadyUsed) {
                header("location: ?view=register&error=matriculeAlreadyUsed&matricule=$matricule");
            }
        }

    }

    public function verifyRegistration($mail)
    {
        $sql = 'SELECT Mail FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header("location: ?view=register&error=dbPrepare");
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return !empty($reponse->fetch());
                   
            } catch (PDOException $e) {
                //Wait
            }
    }

    public function verifyPassword($mail, $password)
    {
        $sql = 'SELECT Sha256 FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header("location: ?view=register&error=dbPrepare");
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return ($reponse->fetch()['Sha256'] === $this->cipher->sha256($password));
            } catch (PDOException $e) {
                //Wait
            }
        }

    public function verifyStatus($mail)
    {
        $sql = 'SELECT Statut FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header("location: ?view=register&error=dbPrepare");
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return $reponse->fetch()['Statut'];
                   
            } catch (PDOException $e) {
                //Wait
            }
        }

    

    public function getPromotions()
    {
        //wait
    }
}