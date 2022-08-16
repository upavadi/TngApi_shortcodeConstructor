<!-- Marriage Anniversaries Modified to give period from marriage to first death Aug 2022-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Family Anniversaries</title>
</head>
<?php
$monthList = array(
	'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
	);
?>
<form action="#" style="display: inline-block;" method="get">
<label style="text-align: right; width: 108px;" for="monthselect2">Change Month:</label>
<select name="monthselect2" style="width: 100px; margin: 5px;" id="monthSelect2" onchange="runAnniversary()">
<option value="">--Select Month--</option>
<?php
		static $usertree;
		$tngcontent = TngWp_ShortcodeContent::instance()->init();
		$user = $tngcontent->getTngUser(); 
		$usertree = $user['gedcom'];
		$allowAdmin = $user['allow_private'];
for ($i = 0; $i <= 11; $i++) {
$currentmonth = $i + 1;
if ($currentmonth < 10) {
$currentmonth = "0". $currentmonth;
$currentmonthyear = $currentmonth. $year;
}
if ($currentmonth == $month) {
?>
<option value="<?php echo $currentmonth;?>" selected="selected"><?php echo $monthList[$i] ?></option>
<?php
} else {
?>
<option value="<?php echo $currentmonth;?>"><?php echo $monthList[$i] ?></option>
<?php } }  ?>
</select>
<?php
$currentyear = $year;
?>
<label for="yearselect2" style="text-align: right; width: 108px;">Change Year:</label>
<select name="yearselect2" id="yearSelect2" style="width: 100px; margin: 5px;" onchange="runAnniversary()">
<option value="">--Select Year--</option>
<option value="<?php echo $currentyear-3;?>"><?php echo $currentyear-3;?></option>
<option value="<?php echo $currentyear-2;?>"><?php echo $currentyear-2;?></option>
<option value="<?php echo $currentyear-1;?>"><?php echo $currentyear-1;?></option>
<option value="<?php echo $currentyear;?>" selected="selected"><?php echo $currentyear;?></option>
<option value="<?php echo $currentyear+1;?>"><?php echo $currentyear+1;?></option>
<option value="<?php echo $currentyear+2;?>"><?php echo $currentyear+2;?></option>
<option value="<?php echo $currentyear+3;?>"><?php echo $currentyear+3;?></option>
</select>
<input type="hidden" id="anniversaryMonthYear" name="monthyear">
 <input type="submit" value="Update" style="width:85px; margin: 10px;" />   
 <input type="submit"  value="Today" onclick="goToToday()"/>
</form> 
<script>
function runAnniversary() {
    document.getElementById("anniversaryMonthYear").value = "01/" + document.getElementById("monthSelect2").value + "/" + document.getElementById("yearSelect2").value;
}
function goToToday() {
    document.getElementById("birthMonthYear").value = "01/" + document.getElementById("monthSelect").value + "/" + date("Y");
}

</script>
<h2><span style="color:#D77600; font-size:25px">Marriage Anniversaries for <?php echo $date->format('F Y'); ?></span></h2></p>
Clicking on a name takes you to the Individual's Page.
	<?php
	//get and hold current user
	$content = TngWp_ShortcodeContent::instance()->init();
	$user = $content->getTngUser();
	if (isset($user['gedcom'])) $usertree = $user['gedcom'];
	$url = $content->getTngUrl();

	?>
<div class="container-fluid table-responsive">
<div class="col-md-12">
<table class="table table-bordered"> 
	<tr class="row">	
			<td class="tdback col-md-3" style="text-align: center">Husband</td>
			<td class="tdback col-md-3" style="text-align: center">Wife</td>
			<td class="tdback col-md-2">Date</td>
			<td class="tdback col-md-2">Place</td>
			<td class="tdback col-md-1" style="text-align: center">Years - Marriage</td>
			<td class="tdback col-md-1" style="text-align: center">Years - First Death</td>
			<?php 
			$url = $content->getTngUrl();
			if ($usertree == '') { ?>
			<td class="tdback col-md-1">Tree</td>
			<?php } ?>

	<tbody>	
	</tr>
	<?php foreach ($manniversaries as $manniversary):
		$manniversarydate = strtotime($manniversary['marrdate']);
		$Years = $year - date('Y', $manniversarydate);
		$personId1 = $manniversary['personid1']; 
		$personId2 = $manniversary['personid2'];
		$privacycontent = TngWp_PrivacyContent::instance()->init();
		$family_living = $privacycontent->doManniversaryLiving($personId1, $personId2);
		$tree = $family_living['gedcom'];
		//$personUrl1 = $url. "getperson.php?personID=". $personId1. "&tree=". $userTree;
		//$personUrl2 = $url. "getperson.php?personID=". $personId2. "&tree=". $userTree;
		$familyID = $manniversary['familyID'];
		$firstname1 = $family_living['firstname1'];
		$lastname1 = $family_living['lastname1'];
		$firstname2 = $family_living['firstname2'];
		$lastname2 = $family_living['lastname2'];
	//	$marrdate = $family_living['mardate']; //echo $marrdate;
		$defaultmedia1 = $family_living['defaultmedia1'];
		$defaultmedia2 = $family_living['defaultmedia2'];
		$marrdate = $manniversary['marrdate'];
		$marrplace = $manniversary['marrplace'];
		$div_date = $manniversary['divdate'];

		$genealogy = $content->getTngIntegrationPath();
		$url = $content->getTngUrl();
		$Directory = basename($url );
		$IntegratedPath = dirname($url). "/". $genealogy. "/";
		$personUrl1 = $IntegratedPath. "getperson.php?personID=". $personId1. "&tree=". $userTree;
		$personUrl2 = $IntegratedPath. "getperson.php?personID=". $personId2. "&tree=". $userTree;

