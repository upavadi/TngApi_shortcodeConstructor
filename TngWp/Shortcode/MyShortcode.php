<?php

class TngWp_Shortcode_MyShortcode extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_MyShortcode';
    
    public function show()
    {
      $this->content->init();  
      $personId = $this->content->getCurrentPersonId();
      
      
        $context = array();
        $tng_context = array();
       $context['name'] = $this->content->getPersonName($personId);
        $p_content = TngWp_PrivacyContent::instance(); //var_dump($p_content);
        $context['x'] = $p_content->gethim(); //add function from Shortcode Content
        $tng_context = $p_content->tngPrivacy(); //general privacy from PrivacyContent
        $user_context = $p_content->userPrivacy(); //User privacy from PrivacyContent
var_dump($tng_context, $user_context);
        return $this->templates->render('myshortcode.html', $context);
    }
// No Privacy rules on this shortcode 
}
