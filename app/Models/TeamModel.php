<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// This is Team Model which controls the Home and Dashboard Controller
// Everything with user login, forgot password, reset password, user registration, editing profile information, uploading avatar, changing email and password is done with this Model itself
// Even things like feteching the data from the database and displaying it and all the CRUD functionalities is done with the help of this Team Model
// Note: This model doesn't controls the AI tools that is done with Prompt Model which controls the OpenAI controller

namespace App\Models; //Defining the namespace for models

use CodeIgniter\Model; //Importing model from codeigniter

class TeamModel extends Model {

        //Register Admin

        // This function creates a new admin user in the "cgpt_users" table using the provided $admin_data which is an associative array containing the data to be saved.
        // It uses CodeIgniter's query builder to create an insert query and execute it on the database.
        // After executing the query, the function checks if exactly one row was affected.
        // If one row was affected, the function returns true to indicate a successful insert operation.
        // If no rows were affected, the function returns false to indicate a failed insert operation.
        public function createAdmin($admin_data) {

                $builder = $this->db->table('cgpt_users');
                $result = $builder->insert($admin_data);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }

        //Register Team

        // This function creates a new team in the "cgpt_users" table using the provided $staff_data which is an associative array containing the data to be saved.
        // It uses CodeIgniter's query builder to create an insert query and execute it on the database.
        // After executing the query, the function checks if exactly one row was affected.
        // If one row was affected, the function returns true to indicate a successful insert operation.
        // If no rows were affected, the function returns false to indicate a failed insert operation.
        public function createTeam($staff_data) {

                $builder = $this->db->table('cgpt_users');
                $result = $builder->insert($staff_data);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }


        //Check if admin user exist or not
        // This function checks if an admin user of the specified $type exists in the "cgpt_users" table.
        // It uses CodeIgniter's query builder to create a select query with the specified $type as a condition.
        // After executing the query, the function checks if exactly one row was returned.
        // If one row was returned, the function returns the row as an object to indicate that an admin user of the specified type exists.
        // If no rows were returned, the function returns false to indicate that an admin user of the specified type does not exist.
        public function checkAdmin($type) {

                $builder = $this->db->table('cgpt_users');
                $builder->select('usr_type');
                $builder->where('usr_type', $type);

                $result = $builder->get();

                if(count($result->getResultArray()) == 1) {

                        return $result->getRow();

                } else {

                        return false;

                }
        }

        //Function to verify account to activate the registered account

        // This function verifies the account with the specified $uid by checking its activation status.
        // It uses CodeIgniter's query builder to create a select query with the specified $uid as a condition.
        // The query selects the date, uid, uid and ac_status columns from the "cgpt_users" table.
        // After executing the query, the function checks if exactly one row was returned.
        // If one row was returned, the function returns the row as an object to indicate that the account exists and its activation status can be checked.
        // If no rows were returned, the function returns false to indicate that an account with the specified $uid does not exist.
        public function verifyAccount($uid) {

                $builder = $this->db->table('cgpt_users');
                $builder->select('date, uid, ac_status');
                $builder->where('uid', $uid);

                $result = $builder->get();

                if(count($result->getResultArray()) == 1) {

                        return $result->getRow();

                } else {

                        return false;

                }
        }

