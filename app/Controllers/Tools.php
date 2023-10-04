<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)
// API libaray URL: https://github.com/orhanerday/open-ai

// This is a Tools controller, which controls all the custom prompts made using Open AI Api.
// Open AI have not made specific library for PHP because of that for this we are using Open AI PHP library made by orhanerday.
// The Open AI PHP libary made by orhanerday is approved by Open AI themselves.

namespace App\Controllers; // Assing the namespace
use CodeIgniter\Controller; // Importing controller
use App\Models\PromptModel; // Importing Prompt Model
use App\Models\TeamModel; // Importing team Model
use Orhanerday\OpenAi\OpenAi; // Importing open ai library

class Tools extends BaseController
{
        public $promptModel; // Defining public variable for prompt model
        public $teamModel; // Defining public variable for team model
        public $session; // Defining public variable for session library

        public function __construct()
        {
                helper(['form']); // Helper function for form which works with form_helper.php file from helpers folder
                helper(['date']); // Helper function for date
                helper(['text']); //Helper function for text

                $this->session = \Config\Services::session(); //Initializing the session library
                $this->promptModel = new PromptModel(); // Initializing the prompt model
                $this->teamModel = new TeamModel(); // Initializing the team model

                // Initialization of Open AI Api Key by fetching it from .env file
                $open_ai_key = env("OPEN_AI_API_KEY"); // The key is fetch from .env
                $this->OpenAI = new OpenAI($open_ai_key); // Then its assigned
        }

        /*-----------------------------------------------------*/
                // Content AI Tools //
        /*-----------------------------------------------------*/

        //Title maker tool
        public function title_maker()
        {
                // Session with a session name logged_staff making sure that the user is logged in
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login"); // If its not logged in then its redirecting the visitor to login page, this is so that the visitor from outside cannot directly access the page
                } 
                $data = []; // Here we have initialize an empty array called data which will be used to pass the data to the view file
                $data['validation'] = null; // This variable will be used to store validation if there are any by default it is set to null, there are any errors it will be displayed with the help of from_helper.php
                $uid = session()->get('logged_staff'); // This will store logged in user's information in $Uid variable
                
                $data['teamdata'] = $this->teamModel->getUserData($uid); // The teamdata variable whch stores the data feteched by getUserData query function from the TeamModel and then it is displayed according to the user id stored in $uid variable.
                $data['profilepic'] = $this->teamModel->getProfilePic($uid); // The profilepic variable stores the profile picture data from getProfilePic query function from TeamModel and it is then displayed according to the user id stored in $uid variable.

