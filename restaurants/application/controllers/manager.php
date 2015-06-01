<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            if($this->session->userdata('control_type')!='manager')
            {
                redirect('login');
            }
            $this->menu_name = 'menu_left_manager';
            $this->chain_id = $this->session->userdata('chainid');
            $this->outlet_id = $this->session->userdata('outletid');
    }
       
    
    public function index()
    {
        $page = "Manager Home";
        $data['title'] = ucfirst($page); 

        $data['control_type'] = $this->session->userdata('control_type');
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header', $data);
        $this->load->view('template/menu_left_manager');

        $this->load->view('template/blank_page');

        $this->load->view('template/footer', $data);
    }

    public function user()
    {
        $crud = new Db_crud();
        $crud->user($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
    public function tables()
    {
        $crud = new Db_crud();
        $crud->tables($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
    
    
    public function category()
    {
        $crud = new Db_crud();
        
        $crud->category($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
   
    
    public function item()
    {
        $crud = new Db_crud();
        $crud->item($this->menu_name,$this->chain_id,$this->outlet_id);
    }
       
}