        //Update status of account from inactive to active
        // This function updates the activation status of the account with the specified $uid from inactive to active.
        // It uses CodeIgniter's query builder to create an update query with the specified $uid as a condition.
        // The query updates the "ac_status" column of the "cgpt_users" table to "active".
        // After executing the query, the function checks if exactly one row was affected.
        // If one row was affected, the function returns true to indicate that the activation status of the account was successfully updated.
        // If no rows were affected, the function returns false to indicate that the activation status of the account could not be updated.
        public function updateStatus($uid) {
        
                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);
                $builder->update(['ac_status' => 'active']);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }
        
        //Update status of user account for blocking/making inactive/active

        // This function updates the activation status of the user account with the specified $id to the specified $user_status.
        // It uses CodeIgniter's query builder to create an update query with the specified $id as a condition.
        // The query updates the "ac_status" column of the "cgpt_users" table to the specified $user_status.
        // After executing the query, the function checks if exactly one row was affected.
        // If one row was affected, the function returns true to indicate that the activation status of the user account was successfully updated.
        // If no rows were affected, the function returns false to indicate that the activation status of the user account could not be updated.
        public function changeStatus($id, $user_status) {
        
                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $id);
                $builder->update(['ac_status' => $user_status]);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }

        //Check user login

        // This function checks if a user with the specified $email exists in the "cgpt_users" table.
        // This function checks if a user with the specified $email exists in the "cgpt_users" table.
        // It uses CodeIgniter's query builder to create a select query that fetches the "uid", "ac_status", "email_id", and "passwd" columns for the user with the specified $email.
        // After executing the query, the function checks if exactly one row was returned.
        // If one row was returned, the function returns an associative array containing the values of the "uid", "ac_status", "email_id", and "passwd" columns for the user.
        // If no rows were returned, the function returns false to indicate that the user does not exist in the "cgpt_users" table.
        public function checkLogin($email) {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('email_id', $email);

                $result = $builder->get();

                if(count($result->getResultArray()) == 1) {

                        return $result->getRowArray();

                } else {

                        return false;

                }
        }

        //Update the data

        // This function checks if a user with the specified $email exists in the "cgpt_users" table.
        // It uses CodeIgniter's query builder to create a select query that fetches the "uid", "ac_status", "email_id", and "passwd" columns for the user with the specified $email.
        // After executing the query, the function checks if exactly one row was returned.
        // If one row was returned, the function returns an associative array containing the values of the "uid", "ac_status", "email_id", and "passwd" columns for the user.
        // If no rows were returned, the function returns false to indicate that the user does not exist in the "cgpt_users" table.
        public function updatedData($uid) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);
                $builder->update(['updated_at'=> date('Y-m-d H:i:s')]);
                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }

        //Check token for password reset

        // This function checks if a given token is valid for resetting the user's password.
        // It queries the "cgpt_users" table to see if there is a user with the given token.
        // If there is exactly one user with the token, it returns an associative array containing the user's ID, first name, and updated_at timestamp.
        // If there are zero or more than one users with the token, it returns false.
        public function checkToken($token) {

                $builder = $this->db->table('cgpt_users');
                $builder->select('uid, fname, updated_at');
                $builder->where('uid', $token);

                $result = $builder->get();
                if(count($result->getResultArray()) == 1) {
                        
                        return $result->getRowArray();

                } else {
                        
                        return false;
                         
                }
        }

        //Update the password 

        // Function to update the password for a user with the given id
        // It updates the password field in the cgpt_users table using the CodeIgniter Query Builder
        // It then checks if the update operation affected exactly one row, and returns true if it did, and false otherwise.
        public function updatePass($id, $password) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $id);
                $builder->update(['passwd'=> $password]);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }

        //Function to archive the user so that admin can restore the account

        // Function to archive the user so that admin can restore the account
        // Takes a parameter named "$id" which is the ID of the user to be archived
        // Updates the "ac_status" and "on_status" fields of the user with the given ID in the "cgpt_users" table to "deleted" and 1 respectively
        // Checks if the update operation affected exactly one row, and returns true if it did, and false otherwise.
        public function delete_user($id) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $id);
                $builder->update(['ac_status' => 'deleted', 'on_status' => 1]);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
                
        }

        //Function to restore the archived user account

        //Restore a user account that has been previously deleted by setting the 'ac_status' to 'active' and 'on_status' to 0
        //int $id The ID of the user to restore
        //bool True if the account was successfully restored, false otherwise

        public function restore_user($id) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $id);
                $builder->update(['ac_status' => 'active', 'on_status' => 0]);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }

        }

        //Function to delete the user forever

        //This is a function for deleting user forever from a database table.
        //The function takes one parameter, which is the ID of the user whose history records will be deleted.
        //The database table being used is named 'cgpt_users'.
        //The function applies a filter to the 'uid' column of the table to only delete records for the specified user ID.

        public function deleteUser($id) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $id);
                $builder->delete();
        }

        //Get all logged in user data

        //Function retrieves user data from the "cgpt_users" table based on the provided user ID.
        //The function accepts one parameter, the user ID, which is used to filter the result set.
        //If a single row is returned from the query, it is returned as an object.
        //If no rows are returned, the function returns false.
        //This function assumes that the "uid" column in the "cgpt_users" table is unique, as it does not handle the case where multiple rows are returned for a single user ID.

        public function getUserData($uid) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);

                $result = $builder->get();
                if(count($result->getResultArray()) == 1) {

                        return $result->getRow();

                } else {

                        return false;
                        
                }
        }

        //Get user profile image

        //This function gets the profile picture data of a user by their uid.
        //The function accepts one parameter, the user ID, which is used to filter the result set.
        //If a single row is returned from the query, it is returned as an object.
        //If no rows are returned, the function returns false.
        //This function assumes that the "uid" column in the "cgpt_users" table is unique, as it does not handle the case where multiple rows are returned for a single user ID.

        public function getProfilePic($uid) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);

                $result = $builder->get();
                if(count($result->getResultArray()) == 1) {

                        return $result->getRow();

                } else {

                        return false;
                        
                }
        }

        //Update user profile information (User designation in this case)

        // Function updates user information in the "cgpt_users" table based on the provided user ID.
        // The function accepts two parameters: the user ID and an array of updated user data.
        // The "user_desg" column in the "cgpt_users" table is updated with the value provided in the $user_data array.
        // If the update is successful, the function returns true.
        // If no rows are affected by the update, the function returns false.
        public function update_information($uid, $user_data) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);
                $builder->update(['user_desg' => $user_data]);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }

        //Update user email id

        // Function updates the email of a user in the "cgpt_users" table based on the provided user ID.
        // The function accepts two parameters: the user ID and an array of email data to be updated.
        // The "email_data" array should contain key-value pairs, where the key is the name of the column to be updated and the value is the new value to be set.
        // If the update is successful and one row is affected, the function returns true.
        // If the update fails or zero rows are affected, the function returns false.

        public function updateUserEmail($uid, $email_data) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);
                $builder->update($email_data);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }

        //Verify the user id for activating the updated email

        // Function to retrieve email confirmation status, user ID, and email status from the "cgpt_users" table based on the provided user ID.
        // The function accepts one parameter, the user ID, which is used to filter the result set.
        // If a single row is returned from the query, it is returned as an object.
        // If no rows are returned, the function returns false.
        // This function assumes that the "uid" column in the "cgpt_users" table is unique, as it does not handle the case where multiple rows are returned for a single user ID.

        public function verifyuserId($uid) {

                $builder = $this->db->table('cgpt_users');
                $builder->select('email_confirm, uid, em_status');
                $builder->where('uid', $uid);

                $result = $builder->get();

                if(count($result->getResultArray()) == 1) {

                        return $result->getRow();

                } else {

                        return false;

                }
        }

        //Function to update the email status from unverified to verified as well as update inactive status to active

        // Function updates the email and account status of a user in the "cgpt_users" table
        // The function accepts one parameter, the user ID
        // The function updates the "em_status" column to "verified" and the "ac_status" column to "active"
        // If the update is successful and only one row is affected, the function returns true.
        // If the update is not successful or more than one row is affected, the function returns false.

        public function updateUserStatus($uid) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);
                $builder->update(['em_status' => 'verified', 'ac_status' => 'active']);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

                }
        }

        //Function to change the user's password from inside
        public function updateNewPass($uid, $updatePass) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);
                $builder->update(['passwd'=> $updatePass]);

                if($this->db->affectedRows() > 0) {

                        return true;

                } else {

                        return false;

                }
        }

        //Upload user profile picture

        // Function updates the avatar of a user in the "cgpt_users" table based on the provided user ID.
        // The function accepts two parameters: the user ID and the new avatar image path.
        // The function updates the "user_pic" column of the user with the provided ID with the new avatar image path.
        // If the update operation is successful (i.e., if one or more rows are affected), the function returns true.
        // If the update operation fails (i.e., if no rows are affected), the function returns false.

        public function uploadAvatar($uid, $path) {

                $builder = $this->db->table('cgpt_users');
                $builder->where('uid', $uid);
                $result = $builder->update(['user_pic' => $path]);
                
                if($this->db->affectedRows() > 0) {

                        return true;

                } else {

                        return false;
                }
        }

        //Get the type of user to restrict access

        // Function retrieves user data from the "cgpt_users" table based on the provided user ID.
        // The function accepts one parameter, the user ID, which is used to filter the result set.
        // If a single row is returned from the query, it is returned as an associative array.
        // If no rows are returned, the function returns false.
        // This function assumes that the "uid" column in the "cgpt_users" table is unique, as it does not handle the case where multiple rows are returned for a single user ID.

        public function getUserType($uid) {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('uid', $uid);

                $result = $builder->get();

                if(count($result->getResultArray()) == 1) {

                        return $result->getRowArray();

                } else {

                        return false;

                }

        }

        //Function to get admin details

        // Function retrieves details of all users with "admin" user type from the "cgpt_users" table.
        // No parameter is accepted by this function.
        // If one or more rows are returned from the query, they are returned as an array of objects.
        // If no rows are returned, an empty array is returned.
        // Note that this function assumes that there may be multiple users with the "admin" user type, so it returns an array instead of a single object.

        public function getAdminDetails() {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('usr_type', 'admin');
                $result = $builder->get();
                return $result->getResult();
        }

        //Function which fetches all the user data for admin account

        // This function retrieves all users who have the "team" user type and their "on_status" column is set to 0 from the "cgpt_users" table.
        // The function does not accept any parameter.
        // If one or more rows are returned from the query, they are returned as an array of objects.
        // If no rows are returned, the function returns an empty array.
        // Note that the "on_status" column presumably indicates whether the user is currently online or not.
        public function getAllTeam() {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('usr_type', 'team');
                $builder->where('on_status', '0');
                $result = $builder->get();
                return $result->getResult();
        }

        //Function which fetches all the archived user data for admin account

        
        // This function retrieves all the archived team members from the "cgpt_users" table.
        // It returns an array of objects, each representing a single archived team member.
        // The function assumes that a team member is considered archived if their "ac_status" column is set to "deleted" and their "on_status" column is set to "1".

        public function getArchiveTeam() {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('ac_status', 'deleted');
                $builder->where('on_status', '1');
                $result = $builder->get();
                return $result->getResult();
        }

        
        //Get inactive user count

        // Function retrieves the count of inactive users from the "cgpt_users" table.
        // The function does not accept any parameter and retrieves the count of inactive users by performing a like search on the "ac_status" column for the keyword "inactive".
        // The function returns the count of inactive users as an integer.

        public function getInactiveUsers() {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('ac_status', 'inactive');

                return $builder->countAllResults();

        }

        //Get active user count

        // This function retrieves the count of all active users from the "cgpt_users" table.
        // It uses CodeIgniter's query builder to select all columns and filter the result set where the "ac_status" column is like "active".
        // The function then returns the count of all rows in the result set using CodeIgniter's "countAllResults()" method.

        public function getActiveUsers() {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('ac_status', 'active');
            
                return $builder->countAllResults();

        }

        //Get blocked user count

        // This function retrieves the count of all blocked users from the "cgpt_users" table.
        // It uses CodeIgniter's query builder to select all columns and filter the result set where the "ac_status" column is like "blocked".
        // The function then returns the count of all rows in the result set using CodeIgniter's "countAllResults()" method.
        
        public function getBlockedUsers() {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('ac_status', 'blocked');

                return $builder->countAllResults();

        }

        //Get archived user count

        // This function retrieves the count of all archived users from the "cgpt_users" table.
        // It uses CodeIgniter's query builder to select all columns and filter the result set where the "ac_status" column is like "deleted".
        // The function then returns the count of all rows in the result set using CodeIgniter's "countAllResults()" method.

        public function getArchivedUsers() {

                $builder = $this->db->table('cgpt_users');
                $builder->select('*');
                $builder->where('ac_status', 'deleted');

                return $builder->countAllResults();

        }

}