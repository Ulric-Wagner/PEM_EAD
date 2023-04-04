<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;
use \PDO;

class FilesManagement extends DataBase
{
    public function __construct()
    {
        parent::__construct();
        $this->view = $_GET['view'];
        $this->NOK = "Location: ?view=$this->view&error=nok";
        $this->DONE = "Location: ?view=$this->view&success=done";
        $this->NAME_NOK = "Erreur, le nom du fichier n'est pas conforme ";
    }

    public function verifyCSRF($token)
    {
        return $token === $_SESSION['CSRFToken'];
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
        $out = $out . "Erreur, votre fichier fait plus de 50Mo. ";
        $uploadOk = 0;}

        //verification du mimetype via fileinfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $validMIME = array(
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "application/vnd.ms-powerpoint",
            "application/vnd.oasis.opendocument.presentation",
            "application/pdf"
        );

        if (!in_array(finfo_file($finfo, $_FILES["fileToUpload"]["tmp_name"]), $validMIME)) {
            $out = $out . "Erreur, seul les fichiers pdf ou ppt/pptx ou odp sont acceptés ";
            $uploadOk = 0;
        }

        // verify valid extention first (name can't contain dot)
        $findme = '.';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . "Erreur, seul les fichiers pdf ou ppt/pptx sont acceptés,
        le fichier ne doit contenir qu'une seule extention ";
        $uploadOk = 0;
        }
            
        // le nom du fichier et son extention ne doivent pas contenir de caractères spéciaux

            // recherche /
        $findme = '/';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }
            
            
                // recherche \
        $findme = '\\';
        $check = strpos($fileName, $findme);
        if($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }
            
            
                // recherche %
        $findme = '%';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if ($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }
                // recherche ?
        $findme = '?';
        $check = strpos($fileName, $findme);
        if ($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }

        $check = strpos($fileType, $findme);
        if ($check)
        {
        $out = $out . $this->NAME_NOK;
        $uploadOk = 0;
        }
            
            
        //vérification de la longueur du nom du fichier
        //la limite de taille linux est 255, par sécurité nous limitons à 200
        $check = strlen($fileName) + strlen($fileType);
        if ($check > 200)
        {
            $out = $out . "Erreur, le nom du fichier est trop long ";
        $uploadOk = 0;
        }
            
        // Allow certain file formats
        if ($fileType !== "pdf" AND $fileType !== "ppt" AND $fileType !== "pptx" AND $fileType !== "odp") {
        $out = $out . "Erreur, seul les fichier pdf, ppt et pptx sont acceptés ";
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
        if ($uploadOk === 1
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
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
                               'Poster' => $_SESSION['Grade'] . " " . $_SESSION['Nom'] . " ". $_SESSION['Prenom']));
            header($this->DONE);
            
        } catch (PDOException $e) {

                //erreur inatendue
                header($this->DBNOK);
            }
        }
        } else {
        //message de sortie pour information utilisateur
        $_SESSION['ERROR'] = $out;
        header("Location: ?view=$this->view&error=uploadError");

        }
        }
        else {
            //erreur inatendue
            header($this->DBNOK);
        }

    }

    public function download() {
        if (isset($_POST['FileToRead'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
            $file = 'files/'.$this->iocleaner->inputFilter($_POST['FileToRead']);
            if (file_exists($file)) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file);
                header("Content-Type: $mime");
                
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header("Cache-Control: no-cache, must-revalidate");
                $date = date('D, j M Y G:i:s', time()-600);
                $expiresDate = $date.' GMT';
                header("Expires: $expiresDate");
                // clean output buffer
                ob_end_clean();
                readfile($file);
                // flush buffer
                ob_flush();
                exit();
            }

        }
    }

    public function getFiles($gid)
    {
        //retourne une array contenant les information sur les promotions
        $sql = 'SELECT * FROM fichiers WHERE GID = :GID ORDER BY Fichier ASC ';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('GID' => $gid));
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getFilePath($fid)
    {
        //retourne une array contenant les information sur les promotions
        $sql = 'SELECT * FROM fichiers WHERE FID = :FID ORDER BY Fichier ASC ';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('FID' => $fid));
                return $reponse->fetch()['Path'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getDocuments($mid)
    {
        //retourne une array contenant les information sur les documents
        $sql = 'SELECT DID, Document, Description, MID, fichiers.FID, statut, Fichier, Type, Path, Poster
        FROM `documents` JOIN `fichiers` ON documents.FID = fichiers.FID WHERE MID = :MID ORDER BY Document ASC ';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('MID' => $mid));
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getValidatedDocuments($mid)
    {
        //retourne une array contenant les information sur les documents validés
        $sql = 'SELECT DID, Document, Description, MID, fichiers.FID, statut, Fichier, Type, Path, Poster
        FROM `documents` JOIN `fichiers` ON documents.FID = fichiers.FID
        WHERE MID = :MID
        AND statut = "1"
        ORDER BY Document ASC ';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('MID' => $mid));
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function getUnvalidatedDocuments($mid)
    {
        //retourne une array contenant les information sur les documents à valider
        $sql = 'SELECT DID, Document, Description, MID, fichiers.FID, statut, Fichier, Type, Path, Poster
        FROM `documents` JOIN `fichiers` ON documents.FID = fichiers.FID
        WHERE MID = :MID
        AND statut = "0"
        ORDER BY Document ASC ';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('MID' => $mid));
                return $reponse->fetchall();
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function countUnvalidatedDocuments()
    {
        //retourne une array contenant les information sur les documents à valider
        $sql = 'SELECT COUNT(*) FROM `documents` WHERE statut = "0";';
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

    public function countUnvalidatedDocumentsForMID($mid)
    {
        //retourne une array contenant les information sur les documents à valider pour une matiere
        $sql = 'SELECT COUNT(*) FROM `documents` WHERE statut = "0" AND MID = :MID;';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('MID' => $mid));
                return $reponse->fetch()['COUNT(*)'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function createDocument()
    {
        if (isset($_POST['FID'])
        && isset($_POST['description'])
        && isset($_POST['title'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {

            $sql = 'INSERT INTO documents (`Document`, `Description`, `FID`, `MID`)
            VALUES (:Document,:Description, :FID, :MID);';
            try {
                $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (Exception $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {$insert->execute(array('Document' => $this->iocleaner->inputFilter($_POST['title']),
                                   'Description' => $this->iocleaner->inputFilter($_POST['description']),
                                   'MID' => $this->iocleaner->inputFilter($_POST['MID']),
                                   'FID' => $this->iocleaner->inputFilter($_POST['FID'])));
                header($this->DONE);
                
            } catch (PDOException $e) {
    
                    //erreur inatendue
                    header($this->DBNOK);
                }
        }
    
    }

    public function validDocument()
    {
        if (isset($_POST['Valid'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {

            $sql = 'UPDATE documents SET statut = 1
            WHERE DID = :DID;';
            try {
                $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (Exception $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {$insert->execute(array('DID' => $this->iocleaner->inputFilter($_POST['Valid'])));
                header($this->DONE);
                
            } catch (PDOException $e) {
    
                    //erreur inatendue
                    header($this->DBNOK);
                }
        }
    
    }

    public function rejectDocument()
    {
        if (isset($_POST['Reject'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {

            $sql = 'DELETE FROM `documents` WHERE DID = :DID;';
            try {
                $insert = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (Exception $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {$insert->execute(array('DID' => $this->iocleaner->inputFilter($_POST['Reject'])));
                header($this->DONE);
                
            } catch (PDOException $e) {
    
                    //erreur inatendue
                    header($this->DBNOK);
                }
        }
    
    }

    public function countDocumentsForFID($fid)
    {
        //retourne une array contenant les information sur les documents à valider
        $sql = 'SELECT COUNT(*)
        FROM `documents` JOIN `fichiers` ON documents.FID = fichiers.FID
        WHERE fichiers.FID = :FID';
            try {
                $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (PDOException $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $reponse->execute(array('FID' => $fid));
                return $reponse->fetch()['COUNT(*)'];
                   
            } catch (PDOException $e) {
                //erreur inatendue
                header($this->DBNOK);
            }
    }

    public function removeFIle()
    {
        if (isset($_POST['Remove'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])
        && !$this->countDocumentsForFID($_POST['Remove'])) {

            $sql = 'DELETE FROM `fichiers` WHERE FID = :FID;';
            try {
                $delete = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            } catch (Exception $e) {
                header($this->LOCATION_DBPREPARE_ERROR);
            }
            try {
                $targetFile = $this->getFilePath($_POST['Remove']);
                unlink($targetFile);
                
                $delete->execute(array('FID' => $this->iocleaner->inputFilter($_POST['Remove'])));
                
            } catch (PDOException $e) {
    
                    //erreur inatendue
                    header($this->DBNOK);
                }
        } elseif (isset($_POST['Remove'])
        && $this->countDocumentsForFID($_POST['Remove'])
        && isset($_POST['CSRFToken'])) {
            header("Location: ?view=$this->view&error=busyFile");
        }
    
    }

    public function removeMatiere()
    {
        if (isset($_POST['Remove'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
            //supprime une matiere et ses documents
            $sql = 'DELETE FROM matieres WHERE MID = :MID';
                try {
                    $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                } catch (PDOException $e) {
                    header($this->LOCATION_DBPREPARE_ERROR);
                }
                try {
                    $reponse->execute(array("MID" => $_POST['Remove']));
                    
                    
                } catch (PDOException $e) {
                    //erreur inatendue
                    header($this->DBNOK);
                }

                $sql = 'DELETE FROM Documents WHERE MID = :MID';
                try {
                    $reponse = $this->bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                } catch (PDOException $e) {
                    header($this->LOCATION_DBPREPARE_ERROR);
                }
                try {
                    $reponse->execute(array("MID" => $_POST['Remove']));
                    
                    
                } catch (PDOException $e) {
                    //erreur inatendue
                    header($this->DBNOK);
                }
        }
    }

    

}