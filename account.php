<?php require_once("includes/session.php")?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
//logged in?
confirmed_logged_in();

//gather user info
$user_id= $_SESSION['userid'];
$email= $_SESSION['email'];

//button to generate new code is clicked
if(isset($_POST['newcode'])){    
    $datetime= date("Y-m-d h:i:s a");
    $code = generate_new_unique_code();
    $insertcode = mysql_query("INSERT INTO codes (userid,code,time) VALUES ('{$user_id}','{$code}','{$datetime}')");
}    


?>
<!DOCTYPE html>

<html>
<head>
    <title>Account</title>
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
        <a href="logout.php" data-icon="gear">Logout</a>
    </div>
    <div style="text-align: center;">
        <strong><?php echo $email; ?></strong>
    </div>
    <form action="account.php" method="post" data-ajax="false">
        <input type="submit" name="newcode" value="Generate New Code">
    </form>
    <ul data-role="listview">
    <?php
        $get_codelist = mysql_query("SELECT * FROM codes WHERE userid = '{$user_id}' ");
        while($array_codelist = mysql_fetch_array($get_codelist)){
            if($array_codelist['title'] == ""){
                $codeTitle = "untitled";
            }else{
                $codeTitle = $array_codelist['title'];
            }
            
            $buttonText = $array_codelist['code'].": ".$codeTitle;
            
            
            
            
            echo "<li><a href=\"details.php?c=".$array_codelist['code']."\">".$buttonText."</a></li>";
        }
    ?>
    </ul>
</body>
</html>
<?php
require_once("includes/footer.php");
?>