<?php

class TngWp_PrivacyContent extends TngWp_ShortcodeContent
{

    private static $instance = null;
    protected $shortcodes = array();
    protected $domain;
    private $privacy;

    // public function __construct(Privacy $privacy)
    // {
    //      $this->privacy = $privacy;
    // }

    public static function instance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getContent() {
        return TngWp_ShortcodeContent::instance();
    }

    
    /** Require Login ****/
    function requireLogin() {
        $configPath = $this->getConfigPath();
        include $configPath;
        return $requirelogin;
    }

    /** Restrict Access to tree REMOVE ****/
    function treeAccess() {
        $configPath = $this->getConfigPath();
        include $configPath;
        if ($requirelogin == "1" && $treerestrict == '1')
            $treerestrict = '1';
            return $treerestrict;
    }
        
    

    public function tngPrivacy () {
        $content = $this->getContent();
        $tngPath = $content->getConfigPath();
        include $tngPath;
        /** from TNG general set up *****/ 
        $tng_context = array();
        $tng_context['tng_login'] = $requirelogin; //Require Login, No – 0,	Yes – 1
        $tng_context['tng_treerestrict'] = $treerestrict;//Restrict access Tree,	No – 0,	Yes – 1	if logged in =1
        $tng_context['tng_lds'] = $ldsdefault; //Show LDS Data,	Never – 1,	Always – 0,	User Rights = 2
        $tng_context['tng_living'] = $livedefault; //Show Living Data,	Never – 1,	Always – 2,	User Rights = 0
        $tng_context['tng_showNames'] = $nonames; //Show Names of Living, No –1, Yes – 0,	Abbriviate 1st name – 2
        $tng_context['tng_showNamesPrivate'] = $tngconfig['nnpriv']; //Show Names Private, No –1,	Yes – 0, 	Abbriviate 1st name – 2
        return $tng_context;
    }

