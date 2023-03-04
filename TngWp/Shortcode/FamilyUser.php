<?php

class TngWp_Shortcode_FamilyUser extends TngWp_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'TngWp_familyuser';

    //do shortcode Add Family Page
    public function show()
    {
        
        static $userTree, $tngAllowLiving;
        $this->content->init();
        $personId = filter_input(INPUT_GET, 'personId', FILTER_SANITIZE_SPECIAL_CHARS);
        $tree = filter_input(INPUT_GET, 'tree', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = array(); // shortcodeContent array
        $p_content = array(); // privacyContent array
        $content = TngWp_ShortcodeContent::instance(); 
        $p_content = TngWp_PrivacyContent::instance(); 
        $currentPerson = $this->content->getCurrentPersonId();
        $requireLogin = $p_content->requireLogin(); //in setup
        $treeAccess = $p_content->treeAccess(); //in setup
        $tngUser = $this->content->getTngUser();
        $genealogy = $this -> content->getTngIntegrationPath();
        $url = $this -> content->getTngUrl();
        $tngDirectory = basename($url);
        $IntegratedPath = dirname($url). "/". $genealogy;
        $displayButtons = $this -> content->getTngShowButtons();
        $photos = $this->content->getTngPhotoFolder();
        $photosPath = $url. $photos;
        $currentpersonID = $this ->content->getCurrentPersonId();
        $currentperson = $this ->content->getPerson($currentpersonID);
    $currentuser = ($currentperson['firstname'] ." ". $currentperson['lastname']);
   //var_dump($personId);
   $version = $this ->content->guessVersion();
        if(isset($tngUser))
         {
            $tngAllowLiving = $tngUser['allow_living']; 
            $userTree = $tngUser['mygedcom']; 
            $userRestrictTree = $tngUser['gedcom']; 
         }
    //get default media
    $defaultmedia = $this->content->getDefaultMedia($personId, $tree);
    if ($defaultmedia['thumbpath'] == null AND $person['sex'] == "M") {
        $mediaID = $url. "/img/male.jpg";
    }
    if ($defaultmedia['thumbpath'] == null AND $person['sex'] == "F") {
        $mediaID = $url. "/img/female.jpg"; 
    }
    if ($defaultmedia['thumbpath'] !== null) {
        $mediaID = $photosPath. "/" . $defaultmedia['thumbpath'];
}
        $context = array(
            'requireLogin' => $requireLogin,
            'content' => $content,
            'treeAccess' => $treeAccess,
            'tngUser' => $tngUser,
            'tngDirectory' => $tngDirectory,
            'IntegratedPath' => $IntegratedPath,
            'photosPath' => $photosPath,
			'userTree' =>$userTree,
            'genealogy' => $genealogy,
            'url' => $url,
            'mediaID' => $mediaID,
            'tngAllowLiving' => $tngAllowLiving,
            'version' => $version,
            'personId' => $personId,
            'tree' => $tree,
            'currentpersonID' => $currentpersonID,
            'currentuser' => $currentuser
        );
       
        if ($requireLogin == 1 && (!ISSET($tngUser))) {
            /** if not logged in display error ** */
            echo "<div style='color: red; font-size: 1.2em; text-align: center;'>You are not Logged In. Please Login to continue</div>";
        } else {
        return $this->templates->render('familyuser.html', $context);
        }
    }
}