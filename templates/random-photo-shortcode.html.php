<?php
/** Random Photo shortcode ************
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
 * 
 * *************************************/

include($tng_path.'/config.php');

$db = @mysqli_connect($database_host, $database_username, $database_password, $database_name );         
$sql3 = "
SELECT 
	m2.personID,
	m.defphoto,
	mediakey,
	m.mediaID,
	description,
	alwayson

FROM   $media_table as ml
    LEFT JOIN $medialinks_table AS m
              ON ml.mediaID = m.mediaID
	LEFT JOIN $people_table AS m2
			  ON m.personID = m2.personID
where (m.defphoto = 1 AND m2.living = 0) OR (alwayson = 1) ORDER BY RAND()";

$result2 = $db->query($sql3);
$imgrow = $result2->fetch_assoc();
$showmedia_url = 'showmedia.php?';


$tng_img_url = $tng_url. $imgrow['mediakey'];
$tng_media_url = $tng_url. $showmedia_url. "mediaID=". $imgrow['mediaID'];;
echo '<div class="random-frame">';
echo "<div class=\"\">\n";
echo "<a href=\"{$tng_img_url}\"><img class=\"random-photo\" src=\"$tng_img_url\" alt=\"{$imgrow['description']}\" title=\"{$imgrow['description']}\">\n";
echo "<div style=\"padding: 5px\">\n";
echo "<em><a href=\"{$tng_media_url}\">{$imgrow['description']}</a></em>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>";