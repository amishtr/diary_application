<?php

/**
 * Filename: signup.php
 * Description: Diary Web Application
 * Author: Amish Trivedi
 * Date developed: 17-Jan-2020
 * Version: 1.0
 */

// Remove error reporting messages from the page
//error_reporting(E_ERROR | E_PARSE);

session_start();

include 'connection.php';

// Encrypt entered password
function RandomToken($length = 32){
  if(!isset($length) || intval($length) <= 8 ){
    $length = 32;
  }
  return bin2hex(random_bytes($length));
}
function Salt(){
  return substr(strtr(base64_encode(hex2bin(RandomToken(32))), '+', '.'), 0, 44);
}

$error = ""; 
$success = "";

    if ($_POST) {
        if (!$_POST["user_name"]) {            
            $error .= "• A username is required.<br>";            
        }

        if (!$_POST["user_email"]) {            
            $error .= "• An email address is required.<br>";            
        }
        
        if (!$_POST["user_password"]) {            
            $error .= "• The password field is required.<br>";            
        }
                
        if ($_POST["user_email"] && filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL) === false) {            
            $error .= "• The email address is invalid.<br>";            
        }
        
    if ($error !== "") {            
            $error = '<div class="alert alert-danger" role="alert"><p><b>There were error(s) in your form:</b></p>' . $error . '</div>';
          
    }  else {  

       $newUserName = mysqli_real_escape_string($conn, $_POST['user_name']);
       $newUserEmail = mysqli_real_escape_string($conn, $_POST['user_email']);
       $newPassword = mysqli_real_escape_string($conn, $_POST['user_password']);
       $salt =  Salt();
       $passwordHashed = password_hash($newPassword.$salt, PASSWORD_DEFAULT);

       $queryCheckExistingUser = "SELECT `userName`, `userEmail` FROM users WHERE userName = '$newUserName' OR userEmail = '$newUserEmail'";
             
       $result = mysqli_query($conn, $queryCheckExistingUser);        
       
       if(mysqli_num_rows($result) > 0){    
         
         $error = '<div class="alert alert-danger" role="alert">Sorry, the entered email address <b>' .$_POST["user_email"]. '</b> has already been taken. Please try a different email to sign up.</div>';     
         
       } else {

      $queryInsertUser = "INSERT INTO `users` (userName, userEmail, userPassword,salt) VALUES('$newUserName', '$newUserEmail', '$passwordHashed','$salt')";
           
      if(mysqli_query($conn, $queryInsertUser)) {           

        $success = '<div class="alert alert-success" role="alert">You have successfully registered in the system. Please go back to login page to sign in.</div>'; 
        //header("Location: login.php");

      } else { 
          $error = '<div class="alert alert-danger" role="alert">Sorry, there was a problem registering email <b>' .$_POST["user_email"]. '</b>. Please try again later.</div>';     
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);            
        } 
       } 
       //Close connection
       mysqli_close($conn);   
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
  body {
    background-image: url("images/login_image.jpg");
    background-repeat: no-repeat;
  }

  .modal-dialog {
    top: calc(100% - 400px); 
  }   
</style>

<body>
<div class="container pt-3 mt-2">
 <div id="error"><? echo $error; ?></div>
 <div id="success"><? echo $success; ?></div>
  <div class="row justify-content-sm-center">
    <div class="col-sm-10 col-md-6">
      <div class="card border-info">
        <div class="card-header">Please register to continue</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 text-center">
            <img src="images/register-icon.png">
            </div>
            <div class="col-md-8">
              <form class="form-signin" method="POST" novalidate>
                <input type="text" class="form-control mb-2" id="user_name" name="user_name" placeholder="Username" required autofocus>
                <input type="text" class="form-control mb-2" id="user_email" name="user_email" placeholder="Email" required>
                <input type="password" class="form-control mb-2" id="user_password" name="user_password" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block mb-1" type="submit">Sign up</button>                
                <a href="login.php" class="float-right">Back to Sign In</a>
              </form>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script type="text/javascript">
    // jQuery validation //
    $("form").submit(function(e) {              
      var error = "";
      
      if ($("#email").val() == "") {                  
          error += "• The email field is required.<br>"                  
      }
      
      if ($("#password").val() == "") {                  
          error += "• The password field is required.<br>"                  
      }              
                    
      if (error != "") {                  
          $("#error").html('<div class="alert alert-danger" role="alert"><p><strong>There were error(s) in your form:</strong></p>' + error + '</div>'); 
          return false;
          
      } else {                  
          return true;                  
      } 
    }) 
</script>

</body>
</html>