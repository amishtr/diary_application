<?php

/**
 * Filename: login.php
 * Description: Diary Web App
 * Author: Amish Trivedi
 * Date developed: 12-Nov-2019
 * Version: 1.0
 */

// Remove error reporting messages from the page
//error_reporting(E_ERROR | E_PARSE);

session_start();
include 'connection.php';

$error = ""; 

    if ($_POST) {   

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
          
    } else {         
      $queryCheckUser = "SELECT `id`, `userName`, `userPassword`, `salt` FROM `users` WHERE userEmail = '".$_POST['user_email']."'";
      
      $result = mysqli_query($conn, $queryCheckUser);

      //check if user exists
      if(mysqli_num_rows($result) < 1){  
        
        $error = '<div class="alert alert-danger" role="alert">Sorry, the email <b>' .$_POST["user_email"]. $_POST['user_name']. '</b> or the password is incorrect. Please input the correct credentials to login.</div>';
      
      } else {
          $row = mysqli_fetch_assoc($result);
          if(!password_verify($_POST['user_password'].$row['salt'], $row['userPassword'])){
            $error = '<div class="alert alert-danger" role="alert">Sorry, the email <b>' .$_POST["user_email"]. '</b> or the password is incorrect. Please input the correct credentials to login.</div>';                 
        
        } else {
          $_SESSION['userEmail'] = $_POST['user_email'];           
          $row = mysqli_fetch_assoc($result);
          $_SESSION['userName'] = $_POST['user_name'];   
          header("Location: index.php");
        }
      }   
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>

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
  <div class="row justify-content-sm-center">
    <div class="col-sm-10 col-md-6">
      <div class="card border-info">
        <div class="card-header">Sign in to continue</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 text-center">
            <img src="images/login-icon.png">
            </div>
            <div class="col-md-8">
              <form class="form-signin" method="POST" novalidate>
                <input type="text" class="form-control mb-2" id="user_email" name="user_email" placeholder="Email" required autofocus>
                <input type="password" class="form-control mb-2" id="user_password" name="user_password" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block mb-1" type="submit">Sign in</button>                
                <a href="signup.php" class="float-right">Register an account</a>
              </form>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>

<!--- <div class="container mt-5">
  <div id="error"><? echo $error; ?></div>
    <div class="row">
      <div class="col-sm"></div>
      <div class="col-sm">
    <form method="post" novalidate>
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control border border-secondary" id="user_email" name="user_email" style="width:400px;" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control border border-secondary" id="user_password" name="user_password" style="width:400px;" placeholder="Password">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
      </div>
      <div class="col-sm"></div>
    </div>
</div> --->
    
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