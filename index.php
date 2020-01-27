<?php

/**
 * Filename: index.php
 * Description: Diary Web Application
 * Author: Amish Trivedi
 * Date developed: 12-Nov-2019
 * Version: 1.0
 */

// Remove error reporting messages from the page
 error_reporting(E_ERROR | E_PARSE);

session_start();
include 'connection.php';

$errorMsg = "";
$successMsg = "";

$errorMsg .= "Something went wrong, please try again later.";
//$data['error'] = $errorMsg;
$successMsg .= "The story has been saved in the system.";

//$errorMsg .= '<div class="alert alert-danger" role="alert" style="text-align: center;">The story field cannot be empty. Please write or update your story to SAVE.';  
  
$query = "SELECT `userStory`, `userName` FROM `users` WHERE userEmail = '".$_SESSION['userEmail']."'";
  
$result = mysqli_query($conn, $query);    
$row = mysqli_fetch_assoc($result);  
$value = $row["userStory"]; 
$userName = $row["userName"]; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['userName']. " | Homepage"; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/line-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/simditor.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Simiditor plugin files -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/module.js"></script>
    <script type="text/javascript" src="js/hotkeys.js"></script>
    <script type="text/javascript" src="js/uploader.js"></script>
    <script type="text/javascript" src="js/simditor.js"></script>

<style>

  body {
    background-color: #F8F8F8;
  }

</style>
</head>

<body>    
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Secret Diary</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Page 1</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Page 2</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Page 3</a>
      </li>
    </ul>
    <div class="my-2 my-lg-0">       
    <a href="logout.php" class="btn btn-danger"><i class="fa fa-unlock-alt"></i><span style="margin-left: 5px;"> LOGOUT</span></a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="text-center">
  <h3><?php if(!$_SESSION['userEmail'] == '') {
              echo "Welcome, " .$userName. " to your homepage.";
            } else {
              header("Location: login.php");
      }?>
  </h3>
  <p>"I always say, keep a diary and someday it'll keep you." - Mae West</p>
  </div>
  
  <form class="form-group" method="">

    <label for="text">Start writing your own story...</label>    
    <div class="alert alert-danger text-center" id="error" style="display:none"><? echo $errorMsg; ?></div>
    <div class="alert alert-success text-center" id="success" style="display:none"><? echo $successMsg; ?></div>
    <textarea class="form-control border border-secondary h-100" id="editor" style="background:#FFFFE0" name="text"><?php echo $value; ?></textarea>
    <button type="submit" class="btn btn-primary mt-2 float-right"><i class="fa fa-save"></i><span style="margin-left: 5px;"> Save</button>
  
  </form>
</div>    

<script>
  var editor = new Simditor({
    textarea: $('#editor')
    //optional options 
  });
</script>

<script>
      $(function () {
        $('form').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
            url: 'insertStory.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
              if(data.error ==''){
              //alert('form was submitted');
              $("#success").show("slow").delay(5000).hide(0);
              }
              else{
                //alert(data.error);                      
                $("#error").show("slow").delay(5000).hide(0);
              }
            },
            error:function(data){              
              //alert("Something went wrong, please try again later."); 
            }
          });
        });
      });
</script>

</body>
</html>

