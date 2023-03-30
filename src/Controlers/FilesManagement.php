<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;
use \PDO;

class FilesManagement extends DataBase
{
    public function __construct()
    {
        $view = $_GET['view'];
        $this->NOK = "Location: ?view=$view&error=nok";
        parent::__construct();
    }

    public function fileUpload()
    {
        //Import du pdf ou ppt/pptx avec vérification
        $targetDir = "files/";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        $fileName = pathinfo($targetFile,PATHINFO_BASENAME);
        $fileName = str_replace(".$fileType", "", $fileName);
        
        // upload du fichier
        if (isset($_FILES["fileToUpload"]))
        {
        $uploadOk = 1;
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 50000000) {
        $out = $out . "Erreur, votre fichier fait plus de 50Mo.<br/>";
        $uploadOk = 0;}

            
        // verify valid extention first (name can't contain dot)
        $findme = '.';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . "Erreur, seul les fichiers pdf ou ppt/pptx sont acceptés,
        le fichier ne doit contenir qu'une seule extention<br/>";
        $uploadOk = 0;
        }
            
        // le nom du fichier et son extention ne doivent pas contenir de caractères spéciaux

            // recherche /
        $findme = '/';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }
            
            
                // recherche \
        $findme = '\\';
        $check = strpos($fileName, $findme);
        if($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }
            
            
                // recherche %
        $findme = '%';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if ($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }
                // recherche ?
        $findme = '?';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if ($check)
        {
        $out = $out . "Erreur, le nom du fichier n'est pas conforme<br/>";
        $uploadOk = 0;
        }
            
            
        //vérification de la longueur du nom du fichier
        //la limite de taille linux est 255, par sécurité nous limitons à 200
        $check = strlen($fileName) + strlen($fileType);
        if ($check > 200)
        {
            $out = $out . "Erreur, le nom du fichier est trop long<br/>";
        $uploadOk = 0;
        }
            
        // Allow certain file formats
        if ($fileType !== "pdf" AND $fileType !== "msg") {
        $out = $out . "Erreur, seul les fichier pdf et msg sont acceptés<br/>";
        $uploadOk = 0;}
            
        //vérification de la présence d'un fichier avec le même nom sur le serveur
        if (file_exists($targetFile))
        {
        $fileIncrement = 0;
            while (file_exists($targetFile)) {
                $fileIncrement++;
                $targetFile = $targetDir.$fileName."($fileIncrement)".".$fileType";
            }
            
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)){
            $out =  "Le fichier:" . $this->iocleaner->outputFilter(basename($targetFile)) . " a
            été importé avec succès.";
            
        //--------------------

        //record the file
        
        $sql = 'INSERT INTO fichiers (`Fichier`, `Type`, `GID`, `Path`, `Poster`)
        VALUES (:Fichier, :Type, :GID, :Path, :Poster);';
        try {
            $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        } catch (Exception $e) {
            header($this->LOCATION_DBPREPARE_ERROR);
        }
        try {$insert->execute(array('Fichier' => $this->iocleaner->outputFilter(basename($targetFile)),
                               'Type' => $this->iocleaner->outputFilter($fileType),
                               'Path' => $this->iocleaner->outputFilter($targetFile),
                               'GID' => $_SESSION['GID'],
                               'Poster' => $_SESSION['Grade']));
            header($this->DONE);
            
        } catch (PDOException $e) {

                //erreur inatendue
                header($this->DBNOK);
            }

        }
        } else {
        //message de sortie pour information utilisateur
        $_SESSION['ERROR'] = $out;

        }
        }
        else {
            //erreur inatendue
            header($this->DBNOK);
        }

    }

    
}
