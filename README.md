
# TNG SHORTCODES CONSTRUCTOR VERSION 1.0 FOR WORDPRESS

## License
The code is licenced under the [MIT licence](http://opensource.org/licenses/MIT)
- _This allows you to deal with the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so._

- All I ask is that you share your changes, perhaps by creating a  __Github Fork Request__.

## Introduction
__TNG Shortcode Constructor__ is a stripped down version of The [TngApi V3.3.2](https://github.com/upavadi/TngApi/archive/refs/tags/V3.3.2.zip) plugin for Wordpress. 

[TngApi V3.3.2](https://github.com/upavadi/TngApi/archive/refs/tags/V3.3.2.zip), a stand-alone plugin, was published in 2015. It integrates smoothly with TNG ( The Next Generation of Genealogy Sitebuilding ) to display genealogy data in Wordpress pages. 
It's main attraction was the ability of the user to add / amend family data and ability of the administrator to perform one-click transfer of this data to tng database. With changes to MySQL and TNG database structure I have found it virtually imposible to support this feature.

I understand that now, a TNG mod, the [Family Group Worksheet ](https://tng.lythgoes.net/wiki/index.php/Family_Group_Worksheet),has the facility for administrators to merge data in to TNG database.

Plan is to have the __TNG Shortcode Constructor__ do everything the TngApi did, except update TNG data.
- It implements Privacy Credentials in the General SetUp>Privacy
  - Require Login:
  - Show Living Data:
  - Show Names for Private:
  - I may implement the following in the next update
    - Show LDS Data: Current shortcodes do not show LDS data, as do not have LDS data.
    - Restrict access to assigned tree. As I only have one tree, I have not implemented this. Perhaps on next version.

 - It implements Privacy Credentials for the User
    - Allow to view information for living individuals
    - Allow to view information for private individuals
    - I may implement the following in the next update
      - Allow to view LDS information
      - Restrict access to specific trees and branches.

# Change Log
     Current Released Version 1.0

# Setup 

# Tested on
- Wordpress platform: 5.9.3
- PHP version 8.01
- WP-TNG Integration
  - Mike Barnes Method using a [Stripped Down tng.php]( https://github.com/upavadi/TngPluginStripped/blob/master/tng.php) 
   - [Kloosterman method](https://www.kloosterman.be/info/tng-wp-avada/)
- Alongside my plugins, [TngApi V3.3.2](https://github.com/upavadi/TngApi/archive/refs/tags/V3.3.2.zip) and [tng-wp-login v3.1.3.beta](https://github.com/upavadi/tng-wp-login/releases/tag/3.1.3.beta) 


# Shortcodes

- `TngWp_birthdays` List birthdays for the selected month.
- `TngWp_danniversaries` List death anniversaries for the selected month.
- `TngWp_gone` (Gone But Not Forgotten). Gives birth dates and deat hdates for yesterday, today and tomorrow. It is encapsulated in a DIV and it may be possible to include that in your content.
- `TngWp_LandingPage` This is similar to 'TngWp_gone' but has user name, general birthdays and marriage anniversaries, added. 
- `TngWp_manniversaries`
- `TngWp_MyShortcode`
- `TngWp_submitImage`

# To Do
- Assigned Tree: 
- Shortcode for __Family Page__ similar to TngApi
- Shortcode widjet for __TNG Person Search__ similar to TngApi







