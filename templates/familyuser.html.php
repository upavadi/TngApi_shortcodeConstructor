<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Page</title>
</head>
<a name="Family"></a>
<?php
	//set variable for Cousins Mod. Remove comment ( // ) to show the Cousins Button: For TNG V12+ and Cousins Mod.
	global $father, $mother;	
	$cousins = false;
    // this may have changed in v14.

    //get person details
    $content = TngWp_ShortcodeContent::instance(); 
    $person = $content->getPerson($personId, $tree);
    $birthdate = $person['birthdate'];
    $birthdatetr = ($person['birthdatetr']);
    $birthplace = $person['birthplace'];
    $deathdate = $person['deathdate'];
    $deathdatetr = ($person['deathdatetr']);
    $deathplace = $person['deathplace'];
	$name = $person['firstname'] ." ".  $person['lastname'];

	$displayButtons = esc_attr(get_option('tng-api-display-buttons'));

//get person details for link to tng pages
$linkPerson = $person['personID'];
$tree = $person['gedcom'];
$currentmonth = date("m");
//person Birthdate & Place
if (($birthdatetr == '0000-00-00') and ($birthdate == ''))  {
    $birthmonth = null;
    $birthdate = "Date unknown";
} else {
    $birthmonth = substr($birthdatetr, -5, 2);
    $birthdate = $person['birthdate'];
}
if ($person['birthplace'] == null) {
    $birthplace = "Unknown";
} else {
    $birthplace = $person['birthplace'];
}
//get Cause of Death for person
$personRow = $content->getCause($person['personID'], $tree);
if (isset($personRow['eventtypeID']) && $personRow['eventtypeID'] == "0") {
    $cause_of_death = ". Cause: ". $personRow['cause'];
} else {
$cause_of_death = "";
}
//person Death date & Place
if (($deathdatetr == "0000-00-00") and ($deathdate == '')) {
    $deathmonth = null;
} else {
    $deathmonth = substr($deathdatetr, -5, 2);
}
if ($person['living'] == '0' AND $person['deathdate'] !== '') {
    $deathdate = " died: " . $person['deathdate'];
} else {
    $deathdate = " died: Date unknown";
}
if ($person['living'] == '1') {
    $deathdate = "  (Living)";
    $deathplace = "not applicable";
}
if ($person['living'] == '0' AND $person['deathplace'] == "") {
    $deathplace = "Unknown";
}
//get Person Special Event
$personRow = $content->getSpEvent($person['personID'], $tree);
$spevent = $personRow['info']; 
//get Description of Event type
$EventRow = $content->getEventDisplay();	
$EventDisplay = $EventRow['display'];
//get details of family
if ($person['sex'] == 'M') {
    $sortBy = 'husborder';
} else if ($person['sex'] == 'F') {
    $sortBy = 'wifeorder';
} else {
    $sortBy = null;
}
if ($person['living'] == '0' AND $person['deathdatetr'] !== '0000-00-00') {
    $deathdate = " died: " . $person['deathdate'];
} else {
    $deathdate = " died: date unknown";
}
if ($person['living'] == '1') {
    $deathdate = "  (Living)";
}
if ($person['living'] == '0' AND $person['deathplace'] == "") {
    $deathplace = "unknown";
}

//get details of family
if ($person['sex'] == 'M') {
    $sortBy = 'husborder';
} else if ($person['sex'] == 'F') {
    $sortBy = 'wifeorder';
} else {
    $sortBy = null;
}
if ($person['living'] == '0' AND $person['deathdatetr'] !== '0000-00-00') {
    $deathdate = " died: " . $person['deathdate'];
} else {
    $deathdate = " died: date unknown";
}
if ($person['living'] == '1') {
    $deathdate = "  (Living)";
}
if ($person['living'] == '0' AND $person['deathplace'] == "") {
    $deathplace = "unknown";
}
$families = $content->getFamilyUser($person['personID'], $tree, $sortBy);
    $parents = '';
    $parents = $content->getFamilyById($person['famc'], $tree);
    if ($person['famc'] !== '' and $parents['wife'] !== '') {
        $mother = $content->getPerson($parents['wife'], $tree);
    }
    if ($person['famc'] !== ''and $parents['husband'] !== '') {
        $father = $content->getPerson($parents['husband'], $tree);
    }
