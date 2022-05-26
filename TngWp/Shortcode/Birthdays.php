<?php
/*********
* LogIn in Setup  
* for Allow Livingp people only
* Requires Tree Access update
*
***/
class TngWp_Shortcode_Birthdays extends TngWp_Shortcode_AbstractShortcode
{

    const SHORTCODE = 'TngWp_birthdays';

    public function show()
    {
        $this->content->init();
        $monthyear = filter_input(INPUT_GET, 'monthyear', FILTER_SANITIZE_SPECIAL_CHARS);
		$currentPerson = $this->content->getCurrentPersonId();
        
		if ($monthyear == "") {
            $month = date('m');
            $year = date('Y');
        } else {
            $month = substr($monthyear, 3, 2);
            $year = substr($monthyear, 6, 4);
        }
        $requireLogin = $this->content->requireLogin(); //in setup
        $treeAccess = $this->content->treeAccess(); //in setup
        $tngUser = $this->content->getTngUser();
        $tngAllowLiving = $tngUser['allow_living']; 
        $userTree = $tngUser['mygedcom']; 
        $userRestrictTree = $tngUser['gedcom']; 

        $birthdays = $this->content->getBirthdays($month);
        foreach ($birthdays as $index => $birthday) {
            $birthdate = strtotime($birthday['birthdate']);
            $age = $year - date('Y', $birthdate);
            $birthdays[$index]['age'] = $age;
        }
        $date = new DateTime();
        $date->setDate($year, $month, 01);
        $context = array(
            'year' => $year,
            'month' => $month,
            'date' => $date,
			'monthyear' => $monthyear,
            'birthdays' => $birthdays,
            'requireLogin' => $requireLogin,
            'treeAccess' => $treeAccess,
			'userTree' =>$userTree,
            'tngAllowLiving' => $tngAllowLiving,
            'currentperson' => $currentPerson
        );
        if ($requireLogin == 1 && (!ISSET($tngUser))) {
            /** if not logged in display error ** */
            echo "<div style='color: red; font-size: 1.2em; text-align: center;'>You are not Logged In. Please Login to continue</div>";
        } else {
        return $this->templates->render('birthdays.html', $context);
        }
    }
}