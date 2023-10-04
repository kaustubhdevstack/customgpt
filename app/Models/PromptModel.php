<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// This is Prompt Model which controls all the open ai tools in this Custom GPT Tool

namespace App\Models; //Defining the namespace for models

use CodeIgniter\Model; //Importing Model from codeigniter

class PromptModel extends Model {

       //Function to save history for all ai tools

       //It takes a parameter named "$cgpt_data" which is an associative array containing the data to be saved.
       //The function inserts the data into a table named "cgpt_history" using the CodeIgniter Query Builder.
       //It then checks if the insert operation affected exactly one row, and returns true if it did, and false otherwise.
       public function saveHistory($cgpt_data) {

                $builder = $this->db->table('cgpt_history');
                $result = $builder->insert($cgpt_data);

                if($this->db->affectedRows() == 1) {

                        return true;

                } else {

                        return false;

               }
       }

       //Function to get all the history for all tools

       //This function is named "getAllHistory" and is designed to retrieve all the history for all tools for a particular user.
       //It takes a parameter named "$uid" which represents the user ID for whom the history needs to be retrieved.
       //The function uses the CodeIgniter Query Builder to select all rows from the "cgpt_history" table where the "uid" column matches the given user ID.
       //The function then retrieves the results of the query and returns them as an array using the "getResult()" method.
       public function getAllHistory($uid) {

                $builder = $this->db->table('cgpt_history');
                $builder->select('*');
                $builder->where('uid', $uid);
                $result = $builder->get();
                return $result->getResult();
       }

       //Function to get history details

       //This function is named "history_details" and is designed to retrieve the details of a specific history item.
       //It takes a parameter named "$id" which represents the ID of the history item whose details are to be retrieved.
       //The function uses the CodeIgniter Query Builder to select all columns from the "cgpt_history" table where the "id" column matches the given ID.
       //The function then retrieves the results of the query and returns them as an array using the "getResult()" method.
       public function history_details($id) {

                $builder = $this->db->table('cgpt_history');
                $builder->select('*');
                $builder->where('id', $id);
                $result = $builder->get();
                return $result->getResult();

        }

       //Function to delete history one by one

       //This function is named "deleteHistory" and is designed to delete a single history item based on its ID.
       //It takes a parameter named "$id" which represents the ID of the history item to be deleted.
       //The function uses the CodeIgniter Query Builder to find the row in the "cgpt_history" table where the "id" column matches the given ID, and deletes it using the "delete()" method.
       //The function does not return any value.
       public function deleteHistory($id) {

                $builder = $this->db->table('cgpt_history');
                $builder->where('id', $id);
                $builder->delete();
       }

       //Function to delete all history according to every user

       //This function is named "deleteAllHistory" and is designed to delete all the history items for a particular user.
       //It takes a parameter named "$uid" which represents the user ID for whom all the history items are to be deleted.
       //The function uses the CodeIgniter Query Builder to find all the rows in the "cgpt_history" table where the "uid" column matches the given user ID, and deletes them using the "delete()" method.
       //The function does not return any value.
       public function deleteAllHistory($uid) {

                $builder = $this->db->table('cgpt_history');
                $builder->where('uid', $uid);
                $builder->delete();
       }

}