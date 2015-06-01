<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChainAdmin extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            if($this->session->userdata('control_type')!='chainAdmin')
            {
                redirect('login');
            }
            $this->menu_name = 'menu_left_chainadmin';
            $this->chain_id = $this->session->userdata('chainid');
            $this->outlet_id = '';
            
            
    }
    
    
    
    
    public function index()
    {
        $page = "Chain Admin Home";
        $data['title'] = ucfirst($page); 


        $data['control_type'] = $this->session->userdata('control_type');
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header', $data);
        $this->load->view('template/menu_left_chainadmin');

        $this->load->view('template/blank_page');

        //$this->load->view('template/page_right_sidebar', $data);
        $this->load->view('template/footer', $data);
    }
    
    
    
    public function outlet()
    {
        $crud = new Db_crud();
        $crud->outlet($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
    public function user()
    {
        $crud = new Db_crud();
        $crud->user($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
    
    
    
    
}
