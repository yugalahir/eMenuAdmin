<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_images extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	
	}
	
	function _example_output($output)
	{
		$this->load->view('examples.php',$output);	
	}
	
	function index()
	{
                $itemid = $this->input->get('itemid');
		$image_crud = new image_CRUD();
	
		//$image_crud->set_primary_key_field('item_photos_id');
		$image_crud->set_url_field('url');
		$image_crud->set_table('item_photos');
                    //->set_image_path('assets/uploads/files');
                    //->set_relation_field('itemid');
                
                
		$output = $image_crud->render();
	
		$this->_example_output($output);
	}

	
}