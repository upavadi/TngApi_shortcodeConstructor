<?php
/** Sample Text
* How to add shortcode FOR THIS PAGE to TNG Shortcode Constructor
**/
echo "PHP Version = ". (phpversion()); //variable
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
                <li>Closed with closing statement: <b>'return $this->templates->render('myshortcode.html', $context);</b> This Shortcode will render the template file.
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
<div>
<b>Wordpress Options:</b>
<li>Tng url = esc_attr(get_option('tng-api-tng-url'))</li>
<li>rootPath = esc_attr(get_option('tng-api-tng-path')</li>
<li>Tng Integration Path = esc_attr(get_option('tng-base-tng-path')</li>
( These are the same variables as in TNG API )

<br /><b>functions</b>
<li>$url = $content->getTngUrl();</li>
<li>$genealogy = $content->getTngIntegrationPath();</li>
<li>$IntegratedPath = dirname($url). "/". $genealogy;</li>
</div>

