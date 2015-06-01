<?php
class Db_crud 
{
        public function __construct()
        {
            $this->CI =& get_instance();
            
        }
        public function crud_output($output = null,$menu_name)
	{
                $page = "Data Table";
                $data['title'] = ucfirst($page); 
                
               
                $data['control_type'] = $this->CI->session->userdata('control_type');
                $this->CI->load->view('template/header_data_table', $output);
                $this->CI->load->view('template/page_header', $data);
                $this->CI->load->view('template/'.$menu_name,$data);

                $this->CI->load->view('tables/table_data',$output);
                
                //$this->load->view('template/page_right_sidebar', $data);
                $this->CI->load->view('template/footer_data_table', $data);
	}
	
        
        
	public function chain($menu_name)
	{
                $crud = new ajax_grocery_CRUD();

                $tablename = 'chain';
                $crud->set_table($tablename);
                //$crud->set_primary_key('id','item');
                
                $crud->set_subject('chain');
                $crud->set_title("Chain");
                $crud->set_field_upload('logo');
                
                $crud->set_field_upload('picture');
                $crud->set_field_upload('video');
                
                
                $crud->add_fields('name', 'license', 'address', 'country', 'state', 'city', 'zipcode', 'turnover',  'picture', 'video', 'phone', 'fax', 'email', 'status');
                $crud->edit_fields('name', 'license', 'address', 'country', 'state', 'city', 'zipcode', 'turnover', 'picture', 'video', 'phone', 'fax', 'email', 'status');
                $crud->columns( 'name', 'address', 'state', 'city',  'turnover', 'logo', 'picture', 'video', 'phone');
                //$crud->add_fields('name', 'license', 'address', 'city', 'state', 'country', 'zipcode', 'turnover', 'phone', 'fax', 'email', 'status', 'logo', 'picture', 'video' );

                
                $crud->set_relation('country', 'country', 'short_name');
                
                $crud->set_relation('state', 'states', 'name');
                $crud->set_relation_dependency('state', 'country', 'countryid');
                
                
                $crud->set_relation('city', 'city', 'city_name');
                $crud->set_relation_dependency('city', 'state', 'state');
                
                
                //$crud->callback_after_upload(array($this,'thumbnail_callback_after_upload'));
                
                
                $output = $crud->render();

                $this->crud_output($output,$menu_name);
            
	}
        
        

        
        
        
        
        function thumbnail_callback_after_upload($uploader_response,$field_info, $files_to_upload)
        {
            $fullfilename = $uploader_response[0]->name;
            $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
            $pos = strripos($fullfilename,'.');
            
            $filename = substr($fullfilename,0, $pos);
            
            $fileType = substr($fullfilename, $pos+1);
            if($fileType == 'mp4')
            {
                //exec('ffmpeg -i assets/uploads/files/'.$fullfilename.' -deinterlace -an -ss 2 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg assets/uploads/files/thumb-'.$filename.'.jpg');
                exec('ffmpeg -i assets/uploads/files/'.$fullfilename.' -vframes 1 -s 320x240 -ss 10 assets/uploads/files/thumb-'.$filename.'.jpg');
                
            }
            else
            {
                //Is only one file uploaded so it ok to use it with $uploader_response[0].
                $thumbnail1 = $field_info->upload_path.'/thumb1-'.$uploader_response[0]->name;
                
                //$this->CI->image_moo->load($file_uploaded)->resize(50)->save($file_uploaded,true);
                $this->CI->image_moo->load($file_uploaded)->resize_crop(100,100)->save($thumbnail1,true);
                
            }
            return true;
        }
        
        
        
        public function role($menu_name)
	{
            $crud = new grocery_CRUD();
             
            $tablename = 'role';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');


            //$this->setAccess($tablename, $crud);
            
            $crud->set_subject('role');
            $crud->set_title("Role");
            //$crud->unset_delete();

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
            
	}
        
      
        public function user($menu_name,$chain_id,$outlet_id)
	{
            $crud = new grocery_CRUD();
             
            $tablename = 'user';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');


            //$this->setAccess($tablename, $crud);
            
            $crud->set_subject('user');
            $crud->set_title("User");
            $crud->columns('outletid', 'roleid', 'Name', 'nname', 'username');
            // 'outletid', 'roleid', 'fname', 'lname', 'nname', 'dob', 'doj'
            $crud->display_as('outletid','Outlet');
            $crud->display_as('roleid','Role');
            $crud->change_field_type('password', 'password');
            $crud->display_as('fname','First Name');
            $crud->display_as('lname','Last Name');
            $crud->display_as('nname','Nick Name');
            
            $crud->callback_column('Name',array($this,'get_full_name'));
            
            
            
            if($chain_id!='')
            {
                //$crud->where('user.outletid',$outlet_id);
                if($outlet_id!='')
                {
                    $crud->where('user.outletid',$outlet_id);
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.outletid'=>$outlet_id));
                }
                else
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.chainid'=>$chain_id));
                
            }
            else
            {
                $crud->set_relation('outletid', 'outlet', 'name');
            }
            
            
            
            if($this->CI->session->userdata('roleid')>1)
            {
                $crud->where('user.roleid > ',$this->CI->session->userdata('roleid'));
                $crud->set_relation('roleid', 'role', 'name' , array('role.roleid >'=>$this->CI->session->userdata('roleid')));
            }
            else
            {
                $crud->set_relation('roleid', 'role', 'name');
            }

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
            
	}
        
