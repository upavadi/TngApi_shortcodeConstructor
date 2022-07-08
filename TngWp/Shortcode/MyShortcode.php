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
                
        $requireLogin = $tng_content['tng_login'];
        $url = $content->getTngUrl();
        $genealogy = $content->getTngIntegrationPath();
        $integratedPath = dirname($url). "/". $genealogy;        
        //Sample array for html file.
        $context = array(
        'requireLogin' => $requireLogin,
        'url' => $url,
        'tng_content' => $tng_content,
        'integratedPath' => $integratedPath 
       );


       //This html file to show
       return $this->templates->render('myshortcode.html', $context);
    }
   
  
    // No Privacy rules on this shortcode 
}