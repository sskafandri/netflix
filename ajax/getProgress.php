<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"])){
    $query = $con->prepare("SELECT progress from videoProgress
                            WHERE username=:username AND videoId=:videoId");//NOW() is a buildin function of mysql that is use for knowing the current timestamp
    $query->bindValue(":username",$_POST["username"]);
    $query->bindValue(":videoId",$_POST["videoId"]);
    
    $query->execute();
    echo $query->fetchColumn(); //this is used when only one column is returned from the query .. it will give progress value
    

}
else{
    echo "No videoId or username passed into file";
}
?>