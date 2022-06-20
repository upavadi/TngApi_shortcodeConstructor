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
        foreach ($manniversaries as $manniversary):
            $tree = $manniversary['gedcom'];
            $personId1 = $manniversary['personid1'];
            $personId2 = $manniversary['personid2'];
            $divorceDate = $manniversary['divdate'];
            $familyPrivacy = $manniversary['private'];
            $personPrivacy1 = $tngcontent->getPerson($personId1)['private'];
            $personPrivacy2 = $tngcontent->getPerson($personId2)['private'];
            //  $dmedia1 = $tngcontent->getDefaultMedia($personId1, $tree);
            //  $dmedia2 = $tngcontent->getDefaultMedia($personId2, $tree);
            //  $mediaPath1 = $photosPath."/". $dmedia1['thumbpath'];
            // $mediaPath2 = $photosPath."/". $dmedia2['thumbpath'];
    
            if ($familyPrivacy) {
                $manniversary['firstname1'] = 'Private:';
                $manniversary['firstname2'] = 'Private:';
                $manniversary['lastname1'] = ' Details withheld';
                $manniversary['lastname2'] = ' Details withheld';
                $manniversary['marrdate'] = "?";
                $manniversary['Years'] = "";               
                
        }
        ?>
            <tr>
                <td><?php echo $manniversary['marrdate']; ?></a></td>
                <td><a href="/family/?personId=<?php echo $manniversary['personid1']; ?>">
                        <?php echo $manniversary['firstname1']; ?><?php echo $manniversary['lastname1']; ?></a></td>
                <td><a href="/family/?personId=<?php echo $manniversary['personid2']; ?>">
                        <?php echo $manniversary['firstname2']; ?><?php echo $manniversary['lastname2']; ?></a></td>
                <td><?php echo $manniversary['Years']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>