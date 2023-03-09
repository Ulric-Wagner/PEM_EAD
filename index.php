<?php
ini_set('display_errors', 1);
#import autoloader to use namespace fonctionality
require_once 'vendor/autoload.php';

#call the main router
use Csupcyber\Pemead\Routers\IndexRouter;

$index = new IndexRouter();



