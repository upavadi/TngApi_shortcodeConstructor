<?php
class TngWp_Shortcode_TngSearch extends TngWp_Shortcode_AbstractShortcode
{
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
        $requireLogin = $tng_content['tng_login'];
        $url = $content->getTngUrl();
        $genealogy = $content->getTngIntegrationPath();
        $integratedPath = dirname($url). "/". $genealogy;        
        //Sample array for html file.
        $this->content->init();
        $firstName = filter_input(INPUT_GET, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastName = filter_input(INPUT_GET, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS); 
        $context = array(
            'requireLogin' => $requireLogin,
            'treeAccess' => $treeAccess,
			'userTree' =>$userTree,
            'tngAllowLiving' => $tngAllowLiving
        );
        var_dump($context);
        $context['results'] = $this->content->searchPerson($firstName, $lastName);
        

       //This html file to show your page
       return $this->templates->render('tngSearch.html', $context);
    }
 
}