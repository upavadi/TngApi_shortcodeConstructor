<?php

class TngWp_Shortcode_SubmitImage extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_submitImage';

    //do shortcode Add Family form
    public function show()
    {
        $personId = filter_input(INPUT_GET, 'personId', FILTER_SANITIZE_SPECIAL_CHARS);
        $context = array();
        $context['personId'] = $personId;
        return $this->templates->render('submit_images.html', $context);
    }
}