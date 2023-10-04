<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

//  Form helper validation file


//Function to display validation error

//The display_err() function is used to display validation errors for a particular form field. The function takes two parameters: 

//$validation: This parameter is an object of the validation class that contains the validation rules and error messages for the form fields. 

//$field: This parameter is a string that represents the name of the form field for which the validation error needs to be displayed. The function first checks if the $validation object is set or not. If it is set, it checks if the $field has any errors by calling the hasError() method of the $validation object. If there is an error, it returns the error message for the $field by calling the getError() method of the $validation object. If there is no error for the $field, it returns false. 

//The purpose of this function is to simplify the process of displaying validation errors for a form field. It is commonly used in web development to provide user-friendly error messages to users when they submit a form with invalid data.

function display_err($validation, $field){
    if(isset($validation))
    {
        if($validation->hasError($field))
        {
            return $validation->getError($field);
        }
        else
        {
            return false;
        }
    }
}