//set Father details       
if ($father['birthdatetr'] == "0000-00-00" OR $person['famc'] == null) {
    $fatherbirthmonth = null;
    $fatherbirthdate = "Date unknown";
} else {
    $fatherbirthmonth = substr($father['birthdatetr'], -5, 2);
    $fatherbirthdate = $father['birthdate'];
}
if ($father['birthplace'] == "" OR $person['famc'] == null) {
    $fatherbirthplace = "Place Unknown";
} else {
    $fatherbirthplace = $father['birthplace'];
}
if ($father['living'] == '0' AND $father['deathdate'] !== '') {
    $fatherdeathdate = " died: " . $father['deathdate'];
} else { if ($person['famc'] == null) { 
    $fatherdeathdate = "Unknown";
    }
    else {
    $fatherdeathdate = " died: Date unknown";
}
}
if ($father['deathdatetr'] == "0000-00-00") {
    $fatherdeathmonth = null;
} else {
    $fatherdeathmonth = substr($father['deathdatetr'], -5, 2);
}
if ($father['living'] == '0' AND $father['deathplace'] == '') {
    $fatherdeathplace = "Place Unknown";
} else {
$fatherdeathplace = $father['deathplace'];
}
if ($father['living'] == '1') {
    $fatherdeathdate = "  (Living)";
}
if ($father['personID'] !== null) {
    $fathername = $father['firstname']. " ". $father['lastname'];
    } else {
    $fathername = "Unknown";
    }
//Father - Special Event
$father_spevent = "";
if ($EventDisplay !== null)
{
 if ($father['personID'] !== null)
 {
 $fatherRow = $content->getSpEvent($father['personID'], $tree);
     if ($fatherRow !== null)  {
     $father_spevent = " (". $EventDisplay. ": ". $fatherRow['info']. " )";
     } else {
 $father_spevent = " (". $EventDisplay. ": Unknown)";
     }
 }	
}

//get Cause of Death for Father
$fatherRow = $content->getCause($father['personID'], $tree);
if (isset($fatherRow['eventtypeID']) && $fatherRow['eventtypeID'] == "0") {
    $father_cause_of_death = ". Cause: ". $fatherRow['cause'];
} else {
$father_cause_of_death = "";
}

//set Mother details
if ($mother['birthdatetr'] == "0000-00-00" OR $person['famc'] == null) {
	$motherbirthmonth = null;
	$motherbirthdate = "Date unknown";
} else {
	$motherbirthmonth = substr($mother['birthdatetr'], -5, 2);
	$motherbirthdate = $mother['birthdate'];
}
if ($mother['birthplace'] == "" OR $person['famc'] == null) {
	$motherbirthplace = "Place Unknown";
} else {
	$motherbirthplace = $mother['birthplace'];
}
if ($mother['living'] == '0' AND $mother['deathdate'] !== '') {
	$motherdeathdate = " died: ". $mother['deathdate'];
} else { if ($person['famc'] == null) { 
	$motherdeathdate = "Unknown";
	}
	else {
	$motherdeathdate = " died: Date unknown";
}
}
 if ($mother['deathdatetr'] == "0000-00-00") {
	$motherdeathmonth = null;
} else {
	$motherdeathmonth = substr($mother['deathdatetr'], -5, 2);
}
if ($mother['living'] == '0' AND $mother['deathplace'] == '') {
	$motherdeathplace = "Place Unknown";
} else {
$motherdeathplace = $mother['deathplace'];
}

if ($mother['living'] == '1') {
	$motherdeathdate = "  (Living)";
	
}
if ($mother['firstname'] == null) {
	$motherfirstname = "Unknown";
	} else {
	$motherfirstname = $mother['firstname'];
}
if ($mother['lastname'] == '') {
	$mothersurname = "Unknown";
	} else {				
	$mothersurname = $mother['lastname'];
}
if ($mother['personID'] !== null) {
	$mothername = $mother['firstname']. " ". $mother['lastname'];
	} else {
	$mothername = "Unknown";
	}
// Mother - Special Event
$mother_spevent = "";
if ($EventDisplay !== null)
{
if ($mother['personID'] !== null)
{
$motherRow = $content->getSpEvent($mother['personID'], $tree);
	if ($motherRow !== null)  {
	$mother_spevent = " (". $EventDisplay. ": ". $motherRow['info']. " )";
	} else {
$mother_spevent = " (". $EventDisplay. ": Unknown)";
	}
}	
}
//get Cause of Death for Mother
$motherRow = $content->getCause($mother['personID'], $tree);
if (isset($motherRow['eventtypeID']) && $motherRow['eventtypeID'] == "0") {
	$mother_cause_of_death = ". Cause: ". $motherRow['cause'];
} else {
$mother_cause_of_death = "";
}

