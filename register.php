<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");   //reference to class where we are going to get FormSanitizer class
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");


    $account = new Account($con);

    if(isset($_POST["submitButton"])){

        $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);  //class name::Static method name .. aise hi call kiya jata hai static method ko
        $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
        $username = FormSanitizer::sanitizeFormUsername($_POST["userName"]);
        $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

    
        $success = $account->register($firstName,$lastName,$username,$email,$email2,$password,$password2);
        
        if($success){
            $_SESSION["userLoggedIn"] = $username;  //session establishing
            header("Location:index.php");  //goto this page
        }

        $success = $account->login($username,$password);
        
        if($success){
            $_SESSION["userLoggedIn"] = $username;  //session establishing
            header("Location: index.php");  //goto this page
        }
    }
    
    function getInputValue($name){
        if(isset($_POST[$name])){  //this will store data in post this will not lost when user enter wrong data
            echo $_POST[$name];    // as user will have to enter all the data agin..but this will show where user is wrong .. value used in email email2 usrname and all
        }                           // are used together so that data is not lost
    }   
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="assets/style/style.css">
<link href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAAEAKPAA4DjgAPBq8AEASSAA8FpgATCeUAFAnlABUJ5QASCuQADwalAAAAAQAPBrAAAQABAAABAAABAQAAEgnmABMJ5gAVCuUAGg/fABAFsgAPBrEAAQEBABkN4gAPA5MAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADxUUABYJCAsAAAAAAAAAAA8VFQAXBgYLAAAAAAAAAAAPFRUOBgYYCwAAAAAAAAAADxUVCwYGAwsAAAAAAAAAAA8VAxAGBxULAAAAAAAAAAAPFQoGBgIVCwAAAAAAAAAADxUBBhIFFQsAAAAAAAAAAA8VBwYRDBULAAAAAAAAAAAPDAYGABUVCwAAAAAAAAAADwQGBgAVFQsAAAAAAAAAAA8GBhMAFRULAAAAAAAAAAANBgYNABUVCwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=" rel="icon" type="image/x-icon" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
<title>welcome to netflix</title>
</head>
<body>
    <div class="signInContainer">
        <div class="column">

            <div class="header">
                <img src="assets/images/img1.png" title="logo" alt="site logo">
                <h3>Sign Up</h3>
                <span>to continue to netflix</span>
            </div>
            <form action="" method="POST">
                <?php echo $account->getError(Constants::$firstNameCharacters); ?>   
                <input type="text" name="firstName" placeholder="first name" value="<?php getInputValue("firstName") ?>" required>

                <?php echo $account->getError(Constants::$lastNameCharacters); ?>   
                <input type="text" name="lastName" placeholder="last name" value="<?php getInputValue("lastName") ?>" required>

                <?php echo $account->getError(Constants::$usernameCharacters); ?>   
                <?php echo $account->getError(Constants::$usernameTaken); ?>                     
                <input type="text" name="userName" placeholder="user name" value="<?php getInputValue("userName") ?>" required> 

                <?php echo $account->getError(Constants::$emailDontMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <?php echo $account->getError(Constants::$emailTaken); ?>
                <input type="email" name="email" placeholder="email" value="<?php getInputValue("email") ?>" required>
                <input type="email" name="email2" placeholder="confirm email" value="<?php getInputValue("email2") ?>" required>

                <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
                <?php echo $account->getError(Constants::$passwordLength); ?>
                <input type="password" name="password" placeholder="password" required>
                <input type="password" name="password2" placeholder="confirm password" required>
                <input type="submit" name="submitButton" value="SUBMIT">
            </form>

            <a href="login.php" class="signInMessage">already have a account? sign in here!</a>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>