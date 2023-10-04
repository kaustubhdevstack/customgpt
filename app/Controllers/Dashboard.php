<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// This is a dashboard controller which controls everything related to user
// It has Profile Management/Staff Management/Appllication settings like email id and password reset

namespace App\Controllers; // Assing the namespace
use CodeIgniter\Controller; // Importing controller
use App\Models\TeamModel; // Importing team Model

class Dashboard extends BaseController
{
        public $teamModel; // Defining public variable for team model
        public $session; // Defining public variable for session library

        public function __construct()
        {
            helper(['form']); // Helper function for form which works with form_helper.php file from helpers folder
            helper(['date']); // Helper function for date
            helper(['text']); //Helper function for text
    
            $this->session = \Config\Services::session();  //Initializing the session library
            $this->email = \Config\Services::email();  //Initializing the email library
            $this->teamModel = new TeamModel(); // Initializing the team model
        }

        //This is the dashboard page
        public function index()
        {
                 // Session with a session name logged_staff making sure that the user is logged in
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login"); // If its not logged in then its redirecting the visitor to login page, this is so that the visitor from outside cannot directly access the page
                } 
                $data = []; // Here we have initialize an empty array called data which will be used to pass the data to the view file
                $uid = session()->get('logged_staff'); // This will store logged in user's information in $Uid variable

                $data['teamdata'] = $this->teamModel->getUserData($uid); // The teamdata variable whch stores the data feteched by getUserData query function from the TeamModel and then it is displayed according to the user id stored in $uid variable.
                $data['profilepic'] = $this->teamModel->getProfilePic($uid); // The profilepic variable stores the profile picture data from getProfilePic query function from TeamModel and it is then displayed according to the user id stored in $uid variable.

