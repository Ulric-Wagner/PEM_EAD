<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\IOCleaner;

class DataBase
{
    public function __construct()
    {
        $this->iocleaner = new IOCleaner();
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
        }catch (Exception $e) {
            echo $e;
        }
    }

    public function createUser()
    {
        $sql = 'INSERT INTO users (Nom, Prenom, Matricule, Mail, Sha256, Statut)
                VALUES (:Nom, :Prenom, :Maticule, :Mail, :Sha256, :Statut);';
        try {
            $insert = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (Exception $e) {
            echo 'Une erreur est survenue lors de la préparation de la requête \
            vers la base de données, veuillez contacter un administrateur';
        }
        try {
            $insert->execute(array('Nom' => $this->iocleaner->inputFilter(),
                                   'Prenom' => $this->iocleaner->inputFilter(),
                                   'Matricule' => $this->iocleaner->inputFilter(),
                                   'Mail' => $this->iocleaner->inputFilter(),
                                   'Sha256' => $this->iocleaner->inputFilter(),
                                   'Statut' => 0));
                                } catch (Exception $e) {
                    echo 'Une erreur est survenue lors de l\'execution \
                    de la requête vers la base de données, veuillez contacter un administrateur';
                }
    }
}