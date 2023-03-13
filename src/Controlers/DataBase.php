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
        $this->LOCATION_REGISTER_DBPREPARE_ERROR = "location: ?view=register&error=dbPrepare";
        $this->LOCATION_SETPASSWORD_DBPREPARE_ERROR = "location: ?view=setPassword&error=dbPrepare";
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

    public function createUser($grade, $nom, $prenom, $matricule, $mail, $password)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sha256 = $this->cipher->sha256($this->iocleaner->inputFilter($password));
        $sql = 'INSERT INTO users (`Grade`, `Nom`, `Prenom`, `Matricule`, `Mail`, `Sha256`)
                VALUES (:Grade, :Nom, :Prenom, :Matricule, :Mail, :Sha256);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Grade' => $this->iocleaner->inputFilter($grade),
                                   'Nom' => $this->iocleaner->inputFilter($nom),
                                   'Prenom' => $this->iocleaner->inputFilter($prenom),
                                   'Matricule' => $this->iocleaner->inputFilter($matricule),
                                   'Mail' => $this->iocleaner->inputFilter($mail),
                                   'Sha256' => $sha256));
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
                header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
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
                header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
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
                header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return $reponse->fetch()['Statut'];
                   
            } catch (PDOException $e) {
                //Wait
            }
        }

    public function updateUserPassword($mail, $password)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sha256 = $this->cipher->sha256($this->iocleaner->inputFilter($password));
        $sql = 'UPDATE users SET Sha256 = :Sha256 WHERE Mail = :Mail;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_SETPASSWORD_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Mail' => $this->iocleaner->inputFilter($mail),
                                   'Sha256' => $sha256));
            header('location: ?view=office&success=passwordChanged');
        } catch (PDOException $e) {
            //wait
        }
    }

    public function getUserInfos($mail)
    {
        $sql = 'SELECT * FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                $infos = $reponse->fetch();
                $_SESSION['UID'] = $infos['UID'];
                $_SESSION['Grade'] = $infos['Grade'];
                $_SESSION['Nom'] = $infos['Nom'];
                $_SESSION['Prenom'] = $infos['Prenom'];
                $_SESSION['Matricule'] = $infos['Matricule'];

                   
            } catch (PDOException $e) {
                //Wait
            }
    }

    public function getNewUsers()
    {
        //retourne une array contenant les information sur les utilisateurs en attente de validation
        $sql = 'SELECT * FROM `users` WHERE `Statut` = 0';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //Wait
            }
    }

    public function getEnabledUsers()
    {
        //retourne une array contenant les information sur les utilisateurs actifs
        $sql = 'SELECT * FROM `users` WHERE `Statut` = 1';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //Wait
            }
    }

    public function getCourses()
    {
        //retourne une array contenant les information sur les utilisateurs actifs
        $sql = 'SELECT * FROM `Cours`';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //Wait
            }
    }

    public function validUser($uid)
    {
        // validation d'un nouvel uilisateur
        $sql = 'UPDATE users SET Statut = :Statut WHERE UID = :UID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_SETPASSWORD_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('UID' => $this->iocleaner->inputFilter($uid),
                                   'Statut' => '1'));
        } catch (PDOException $e) {
            //wait
        }
    }

    public function disableUser($uid)
    {
        // validation d'un nouvel uilisateur
        $sql = 'UPDATE users SET Statut = :Statut WHERE UID = :UID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_SETPASSWORD_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('UID' => $this->iocleaner->inputFilter($uid),
                                   'Statut' => '0'));
        } catch (PDOException $e) {
            //wait
        }
    }

    public function rejectUser($uid)
    {
        // suppression de l'uilisateur rejeté
        $sql = 'DELETE FROM users WHERE UID = :UID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_SETPASSWORD_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('UID' => $this->iocleaner->inputFilter($uid)));
        } catch (PDOException $e) {
            //wait
        }
    }

    public function createCourse($cours)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'INSERT INTO cours (`Cours`)
                VALUES (:Cours);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_REGISTER_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Cours' => $this->iocleaner->inputFilter($cours)));
            header('location: ?view=coursesManagement&success=done');
        } catch (PDOException $e) {

            //Cours déjà existant
            $patern = "#pour la clef 'Cours'$#";
            $courseAlreadyUsed = preg_match($patern, $e->getMessage());
            if ($courseAlreadyUsed) {
                header("location: ?view=coursesManagement&error=coursAlreadyUsed&cours=$cours");
            }

        }

    }
}
