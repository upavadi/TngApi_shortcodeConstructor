<?php
/** Yesterday - Today - Tomorrow
 * Gone but Not Forgoytten
* Dedeased only . No Credential checks
**/

?>
<div class="gone_div">
				<div class="gone_header">Gone But Not Forgotten.</div>
				<div class="gone_text">Birth and Death Anniversaries for Yesterday, Today and Tomorrow
				</div>
				<div>For full list of All Events, please login and navigate to  <a href="../events-today">Yesterday - Today - Tomorrow</a>
				</div>
				<div><?php include('birth_death.php'); ?></div>
		
<table class="born-article-table" >
    <tbody>
	<th class="born-article-table " style="background-color: #EDEDED; text-align: center;">Name</th>
    <th  class="born-article-table" style="background-color: #EDEDED;text-align: center;">Birth Date</th>
    <th  class="born-article-table" style="background-color: #EDEDED; text-align: center;">Death Date</th>
	<th  class="born-article-table" style="background-color: #EDEDED;text-align: center;">Age<br />at Death</th>
	<th class="born-article-table" style="background-color: #EDEDED; text-align: center;">Years<br />since Birth</th>
	<th class="born-article-table" style="background-color: #EDEDED; text-align: center;">Years<br />since Death</th>
    
<?php	
    $content = array(); // shortcodeContent array
    $content = TngWp_ShortcodeContent::instance(); 
    //var_dump($gonedays);
    foreach ($gonedays as $goneday):
        $personId = $goneday['personid'];
        $tree = $goneday['gedcom'];  
        $firstname = $goneday['firstname'];
        $lastname = $goneday['lastname'];
        $birthdate = $goneday['birthdate'];
        $deathdate = $goneday['deathdate'];
        $sex = $goneday['sex'];
        $personUrl = $tngUrl. 'getperson.php?personID='. $personId. '&tree='. $tree;
        
        $thumbPath = $content->getDefaultMedia($personId)['thumbpath'];  
        $defaultphoto = $photoPath. $thumbPath;
        if ($thumbPath == null && $sex == 'M') $defaultphoto = $generic_M;
        if ($thumbPath == null && $sex == 'F') $defaultphoto = $generic_F;

        /*** if no dates **** */
        if ($goneday['birthdate'] == "")
			{
			$DeathAge = "";
			$BirthAge = "";
		}
		if ($goneday['deathdate'] == "") {
            $DeathYears = "";
            $DeathAge = "";
        }

        /*** work out month  ******/
        $currentmonth = date("m");
        $birthmonth = substr($goneday['birthdatetr'], -5, 2);
        $deathmonth = substr($goneday['deathdatetr'], -5, 2);
        If ($currentmonth == $birthmonth) {
			$bornClass = 'born-highlight';
		} else {
			$bornClass = "";
	}
	If ($currentmonth == $deathmonth) {
			$deathClass = 'death-highlight';
		} else {
			$deathClass = "";
	}



?>
        <tr>
            <td class="born-article-table" ><a href="<?php echo $personUrl; ?>">
			<img src="<?php echo $defaultphoto; ?>" class='profile-image' style="width: 80px; padding: 5px"; />
			<div>
                <a href="<?php echo $personUrl; ?>">
                    <?php echo $goneday['firstname'] . " "; ?><?php echo $goneday['lastname']; ?>
                </a></div>
            </td>
            <td class="born-article-table <?php echo $bornClass; ?>" style="text-align: center;"><?php echo $birthdate; ?></td>
			<td class="born-article-table <?php echo $deathClass; ?>" style="text-align: center;"><?php echo $deathdate; ?></td>
            <td class="born-article-table" style="text-align: center;"><?php echo $DeathAge; ?></td>
			<td class="born-article-table" style="text-align: center;"><?php echo $BirthAge; ?></td>
			<td class="born-article-table" style="text-align: center;"><?php echo $DeathYears; ?></td>
        </tr>





<?php




    endforeach; 
?>
</table>
</div>