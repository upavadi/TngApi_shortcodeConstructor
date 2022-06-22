<?php

class TngWp_Shortcode_LandingPage extends TngWp_Shortcode_AbstractShortcode
{

    const SHORTCODE = 'TngWp_LandingPage';
    
    public function show()
    {
        $this->content->init();
        $personId = $this->content->getCurrentPersonId();
        $url = $this->content->getTngUrl();
		$photos = $this->content->getTngPhotoFolder();
		$photosPath = $url. $photos;
		$profileImage = $this->content->getProfileMedia($personId);
		$currentBirthday = $this->content->getCurrentBirthday();
        $currentmanniversary = $this->content->getCurrentMAnniversaries();
        $currentdanniversaries = $this->content->getCurrentDAnniversaries();
		$month = date('m');
        $context = array(
            'personId' => $personId,
            'name' => $this->content->getPersonName($personId),
            'profileImage' => $profileImage,
            'birthdays' => $currentBirthday,
            'manniversaries' => $currentmanniversary,
            'danniversaries' => $this->content->getCurrentDAnniversaries(),
            'date' => date("l, jS F Y")
        );
		return $this->templates->render('landing-page.html', $context);
    }
}
