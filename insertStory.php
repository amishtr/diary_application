<?php

/**
 * Filename: insertStory.php
 * Description: Diary Web Application
 * Author: Amish Trivedi
 * Date developed: 12-Nov-2019
 * Version: 1.0
 */

session_start();
include 'connection.php';

$data['post'] = $_POST;
$data['error'] = '';

if($_POST['text']){
      $story = $_POST['text'];       

      $query = "UPDATE users SET userStory = '$story' WHERE userEmail = '" .$_SESSION['userEmail']. "'";
      $result = mysqli_query($conn, $query);

      $data['mysql'] = $result;     

      if($result){
          $data['message'] = "Data inserted successfully into system.";     
        }
      else {
          $data['error'] = 'There is a problem, please try again later.';
        } 
      } 
echo json_encode($data);

?>