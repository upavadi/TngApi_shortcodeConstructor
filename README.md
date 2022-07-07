
# TNG SHORTCODES CONSTRUCTOR Version 1.0 FOR WORDPRESS

## License
The code is licenced under the [MIT licence](http://opensource.org/licenses/MIT)
- _This allows you to deal with the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so._
- All I ask is that you share your changes, perhaps by creating a  __Github Pull Request__.

## Introduction
TNG Shortcode Constructor is a stripped down version of The TngApi plugin for Wordpress. 

[TngApi V3.3.2](https://github.com/upavadi/TngApi/archive/refs/tags/V3.3.2.zip) is a stand-alone plugin, published in 2015. It integrates smoothly with TNG ( The Next Generation of Genealogy Sitebuilding ) to display genealogy data in Wordpress pages. 
It's main attraction was the ability of the user to add / amend family data and ability of the administrator to perform one-click transfer of this data to tng database. With changes to MySQL and TNG database structure I have found it virtually imposible to support this feature.

Plan is to have the Shortcode Constructor do everything the TngApi did, except update TNG data. 


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
- `TngWp_gone` Gone But Not Forgotten. 
- `TngWp_LandingPage`
- `TngWp_manniversaries`
- `TngWp_MyShortcode`
- `TngWp_submitImage`

# To Do
- Assigned Tree: 
- Shortcode for __Family Page__ similar to TngApi
- Shortcode widjet for __TNG Person Search__ similar to TngApi






