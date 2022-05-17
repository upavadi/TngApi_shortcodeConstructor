<?php
/**
file name: shortCodeContent.php
class name = shortCodeContent


function ContentConstruct($class)
{
    include(__DIR__ . "/TngWp/". $class.".php");
}
spl_autoload_register('ContentConstruct');
var_dump(ContentConstruct());
**/
function TngWp_autoloader($class) {
    $parts = explode("_", $class);
    if ("TngWp" !== $parts[0]) {
        return;
    }
    
    $dir = dirname(__FILE__);
    $file = implode('/', $parts) . '.php';
    include $dir . '/' . $file;
}


if (function_exists('__autoload')) {
    spl_autoload_register('__autoload');
}
spl_autoload_register("TngWp_autoloader");
?>
