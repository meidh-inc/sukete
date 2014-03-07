<?php require_once("includes/session.php")?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
    $error_message= "";
    
    if(isset($_POST['submit'])) {
        
        //Set and configure the time
        date_default_timezone_set('America/Chicago');
        $datetime= date("Y-m-d h:i:s a");
        
        //Trim and set the inputs to variables
        $email= trim(mysql_prep($_POST['email']));
        $email_2= trim(mysql_prep($_POST['email_2']));
        $password= trim(mysql_prep($_POST['password']));
        $password_2= trim(mysql_prep($_POST['password_2']));
        
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message= "This (email_a) email address is considered valid.";
            }      
        
        //If the emails and passwords match proceed to put information in the database
    if($email == $email_2 AND $password == $password_2) {
        
        if($email != "" AND $password !=""){
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $check_email= mysql_query("SELECT id FROM users WHERE email = '{$email}'");
                $num_rows= mysql_num_rows($check_email);
                    if($num_rows > 0){
                        $error_message= "The email you have entered is already in use.";
                    }else{
               
                $hashed_password= sha1($password);    
                $insert = mysql_query("INSERT INTO users (email, password, signuptime) VALUES ('{$email}', '{$hashed_password}', '{$datetime}')");    
                $error_message= "Success";
                $get_id = mysql_query("SELECT id FROM users WHERE email = '{$email}'");
                $fetch_id = mysql_fetch_array($get_id);
                $user_id = $fetch_id['id'];
                $_SESSION['userid'] = $user_id; 
                $_SESSION['email'] = $email;
                redirect_to("account.php");
                }
                
            }else{
                $error_message= "Your email address is not a valid format.";
            }      
            
        }else{
            
            $error_message="Email and password required.";
            
        }
        }else{
            
            $error_message="Your email and/or password do not match.";
        }

    }else{
        $email= "";
        $email_2= "";
        $password= "";
        $password_2= "";
    }





?>
<!DOCTYPE html>

<html>
<head>
    <title>Sign Up</title>
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
        <h1><img src="images/header_useful.png"></h1>
        <a href="login.php" data-icon="gear">Login</a>
    </div>
        
    <form action="signup.php" method="post">
        Email:<input type="text" name="email" value="<?php echo htmlentities($email); ?>">
        
        Confirm Email:<input type="text" name="email_2" value="<?php echo htmlentities($email_2); ?>">
        
        Password:<input  type="password" name="password" value="<?php echo htmlentities($password); ?>">
        
        Confirm Password:<input type="password" name="password_2" value="<?php echo htmlentities($password_2); ?>">
        
        <span style="color: red;"><?php echo $error_message; ?></span>       
        <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>
<?php
require_once("includes/footer.php");
?>