// Parents Marriage Data
if ($parents['marrdatetr'] == "0000-00-00" OR $person['famc'] == null) {
	$parentsmarrmonth = null;
	$parentsmarrdate = "Marriage Date unknown";
} else {
	$parentsmarrmonth = substr($parents['marrdatetr'], -5, 2);
	$parentsmarrdate = "Married on ". $parents['marrdate'];
}

if ($parents['marrplace'] == "" OR $person['famc'] == null) {
	$parentsmarrplace = "Unknown";
} else {
	$parentsmarrplace = $parents['marrplace'];
}
//parents divorced data
$parentsDivDate = $parents['divdate'];
$parentsDivplace = $parents['divplace'];

$parentsdivdata = '';
if ($parentsDivDate) {
$parentsdivdata = "( Divorced: ". $parentsDivDate;
	if ($parentsDivplace) {
		$parentsdivdata = $parentsdivdata. " at ". $parentsDivplace;
	}
$parentsdivdata = $parentsdivdata. " )";
}

//get default media
$defaultmedia = $content->getDefaultMedia($personId, $tree);
if ($defaultmedia['thumbpath'] == null AND $person['sex'] == "M") {
	$mediaID = $url. "/img/male.jpg";
}
if ($defaultmedia['thumbpath'] == null AND $person['sex'] == "F") {
	$mediaID = $url. "/img/female.jpg"; 
}
if ($defaultmedia['thumbpath'] !== null) {
	$mediaID = $photosPath. "/" . $defaultmedia['thumbpath'];
}

?>

<!------ Html Header table -------------------------------------------->
<div class="container-fluid">
    <a href="?personId=<?php echo $currentpersonID; ?>"><span style="color:#D77600; font-size:14pt">			
    <?php echo "Welcome " . $currentuser; ?>
    </span></a>
<table border="0">
        <tr>
            <td class="col-md-1 col-xs-4 col-sm-2">
				<div>
				<img src="<?php echo "$mediaID"; ?>" class='img-responsive' />
				</div>
			</td>
			<td>
				<div class="row">					
					<div class="col-md-8 col-sm-8">
						<span style="font-size:14pt"><a href="?personId=<?php echo $person['personID']; ?>&amp;tree=<?php echo $person['gedcom']; ?>">			
						<?php echo "Family of " . $name; ?></span></a>
					</div>
				</div>
				<!-- submit Photo + 1 -->
				<div class="row">
					<div class="col-md-2 display-btn col-sm-4" >
					<?php
					echo "<input type=\"button\" id=\"link-btn\" value=\"submit-profile-photo\" onclick=\"window.location.href = '#submit-profile-photo' \" />";
                    ?>
					</div>
					
					<?php 
					if ($displayButtons == 1) 
					{
					
						echo ('<div class="col-md-2  col-sm-4 display-btn" >');
						echo "<input type=\"button\" id=\"link-btn\" value=\"Descendants\" onclick=\"window.location.href = '$IntegratedPath/descend.php?personID=$linkPerson&tree=$tree'\" />";
						?>
					</div>
				</div>	
					<div class="row">
						<div class="col-md-2 display-btn col-sm-4" >
						<?php 
						echo "<input type=\"button\" id=\"link-btn\" value=\"Genealogy Page\" onclick=\"window.location.href = '$IntegratedPath/getperson.php?personID=$linkPerson&tree=$tree' \" />";
						?>
						</div>
						<div class="col-md-2 display-btn col-sm-4" >
						<?php 
						echo "<input type=\"button\" id=\"link-btn\" value=\"Ancestors\" onclick=\"window.location.href = '$IntegratedPath/pedigree.php?personID=$linkPerson&tree=$tree'\" />";
						?>
						</div>					
					</div>
						<?php
						}
						?>
			</td>
        </tr>
