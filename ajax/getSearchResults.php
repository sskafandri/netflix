<?php
require_once("../includes/config.php");

if(isset($_POST["term"]) && isset($_POST["username"])){
    echo "hello " . $_POST["term"];
}
else{
    echo "No videoId or username passed into file";
}
?>