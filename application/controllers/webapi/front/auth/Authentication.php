<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/firebase/php-jwt/src/JWT.php';

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST OPTIONS,PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
use Firebase\JWT\JWT;
class Authentication extends REST_Controller  {

    public function __construct($config = 'rest') {
        parent::__construct($config);
 
        $this->load->model('Common_model');
        $this->load->model('User_model');
        $this->load->model('Wallet_model');
        $this->load->model('Betting_model');
        $this->load->model('Market_model');
        $this->load->library('Common_data');

    }

    function register_post()
    {
         $response = [
            "status" => 400,
            "result" => false,
            "message" => "Invalid Inputs",
        ];
       
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("password", "password", "required");
        $this->form_validation->set_rules("firstname", "firstname", "required");
        $this->form_validation->set_rules("lastname", "lastname", "required");
        $this->form_validation->set_rules("userdob", "userdob", "required");
        $this->form_validation->set_rules("usercontact", "usercontact", "required");
        $this->form_validation->set_rules("country", "Country", "required");
        $this->form_validation->set_rules("state", "state", "required");
        // $this->form_validation->set_rules("city", "city", "required");
        $this->form_validation->set_rules("useraddr1", "useraddr1", "required");
        $this->form_validation->set_rules("useraddr2", "useraddr2", "required");
        $this->form_validation->set_rules("notification", "notification", "required");
        $this->form_validation->set_rules("txtmsg", "txtmsg", "required");
        $this->form_validation->set_rules("txtemail", "txtemail", "required");

    if ($this->form_validation->run() === FALSE) {

         $err_msg = validation_errors();

        $this->response($response, REST_Controller::HTTP_OK);
       
     }
     else
     {
            // Check if the given email already exists
            $email=strip_tags($this->input->post('useremail'));
           $mobile= strip_tags($this->input->post('usercontact'));

        $emailCount = $this->Common_model->getAll('users', array('email' => $email))->num_rows();
        $mobileCount = $this->Common_model->getAll('users', array('mobile' =>$mobile))->num_rows();

             if($emailCount > 0)
             {
                  // Set the response and exit
                      $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "The given Email already exists",
                    ];

                $this->response($response, REST_Controller::HTTP_OK);
             
             }
             else if($mobileCount > 0)
             {
                 // Set the response and exit
                   $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "The given Mobile already exists",
                    ];

                $this->response($response, REST_Controller::HTTP_OK);
              
             }
            else {
                
                $userData['username'] = strip_tags($this->input->post('username'));
                $userData['password'] = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
                $userData['role'] = 3;
                $userData['created_by'] = 1;
                $userData['first_name'] = strip_tags($this->input->post('firstname'));
                $userData['last_name'] = strip_tags($this->input->post('lastname'));
                $userData['email'] = $email;
                $userData['dob'] = strip_tags(date("Y-m-d", strtotime($this->input->post('userdob'))));
                $userData['mobile'] = strip_tags($this->input->post('usercontact'));
                $userData['country'] = strip_tags($this->input->post('selectedIndex'));
                $userData['state'] = strip_tags($this->input->post('state'));
                $userData['role'] = strip_tags($this->input->post('city'));
                $userData['addr1'] = strip_tags($this->input->post('useraddr1'));
                $userData['addr2'] = strip_tags($this->input->post('useraddr2'));
                $userData['device_name'] = $this->input->server('HTTP_USER_AGENT');
                $userData['device_os'] = $this->input->server('HTTP_USER_AGENT');
                $userData['status'] ='Active';
                $userData['currency'] ='INR';
                $userData['noti_browser_msg'] = strip_tags($this->input->post('notification')); //Agent Commsion
                $userData['noti_text_msg'] = strip_tags($this->input->post('txtmsg')); //Under User
                $userData['noti_email'] = strip_tags($this->input->post('txtemail')); //Under User

                $insert_id = $this->Common_model->insert('users', $userData);
                if(!empty($insert_id))
                {

                    $dat['user_id'] = $insert_id;
                    $dat['title'] = 'New User Joined';
                    $dat['message'] = $this->input->post('username') . ' Joined as User';
                    $dat['notification_to'] = 'admin';
                    $dat['created_at'] = date('Y-m-d H:i:s');
                    $dat['status'] = 'Unread';
                    $this->Common_model->insert('notification', $dat);

                        //Insert into Wallet
                    $insert_wallet['user_id'] = $insert_id;
                    //$insert_wallet['updated_at'] = date('Y-m-d H:i:s');
                    $this->Common_model->insert('wallet', $insert_wallet);

                   /*$token = [
                        'userid' => $insert_id,
                        "iat" => $date->getTimestamp(),
                        "exp" => $date->getTimestamp() + 60 * 60 * 24
                    ];

                    $output = [
                        "token" => JWT::encode($token, $this->config->item('jwt_secret_key')),
                        "ws" => "auth",
                        "status" => 1,
                        "message" => "success"
                    ];*/

                     $this->response([
                            'status' => 200,
                            'result' => TRUE,
                            'message' => 'The user has been added successfully.',
                            'user_id' => $insert_id
                        ], REST_Controller::HTTP_OK);
                }
                else {
                    // Set the response and exit
                         $response = [
                            "status" => 400,
                            "result" => false,
                            "message" => "Some problems occurred, please try again",
                        ];

                        $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
                }
            }

     }
        
        //$this->output->set_content_type('application/json')->set_output(json_encode($response));
      
    }



  public function checkemail_post()
    {
    
     $response = [
            "status" => 400,
            "result" => false,
            "message" => "The Useremail field is required",
        ];

    $this->form_validation->set_rules("useremail", "Useremail", "trim|required");

    if ($this->form_validation->run() == FALSE) {

          $err_msg = strip_tags(validation_errors());
           $this->set_response($response, REST_Controller::HTTP_OK);
       
     }
     else
     {
            // Check if the given email already exists
         $email=$this->input->post('useremail');
           
        $userCount = $this->Common_model->getAll('users', array('email' => $email))->num_rows();
       
             if($userCount > 0)
             {
                  // Set the response and exit
            
                $response = array(
                   'result' => true,
                   'status' => 200,
                   'message' => 'email exists !'
                 );


             }
            else {
               
                 $response = array(
                       'result' => false,
                       'status' => 201,
                       'message' => 'The given email not exists !'
                 );

            }
            
        $this->set_response($response, REST_Controller::HTTP_OK);
        
     }
         
        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
      
    }

    public function login_post()
    {

        $this->form_validation->set_rules("useremail", "Useremail", "required");
        $this->form_validation->set_rules("password", "Password", "required");

        if ($this->form_validation->run() == FALSE) {
            
            $err_msg = validation_errors();

            $this->set_response([
                            'status' => 400,
                            'result' => false,
                            'message' => 'Invalid Inputs',
                        ], REST_Controller::HTTP_OK);

        } else {

            $username = htmlentities($this->input->post("useremail"));
            $password = htmlentities($this->input->post("password"));
            
            $usersResult = $this->Common_model->getAll('users',array('email'=>$username))->row();

            if ($usersResult) {

                if($usersResult->status == 'Inactive' || $usersResult->status == 'Block') {
                      
                  $this->set_response([
                        'status' => 400,
                        'result' => FALSE,
                        'message' => 'Your account has been banned! Please contact support .',
                    ], REST_Controller::HTTP_OK);
 
                }

                $v_password = password_verify($password, $usersResult->password);
                
                if ($v_password == 1) {
                    $session_data = array(
                        "user_logged_in" => TRUE,
                        "user_id" => $usersResult->user_id,
                        "user_name" => $usersResult->first_name . " " . $usersResult->last_name,
                        "user_role" => $usersResult->role,
                        "user_email" => $usersResult->email,
                        "mobile" => $usersResult->mobile,
                    );
                    
                   $this->session->set_userdata($session_data);
                    //Update Last Login Time
                    $get_last_time = $this->Common_model->getAll("users", array("user_id" => $usersResult->user_id))->row_array();
                    $dat_time['last_login_activity'] = $get_last_time['updated_at'];
                    $dat_time['updated_at'] = date('Y-m-d H:i:s');
                    $this->Common_model->update("users", $dat_time, array("user_id" => $usersResult->user_id));

                      $date = new DateTime();
                     $token = [
                            'userid' => $usersResult->user_id,
                            'user_full_name' => $usersResult->first_name . " " . $usersResult->last_name,
                            'email' => $usersResult->email,
                            'phone' => $usersResult->mobile,
                            'role' => $usersResult->role,
                            "iat" => $date->getTimestamp(),
                            "exp" => $date->getTimestamp() + 60 * 60 * 24
                        ];

                    $response = [
                        "token" => JWT::encode($token, $this->config->item('jwt_secret_key')),
                        'result' => TRUE,
                        "status" => 200,
                        "message" => "Login Success",
                        // "data" =>$session_data
                    ];

                  $this->set_response($response, REST_Controller::HTTP_OK);

                  
                }
                else
                {
                     $response = array(
                            'result' => FALSE,
                            "status" => 400,
                            "message" => "Invalid username Or password"
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                }
                
            }
           else
           {

            $this->response([
                            'status' => 400,
                            'result' => FALSE,
                            'message' => 'Invalid Username Or Password.',
                        ], REST_Controller::HTTP_OK);
 
           }
                      
       }

    }


     public function forgetpassword_post()
     {
        
         $response = [
            "status" => 400,
            "result" => false,
            "message" => "Data Not Found",
        ];


        $this->form_validation->set_rules("username", "Username", "trim|required");
        $this->form_validation->set_rules('useremail', 'Useremail', 'trim|required');
        $this->form_validation->set_rules("userdob", "Userdob", "trim|required");
        
     
          if ($this->form_validation->run() == FALSE) {
            
           $err_msg = validation_errors();

             $this->response($response, REST_Controller::HTTP_OK);
        }
        else
        {
   // 
            $username = strip_tags($this->input->post("username"));
            $useremail = strip_tags($this->input->post("useremail"));
            $dob = strip_tags($this->input->post("userdob"));    

            $userEmail = $this->Common_model->getAll('users',array('email'=>$useremail))->row();
          
            if (!empty($userEmail)) {

                $message = 'Oops! you forgot your password? No worries.
                            Reset your password via the given link <br/><a href="' . base_url('webapi/front/auth/authentication/reset_password/') . '">Click here to reset password</a>';

                if($this->common_data->email_template($useremail,$message))
                {
                     $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "Email Sent Successfully",
                    ];
                }
                else
                {
                     $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Error Occured While Email sending ! Please contact support !",
                    ];
                }
               

            } else {
                
                $response = [
                    "status" => 400,
                    "result" => false,
                    "message" => "User Not Found",
                ];
                 
            }

           $this->response($response, REST_Controller::HTTP_OK);
          }

     }


    public function sendpassword($data)
    {
        $email = $data->email;

        $userEmail = $this->Common_model->getAll('users',array('email'=>$email))->row();

     if ($userEmail)
    {
        $newPassword  = rand(999999999,9999999999);
        $encrypted_pass = $this->pass_gen($newPassword);
        $this->db->where('email', $email);
        $this->db->update('users', $encrypted_pass); 
        $mail_message='Dear '.$userEmail->username.','. "\r\n";
        $mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b>Password</b> is <b>'.$newPassword.'</b>'."\r\n";
        $mail_message.='<br>Password Updated Successfully .';
        $mail_message.='<br>Thanks & Regards';
        

    }
}

        // Password encryption
    public function pass_gen($password) {

        $encrypted_pass=password_hash($password,PASSWORD_DEFAULT);
        return $encrypted_pass;
    }   

    
   public  function reset_password() {

       
         $response = [
            "status" => 400,
            "result" => false,
            "message" => "Invalid Request",
        ];

    $this->form_validation->set_rules('password', 'Password', 'required|callback_valid_password');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
           
            if ($this->form_validation->run() === false) {

               $this->response($response, REST_Controller::HTTP_OK);
            } else {

                $username = $this->session->userdata("temp_username");
                $password = $this->input->post('password');
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $updata['password']=$hash_password;
                $res = $this->Common_model->update('users',$updata,array('username'=>$username));

                if($res)
                {
                    $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "Password updated!",
                    ];
                }
                else
                {
                    $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Something went wrong!",
                    ];
                }

                $this->response($response, REST_Controller::HTTP_OK);
                
            }
         
    }

    /*
        Retrieve country list
    */
    public function getCountry_get()
    {
         $country = $this->Common_model->getAll('countries')->result();

           if($country)
                {
                    $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "country fetch!",
                        "data" => $country,
                    ];
                }
                else
                {
                    $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Something went wrong!",
                    ];
                }

                $this->response($response, REST_Controller::HTTP_OK);
    }

    /*
        Retrieve state list
    */

    public function getState_get($id)
    {
         $state = $this->Common_model->getAll('states',array('country_id'=>$id))->result();

           if($state)
                {
                    $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "state fetch!",
                        "data" => $state,
                    ];
                }
                else
                {
                    $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Something went wrong!",
                    ];
                }

                $this->response($response, REST_Controller::HTTP_OK);
    }


     /*
        @Author Ishwar
        function return active match list
    */

    public function match_result_get()
    {
         $market = $this->Market_model->get_all_matches();
      
           if($market)
                {
                    $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "match list!",
                        "data" => $market,
                    ];
                }
                else
                {
                    $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Something went wrong!",
                    ];
                }

                $this->response($response, REST_Controller::HTTP_OK);
    }

    public function inplay_match_result_get($matchid)
    {
        // echo $match_id=$this->input->post('matchid');
    
        $inplay_result = $this->Market_model->get_inplay_result($matchid);
      
           if($inplay_result)
                {
                    $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "inplay list!",
                        "data" => $inplay_result,
                    ];
                }
                else
                {
                    $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Something went wrong!",
                    ];
                }

                $this->response($response, REST_Controller::HTTP_OK);
    }


    public function show_inplay_all_match_result_get()
    {
        // echo $match_id=$this->input->post('matchid');
       
        $inplay_result = $this->Market_model->show_inplay_all_match();
      
           if($inplay_result)
                {
                    $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "inplay list!",
                        "data" => $inplay_result,
                    ];
                }
                else
                {
                    $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Something went wrong!",
                    ];
                }

                $this->response($response, REST_Controller::HTTP_OK);
    }

    public function inplay_match_bets_odds_get($match_id)
    {

        $inplay_result = $this->Market_model->show_match_odds($match_id);
      
           if($inplay_result)
                {
                    $response = [
                        "status" => 200,
                        "result" => true,
                        "message" => "inplay list!",
                        "data" => $inplay_result,
                    ];
                }
                else
                {
                    $response = [
                        "status" => 400,
                        "result" => false,
                        "message" => "Something went wrong!",
                    ];
                }

                $this->response($response, REST_Controller::HTTP_OK);
    }


    public function upcoming_match_result_get()
    {
        $upcoming_result = $this->Market_model->display_upcoming_match();

        if($upcoming_result)
        {
            $response = [
                "status" => 200,
                "result" => true,
                "message" => "upcoming list!",
                "data" => $upcoming_result,
            ];
        }
        else
        {
            $response = [
                "status" => 400,
                "result" => false,
                "message" => "something went wrong!",
            ];
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }
}
