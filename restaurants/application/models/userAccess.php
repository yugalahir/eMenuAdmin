<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class userAccess extends CI_Model {

        public function saveAccessData($queryParameters)
	{
            $this->db->insert('useraccessprivilege',$queryParameters);
            return $this->db->insert_id();
	}
        
        public function getAccessData($queryParameters)
	{
            $this->db->where($queryParameters);
            $query =  $this->db->get('useraccessprivilege');
           	
            if($query->num_rows>=1)
            {
                return $query->result_array();
            }
            else
		return false;
	}
        
        public function updateAccessData($id,$queryParameters)
	{
            $this->db->where('id', $id);
            return $this->db->update('useraccessprivilege', $queryParameters);
        }
}


	