/*********** Calculate Years from first death ******************************************************/
		static $firstDeathDate, $secondDeathDate, $secondDeathstamp;
		$firstLiving = $manniversary['living1'];
		$secondLiving = $manniversary['living2'];
		$firstDeathDate = $manniversary['deathdate1']; 
		$secondDeathDate = $manniversary['deathdate2'];

		$firstDeathstamp = strtotime($firstDeathDate);
		$firstDeathYear = date('Y', $firstDeathstamp);
		$secondDeathstamp = strtotime($secondDeathDate);
		$secondDeathYear = date('Y', $secondDeathstamp);
		$marrYears = date('Y', $manniversarydate);
		$yearsSinceDeath = $firstDeathYear - $marrYears; 

		//if Living
		if ($firstLiving == 1 && $secondLiving == 1) {
				$yearsSinceDeath = "Living";
		}

		//first death
		if ($firstLiving == 0 && $secondLiving == 1) {
			
			if ($firstDeathDate > 0) {
			$yearsSinceDeath = ($firstDeathYear - $marrYears);
			} else {
				$yearsSinceDeath = "";
			}
		}

		//2nd death
		if ($firstLiving == 1 && $secondLiving == 0) {
				if ($secondDeathDate > 0) {
				$yearsSinceDeath = ($secondDeathYear - $marrYears);
				} else {
					$yearsSinceDeath = "";
				}

		}

		//Both deceased
		if ($firstLiving == 0 && $secondLiving == 0) {
							
			if ($firstDeathDate > 0 && $secondDeathDate > 0) {
				if ($firstDeathYear <= $secondDeathYear ) {
					$yearsSinceDeath = $firstDeathYear - $marrYears;
				} else {
					$yearsSinceDeath = $secondDeathYear - $marrYears;
				}
			}

			//if firstDeathDate is blank
			if ($firstDeathDate <= 0 && $secondDeathDate <= 0) {
				$yearsSinceDeath = "";
			}
			if ($firstDeathDate <= 0 && $secondDeathDate > 0) {
				$yearsSinceDeath = $secondDeathYear - $marrYears;
			}

			if ($firstDeathDate > 0 && $secondDeathDate <= 0) {
				$yearsSinceDeath = $firstDeathYear - $marrYears;
			}
		}
/*********************************************************************************************************** */
		//Suppress dates and years if LIVING or PRIVATE
		if (($family_living['firstname1'] == 'Living') || ($family_living['firstname1'] == ['Private']) || ($family_living['firstname2'] == 'Living') || ($family_living['firstname2'] == ['Private']))
		{ 
		$marrdate = $marrplace = $Years = "";
		}

		//Ignore if divorced.
		if ($div_date == '') {
	?>
	
		<tr class="row">
			<td class="col-md-3 tdfront">
			<div>
			<?php if ($defaultmedia1) { ?>
			<img src="<?php 
			echo "$defaultmedia1";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?>
			<br /><a href="<?php echo $personUrl1;?>">
			<?php echo $firstname1. ""; ?><?php echo " ". $lastname1; ?></a></div></td>
			<div>
			<td class="col-md-3 tdfront"><?php if ($defaultmedia2) { ?>
			<img src="<?php 
			echo "$defaultmedia2";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?>
			<br /><a href="<?php echo $personUrl2;?>">
			<?php echo $firstname2; ?><?php echo " ". $lastname2; ?></a></div></td>
			<td class="col-md-2 tdfront"><?php echo $marrdate; ?></td>
			<td class="col-md-2 tdfront"><?php echo $marrplace; ?></td>
			<td class="col-md-1 tdfront"><?php echo $Years; ?></td>
			<td class="col-md-1 tdfront"><?php echo $yearsSinceDeath; ?></td>
			<?php 
			if ($usertree == '') { ?>
				<td class="col-md-1 tdfront"><?php echo $tree; ?></td>
        </tr>
	<?php 
		}
		}
	endforeach; ?>
</tbody>
</table>
</div>
</div>
</html>	