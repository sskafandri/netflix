<?php
class Account{

    private $con;
    private $errorArray = array();  //empty array
    public function __construct($con){ //contructor of account class
        $this->con = $con;
    } 

    public function updateDetails($fn,$ln,$em,$un){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em,$un);

        if(empty($this->errorArray)){
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em
                                        WHERE username=:un");
        
        $query->bindValue(":fn",$fn);
        $query->bindValue(":ln",$ln);
        $query->bindValue(":em",$em);
        $query->bindValue(":un",$un);
        
        return $query->execute();

        }
        return false;
    }
    public function register($fn,$ln,$un,$em,$em2,$pw,$pw2){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmails($em,$em2);
        $this->validatePasswords($pw,$pw2);

        if(empty($this->errorArray)){
            return $this->insertUserDetails($fn,$ln,$un,$em,$pw);          
        }
        return false;
    }

    public function login($un,$pw){
        $pw= hash("sha512",$pw); //when user enter a password it is matched with database both in hashed manner .. that is hashed is matched with hashed

        $query = $this->con->prepare("SELECT *  FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un",$un);
        $query->bindValue(":pw",$pw);

        $query->execute();
        if($query->rowCount()== 1){
            return true;
        }

        array_push($this->errorArray,Constants::$loginFailed);
        return false;

    }

    private function insertUserDetails($fn,$ln,$un,$em,$pw){
        $pw= hash("sha512",$pw); //hash the password and store in $pw sha512 is the hashing one of the hashing type
        $query = $this->con->prepare("INSERT INTO users (firstName,lastName,username,email,password)
                                        VALUES (:fn,:ln,:un,:em,:pw)");

        $query->bindValue(":fn",$fn);
        $query->bindValue(":ln",$ln);
        $query->bindValue(":un",$un);
        $query->bindValue(":em",$em);
        $query->bindValue(":pw",$pw);

        return $query->execute();
    }


    private function validateFirstName($fn){    //fs stand for first name, this function is used for 
     //checking standars that first name should be grater than 2 charter and less than 25 char
        if(strlen($fn)< 2 || strlen($fn)> 25){
            array_push($this->errorArray,Constants::$firstNameCharacters); //fist name worng ... is pushed to an array errorArray
        }    

    }
    
    private function validateLastName($ln){    //ls stand for last name, this function is used for 
        //checking standars that first name should be grater than 2 charter and less than 25 char
        if(strlen($ln)< 2 || strlen($ln)> 25){
            array_push($this->errorArray,Constants::$lastNameCharacters); //fist name worng ... is pushed to an array errorArray
        }    

    }
    
    private function validateUserName($un){    //ls stand for last name, this function is used for 
    //checking standars that first name should be grater than 2 charter and less than 25 char
        if(strlen($un)< 2 || strlen($un)> 25){
            array_push($this->errorArray,Constants::$usernameCharacters); //fist name worng ... is pushed to an array errorArray
            return;
        }
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");   //sequel query..it is used to check wheather user name already exist or not
        $query->bindValue(":un",$un);

        $query->execute();

        if($query->rowCount()!=0){
            array_push($this->errorArray,Constants::$usernameTaken);
        }
    }
    private function validateEmails($em,$em2){
        if($em != $em2){    //check both are same or not
            array_push($this->errorArray,Constants::$emailDontMatch);    
            return;
        }
        if(!filter_var($em,FILTER_VALIDATE_EMAIL)){ //it will fiter em with validate email filter.. filter_var is bulid in function..check valid email
            array_push($this->errorArray,Constants::$emailInvalid);
            return;
        }
        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");   //sequel query..it is used to check wheather user name already exist or not
        $query->bindValue(":em",$em);

        $query->execute();

        if($query->rowCount()!=0){
            array_push($this->errorArray,Constants::$emailTaken);
        }
    }
    private function validateNewEmail($em,$un){
        

        if(!filter_var($em,FILTER_VALIDATE_EMAIL)){ //it will fiter em with validate email filter.. filter_var is bulid in function..check valid email
            array_push($this->errorArray,Constants::$emailInvalid);
            return;
        }
        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em AND username != :un");   //sequel query..it is used to check wheather user name already exist or not
        $query->bindValue(":em",$em);
        $query->bindValue(":un",$un);


        $query->execute();

        if($query->rowCount()!=0){
            array_push($this->errorArray,Constants::$emailTaken);
        }
    }
    private function validatePasswords($pw,$pw2){
        if($pw != $pw2){    //check both are same or not
            array_push($this->errorArray,Constants::$passwordsDontMatch);    
            return;
        }
        if(strlen($pw)< 5 || strlen($pw)> 25){
            array_push($this->errorArray,Constants::$passwordLength); //fist name worng ... is pushed to an array errorArray
            return;
        }
    }
    
    public function getError($error){
        if(in_array($error,$this->errorArray))  //in_array method check if somethis is in the array.. check if $error is inside of the errorArray
        {
            return "<span class='errorMessage'>$error</span>";
        }
        else{
            $errorMessage = $account->getFirstError();

            $detailsMessage = "<div class='alertError'>
                                    $errorMessage
                                </div>";
        }
    }

    public function getFirstError(){
        if(!empty($this->errorArray)){
            return $this->errorArray[0];
        }
    }
   public function updatePassword($oldPw,$pw,$pw2,$un){
        $this->validateOldPassword($oldPw,$un);
        $this->validatePasswords($pw,$pw2);

        if(empty($this->errorArray)){
            $query = $this->con->prepare("UPDATE users SET password=:pw WHERE username=:un");
            $pw= hash("sha512",$pw);
            $query->bindValue(":pw",$pw);
            $query->bindValue(":un",$un);
            
            return $query->execute();

        }
        return false;
   }
   public function validateOldpassword($oldPw,$un){
    $pw= hash("sha512",$oldPw); //when user enter a password it is matched with database both in hashed manner .. that is hashed is matched with hashed

    $query = $this->con->prepare("SELECT *  FROM users WHERE username=:un AND password=:pw");
    $query->bindValue(":un",$un);
    $query->bindValue(":pw",$pw);

    $query->execute();
    if($query->rowCount()== 0){
        array_push($this->errorArray,Constants::$passwordIncorrect);
    }
   }
}

?>