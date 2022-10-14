<?php
/** Random Media shortcode ************
 * [TngWp_RandomMedia]
 * 
 * CSS
 * class random-frame sets the frame
 * random-photo sets the image
 * width is fixed at 220pix
 * 
 * SQL
 * set at default photo = 1 and living = 0
 * or
 * always on = 1
 * OR
 * (mediatypeID = 'documents') 
 * OR
 * (mediatypeID = 'hedstones') 
 * 
 * *************************************/

include($tng_path.'/config.php');

$db = @mysqli_connect($database_host, $database_username, $database_password, $database_name );         
$sql3 = "
SELECT 
	m2.personID,
	m.defphoto,
	mediakey,
    mediatypeID,
	m.mediaID,
	description,
	alwayson

FROM   $media_table as ml
    LEFT JOIN $medialinks_table AS m
              ON ml.mediaID = m.mediaID
	LEFT JOIN $people_table AS m2
			  ON m.personID = m2.personID
where (m.defphoto = 1 AND m2.living = 0) OR (mediatypeID = 'documents') OR (mediatypeID = 'headstones') OR (alwayson = 1) ORDER BY RAND()";

$result2 = $db->query($sql3);
$imgrow = $result2->fetch_assoc();
$showmedia_url = 'showmedia.php?';
$random_href_url = $tng_url. $imgrow['mediakey']; //$tng_img_url;
$random_img_url = $tng_url. $imgrow['mediakey']; //$tng_img_url;
$random_media_url = $tng_url. $showmedia_url. "mediaID=". $imgrow['mediaID']; //$tng_media_url;
$random_media_desc = $imgrow['description'];
$random_mediatypeID = $imgrow['mediatypeID'];
$random_doc_img_url = plugin_dir_url( __DIR__ ). "img/doc01.jpg";

/******************************************
 * Set for documents
 * Image for documents is doc01.jpg in img folder
 *  ***/
if ($random_mediatypeID == 'documents') {
	$random_img_url = plugin_dir_url( __DIR__ ). "img/doc01.jpg";
	$random_href_url = $random_media_url;
}
/******************************************* 
 * Set for Headstones
 *  *********************/
if ($random_mediatypeID == 'headstones') {
	// Set Conditions
}
/******************************************* */

echo '<div class="random-frame">';
echo "<div class=\"\">\n";

echo "<a href=\"{$random_href_url}\"><img class=\"random-photo\" src=\"$random_img_url\" alt=\"{$random_media_desc}\" title=\"{$random_media_desc}\">\n";
echo "<div style=\"padding: 5px\">\n";
echo "<em><a href=\"{$random_media_url}\">{$random_media_desc}</a></em>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>";