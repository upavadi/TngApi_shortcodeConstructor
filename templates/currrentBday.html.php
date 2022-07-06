<h2>
    <span style="color:#D77600; font-size:14pt;">Birthdays</span>
</h2>		
<table style="width: auto" cellspacing="1" cellpadding="1">
    <tbody>
    <th style="background-color: #EDEDED;">Date</th>
    <th style="background-color: #EDEDED;">Name</th>
    <th style="background-color: #EDEDED;">Age</th>

    <?php 
    $content = TngWp_ShortcodeContent::instance()->init();
    $privacycontent = TngWp_PrivacyContent::instance()->init();
    $tngFolder = $content->getTngIntegrationPath();
    foreach ($birthdays as $birthday): 
        $personId = $birthday['personid'];
        $allow_living = $privacycontent->doLiving($personId);
        $userTree = $birthday['gedcom'];
        $url = $content->getTngUrl();
        $genealogy = $content->getTngIntegrationPath();
        $url = $content->getTngUrl();
        $Directory = basename($url );
        $IntegratedPath = dirname($url). "/". $genealogy. "/";
	    $personUrl = $IntegratedPath. "getperson.php?personID=". $personId. "&tree=". $userTree;
        $parentId = $birthday['famc'];
        $tree = $birthday['gedcom'];
    	$families = $content->getFamily($personId, $tree, null);
        $parents = $content->getFamilyById($parentId, $tree = null); 
        
         $firstname = $allow_living['firstname'];  
         $lastname = $allow_living['lastname'];
         $age = $birthday['Age']; 
         if (isset($allow_living['age']) && $allow_living['age'] == '' ) {
            $age = ""; 
         } 
     
        
    ?>
        <tr>
            <td><?php echo $birthday['birthdate']; ?></td>
            <td width="50%">
                <a href="<?php echo $personUrl; ?>">
                    <?php echo $firstname. " "; ?><?php echo $lastname; ?>
                </a>
            </td>
            <td width="50"><?php echo $age; ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>