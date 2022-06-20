<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Events - Toaday</title>
</head>
    <?php echo "<strong>". $date. "</strong>"; ?>
</span>
<table class="table">
    <tr>
        <td><img src="<?php echo $profileImage; ?>" class='profile-image' /></td>
        <td>
            <span style="color:#D77600; font-size:14pt">			
                Welcome
                <a href="/family/?personId=<?php echo $personId; ?>">
                    <?php echo $name; ?>
                </a>
                to Upavadi Family Site
            </span>
            <h2>
                <span style="color:#D77600; font-size:14pt">			
                    Events for Yesterday, Today and Tomorrow<br />
                </span>
            </h2>
        </td>
    </tr>
</table>
<table class="table">
    <tr>
        <td style="vertical-align: top;">
            <?php include('currrentBday.html.php'); ?>
        </td>
        <td style="vertical-align: top;">
            <?php include('currentManniversaries.html.php'); ?>
        </td>
        <td style="vertical-align: top;">
            <?php include('currentDanniversaries.html.php'); ?>
        </td>
    </tr>
</table>