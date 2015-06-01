<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    
	public function getUser($queryParameters)
	{
            $this->db->join('role', 'user.roleid = role.roleid','left');
            
            
            $this->db->where($queryParameters);
          
            $query =  $this->db->get('user');

            if($query->num_rows==1)
            {
                $data_user = $query->result_array();
                return $data_user[0];
            }
            else
		return false;
	}
	
	
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */