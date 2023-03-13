<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class ValidUserProcess
{
    public function valid()
    {
        if (isset($_POST['ValidatedUser'])) {
        $validation = new DataBase();
        $validation->validUser($_POST['ValidatedUser']);
        
        header('Location: ?view=accountsManagement&success=done');
        } else {
            header('Location: ?view=accountsManagement&error=nok');
        }
    }

}

