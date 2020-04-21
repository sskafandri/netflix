<?php

require_once("includes/header.php");

if(isset($_POST["saveDetailsButton"])){
    $account = new Account($con);

    $firstName = FormSnitizer::sanitizeFormString($_POST["fistName"]);
    $lastName = FormSnitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSnitizer::sanitizeFormEmail($_POST["email"]);

}

?>

<div class="settingsContainer column">

    <div class="formSection">

        <form action="" method="POST">
        
        <h2>User details</h2>

        <?php

        $user = new User($con,$userLoggedIn);

        $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
        $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
        $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();

        ?>

        <input type="text" name="firstName" placeholder="First name" value="<?php echo $firstName ?>">
        <input type="text" name="lastName" placeholder="Last name" value="<?php echo $lastName ?>">
        <input type="email" name="email" placeholder="Email " value="<?php echo $email ?>">

        <input type="submit" name="saveDetailsButton" value="save">
        </form>

    </div>

    <div class="formSection">

        <form action="" method="POST">
        
        <h2>Update password</h2>

        <input type="password" name="oldPassword" placeholder="Old pasword">
        <input type="password" name="newPassword" placeholder="New password">
        <input type="password" name="newPassword2" placeholder="Confirm new password">

        <input type="submit" name="savePasswordButton" value="save">
        </form>

    </div>
</div>