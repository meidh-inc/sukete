<?php require_once("includes/session.php")?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
    
    $message = "";
    
    if(isset($_POST['entercode'])){
        
        $code= trim(mysql_prep($_POST['code']));    //test code: C23226S
        
        $check_code= mysql_query("SELECT * FROM codes WHERE code = '{$code}' ");
        $num_rows= mysql_num_rows($check_code);
        
        if($num_rows == 1){
            $_SESSION['code'] = $code;
            redirect_to("review.php");
        }else{
            $message = "Code Not Found.";
        }
    }

?>
<!DOCTYPE html>

<html>
<head>
    <title>Submit</title>
<!--  http://jquerymobile.com/themeroller/?ver=1.3.1&style_id=20130625-76   -link works until July 20, 2013-->    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery/themes/plusdelta.min.css" />
    <link rel="stylesheet" href="jquery/jquery.mobile.structure-1.3.1.min.css" /> 
    <script src="jquery/jquery-1.9.1.min.js"></script> 
    <script src="jquery/jquery.mobile-1.3.1.min.js"></script>
</head>

<body>
    <div data-role="header">
        <h1><img src="images/header_useful.png"></h1>
        <a href="index.php" data-icon="grid";>Main</a>
    </div>

    <form action="entercode.php" method="post" data-ajax="false">
        
        <div data-role="fieldcontain">
            Enter Your 7 Digit Review Code:
            <br>
            <input type="text" name="code" maxlength="7">
            <br>
            <?php echo $message; ?>
        </div>
        <input type="submit" name="entercode" value="Enter Code">
        
    </form>

</body>
</html>
<?php
require_once("includes/footer.php");
?>