    public function userPrivacy() {
        $content = $this->getContent();
        $tngUser = $content->getTngUser();
        /** from TNG User *****/ 
        $user_context = array();
        if(isset($tngUser)) {
       $user_context['living'] = $tngUser['allow_living']; // Show Living Data
       $user_context['private'] = $tngUser['allow_private']; // Show Private Individuals
       $user_context['lds'] = $tngUser['allow_lds']; //Show LDS Data	allow_lds
       $user_context['usertree'] = $tngUser['mygedcom']; //User Tree	mygedcom
       $user_context['accesstree'] = $tngUser['gedcom']; // TREE ACCSS
       }
      return $user_context;
    }

/********************do Privacy ********************************** */
    public function doPrivacy($personId = null, $tree = null) {
        $defaultmedia = '';
        $age = "";
        $years = "";
        $content = $this->getContent();
        $tngPath = $content->getConfigPath();
        include $tngPath;
        $user = $this->userPrivacy() ?? "";
        $userPrivate = $this->userPrivacy()['private'] ?? "";
        $media = $content->getDefaultMedia($personId, $tree);
        if(isset($media['thumbpath'] ))
        $defaultmedia = $tngdomain. $photopath. "/". $media['thumbpath'] ;
        $content = $this->getContent();
        $person = $content->getPerson($personId);
        $personPrivate = $person['private'];
        $tng_NamesPrivate = $this->tngPrivacy()['tng_showNamesPrivate'];
    
        $showAll = $this->showAll($personId, $defaultmedia);
        $showNamesNoData =$this-> showNamesNoData($personId, $defaultmedia);
        $showLivingNoData = $this->showLivingNoData($personId, $defaultmedia);
        $showPrivateNoData = $this->showPrivateNoData($personId, $defaultmedia);
        $showAbbriviateNoData = $this->showAbbriviateNoData($personId, $defaultmedia);
        

        //USER CAN SEE PRIVATE
        if ($userPrivate == 1 && $personPrivate == 1) 
        return $showAll;
       
        //LOGGED IN user can see LIVING - can not see Private        
        if (($userPrivate == '0' || $userPrivate == '') && $personPrivate == 1 )
        {
            if ($tng_NamesPrivate == '2')
            return $showAbbriviateNoData;
            if ($tng_NamesPrivate == '1')
            return $showPrivateNoData;
            if ($tng_NamesPrivate == '0')
            return $showNamesNoData;
        } else {
        return $showAll;
    }
        
    }
/*****************************doLiving***********************************/
    public function doLiving($personId = null, $tree = null) {
        $defaultmedia = '';
        $age = "";
        $years = "";
        $content = $this->getContent();
        $personLiving = $content->getPerson($personId);
        $userLiving = "";
        $userLiving = $this->userPrivacy()['living'] ?? "";
        $userPrivate = $this->userPrivacy()['private'] ?? ""; 
        $tng_login = $this->tngPrivacy()['tng_login'];
        $tng_treerestrict = $this->tngPrivacy()['tng_treerestrict'];
        $tng_living = $this->tngPrivacy()['tng_living'];
        $tng_showNames = $this->tngPrivacy()['tng_showNames'];
        $tng_NamesPrivate = $this->tngPrivacy()['tng_showNamesPrivate'];
              
        $tngPath = $content->getConfigPath();
        include $tngPath;
        $set_living = $livedefault;
        $media = $content->getDefaultMedia($personId, $tree);
        if(isset($media['thumbpath'] ))
        $defaultmedia = $tngdomain. $photopath. "/". $media['thumbpath'] ;
        
        $showAll = $this->showAll($personId, $defaultmedia);
        $showNamesNoData =$this-> showNamesNoData($personId, $defaultmedia);
        $showLivingNoData = $this->showLivingNoData($personId, $defaultmedia);
        $showPrivateNoData = $this->showPrivateNoData($personId, $defaultmedia);
        $showAbbriviateNoData = $this->showAbbriviateNoData($personId, $defaultmedia);
       
        //LOGGED IN user can see LIVING - can not see Private
        if ($userLiving == '1') {
            if ($userPrivate == '0' && $personLiving['private'] == 1 )
            {
                if ($tng_NamesPrivate == '2')
                return $showAbbriviateNoData;
                if ($tng_NamesPrivate == '1')
                return $showPrivateNoData;
                if ($tng_NamesPrivate == '0')
                return $showNamesNoData;
           
            }
             
        return $showAll;
        }
        
        // Show Living Always = 2
        if ($tng_living == 2 || $personLiving['living'] == '0') return $showAll;
        
        if ($tng_showNames == 0 && ($tng_living == 1 || $tng_living == 0))
            return $showNamesNoData;
        
        if ($tng_showNames == 1 && ($tng_living == 1 || $tng_living == 0))
        return $showLivingNoData;

        if ($tng_showNames == 2 && ($tng_living == 1 || $tng_living == 0))
        return $showAbbriviateNoData;
          
    }

/**************** doManniversaryLiving ****************************** */
    public function doManniversaryLiving($personId1 = null, $personId2 = null) {
        $personId = $personId1;
        $living1 = $this->doLiving($personId1);
        $living2 = $this->doLiving($personId2);
       
        $family = array(

           'gedcom' =>$living1['gedcom'],
         'firstname1'  => $living1['firstname'],
         'lastname1'  => $living1['lastname'],
         'firstname2'  => $living2['firstname'],
         'lastname2'  => $living2['lastname'],
         'defaultmedia1' => $living1['defaultmedia'],
         'defaultmedia2' => $living2['defaultmedia']

        );
       return ($family);
    }
/****************************************************** */

    public function showAll($personId, $defaultmedia) {
        //Show All - $livedefault = 2
        $content = $this->getContent();
        $personLiving = $content->getPerson($personId);
        $allow_living['firstname'] = $personLiving['firstname'];
        $allow_living['lastname'] = $personLiving['lastname'];
        $allow_living['gedcom'] = $personLiving['gedcom'];
        $allow_living['birthdate'] = $personLiving['birthdate'];
        $allow_living['birthplace'] = $personLiving['birthplace'];
        $allow_living['deathdate'] = $personLiving['deathdate'];
        $allow_living['deathplace'] = $personLiving['deathplace'];
        $allow_living['living'] = $personLiving['living'];
        $allow_living['private'] = $personLiving['private'];
        $allow_living['branch'] = $personLiving['branch'];
        $allow_living['prefix'] = $personLiving['prefix'];
        $allow_living['suffix'] = $personLiving['suffix'];
        $allow_living['defaultmedia'] = $defaultmedia;
        return $allow_living;
    }

