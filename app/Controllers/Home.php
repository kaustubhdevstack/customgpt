<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// This is home controller which controlls everything related to user login and register
// This also controls forgot password and reset password modules and keeps checks on the link expiry limit

namespace App\Controllers; // Assing the namespace

use CodeIgniter\Controller; // Importing controller
use App\Models\TeamModel; // Importing team Model

class Home extends BaseController
{
    public $teamModel; // Defining public variable for team model
    public $session; // Defining public variable for session library
    public $email; // Defining public variable for email library

    public function __construct()
    {
        helper(['form']); // Helper function for form which works with form_helper.php file from helpers folder
        helper(['date']); // Helper function for date

        $this->session = \Config\Services::session(); //Initializing the session library
        $this->email = \Config\Services::email(); // Initializing the prompt model
        $this->teamModel = new TeamModel(); // Initializing the team model
    }

    //Index page template design
    public function index()
    {
        // Session with a session name logged_staff making sure that the user is logged in
        if(session()->has('logged_staff')) 
        {
            return redirect()->to(base_url(). "dashboard"); // If its logged in then its redirecting the user to dashboard, this is so that the logged in user cannot visit the index page
        }
    
        $data = []; // Here we have initialize an empty array called data which will be used to pass the data to the view file
        $data['validation'] = null; // This variable will be used to store validation if there are any by default it is set to null, there are any errors it will be displayed with the help of from_helper.php

        echo view('Templates/header'); // Loading header.php from template folder
        echo view('index', $data); // Loading the index.php file
        echo view('Templates/footer'); // loading the footer.php file from templates folder
    }

