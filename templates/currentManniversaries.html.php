<h2><span style="color:#D77600; font-size:14pt">
        Marriage Anniversaries
    </span>
</h2>
<table style="width: auto"  cellspacing="1" cellpadding="1" border="1">
    <thead>
        <tr>
            <th style="background-color: #EDEDED;">Date</th>
            <th style="background-color: #EDEDED;">Husband</th>
            <th style="background-color: #EDEDED;">Wife</th>
            <th style="background-color: #EDEDED;">Years</th>
        </tr>
    </thead>
    <tbody>
        <?php 
         $tngcontent = TngWp_ShortcodeContent::instance()->init();
         $privacycontent = TngWp_PrivacyContent::instance()->init();
         $tngFolder = $tngcontent->getTngIntegrationPath();
        
         foreach ($manniversaries as $manniversary):
            $tree = $manniversary['gedcom'];
            $personId1 = $manniversary['personid1'];
            $personId2 = $manniversary['personid2'];
            $privacycontent = TngWp_PrivacyContent::instance()->init();
		    $family_living = $privacycontent->doManniversaryLiving($personId1, $personId2);
	
            $firstname1 = $family_living['firstname1'];
            $lastname1 = $family_living['lastname1'];
            $firstname2 = $family_living['firstname2'];
            $lastname2 = $family_living['lastname2'];
            $divorceDate = $manniversary['divdate'];
            $years = $manniversary['Years'];

            //Suppress dates and years if LIVING or PRIVATE
            if (($family_living['firstname1'] == 'Living') || ($family_living['firstname1'] == ['Private']) || ($family_living['firstname2'] == 'Living') || ($family_living['firstname2'] == ['Private']))
            { 
            $marrdate = $marrplace = $years = "";
            }
        ?>
            <tr>
                <td><?php echo $manniversary['marrdate']; ?></a></td>
                <td><a href="/family/?personId=<?php echo $manniversary['personid1']; ?>">
                        <?php echo $firstname1. " "; ?><?php echo $lastname1; ?></a></td>
                <td><a href="/family/?personId=<?php echo $manniversary['personid2']; ?>">
                        <?php echo $firstname2; ?><?php echo $lastname2; ?></a></td>
                <td><?php echo $years; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>