<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OutletAdmin extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            if($this->session->userdata('control_type')!='outletAdmin')
            {
                redirect('login');
            }
            $this->menu_name = 'menu_left_outletadmin';
            $this->chain_id = $this->session->userdata('chainid');
            $this->outlet_id = $this->session->userdata('outletid');
           
            
    }
    
    
    
    
    public function index()
    {
//        $page = "Outlet Admin Home";
//        $data['title'] = ucfirst($page); 
//
//
//        $data['control_type'] = $this->session->userdata('control_type');
//        $this->load->view('template/header',$data);
//        $this->load->view('template/page_header', $data);
//        $this->load->view('template/menu_left_outletadmin');
//
//        $this->load->view('template/blank_page');
//
//        //$this->load->view('template/page_right_sidebar', $data);
//        $this->load->view('template/footer', $data);
        $this->orderStatus();
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
    
    public function add_item_images()
    {
        $itemid = $this->input->get('itemid');
        if($itemid!='')
        {
            $this->session->set_userdata(array('selected_item'=>$itemid));
        }
        $crud = new Db_crud();
        $crud->add_item_images($this->menu_name,$this->chain_id,$this->outlet_id);
    }
    
    public function orderStatus()
    {
        $page = "Outlet Admin Home";
        $data['title'] = ucfirst($page); 


        
        
        
        
        $data['control_type'] = $this->session->userdata('control_type');
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header', $data);
        $this->load->view('template/menu_left_outletadmin');

        $this->load->view('template/orderlist',$data);

        //$this->load->view('template/page_right_sidebar', $data);
        $this->load->view('template/footer', $data);
    }
    
    function getOrderDetails()
    {
       
        $query = "SELECT orders.orderid, guest, user.fname as waiter,sum(price) as total, tables.tableid as table_no, orders.orderstatus"
                    ." FROM `orders`,`tables`,`user`, `orderdetails`"
                    ." WHERE  orders.orderid = orderdetails.orderid"
                    ." AND orders.waiterid = user.userid" 
                    ." AND orders.tableid = tables.tableid" 
                    ." AND orders.outletid =".$this->outlet_id
                    ." GROUP BY orderdetails.orderid";
        $result = $this->db->query($query);
      
       if($result->num_rows>=1)
       {
            $allorders = $result->result_array();
            $outp = "[";
           
            foreach ($allorders as $order) 
            {
                if ($outp != "[") {$outp .= ",";}
                $outp .= '{"orderid":"'  . $order["orderid"] . '",';
                $outp .= '"guest":"'   . $order["guest"]        . '",';
                $outp .= '"waiter":"'   . $order["waiter"]        . '",';
                $outp .= '"total":"'   . $order["total"]        . '",';
                $outp .= '"table_no":"'   . $order["table_no"]        . '",';
                $outp .= '"orderstatus":"'. $order["orderstatus"]     . '"}';
            }
            $outp .="]";
            
            
            echo $outp;
           
       }
       else 
       {
          return ; 
       }
    }
    
}