                if($this->request->getMethod() == 'post') {

                        $rules = [
        
                                'keyword'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Focus keyword field is empty',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'tone'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the tone',
                                        ]
                                ],
                                'platform'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the platform',
                                        ]
                                ], 
                        ]; // These are validation rules, as you can see i have not utlizied regular expressions here because we nned to submit the input data to AI to get solutions

                        // Now if the rules are validated the inputs are assigned to these variables
        
                        if($this->validate($rules)) 
                        {
                               //Get the data from the inputs and assigned storing it inside the variable, also FILTER_UNSAFE_RAW is only used for text inputs to filter out unsafe characters, the rest of the inputs they don't have that filter because they are all select inputs//

                                $keyword   = $this->request->getVar('keyword', FILTER_UNSAFE_RAW);
                                $tone      = $this->request->getVar('tone');
                                $platform  = $this->request->getVar('platform');
                                $describe  = $this->request->getVar('describe', FILTER_UNSAFE_RAW);
        
                                $prompt = "You are content writer and you want to write titles that attract people so brainstorm and create 10 unique and creative\n\n" .$platform. "\n\ntitles based on following description:\n\n" .$describe. "\n\n and Keywords:\n\n" .$keyword. "\n\n and the tone of the title should be:" .$tone; // This is AI prompt which is the combination inputs and the query for AI the input variables will have data stored using that data you will be served the resullt
        
                                        $output =  $this->OpenAI->completion([
        
                                                'model' => 'text-davinci-003', // AI Model Name
                                                'prompt' => $prompt, //Getting prompt stored in the variable
                                                'temperature' => 0.9, // Setting the randomness of the result i.e the temperature, the ideal would be 0.7 to 0.9 higher the value means more random result use Open ai playground to get the ideal temperature for you.
                                                'max_tokens' => 256, // Defining maximum token the tool should use to generate results
                                                'top_p' => 1, //parameter that controls the diversity of the generated text. A lower value will result in more predictable text
                                                'frequency_penalty' => 0, //a penalty given to words that appear frequently in the model’s training data
                                                'presence_penalty' => 0, //a penalty given to words that don’t appear in the model’s training data
                                                        
                                        ]);
                
                                        $result = \json_decode($output, true); //decodes the JSON-encoded $output variable and sets the resulting array to the $result variable
                                        $data['resultTxt'] = $result["choices"][0]["text"]; //The third line sets the value of the $data[‘resultTxt’] variable to the generated text returned by the GPT-3 model. Specifically, it retrieves the first choice of generated text from the $result array and then retrieves the text field of that choice. This field contains the actual generated text

                                        $cgpt_data = [

                                                'tool'   => 'Title Maker',
                                                'prompt' => $prompt,
                                                'result' => $result["choices"][0]["text"],
                                                'uid'    => $uid,
                                                'date'   => date('Y-m-d H:i:s'),
                                        ]; // Storing the prompt, tool name and decoded result into array along with user account id and date

                                        $this->promptModel->saveHistory($cgpt_data); // Saving the data as history in database
        
                        } else {
                                
                                $data['validation'] = $this->validator; // Showing validation error if the input data is invalid
        
                        } 
                }

                echo view('Templates/header'); // Loading header.php from template folder
                echo view('Templates/navigation', $data); // Loading navigation.php from template folder and passsing the data
                echo view('Templates/sidebar', $data); // Loading sidebar.php from template folder and passsing the data
                echo view('Tools/titlemaker', $data); // Loading the titlemaker.php template file from tool and passsing the data
                echo view('Templates/copyright'); // Loading the copyright.php footer file from templates folder
                echo view('Templates/footer'); // loading the footer.php file from templates folder
        }

        // From here onwards similar pattern is followed for all the functions each tool function is called in the following way tool/function_name where tool is the name of the controller and function name well you know the name of the function.//


        //Ecommerce title maker
        public function ecom_title()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');
                
                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid); 

                if($this->request->getMethod() == 'post') {

                        $rules = [
        
                                'keyword'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Focus keyword field is empty',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'platform'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the platform',
                                        ]
                                ], 
                        ];
        
                        if($this->validate($rules)) 
                        {
                         
                                $keyword  = $this->request->getVar('keyword', FILTER_UNSAFE_RAW);
                                $pname    = $this->request->getVar('pname');
                                $platform = $this->request->getVar('platform');
                                $describe = $this->request->getVar('describe', FILTER_UNSAFE_RAW);
        
                                $prompt = "You are content writer who is helping a client to sell his product on ecommerce platform so create 10 appropriate product titles for\n\n" .$pname. "\n\nfor \n\n" .$platform. "\n\nbased on following description:\n\n" .$describe. "\n\n and Keywords:\n\n" .$keyword;
        
                                        $output =  $this->OpenAI->completion([
        
                                                'model' => 'text-davinci-003',
                                                'prompt' => $prompt,
                                                'temperature' => 0.9, 
                                                'max_tokens' => 256,
                                                'top_p' => 1,
                                                'frequency_penalty' => 0,
                                                'presence_penalty' => 0,
                                                        
                                        ]);
                
                                        $result = \json_decode($output, true);
                                        $data['resultTxt'] = $result["choices"][0]["text"];

                                        $cgpt_data = [

                                                'tool'   => 'Ecommerce Title Maker',
                                                'prompt' => $prompt,
                                                'result' => $result["choices"][0]["text"],
                                                'uid'    => $uid,
                                                'date'   => date('Y-m-d H:i:s'),
                                        ];

                                        $this->promptModel->saveHistory($cgpt_data);
        
                        } else {
                                
                                $data['validation'] = $this->validator;
        
                        } 
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/ecomTitleMaker', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Topic suggestions
        public function topic_suggestion()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');
                
                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid); 

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field field is empty',
                                        ]
                                ],
                                'platform'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the platform',
                                        ]
                                ], 
                        ];

                        if($this->validate($rules))
                        {
                                $describe  = $this->request->getVar('describe', FILTER_UNSAFE_RAW); 
                                $platform  = $this->request->getVar('platform'); 
        
                                $prompt = "You are a content writer and a content marketer working for digital marketing agency and you are assigned with a task to create content based on ideas so brainstorm 10 unique but creative viral topics on the following\n\n".$describe. "for:\n\n" . $platform;
        
                                        $output =  $this->OpenAI->completion([
        
                                                'model' => "text-davinci-003",
                                                'prompt' => $prompt,
                                                'temperature' => 0.5,
                                                'max_tokens' => 256,
                                                'frequency_penalty' => 0,
                                                'presence_penalty' => 0,
                                                        
                                        ]);
                
                                        $result = \json_decode($output, true);
                                        $data['resultTxt'] = $result["choices"][0]["text"];
        
                                        $cgpt_data = [

                                                'tool'   => 'Topic Suggestion',
                                                'prompt' => $prompt,
                                                'result' => $result["choices"][0]["text"],
                                                'uid'    => $uid,
                                                'date'   => date('Y-m-d H:i:s'),
                                        ];
        
                                        $this->promptModel->saveHistory($cgpt_data);
                        }

                } else {

                        $data['validation'] = $this->validator;
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/topicSuggestion', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Youtube suggestions
        public function youtube_suggestion()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');
                
                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);  

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'ylink'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Link field is empty',
                                        ]
                                ],
                                'niche'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Niche field is empty',
                                        ]
                                ],
                                'topic'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Topic field is empty',       
                                        ]
                                ], 
        
                        ];

                        if($this->validate($rules))
                        {
                                $ylink = $this->request->getVar('ylink', FILTER_UNSAFE_RAW);
                                $niche = $this->request->getVar('niche', FILTER_UNSAFE_RAW);
                                $topic = $this->request->getVar('topic', FILTER_UNSAFE_RAW);

                                $prompt = "You are a youtuber and you have a task to come up with video content for your channel so brainstorm 10 viral video ideas based on following\n\n" .$niche. "\n\nand\n\n" .$topic. "\n\nwith reference to videos from the following link:\n\n" . $ylink;

                                $output = $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.7,
                                        'max_tokens' => 356,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);
        
                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => ' Suggestion',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];

                                $this->promptModel->saveHistory($cgpt_data);
                        }

                }  else {

                        $data['validation'] = $this->validator;
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/youtubeSuggestion', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Short video suggestions
        public function shortvid_suggestion() 
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'niche'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Niche field is empty',
                                        ]
                                ],
                                'topic'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Topic field is empty',
                                        ]
                                ],
                                'platform'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select a plaform',
                                        ]
                                ],

                        ];

                        if($this->validate($rules))
                        {
                                $niche = $this->request->getVar('niche', FILTER_UNSAFE_RAW);
                                $topic = $this->request->getvar('topic', FILTER_UNSAFE_RAW);
                                $platform = $this->request->getVar('platform');

                                $prompt = "You are a content creator and you have a task to create short video content ideas so Brainstorm 10 creative, unique and cool viral ideas for\n\n" .$platform. "\n\nfor the following niche:\n\n" . $niche . "\n\nand topic:\n\n" . $topic;

                                $output = $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Short Video Suggestion',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);
                                
                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/shortVid', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Content outline creator
        public function outline_maker() 
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'title'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Title field is empty',
                                        ]
                                ],
                                'platform'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the use case',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field field is empty',
                                        ]
                                ], 
                        ];

                        if($this->validate($rules)) 
                        {
                                $title    = $this->request->getVar('title', FILTER_UNSAFE_RAW);
                                $platform = $this->request->getVar('platform');
                                $describe = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a content writer and is tasked to create content, so now create an outline for a\n\n" .$platform. "\n\non\n\n" . $title. "\n\nwith following description\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.6,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Outline Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }
                

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/outlineMaker', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Generate Descriptions
        public function description_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'title'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Title field is empty',
                                        ]
                                ],
                                'describe'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $title    = $this->request->getVar('title', FILTER_UNSAFE_RAW);
                                $describe = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a content writer so create an brief descriptive summary for the following\n\n" .$title. "\n\nand\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.6,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Description Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/makeDescription', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Generate Meta Description
        public function meta_description() 
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'keyword'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Focus keyword field is empty',
                                        ]
                                ],
                                'title'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Title Field is empty',
                                        ]
                                ],
                                'describe'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                 'temp' => [
                                        'rules'    => 'required|regex_match[^\d+(\.\d+)?$]',
                                        'errors'   => [
                                        'required' => 'Please enter the temperature value',       
                                        'regex_match' => 'value is invalid'
                                        ]
                                ],
                                'token' => [
                                        'rules'    => 'required|regex_match[^\d+(\.\d+)?$]',
                                        'errors'   => [
                                        'required' => 'Please enter number of tokens',       
                                        'regex_match' => 'value is invalid'
                                        ]
                                ], 
                        ];

                        if($this->validate($rules))
                        {
                                $keyword  = $this->request->getVar('keyword', FILTER_UNSAFE_RAW);
                                $title    = $this->request->getVar('title', FILTER_UNSAFE_RAW);
                                $describe = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a content writer so brainstorm and create 10 Meta Descriptions for blog of 150 characters from following description:\n\n" .$describe. "\n\nfor a\n\n" .$title. "\n\nwith a following focus keyword:\n\n" .$keyword;
                                
                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.6,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Meta Description Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];


                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/metaDescription', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Improve or fix the content
        public function content_fix()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'action'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select the action',
                                        ]
                                ],
                                'describe'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $action   = $this->request->getVar('action', FILTER_UNSAFE_RAW);
                                $describe = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a content writer so \n\n" .$action. "\n\nthe content:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.6,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Improve or Fix Content',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/improveContent', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        /*-----------------------------------------------------*/
                // Marketing AI Tools //
        /*-----------------------------------------------------*/

        //Email Writer
        public function email_writer()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'etype'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select the email type',
                                        ]
                                ],
                                'describe'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ], 
                        ];

                        if($this->validate($rules))
                        {
                                $email_type = $this->request->getVar('etype', FILTER_UNSAFE_RAW);
                                $describe   = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "Write a\n\n" .$email_type. "\n\nemail based on the following\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.6,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Email Writer',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/emailWriter', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Extract the keywords
        public function extract_keyword()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "Extract the high ranking keywords the following\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.6,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Keyword Extractor',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/keywordExtract', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Linkedin Bio Maker
        public function linkedin_bio()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Describe your background',
                                        ]
                                ],
                                'profession'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Profession field is empty',
                                        ]
                                ],
                                'skills'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Skillset field is empty',
                                        ]
                                ],
                                'tone'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the tone',
                                        ]
                                ], 
                        ];

                        if($this->validate($rules))
                        {
                                $skillset    = $this->request->getVar('skills', FILTER_UNSAFE_RAW);
                                $profession  = $this->request->getVar('profession', FILTER_UNSAFE_RAW);
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);
                                $tone        = $this->request->getVar('tone');

                                $prompt = "Write a complete bio for linkedin profile with a\n\n". $tone. "\n\ntone using following information:\n\nProfession -\n\n". $profession . "\n\nSkills - \n\n". $skillset . "\n\nYour Achievements - \n\n". $describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.6,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Linkedin Bio Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/linkedinBio', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Social media page bio creator
        public function social_bio()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Describe your company, business or brand',
                                        ]
                                ],
                                'cname'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please enter your business/brand name',
                                        ]
                                ],
                                'platform'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the required platform',
                                        ]
                                ],
                                'tone'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the tone',
                                        ]
                                ], 
                        ];

                        if($this->validate($rules))
                        {
                                $cname       = $this->request->getVar('cname', FILTER_UNSAFE_RAW);
                                $type        = $this->request->getVar('type');
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);
                                $tone        = $this->request->getVar('tone');
                                $platform    = $this->request->getVar('platform');

                                $prompt = "Write a long bio for my social media page belonging to\n\n". $platform ."\n\n the bio should of 300 words only with following details:\n\n Name - \n\n". $cname . "\n\nType -".$type . "\n\nTone - \n\n". $tone . "\n\nBackground - \n\n". $describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 356,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);
        
                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Social Media Page Bio Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/socialPageBio', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Tweet maker
        public function tweet_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Describe your company, business or brand',
                                        ]
                                ],
                                'tone'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the tone',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);
                                $tone        = $this->request->getVar('tone');

                                $prompt = "You are a digital marketer and your job is to come up with tweets to maintain the twitter account you are given so brainstorm & write some tweets with a\n\n". $tone ."\n\ntone on the following topic:\n\n" . $describe. "\n\nalso decide whether a Tweet's sentiment is positive, neutral, or negative and give the the result in a formatted structure.";

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 356,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);
        
                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Tweet Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
                
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/tweetMaker', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Instagram Captions Maker
        public function insta_captions_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {

                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Describe your company, business or brand',
                                        ]
                                ],
                                'tone'   => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Please select the tone',
                                        ]
                                ],
                                 'temp' => [
                                        'rules'    => 'required|regex_match[^\d+(\.\d+)?$]',
                                        'errors'   => [
                                        'required' => 'Please enter the temperature value',       
                                        'regex_match' => 'value is invalid'
                                        ]
                                ],
                                'token' => [
                                        'rules'    => 'required|regex_match[^\d+(\.\d+)?$]',
                                        'errors'   => [
                                        'required' => 'Please enter number of tokens',       
                                        'regex_match' => 'value is invalid'
                                        ]
                                ], 
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);
                                $tone        = $this->request->getVar('tone');

                                 $prompt = "You are a digital marketer and your job is to maintain the Instagram account that you have with you so brainstorm & write some Instagram Captions with a\n\n". $tone ."tone on the following topic:\n\n" . $describe. "\n\nalso give some trending hastags for the caption";

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 356,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Instagram Captions Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }

                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/InstagramCaption', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Hashtag Maker
        public function hashtag_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {

                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Describe your post',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a digital marketer and your job is to come up with hashtags that will make your content viral so brainstorm & create some trending hashtag for the following topic:\n\n" . $describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 356,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Hashtag Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }

                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/hashtagMaker', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Review Generator
        public function review_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'name'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'rating'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select rating',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $name        = $this->request->getVar('name', FILTER_UNSAFE_RAW);
                                $rating      = $this->request->getVar('rating', FILTER_UNSAFE_RAW);
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "Generate a review based on following information, where\n\n" .$name. "\n\n" .$rating. "\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 356,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Review Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/reviewMaker', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Strategy Generator
        public function strategy_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'goal'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'target'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'strategy'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select type',
                                        ]
                                ],
                                'duration'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select duration',
                                        ]
                                ],
                                'cname'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $goal        = $this->request->getVar('goal', FILTER_UNSAFE_RAW);
                                $target      = $this->request->getVar('target', FILTER_UNSAFE_RAW);
                                $cname       = $this->request->getVar('cname', FILTER_UNSAFE_RAW);
                                $strategy    = $this->request->getVar('strategy');
                                $duration    = $this->request->getVar('duration');
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a digital marketer and your job is to generate a\n\n" .$strategy. "\n\nfor the period of\n\n" .$duration. "\n\nwith a goal\n\n" .$goal."\n\nfor the following:\n\n" .$cname. "\n\nthe target audience is:\n\n" .$target. "\n\nand the marketing prospect is about:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 456,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Strategy Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/strategyMaker', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }


        //Meme Generator
        public function meme_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                               
                                'target'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'tone'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select tone',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $target    = $this->request->getVar('target', FILTER_UNSAFE_RAW);
                                $tone      = $this->request->getVar('tone');
                                $describe  = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a content marketer and the job you have tasked with is to generate a content copy that can be used as a meme with\n\n" .$tone. "\n\ntone for the following target audience\n\n" .$target. "\n\nbased on a following description:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 456,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Meme Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }

                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/memeMaker', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');
        }

        //Google Ads
        public function google_ads()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                               
                                'target'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'tone'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select tone',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $target    = $this->request->getVar('target', FILTER_UNSAFE_RAW);
                                $tone      = $this->request->getVar('tone');
                                $describe  = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a digital marketer and your job is to write viral a\n\n". $tone. "\n\n3 Different Google Ads Headline of 30 characters only, 2 different Google Ads Descriptions of 90 characters only for\n\n". $target ."\n\nwith a call to action using following topic:\n\n". $describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Google ads',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/googleAds', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Meta Ads
        public function meta_ads()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                               
                                'target'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'tone'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select tone',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $target    = $this->request->getVar('target', FILTER_UNSAFE_RAW);
                                $tone      = $this->request->getVar('tone');
                                $describe  = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a digital marketer and your job is to write viral a\n\n". $tone. "\n\nFacebook and Instagram Ad Copy of 125 characters only for\n\n". $target ."\n\nwith a call to action using following topic:\n\n". $describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Meta ads',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/metaAds', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Linkedin Ads
        public function linkedin_ads()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                               
                                'target'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                                'tone'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select tone',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $target    = $this->request->getVar('target', FILTER_UNSAFE_RAW);
                                $tone      = $this->request->getVar('tone');
                                $describe  = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a digital marketer and your job is to write viral a\n\n". $tone. "\n\nLinkedin Ad Copy of 70 characters only for\n\n". $target ."\n\nwith a call to action using following topic:\n\n". $describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 256,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Linkedin ads',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/linkedinAds', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        /*-----------------------------------------------------*/
                // Code AI Tools //
        /*-----------------------------------------------------*/

        //Code Writer
        public function code_writer()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'programming'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select the coding language',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $programming = $this->request->getVar('programming');
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a developer and programmer so job is to write a code in\n\n" .$programming. "\n\nby executing the instructions given below:\n\n" .$describe ."\n\nand explain the code step by step.";

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 1000,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Code Writer',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeWriter', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Regex Maker
        public function regex_maker()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a developer plus a programmer so your job is to create Regular Expression by executing the instructions given below:\n\n" .$describe. "\n\nand explain it step by step.";

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 1000,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Regex Maker',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeRegex', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Code Reviewer
        public function review_code()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a software tester and your job is to do an in-depth code review given below:\n\n" .$describe. "\n\nand write it a report explaining each and everything in detail.";

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 1000,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Code Reviewer',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeReview', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Code Bug Fixer
        public function fix_code()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a developer plus a programmer and you are given a task to Fix the bugs in the code and give an improved but correct version of the code, also you have to give an explanation of what was the issue and how it was resolved:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 1000,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Code Bug Fixer',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeFix', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Secure the code
        public function secure_code()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a security analyist and your job is to first list down security issues in the code given below and then fix security issues which you listed down, also you have to give a secured version of the code and also explain the security measures applied in the code, in order for other developers to get a complete understanding:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 1000,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Code Secure',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeSecure', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

        //Convert Code
        public function convert_code()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'programming'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Select the coding language',
                                        ]
                                ],
                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $programming = $this->request->getVar('programming');
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a developer and programmer and your job is to convert the following code given below into\n\n" .$programming ."\n\ncode:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 650,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Code Converter',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeConvert', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }


        //Generate SQL & MySQL Code
        public function generate_sql()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a developer plus a programmer and your job create SQL query by executing the instructions given below and explain what the query does:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 650,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Code SQL & MySQL',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeSQL', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }


        //Improve code quality
        public function improve_code()
        {
                if(!session()->has('logged_staff')) 
                {
                   return redirect()->to(base_url(). "home/login");
                } 
                $data = [];
                $data['validation'] = null;
                $uid = session()->get('logged_staff');

                $data['teamdata'] = $this->teamModel->getUserData($uid);
                $data['profilepic'] = $this->teamModel->getProfilePic($uid);

                if($this->request->getMethod() == 'post')
                {
                        $rules = [

                                'describe'        => [
                                        'rules'    => 'required',
                                        'errors'   => [
                                        'required' => 'Field is empty',
                                        ]
                                ],
                        ];

                        if($this->validate($rules))
                        {
                                $describe    = $this->request->getVar('describe', FILTER_UNSAFE_RAW);

                                $prompt = "You are a developer plus a programmer and your job is to analyze the code given below and improve the quality of the code and describe the changes done in the code:\n\n" .$describe;

                                $output =  $this->OpenAI->completion([

                                        'model' => "text-davinci-003",
                                        'prompt' => $prompt,
                                        'temperature' => 0.9,
                                        'max_tokens' => 650,
                                        'frequency_penalty' => 0,
                                        'presence_penalty' => 0,
                                                
                                ]);

                                $result = \json_decode($output, true);
                                $data['resultTxt'] = $result["choices"][0]["text"];

                                $cgpt_data = [

                                        'tool'   => 'Improve Code Quality',
                                        'prompt' => $prompt,
                                        'result' => $result["choices"][0]["text"],
                                        'uid'    => $uid,
                                        'date'   => date('Y-m-d H:i:s'),
                                ];
        
                                $this->promptModel->saveHistory($cgpt_data);

                        } else {

                                $data['validation'] = $this->validator;
                        }
                }


                echo view('Templates/header');
                echo view('Templates/navigation', $data);
                echo view('Templates/sidebar', $data);
                echo view('Tools/codeImprove', $data);
                echo view('Templates/copyright');
                echo view('Templates/footer');

        }

}
