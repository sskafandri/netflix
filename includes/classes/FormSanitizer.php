<?php

class FormSanitizer{
    public static function sanitizeFormStrnig($inputText){
        $inputText = strip_tags($inputText);  //to remove html tags
        $inputText = str_replace(" ","",$inputText); //to remove space in first name staring or in the end (or)
        //$inputText = trim($inputText); to remove space in between name or any where
        $inputText = strtolower($inputText); //to convert name in lower case
        $inputText = ucfirst($inputText); //to convert first letter into captel letter
        return $inputText;
    } 

    public static function sanitizeFormUsername($inputText){
        $inputText = strip_tags($inputText);  //to remove html tags
        $inputText = str_replace(" ","",$inputText); //to remove space in first name starting or in the end 
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText){
        $inputText = strip_tags($inputText);  //to remove html tags
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText){
        $inputText = strip_tags($inputText);  //to remove html tags
        $inputText = str_replace(" ","",$inputText); //to remove space in first name starting or in the end 
        return $inputText;
    }
}

?>