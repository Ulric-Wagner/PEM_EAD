<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class SetCourseProcess
{
    public function __construct()
    {   
        if (isset($_GET['view'])){
            $view = $_GET['view'];
        } else {
            $view = "office";
        }
        $this->NOK = "Location: ?view=$view&error=nok";
        $this->db = new DataBase();
    }

    

    public function verifyCSRF($token)
    {
        return $token === $_SESSION['CSRFToken'];
    }

    public function createGroupement()
    {
        if (isset($_POST['createGroupement'])
        && !empty($_POST['createGroupement'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->createGroupement(strtoupper($_POST['createGroupement']));
        
        } else {
            header($this->NOK);
            
        }
    }

    public function renameGroupement()
    {
        if (isset($_POST['newGroupementName'])
        && !empty($_POST['newGroupementName'])
        && isset($_POST['GID'])
        && !empty($_POST['GID'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->renameGroupement($_POST['GID'], strtoupper($_POST['newGroupementName']));
        
        } else {
            header($this->NOK);
        }
    }

    public function removeGroupement()
    {
        if (isset($_POST['removeGroupement'])
        && !empty($_POST['removeGroupement'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->removeGroupement($_POST['removeGroupement']);
        
        } else {
            header($this->NOK);
        }
    }

    public function createCourse()
    {
        if (isset($_POST['createCourse'])
        && !empty($_POST['createCourse'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->createCourse(strtoupper($_POST['createCourse']), $_POST['GID']);
        
        } else {
            header($this->NOK);
        }
    }

    public function renameCourse()
    {
        if (isset($_POST['newCourseName'])
        && !empty($_POST['newCourseName'])
        && isset($_POST['CID'])
        && !empty($_POST['CID'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->renameCourse($_POST['CID'], strtoupper($_POST['newCourseName']));
        
        } else {
            header($this->NOK);
        }
    }

    public function removeCourse()
    {
        if (isset($_POST['removeCourse'])
        && !empty($_POST['removeCourse'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->removeCourse($_POST['removeCourse']);
        
        } else {
            header($this->NOK);
        }
    }

    public function createPromotion()
    {
        if (isset($_POST['createPromotion'])
        //&& !empty($_POST['createPromotion'])
        && isset($_POST['CID'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->createPromotion($_POST['CID'], strtoupper($_POST['createPromotion']));
        
        } else {
            header($this->NOK);
        }
    }

    public function renamePromotion()
    {
        if (isset($_POST['newPromotionName'])
        && !empty($_POST['newPromotionName'])
        && isset($_POST['PID'])
        && !empty($_POST['PID'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->renamePromotion($_POST['PID'], strtoupper($_POST['newPromotionName']));
        
        } else {
            header($this->NOK);
        }
    }

    public function removePromotion()
    {
        if (isset($_POST['removePromotion'])
        && !empty($_POST['removePromotion'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->removePromotion($_POST['removePromotion']);
        
        } else {
            header($this->NOK);
        }
    }

    public function createMatiere()
    {
        if (isset($_POST['createMatiere'])
        && isset($_POST['CID'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->createMatiere($_POST['CID'], strtoupper($_POST['createMatiere']));
        
        } else {
            header($this->NOK);
        }
    }

}
