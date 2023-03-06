
## TNG SHORTCODE CONSTRUCTOR FOR WORDPRESS

## Download
You may download latest version, V1.04, [here.](https://github.com/upavadi/TngApi_shortcodeConstructor/releases/latest)

Repository for the Current Development, Version V1.05, is [here](https://github.com/upavadi/TngApi_shortcodeConstructor)


## License
The code is licenced under the [MIT licence](http://opensource.org/licenses/MIT)
- _This allows you to deal with the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so._

- All I ask is that you share your changes, perhaps by creating a  __Github Fork Request__.

## Introduction
__TNG Shortcode Constructor__ is a stripped down version of The [TngApi V3.3](https://github.com/upavadi/TngApi/archive/refs/tags/V3.3.2.zip) plugin for Wordpress. 

[TngApi V3.3](https://github.com/upavadi/TngApi/archive/refs/tags/V3.3.2.zip), a stand-alone plugin, was published in 2015. It integrates smoothly with [TNG (The Next Generation of Genealogy Sitebuilding)](http://www.tngsitebuilding.com/) to display genealogy data in Wordpress pages. 
It's main attraction was the ability of the user to add / amend family data and ability of the administrator to perform one-click transfer of this data to tng database. With changes to MySQL and TNG database structure, I have found it virtually imposible to support this feature.

I understand that, now, a TNG mod, the [Family Group Worksheet ](https://tng.lythgoes.net/wiki/index.php/Family_Group_Worksheet), has the facility for administrators to merge data in to TNG database.

Plan is to have the __TNG Shortcode Constructor__ do everything the TngApi did, except update TNG data.
- It implements Privacy Credentials in the TNG General SetUp>Privacy
  - Require Login:
  - Show Living Data:
  - Show Names for Living:
  - Show Names for Private:
  - I may implement the following in the next update
    - Show LDS Data: Current shortcodes do not show LDS data, as do not have LDS data my database.
    - Restrict access to assigned tree. As I only have one tree, I have not implemented this. Perhaps on next version.

 - It implements Privacy Credentials for the User
    - Allow User to view information for living individuals
    - Allow User to view information for private individuals
  - I may implement the following in the next update
      - Allow User to view LDS information
      - Restrict User access to specific trees and branches.

# Change Log
- __Current Released Version V1.05__
 - Added __shortcode `TngWp_familyuser`__. A reconstructed family page from my TngApi plugin. 
   - As the default person for this page is the logged-in User, the page is only available to logged-in users.  
    I am open to suggestions if this has to be changed.
   - Displays All family data including notes and media 
   - Option to upload Profile Image
   - Option (in Settings) to display Button Links to TNG Person, Ancestors and Descendents.
    - Option (in Settings) to track ONE Special Event. Please note that if there are more than on entry for that person, only first one will be displayed.
  - Added files,
    - /TngWp/Shortcode/FamilyUser
    - /templates/Familyuser.html
    - /templates/processupload
 - Modified files,
   - tng-shortcode-constructor
   - /TngWp/ShortcodeContent
   - /css/tngwp
   - this file, readme

- __1.04a__
  - Corrected stupid typo in tng-shortcode-constructor.php which prevented style sheet, tngwp.css, to load
  - Style Sheet Bootstrap.css seems to cause conflicts in some themes.  
    - Modified admin_set_paths.php to add an option to disable bootstrap.css in Settings>TNG Shortcodes.
    - Modified option to load bootstrap.css in tng-shortcode-constructor.php

- __1.04__
  - Added Legacy Widget, `TngWp_search` which searches names in TNG database.
    - The widget requires a Wordpress page to display search results.
    - Page Name, "TNG Name Search", which is same as Widget name, is defined in /widget/TngSearch.php
    - The widget obeys credentials setup in TNG admin.
    - To create the Wordpress page, navigate to Settings>TNG Shortcodes and enter a page name (slug) such as tng-search. __Do not leave blanks__ 
        - A Wordpress page will be created, with shortcode as content, when changes are saved.
        - Do not leave space between words such as "tng search"
        - Avoid using __"search"__ as page name as this may clash with the widget in TngApi.
    - Widget will only be activate if a Wordpress page for the widget is created and page name is shown in the Plugin Paths.
    - Note: I use [a Wordpress Classic Widget Plugin](https://en-gb.wordpress.org/plugins/classic-widgets/) to work in the Widget area. Makes it very easy to work with Legacy Widgets.<br/><br/> 

  - Added shortcode, `TngWp_RandomMedia` which is set to display 
    - Default images of deceased
    - images set to "AlwaysOn" 
    - headstones
    - For Documents, default image, /img/doc01.jpg, is shown, with description and link of the document. 
    - This is added subsequent to user request and it may be modified to suit user needs.  
    - Display of Document is fluid and I am open to suggestions.<br/><br/>    
  
  - Added shortcode, `TngWp_RandomPhoto` which is set to display images of deceased OR images set to be 'always on'. 
    - current condition is set to display default images of deseased OR images marked as 'Always On' 
    - This is added susequent to user request and it may be modified to suit user needs.  
    - Functionality may change depending on comments / suggestions from users<br/><br/>    

  - Added shortcode `TngWp_manniversariesDeceased` which Calculates years between marriage and first death.
    - This shortcode adds extra column to `TngWp_manniversaries`, with header title “Years - First Death”. This displays years between marriage date and first death. Feel free to suggest changes in header titles. For test purposes, this column will display “Living” if both spouses are living.<br/><br/>

- __1.02__
  - Special characters (eg Norwegian Æ, Ø, Å ) from TNG database showing up as ? or similar. A charset to UTF applied to all TNG tables in 'shortcodeContent.php' 
- __1.01__
  -Incorrect file name /TngWp/shortcodes/gone.php. Changed to /TngWp/shortcodes/Gone.php.
  - Omitted to add /templates in gone.html.php. Fixed
  - Undeclared variable when using PHP 8.01 in /templates in gone.html.php Fixed
- Released Version 1.0

# Setup
The plugin should work with all versions of TNG. 
- Plugin obtains it's credentials from TNG setup. 
- Plugin shares it's variables with TngApi
- Plugin Settings are in Wordpress Admin>Settings
- The variables are
  - __TNG Root Path:__ TNG Root Path is the absolute path to TNG. You may look this up from TNG Admin Setup or config.php ($rootpath) in TNG folder.
  - __URL to TNG Folder:__ TNG URL is path to TNG (http://www.mysite.com/tng). You may look this up from TNG Admin Setup or config.php ($tngdomain) in TNG folder. 
  - __TNG Photo Folder:__ Name of TNG Photo Folder. Derived from TNG setup.
  - __TNG Integration Path__ Enter TNG folder name here. If you are using Wordpress Integration by Mark Barnes, enter the name of the page you have specified to display TNG pages within Wordpress container. __Otherwise enter name of TNG folder__. 
  - __TNG Collection ID for Photo Uploads:__ 		User images are uploaded in to one of TNG folders with the collection name specified by you in the admin set up. Enter the name for the collection you have set up in TNG admin > media. _Mine is called “My Uploads”_. 

  __Important Variable is the TNG Root Path. If it can not find the TNG file it will complain, bitterly.__


# Tested on
- Wordpress platform: 5.9.3
- PHP version 7.xx and 8.01
- WP-TNG Integration
  - Mike Barnes Method using a [Stripped Down tng.php]( https://github.com/upavadi/TngPluginStripped/blob/master/tng.php) 
   - [Kloosterman method](https://www.kloosterman.be/info/tng-wp-avada/)
- Alongside my plugins, [TngApi V3.3.2](https://github.com/upavadi/TngApi/archive/refs/tags/V3.3.2.zip) and [tng-wp-login v3.1.3.beta](https://github.com/upavadi/tng-wp-login/releases/tag/3.1.3.beta) 


# Other Shortcodes

- `TngWp_birthdays` List birthdays for the selected month.
- `TngWp_danniversaries` List death anniversaries for the selected month.
- `TngWp_gone` (Gone But Not Forgotten). Gives birth dates and death dates for yesterday, today and tomorrow. It is encapsulated in a DIV and it may be possible to include that in your content. ( I have used similar in [my Home Page](http://www.upavadi.net/))
- `TngWp_LandingPage` This is similar to 'TngWp_gone' but has user name, birthdays, marriage anniversaries and death anniversaries added. 
- `TngWp_manniversaries` List of marriage anniversaries for the selected month.
- `TngWp_MyShortcode` __Template for adding your own shortcode__
- `TngWp_submitImage` Upload images from Wordpress. Image will be stored in a TNG Media Collection specified by you.

# Add Your Own Shortcode
 - Create a file for your page. (e.g. myShortcode.html.php)
 - Create a file with the class for the shortcode (e.g. myShortcode.php)
   
        class TngWp_Shortcode_MyShortcode extends TngWp_Shortcode_AbstractShortcode
         {
          const SHORTCODE = 'TngWp_MyShortcode'; //This is your shortcode name
          
           public function show()
          {
            // This may best place to define general variables.
            //Array $conext will be available in your page.
            $context = array(        
            );
           //This html file will show your page
           return $this->templates->render('myshortcode.html', $context);
          }
        }
  
 - Add Short code class in the plugin file tng-shortode-constructop.php

        $content->addShortcode(new TngWp_Shortcode_MyShortcode());
    
- Hopefully, that Should work
# To Do
- Add Privacy Credentials for Assigned Tree
- Add Privacy Credentials for LDS Data 
- Shortcode for __Family Page__ similar to TngApi
- Shortcode widjet for __TNG Person Search__ similar to TngApi

# Patches & contributions

This is very much a project that can evolve so please feel free to fork and submit pull requests.

I would really love to have your feedback, so if you download, let me know. Thanks.







