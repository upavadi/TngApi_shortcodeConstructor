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

    function testPrivacy() {
    $content = $this->getContent();
    $currentPerson = $content->getConfigPath();
    return $currentPerson. "This is Testing Privacy function";   
    }

/*** All custom functions below this line please*******/
} /******* CLASS Last Brace ********************************/