<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class RejectUserProcess
{
    public function reject()
    {
        if (isset($_POST['RejectedUser'])) {
        $validation = new DataBase();
        $validation->rejectUser($_POST['RejectedUser']);
        
        header('Location: ?view=accountsManagement&success=done');
        } else {
            header('Location: ?view=accountsManagement&error=nok');
        }
    }

}

