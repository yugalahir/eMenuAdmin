<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SuperAdmin extends CI_Controller {
    
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
        $page = "Super Admin Home";
        $data['title'] = ucfirst($page); 


        $data['control_type'] = 'superAdmin';
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header', $data);
        $this->load->view('template/menu_left_superadmin',$data);

        $this->load->view('template/blank_page');

        //$this->load->view('template/page_right_sidebar', $data);
        $this->load->view('template/footer', $data);
    }
    
    public function chain()
    {
        $crud = new Db_crud();
       
        $crud->chain($this->menu_name);
        
    }
    
    public function outlet()
    {
        $crud = new Db_crud();
        $chain_id = '';
        $crud->outlet($this->menu_name,'','');
    }
    
    public function user()
    {
        $crud = new Db_crud();
        $crud->user($this->menu_name,'','');
    }
    
    public function devices()
    {
        $crud = new Db_crud();
        $crud->devices($this->menu_name,'','');
    }


    public function role()
    {
        $crud = new Db_crud();
        $crud->role($this->menu_name);
    }
    
    public function tables()
    {
        $crud = new Db_crud();
        $crud->tables($this->menu_name,'','');
    }
    
    public function item()
    {
        $crud = new Db_crud();
        $crud->item($this->menu_name,'','');
    }
    
    public function add_item_images()
    {
        $itemid = $this->input->get('itemid');
        if($itemid!='')
        {
            $this->session->set_userdata(array('selected_item'=>$itemid));
        }
        $crud = new Db_crud();
        $crud->add_item_images($this->menu_name,'','');
    }
    
    public function category()
    {
        $crud = new Db_crud();
        
        $crud->category($this->menu_name,'','');
    }
    
    
    
   public function languages()
    {
        $crud = new Db_crud();
        
        $crud->languages($this->menu_name);
    }
    
    
    
    public function userPrivilege()
    {
        $crud = new Db_crud();
        
        $crud->userPrivilege($this->menu_name);
    }
}
