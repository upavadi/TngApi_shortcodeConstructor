<?php
/*********
* LogIn in Setup  
* Allow Livingp people only
* Requires Tree Access update
*
***/
class TngWp_Shortcode_Manniversaries extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_manniversaries';

    public function show()
    {
         $this->content->init();
         $p_content = array(); // privacyContent array
         $content = TngWp_ShortcodeContent::instance(); 
         $p_content = TngWp_PrivacyContent::instance(); 
        
        $monthyear = filter_input(INPUT_GET, 'monthyear', FILTER_SANITIZE_SPECIAL_CHARS);
        $currentPerson = $this->content->getCurrentPersonId();
			
		if ($monthyear == "") {
        $month = date('m');
		$year = date('Y');
		} else {
		$month = substr($monthyear, 3, 2);
		$year = substr($monthyear, 6, 4);
		}
        /** Access as in SetUp ** */
        $requireLogin = $p_content->requireLogin(); //in setup
        $treeAccess = $this->content->treeAccess(); //in setup
        $tngUser = $this->content->getTngUser();
        $tngAllowLiving = $tngUser['allow_living']; 
        $userTree = $tngUser['mygedcom']; 
        $userRestrictTree = $tngUser['gedcom']; 
		$manniversaries = $this->content->getMarriageAnniversaries($month);
        $date = new DateTime();
        $date->setDate($year, $month, 01);
		       		
		$context = array(
            'year' => $year,
			'month' => $month,
            'date' => $date,
            'requireLogin' => $requireLogin,
            'treeAccess' => $treeAccess,
            'userTree' =>$userTree,
            'manniversaries' => $manniversaries,
            'tngAllowLiving' => $tngAllowLiving,
			'currentperson' => $currentPerson
        );
        if ($requireLogin == '1' && (($tngUser == null)))  {
            /** if not logged in display error ** */
            echo "<div style='color: red; font-size: 1.2em; text-align: center;'>You are not Logged In. Please Login to continue</div>";
        } else {
        return $this->templates->render('manniversaries.html', $context);
        }
    }
}
