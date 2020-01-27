<?php

/**
 * Filename: logout.php
 * Description: Diary Web Application
 * Author: Amish Trivedi
 * Date developed: 12-Nov-2019
 * Version: 1.0
 */

include 'connection.php';

session_start();
session_destroy();

header('location: login.php');

?>