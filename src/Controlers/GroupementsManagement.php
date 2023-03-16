<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Models\HtmlHeader;
use Csupcyber\Pemead\Models\NavBar;
use Csupcyber\Pemead\Models\GroupementsManagementBody;
use Csupcyber\Pemead\Models\HtmlFooter;

class GroupementsManagement
{
    public function header()
    {
        $this->header = new HtmlHeader();
    }

    public function navbar()
    {
        $this->navbar = new NavBar();
    }

    public function body()
    {
        $this->body = new GroupementsManagementBody();
    }

    public function footer()
    {
        $this->footer = new HtmlFooter();
    }
}