</table>
<!------------ Person Details table -------------------------------------------->	
<div class="table-resp onsive">
  <table class="table table-bordered"> 
	<tr class="row">
		<td width="10%" class="tdback col-md-1 col-sm-1"><?php echo "Name"; ?></td>
		<td width=50%" class="tdpadding col-md-8 col-sm-8"><?php echo $name; ?></td>
		<td width="10%"  class="tdback col-md-1 col-sm-1"><?php echo $EventDisplay; ?></td>
      	<td width="10%" class="tdpadding col-md-2 col-sm-2"><?php echo $spevent; ?></td>
	</tr>
	<?php
	If ($currentmonth == $birthmonth) {
		$bornClass = 'born-highlight';
	} else {
		$bornClass = "";
	}
	?>
	<tr class="row">
		<td class="tdback col-md-1"><?php echo "Born"; ?></td>
		<td class="tdpadding col-md-8 col-sm-8 <?php echo $bornClass; ?>"><?php echo $birthdate; ?></td>
		<td class="tdback col-md-1 col-sm-1"><?php echo "Place"; ?></td>
      	<td class="tdpadding col-md-2 col-sm-2"><?php echo $birthplace; ?></td>
	</tr>
	<tr class="row">
			<?php
			If ($currentmonth == $deathmonth) {
				$bornClass = 'born-highlight';
			} else {
				$bornClass = "";
			}
			?>
		<td class="tdback col-md-1 col-sm-1"><?php echo "Died"; ?></td>
		<td class="tdpadding col-md-8  col-sm-8 <?php echo $bornClass; ?>"><?php echo $deathdate. $cause_of_death; ?></td>
		<td class="tdback col-md-1 col-sm-1"><?php echo "Place"; ?></td>
      	<td class="tdpadding col-md-2 col-sm-2"><?php echo $deathplace; ?></td>
	</tr>
 </table>
 <!-- Father ------------> 
<table class="table table-bordered"> 
	<tr class="row">
		<td width="10%" class="tdback col-md-1 col-sm-1">Father</td>
		<td width="50%" class="tdpadding col-md-8 col-sm-8">
			<?php
			If ($currentmonth == $fatherdeathmonth and $father['personID'] !== null) {
			?>
			<a href="?personId=<?php echo $father['personID']; ?>">
				<?php echo $fathername; ?></a>,<span style="background-color:#E0E0F7"><?php echo $fatherdeathdate; ?>, </span><?php echo $father['deathplace']; ?>
			<?php
			} elseif ($father['personID'] !== null) {
			?>
				<a href="?personId=<?php echo $father['personID']; ?>&amp;tree=<?php echo $father['gedcom']; ?>">
					<?php echo $fathername; ?></a>,<?php echo $fatherdeathdate; ?>, </span><?php
				echo $fatherdeathplace. $father_cause_of_death. $father_spevent;
			} else {

				echo $fathername;
			}
			?>
        </td>          
			<?php
			If ($currentmonth == $fatherbirthmonth) {
				$bornClass = 'born-highlight';
			} else {
				$bornClass = "";
			}
			?>
		<td width="10%" class="tdback col-md-1 col-sm-1">Born</td>
		<td width="10%" class="tdpadding col-md-2 col-sm-2 <?php echo $bornClass; ?>""><?php echo $fatherbirthdate; ?></td>
		
	</tr>
<!-- Mother -->
	<tr class="row">
		<td class="tdback col-md-1 col-sm-1">Mother</td>
		<td class="tdpadding col-md-8 col-sm-8">
			<?php
			If ($currentmonth == $motherdeathmonth and $mother['personID'] !== null) {
			?>
			<a href="?personId=<?php echo $mother['personID']; ?>">
				<?php echo $mothername; ?></a>,<span style="background-color:#E0E0F7"><?php echo $motherdeathdate; ?>, </span><?php echo $mother['deathplace']; ?>
			<?php
			} elseif ($mother['personID'] !== null) {
			?>
				<a href="?personId=<?php echo $mother['personID']; ?>&amp;tree=<?php echo $mother['gedcom']; ?>">
					<?php echo $mothername; ?></a>,<?php echo $motherdeathdate; ?>, </span><?php
				echo $motherdeathplace. $mother_cause_of_death. $mother_spevent;
			} else {

				echo $mothername;
			}
			?>
        </td>          
			<?php
			If ($currentmonth == $motherbirthmonth) {
				$bornClass = 'born-highlight';
			} else {
				$bornClass = "";
			}
			?>
		<td class="tdback col-md-1 col-sm-1">Born</td>
		<td class="tdpadding col-md-2 col-sm-2 <?php echo $bornClass; ?>""><?php echo $motherbirthdate; ?></td>
		
	</tr>	
