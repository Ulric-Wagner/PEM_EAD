<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Models\HtmlHeader;
use Csupcyber\Pemead\Models\NavBar;
use Csupcyber\Pemead\Models\EvalsManagementBody;
use Csupcyber\Pemead\Models\HtmlFooter;

class EvalsManagement
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
        $this->body = new EvalsManagementBody();
    }

    public function footer()
    {
        $this->footer = new HtmlFooter();
    }
}

