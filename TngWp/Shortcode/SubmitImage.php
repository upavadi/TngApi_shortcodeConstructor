<?php
/** Requires LogIn ****/
class TngWp_Shortcode_SubmitImage extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_submitImage';

     public function show()
     {
        $this->content->init();
        $content = TngWp_ShortcodeContent::instance();
        $p_content = TngWp_PrivacyContent::instance();
        $requireLogin = $p_content->requireLogin(); //in setup
        $treeAccess = $this->content->treeAccess(); //in setup
        $tngUser = $this->content->getTngUser();
        $context = array(
            'requireLogin' => $requireLogin,
            'treeAccess' => $treeAccess
            
        );

if ($requireLogin == 1 && (!ISSET($tngUser))) {
            /** if not logged in display error ** */
            echo "<div style='color: red; font-size: 1.2em; text-align: center;'>You are not Logged In. Please Login to continue</div>";
        } else {
        return $this->templates->render('submit_images.html', $context);
        }
    }

}