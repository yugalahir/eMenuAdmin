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
                
                
                $crud->set_subject('chain');
                $crud->set_title("Chain");
                
                $crud->set_field_upload('logo','assets/uploads/files');
                $crud->set_field_upload('picture','assets/uploads/files');
                $crud->set_field_upload('video','assets/uploads/files');
          
               
                $crud->set_rules('name','Name','trim|required|alpha_numeric_space|required|min_length[1]|max_length[100]');
                $crud->set_rules('license', 'license', 'trim|required|alpha_numeric_space|min_length[1]|max_length[100]');
                $crud->set_rules('address', 'Address', 'trim|min_length[1]|max_length[150]|required');
                $crud->set_rules('country', 'Country', 'required');
                $crud->set_rules('state', 'State', 'required');
                $crud->set_rules('city', 'City', 'required');
                $crud->set_rules('zipcode', 'Zipcode','trim|numeric|min_length[1]|max_length[6]');
                $crud->set_rules('turnover', 'Turnover','trim|required|min_length[1]|max_length[30]');
                $crud->set_rules('picture', 'Picture', 'required');
                $crud->set_rules('phone', 'Phone', 'trim|required');
                $crud->set_rules('fax', 'Fax', 'trim');
                $crud->set_rules('email', 'Email', 'trim|valid_email|required');
               
                
                
                
                $crud->add_fields('name', 'license', 'address', 'country', 'state', 'city', 'zipcode', 'turnover', 'phone', 'fax', 'email', 'status', 'logo', 'picture', 'video');
                $crud->edit_fields('name', 'license', 'address', 'country', 'state', 'city', 'zipcode', 'turnover', 'phone', 'fax', 'email', 'status','logo', 'picture', 'video');
                $crud->columns('name', 'address', 'state', 'city',  'turnover', 'logo', 'picture', 'video', 'phone');
                
                
                
                $crud->set_relation('country', 'country', 'short_name');
                
                $crud->set_relation('state', 'states', 'name');
                $crud->set_relation_dependency('state', 'country', 'countryid');
                
                
                $crud->set_relation('city', 'city', 'city_name');
                $crud->set_relation_dependency('city', 'state', 'state');
                
                $crud->callback_before_upload(array($this,'check_upload_type'));
                
                $crud->callback_add_field('phone',array($this,'input_phone_add'));
                $crud->callback_edit_field('phone',array($this,'input_phone_edit'));
                
                
                $crud->callback_add_field('fax',array($this,'input_fax_add'));
                $crud->callback_edit_field('fax',array($this,'input_fax_edit'));
                
                
                $crud->callback_add_field('zipcode',array($this,'input_zipcode_add'));
                $crud->callback_edit_field('zipcode',array($this,'input_zipcode_edit'));
                
                
                $crud->callback_add_field('turnover',array($this,'input_turnover_add'));
                $crud->callback_edit_field('turnover',array($this,'input_turnover_edit'));
                
                
                $output = $crud->render();

                $this->crud_output($output,$menu_name);
            
	}
        
        function input_turnover_add()
        {
            return "<input type='text' id='field-price' name='turnover'  class='form-control' >";
        }
        
        function input_turnover_edit($value, $primary_key)
        {
            return "<input type='text' id='field-price' name='turnover' value='".$value."' class='form-control'>";
        }
        
        function input_phone_add()
        {
            return "<input type='text' id='field-phone' name='phone' data-mask='(999) 999-9999' class='form-control'>";
        }
        
        function input_phone_edit($value, $primary_key)
        {
            return "<input type='text' id='field-phone' name='phone' value='".$value."' data-mask='(999) 999-9999' class='form-control'>";
        }
        
        
        function input_zipcode_add()
        {
            return "<input type='text' id='field-zipcode' name='zipcode' data-mask='999999' class='form-control'>";
        }
        
        function input_zipcode_edit($value, $primary_key)
        {
            return "<input type='text' id='field-zipcode' name='zipcode' value='".$value."' data-mask='999999' class='form-control'>";
        }
        
        
        function input_fax_add()
        {
            return "<input type='text' id='field-fax' name='fax' data-mask='(999) 999-9999' class='form-control'>";
        }
        
        function input_fax_edit($value, $primary_key)
        {
            return "<input type='text' id='field-fax' name='fax' value='".$value."' data-mask='(999) 999-9999' class='form-control'>";
        }
        
        function check_upload_type($files_to_upload,$field_info )
        {
            $fullfilename = '';
            foreach($files_to_upload as $myfile)
            {
                $fullfilename = $myfile['name'];
                break;
            }
            //$fullfilename = $uploader_response[0]->name;
            $field_name= $field_info->field_name;
            $pos = strripos($fullfilename,'.');
            
            $filename = substr($fullfilename,0, $pos);
            
            $fileType = substr($fullfilename, $pos+1);
            
            
            if($fileType == 'mp4' && $field_name!='video')
            {
                return 'Only image files of jpg, png, gif type are allowed';
            }
            elseif($fileType != 'mp4' && $field_name=='video')
            {
                return 'Only video files of type mp4 is allowed';
            }
            
            //$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
            return true;
        }
        
        
        public function orders($menu_name)
	{
                $crud = new ajax_grocery_CRUD();

                $tablename = 'orders';
                $crud->set_table($tablename);
                //$crud->set_primary_key('id','item');
                
                $crud->set_subject('orders');
                $crud->set_title("orders");
                $crud->set_relation('outletid', 'outlet', 'name');
                $crud->set_relation('waiterid', 'user', 'fname',array('roleid'=>'6'));
                $crud->set_relation('tableid', 'tables', 'tableid');
            
                
                
                $output = $crud->render();

                $this->crud_output($output,$menu_name);
            
	}
        
        public function orderdetails($menu_name)
        {
             $crud = new ajax_grocery_CRUD();

                $tablename = 'orderdetails';
                $crud->set_table($tablename);
                //$crud->set_primary_key('id','item');
                
                $crud->set_subject('orderdetails');
                $crud->set_title("orderdetails");
                $crud->set_relation('orderid', 'orders', 'orderid');
                $crud->set_relation('itemid', 'item', 'name');
                $crud->set_relation('deviceid', 'device', 'deviceid');
                
                $crud->unset_add_fields('ordertime');
                
                
                $output = $crud->render();

                $this->crud_output($output,$menu_name);
        }
                
        
        public function devices($menu_name,$chain_id,$outlet_id)
        {
            $crud = new ajax_grocery_CRUD();
             
            $tablename = 'device';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');

            $crud->unset_texteditor('gcm_regid');

            $crud->set_subject('Device');
            $crud->set_title("Device");
            
            $crud->display_as('outletid','Outlet Name');
            
            $crud->display_as('chainid','Chain');
            if($chain_id!='')
            {
                //$crud->where('user.outletid',$outlet_id);
                $crud->set_relation('chainid', 'chain', 'name',array('chain.chainid'=>$chain_id));
                if($outlet_id!='')
                {
                    $crud->where('device.outletid',$outlet_id);
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.outletid'=>$outlet_id));
                    
                }
                else
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.chainid'=>$chain_id));
             }
            else
            {
                $crud->set_relation('chainid', 'chain', 'name');
                $crud->set_relation('outletid', 'outlet', 'name');
                
            }
            $crud->set_relation_dependency('outletid', 'chainid', 'chainid');
            
            $crud->field_type('gcm_regid', 'varchar');
            $crud->field_type('createddate', 'hidden');
            
            $crud->set_rules('deviceid','Device ID','trim|required|min_length[1]|max_length[20]');
            $crud->set_rules('gcm_regid', 'Gcm Reg ID', 'trim|required|min_length[1]|max_length[256]');
            $crud->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[50]');
                

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
        
        
        
        public function role($menu_name)
	{
            $crud = new grocery_CRUD();
             
            $tablename = 'role';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');


            $crud->set_subject('role');
            $crud->set_title("Role");
            
            $crud->set_rules('name','Name','trim|required|alpha_numeric_space|required|min_length[1]|max_length[100]|is_unique[role.name]');
            
            
            $crud->required_fields('name');
            
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->unset_read();

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
            
	}
        
      
        public function user($menu_name,$chain_id,$outlet_id)
	{
            $crud = new ajax_grocery_CRUD();
             
            $tablename = 'user';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            
            
            //////////////
            $crud->display_as('chainid','Chain');
            if($chain_id!='')
            {
                //$crud->where('user.outletid',$outlet_id);
                $crud->set_relation('chainid', 'chain', 'name',array('chain.chainid'=>$chain_id));
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
                $crud->set_relation('chainid', 'chain', 'name');
                $crud->set_relation('outletid', 'outlet', 'name');
                
            }
            $crud->set_relation_dependency('outletid', 'chainid', 'chainid');    
            ////////////////////////
                
                
            
            
            
            $crud->set_subject('user');
            $crud->set_title("User");
            $crud->columns('chainid','outletid', 'roleid', 'Name', 'nname', 'username');
            
            $crud->display_as('outletid','Outlet');
            $crud->display_as('roleid','Role');
            $crud->change_field_type('password', 'password');
            $crud->display_as('fname','First Name');
            $crud->display_as('lname','Last Name');
            $crud->display_as('nname','Nick Name');
            
            $crud->callback_column('Name',array($this,'get_full_name'));
            
            $crud->required_fields('chainid', 'outletid', 'roleid', 'fname', 'lname',  'dob', 'doj', 'shift', 'username', 'password');
            $crud->set_rules('outletid', 'Outlet', 'required');
            $crud->set_rules('roleid', 'Role', 'required');
            
            $crud->set_rules('fname', 'First Name', 'trim|alpha_space|required|min_length[1]|max_length[50]');
            $crud->set_rules('lname', 'Last Name', 'trim|alpha_space|required|min_length[1]|max_length[50]');
            $crud->set_rules('nname', 'Nick Name', 'trim|alpha_space|min_length[1]|max_length[10]');
            $crud->set_rules('username', 'User ID', 'trim|alpha_numeric_space|required|min_length[7]|max_length[15]');
            $crud->set_rules('password', 'Password', 'trim|required|min_length[6]|valid_password');
            $crud->set_rules('email', 'Email', 'trim|valid_email|required|min_length[6]|max_length[100]');
            
            
            
            
            $crud->where('user.roleid > ',$this->CI->session->userdata('roleid'));
            $crud->set_relation('roleid', 'role', 'name' , array('role.roleid >'=>$this->CI->session->userdata('roleid')));
           

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

            $crud->set_subject("outlet");
            $crud->set_title("Outlet");

            
            if($chain_id!='')
            {
                $crud->where('outlet.chainid',$chain_id);
                $crud->set_relation('chainid', 'chain', 'name',array('chain.chainid'=>$chain_id));
            }
            else 
            {
                $crud->set_relation('chainid', 'chain', 'name');
            }
            
            
            $crud->set_relation('currency', 'currency', 'currencysymbol');
            $crud->set_relation('country', 'country', 'short_name');
            
            $crud->set_relation('state', 'states', 'name');
            $crud->set_relation_dependency('state', 'country', 'countryid');
            
            $crud->set_relation('city', 'city', 'city_name');
            $crud->set_relation_dependency('city', 'state', 'state');
           
            $crud->order_by('chainid', 'ASC');
            
            $crud->required_fields('chainid', 'name','country', 'city', 'state',  'logo', 'picture',  'phone','currency');
       
           
            $crud->fields('chainid', 'name', 'address',  'country', 'state','city', 'zipcode', 'logo', 'picture', 'video', 'phone', 'fax', 'email', 'speciality', 'eodprocessing', 'currency', 'multilanguagesupport', 'status','languages');
            $crud->columns('chainid', 'name', 'address',  'country', 'state','city', 'zipcode', 'logo', 'picture','languages');
            
            $crud->set_relation_n_n('languages', 'restaurant_locale', 'languages', 'outletid', 'local_id', 'language');
            $crud->display_as('languages','Languages ');
            
            $crud->set_rules('chainid', 'Chain', 'required');
            $crud->set_rules('name','Name','trim|alpha_numeric_space|required|min_length[1]|max_length[100]');
            $crud->set_rules('address', 'Address', 'trim|min_length[1]|max_length[150]|required');
            $crud->set_rules('country', 'Country', 'required');
            $crud->set_rules('state', 'State', 'required');
            $crud->set_rules('city', 'City', 'required');
            $crud->set_rules('zipcode', 'Zipcode', 'required|min_length[1]|max_length[6]');
            $crud->set_rules('logo', 'logo', 'required');
            $crud->set_rules('picture', 'Picture', 'required');
            $crud->set_rules('speciality', 'Speciality', 'trim|alpha_numeric_space|required');
            $crud->set_rules('fax', 'Fax', 'trim');
            $crud->set_rules('email', 'Email', 'trim|valid_email|required');
            $crud->set_rules('status', 'Status', 'required');
            $crud->set_rules('phone', 'Phone', 'trim|required');
            
            $crud->callback_add_field('phone',array($this,'input_phone_add'));
                
                
            $crud->callback_edit_field('phone',array($this,'input_phone_edit'));
                
                
            $crud->callback_add_field('fax',array($this,'input_fax_add'));
                
                
            $crud->callback_edit_field('fax',array($this,'input_fax_edit'));
            
            $crud->callback_add_field('zipcode',array($this,'input_zipcode_add'));
            $crud->callback_edit_field('zipcode',array($this,'input_zipcode_edit'));
            
            $crud->display_as('chainid','Chain');
            $crud->display_as('eodprocessing','EOD Processing');
            $crud->display_as('multilanguagesupport','Multi Language Support');
            
            $crud->set_field_upload('logo');
            $crud->set_field_upload('picture');
            $crud->set_field_upload('video');
            
            $crud->callback_before_upload(array($this,'check_upload_type'));

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
            
	}
        
        public function languages($menu_name)
        {
            $crud = new grocery_CRUD();


            $tablename = 'languages';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            
            $crud->set_subject('languages');
            $crud->set_title("Languages");
            
            $state = $crud->getState();

            
            if($state == 'edit' || $state == 'update') 
            {
                $crud->field_type('locale', 'readonly');
                $crud->set_rules('language', 'Language', 'trim|alpha|required|min_length[2]|max_length[20]');
                $crud->required_fields('language');
            }
            
            if($state == 'add' || $state == 'insert_validation' || $state == 'insert')
            {   
                
                $crud->set_rules('locale', 'Locale', 'trim|alpha|required|min_length[2]|max_length[2]|is_unique[languages.locale]');
                $crud->set_rules('language', 'Language', 'trim|alpha|required|min_length[2]|max_length[20]|is_unique[languages.language]');
                
                $crud->required_fields('locale','language');
                
            }
            
            
            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
        
        public function tables($menu_name,$chain_id,$outlet_id)
	{
            
            $crud = new ajax_grocery_CRUD();

            $tablename = 'tables';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            $crud->display_as('outletid','Outlet Name');
            
            $crud->display_as('chainid','Chain');
            if($chain_id!='')
            {
                //$crud->where('user.outletid',$outlet_id);
                $crud->set_relation('chainid', 'chain', 'name',array('chain.chainid'=>$chain_id));
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
                $crud->set_relation('chainid', 'chain', 'name');
                $crud->set_relation('outletid', 'outlet', 'name');
                
            }
            $crud->set_relation_dependency('outletid', 'chainid', 'chainid'); 
            
            $crud->set_subject('tables');
            $crud->set_title("Tables");


            $crud->required_fields('chainid','outletid', 'table_name',  'size','type','floor');
               


            $output = $crud->render();

            $this->crud_output($output,$menu_name);
            
	}
        
        public function item($menu_name,$chain_id,$outlet_id)
        {
            $crud = new ajax_grocery_CRUD();


            $tablename = 'item';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            
            $crud->columns('chainid','outletid','name','Categories','recipe', 'url', 'video_thumnail',  'spicelevel', 'price');
            //$crud->unset_fields()
            
            
            $crud->display_as('outletid','Outlet Name');
            
            $crud->display_as('chainid','Chain');
            if($chain_id!='')
            {
                //$crud->where('user.outletid',$outlet_id);
                $crud->set_relation('chainid', 'chain', 'name',array('chain.chainid'=>$chain_id));
                if($outlet_id!='')
                {
                    $crud->where('item.outletid',$outlet_id);
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.outletid'=>$outlet_id));
                    $crud->set_relation_n_n('Categories', 'category_item_mapping', 'category', 'itemid', 'categoryid', 'name','', array('category.outletid'=>$outlet_id));
            
                }
                else
                {
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.chainid'=>$chain_id));
                    $crud->set_relation_n_n('Categories', 'category_item_mapping', 'category', 'itemid', 'categoryid', 'name','',array('category.chainid'=>$chain_id));
            
                }
             }
            else
            {
                $crud->set_relation('chainid', 'chain', 'name');
                $crud->set_relation('outletid', 'outlet', 'name');
                $crud->set_relation_n_n('Categories', 'category_item_mapping', 'category', 'itemid', 'categoryid', 'name');
                
            }
            $crud->set_relation_dependency('outletid', 'chainid', 'chainid');
            
            $crud->field_type('sdescription','text');
            $crud->unset_texteditor('sdescription');
            
            $crud->required_fields('chainid', 'outletid', 'name',  'recipe', 'url', 'video', 'price','sdescription');
            
            $crud->display_as('sdescription','Short Description');
            $crud->display_as('ldescription','Long Description');
            
            ///$crud->set_field_upload('video_thumnail');
            $crud->set_field_upload('video');
            
            
            $crud->unset_texteditor('ldescription');
            $crud->unset_texteditor('recipe');
            $crud->unset_texteditor('url');
            
            $crud->set_field_upload('video');
            
            $crud->set_field_upload('url');
            $crud->display_as('url','Picture');
            
            $crud->callback_before_upload(array($this,'check_upload_type'));
            $crud->callback_after_upload(array($this,'thumbnail_callback_after_upload'));
            $crud->callback_before_insert(array($this,'get_thumbnail_callback'));
            $crud->callback_before_update(array($this,'get_thumbnail_callback'));
            
            $state = $crud->getState();
            if ($state == 'edit' || $state == 'add') 
            {
                $crud->field_type('video_thumnail', 'hidden');
            }
            else 
            {
                $crud->set_field_upload('video_thumnail');
            }

            
            $crud->set_subject('item');
            $crud->set_title("Item");
            
            $crud->set_rules('name', 'Name', 'trim|alpha_numeric_space|required|min_length[3]|max_length[30]');
            $crud->set_rules('sdescription', 'Short Description', 'trim||alpha_numeric_space|min_length[10]|max_length[100]');
            $crud->set_rules('ldescription', 'Long Description', 'trim||alpha_numeric_space|min_length[0]|max_length[300]');
            $crud->set_rules('recipe', 'Recipe', 'trim|min_length[0]|max_length[200]');
            $crud->set_rules('price', 'Price', 'trim|required|min_length[3]|max_length[9]');
            
            
            $crud->callback_add_field('price',array($this,'input_price_add'));
                
            $crud->callback_edit_field('price',array($this,'input_price_edit'));
            
            
            $crud->add_action('Add Images', '', '','fa fa-plus-square',array($this,'createLink'));
            
            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
        
        function input_price_add()
        {
            return "<input type='text' id='field-price' name='price'  class='form-control' >";
        }
        
        function input_price_edit($value, $primary_key)
        {
            return "<input type='text' id='field-price' name='price' value='".$value."' class='form-control'>";
        }
        
        function thumbnail_callback_after_upload($uploader_response,$field_info, $files_to_upload)
        {
            $fullfilename = $uploader_response[0]->name;
            
            $pos = strripos($fullfilename,'.');
            
            $filename = substr($fullfilename,0, $pos);
            
            $fileType = substr($fullfilename, $pos+1);
            
            $field_name= $field_info->field_name;
           
            
            $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
            
            if($fileType == 'mp4')
            {
                $thumbname = 'thumb-'.$filename.'.jpg';
                $this->CI->session->set_userdata(array('thumbnail_image_name'=>$thumbname));
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
        
       function get_thumbnail_callback($post_array)
       {
           if($this->CI->session->userdata('thumbnail_image_name')!=null)
            {
                $post_array['video_thumnail'] = $this->CI->session->userdata('thumbnail_image_name');
                $this->CI->session->set_userdata(array('thumbnail_image_name'=>null));
            }
           
            return $post_array;
       }
        
        function createLink($primary_key , $row)
        {
            $control_type = $this->CI->session->userdata('control_type');
            return base_url('index.php/'.$control_type.'/add_item_images').'?itemid='.$row->itemid;
        }
        
        function add_item_images($menu_name,$chain_id,$outlet_id)
        {
            $crud = new grocery_CRUD();

            $tablename = 'item_photos';
            $crud->set_table($tablename);
            //$crud->set_primary_key('id','item');
            $itemid = $this->CI->session->userdata('selected_item');
            $crud->where('item_photos.itemid', $itemid);
            $crud->set_subject('Add Images To Item');
            $crud->set_title("Add Images To Item");

            
            $state = $crud->getState();
            if ($state == 'edit' || $state == 'add') 
            {
                $crud->field_type('itemid', 'hidden');
            }
            else 
            {
                $crud->set_relation('itemid','item','name');
            }
            
            $crud->required_fields('url');
            $crud->display_as('url','Picture');
            $crud->callback_before_insert(array($this,'get_item_callback'));
            
            $crud->set_field_upload('url');
            $crud->callback_before_upload(array($this,'check_upload_type'));

            $output = $crud->render();

            $this->crud_output($output,$menu_name);
        }
                
        function get_item_callback($post_array)
        {
            if($this->CI->session->userdata('selected_item')!=null)
            {
                $post_array['itemid'] = $this->CI->session->userdata('selected_item');
            }
           
            return $post_array;
        }
        
        function get_input_text()
        {
            return "<input id='field-url' class='form-control' type='text' = value='' name='url'>";
        }
        
        public function category($menu_name,$chain_id,$outlet_id)
        {
            $crud = new ajax_grocery_CRUD();

            $tablename = 'category';
            $crud->set_table($tablename);
            
            
            //////////////
            $crud->display_as('chainid','Chain');
            if($chain_id!='')
            {
                $crud->set_relation('chainid', 'chain', 'name',array('chain.chainid'=>$chain_id));
                if($outlet_id!='')
                {
                   
                    $crud->where('category.outletid',$outlet_id);
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.outletid'=>$outlet_id));
                    $crud->set_relation('parentid','category','name', array('category.outletid'=>$outlet_id));
                    
                }
                else
                {
                    $crud->set_relation('outletid', 'outlet', 'name' , array('outlet.chainid'=>$chain_id));
                    $crud->set_relation('parentid','category','name', array('category.chainid'=>$chain_id));
                }
             }
            else
            {
                $crud->set_relation('chainid', 'chain', 'name');
                $crud->set_relation('outletid', 'outlet', 'name');
                $crud->set_relation('parentid','category','name');
                
            }
            $crud->set_relation_dependency('outletid', 'chainid', 'chainid');    
            ////////////////////////
            
            
            $crud->columns('chainid','outletid','name', 'sdescription',  'parentid', 'url', 'burl', 'video');
            $crud->display_as('outletid','Outlet');

            $crud->set_subject('category');
            $crud->set_title("Category");

            $crud->display_as('sdescription','Short Description');
            $crud->display_as('ldescription','Long Description');
            
            
            
            
            $crud->unset_texteditor('ldescription');
         
            
            $crud->required_fields('chainid','outletid', 'name', 'sdescription',  'url', 'burl');
            
            $crud->set_field_upload('url');
            $crud->display_as('url','Picture');
            
            $crud->field_type('sdescription','text');
            $crud->unset_texteditor('sdescription');
            $crud->set_field_upload('video');
            $crud->field_type('burl','input');
            $crud->display_as('burl','Label');
            $crud->callback_before_upload(array($this,'check_upload_type'));
            
            $crud->set_rules('outletid', 'Outlet', 'required');
            $crud->set_rules('name', 'Name', 'trim|alpha_numeric_space|required|min_length[3]|max_length[30]');
            $crud->set_rules('sdescription', 'Short Description', 'trim||alpha_numeric_space|min_length[10]|max_length[100]');
            $crud->set_rules('ldescription', 'Long Description', 'trim||alpha_numeric_space|min_length[0]|max_length[300]');
            $crud->set_rules('status', 'Status', 'required');

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
        

        
        
        
}


