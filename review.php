<?php require_once("includes/session.php")?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

//Get all required info about the entered code
    $code               = $_SESSION['code'];
    $get_codeDetails    = mysql_query("SELECT * FROM codes WHERE code = '{$code}' ");
    $array_codeDetails  = mysql_fetch_array($get_codeDetails);
    $codeSubject        = $array_codeDetails['title'];
    $codeID             = $array_codeDetails['id'];


//Submit the entered review text
    if(isset($_POST['submitreview'])) {
        
        //Grab the text from the four review boxes
        $youPlus    = trim(mysql_prep($_POST['youPlus']));
        $mePlus     = trim(mysql_prep($_POST['mePlus']));
        $youDelta   = trim(mysql_prep($_POST['youDelta']));
        $meDelta    = trim(mysql_prep($_POST['meDelta']));
        
        //Save the review text
        $insert_text = mysql_query("INSERT INTO reviews (codeid, youplus, meplus, youdelta, medelta
                                   )VALUES ('{$codeID}', '{$youPlus}', '{$mePlus}', '{$youDelta}', '{$meDelta}')");
        
        //send the user back the homepage to display a thank you message
        redirect_to("index.php?m=thankyou");
        
    }

?>
<!DOCTYPE html>

<html>
<head>
    <title>Form</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery/themes/plusdelta.min.css" />
    <link rel="stylesheet" href="jquery/jquery.mobile.structure-1.3.1.min.css" /> 
    <script src="jquery/jquery-1.9.1.min.js"></script> 
    <script src="jquery/jquery.mobile-1.3.1.min.js"></script>    
</head>

<body>
    <div data-role="header">
        <a href="index.php?m=reviewcancelled" data-icon="delete" data-inline="true";>Cancel</a>
        <h1><img src="images/header_useful.png"> </h1>
        <a href="#popupBasic" data-icon=info data-rel="popup">Help</a>
        <div data-role="popup" id="popupBasic">
            <dl>
                <dt>You &#43;</dt>
                    <dd>- What did the leader, lecturer, product, or other item do well?</dd>
                    <br>
                <dt>You &#916;</dt>
                    <dd>- What opportunities does the leader, lecturer, product, or other item have for improvement?</dd>
                    <br>
                <dt>Me &#43;</dt>
                    <dd>- What did you, the reviewer, do well?</dd>
                    <br>
                <dt>Me &#916;</dt>
                    <dd>- What opportunities do you, the reviewer, have for improvement?</dd>
                    <br>
            </dl>
        </div>
    </div>    
    
    <form action="review.php" method="post" data-ajax="false">
        <div style="text-align: center;">
            You are reviewing: <?php echo $codeSubject; ?>
        </div>
        <table style="width:100%; text-align: center;">          
            <tr>
                <th style="width:2%; margin:0px; padding:0px; border: none;">
                    
                </th>
                <th style="margin:0px; padding:0px; border: none;">
                    You
                </th>
                <th style="margin:0px; padding:0px; border: none;">
                    Me
                </th>
            </tr>
            <tr>
                <td style="width:2%; margin:0px; padding:0px; border: none; font-size: xx-large;">
                    &#43;  <!-- PLUS SYMBOL -->
                </td>
                <td style="margin:0px; padding:0px; border: none;">
                    <textarea name="youPlus" style="margin:0px;resize:none;overflow:auto;height:150px;max-height:150px;"></textarea>
                </td>
                <td style="margin:0px; padding:0px; border: none;">
                    <textarea name="mePlus" style="margin:0px;resize:none;overflow:auto;height:150px;max-height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td style="width:2%; margin:0px; padding:0px; border: none; font-size: xx-large;">
                    &#916;  <!-- DELTA SYMBOL -->
                </td>
                <td style="margin:0px; padding:0px; border: none;">
                    <textarea name="youDelta" style="margin:0px;resize:none;overflow:auto;height:150px;max-height:150px;"></textarea>
                </td>
                <td style="margin:0px; padding:0px; border: none;">
                    <textarea name="meDelta" style="margin:0px;resize:none;overflow:auto;height:150px;max-height:150px;"></textarea>
                </td>
            </tr>
        </table>
        <input type="submit" name="submitreview" value="Submit Review">
    </form>
    
</body>
</html>
<?php
require_once("includes/footer.php");
?>