        public function get_full_name($value, $row)
        {
        $str = $row->fname.' '.$row->lname;
        return $str;
        }
        
        
        public function outlet($menu_name,$chain_id,$outlet_id)
	{
            
            $crud = new ajax_grocery_CRUD();

            $tablename = 'outlet';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');


            //$this->setAccess($tablename, $crud);

            
            $crud->set_subject("outlet");
            $crud->set_title("Outlet");

            $crud->columns('chainid', 'name', 'city', 'state',  'logo', 'picture',  'phone');
            
            if($chain_id!='')
            {
                $crud->where('outlet.chainid',$chain_id);
                $crud->set_relation('chainid', 'chain', 'name',array('chain.chainid'=>$chain_id));
            }
            else 
            {
                $crud->set_relation('chainid', 'chain', 'name');
            }
            
            $crud->required_fields('chainid', 'name', 'city', 'state',  'logo', 'picture',  'phone');
            
            $crud->set_relation_n_n('Languages Required', 'restaurant_locale', 'languages', 'outletid', 'loacal_map_id', 'language');

            
            $crud->add_fields('chainid', 'name', 'address','country', 'state',  'city', 'zipcode',  'picture', 'video', 'phone', 'fax', 'email', 'speciality', 'eodprocessing', 'currency', 'multilanguagesupport', 'status');
            $crud->edit_fields('chainid', 'name', 'address','country', 'state',  'city', 'zipcode',  'picture', 'video', 'phone', 'fax', 'email', 'speciality', 'eodprocessing', 'currency', 'multilanguagesupport', 'status');
                
            
            
            
            $crud->set_relation('country', 'country', 'short_name');
                
            $crud->set_relation('state', 'states', 'name');
            $crud->set_relation_dependency('state', 'country', 'countryid');


            $crud->set_relation('city', 'city', 'city_name');
            $crud->set_relation_dependency('city', 'state', 'state');
            
            
            $crud->display_as('chainid','Chain');
            $crud->set_field_upload('logo');
            $crud->set_field_upload('picture');
            $crud->set_field_upload('video');
            
            

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
            
	}
        
