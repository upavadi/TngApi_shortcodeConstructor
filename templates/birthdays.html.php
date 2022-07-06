<!-- Birthdays Modified for BootStrap March 2016-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Family Birth dates</title>
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
<label style="text-align: right; width: 108px;" for="monthselect">Change Month:</label>
<select name="monthselect" style="width: 100px; margin: 5px;" id="monthSelect" onchange="runBirth()">
<option value="">--Select Month--</option>
<?php
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
<label for="yearselect" style="text-align: right; width: 108px;">Change Year:</label>
<select name="yearselect" id="yearSelect" style="width: 100px; margin: 5px;" onchange="runBirth()">
<option value="">--Select Year--</option>
<option value="<?php echo $currentyear-3;?>"><?php echo $currentyear-3;?></option>
<option value="<?php echo $currentyear-2;?>"><?php echo $currentyear-2;?></option>
<option value="<?php echo $currentyear-1;?>"><?php echo $currentyear-1;?></option>
<option value="<?php echo $currentyear;?>" selected="selected"><?php echo $currentyear;?></option>
<option value="<?php echo $currentyear+1;?>"><?php echo $currentyear+1;?></option>
<option value="<?php echo $currentyear+2;?>"><?php echo $currentyear+2;?></option>
<option value="<?php echo $currentyear+3;?>"><?php echo $currentyear+3;?></option>
</select>
<input type="hidden" id="birthMonthYear" name="monthyear">
 <input type="submit" value="Update" style="width:85px; margin: 10px;" /> 
 <input type="submit"  value="Today" onclick="goToToday()"/> 
</form>

<script>
function runBirth() {
    document.getElementById("birthMonthYear").value = "01/" + document.getElementById("monthSelect").value + "/" + document.getElementById("yearSelect").value;
}
function goToToday() {
    document.getElementById("birthMonthYear").value = "01/" + document.getElementById("monthSelect").value + "/" + date("Y");
}

</script>
<h2><span style="color:#D77600; font-size:25px">Birthdays for <?php echo $date->format('F Y'); ?></span></h2>
Clicking on a name takes you to the Individual's Family Page
<?php
//get and hold current user
$content = TngWp_ShortcodeContent::instance()->init();
$privacycontent = TngWp_PrivacyContent::instance()->init();
$user = $content->getTngUser(); 
$privacy = array();
$usertree = ''; 
if (isset($user)) {
//$allowAdmin = $user['allow_private'];
$usertree = $user['gedcom'];
}
$tngFolder = $content->getTngIntegrationPath();
?>

<div class="container-fluid table-responsive">
<div class="col-md-12">
<table class="table table-bordered">   
    <tr class="row">
	<td class="tdback col-md-4">Name</td>
    <td class="tdback col-md-1"> Date</td>
    <td class="tdback col-md-2" >Birth Place</td>
    <td class="tdback col-md-1">Age</td>
	<td class="tdback col-md-1">Relationship</td>
    <?php 
	$url = $content->getTngUrl();
		
	if ($usertree == '') { ?>
	<td class="tdback col-md-1" style="text-align: center">Tree</td>
			
	<?php } ?>
	</tr>
    <?php foreach ($birthdays as $birthday):
	$personId = $birthday['personid'];
	//$privacy = $privacycontent->doPrivate($personId);
	$allow_living = $privacycontent->doLiving($personId);
	$tree = $birthday['gedcom'];
	$firstname = $allow_living['firstname'];
	$lastname = $allow_living['lastname'];
	$tree = $allow_living['gedcom'];
	$defaultmedia = $allow_living['defaultmedia'];
	$birthdate = $allow_living['birthdate'];
	$birthplace = $allow_living['birthplace'];
	$age = $birthday['age']; 
	if (isset($allow_living['age']) && $allow_living['age'] == '' ) {
		$age = "";

	}
	
	$view = true;
	$genealogy = $content->getTngIntegrationPath();
	$url = $content->getTngUrl();
	$Directory = basename($url );
	$IntegratedPath = dirname($url). "/". $genealogy. "/";
	$personUrl = $IntegratedPath. "getperson.php?personID=". $personId. "&tree=". $userTree;
	// }
	$view = "View";
	?>
	<tbody>
	   <tr class="row">
            <td class="col-md-5 tdfront" style="text-align: center">
			
			<img src="<?php 
			echo "$defaultmedia";  ?>" border='1' height='50' border-color='#000000'/><br /> 
			<a href="<?php echo $personUrl; ?>">
                    <?php echo $firstname . " "; ?><?php echo $lastname; ?></a></td>
            <td class="col-md-2 tdfront" style="text-align: center"><?php echo $birthdate; ?></td>
            <td class="col-md-2 tdfront" style="text-align: center"><?php echo $birthplace; ?></td>
            <td class="col-md-1 tdfront" style="text-align: center"><?php echo $age; ?></td>
			<?php if($view) 
					?>
			<td class="col-md-1 tdfront" style="text-align: center";><a href="<?php echo $IntegratedPath; ?>/relationship.php?altprimarypersonID=&savedpersonID=&secondpersonID=<?php echo $birthday['personid'];?>&maxrels=2&disallowspouses=0&generations=15&tree=upavadi_1&primarypersonID=<?php echo $currentperson; ?>"><?php echo $view?></td>
			<?php
			
			if ($usertree == '') { ?>
				<td class="col-md-1 tdfront" style="text-align: center"><?php echo $birthday['gedcom']; ?></td>
		</tr>
    <?php 
	}
	endforeach; ?>
	
	</tbody>
</table>
</div>
</div>
</html>