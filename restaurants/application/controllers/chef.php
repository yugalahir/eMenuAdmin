<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chef extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            if($this->session->userdata('control_type')!='chef')
            {
                redirect('login');
            }
            $this->menu_name = 'menu_left_chef';
            $this->chain_id = $this->session->userdata('chainid');
            $this->outlet_id = $this->session->userdata('outletid');
    }
       
    
    public function index()
    {
        $page = "Chef Home";
        $data['title'] = ucfirst($page); 

        $data['control_type'] = $this->session->userdata('control_type');
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header', $data);
        $this->load->view('template/menu_left_chef');

        $this->load->view('template/blank_page');

        $this->load->view('template/footer', $data);
    }
    
    
    
    public function item()
    {
        $crud = new Db_crud();
        $crud->item($this->menu_name,$this->chain_id,$this->outlet_id);
    }
       
}

