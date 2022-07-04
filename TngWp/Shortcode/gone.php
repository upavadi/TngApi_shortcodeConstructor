<?php
class TngWp_Shortcode_Gone extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_gone';
    
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
        $tngUrl = $content->getTngUrl(); 
        $generic_M_photo = $tngUrl. "img/male.jpg";
        $generic_F_photo = $tngUrl. "img/female.jpg";
        $photoPath = $tngUrl. 'photos/';

        //Sample array for html file.
        $context = array(
        'gonedays' =>$content->getYesterdayTodayTomorrow(),
        'generic_M' => $generic_M_photo, 
        'generic_F' =>  $generic_F_photo, 
        'photoPath' => $photoPath,
        'tngUrl' => $tngUrl
      );
      
      //This html file to show
       return $this->templates->render('gone.html', $context);
    }
   
  
    // No Privacy rules on this shortcode 
}