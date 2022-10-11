<?php
class TngWp_Shortcode_TngSearch extends TngWp_Shortcode_AbstractShortcode
{
    // Shortcode
    const SHORTCODE = 'TngWp_search';
    
    public function show()
    {
        $this->content->init();
        $content = array(); // shortcodeContent array
        $p_content = array(); // privacyContent array
        $content = TngWp_ShortcodeContent::instance(); 
        $p_content = TngWp_PrivacyContent::instance(); 
        $tng_content = $p_content->tngPrivacy(); //general privacy from PrivacyContent
        $user_content = $p_content->userPrivacy(); //User privacy from PrivacyContent
        
        //Define variables here and add to $context  
        $genealogy = $content->getTngIntegrationPath();
        $url = $content->getTngUrl();
        $IntegratedPath = dirname($url). "/". $genealogy. "/";   
        $requireLogin = $tng_content['tng_login'];
        // $treeAccess = $p_content->treeAccess(); //in setup
       $userTree = "";
        if (isset($tngUser)) $userTree = $tngUser['mygedcom']; 
        
                  
        //Sample array for html file.
        
        $firstName = filter_input(INPUT_GET, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastName = filter_input(INPUT_GET, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS); 
        $user = $content->getTngUser();
        $tngFolder = $content->getTngIntegrationPath();

        $context = array(
            'requireLogin' => $requireLogin,
            'user' => $user,
            'url' => $url,
            'userTree' => $userTree,
            'IntegratedPath' => $IntegratedPath,

            'tngFolder' =>$tngFolder
        );
       
        $context['results'] = $this->content->searchPerson($firstName, $lastName);
        
       //This html file to show your page
       return $this->templates->render('tngSearch.html', $context);
    }
 
}