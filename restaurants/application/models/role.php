<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Model {

        public function saveRole($queryParameters)
	{
            $this->db->insert('role',$queryParameters);
            return $this->db->insert_id();
	}
        
        public function getRole()
	{
            $query =  $this->db->get('role');
           	
            if($query->num_rows>=1)
            {
                return $query->result_array();
            }
            else
		return false;
	}
        
        public function updateRole($id,$queryParameters)
	{
            $this->db->where('id', $id);
            return $this->db->update('role', $queryParameters);
        }
}


	


