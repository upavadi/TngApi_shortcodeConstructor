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
        <?php foreach ($danniversaries as $danniversary): ?>
            <tr>
                <td><?php echo $danniversary['deathdate']; ?></td>
                <td><a href="/family/?personId=<?php echo $danniversary['personid']; ?>">
                        <?php echo $danniversary['firstname']; ?><?php echo $danniversary['lastname']; ?></a></td>
                <td><?php echo $danniversary['Years']; ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>