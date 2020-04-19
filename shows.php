<?php
require_once("includes/header.php");

$preview = new PreviewProvider($con,$userLoggedIn);
echo $preview->createTVShowPreviewVideo(null); 

$preview = new CategoryContainers($con,$userLoggedIn);
echo $preview->showTvShowCategories(); 
?>