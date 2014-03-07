<?php
require("connection.php");

// This file is the place to store all basic functions

function mysql_prep( $value ) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
    if( $new_enough_php ) { // PHP v4.3.0 or higher
	// undo any magic quote effects so mysql_real_escape_string can do the work
	if( $magic_quotes_active ) { $value = stripslashes( $value ); }
	    $value = mysql_real_escape_string( $value );
    } else { // before PHP v4.3.0
	// if magic quotes aren't already on then add slashes manually
	if( !$magic_quotes_active ) { $value = addslashes( $value ); }
	    // if magic quotes are active, then the slashes already exist
    }
    return $value;
}

function confirm_query($result_set) {
    if (!$result_set) {
	die("Database query failed: " . mysql_error());
    }
}

function confirmed_logged_in() {
    if(isset($_SESSION['userid'])){
	//do nothing, stay on page
    }else{
	redirect_to('index.php');
    }
}

function redirect_to( $location = NULL ) {
    if ($location != NULL) {
	header("Location: {$location}");
	exit;
    }
}

function generate_new_unique_code(){
    $num_rows= 1;
    while($num_rows != 0){
        //Generating 7 digit code: A12345Z
        $numbers1=(mt_rand(1,9));
        $numbers2=(mt_rand(1,9));
        $numbers3=(mt_rand(1,9));
        $numbers4=(mt_rand(1,9));
        $numbers5=(mt_rand(1,9));
        $letter1 = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ"), 0, 1);          
        $letter2 = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ"), 0, 1);          
        $code=$letter1.$numbers1.$numbers2.$numbers3.$numbers4.$numbers5.$letter2;
        
        $check_code= mysql_query("SELECT code FROM codes WHERE code = '{$code}'");
        $num_rows= mysql_num_rows($check_code);
    }
    return $code;
}

function check_required_fields($required_array) {
	$field_errors = array();
	foreach($required_array as $fieldname) {
		if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_numeric($_POST[$fieldname]))) { 
			$field_errors[] = $fieldname; 
		}
	}
	return $field_errors;
}

function check_max_field_lengths($field_length_array) {
	$field_errors = array();
	foreach($field_length_array as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $field_errors[] = $fieldname; }
	}
	return $field_errors;
}

function display_errors($error_array) {
	echo "<p style=\"color:#C20000; font-size: 12px;\">";
	//echo "Please review the following fields:<br />";
	foreach($error_array as $error) {
		
		if($error == "email"){
			$error = "";
		}elseif($error == "agree"){
			$error = "Please agree to the NDA.";
		}else{}
		
		echo $error;
	}
	echo "</p>";
}


?>