<!-- Parents -->
			<?php
            if ($currentmonth == $parentsmarrmonth) {
				$bornClass = 'born-highlight';
			} else {
				$bornClass = "";
			}
            ?>
	<tr class="row">
		<td class="tdback col-md-1 col-sm-1">Parents</td>
		<td class="tdpadding col-md-8 col-sm-8 <?php echo $bornClass; ?>""><?php echo $parentsmarrdate. " ". $parentsdivdata; ?></td>
		<td class="tdback col-md-1 col-sm-1">Place</td>
		<td class="tdpadding col-md-2 col-sm-2"><?php echo $parentsmarrplace; ?></td>
	</tr>
 </table>

 <?php
//Spouse(s)		
	foreach ($families as $family):
		$divdata = "";
		$marrdatetr = $family['marrdatetr'];
		$marrdate = $family['marrdate'];
		$marrplace = $family['marrplace'];
		$divdate = $family['divdate'];
		$divplace = $family['divplace'];
		if ($divdate) {
			$divdata = "( Divorced: ". $divdate;
				if ($divplace) {
					$divdata = $divdata. " at ". $divplace;
				}
			$divdata = $divdata. " )";
		}	
			$order = null;
		if ($sortBy && count($families) > 1) {
			$order = $family[$sortBy];
		}
		//$spouse['personID'] == '';

		if ($person['personID'] == $family['wife']) {
			if ($family['husband'] !== '') {
				$spouse = $content->getPerson($family['husband'], $tree);
			}
		}
		if ($person['personID'] == $family['husband']) {
			if ($family['wife'] !== '') {
				$spouse = $content->getPerson($family['wife'], $tree);
			}
		}
		if ($family['marrplace'] == '') {
			$marrplace = "unknown";
		} else {
			$marrplace = $family['marrplace'];
		}
		if (($spouse['birthdatetr'] == '0000-00-00') and ($spouse['birthdate'] == ''))  {
			$spousebirthdate = "date unknown";
		} else {
			$spousebirthdate = $spouse['birthdate'];
		}
		if ($spouse['birthplace'] == "") {
				$spousebirthplace = "Unknown";
			} else {
				$spousebirthplace = $spouse['birthplace'];
			}

		if ($spouse['living'] == '0' AND $spouse['deathdate'] !== '') {
			$spousedeathdate = " died: " . $spouse['deathdate'];
		} else {
			$spousedeathdate = " died: date unknown";
		}
		if ($spouse['living'] == '0' AND $spouse['deathplace'] == '') {
				$spousedeathplace = "Unknown";
			} else {
			$spousedeathplace = $spouse['deathplace'];
			}
						
		if ($spouse['living'] == '1') {
			$spousedeathdate = "  (Living)";
			$spousedeathplace = " not applicable";
		}

		if ($spouse['personID'] == '') {
			$spousename = "Unknown";
		} else {
			$spousename = $spouse['firstname']. " ". $spouse['lastname'] . $deathdate;
		}
// Spouse - Special Event
			$spouse_spevent = "";
			if ($EventDisplay !== null)
			{
				if ($spouse['personID'] !== null)
				{
				$spouseRow = $content->getSpEvent($spouse['personID'], $tree);
					if ($spouseRow !== null)  {
					$spouse_spevent = " (". $EventDisplay. ": ". $spouseRow['info']. " )";
					} else {
				$spouse_spevent = " (". $EventDisplay. ": Unknown)";
					}
				}	
			}
