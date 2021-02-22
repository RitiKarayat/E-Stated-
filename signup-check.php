<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['email']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])) {





	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$email = validate($_POST['email']);
	$pass = validate($_POST['password']);

	$re_pass = validate($_POST['re_password']);
	$name = validate($_POST['name']);

	$user_data = 'email='. $email. '&name='. $name;

	if(empty($_POST["password"])){
		header("Location: signup.php?error=Password is required&$user_data");
		exit();
}elseif(!(strlen($_POST["password"])>6
         and preg_match('/[A-Z]/',$_POST["password"])
				 and preg_match('/[0-9]/',$_POST["password"])
				 and preg_match('/[a-z]/',$_POST["password"])
        )
       ){
    	header("Location: signup.php?error=Password should conatin atleast one uppercase and one number&$user_data");
	    exit(); 
}else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING); 
    if(empty($_POST["re_password"])){
			header("Location: signup.php?error=confirm password is require &$user_data");
	    exit();
    }else{
        $password2 = filter_var($_POST["re_password"], FILTER_SANITIZE_STRING);
        if($password !== $password2){
					header("Location: signup.php?error=Both Passwords do not match&$user_data");
					exit();
            
        }
    }
}

	



	if (empty($email)) {
		header("Location: signup.php?error=Email is required&$user_data");
	    exit();
	}

	else if(empty($name)){
        header("Location: signup.php?error=Name is required&$user_data");
	    exit();
	}

	

	else{

		// hashing the password
        $pass = md5($pass);

	    $sql = "SELECT * FROM users WHERE user_name='$email' ";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			header("Location: signup.php?error=This email is taken try another&$user_data");
	        exit();
		}else {
           $sql2 = "INSERT INTO users(user_name, password, name) VALUES('$email', '$pass', '$name')";
           $result2 = mysqli_query($conn, $sql2);
           if ($result2) {
           	 header("Location: signup.php?success=Your account has been created successfully");
	         exit();
           }else {
	           	header("Location: signup.php?error=unknown error occurred&$user_data");
		        exit();
           }
		}
	}
	
}else{
	header("Location: signup.php");
	exit();
}