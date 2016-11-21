<?php
require 'config.php';

// $dbname = "Zeni"; //manually putting in username and password instead of config.php
// $dbusername = "root";
// $dbpassword = "";

try {
  $conn = new PDO('mysql:host=localhost', $config['DB_USERNAME'], $config['DB_PASSWORD']);



  $conn = new PDO('mysql:host=localhost', $config['DB_USERNAME'], $config['DB_PASSWORD']);
  // $conn = new PDO('mysql:host=localhost', $dbusername, $dbpassword); //If we decided to manully input the username/password data
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $create_db = "CREATE DATABASE IF NOT EXISTS `Zeni` ";
  $conn->exec($create_db);
  $conn->query("USE `Zeni`");



  $create_users = "CREATE TABLE IF NOT EXISTS `users` (
  	`uid` int(11) PRIMARY KEY AUTO_INCREMENT,
  	`fname` varchar(255) NOT NULL,
  	`lname` varchar(255) NOT NULL,
  	`username` varchar(255) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`salt` varchar(255) NOT NULL,
  	`is_admin` tinyint(1) NOT NULL
  	)";

	$conn->exec($create_users);

} 
catch(PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
}

// if ($conn) {
//   echo "Connected!";



