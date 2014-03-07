<?php require_once("includes/connection.php")?>
<?php require_once("includes/functions.php")?>
<?php require_once("includes/session.php"); ?>
<?php
    $error_message= "";
    
    if(isset($_POST['submit'])) {
        
        //Set and configure the time
        date_default_timezone_set('America/Chicago');
        $datetime= date("Y-m-d h:i:s a");
        
        
        //Trim and set the inputs to variables
        $email= trim(mysql_prep($_POST['email']));
        $password= trim(mysql_prep($_POST['password']));
        $hashed_password= sha1($password);

        if($email != "" AND $password != ""){
            $get_login= mysql_query("SELECT * FROM users WHERE email = '{$email}'");
            $fetch_login= mysql_fetch_array($get_login);
            $correct_password= $fetch_login['password'];
            
            if($correct_password == $hashed_password){
                //$error_message= "Success!";
                
                //get userid
                $get_id = mysql_query("SELECT id FROM users WHERE email = '{$email}'");
                $fetch_id = mysql_fetch_array($get_id);
                
                //set login timestamp
                $update_login = mysql_query("UPDATE users SET lastlogin = '{$datetime}' WHERE email = '{$email}' ");
                
                //set session
                $_SESSION['userid'] = $fetch_id['id']; 
                $_SESSION['email'] = $email;
                
                //redirect user
                redirect_to("account.php");
            }else{
                $error_message= "The email/password you have entered is incorrect.";
            }
            }
        }
?>
<!DOCTYPE html>

<html>
<head>
    <title>Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="jquery/themes/plusdelta.min.css" />
        <link rel="stylesheet" href="jquery/jquery.mobile.structure-1.3.1.min.css" /> 
        <script src="jquery/jquery-1.9.1.min.js"></script> 
        <script src="jquery/jquery.mobile-1.3.1.min.js"></script>    
</head>

<body>
    <div data-role="header">
        <a href="index.php" data-icon="grid" data-inline="true";>Main</a>
        <h1><img src="images/header_useful.png"</h1>
    </div>
        
    <form action="login.php" method="post" data-ajax="false">
        Email:<input type="text" name="email" value="">
        
        Password:<input  type="password" name="password" value="">
        
        <span style="color: red;"><?php echo $error_message ?></span>       
        <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>
<?php
require_once("includes/footer.php");
?>