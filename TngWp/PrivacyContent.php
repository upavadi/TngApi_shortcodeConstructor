<?php
/** Get privacy settings from TNG set up. *****/
/*****
$database_host = "localhost";
$database_name = "upavadi_for_v13";
$database_username = "root";
$database_password = '';

$rootpath = "C:/wamp64/www/tng13/";
$tngdomain = "http://localhost/tng13/";

$mediapath = "media";
$photopath = "photos";

$requirelogin = "1";
$treerestrict = "0";
$defaulttree = "upavadi_1";
***********************************
Wordpress:
Tng Path = esc_attr(get_option('tng-api-tng-path'))

*/
class TngWp_PrivacyContent
{
    private static $instance2 = null;
protected $shortcodes = array();
protected $domain;
private $tngUser;

protected function __construct()
{

}

public static function instance2()
{
    if (!self::$instance2 instanceof self) {
        self::$instance2 = new self;
    }

    return self::$instance2;
}


function gethim() {
return ("werty");
    
}





}