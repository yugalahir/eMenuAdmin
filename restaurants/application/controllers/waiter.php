<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waiter extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            if($this->session->userdata('control_type')!='waiter')
            {
                redirect('login');
            }
            $this->menu_name = 'menu_left_waiter';
            $this->chain_id = $this->session->userdata('chainid');
            $this->outlet_id = $this->session->userdata('outletid');
    }
       
    
    public function index()
    {
        $page = "Waiter Home";
        $data['title'] = ucfirst($page); 

        $data['control_type'] = 'waiter';
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header', $data);
        $this->load->view('template/menu_left_waiter');

        $this->load->view('template/blank_page');

        $this->load->view('template/footer', $data);
    }
    
    
    
    
    public function tables()
    {
        $crud = new Db_crud();
        $crud->tables($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
    public function orders()
    {
        $crud = new Db_crud();
        $crud->orders($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
    public function ordersdetails()
    {
        $crud = new Db_crud();
        $crud->orderdetails($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
}

