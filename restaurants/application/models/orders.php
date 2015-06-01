<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Model {

        public function saveorders($queryParameters)
	{
            $this->db->insert('orders',$queryParameters);
            return $this->db->insert_id();
	}
        
        public function getorders($queryParameters)
	{
            $this->db->where($queryParameters);
            $query =  $this->db->get('orders');
           	
            if($query->num_rows>=1)
            {
                return $query->result_array();
            }
            else
		return false;
	}
        
        public function updateorders($id,$queryParameters)
	{
            $this->db->where('orderid', $id);
            return $this->db->update('orders', $queryParameters);
        }
}


	


