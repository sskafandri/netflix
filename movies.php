<?php
require_once("includes/header.php");

$preview = new PreviewProvider($con,$userLoggedIn);
echo $preview->createTVShowPreviewVideo(); 

$preview = new CategoryContainers($con,$userLoggedIn);
echo $preview->showMoviesCategories(); 
?>