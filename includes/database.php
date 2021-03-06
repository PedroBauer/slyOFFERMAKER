<?php

/*
 Filename: database.php
 Author: Pedro Bauer
 Description: This file handles the connection to the mysql database and 
 is implemented while using the blockeditor or right after the conditions page.
  
 */
$databaseName ="#####";
$databaseUser ="#####";
$databasePassword = "#####";

$db = @mysqli_connect("127.0.0.1", $databaseUser, $databasePassword);
if (!@$db) die("Verbindung zur Datenbank konnte nicht hergestellt werden!");

mysqli_select_db($db, $databaseName);
if (mysqli_errno($db)) die("Verbindung zur Datenbank konnte nicht hergestellt werden!");

$sql = "SET NAMES 'utf8'";
$db->query($sql);

?>