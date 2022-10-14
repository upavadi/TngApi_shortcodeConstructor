<?php
/*
 * Plugin Name: TngApiShortcodeConstructor
 * Description: Shortcode constructor for TNG V10 to V13
 *
 * Plugin URI: https://github.com/TngWp/TngApi
 * Version: 1.04 dev (under developement)
 *         
 * Author: Mahesh Upadhyaya. Based on TngApi V3.3x by Neel and Mahesh Upadhyaya
 * Author URI: http://trial.upavadi.net/
 * License: MIT Licence http://opensource.org/licenses/MIT
 *
 *
 */
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/admin_set_paths.php';

static $tngPath;

$tngPath = esc_attr(get_option('tng-api-tng-path') . "config.php");

if (!file_exists($tngPath)) {
	echo "TNG Path not found";
	add_action('admin_notices', 'findTngPath');
}

function findTngPath()
{
static $success, $error;
$error = "<div style='color: red; font-size: 1.2em'>TNG Shortcode Constructor: We need to know where TNG is installed:</div>";
$success = "<div style='color: green; font-size: 1.2em'>Thanks. Found TNG folder. Please refresh screen.</div>"; 
$title = "TNG Shortcode Constructor: We need to know where TNG is installed:";
$rootPath = esc_attr(get_option('tng-api-tng-path')); 

if (!ISSET($_POST['wp_tng_path'])) {
	$_POST['tng-api-tng-path'] = esc_attr(get_option('tng-api-tng-path')); 
	echo "<div class='notice notice-error'>";
	echo $error;	
} else {
	$rootPath = $_POST['wp_tng_path'];
	update_option('tng-api-tng-path', $rootPath);
	echo "<div class='notice notice-success'>";
	echo $success;	
	
}

?>
	<form action='' method="post">
		<div>
			<input type="text" style="width: 250px" name="wp_tng_path" value='<?php if (isset($_POST['wp_tng_path'])) echo ($_POST['wp_tng_path']) ?>' placeholder='TNG Root Path:'>
			TNG Root Path is absolute path to TNG. You may look this up from TNG Admin Setup>Paths and Folders>Root Path or in config.php in TNG folder.
		</div>

		<p>
			<input type="submit" name="Update_wp_tng_Paths" value="Submit"> 
		</p>
		</div>
	</form>
	
<?php

}


if (file_exists($tngPath)) {

	$content = TngWp_ShortcodeContent::instance();
	$p_content = TngWp_PrivacyContent::instance();
	$content->addShortcode(new TngWp_Shortcode_MyShortcode());
	$content->addShortcode(new TngWp_Shortcode_SubmitImage());
	$content->addShortcode(new TngWp_Shortcode_Birthdays());
	$content->addShortcode(new TngWp_Shortcode_Danniversaries());
	$content->addShortcode(new TngWp_Shortcode_Manniversaries());
	$content->addShortcode(new TngWp_Shortcode_ManniversariesDeceased());
	$content->addShortcode(new TngWp_Shortcode_RandomPhotoShortcode());
	$content->addShortcode(new TngWp_Shortcode_RandomMediaShortcode());
	$content->addShortcode(new TngWp_Shortcode_LandingPage());
	$content->addShortcode(new TngWp_Shortcode_Gone());
	$content->addShortcode(new TngWp_Shortcode_TngSearch());
	$tngSearch = new TngWp_Widget_TngSearch;
	
	add_action('init', array($content, 'initVariables'));
	add_action('init', array($content, 'initPlugin'), 1);
	add_action('wp_enqueue_scripts', 'add_TngWp_stylesheets');
	add_action('widgets_init', array($tngSearch, 'init'));
	function add_TngWp_stylesheets()
	{
		wp_register_style('register-tngapi_TngWp', plugins_url('css/TngWp.css', __FILE__));
		wp_enqueue_style('register-tngapi_TngWp');
		wp_register_style('register-tngapi_bootstrap', plugins_url('css/bootstrap.css', __FILE__));
		wp_enqueue_style('register-tngapi_bootstrap');
	}

	//register_activation_hook( __FILE__, 'do_insert_pages' ); 
}