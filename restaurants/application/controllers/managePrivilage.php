<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class managePrivilage extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
           if($this->session->userdata('control_type')!='superAdmin')
            {
                redirect('login');
            }
            
            $this->menu_name = 'menu_left_superadmin';
    }
   
    public function index()
    {
        $page = "User Access Controll";
        $data['title'] = ucfirst($page); 

        $this->load->model('role');
        $data['role'] = $this->role->getRole();

        $data['control_type'] = $this->session->userdata('control_type');
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header',$data);
        $this->load->view('template/menu_left_superadmin',$data);

        $this->load->view('tables/useraccesscontroll',$data);

        //$this->load->view('template/page_right_sidebar', $data);
        $this->load->view('template/footer');
    }
    
    public function savePrivilages()
    {
        $btnSave = $this->input->post('btnSave');
        
        $id = substr($btnSave[0],4);
        
        $checkRead = $this->input->post('check_'.$id.'_1');
        $checkAdd = $this->input->post('check_'.$id.'_2');
        $checkEdit = $this->input->post('check_'.$id.'_3');
        $checkDelete = $this->input->post('check_'.$id.'_4');
        
        $updateFeilds = array(
            'read_access'=>$checkRead,
            'add_access'=>$checkAdd,
            'update_access'=>$checkEdit,
            'delete_access'=>$checkDelete
        );
        
        $this->load->model('userAccess');
        if(!$this->userAccess->updateAccessData($id,$updateFeilds))
        {
            echo "Updation Failed";
        }
        else 
        {
            $this->index();
        }
        
    }
    
    function getAccess()
    {
            $user_type = $this->input->get('user_type');
            $this->load->model('userAccess');
            
            $result = $this->userAccess->getAccessData(array('userroleid'=>$user_type));
            
            
            $outp = "[";
            $i=0;
            foreach ($result as $data)
            {
                
                if ($outp != "[") {$outp .= ",";}
                $outp .= '{"id":"'  . $data["id"] . '",';
                $outp .= '"tablename":"'   . $data["tablename"]        . '",';
                $outp .= '"read_access":"'   . $data["read_access"]        . '",';
                $outp .= '"add_access":"'   . $data["add_access"]        . '",';
                $outp .= '"update_access":"'   . $data["update_access"]        . '",';
                $outp .= '"delete_access":"'. $data["delete_access"]     . '"}';
                $i++;
            }
            $outp .="]";
            
            
            echo $outp;
            
    }
    

}