//get Cause of Death for Spouse
			$spouseRow = $content->getCause($spouse['personID'], $tree);
			if (isset($spouseRow['eventtypeID']) && $spouseRow['eventtypeID'] == "0") {
				$spouse_cause_of_death = ". Cause: ". $spouseRow['cause'];
			} else {
			$spouse_cause_of_death = "";
			}
		?>
 <!--- spousees -->
 <table class="table table-bordered"> 
	<tr class="row">
	    <td width="10%" class="tdback col-md-1 col-sm-1"><?php echo "Spouse ", $order; ?></td>
		<td width="50%" class="tdpadding col-md-8 col-sm-8">	
		<?php
			if ($spouse['personID'] == '') {
				$spousename = "Unknown";
				?>
				<?php
				echo $spousename;
			} else {
				$spousename = $spouse['firstname']. " ". $spouse['lastname'];
				?>
				<a href="?personId=<?php echo $spouse['personID']; ?>&amp;tree=<?php echo $spouse['gedcom']; ?>">
					<?php
					echo $spousename. $spouse_spevent;
				}
		?>
			</a>
		</td>
        <td width="10%" class="tdback col-md-1 col-sm-1">Born</td>
			<?php
			$spousebirthmonth = substr($spouse['birthdatetr'], -5, 2);
			If ($currentmonth == $spousebirthmonth) {
				$bornClass = 'born-highlight';
			} else {
				$bornClass = "";
			}
			?>
        <td width="10%" class="tdpadding col-md-2 col-sm-2 <?php echo $bornClass; ?>"><?php echo $spousebirthdate; ?></td>

    </tr>
    <tr class="row">
		<td width="10%" class="tdback col-md-1 col-sm-1"><?php echo "Married" ?></td>
		<?php
			if ($marrdatetr == "0000-00-00") {
				$marrmonth = null;
			} else {
				$marrmonth = substr($family['marrdatetr'], -5, 2);
			}

			If ($currentmonth == $marrmonth) {
				$bornClass = 'born-highlight';
			} else {
				$bornClass = "";
			}
			if (($family['marrdatetr'] == "0000-00-00") and ($family['marrdate'] == '')){
				$marrdate = "date unknown";
			} else {
				$marrdate = $family['marrdate'];
			}
		?>
		<td width="10%" class="tdpadding col-md-8 col-sm-8 <?php echo $bornClass; ?>"><?php echo $marrdate. " ". $divdata; ?>
		</td>
		<td class="tdback col-md-1 col-sm-1"><?php echo "Place"; ?></td>
		<td class="tdpadding col-md-2 col-sm-2"><?php echo $marrplace; ?></td>

    </tr>
	<tr class="row">
		<?php
		$spousedeathmonth = substr($spouse['deathdatetr'], -5, 2);
		If ($currentmonth == $spousedeathmonth) {
			$bornClass = 'born-highlight';
		} else {
			$bornClass = "";
		}
		?>
		<td width="10%" class="tdback col-md-1 col-sm-1"><?php echo "Died"; ?></td>

		<td width="10%" class="tdpadding col-md-8 col-sm-8 <?php echo $bornClass; ?>"><?php echo $spousedeathdate. " ". $spouse_cause_of_death; ?></td>

		<td width="10%" class="tdback col-md-1 col-sm-1"><?php echo "Place"; ?></td>
		<td width="10%" class="tdpadding col-md-2 col-sm-2"><?php echo $spousedeathplace; ?></td>
    </tr>
    <tr class="row">
	<!-- Children -->				
	<td width="10%" class="tdback col-md-1 col-sm-1">Children</td>
		<td width="70%" class="tdpadding col-md-8 col-sm-8" colspan="3">
		<ul>
		<?php
		$children = $content->getChildren($family['familyID'], $tree);
			foreach ($children as $child):
				$classes = array('child');
				$childPerson = $content->getPerson($child['personID'], $tree);
				$childName = $childPerson['firstname']. " ". $childPerson['lastname'];
				$childdeathdate = $childPerson['deathdate'];
			//child special event
			$child_spevent = "";
				if ($EventDisplay !== null)
				{
					if ($child['personID'] !== null)
					{
					$childRow = $content->getSpEvent($child['personID'], $tree);
						if ($childRow !== null)  {
						$child_spevent = " (". $EventDisplay. ": ". $childRow['info']. " )";
						} else {
					$child_spevent = " (". $EventDisplay. ": Unknown)";
						}
					}	
				}
				
				$kids = 0;
				if ($child['haskids']) {
					$classes[] = 'haskids';
				$kids = $kids + 1;
				}
				$class = join(' ', $classes);
				if ($childPerson['living'] == '0' AND $childPerson['deathdate'] !== '') {
					$childdeathdate = (" died: " . $childPerson['deathdate']);
				} else {
					$childdeathdate = " died: date unknown";
				}
				if ($childPerson['living'] == '1') {
					$childdeathdate = "  (Living)";
				}
				?>
			<li colspan="0", class="<?php echo $class ?>">
				<a href="?personId=<?php echo $childPerson['personID']; ?>&amp;tree=<?php echo $childPerson['gedcom']; ?>">

					<?php
					if ($childPerson['birthdatetr'] == "0000-00-00") {
						$childbirthmonth = null;
					} else {
						$childbirthmonth = substr($childPerson['birthdatetr'], -5, 2);
					}
					if ($childPerson['deathdatetr'] == "0000-00-00") {
						$childdeathmonth = null;
					} else {
						$childdeathmonth = substr($childPerson['deathdatetr'], -5, 2);
					}

					if ($childPerson['birthdatetr'] !== "0000-00-00") {
						$childbirthdate = $childPerson['birthdate'];
					}
					if ($childPerson['birthdatetr'] == "0000-00-00") {
						$childbirthdate = ("Date Unknown");
					}
					//var_dump ($childbirthdate);

					If ($currentmonth == $childbirthmonth) {

						echo $childName;
						?></a>,<span style="background-color:#E0E0F7"> born: <?php echo $childbirthdate; ?>, </span><?php echo $childPerson['birthplace']; ?><?php echo $childdeathdate. ", ". $child_spevent; ?>
				</li> 
				<?php
			} elseif ($currentmonth == $childdeathmonth) {
				echo $childName;
				?></a>, born: <?php echo $childbirthdate; ?>,<?php echo $childPerson['birthplace']; ?><span style="background-color:#E0E0F7"><?php echo $childdeathdate. ", ". $child_spevent; ?>
				</span>
				</li> 
				<?php
			} elseif (($currentmonth == $childbirthmonth) AND ( $currentmonth == $childdeathmonth)) {
				echo $childName;
				?></a>,<span style="background-color:#E0E0F7"> born: <?php echo $childbirthdate; ?>,<?php echo $childPerson['birthplace']; ?><span style="background-color:#E0E0F7"><?php echo $childdeathdate. ", ". $child_spevent; ?>
					</span>
					</li>
					<?php
				} else {
					echo $childName;
					?></a>, born: <?php echo $childbirthdate; ?>, <?php echo $childPerson['birthplace']; ?><?php echo $childdeathdate. ", ". $child_spevent; ?>
					</li>

                                    <?php
                                }
                            endforeach;
							
                            ?>
                    </ul>
				<i><?php if ($kids > 0) {
				echo '&#9632'. " = has child(ren)." ; } ?></i>                
				</td>
            </tr>
            <?php
        endforeach;
		?>				
    </ul>
