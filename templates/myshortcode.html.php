<?php
/** Sample Text
* How to add shortcode FOR THIS PAGE to TNG Shortcode Constructor
**/

?>
<div>
<h1>How this shortcode was added to the tng-shortcode-constructor</h1>
<strong>Shortcode is [TngWp_MyShortcode]</strong>
</div>
<h1>
<?php

?>
</h1>
<div>
    <ol>
        <li> In TngWp/shortcode folder, file <b>'MyShortcode.php'</b> added
            <ol>
                <li>Created class: <b>'class TngWp_Shortcode_MyShortcode extends TngWp_Shortcode_AbstractShortcode'</b></li>
                <li>Closed with closing statement: <b>'return $this->templates->render('myshortcode.html', $context);</b>
            
   ' 
        </li>
        </ol>
    </li>
        
        <li> In templates folder, this file, <b>'myshortcode.html.php'</b>, added</li>
        <li> In  <b>'tng-shortcode-constructor.php'</b>, this shortcode added to content
            <ol>
                <li>$content->addShortcode(new TngWp_Shortcode_MyShortcode());</li>
            </ol>
        </li>
        <li> That's it</li> 
    </ol>
</div>






<!--
In LandingPage.php

class TngApiCustom_Shortcode_LandingPage extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_landing_page';
    const SHORTCODE = 'tngcustom_landing_page';

    public function show()
    {


        return $this->templates->render('landing-page.html', $context);
    } 

}

In TngCustom.php

    protected $shortCodes = array(
        "MyShortcode",
        "LandingPage",
		"BirthdaysPlusOne",
		"ManniversariesPlusOne",
		"DanniversariesPlusOne",
		"FamilySheet",
		"BirthdaysCustom",
		"ManniversariesCustom",
        "DanniversariesCustom"   		
		
    );

    
/********************** Get privacy settings from TNG set up. *****
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

*****************************************************************************/