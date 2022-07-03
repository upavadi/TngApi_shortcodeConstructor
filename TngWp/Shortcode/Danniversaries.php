<?php
/** Requires LogIn in Setup  Requires Tree Access update****/
class TngWp_Shortcode_Danniversaries extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_danniversaries';

    public function show()
    {
        $this->content->init();
        $content = array(); // shortcodeContent array
        $p_content = array(); // privacyContent array
        $content = TngWp_ShortcodeContent::instance(); 
        $p_content = TngWp_PrivacyContent::instance(); 
        $tng_content = $p_content->tngPrivacy(); //general privacy from PrivacyContent
        $user_content = $p_content->userPrivacy(); //User privacy from PrivacyContent
                   
        $monthyear = filter_input(INPUT_GET, 'monthyear', FILTER_SANITIZE_SPECIAL_CHARS);
		if ($monthyear == "") {
        $month = date('m');
		$year = date('Y');
		} else {
		$month = substr($monthyear, 3, 2);
		$year = substr($monthyear, 6, 4);
		}

		/** Access as in SetUp ** */
        $requireLogin = $p_content->requireLogin();
        $treeAccess = $p_content->treeAccess();
        $tngUser = $content->getTngUser();
        $userTree = "";
        if(isset($tngUser['mygedcom'])) {
        $userTree = $tngUser['mygedcom'];
        $userRestrictTree = $tngUser['gedcom']; 
        }
        
        $photos = $this->content->getTngPhotoFolder();
        $danniversaries = $this->content->getDeathAnniversaries($month);
        $date = new DateTime();
        $date->setDate($year, $month, 01);
		    		
		$context = array(
            'year' => $year,
			'month' => $month,
            'date' => $date,
            'requireLogin' => $requireLogin,
            'treeAccess' => $treeAccess,
			'danniversaries' => $danniversaries,
            'photos' =>$photos,
            'userTree' =>$userTree
        );
        if ($requireLogin == '1' && (($tngUser == null))) {
            /** if not logged in display error ** */
            echo "<div style='color: red; font-size: 1.2em; text-align: center;'>You are not Logged In. Please Login to continue</div>";
        } else {
        return $this->templates->render('danniversaries.html', $context);
        }
    }

}