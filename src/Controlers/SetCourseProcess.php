<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class SetCourseProcess
{
    public function __construct()
    {
        $this->db = new DataBase();
        $this->DONE = 'Location: ?view=coursesManagement&success=done';
        $this->NOK = 'Location: ?view=coursesManagement&error=nok';
    }

    

    public function verifyCSRF($token)
    {
        return $token === $_SESSION['CSRFToken'];
    }

    public function create()
    {
        if (isset($_POST['createCourse'])
        && isset($_POST['CSRFToken'])
        && $this->verifyCSRF($_POST['CSRFToken'])) {
        $create = new DataBase();
        $create->createCourse($_POST['createCourse']);
        
        header($this->DONE);
        } else {
            header($this->NOK);
        }
    }

}
