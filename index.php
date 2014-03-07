<?php
//detect and deliver thank you message
if(isset($_GET['m'])){
    
    if($_GET['m']=='thankyou'){
        $message = "Thank you for providing your review.";
    }
    if($_GET['m']=='reviewcancelled'){
        $message = "Your review submission was not saved.";
    }
    
}else{
    $message = "";
}
?>
<!DOCTYPE html>

<html>
<head>
    <title>Sukete</title>    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery/themes/plusdelta.min.css" />
    <link rel="stylesheet" href="jquery/jquery.mobile.structure-1.3.1.min.css" /> 
    <script src="jquery/jquery-1.9.1.min.js"></script> 
    <script src="jquery/jquery.mobile-1.3.1.min.js"></script>
    <link rel="apple-touch-icon" href="images/bookmark_57px.png"/>  
    <link rel="apple-touch-icon" sizes="72x72" href="images/bookmark_72px.png"/>  
    <link rel="apple-touch-icon" sizes="114x114" href="images/bookmark_114px.png"/>     
</head>

<body>
    <div data-role="header">
        <a href="login.php" data-icon="gear">Login</a>
        <h1><img src="images/header_useful.png"></h1>
    </div>
    <br><br>
    <div style="text-align: center;">
        <?php echo $message; ?>
    </div>
    <div>   
        <a href="entercode.php" data-role="button" style="height: 100px;">SUBMIT A REVIEW CARD</a>
    </div>
    <br><br>
    <div>
        <a href="signup.php" data-role="button" style="height: 100px;">SIGN UP</a>
    </div>
    <div style="text-align: center;">
        <img src="images/sukete_logo.png">
    </div>
</body>
</html>
<?php
require_once("includes/footer.php");
?>
