<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('cookie');
                if($this->input->cookie('remember_user',TRUE))
                {    
                    $this->input->cookie('remember_user',TRUE);
                }
        }
    
	public function index($page = 'login')
	{
                
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$this->load->view($page, $data);
	}
	
	public function fogetPassword($page= 'login')
        {
            
            $form_data = array('username' => $this->input->post('username'));
            $this->load->model('user');
            $userData  = $this->user->getUser($form_data);
            
            if(!$userData)
            {
                $data['message_type'] = "danger";
                $data['message'] = "User Name Not Found!!!";
            }
            else 
            {
                $data['message_type'] = "success";
                $data['message'] = "Mail has been sent on your email id.";
                
		    
                $username= $userData['username'];
                $password= $userData['password'];
                $email= $userData['email'];

                // subject
                $subject = 'Password Recovery';

                // message
                 // message
                 $message = "<table width='600'>
                        <tr>
                          <td colspan=2><center><B>Account Detail</B></center></td>
                        </tr>
                        <tr>
                          <td><B>User Name</B> </td><td>: ".$username."</td>
                        </tr>
                        <tr>
                          <td><B>Password</B> </td><td>: ".$password."</td>
                        </tr>
                    </table>			
                ";
                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Additional headers
                $headers .= 'From: noreply@gennextit.com' . "\r\n";
                $to = $email;
                
                

                // Mail it
                $mail = mail($to, $subject, $message, $headers);
                
                if(!$mail)
                {
                    $data['message_type'] = "danger";
                    $data['message'] = "Mail sending failed!!!";
                }
            }
            
            $this->load->view($page, $data);
           
        }
        
	public function validate_login()
	{
            $form_data = array(
                'username' => $this->input->post('UserName'),
                'password' => $this->input->post('Password')
            );
            $this->load->model('user');
            $userData  = $this->user->getUser($form_data);
            
            
            if($userData!=false)
            {
                $remember = $this->input->post('remember');
                
                if($remember == 'remember')
                {
                    $this->input->set_cookie('remember_user',$this->input->post('UserName'), 3600);
                    $this->input->set_cookie('remember_password',$this->input->post('Password'), 3600);
                    
                }
                
                
                
                
                $data=array(
                    'is_logged_in'=>true
                    );
                
                $this->session->set_userdata($userData);
                $this->session->set_userdata($data);
                
                
                $this->load->model('outlet');
                $dataOutlet = $this->outlet->getOutlet(array('outletid'=>$userData['outletid']));
                
                
                $usreRole = $userData['name'];
                
                switch($usreRole)
                {
                    case "Super Admin":
                        $this->session->set_userdata(array('control_type'=>'superAdmin'));
                        redirect('superAdmin'); 
                        break;
                    case "Chain Admin":
                        $this->session->set_userdata(array('control_type'=>'chainAdmin'));
                        $this->session->set_userdata(array('chainid'=>$dataOutlet[0]['chainid']));
                        redirect('chainAdmin'); 
                        break;
                    case "Outlet Admin":
                        $this->session->set_userdata(array('control_type'=>'outletAdmin'));
                        $this->session->set_userdata(array('chainid'=>$dataOutlet[0]['chainid']));
                        redirect('outletAdmin'); 
                        break;
                    case "Manager":
                        $this->session->set_userdata(array('control_type'=>'manager'));
                        $this->session->set_userdata(array('chainid'=>$dataOutlet[0]['chainid']));
                        redirect('manager'); 
                        break;
                    case "Chef":
                        $this->session->set_userdata(array('control_type'=>'chef'));
                        $this->session->set_userdata(array('chainid'=>$dataOutlet[0]['chainid']));
                        redirect('chef'); 
                        break;
                    case "Waiter":
                        $this->session->set_userdata(array('control_type'=>'waiter'));
                        $this->session->set_userdata(array('chainid'=>$dataOutlet[0]['chainid']));
                        redirect('waiter'); 
                        break;
                    default :
                        echo "User Role Not Associated With Controll";
                }
                    
		//redirect(ucfirst($resultData['designation']));
            }
            else
            {
                $page="login";
                $data['title'] = ucfirst($page); // Capitalize the first letter
                $data['message'] = "Invalid login";
                $this->load->view($page, $data);
            }
	}
}
