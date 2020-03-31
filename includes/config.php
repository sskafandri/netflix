<?php

ob_start(); //turns on the output buffering 
session_start(); //it start the session stores the data from when to when user was log in

date_default_timezone_set("Asia/Kolkata");


 /**DATA BASE CONNECTION */
try{
    $con = new PDO("mysql:dbname=netflix;host=localhost","root","");  //root =username ,""= it is password
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);   //error mode
}
catch(PDOException $e){  //PDO phpdataobject
    exit("Connection failed"  .  $e->getMessage());
}
?>