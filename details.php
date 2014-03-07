<?php require_once("includes/session.php")?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
//logged in?
confirmed_logged_in();

if(isset($_POST['save'])){
    $new_title      = trim(mysql_prep($_POST['title']));
    $update_active  = trim(mysql_prep($_POST['active']));
    $passed_code = $_POST['code'];
    
    $update_code = "UPDATE codes SET
                                title = '{$new_title}',
                                active = '{$update_active}'
                                WHERE code = '{$passed_code}' ";
    $result_code = mysql_query($update_code);
}

//get which code we're playing with
if(isset($_GET['c'])){
    
    //get the code
    $code = $_GET['c'];
    
    
    
    //get code details
    $get_codeDetails    = mysql_query("SELECT * FROM codes WHERE code = '{$code}' ");
    $array_codeDetails  = mysql_fetch_array($get_codeDetails);
    $genDate = date('F j, Y \a\t g:i a', strtotime($array_codeDetails['time']) );
    
    //set active toggle
    if($array_codeDetails['active'] == 'yes' ){ //code is active
        $toggleYes = "selected=\"selected\"";
        $toggleNo = "";
    }else{  //code is not active
        $toggleYes = "";
        $toggleNo = "selected=\"selected\"";
    }
    
    //Get all reviews for this code (will loop through them below)
    $get_reviews = mysql_query("SELECT * FROM reviews WHERE codeid = '{$array_codeDetails['id']}' ");
    
    //get count of all reviews for this code
    $count_reviews = mysql_num_rows($get_reviews);
    
    //get date of last review entry for this code
    //$get_lastreview = mysql_query("SELECT id, time FROM reviews WHERE codeid = '{$array_codeDetails['id']}' ORDER BY id DESC LIMIT 1 ");
   // $array_lastreview = mysql_fetch_array($get_lastreview);
    //format last review date for zero reviews
    /*if($array_lastreview['time']==""){
        $lastReviewDate = "n/a";
    }else{
        $lastReviewDate = date('F j, Y \a\t g:i a', strtotime($array_lastreview['time']) );
    }
*/   
}else{
    $code = "An error occurred accessing data for this code (error_128).";
}


?>
<!DOCTYPE html>

<html>
<head>
    <title>More Details</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery/themes/plusdelta.min.css" />
    <link rel="stylesheet" href="jquery/jquery.mobile.structure-1.3.1.min.css" /> 
    <script src="jquery/jquery-1.9.1.min.js"></script> 
    <script src="jquery/jquery.mobile-1.3.1.min.js"></script>
</head>

<body>
    <div data-role="header">
        <a href="account.php" data-icon="back" data-inline="true";>Back</a>
        <h1><img src="images/header_useful.png"></h1>
    </div>
    <br>
    Code: <?php echo $code; ?>
    <br>
    <form action="details.php?c=<?php echo $code; ?>" method="post" data-ajax="false">
        Edit Title: 
        <input type="text" name="title" value="<?php echo htmlentities($array_codeDetails['title']); ?>">
        <br>
        <div class="containing-element">
            <label for="flip-min">Active:</label>
            <select name="active" id="flip-min" data-role="slider">
                <option value="no" <?php echo $toggleNo; ?>>No</option>
                <option value="yes" <?php echo $toggleYes; ?>>Yes</option>
            </select>
        </div>
        <input type="hidden" name="code" value="<?php echo $code; ?>">
        <input type="submit" name="save" value="Save Changes">
    </form>
    <br><br>
    Code generated on: <?php echo $genDate; ?>
    <br><br>
    Reviews submitted: <?php echo $count_reviews; ?>
    <br><br>
    Last review submitted on: <?php // echo $lastReviewDate; ?> Unavailable
    <br><br>
    Review Comments:
    <br><br>
            <div data-role="collapsible-set">
                
                
                
                <?php
                //loop through and print reviews for this code
                $i = 1;
                while($array_reviews = mysql_fetch_array($get_reviews)){
                        echo "<div data-role=\"collapsible\" id=\"review".$i."\" data-collapsed=\"false\">";
                        echo "<h3>Review ".$i."</h3>";
                        echo "YouPlus: ".$array_reviews['youplus']."<br><br>";
                        echo "MePlus: ".$array_reviews['meplus']."<br><br>";
                        echo "YouDelta: ".$array_reviews['youdelta']."<br><br>";
                        echo "MeDelta: ".$array_reviews['medelta']."<br><br>";
                        echo "</div>";
                $i++;
                }  
                //print no reviews message if needed
                if($count_reviews == 0){
                    echo "no reviews found";
                }
                ?>
               </div>
                
                
                
                
</body>
</html>
<?php
require_once("includes/footer.php");
?>