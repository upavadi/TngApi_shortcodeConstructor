<?php

class TngWp_Shortcode_LandingPage extends TngWp_Shortcode_AbstractShortcode
{

    const SHORTCODE = 'TngWp_LandingPage';
    
    public function show()
    {
        $this->content->init();
        $content = TngWp_ShortcodeContent::instance(); 
        $p_content = TngWp_PrivacyContent::instance(); 

        /** Access as in SetUp ** */
        $requireLogin = $p_content->requireLogin();
        $treeAccess = $p_content->treeAccess();
        $tngUser = $content->getTngUser();
        $personId = $content->getCurrentPersonId();
        $url = $content->getTngUrl();
		$photos = $content->getTngPhotoFolder();
		$photosPath = $url. $photos;
		$profileImage = $content->getProfileMedia($personId);
		$currentBirthday = $content->getCurrentBirthday();
        $currentmanniversary = $content->getCurrentMAnniversaries();
        $currentdanniversaries = $content->getCurrentDAnniversaries();
		$month = date('m');
        $context = array(
            'personId' => $personId,
            'name' => $this->content->getPersonName($personId),
            'profileImage' => $profileImage,
            'birthdays' => $currentBirthday,
            'manniversaries' => $currentmanniversary,
            'danniversaries' => $content->getCurrentDAnniversaries(),
            'date' => date("l, jS F Y")
        );

        if ($requireLogin == '1' && (($tngUser == null))) {
            /** if not logged in display error ** */
            echo "<div style='color: red; font-size: 1.2em; text-align: center;'>You are not Logged In. Please Login to continue</div>";
        } else {        
		return $this->templates->render('landing-page.html', $context);
        }
    }
}
