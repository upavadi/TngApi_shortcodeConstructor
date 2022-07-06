<h2>
    <span style="color:#D77600; font-size:14pt">Death Anniversaries</span>
</h2>
<table style="width: auto"  cellspacing="1" cellpadding="1" border="1">
    <thead>    
        <tr>
            <th style="background-color: #EDEDED;">Date</th>
            <th style="background-color: #EDEDED;">Name</th>
            <th style="background-color: #EDEDED;">Years  </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $content = TngWp_ShortcodeContent::instance()->init();
        $privacycontent = TngWp_PrivacyContent::instance()->init();
        $user = $content->getTngUser();
        
        foreach ($danniversaries as $danniversary): 
        $personId = $danniversary['personid'];
        $privacy = $privacycontent->doPrivacy($personId); 
        $url = $content->getTngUrl();
        $genealogy = $content->getTngIntegrationPath();
        $IntegratedPath = dirname($url). "/". $genealogy. "/";
        $personUrl = $IntegratedPath. "getperson.php?personID=". $personId. "&tree=". $userTree;
         
        $firstname = $privacy['firstname'];
        $lastname = $privacy['lastname'];
        $years = $danniversary['Years'];
         
       if ($privacy['private'] == 1 && $user['allow_private'] == "0" )   $years = "";  
        ?>
            <tr>
                <td><?php echo $danniversary['deathdate']; ?></td>
                <td><a href="<?php echo $personUrl; ?>">
                        <?php echo $firstname. " ". $lastname; ?></a></td>
                <td><?php echo $years; ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>