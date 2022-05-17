<?php

class TngWp_Shortcode_Manniversaries extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_manniversaries';

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
						
       $manniversaries = $this->content->getMarriageAnniversaries($month);
            $date = new DateTime();
        $date->setDate($year, $month, 01);
		       		
		$context = array(
            'year' => $year,
			'month' => $month,
            'date' => $date,
			'manniversaries' => $manniversaries,
			'currentperson' => $currentPerson
        );
        return $this->templates->render('manniversaries.html', $context);
    }
}
