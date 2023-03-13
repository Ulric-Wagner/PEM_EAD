<?php
namespace Csupcyber\Pemead\Models;

class HtmlFooter
{
    public function __construct()
    { ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <?php
    if (isset($_GET['view']) && $_GET['view'] === 'setPassword') {
        ?>
        <script src="js/setPassword.js"></script>
        <?php
    }

    if (isset($_GET['view']) && $_GET['view'] === 'register') {
        ?>
        <script src="js/register.js"></script>
        <?php
    }
    ?>
    </body>
    <?php
    }
}
