<?php

session_start();//we have to start the session in order to destroy it ...if we try to destroy the
//session without starting it .. it cannot becasuse there are no session  in the page ..
//the only way of destroying the session is by staring the session in the page..
//we have to start the session so we can destroy it and the we redirect the user to login page
session_destroy();
header("Location:login.php");

?>