        public function languages($menu_name)
        {
            $crud = new grocery_CRUD();


            $tablename = 'languages';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            
            ////$this->setAccess($tablename, $crud);
            
            $crud->set_subject('languages');
            $crud->set_title("Languages");


            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
        
        public function tables($menu_name,$chain_id,$outlet_id)
	{
            
            $crud = new grocery_CRUD();

            $tablename = 'tables';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            $crud->display_as('outletid','Outlet Name');
            
            if($chain_id!='')
            {
                //$crud->where('user.outletid',$outlet_id);
                if($outlet_id!='')
                {
                    $crud->where('tables.outletid',$outlet_id);
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.outletid'=>$outlet_id));
                }
                else
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.chainid'=>$chain_id));
                
            }
            else
            {
                $crud->set_relation('outletid', 'outlet', 'name');
            }
            
            
            

            //$this->setAccess($tablename, $crud);


            $crud->set_subject('tables');
            $crud->set_title("Tables");



            


            $output = $crud->render();

            $this->crud_output($output,$menu_name);
            
	}
        
        public function item($menu_name,$chain_id,$outlet_id)
        {
            $crud = new grocery_CRUD();


            $tablename = 'item';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            
            $crud->unset_columns('sdescription','ldescription');
            
            $crud->display_as('sdescription','Short Description');
            $crud->display_as('ldescription','Long Description');
            
            ///$crud->set_field_upload('video_thumnail');
            $crud->set_field_upload('video');
            
            
            $crud->unset_texteditor('ldescription');
            $crud->unset_texteditor('recipe');
            $crud->unset_texteditor('url');
            
            $crud->set_field_upload('video');
            $crud->callback_after_upload(array($this,'video_callback_after_upload'));
            
            $crud->callback_add_field('video_thumnail');
            
            
            
            $crud->set_relation_n_n('Categories', 'category_item_mapping', 'category', 'itemid', 'categoryid', 'name');
            
            $crud->set_subject('item');
            $crud->set_title("Item");


           
            
            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
        
        function video_callback_after_upload($uploader_response,$field_info, $files_to_upload)
        {
            
            
            $fullfilename = $uploader_response[0]->name;
            $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
            $pos = strripos($fullfilename,'.');
            
            $filename = substr($fullfilename,0, $pos);
            
            $fileType = substr($fullfilename, $pos+1);
            if($fileType == 'mp4')
            {
                //exec('ffmpeg -i assets/uploads/files/'.$fullfilename.' -deinterlace -an -ss 2 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg assets/uploads/files/thumb-'.$filename.'.jpg');
                exec('ffmpeg -i assets/uploads/files/'.$fullfilename.' -vframes 1 -s 320x240 -ss 10 assets/uploads/files/thumb-'.$filename.'.jpg');
                $uploader_response['video_thumnail'] = 'thumb-'.$filename.'.jpg';
            }
            else
            {
                //Is only one file uploaded so it ok to use it with $uploader_response[0].
                $thumbnail1 = $field_info->upload_path.'/thumb1-'.$uploader_response[0]->name;
                
                //$this->CI->image_moo->load($file_uploaded)->resize(50)->save($file_uploaded,true);
                $this->CI->image_moo->load($file_uploaded)->resize_crop(100,100)->save($thumbnail1,true);
                
            }
            return true;
        }
 
        
        function get_input_text()
        {
            return "<input id='field-url' class='form-control' type='text' = value='' name='url'>";
        }
        
        public function category($menu_name,$chain_id,$outlet_id)
        {
            $crud = new grocery_CRUD();

            $tablename = 'category';
            $crud->set_table($tablename /*,'outlet'*/);
            //$crud->set_primary_key('id','item');
            
            if($chain_id!='')
            {
                //$crud->where('outlet.chainid',$chain_id);
                if($outlet_id!='')
                {
                    
                    $crud->where('category.outletid',$outlet_id);
                    
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.outletid'=>$outlet_id));
                }
                else
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.chainid'=>$chain_id));
                
            }
            else
            {
                $crud->set_relation('outletid', 'outlet', 'name');
            }
            
            
            $crud->unset_columns('status');
            //$this->setAccess($tablename, $crud);


            $crud->set_subject('category');
            $crud->set_title("Category");


            //$crud->set_relation('outletid', 'outlet', 'name');
            
            $crud->display_as('sdescription','Short Description');
            $crud->display_as('ldescription','Long Description');
            
            $crud->set_relation('parentid','category','name');
            
            
            $crud->unset_texteditor('ldescription');
            //
            $crud->unset_texteditor('url');
            $crud->unset_texteditor('burl');

            $crud->set_field_upload('video');

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }

        public function categoryItemMapping($menu_name)
        {
            $crud = new grocery_CRUD();

            $tablename = 'category_item_mapping';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');

            $crud->unset_columns('status');
            //$this->setAccess($tablename, $crud);


            $crud->set_subject('Add Item To Category');
            $crud->set_title("Add Item To Category");

            $crud->set_relation('categoryid','category','name');
            $crud->set_relation('itemid','item','name');

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
        
        public function userPrivilege($menu_name)
        {
            $crud = new grocery_CRUD();
            $tablename = 'useraccessprivilege';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');


            //$this->setAccess($tablename, $crud);


            $crud->set_subject('User Privilege');
            $crud->set_title("User Privilege");
            $crud->display_as('userroleid',"Role");
            $crud->unset_delete();
            $crud->callback_add_field('tablename',array($this,'get_table_names'));
            $crud->callback_edit_field('tablename',array($this,'get_table_names'));
            $crud->set_relation('userroleid', 'role', 'name');//
            //$crud->set_relation('tablename', 'INFORMATION_SCHEMA.TABLES', 'table_name');
            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
        
        public function get_table_names()
        {
            $str = "<div id='tablename_input_box' class='form-input-box'>
					<select style=' ' data-placeholder='Select Table Name' class='chosen-select chzn-done' name='tablename' id='field-tablename'>
                                            <option value=''>Select Table Name</option>";
            
                $queryGetALLTables ="show tables";
                $result = mysql_query($queryGetALLTables);
                while ($row = mysql_fetch_row($result))
                {
                    $str.= "<option value='$row[0]'>".ucfirst($row[0])."</option>";
                }
            
            $str.="</select></div>";
            return $str;
        }
        
        public function setAccess($tablename,$crud)
        {
            //--------------Access Controll On Table
                $userRole = $this->CI->session->userdata('roleid');
                $this->CI->load->model('userAccess');
                $queryParameter = array(
                    'userroleid'=> $userRole,
                    'tablename'=>$tablename
                );
                $result = $this->CI->userAccess->getAccessData($queryParameter);
                
                if($result[0]['read_access']==0 || $result[0]['read_access']=='')
                {
                    $crud->unset_read();
                }
                
                if($result[0]['add_access']==0 || $result[0]['read_access']=='')
                {
                    $crud->unset_add();
                }
                
                if($result[0]['update_access']==0 || $result[0]['read_access']=='')
                {
                    $crud->unset_edit();
                }
                
                if($result[0]['delete_access']==0 || $result[0]['read_access']=='')
                {
                    $crud->unset_delete();
                }
                
                //--------------!Access Controll On Table
        }
}


