<?php

class TngWp_Shortcode_MyShortcode extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_Shortcode_MyShortcode';
    
    public function show()
    {
        //$personId = $this->content->getCurrentPersonId();
        $context = array();
      //  $context['name'] = $this->custom->getPersonName($personId);
        return $this->templates->render('myshortcode.html', $context);
    }
}
