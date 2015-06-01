<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Outlet extends CI_Model {

        public function saveOutlet($queryParameters)
	{
            $this->db->insert('outlet',$queryParameters);
            return $this->db->insert_id();
	}
        
        public function getOutlet($queryParameters)
	{
            $this->db->where($queryParameters);
            $query =  $this->db->get('outlet');
           	
            if($query->num_rows>=1)
            {
                return $query->result_array();
            }
            else
		return false;
	}
        
        public function updateOutlet($id,$queryParameters)
	{
            $this->db->where('id', $id);
            return $this->db->update('outlet', $queryParameters);
        }
}


	


