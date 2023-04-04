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
        if (isset($_GET['view'])){
            $view = $_GET['view'];
        } else {
            $view = "office";
        }
        $this->DONE = "Location: ?view=$view&success=done";
        $this->DBNOK = "Location: ?view=$view&error=DBNOK";
        $this->LOCATION_DBPREPARE_ERROR = "location: ?view=$view&error=dbPrepare";
        $this->iocleaner = new IOCleaner();
        $this->cipher = new Cipher();
        $this->connect();
        if (isset($_POST['RegisterGrade'])
            && isset($_POST['RegisterNom'])
            && isset($_POST['RegisterPrenom'])
            && isset($_POST['RegisterMatricule'])
            && isset($_POST['RegisterDateOfBirth'])
            && isset($_POST['RegisterMail'])
            && isset($_POST['RegisterPassword'])
            ) {
        $this->registerGrade = $this->iocleaner->inputFilter(strtoupper($_POST['RegisterGrade']));
        $this->registerNom = $this->iocleaner->inputFilter(strtoupper($_POST['RegisterNom']));
        $this->registerPrenom = $this->iocleaner->inputFilter(ucfirst($_POST['RegisterPrenom']));
        $this->registerMatricule = $this->iocleaner->inputFilter($_POST['RegisterMatricule']);
        $this->registerDateOfBirth = $this->iocleaner->inputFilter($_POST['RegisterDateOfBirth']);
        $this->registerMail = $this->iocleaner->inputFilter(strtolower($_POST['RegisterMail']));
        $this->registerPassword = $this->cipher->sha256($this->iocleaner->inputFilter($_POST['RegisterPassword']));
        }

        if (isset($_POST['RegisterRole'])) {
            $this->registerRole = $this->iocleaner->inputFilter($_POST['RegisterRole']);
        }

        if (isset($_POST['RegisterGroupement'])) {
            $this->registerGroupement = $this->iocleaner->inputFilter($_POST['RegisterGroupement']);
        }

        if (isset($_POST['RegisterCourse'])) {
            $this->registerCourse = $this->iocleaner->inputFilter($_POST['RegisterCourse']);
        }

        if (isset($_POST['RegisterPromotion'])) {
            $this->registerPromotion = $this->iocleaner->inputFilter($_POST['RegisterPromotion']);
        }
        
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

    public function createUser()
    {
        //Si l'utilisateur est le premier à s'enregister et qu'il n'est pas élève le
        //comptes est actif et administrateur.

        $count = $this->countUsers();
        if ($count < 1) {
            $statut = 0;
        } else {
            $statut = 1;
        }

        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'INSERT INTO users (`Grade`, `Nom`, `Prenom`, `Matricule`, `DateOfBirth`, `Mail`, `Sha256`)
                VALUES (:Grade, :Nom, :Prenom, :Matricule, :DoB, :Mail, :Sha256);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Grade' => $this->registerGrade,
                                   'Nom' =>$this->registerNom,
                                   'Prenom' => $this->registerPrenom,
                                   'Matricule' => $this->registerMatricule,
                                   'DoB' => $this->registerDateOfBirth,
                                   'Mail' => $this->registerMail,
                                   'Sha256' => $this->registerPassword));
            if ($statut) {
                header('location: ?view=signup&success=registred');
            } else {
                header('location: ?view=signup&success=firstRegistred');
            }
        } catch (PDOException $e) {

            //Mail déjà existant
            $patern = "#pour la clef 'Mail'$#";
            $mailAlreadyUsed = preg_match($patern, $e->getMessage());
            if ($mailAlreadyUsed) {
                header("location: ?view=register&error=mailAlreadyUsed&mail=$this->registerMail");
            } else {
                //Matricule déjà existant
                $patern = "#pour la clef 'Matricule'$#";
                $matriculeAlreadyUsed = preg_match($patern, $e->getMessage());
                if ($matriculeAlreadyUsed) {
                    header("location: ?view=register&error=matriculeAlreadyUsed&matricule=$this->registerMatricule");
                } else {
                    //erreur inatendue
                    header($this->DBNOK);
                }
            }

            
            
        }

        if (!$statut) {
            //activation du compte du premier utilisateur
            $this->validUser(
                $this->getUserID($this->registerMail)
            );
            // déclaration de l'administrateur
            $this->setRoleAdministrateur(
                $this->getUserID($this->registerMail)
            );
        }

        if ($this->registerRole === "Pilote"
        && $this->registerCourse != "None") {
            $this->setRolePilote(
                $this->getUserID($this->registerMail),
                $this->registerCourse
            );
        } elseif ($this->registerRole === "Pilote"
        && $this->registerCourse === "None") {
            header("Location: ?view=register&error=noCourse");
        }

        if ($this->registerRole === "Instructeur"
        && $this->registerGroupement != "None") {
            $this->setRoleInstructor(
                $this->getUserID($this->registerMail),
                $this->registerGroupement);
        } elseif ($this->registerRole === "Instructeur"
        && $this->registerGroupement === "None") {
            header("Location: ?view=register&error=noGroupement");
        }

        if ($this->registerRole === "Student"
        && $this->registerPromotion != "None") {
            $this->setRoleStudent(
                $this->getUserID($this->registerMail),
                $this->registerPromotion
            );
        } elseif ($this->registerRole === "Student"
        && $this->registerPromotion === "None") {
            header("Location: ?view=register&error=noPromotion");
        }

    }

    public function getUserID($mail)
        {
            $sql = 'SELECT `UID` FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return $reponse->fetch()['UID'];

                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
        }

        public function setRoleInstructor($uid, $cid)
        {
            $sql = "INSERT INTO `instructeurs` (`UID`, `GID`)
            VALUE (:UID, :GID);";
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid,
                                        'GID' => $cid));

                   
            } catch (PDOException $e) {
                //Pas de GID
                $patern = "#for column 'GID' at row 1$#";
                $noCID = preg_match($patern, $e->getMessage());
                if ($noCID) {
                    //pass
                } else {
                //erreur inatendue
                header($this->DBNOK);
                }
            }
        }

        public function setRolePilote($uid, $cid)
        {
            $sql = "INSERT INTO `pilotes` (`UID`, `CID`)
            VALUE (:UID, :CID);";
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid,
                                        'CID' => $cid));

                   
            } catch (PDOException $e) {
                //Pas de CID
                $patern = "#for column 'CID' at row 1$#";
                $noCID = preg_match($patern, $e->getMessage());
                if ($noCID) {
                    //pass
                } else {
                //erreur inatendue
                header($this->DBNOK);
                }
    
            }

            $this->setRoleInstructor(
                $uid,
                $this->getCourseGID($cid)
            );
        }

        public function setRoleStudent($uid, $pid)
        {
            $sql = "INSERT INTO `students` (`UID`, `PID`)
            VALUE (:UID, :PID);";
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid,
                                        'PID' => $pid));

                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
        }

        public function setRoleAdministrateur($uid)
        {
            $sql = "INSERT INTO `administrateurs` (`UID`)
            VALUE (:UID);";
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));

                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
        }

        public function countUsers()
        {
            $sql = 'SELECT COUNT(*) FROM `users`;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetch()['COUNT(*)'];
                

                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
        }

    public function verifyRegistration($mail)
    {
        $sql = 'SELECT Mail FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return !empty($reponse->fetch());
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function verifyPassword($mail, $password)
    {
        $sql = 'SELECT Sha256 FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return ($reponse->fetch()['Sha256'] === $this->cipher->sha256($password));
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
        }

    public function verifyStatus($mail)
    {
        $sql = 'SELECT Statut FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                return $reponse->fetch()['Statut'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
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
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Mail' => $this->iocleaner->inputFilter($mail),
                                   'Sha256' => $sha256));
            header('location: ?view=office&success=passwordChanged');
        } catch (PDOException $e) {
            //erreur inatendue
            header($this->DBNOK);
        }
    }

    public function getUserInfos($mail)
    {
        $sql = 'SELECT * FROM `users` WHERE `Mail` LIKE :Mail;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('Mail' => $mail));
                $infos = $reponse->fetch();
                $_SESSION['UID'] = $infos['UID'];
                $_SESSION['Grade'] = $infos['Grade'];
                $_SESSION['Nom'] = $infos['Nom'];
                $_SESSION['Prenom'] = $infos['Prenom'];
                $_SESSION['Matricule'] = $infos['Matricule'];
                $_SESSION['Admin'] = 'None';
                $_SESSION['Pilote'] = 'None';
                $_SESSION['Instructeur'] = 'None';
                $_SESSION['Student'] = 'None';
                $_SESSION['Role'] = '(Utilisateur)';
                $_SESSION['Profil'] = 'None';

                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }

            if ($this->userIsAdmin($_SESSION['UID'])) {
                $_SESSION['Admin'] = 'Admin';
                $_SESSION['Role'] = '(Administrateur)';
            }

            if ($this->userIsInstructor($_SESSION['UID'])) {
                $_SESSION['Instructeur'] = 'Instructeur';
                $_SESSION['Profil'] = "Instructeur ".$this->getInstructorGroupement($_SESSION['UID'])['Groupement'];
                $_SESSION['GID'] = $this->getInstructorGroupement($_SESSION['UID'])['GID'];
            }

            if ($this->userIsPilote($_SESSION['UID'])) {
                $_SESSION['Pilote'] = 'Pilote';
                $_SESSION['Profil'] = "Pilote du cours ".$this->getPiloteCourse($_SESSION['UID'])['Cours'];
                $_SESSION['PiloteCID'] = $this->getPiloteCourse($_SESSION['UID'])['CID'];
            }


            if ($this->userIsStudent($_SESSION['UID'])) {
                $_SESSION['Student'] = 'Student';
                $promotion = $this->getStudentPromotion(($_SESSION['UID']));
                $_SESSION['Profil'] = "Elève ".$promotion['Cours']." ".$promotion['Promotion'];
            }
    }

    public function getNewUsers()
    {
        //retourne une array contenant les information sur les utilisateurs en attente de validation
        $sql = 'SELECT * FROM `users` WHERE `Statut` = 0';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function countNewUsers()
    {
        //retourne une array contenant les information sur les utilisateurs en attente de validation
        $sql = 'SELECT COUNT(*) FROM `users` WHERE `Statut` = 0';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetch()['COUNT(*)'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getEnabledUsers()
    {
        //retourne une array contenant les information sur les utilisateurs actifs
        $sql = 'SELECT * FROM `users` WHERE `Statut` = 1';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getGroupements()
    {
        //retourne une array contenant les information sur les cours
        $sql = 'SELECT * FROM `groupements`';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getCourses()
    {
        //retourne une array contenant les information sur les cours
        $sql = 'SELECT * FROM `cours` JOIN `groupements` ON cours.GID = groupements.GID';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getCourseGID($cid)
    {
        $sql = 'SELECT * FROM `cours` WHERE `CID` LIKE :CID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('CID' => $cid));
                return $reponse->fetch()['GID'];

                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getCourseByCID($cid)
    {
        $sql = 'SELECT * FROM `cours` WHERE `CID` LIKE :CID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('CID' => $cid));
                return $reponse->fetchall();

                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getPromotions()
    {
        //retourne une array contenant les information sur les promotions
        $sql = 'SELECT * FROM Cours JOIN Promotions ON Cours.CID = Promotions.CID';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getMatieres()
    {
        //retourne une array contenant les information sur les promotions
        $sql = 'SELECT * FROM Cours JOIN Matieres ON Cours.CID = Matieres.CID';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute();
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getCourseMatieres($cid)
    {
        //retourne une array contenant les information sur les promotions
        $sql = 'SELECT * FROM Cours JOIN Matieres ON Cours.CID = Matieres.CID WHERE Cours.CID = :CID';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('CID' => $cid));
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function validUser($uid)
    {
        // validation d'un nouvel uilisateur
        $sql = 'UPDATE users SET Statut = :Statut WHERE UID = :UID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('UID' => $this->iocleaner->inputFilter($uid),
                                   'Statut' => '1'));
            if (isset($_POST['process'])
                && ($_POST['process'] != 'register')) {
            header($this->DONE);
            }
        } catch (PDOException $e) {
            //erreur inatendue
            header($this->DBNOK);
        }
    }

    public function setUserAsPilote($uid, $course)
    {
        //cette fonction permet de modifier un utilisateur pour lui donner le role de pilote de cours

        //supression de l'utilisateur de la table Students et instructeurs
        $this->deleteFromStudents($uid);
        $this->deleteFromInstructeurs($uid);
        //Ajout du role pilote
        $this->setRolePilote($uid, $course);

    }

    public function setUserAsInstructor($uid, $groupement)
    {
        //cette fonction permet de modifier un utilisateur pour lui donner le role
        //d'instructeur pour un groupement d'instruction donnée

        //supression de l'utilisateur de la table Students
        $this->deleteFromStudents($uid);
        //supression de l'utilisateur de la table Pilotes
        $this->deleteFromPilotes($uid);
        //Ajout du role Instructeur
        $this->setRoleInstructor($uid, $groupement);

    }

    public function setUserAsStudent($uid, $promotion)
    {
        //cette fonction permet de modifier un utilisateur pour lui donner le role
        //d'instructeur pour un groupement d'instruction donnée

        //supression de l'utilisateur de la table Pilotes
        $this->deleteFromPilotes($uid);
        //supression de l'utilisateur de la table Instructeurs
        $this->deleteFromInstructeurs($uid);
        //Ajout du role Instructeur
        $this->setRoleStudent($uid, $promotion);

    }



    public function disableUser($uid)
    {
        // validation d'un nouvel uilisateur
        $sql = 'UPDATE users SET Statut = :Statut WHERE UID = :UID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('UID' => $this->iocleaner->inputFilter($uid),
                                   'Statut' => '0'));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur inatendue
            header($this->DBNOK);
        }
    }

    public function rejectUser($uid)
    {
        // suppression de l'uilisateur rejeté
        $sql = 'DELETE FROM users WHERE UID = :UID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('UID' => $this->iocleaner->inputFilter($uid)));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur inatendue
            header($this->DBNOK);
        }

        // suppresion de toute les tables
        $this->deleteFromInstructeurs($uid);
        $this->deleteFromPilotes($uid);
        $this->deleteFromStudents($uid);
    }

    public function createGroupement($groupement)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'INSERT INTO groupements (`Groupement`)
                VALUES (:Groupement);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Groupement' => $this->iocleaner->inputFilter($groupement)));
            header($this->DONE);
        } catch (PDOException $e) {

            //Cours déjà existant
            $patern = "#pour la clef 'Groupement'$#";
            $groupementAlreadyUsed = preg_match($patern, $e->getMessage());
            if ($groupementAlreadyUsed) {
                header("location: ?view=groupementsManagement&error=groupementAlreadyUsed&groupement=$groupement");
            } else {
                //erreur inatendue
                header($this->DBNOK);
                
            }

        }

    }

    public function renameGroupement($gid, $groupement)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'UPDATE groupements SET Groupement = :Groupement WHERE GID = :GID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Groupement' => $this->iocleaner->inputFilter($groupement),
                                   'GID' => $this->iocleaner->inputFilter($gid)));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur innatendue
            header($this->DBNOK);
        }

    }

    public function removeGroupement($gid)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'DELETE FROM groupements WHERE GID = :GID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('GID' => $this->iocleaner->inputFilter($gid)));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur innatendue
            header($this->DBNOK);
        }

    }

    public function createCourse($cours, $gid)
    {
        // création d'un nouveau cours dans la base de donnée
        $sql = 'INSERT INTO cours (`Cours`, `GID`)
                VALUES (:Cours, :GID);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Cours' => $this->iocleaner->inputFilter($cours),
                                   'GID' => $this->iocleaner->inputFilter($gid)));
            header($this->DONE);
        } catch (PDOException $e) {

            //Cours déjà existant
            $patern = "#pour la clef 'Cours'$#";
            $courseAlreadyUsed = preg_match($patern, $e->getMessage());
            if ($courseAlreadyUsed) {
                header("location: ?view=coursesManagement&error=courseAlreadyUsed&course=$cours");
            } else {
                //erreur inatendue
                header($this->DBNOK);
            }

        }

    }

    public function renameCourse($cid, $cours)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'UPDATE cours SET Cours = :Cours WHERE CID = :CID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Cours' => $this->iocleaner->inputFilter($cours),
                                   'CID' => $this->iocleaner->inputFilter($cid)));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur innatendue
            header($this->DBNOK);
        }

    }

    public function removeCourse($cid)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'DELETE FROM cours WHERE CID = :CID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('CID' => $this->iocleaner->inputFilter($cid)));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur innatendue
            header($this->DBNOK);
        }

    }

    public function createPromotion($cid, $promotion)
    {
        // création d'une nouvelle promotion dans la base de donnée
        $sql = 'INSERT INTO promotions (`CID`, `Promotion`)
                VALUES (:CID, :Promotion);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Promotion' => $this->iocleaner->inputFilter($promotion),
                                   'CID' => $this->iocleaner->inputFilter($cid)));
            header($this->DONE);
        } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
        }
    }

    public function createMatiere($cid, $matiere)
    {
        // création d'une nouvelle matiere dans la base de donnée
        $sql = 'INSERT INTO matieres (`CID`, `Matiere`)
                VALUES (:CID, :Matiere);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Matiere' => $this->iocleaner->inputFilter($matiere),
                                   'CID' => $this->iocleaner->inputFilter($cid)));
            header($this->DONE);
        } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
        }
    }


    public function renamePromotion($pid, $promotion)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'UPDATE promotions SET Promotion = :Promotion WHERE PID = :PID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('Promotion' => $this->iocleaner->inputFilter($promotion),
                                   'PID' => $this->iocleaner->inputFilter($pid)));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur innatendue
            header($this->DBNOK);
        }

    }

    public function removePromotion($pid)
    {
        // création d'un nouvel uilisateur dans la base de donnée
        $sql = 'DELETE FROM promotions WHERE PID = :PID;';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $insert->execute(array('PID' => $this->iocleaner->inputFilter($pid)));
            header($this->DONE);
        } catch (PDOException $e) {
            //erreur innatendue
            header($this->DBNOK);
        }

    }

    public function userIsAdmin($uid)
    {
        //return true si l'utilisateur est administrateur
        $sql = 'SELECT COUNT(*) FROM `administrateurs` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                return $reponse->fetch()['COUNT(*)'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function userIsInstructor($uid)
    {
        //return true si l'utilisateur est administrateur
        $sql = 'SELECT COUNT(*) FROM `instructeurs` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                return $reponse->fetch()['COUNT(*)'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function userIsPilote($uid)
    {
        //return true si l'utilisateur est administrateur
        $sql = 'SELECT COUNT(*) FROM `pilotes` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                return $reponse->fetch()['COUNT(*)'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function userIsStudent($uid)
    {
        //return true si l'utilisateur est administrateur
        $sql = 'SELECT COUNT(*) FROM `students` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                return $reponse->fetch()['COUNT(*)'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function deleteFromAdmins($uid)
    {
        //supprime l'utilisateur de la table administrateurs
        $sql = 'DELETE FROM `administrateurs` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function deleteFromPilotes($uid)
    {
        //supprime l'utilisateur de la table pilotes
        $sql = 'DELETE FROM `pilotes` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function deleteFromInstructeurs($uid)
    {
        //supprime l'utilisateur de la table instructeurs
        $sql = 'DELETE FROM `instructeurs` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function deleteFromStudents($uid)
    {
        //supprime l'utilisateur de la table students
        $sql = 'DELETE FROM `Students` WHERE UID = :UID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('UID' => $uid));
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getStudentPromotion($uid)
    {
        //retourne le cours et la promotion suivi par l'eleve.
        $sql = 'SELECT promotions.PID, cours.Cours, promotions.Promotion
        FROM students JOIN promotions ON students.PID = promotions.PID
        JOIN cours ON promotions.CID = cours.CID
        WHERE students.UID = :UID;';
        try {
            $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $reponse->execute(array('UID' => $uid));
            return $reponse->fetch();

               
        } catch (PDOException $e) {
            //erreur inatendue
            header($this->DBNOK);
        }
    }

    public function getInstructorGroupement($uid)
    {
        //retourne le cours et la promotion suivi par l'eleve.
        $sql = 'SELECT groupements.GID, groupements.Groupement FROM instructeurs
        JOIN groupements ON groupements.GID = instructeurs.GID
        WHERE instructeurs.UID = :UID;';
        try {
            $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $reponse->execute(array('UID' => $uid));
            return $reponse->fetch();

               
        } catch (PDOException $e) {
            //erreur inatendue
            header($this->DBNOK);
        }
    }

    public function getPiloteCourse($uid)
    {
        //retourne le cours et la promotion suivi par l'eleve.
        $sql = 'SELECT cours.CID, cours.Cours FROM Cours
        JOIN Pilotes ON Pilotes.CID = cours.CID
        WHERE pilotes.UID = :UID;';
        try {
            $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (PDOException $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {
            $reponse->execute(array('UID' => $uid));
            return $reponse->fetch();

               
        } catch (PDOException $e) {
            //erreur inatendue
            header($this->DBNOK);
        }
    }
}
