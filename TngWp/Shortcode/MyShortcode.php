<?php

class TngWp_Shortcode_MyShortcode extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_MyShortcode';
    
    public function show()
    {
      $this->content->init();  
      
      
      
        $content = array(); // shortcodeContent array
        $p_content = array(); // privacyContent array
        $content = TngWp_ShortcodeContent::instance(); 
        $p_content = TngWp_PrivacyContent::instance(); 
        $tng_content = $p_content->tngPrivacy(); //general privacy from PrivacyContent
        $user_content = $p_content->userPrivacy(); //User privacy from PrivacyContent
        $test_content = $p_content->testPrivacy(); //add function from Shortcode Content
        
        $requireLogin = $tng_content['tng_login'];
        
        //Sample array for html file.
        $context = array(
        'requireLogin' => $requireLogin  
       );
       
       //This html file to show
       return $this->templates->render('myshortcode.html', $context);
    }
// No Privacy rules on this shortcode 
}
