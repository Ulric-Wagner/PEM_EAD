<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class SetCourseProcess
{
    public function __construct()
    {
        $this->db = new DataBase();
        $this->NOK = 'Location: ?view=coursesManagement&error=nok';
    }

    

    public function verifyCSRF($token)
    {
        return $token === $_SESSION['CSRFToken'];
    }

    public function create()
    {
        if (isset($_POST['createCourse'])
        && !empty($_POST['createCourse'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->createCourse(strtoupper($_POST['createCourse']));
        
        } else {
            header($this->NOK);
        }
    }

    public function rename()
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

    public function remove()
    {
        if (isset($_POST['newCourseName'])
        && !empty($_POST['newCourseName'])
        && isset($_POST['CID'])
        && !empty($_POST['CID'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->removeCourse($_POST['CID'], $_POST['newCourseName']);
        
        } else {
            header($this->NOK);
        }
    }

}