    //Function to register very first user
    public function register()
    {
        if(session()->has('logged_staff')) 
        {
            return redirect()->to(base_url(). "dashboard");
        }
    
        $data = [];
        $data['validation'] = null;

        if($this->request->getMethod() == 'post')
        {
            $rules = [

                'fname' => [
                    'rules'    => 'required|regex_match[/^([a-zA-Z ]+)$/]',
                    'errors'   => [
                        'required' => 'Field is empty field is empty',
                        'regex_match' => 'Only captial and small letters are allowed',
                    ]
                ],
                'lname' => [
                    'rules'    => 'required|regex_match[/^([a-zA-Z ]+)$/]',
                    'errors'   => [
                        'required' => 'Field is empty field is empty',
                        'regex_match' => 'Only captial and small letters are allowed',
                    ]
                    ],
                'email_id'     => [
                    'rules'    => 'required|valid_email|is_unique[cgpt_users.email_id]',
                    'errors'   => [
                        'required' => 'Email ID is required',
                        'valid_email' => 'You must enter a valid email',
                        'is_unique' => 'Email ID is already taken',
                    ]
                ],
                'passwd'       => [
                    'rules'    => 'required|min_length[6]|max_length[22]',
                    'errors'   => [
                        'required' => 'Password field is empty',
                        'min_length' => 'Password should be more than 6 characters',
                        'max_length' => 'Password should not be more than 22 characters',
                    ]
                ],
                'cpasswd'  => [
                    'rules'    => 'required|matches[passwd]',
                    'errors'   => [
                        'required' => 'Confirm Password field is empty',
                        'matches' => 'Passwords does not match',
                    ]
                ],
            ];

            //Validation rules for registration 

            if($this->validate($rules)) 
            {

                $identifier =  'e'; // a variable to store random letter (but this letter will be starting letter of all user id)
                $a = str_shuffle('1234567890'); // Generate string with random numbers
                $b = str_shuffle('abcdefghijklmnopqrstuvwxyz'); // generate a string with random letters
                $uid = $identifier . substr($a, 0, 6) . substr($b, 0, 1); // Combining everything to create a random user id with staring letter e and setting its limit

                //Array of data for first user which is admin
                $admin_data = [

                    'fname'     => $this->request->getVar('fname', FILTER_UNSAFE_RAW), // first name
                    'lname'     => $this->request->getVar('lname', FILTER_UNSAFE_RAW),  // last name
                    'email_id'  => $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL), // email id of team member that admin is going to add
                    'passwd'    => password_hash($this->request->getVar('passwd'), PASSWORD_BCRYPT), // Field for password and hashing mechanism for the field
                    'usr_type'  => 'admin', // by default the first aaccount registeration will recieve admin status
                    'ac_status' => 'inactive', // Setting the account status to inactive until email is confirmed by admin
                    'uid'       => $uid, // The random user id generated earlier
                    'date'      => date('Y-m-d H:i:s'), //Registration date
                ];

                $type = [

                    'usr_type' => 'admin',
                ]; 
                // Checking if admin account exist 

                if($this->teamModel->checkAdmin($type))
                {
                    $this->session->setTempdata('error', 'No Registrations Allowed!', 3);
                    return redirect()->to(current_url()); // If admin account exist then no registration is allowed

                } elseif($this->teamModel->createAdmin($admin_data)) {

                    // If the admin account doesn't exist then confirmation email is send to registered email id
                    $to = $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL);
                    $subject = 'Hi Admin, Activate your account - Custom GPT';
                    $message = 'Hi and Welcome, '. $this->request->getVar('name', FILTER_UNSAFE_RAW)."<br><br>Your account has been created"
                    ." successfully. Please click the below link to Activate your account<br><br>"
                    ."<a href='". base_url()."home/activate/".$uid."' target='_blank'>Click here to activate now</a>. This link is set to expire in 15 Minutes.<br><br>Thanks and Regards.<br>Custom GPT";

                    $this->email->setTo($to);
                    $this->email->setFrom('youremail@gmail.com', 'Custom GPT');
                    $this->email->setSubject($subject);
                    $this->email->setMessage($message);

                    if($this->email->send()) 
                    {
                            $this->session->setTempdata('success', 'Please check your email for activation link.', 3);
                            return redirect()->to(base_url()."home/login"); // Shows success message email activation link is send and account created successfully

                    } else {
                            
                            $this->session->setTempdata('error', 'Account created successfully but unable to send the activation link. Contact us.', 3);
                            return redirect()->to(current_url()); // Shows error if account created but confirmation email is not sent
                    }

                } else {

                    $this->session->setTempdata('error', 'Something went wrong please try again!', 3);
                    return redirect()->to(current_url()); // Shows error if nothing happens

                }
                
            } else {

                $data['validation'] = $this->validator; // If the input data is invalid it shows validation errors
            }
        }

        echo view('Templates/header');
        echo view('register', $data); // Loading the register.php file
        echo view('Templates/footer');

    }

    // Function to activate the account based on the provided user id
    public function activate($uid = null) {

        $data = []; // Initialize an empty array to store data
        
        if(!empty($uid)) { // Check if $uid parameter is not empty
    
            $userdata = $this->teamModel->verifyAccount($uid); // Call the verifyAccount method of the teamModel object and pass $uid as a parameter. Store the returned data in $userdata.
    
            if($userdata) { // Check if $userdata is not empty (i.e., an account is found)
    
                if($this->verifyExpiry($userdata->date)) { // Call the verifyExpiry method passing $userdata->date as a parameter to check if the activation link has not expired
    
                    if($userdata->ac_status == 'inactive') { // Check if the account status is 'inactive'
    
                        $status = $this->teamModel->updateStatus($uid); // this line calls the update status query method in team model to change the account status from in active to active.
    
                        if($status == true) { // Check if the status is true (account status updated successfully)
    
                            $data['success'] = "Your account is activated successfully!"; // Shows when account is successfully activated
                        }
    
                    } else {
    
                        $data['success'] = "Your account is activated already!"; // Shown when the account when is already activated and when user clicks the link again
    
                    }
    
                } else {
    
                    $data['error'] = "Sorry, the activation link is expired."; // Shown when the link is expired
    
                }
    
            } else {
    
                $data['error'] = "Sorry unable to find your account"; // Only shown when the uid is wrong
    
            }
    
        } else {
    
            $data['error'] = "Sorry unable to process your request!"; // If the request cannot be completed
    
        }
    
        echo view('Templates/header'); 
        echo view('active_confirm', $data); //Template file where all the success and error notifications will be displayed.
        echo view('Templates/footer'); 
    }

    public function verifyExpiry($expTime)
    {
        $currentTime = now(); // getting present time
        $expTime = strtotime($expTime); //Converting time to string
        $timeDiff = (int)$currentTime - (int)$expTime; //Subtracting the time difference

        if(900 > $timeDiff) {

                return true; // IF the value is 15 minutes then return true

        } else {

                return false; // IF the value is not 15 minutes then return false

        }
    }
    
    //Function of User Login
    public function login()
    {
        if(session()->has('logged_staff'))
        {
            return redirect()->to(base_url(). "dashboard");
        } 
        $data = [];
        $data['validation'] = null;

        if($this->request->getMethod() == 'post')
        {
             
            if ($this->session->get('login_attempts') >= 3) {
                $this->session->setTempdata('error', 'Too many login attempts, please try again later', 3);
                return redirect()->to(current_url()); // Limiting the login attempts to 3 if it reaches that count then returning the error - Too many login attempts
            }

            $rules = [

                'email_id'        => [
                        'rules'    => 'required|valid_email',
                        'errors'   => [
                            'required' => 'Email ID is required',
                            'valid_email' => 'Email ID or Password is wrong',
                            ]
                    ],
                'passwd'        => [
                        'rules'    => 'required|min_length[6]|max_length[22]',
                        'errors'   => [
                            'required' => 'Password field is empty',
                            'min_length' => 'Email ID or Password is wrong',
                            'max_length' => 'Email ID or Password is wrong',
                            ]
                    ],
                ];

                  // Validating the inputs for login

                if($this->validate($rules)) {

                    $email = $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL); // Getting the email
                    $password = $this->request->getVar('passwd', FILTER_UNSAFE_RAW); // Getting the password
                
                    //using the checklogin function from team model we will check for different type of account status for differebt type of users along with email and password and will return response accordingly
                    $slogindata = $this->teamModel->checkLogin($email);
                
                    if($slogindata && password_verify($password, $slogindata['passwd'])) {

                        switch ($slogindata['usr_type']) {
                            case 'admin':
                                switch ($slogindata['ac_status']) {
                                    case 'active':
                                        $this->session->set('logged_staff', $slogindata['uid']);
                                        return redirect()->to(base_url() . 'dashboard');
                
                                    case 'inactive':
                                        $this->session->setTempdata('error', 'Please click on the link in your email to activate your account', 3);
                                        return redirect()->to(current_url());
                
                                    default:
                                        $this->session->setTempdata('error', 'Invalid account status', 3);
                                        return redirect()->to(current_url());
                                }
                                break;
                
                            case 'team':
                                switch ($slogindata['ac_status']) {
                                    case 'active':
                                        $this->session->set('logged_staff', $slogindata['uid']);
                                        return redirect()->to(base_url() . 'dashboard');
                
                                    case 'inactive':
                                        $this->session->setTempdata('error', 'Your account is inactive please ask admin to activate the account ', 3);
                                        return redirect()->to(current_url());
                
                                    case 'blocked':
                                        $this->session->setTempdata('error', 'You have been blocked for policy violation, contact admin to get it unblocked', 3);
                                        return redirect()->to(current_url());
                
                                    case 'deleted':
                                        $this->session->setTempdata('error', 'Your account has been deleted, please contact admin if you want to activate it again', 3);
                                        return redirect()->to(current_url());
                
                                    default:
                                        $this->session->setTempdata('error', 'Invalid account status', 3);
                                        return redirect()->to(current_url());
                                }
                                break;
                
                            default:
                                $this->session->setTempdata('error', 'Invalid user type', 3);
                                return redirect()->to(current_url());
                        }
                
                    } else {

                        $this->session->setTempdata('error', 'Sorry! Email or Password is wrong', 3);
                        $this->session->set('login_attempts', $this->session->get('login_attempts') + 1); // Increasing login attempts to 1
                        return redirect()->to(current_url());
                    }
                
                } else {

                    $data['validation'] = $this->validator; // If the input data is invalid it shows validation errors
            }
        }

        echo view('Templates/header');
        echo view('login', $data); // Loading the Login.php file
        echo view('Templates/footer');

    }

    //Function of forgot password which checks the user existance
    public function forgot_password()
    {
        if(session()->has('logged_staff'))
        {
            return redirect()->to(base_url(). "dashboard");
        } 
        $data = [];
        $data['validation'] = null;

        if($this->request->getMethod() == 'post')
        {
            $rules = [

                'email_id'        => [
                        'rules'    => 'required|valid_email',
                        'errors'   => [
                            'required' => 'Email ID is required',
                            'valid_email' => 'Please enter a valid Email ID',
                    ]
                ],
            ];

            //Validation rules for email

            if($this->validate($rules))
            {
                $email = $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL); // Getting the email 

                //Using check login function we used login we will check if email id exist in the database if it exist then we will be moved to reset password page or else email id doesn't exist email will be shown
                $checkEmail = $this->teamModel->checkLogin($email);

                if(!empty($checkEmail))
                {
                    //If the email id exsist in the database the it will send reset password link to the email which registered for that we use user id to co-relate email with correct user 
                    if($this->teamModel->updatedData($checkEmail['uid']))
                    {
                        $to = $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL);
                        $subject = 'Reset your Password - Custom GPT';
                        $token = $checkEmail['uid']; // Once the cor-relation of user id with email id is done it uses the user id as a token instead of generating token from random character then it sends the reset password link

                        $message = 'Hi '.$this->request->getVar('fname', FILTER_UNSAFE_RAW).",<br><br> Here is the Reset Password Link for your account. "
                                ."Please click the below link to Reset your account's Password.<br><br>"
                                ."<a href='". base_url()."home/reset_password/".$token."' target='_blank'>Click here to reset password now</a>. This link is set to expire in 15 Minutes. <br><br>Thanks and Regards.<br>Custom GPT";

                        $this->email->setTo($to);
                        $this->email->setFrom('youremail@gmail.com', 'Custom GPT');
                        $this->email->setSubject($subject);
                        $this->email->setMessage($message);

                        if($this->email->send())
                        {
                            $this->session->setTempdata('success', 'Reset Password Link sent to your Email ID.', 3);
                            return redirect()->to(base_url()."home/login"); // If the password reset link is send then redirect visitor to login page

                        } else {
                            
                            $this->session->setTempdata('error', 'Sorry! Unable to send link, try again!', 3);
                            return redirect()->to(current_url()); // If the link is not send then it will display this error
                        }
                    } else {

                        $this->session->setTempdata('error', 'Sorry! Unable to update password, try again!', 3);
                        return redirect()->to(current_url()); //If the user id doesn't exist it will display this error
                    }

                } else {

                    $this->session->setTempdata('error', 'Sorry! Email ID does not exist', 3);
                    return redirect()->to(current_url()); // If email id doesn't exist it displays the error
                }

            } else {

                $data['validation'] = $this->validator; // If input data is invalid it will display the error
            }
        }

        echo view('Templates/header');
        echo view('forgot_pass', $data); // Loading the forgot_pass.php file
        echo view('Templates/footer');

    }

    //Function for resetting the password
    public function reset_password($token = null) // Setting the token to null
    {
        if(session()->has('logged_staff'))
        {
            return redirect()->to(base_url(). "dashboard");
        } 
        $data = [];
        $data['validation'] = null;
        $data['token'] = $token;

        if(!empty($token))
        {
            $checkToken = $this->teamModel->checkToken($token); //It will check the token that is generated earlier in forgot_password function

            if(!empty($checkToken)) // If token is available then reset password page is accessible
            {
                if($this->resetLinkExpiry($checkToken['updated_at'])) // It will set the timer to 15 mins for changing the password
                {
                    if($this->request->getMethod() == 'post')
                    {
                        $rules = [

                            'passwd'        => [
                                    'rules'    => 'required|min_length[6]|max_length[22]',
                                    'errors'   => [
                                        'required' => 'Password field is empty',
                                        'min_length' => 'Password should be more than 6 characters',
                                        'max_length' => 'Password should not be more than 22 characters',
                                    ]
                                ],

                            'cpassword'   => [
                                    'rules'    => 'required|matches[passwd]',
                                    'errors'   => [
                                        'required' => 'Confirm Password field is empty',
                                        'matches' => 'Passwords does not match',
                                    ]
                                ],
                            ];

                            //Validation rules for password

                            if($this->validate($rules))
                            {
                                $updatePass = password_hash($this->request->getVar('passwd'), PASSWORD_BCRYPT); //Getting the password and hashing it

                                if($this->teamModel->updatePass($token, $updatePass)) // Updating the password using the token as an identifier
                                {
                                    $this->session->setTempdata('success', 'Password Updated Successfully.', 3);
                                    return redirect()->to(base_url()."home/login"); // Shows success message if password is updated and redirect the visitor to login

                                } else {

                                    $this->session->setTempdata('error', 'Unable to update Password, try again!.', 3);
                                    return redirect()->to(current_url()); // Shows error if unable to update the password and reloads the page
                                }

                            } else {

                                $data['validation'] = $this->validator; // IF input data is invalid shows validation errors
                            }
                    }

                } else {

                    $data['error'] = "Reset Password Link was expired"; // Show this error if password link is expired
                }

            } else {

                $data['error'] = "Unable to find the user account"; // Show this email if the token is not available
            }

        } else {

            $data['error'] = "Sorry! Unauthorized access"; // if the token is expired show this message
        }

        echo view('Templates/header');
        echo view('reset_pass', $data); // Loading the reset_pass.php file
        echo view('Templates/footer');

    }

    //Function to check password reset link expiry and defning varibale in function
    public function resetLinkExpiry($expTime)
    {
        $currentTime = now(); // getting present time
        $expTime = strtotime($expTime); //Converting time to string
        $timeDiff = (int)$currentTime - (int)$expTime; //Subtracting the time difference

        if(900 > $timeDiff) {

                return true; // IF the value is 15 minutes then return true

        } else {

                return false; // IF the value is not 15 minutes then return false

        }
    }
}