    public function showNamesNoData($personId, $defaultmedia) {
        //Show Names, No Data, $livedefault = 0 or 1, $nonames = 0
            $content = $this->getContent();
            $personLiving = $content->getPerson($personId);
            static $age, $years;
            $age = "";
            $yars = "";
            $allow_living['firstname'] = $personLiving['firstname'];
            $allow_living['lastname'] = $personLiving['lastname'];
            $allow_living['gedcom'] = $personLiving['gedcom'];
            $allow_living['birthdate'] = "";
            $allow_living['birthplace'] = "";
            $allow_living['deathdate'] = "";
            $allow_living['deathplace'] = "";
            $allow_living['living'] = $personLiving['living'];
            $allow_living['private'] = $personLiving['private'];
            $allow_living['branch'] = $personLiving['branch'];
            $allow_living['prefix'] = "";
            $allow_living['suffix'] = "";
            $allow_living['defaultmedia'] = "";
            $allow_living['years'] = "";
            $allow_living['age'] = "";
            return $allow_living;
        }

    public function showLivingNoData($personId, $defaultmedia) {
    //Living - $livedefault = 0, 1 $nonames = 0
        $content = $this->getContent();
        $personLiving = $content->getPerson($personId);
        static $age, $years;
        $age = "";
        $yars = "";
        $allow_living['firstname'] = "Living";
        $allow_living['lastname'] = "Details Withheld";
        $allow_living['gedcom'] = $personLiving['gedcom'];
        $allow_living['birthdate'] = "";
        $allow_living['birthplace'] = "";
        $allow_living['deathdate'] = "";
        $allow_living['deathplace'] = "";
        $allow_living['living'] = $personLiving['living'];
        $allow_living['private'] = $personLiving['private'];
        $allow_living['branch'] = $personLiving['branch'];
        $allow_living['prefix'] = "";
        $allow_living['suffix'] = "";
        $allow_living['defaultmedia'] = "";
        $allow_living['years'] = "";
        $allow_living['age'] = "";
        return $allow_living;
    }

    public function showAbbriviateNoData($personId, $defaultmedia) {
    //Abbriviate  - $livedefault = 0, 1 - $nonames = 1
        $content = $this->getContent();
        $personLiving = $content->getPerson($personId);
        static $age, $years;
        $age = $years = "";
        $firstname = ""; 
        $name = $personLiving['firstname'];            
        $words = array();
        $name = ucwords($name);
        $words = explode(" ", "$name");
        foreach($words as $word){
            if (isset($word[0])) $firstname .= $word[0]. ". ";
        }
        $allow_living['firstname'] = $firstname;
        $allow_living['lastname'] = $personLiving['lastname'];
        $allow_living['gedcom'] = $personLiving['gedcom'];
        $allow_living['birthdate'] = "";
        $allow_living['birthplace'] = "";
        $allow_living['deathdate'] = "";
        $allow_living['deathplace'] = "";
        $allow_living['living'] = $personLiving['living'];
        $allow_living['private'] = $personLiving['private'];
        $allow_living['branch'] = $personLiving['branch'];
        $allow_living['prefix'] = "";
        $allow_living['suffix'] = "";
        $allow_living['defaultmedia'] = "";
        $allow_living['years'] = $years;
        $allow_living['age'] = $age;
        return $allow_living;
    }

    public function showPrivateNoData($personId, $defaultmedia) {
    //$livedefault = 2
        $content = $this->getContent();
        $personLiving = $content->getPerson($personId);
        static $age, $years;
        $allow_living['firstname'] = "Private";
        $allow_living['lastname'] = "Details Withheld";
        $allow_living['gedcom'] = $personLiving['gedcom'];
        $allow_living['birthdate'] = "";
        $allow_living['birthplace'] = "";
        $allow_living['deathdate'] = "";
        $allow_living['deathplace'] = "";
        $allow_living['living'] = $personLiving['living'];
        $allow_living['private'] = $personLiving['private'];
        $allow_living['branch'] = $personLiving['branch'];
        $allow_living['prefix'] = "";
        $allow_living['suffix'] = "";
        $allow_living['defaultmedia'] = "";
        $allow_living['years'] = "";
        $allow_living['age'] = "";
        return $allow_living;
    }
    

/*** All custom functions below this line please*******/
} /******* CLASS Last Brace ********************************/