</td>
</tr>

</tbody>
</table>				
</div>

<div class="bordered-div">
<?php
//get All media

$allpersonmedia = $content->getAllPersonMedia($personId, $tree);
if ($person['famc']) {
    $allpersonmedia = array_merge($allpersonmedia, $content->getAllPersonMedia($person['famc'], $tree));
}
foreach ($families as $family):
    $allpersonmedia = array_merge($allpersonmedia, $content->getAllPersonMedia($family['familyID'], $tree));
endforeach;

$images = array();
foreach ($allpersonmedia AS $personmedia):
    $images[$personmedia['mediaID']] = $personmedia;
endforeach;

if (count($images)) {
    ?>
    <p><span style="font-size:14pt">
            <?php echo "Photos and Media for " . $name; ?></span></p>
    <?php
}
foreach ($images AS $personmedia):
    $mediaID = $photosPath. "/". $personmedia['thumbpath'];
    echo "<a href=\"$IntegratedPath/showmedia.php?mediaID={$personmedia['mediaID']}&medialinkID={$personmedia['medialinkID']}\">";
    echo "<img src=\"$mediaID\" class='person-images' border='1' height='50' border-color='#000000' alt=>\n";
    echo "</a>";
endforeach;
?>
</div>

<p><span style="font-size:14pt">
        <?php echo "Notes for " . $name; ?></span></a></br>
You may add or change notes about <?php echo $name; ?> by clicking on <b>Update Person Notes</b> tab above.</br>  
</p>

<?php
//get All notes
$allnotes = $content->getNotes($personId, $tree);
foreach ($allnotes as $PersonNote):
    $individualnote = $PersonNote['note'];
    $individualevent = $PersonNote['eventID'];
    if ($PersonNote['eventID'] == null) {
        $individualevent = "Personal Note";
    }
    if ($PersonNote['eventID'] == "NAME") {
        $individualevent = "About Person's Name";
    }
    if ($PersonNote['eventID'] == "BIRT") {
        $individualevent = "About Person's Birth";
    }

    if ($PersonNote['eventID'] == "DEAT") {
        $individualevent = "About Person's Death";
    }
    if ($PersonNote['eventID'] == "BURI") {
        $individualevent = "About Funeral, Cremation / Burial";
    }
    ?>

