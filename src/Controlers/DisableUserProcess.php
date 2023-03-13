<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Controlers\DataBase;

class DisableUserProcess
{
    public function disable()
    {
        if (isset($_POST['DisabledUser'])) {
        $disable = new DataBase();
        $disable->disableUser($_POST['DisabledUser']);
        
        header('Location: ?view=accountsManagement&success=done');
        } else {
            header('Location: ?view=accountsManagement&error=nok');
        }
    }

}

