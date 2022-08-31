<?php
//TNG Paths are derived from TNG config.php.
/************************************************ */

/**** Set sub menu for shortcodes */
add_action("admin_menu", "short_code_submenu");
function short_code_submenu() {
  add_submenu_page(
        'options-general.php',
        'WP TNG Shortcodes Option',
        'TNG Shortcodes',
        'administrator',
        'shortcode-options',
        'shortcode_options_page' );
}


/***  sub menu page ****/
function shortcode_options_page()
{
	static $author_id;

	$tng_root_path = esc_attr(get_option('tng-api-tng-path'));
	$tng_url = esc_attr(get_option('tng-api-tng-url'));
	$tng_photo_folder = esc_attr(get_option('tng-api-tng-photo-folder'));
	$tng_integration_path = esc_attr(get_option('tng-base-tng-path'));
	$tng_collection_id = esc_attr(get_option('tng-api-tng-photo-upload'));
	$tng_name_search = esc_attr(get_option('tng-api-tng-name-search'));
	$success = "";

	if (isset(($_POST['tng_root_path']))) {
		//var_dump($_POST);
		$tng_root_path = $_POST['tng_root_path'];
		$tng_url = $_POST['tng_url'];
		$tng_photo_folder = $_POST['tng_photo_folder'];
		$tng_integration_path = $_POST['tng_integration_path'];
		$tng_collection_id = $_POST['tng_collection_id'];
		$tng_name_search = $_POST['tng_name_search'];
	
		update_option('tng-api-tng-path', $tng_root_path);
		update_option('tng-api-tng-url', $tng_url);
		update_option('tng-api-tng-photo-folder', $tng_photo_folder);
		update_option('tng-base-tng-path', $tng_integration_path);
		update_option('tng-api-tng-photo-upload', $tng_collection_id);
		update_option('tng-api-tng-name-search', $tng_name_search);
		$success = "Changes Saved";
	}
	?>

	<form action=''  method="post">
	<div>
	<h1>Plugin Paths:-</h1>
	</div>
	<p style="font-size: large; color: red">
	The values are shared with TngApi plugin.<br />
	These values would have been setup on first activation. Values mirror values in config.php, in TNG root.

	</p>
	<div>
		<table>
			<tr>
				<td>
				TNG Root Path: 	
				</td>
				<td>
				<input type="text" size="30" name="tng_root_path" value= '<?php echo $tng_root_path; ?>'>
				</td>
				<td>
				TNG Root Path is absolute path to TNG. You may look this up from TNG Admin Setup or config.php ($rootpath) in TNG folder.
				</td>
			</tr>
			<tr>
				<td>
				URL to TNG Folder: 	
				</td>
				<td>
				<input type="text" size="30" name="tng_url" value= '<?php echo $tng_url; ?>'>	
				</td>
				<td>
				TNG URL is path to TNG (http://www.mysite.com/tng). You may look this up from TNG Admin Setup or config.php ($tngdomain) in TNG folder.
				</td>
			</tr>
			<tr>
				<td>
				TNG Photo Folder: 	
				</td>
				<td>
				<input type="text" size="30" name="tng_photo_folder" value= '<?php echo $tng_photo_folder; ?>'>	
				</td>
				<td>
				Name of TNG Photo Folder. Derived from TNG setup.
				</td>
			</tr>
			<tr>
				<td>
				TNG Integration Path: 	
				</td>
				<td>
				<input type="text" size="30" name="tng_integration_path" value= '<?php echo $tng_integration_path; ?>'>	
				</td>
				<td>
				Enter TNG folder name here. If you are using Wordpress Integration by Mark Barnes, enter the name of the page you have specified to display TNG pages within Wordpress container. Otherwise enter name of TNG folder.
				</td>
			</tr>
			<tr>
				<td>
				TNG Collection ID <br /> for Photo Uploads: 	
				</td>
				<td>
				<input type="text" size="30" name="tng_collection_id" value= '<?php echo $tng_collection_id; ?>'>	
				</td>
				<td>
				User images are uploaded in to one of TNG folders with the collection name specified by you in the admin set up. Enter the name for the collection you have set up in TNG admin > media. Mine is called “My Uploads”. 
				</td>
			</tr>
			<tr>
			<tr>
			<td> <b>TNG Search Widget</b></td>
			<td>requires a Wordpress page to display results.</td>
			<td>Enter unique page name (slug). Leave blank if you are not using the TNG widget</td>
			</tr>	
				<td>
				WP Page for Search Widget: 	
				</td>
				<td>
				<input type="text" size="30" name="tng_name_search" value= '<?php echo $tng_name_search; ?>'>	
				</td>
				<td>
				Enter name (slug) for Wordpress page. Avoid using 'search' if you are using, or have used TngApi plugin.
				</td>
			</tr>

		</table>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="Update_Paths" value="Update Paths">
	</p>

	</form>
</div>
<?php
 var_dump($_POST);
 if(($tng_name_search))
/***************** */
//function insert_tng_search_page($tng_name_search) {
	// Insert tng Search Page
	$slug = $tng_name_search;
	$post_content = '[TngWp_search]';
	$author_id = 1;
	$title = 'TNG Name Search';
	if(isset($slug)) echo "Slug is set";
	insert_page($slug, $post_content, $author_id, $title);

}