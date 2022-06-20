<h2>
    <span style="color:#D77600; font-size:14pt;">Birthdays</span>
</h2>		
<table style="width: auto" cellspacing="1" cellpadding="1">
    <tbody>
    <th style="background-color: #EDEDED;">Date</th>
    <th style="background-color: #EDEDED;">Name</th>
    <th style="background-color: #EDEDED;">Age</th>

    <?php 
    $tngcontent = TngWp_ShortcodeContent::instance()->init();
    foreach ($birthdays as $birthday): 
        $personId = $birthday['personid'];
        $parentId = $birthday['famc'];
        $tree = $birthday['gedcom'];
    	$families = $tngcontent->getFamily($personId, $tree, null);
        $parents = $tngcontent->getFamilyById($parentId, $tree = null); 
        $personPrivacy = $birthday['private'];
        $familyPrivacy = $families['private'];
        $parentPrivacy = $parents['private'];

	if ($personPrivacy || $familyPrivacy || $parentPrivacy) {
		$birthday['firstname'] = 'Private:';
		$birthday['lastname'] = ' Details withheld';
		$birthday['birthdate'] = "?";

	}        
        
        
    ?>
        <tr>
            <td><?php echo $birthday['birthdate']; ?></td>
            <td width="50%">
                <a href="/family/?personId=<?php echo $birthday['personid']; ?>">
                    <?php echo $birthday['firstname'] . " "; ?><?php echo $birthday['lastname']; ?>
                </a>
            </td>
            <td width="50"><?php echo $birthday['Age']; ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>