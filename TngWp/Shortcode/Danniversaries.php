<?php
/** Requires LogIn  Requires Tree Access update****/
class TngWp_Shortcode_Danniversaries extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_danniversaries';

    public function show()
    {
        $this->content->init();
		$monthyear = filter_input(INPUT_GET, 'monthyear', FILTER_SANITIZE_SPECIAL_CHARS);
						
		if ($monthyear == "") {
        $month = date('m');
		$year = date('Y');
		} else {
		$month = substr($monthyear, 3, 2);
		$year = substr($monthyear, 6, 4);
		}
		
        /** Access as in SetUp ** */
        $requireLogin = $this->content->requireLogin(); //in setup
        $treeAccess = $this->content->treeAccess(); //in setup
        $tngUser = $this->content->getTngUser();
        $userTree = $tngUser['mygedcom']; 
        $userRestrictTree = $tngUser['gedcom']; 
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
            'userTree' =>$userTree
        );
        if ($requireLogin == 1 && (!ISSET($tngUser))) {
            /** if not logged in display error ** */
            echo "<div style='color: red; font-size: 1.2em; text-align: center;'>You are not Logged In. Please Login to continue</div>";
        } else {
        return $this->templates->render('danniversaries.html', $context);
        }
    }

}
