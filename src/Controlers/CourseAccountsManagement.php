<?php
namespace Csupcyber\Pemead\Controlers;

use Csupcyber\Pemead\Models\HtmlHeader;
use Csupcyber\Pemead\Models\NavBar;
use Csupcyber\Pemead\Models\CourseAccountsManagementBody;
use Csupcyber\Pemead\Models\HtmlFooter;

class CourseAccountsManagement
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
        $this->body = new CourseAccountsManagementBody();
    }

    public function footer()
    {
        $this->footer = new HtmlFooter();
    }
}

