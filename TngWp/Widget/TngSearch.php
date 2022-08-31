<?php
/***************************************************************
Adds a sidebar widget to let users search TNG Database for names
****************************************************************/
class TngWp_Widget_TngSearch implements TngWp_Widget_WidgetInterface
{

    public function init()
    {

    // Check for the required plugin functions.
        if (!function_exists('wp_register_sidebar_widget')) return;
 
         wp_register_sidebar_widget( __CLASS__ . '_widget', 'TNG Search', array($this, 'TngSearch'));

    // This registers our optional widget control form. Because of this our widget will have a button that reveals a 300x100 pixel form.
        wp_register_widget_control(__CLASS__ . '_control', 'TNG Search', array($this, 'TngSearchControl'), 300, 100);
        
    }

    // This is the function that outputs the TNG search form.
    function TngSearch($args)
    {
        global $lastName, $firstName, $title;
        extract($args);

    // Each widget can store its own options. We keep strings here.
        $options = get_option('widget_Tngsearch', false);
       if (isset($options['title'])) $title = $options['title']; 
       
    // These lines generate our output.
        $tng_name_search = esc_attr(get_option('tng-api-tng-name-search')); // this is the page to display resullt
    
    //Set Variables
        $content = array(); // shortcodeContent array
        $p_content = array(); // privacyContent array
        $content = TngWp_ShortcodeContent::instance(); 
        $p_content = TngWp_PrivacyContent::instance(); 
        $requireLogin = $p_content->requireLogin(); //in setup
        $userLoggedIn = (is_user_logged_in()); // change this to tngUser, later

       
       
        if(!$requireLogin || ($requireLogin && $userLoggedIn)) {
            echo $before_widget . $before_title . $title . $after_title;
            $url_parts = parse_url(get_bloginfo('url'));
        ?>
            
        <div>
            <form action= "<?php echo "/". $tng_name_search; ?>" style="display: inline-block;" method="get">
                <label for="top-search-firstname">First Name: <input  style="width: 100px; height: 20px; font-family: Arial, Helvetica, Tahoma" type="text" value="<?php echo $firstName; ?>" name="firstName" id="top-search-firstname"></label>
                <label for="top-search-lastname">Last Name: <input style="width: 100px; height: 20px; font-family: Arial, Helvetica, Tahoma" type="text" value="<?php echo $lastName; ?>" name="lastName" id="top-search-lastname"></label> 
                <input type="submit" style="margin: 4px 0 5px;" value="Search Tree">
            </form></div>


        <?php
        echo $after_widget;
        }
    }

    // This is the function that outputs the form to let the users edit the widget's title. 
    public function TngSearchControl()
    {

    // Get our options and see if we're handling a form submission.
        $options = get_option('widget_tngsearch');
        if (!is_array($options))
            $options = array('title' => '', 'results' => __('TNG Search', 'widgets'));
        if ($_POST['tngsearch-submit']) {
            $options['title'] = strip_tags(stripslashes($_POST['tngsearch-title']));
            $options['results'] = strip_tags(stripslashes($_POST['tngsearch-results']));
            update_option('widget_tngsearch', $options);
        }

    // Be sure you format your options to be valid HTML attributes.
        $title = htmlspecialchars($options['title'], ENT_QUOTES);
        $results = htmlspecialchars($options['results'], ENT_QUOTES);
    }
}
