<?php
require_once("includes/header.php");

$preview = new PreviewProvider($con,$userLoggedIn);
echo $preview->createPreviewVideo(null); 

$preview = new CategoryContainers($con,$userLoggedIn);
echo $preview->showAllCategories(); 
?>