<div class="bordered-div">
    <p>
        <span style="font-size:14pt"><b>
                <?php echo $individualevent; ?></b></span></a></br>

    <?php echo $individualnote; ?>
    </p>

</div>

<?php endforeach; ?>
</div>


<!-- Upload Profile Image -->	
<a name="submit-profile-photo"></a>
<?php
$upload_content = file_get_contents( __DIR__ ."/.htaccess");
$file_size = (int)(substr($upload_content, 29));
$current_user = wp_get_current_user();
$User = $current_user->user_firstname;
?>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload photos</title>
	
	<!-- jquery-current.min.js is copy of current jquery jquery-x.x.x.min.js --> 
    <script type="text/javascript" src="<?php echo plugins_url('js/jquery-current.min.js', dirname(__FILE__)); ?>"></script>
	<script type="text/javascript" src="<?php echo plugins_url('js/jquery.form.min.js', dirname(__FILE__)); ?>"></script>

<head>
<script type="text/javascript">

$(document).ready(function() { 
	var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
}); 

function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button

}

function beforeSubmit(){
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
}
</script>
</head>
<body>
<div class="container-fluid" >
  <div style="margin-bottom: 1em"> </div>
  <div id="upload-wrapper" style="max-width: 700px; margin: auto" >
    <div align="center">
        <input type="button" id="return-btn" value="Return" onclick="location.href = '#Family'"/>
        <h3>Submit Profile Image for </br><?php echo $name; ?>.</br>
        Profile image submitted by <?php echo $User; ?></h3>
    </div>

  <form class="form-horizontal" action="<?php echo plugins_url('templates/processupload.php', dirname(__FILE__)); ?>" method="post" enctype="multipart/form-data" id="MyUploadForm">
<input type="" hidden name="title" value="<?php echo "Person Profile ID=". $linkPerson; ?>" />
<input type="" hidden name="Desc" value='<?php echo "Submit Profile Image for <br />". $name; ?>' />
<fieldset>
    <div class="form-group upload-control-group">
        <label for="Image" class="upload-width control-label col-sm-3">Select Image</label>
            <div class="control-label col-sm-6">
            <input name="ImageFile" id="chooseFile" class="form-control" type="file" placeholder="no file selected" accept="image/x-png,image/jpeg, image/pjpeg" required style="border: 1px solid lightgrey">
    </div>
        <div class="col-sm-3 col-md-3"><?php echo "Maximum Image size = ". $file_size. "Mb" ?>
        </div>
    </div>
    <div class="user-image mb-3 text-center"><b>Preview</b>
      <div style="width: 100px; height: 100px; overflow: hidden; background: #cccc; margin: 0 auto">
        <img src="..." class="figure-img img-fluid rounded" id="imgPlaceholder" alt="">
      </div>
      <div class="form-group upload-control-group" style="margin-top: 1em"></div>
        <div align='center'>
	    <input type="submit"  id="submit-btn" value="Upload Photo" style="position: center;"/><br />
	    <img src="<?php echo plugins_url('images/ajax-loader.gif', dirname(__FILE__)); ?>" id="loading-img" style="display:none;" alt="Please Wait"/>
	    </div>
    </div>
    </fieldset>
</form>
</div>
    <div class="row">
    <div id="output" style="max-width: 700px; margin: auto"></div>
    </div><! -- coupload wrapper ->
</div><! -- container-fluid" ->
</body>
<script>
function readURL(input) {

      var uploadSize = "<?php Print($file_size ); ?>";
      var FileSize = input.files[0].size / 1024 / 1024; // in MB
      if (FileSize > uploadSize) {
      var  msg = 'File size exceeds ' + uploadSize + 'Mb';
         alert(msg); return; 
      }
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#imgPlaceholder').attr('src', e.target.result);
      }

        // base64 string conversion
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#chooseFile").change(function () {
      readURL(this);
    });
</script>
<style>
.upload-width { width: 155px; padding-left: 15px;}
</style>

</html>

