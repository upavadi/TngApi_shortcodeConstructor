<?php
class TngWp_Shortcode_RandomMediaShortcode extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_RandomMedia';
    
    public function show()
    {
      $this->content->init();
        $content = array(); // shortcodeContent array
        $p_content = array(); // privacyContent array
        $content = TngWp_ShortcodeContent::instance(); 
        $p_content = TngWp_PrivacyContent::instance(); 
        $tng_content = $p_content->tngPrivacy(); //general privacy from PrivacyContent
        $user_content = $p_content->userPrivacy(); //User privacy from PrivacyContent
        $tables = $content->getTngTables();
        //Define variables here and add to $context        
        $requireLogin = $tng_content['tng_login'];
        $url = $content->getTngUrl();
        $genealogy = $content->getTngIntegrationPath();
        $integratedPath = dirname($url). "/". $genealogy;

        //Sample array for html file.
        $tng_path = get_option("tng-api-tng-path"); 
        $tng_photo_path = get_option('tng-api-tng-photo-folder');
        
        $context = array(
        'requireLogin' => $requireLogin,
        'tng_url' => $url,
        'tng_content' => $tng_content,
        'tng_path' => $tng_path,
        'url' => $url,
        'tng_photo_path' => $tng_photo_path,
        'integratedPath' => $integratedPath 
       );

       //This html file to show your pagerandomPhotoShortcode.html', $context);
        //This html file to show your page
        return $this->templates->render('random-media-shortcode.html', $context);
      
    }
   

}  