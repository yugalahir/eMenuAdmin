<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	
	public function index()
	{
		
		$this->session->unset_userdata('is_logged_in');
                $this->session->unset_userdata('control_type');
		
		redirect('login');
	}
}

