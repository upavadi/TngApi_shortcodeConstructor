<?php

class TngWp_Shortcode_MyShortcode extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_MyShortcode';
    
    public function show()
    {
      $this->content->init();  
      $personId = $this->content->getCurrentPersonId();
        //$currentPerson = $this->content->getCurrentPersonId();
        var_dump($personId);
        $context = array();
       $context['name'] = $this->content->getPersonName($personId);
        $content2 = TngWp_PrivacyContent::instance();
        $context['x'] = $content2->gethim();
        return $this->templates->render('myshortcode.html', $context);
    }

}
