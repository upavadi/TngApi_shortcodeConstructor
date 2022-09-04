<?php

/** Sample Text
* How to add shortcode FOR THIS PAGE to TNG Shortcode Constructor
<?php
/*
Search TNG database for names
*/
$result = array();
$firstName = "";
$lastName = "";
$tree ="";
$content = TngWp_ShortcodeContent::instance(); 
$privacycontent = TngWp_PrivacyContent::instance()->init();
$privacy = $privacycontent->doPrivacy($personId);
$personUrl = $integrationPath;
?>
<form style="display: inline-block;" method="get">
	<label for="search-firstname">First Name: <input type="text" value="<?php echo $firstName; ?>" name="firstName" id="search-firstname"></label>
	<label for="search-lastname">Last Name: <input type="text" value="<?php echo $lastName; ?>" name="lastName" id="search-lastname"></label> 
	<input type="submit" style="margin: -3px 0 0 0px;" value="Search Tree">
</form>
<p><h2><span style="color:#D77600; font-size:14pt">Search Results</span></h2></p>
<?php 
if (!count($results)): ?>
<h2>No results found, please search again</h2>
<?php else: ?>
<div class="container">
<table class="table table-bordered">
	<tr>
			<td class="tdback col-md-2 col-sm-2 col-xs-2">Name</th>
			<td class="tdback col-lg-1 col-md-1 col-sm-1 col-xs-1">Birth Date</th>
			<?php 
			if ($usertree == '') { ?>
			<td class="tdback col-lg-1 col-md-1 col-sm-1 col-xs-1">Tree</th>
			
			<?php } ?>			
	</tr>

<tbody>
	<?php

	foreach($results as $result): 
		
		$privacy = $privacycontent->doPrivacy($personId);
	if (($result['private'] == 0) ){ 


		$personId = $result['personID'];
		$allow_living = $privacycontent->doLiving($personId); 
		$parentId = $result['famc'];
		$tree = $result['gedcom'];
		$firstname = $allow_living['firstname'];
		$lastname = $allow_living['lastname'];
		$birthdate = $allow_living['birthdate'];
		$families = $content->getFamily($personId, $tree, null);
		$parents = $content->getFamilyById($parentId, $tree = null);
		$parents = $content->getFamilyById($parentId, $tree = null); 
		$personUrl = $IntegratedPath. "getperson.php?personID=". $personId. "&tree=". $userTree;

	
	
	?>
	<tr>
		<td class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
			<a href="<?php echo $personUrl; ?>">
                    <?php echo $firstname . " "; ?><?php echo $lastname; ?></a>
		</td>
		<td  class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
			<?php echo $birthdate; ?>
		</td>
		
	<?php 
		if ($usertree == '') { ?>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?php echo $result['gedcom']; ?></td>
        </tr>
    <?php
	}
	}

	endforeach; ?> 
</tbody>
</table>
</div>
<?php endif; 
?>