                echo view('Templates/header'); // Loading header.php from template folder
                echo view('Templates/navigation', $data); // Loading navigation.php from template folder and passsing the data
                echo view('Templates/sidebar', $data); // Loading sidebar.php from template folder and passsing the data
                echo view('dashboard', $data); // Loading the dashboard.php template file and passing the data
                echo view('Templates/copyright'); // Loading the copyright.php footer file from templates folder
                echo view('Templates/footer'); // loading the footer.php file from templates folder
        }

        //This is basically the user profile
        public function profile()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');
                $data['validation'] = null;

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('profile', $data); // Loading the profile.php template file and passing the data
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Function to edit user profile information, once the team member or admin memember click on edit profile he/she will be redirected to layout with 2 tabs. First for adding the user's designation - CEO, Manager or Digtal Marketer etc and the other tab will be for uploading the avatar or profile picture.
        public function edit_profile()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');
                $data['validation'] = null; // This variable will be used to store validation if there are any by default it is set to null, there are any errors it will be displayed with the help of from_helper.php

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'user_desg' => [
                                        'rules'    => 'required|regex_match[/^([a-zA-Z ]+)$/]',
                                        'errors'   => [
                                            'required' => 'Field is empty field is empty',
                                            'regex_match' => 'Only captial and small letters are allowed',
                                        ]
                                    ],

                                // This is validation for user designation text input, here We have used regex because we're not submitting the data to the AI, We have not use regex only for AI tool because the open ai automatically eliminates the harmfullness of the character and converts it into plain text.

                                // Although we have used filter unsafe raw for tools just to filter out any harmul elements just in case other than that no regex validation is used.
                        ];

                        if($this->validate($rules))
                        {
                                $user_data = [

                                        'user_desg' => $this->request->getVar('user_desg', FILTER_UNSAFE_RAW), //Getting the user designation from the input and storing it
                                ];

                                if($this->teamModel->update_information($uid, $user_data)) // Calling the update information function from team model to add desgnation to user. Why update and not insert? because majority of the data is taken when admin is registered or when admin tries to add team/staff member so we use update instead of insert here also the information is updated according to user id hence the uid varibale is first and user data is second.
                                {
                                        $this->session->setTempdata('success', 'User designation updated.', 3);
                                        return redirect()->to(base_url()."dashboard/profile"); // Shows success message and redirects user to the profile page

                                } else {

                                        $this->session->setTempdata('error', 'Something went wrong, please try again!.', 3);
                                        return redirect()->to(current_url()); // Shows error and reloads the page
                                }

                        } else {

                                $data['validation'] = $this->validator; // If the input data is invalid then it shows the errors
                        }
                }

                echo view('Templates/header'); 
                echo view('Templates/navigation', $data); 
                echo view('Templates/sidebar', $data); 
                echo view('edit_profile', $data); // Loading the edit_profile.php template file
                echo view('Templates/copyright');
                echo view('Templates/footer'); 
        }

        //Function to add profile picture from the second tab on edit_profile.php page
        public function upload_avatar() 
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');
                $data['validation'] = null;

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'user_pic' => [

                                        'rules'    => 'uploaded[user_pic]|max_size[user_pic,1024]|ext_in[user_pic,png,jpg,jpeg]',
                                        'errors'   => [
                                                'max_size' => 'Size limit exeeded',
                                                'uploaded' => 'File uploaded is not valid',
                                                'ext_in'   => 'Only PNG JPG and JEPG File formats allowed',
                                        ]
                                ],

                                //Validation rules for the image
                        ];

                        if($this->validate($rules))
                        {
                                $file = $this->request->getFile('user_pic'); // Gets the image from the input
        
                                if($file->isValid() && !$file->hasMoved()) // This line checks if the file uploaded is valid or not and has not moved this is to stop user from uploading wrong file
                                {
                                        if($file->move(FCPATH.'public\users\profile', $file->getRandomName())) // This line of code assigns random name to the file while storing in the folder
                                        {
                                                $path = base_url().'public/users/profile/'.$file->getName(); //The file path/url along with name is fetched and stored in the variable path
                                                $status = $this->teamModel->uploadAvatar($uid, $path); //Calls the upload avatar function from the team model and uses insert query to upload the profile picture according to user id

                                                if($status == true)
                                                {
                                                        $this->session->setTempdata('success','Avatar is uploaded successfully',3);
                                                        return redirect()->to(base_url()."dashboard/profile"); // Displays the success notice and redirects user to profile

                                                } else {

                                                        $this->session->setTempdata('error','Sorry! Unable to upload Avatar',3);
                                                        return redirect()->to(current_url()); // Displays error and redirects user to current page
                                                }

                                        } else {

                                                $this->session->setTempdata('error',$file->getErrorString(),3);
                                                return redirect()->to(current_url()); // If the file is stored but unable to fetch then it will display error and reload the page
                                        }

                                } else {

                                        $this->session->setTempdata('error','You have uploaded invalid file',3);
                                        return redirect()->to(current_url()); //If the file uploaded is invalid then the error will be displayed and the page will reload
                                }

                        } else {

                                $data['validation'] = $this->validator; //This will display input validation error if input data is invalid

                        }
                }

                return redirect()->back(); //Since the upload avatar is the second function for the same edit_profile.php file we will not load the view file again as this gives error instead after updating avatar or uploading avatar is successfull then we will redirect user back to the same page. Which gives the same effect as page reload. If we used redirect()->(current_url()); then the page will give you too many redirects error
        }

        //Function to update the user email within dashboard
        public function update_email()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'email_id' => [
                                        'rules'    => 'required|valid_email|is_unique[cgpt_users.email_id]',
                                        'errors'   => [
                                                'required' => 'Email ID is required',
                                                'valid_email' => 'You must enter a valid email',
                                                'is_unique' => 'Email ID is already taken',
                                        ]
                                ]

                                // Validation rules for the email id
                        ];

                        if($this->validate($rules))
                        {
                                $email_data = [

                                        'ac_status'      => 'inactive', // Setting the account status to inactive because user will need to confirm the email
                                        'em_status'      => 'unverified', // Setting the newly updated status to unverified as user will have to verify email
                                        'email_id'       => $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL), // Getting the email id from input and validating it

                                        'email_confirm'  =>  date('Y-m-d H:i:s'), //Date format stored
                                ];

                                if($this->teamModel->updateUserEmail($uid, $email_data)) //Updating the email with update user email function from team model according to the user account id
                                {
                                        //Sending the the confirmation email to new user id
                                        $to = $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL);
                                        $subject = 'Confirm your new Email ID - Custom GPT';
                                        $message = "Hello,<br><br>Your Email ID is changed "
                                                ."successfully. Please click the below link to Confirm your new Email ID<br><br>"
                                                ."<a href='". base_url()."dashboard/activate_email/".$uid."' target='_blank'>Click here to confirm now</a>. This link is set to expire in 15 Minutes.<br><br>Thanks and Regards.<br>Custom GPT";

                                        $this->email->setTo($to);
                                        $this->email->setFrom('no-reply@krytechwebsecurity.com', 'Custom GPT');
                                        $this->email->setSubject($subject);
                                        $this->email->setMessage($message);

                                        if($this->email->send())
                                        {
                                                $this->session->setTempdata('success', 'Email ID changed successfully and Confirmation link send to your Email ID.', 3); // Displays success error and redirects user to profile
                                                return redirect()->to(base_url()."dashboard/profile");

                                        } else {

                                                $this->session->setTempdata('error', 'Email ID changed successfully. Sorry! unable to send confirmation link. Contact us.', 3); // Displays error and redirects user to current page
                                                return redirect()->to(current_url());
                                        }

                                } else {

                                        $this->session->setTempdata('error', 'Sorry! Your Email ID could not be changed', 3);
                                        return redirect()->to(current_url()); // Displays error and redirects user to current page

                                }

                        } else {

                                $data['validation'] = $this->validator; // If the input data is invalid it shows validation error

                        }
                }

                return redirect()->back(); //Since update email is part of profile page and its the function loaded in same view so here we will not not load the view file once again instead we will redirect back user to profile page
        }

        //This is a function to activate email
        public function activate_email($uid = null) //Setting the user id to null
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');
                
                if(!empty($uid)) // Checking if user id is empty, if its not empty then moving to step 2
                {
                        $emailConfirm = $this->teamModel->verifyuserId($uid); //This verify user id function from team model will confirm user id and user email along with the email status
                        if($emailConfirm) // If the data is confirmed then it will go to next step
                        {
                                if($this->verifyEmailExpiry($emailConfirm->email_confirm))  // It will fetch the date and time and will set the expiry limit of 15 min using email expiry function
                                {
                                        if($emailConfirm->em_status == 'unverified') //It will check if the email status is unverified
                                        {
                                                $emstatus = $this->teamModel->updateUserStatus($uid); // If the status is unverified then it will update the user status to verified according to user account id
                                                if($emstatus == true)
                                                {
                                                        $data['success'] = "Your Email ID is confirmed successfully! <a href='". base_url()."dashboard/profile'>Click here go back to profile</a>"; // This will show success message after confirmation
                                                }
                                        }

                                } else {

                                        $data['success'] = "Your account is confirmed already!"; // If the user clicks on the confirmation link in email after successfull confirmation then it will show them this message
                                }

                        } else {

                                $data['error'] = "Sorry unable to find your account"; // Showing error after email link is expired
                        }

                } else {

                        $data['error'] = "Sorry unable to process your request!"; // Showing error if something went wrong
                }

                echo view('Templates/header');
                echo view('active_confirm', $data); //Loading the confirmation template active_confirm.php and passing the data
                echo view('Templates/footer');
        }

        //Verify the expiry time limit of update email function and defning varibale in function
        public function verifyEmailExpiry($email_time) {
                
                $presentTime = now(); // getting present time
                $email_time = strtotime($email_time); //Converting time to string
                $timeDiff = (int)$presentTime - (int)$email_time; //Subtracting the time difference

                if($timeDiff < (15 * 60)) {

                        return true; // IF the value is 15 minutes then return true

                } else {

                        return false; // IF the value is not 15 minutes then return false

                }
        }

        //Function to update user password within dashboard
        public function update_password()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');
                $data['validation'] = null;

                $data['teamdata'] = $this->teamModel->getUserData($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'oldpasswd'          => [
                                        'rules'    => 'required|min_length[6]|max_length[22]',
                                        'errors'   => [
                                                'required' => 'Password field is empty',
                                                'min_length' => 'Password should be more than 6 characters',
                                                'max_length' => 'Password should not be more than 22 characters',
                                        ]
                                ],
                                'passwd' => [
                                        'rules'    => 'required|min_length[6]|max_length[22]',
                                        'errors'   => [
                                                'required' => 'Password field is empty',
                                                'min_length' => 'Password should be more than 6 characters',
                                                'max_length' => 'Password should not be more than 22 characters',
                                        ]
                                ],

                                'cpassword' => [
                                        'rules'    => 'required|matches[passwd]',
                                        'errors'   => [
                                                'required' => 'Confirm Password field is empty',
                                                'matches' => 'Passwords does not match',
                                        ]
                                ],

                                // Validating password inputs

                        ];

                        if($this->validate($rules))
                        {
                                $old_pass = $this->request->getVar('oldpasswd'); // getting the old password and storing it in variable
                                $updatePass = password_hash($this->request->getVar('passwd'), PASSWORD_BCRYPT); // Getting the new password and encrypting it

                                if(password_verify($old_pass, $data['teamdata']->passwd)) // Needs to enter the old password to update new paassword here because we are making the mechanism to change user password from the dashboard, so assumming that the user is logged in and he/she is trying change password then they first need to verify that they know the old password only then the new password will be updated
                                {
                                        if($this->teamModel->updateNewPass($uid, $updatePass)) // So if old password is verified then update new password funtion from Team Model will be called and the new password will be updated according to the user id
                                        {
                                                $this->session->setTempdata('success', 'Your New Password is updated successfully', 3);
                                                return redirect()->to(base_url()."dashboard/profile"); //Shows success message 

                                        } else {

                                                $this->session->setTempdata('error', 'Could not update the Password', 3);
                                                return redirect()->to(base_url()."dashboard/profile"); //Shows error message
                                        }

                                } else {

                                        $this->session->setTempdata('error', 'Your old password does not match!', 3);
                                        return redirect()->to(current_url()); //If the old password is not verified shows error message

                                }

                        } else {

                                $data['validation'] = $this->validator; //If the input data is invalid it will show validation error
                        }
                }

                return redirect()->back(); //Since update password is part of profile page and its the function loaded in same view so here we will not not load the view file once again instead we will redirect back user to profile page
        }

        //List of users admin has added and it will also display admin data
        public function team()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                $data['admindetails'] = $this->teamModel->getAdminDetails(); // Get admin's all data to display it on page
                $data['allteam'] = $this->teamModel->getAllTeam(); // Get all user data

                $data['archived'] = $this->teamModel->getArchivedUsers(); //Get archived user count
                $data['active'] = $this->teamModel->getActiveUsers(); // Get active user count
                $data['inactive'] = $this->teamModel->getInactiveUsers(); //Get inactive user count
                $data['blocked'] = $this->teamModel->getBlockedUsers(); // Get blocked user count

                $user_type = $this->teamModel->getUserType($uid); // get user type function is called from team model to fetch the user type according to logged in user's id

                if($user_type['usr_type'] == 'team'){

                        return redirect()->back(); //If user type is team meaning if its the staff member added by user then it will redirect the user back to the page where he/she was because team/staff members which admin will add won't have access to user management module
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('team', $data); // Loading the team.php template file and passing the data
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //List of users admin has archived
        public function team_archive()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);
                $data['allteam'] = $this->teamModel->getAllTeam();
                $data['archiveteam'] = $this->teamModel->getArchiveTeam(); // Get the archived users data

                $data['archived'] = $this->teamModel->getArchivedUsers();
                $data['active'] = $this->teamModel->getActiveUsers();
                $data['inactive'] = $this->teamModel->getInactiveUsers();
                $data['blocked'] = $this->teamModel->getBlockedUsers();

                $user_type = $this->teamModel->getUserType($uid); // get user type function is called from team model to fetch the user type according to logged in user's id

                if($user_type['usr_type'] == 'team'){

                        return redirect()->back(); //If user type is team meaning if its the staff member added by user then it will redirect the user back to the page where he/she was because team/staff members which admin will add won't have access to user management module
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('team_archive', $data); // Loading the team_archive.php template file and passing the data
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Function to add new users
        public function add_user()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');
                $data['validation'] = null;

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);
                $data['allteam'] = $this->teamModel->getAllTeam();

                $user_type = $this->teamModel->getUserType($uid); // get user type function is called from team model to fetch the user type according to logged in user's id

                if($user_type['usr_type'] == 'team'){

                        return redirect()->back(); //If user type is team meaning if its the staff member added by user then it will redirect the user back to the page where he/she was because team/staff members which admin will add won't have access to user management module
                }

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'fname'        => [
                                        'rules'    => 'required|regex_match[/^([a-zA-Z ]+)$/]',
                                        'errors'   => [
                                                'required' => 'First name field is empty',
                                                'regex_match' => 'First name is invalid',
                                        ]
                                ],
                                'lname'        => [
                                        'rules'    => 'required|regex_match[/^([a-zA-Z ]+)$/]',
                                        'errors'   => [
                                                'required' => 'Last name field is empty',
                                                'regex_match' => 'Last name is invalid',
                                        ]
                                ],
                                'email_id'        => [
                                        'rules'    => 'required|valid_email|is_unique[cgpt_users.email_id]',
                                        'errors'   => [
                                                'required' => 'Email ID is required',
                                                'valid_email' => 'You must enter a valid email',
                                                'is_unique' => 'Email ID is already taken',
                                        ]
                                ],
                                'passwd'        => [
                                        'rules'    => 'required|min_length[6]|max_length[32]',
                                        'errors'   => [
                                                'required' => 'Password field is empty',
                                                'min_length' => 'Password should be more than 6 characters',
                                                'max_length' => 'Password should not be more than 32 characters',
                                        ]
                                ],

                                // Validation for adding user's input
                        ];

                        if($this->validate($rules)) 
                        {
                                $identifier =  'e'; // a variable to store random letter (but this letter will be starting letter of all user id)
                                $a = str_shuffle('1234567890'); // Generate string with random numbers
                                $b = str_shuffle('abcdefghijklmnopqrstuvwxyz'); // generate a string with random letters
                                $uid = $identifier . substr($a, 0, 6) . substr($b, 0, 1); // Combining everything to create a random user id with staring letter e and setting its limit

                                //Array of data for team members the users which admin add will become team members
                                $staff_data = [

                                        'fname'     => $this->request->getVar('fname', FILTER_UNSAFE_RAW), // first name
                                        'lname'     => $this->request->getVar('lname', FILTER_UNSAFE_RAW), // last name
                                        'email_id'  => $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL), // email id of team member that admin is going to add
                                        'passwd'    => password_hash($this->request->getVar('passwd'), PASSWORD_BCRYPT), // Field for password and hashing mechanism for the field
                                        'usr_type'  => 'team', // by default every user admin will add from the dashboard will have a user type of team. Because the users which admin add will become team members
                                        'ac_status' => 'inactive', // Setting the account status to inactive until the user gets an email and he/she confirms to admin and tell admin to activate the account
                                        'uid'       => $uid, // The random user id generated earlier
                                        'date'      => date('Y-m-d H:i:s'), // Date time
                                        'on_status' => '0', // Set account status to 0 it will become 1 if the user is archived
                                    ];

                                    if($this->teamModel->createTeam($staff_data))
                                    {
                                        // Send notification email to user that his account is ready
                                        $to = $this->request->getVar('email_id', FILTER_VALIDATE_EMAIL);
                                        $subject = 'Hi, Activate your account - Custom GPT';
                                        $message = 'Hi and Welcome, '. $this->request->getVar('name', FILTER_UNSAFE_RAW).",<br><br>Your account has been created"
                                        ." successfully. Please tell the admin to activate the account and hand over the credentials to you.<br><br>Thanks and Regards.<br>Custom GPT";

                                        $this->email->setTo($to);
                                        $this->email->setFrom('no-reply@krytechwebsecurity.com', 'Custom GPT');
                                        $this->email->setSubject($subject);
                                        $this->email->setMessage($message);

                                        if($this->email->send()) 
                                        {
                                                $this->session->setTempdata('success', 'Team Member Added.', 3);
                                                return redirect()->to(base_url()."dashboard/team"); // Displays success message and redirects admin to team page

                                        } else {
                                                
                                                $this->session->setTempdata('error', 'Account created successfully. Sorry! unable to Email.', 3);
                                                return redirect()->to(current_url()); // Displays error and reloads the page
                                        }

                                    } else {

                                        $this->session->setTempdata('error', 'Sorry! Unable to create an account, Try again', 3);
                                        return redirect()->to(current_url()); // Displays error and reloads the page

                                    }

                        } else {
                        
                                $data['validation'] = $this->validator; // Shows validation error if input data is invalid
        
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('add_user', $data); // Loading the add_user.php template file and passing the data
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Function to edit user account status to make user active/inactive or to block the user
        public function edit_user($id = null)
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');
                $data['validation'] = null;

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);
                $data['allteam'] = $this->teamModel->getAllTeam($id);

                $user_type = $this->teamModel->getUserType($uid); // get user type function is called from team model to fetch the user type according to logged in user's id

                if($user_type['usr_type'] == 'team'){

                        return redirect()->back(); //If user type is team meaning if its the staff member added by user then it will redirect the user back to the page where he/she was because team/staff members which admin will add won't have access to user management module
                }

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'ac_status'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                                'required' => 'Please select the account status',
                                        ]
                                ],

                                //Validation rules for the account status
                        ];

                        if($this->validate($rules)) 
                        {
                                $user_status = $this->request->getVar('ac_status'); // Getting the account status from input

                                if($this->teamModel->changeStatus($id, $user_status)) // Updating the account status for user using change status function from team model and updating it according to user id
                                {
                                        $this->session->setTempdata('success', 'User status updated successfully!', 3);
                                        return redirect()->to(base_url()."dashboard/team"); //Shows success messages and redirect admin to the team page

                                } else {

                                        $this->session->setTempdata('error', 'Sorry! Unable to update user status, Try again', 3);
                                        return redirect()->to(current_url()); //Shows error and reloads the page
                                }

                        } else {

                                $data['validation'] = $this->validator; // Shows validation error if the input data is invalid
                        }
                }
                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('edit_user', $data); // Loading the edit_user.php template file and passing the data
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Function to remove user and send the account to archived status
        public function delete_user($id = null)
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');

                $user_type = $this->teamModel->getUserType($uid); // get user type function is called from team model to fetch the user type according to logged in user's id

                if($user_type['usr_type'] == 'team'){

                        return redirect()->back(); //If user type is team meaning if its the staff member added by user then it will redirect the user back to the page where he/she was because team/staff members which admin will add won't have access to user management module
                }

                $status = $this->teamModel->delete_user($id); // this will run delete user query from team model to turn user status to archive and it will turn the on_status for user account from 0 to 1 meaning that user has been deleted but is in archive status and he/she cannot login to the account if the account is not restored

                if($status == true) {
           
                        $this->session->setTempdata('success', 'User account successfully archived', 3);
                        return redirect()->to(base_url()."dashboard/team_archive"); // Displays success if the user is archived and redirects user to team_archive page

                } else {

                        $this->session->setTempdata('error', 'Something went wrong could not archive the user', 3);
                        return redirect()->to(base_url()."dashboard/team"); // Displays error if user is not archived and reloads the page
                        
                }
                header('location:' . base_url() . "dashboard/team_archive"); //If nothing happpens the page will just reload
        }

        //Functon to restore user account from archive status to active
        public function restore_user($id = null)
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');

                $user_type = $this->teamModel->getUserType($uid); // get user type function is called from team model to fetch the user type according to logged in user's id

                if($user_type['usr_type'] == 'team'){

                        return redirect()->back(); //If user type is team meaning if its the staff member added by user then it will redirect the user back to the page where he/she was because team/staff members which admin will add won't have access to user management module
                }

                $status = $this->teamModel->restore_user($id); // this will run restore user query from team model to turn user status to active and it will turn the on_status for user account from 1 to 0 meaning that user has been restored successfilly

                if($status == true) {

                        $this->session->setTempdata('success', 'User account successfully restored', 3);
                        return redirect()->to(base_url()."dashboard/team"); // Displays success if the user is restored and redirects user to team page

                } else {

                        $this->session->setTempdata('error', 'Something went wrong could not restore the user', 3);
                        return redirect()->to(base_url()."dashboard/team_archive"); // Displays error if user is not restored and reloads the page

                }
                header('location:' . base_url() . "dashboard/team"); //If nothing happpens the page will just reload
        }

        //Function to remove the user account from the archive completely without any recovery
        public function erase_user($id = null)
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $uid = session()->get('logged_staff');

                $user_type = $this->teamModel->getUserType($uid); // get user type function is called from team model to fetch the user type according to logged in user's id

                if($user_type['usr_type'] == 'team'){

                        return redirect()->back(); //If user type is team meaning if its the staff member added by user then it will redirect the user back to the page where he/she was because team/staff members which admin will add won't have access to user management module
                }

                $status = $this->teamModel->deleteUser($id); // this will run delete user query from team model but this query will delete user without recovery

                if($status == true) {

                        $this->session->setTempdata('error', 'Something went wrong could not delete the user', 3);
                        return redirect()->to(base_url()."dashboard/team"); // Displays error if user is not restored and redirects admin to team page

                } else {

                        $this->session->setTempdata('success', 'User account successfully deleted', 3);
                        return redirect()->to(base_url()."dashboard/team_archive"); // Displays success if the user is restored and reloads the page

                }
                header('location:' . base_url() . "dashboard/team_archive"); //If nothing happpens the page will just reload
        }

        //Function to logout
        public function logout()
        {
                session()->remove('logged_staff');
                session()->destroy();
                return redirect()->to(base_url()."home/login");

        }
}