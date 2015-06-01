<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            
            $this->menu_name = 'menu_left_chainadmin';
            
    }
    
    
    
    
    public function index()
    {
        $page = "Super Admin Home";
        $data['title'] = ucfirst($page); 


        $data['control_type'] = $this->session->userdata('control_type');
        $this->load->view('template/header',$data);
        $this->load->view('template/page_header', $data);
        $this->load->view('template/menu_left_chainadmin');

        $this->load->view('template/blank_page');

        //$this->load->view('template/page_right_sidebar', $data);
        $this->load->view('template/footer', $data);
    }
    
    protected $path_to_uploade_function = 'uploade/multi_uploade'; // path to function. you should change the path .("uploade" in this path is a CLASS' NAME)
    private   $files = array();
    protected $default_css_path = 'assets/css';
    protected $default_javascript_path = 'assets/js';
    protected $path_to_dirrectory = 'assets/uploads/files/';
    // table description
    protected $file_table = 'files';
    protected $category_id_field = 'gallery_id';
    protected $file_name_field = 'file_name';
    protected $primary_key = 'file_id';
 
    function gallery()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('gallery');
        $crud->add_fields(array('title', 'photo'));
        $crud->callback_add_field('photo', array($this, 'add_upload_fied'));
        $crud->callback_edit_field('photo', array($this, 'edit_upload_fied'));
        $crud->callback_before_insert(array($this, '_set_files'));
        $crud->callback_after_insert(array($this, '_save_files_into_db'));
        $crud->callback_before_update(array($this, '_set_files'));
        $crud->callback_after_update(array($this, '_save_files_into_db'));
        // if you have no any upload fields on the page you should to set list of the JS files
        $this->_set_js($crud);
 
        $output = $crud->render();
        $this->_example_output($output);
    }
 
    function _set_js($crud)
    {
        $crud->set_css('assets/grocery_crud/css/ui/simple/' . grocery_CRUD::JQUERY_UI_CSS);
        $crud->set_css('assets/grocery_crud/css/jquery_plugins/file_upload/file-uploader.css');
        $crud->set_css('assets/grocery_crud/css/jquery_plugins/file_upload/jquery.fileupload-ui.css');
        $crud->set_js('assets/grocery_crud/js/' . grocery_CRUD::JQUERY);
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/ui/' . grocery_CRUD::JQUERY_UI_JS);
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/tmpl.min.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/load-image.min.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.iframe-transport.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.fileupload.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/config/jquery.fileupload.config.js');
        $crud->set_css('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.fancybox.pack.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.easing-1.3.pack.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.mousewheel-3.0.4.pack.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/config/jquery.fancybox.config.js');
    }
 
    function add_upload_fied()
    {
        $html = '
<div>
<span class="fileinput-button qq-upload-button" id="upload-button-svc">
<span>Upload a file</span>
<input type="file" name="multi_aploade" id="multi_aploade_field" >
</span> <span class="qq-upload-spinner" id="ajax-loader-file" style="display:none;"></span>
<span id="progress-multiple" style="display:none;"></span>
</div>
<select name="files[]" multiple="multiple" size="8" class="multiselect" id="file_multiple_select" style="display:none;">
</select>
<div id="file_list_svc" style="margin-top: 40px;">
</div>';
        $html.=$this->JS();
        return $html;
    }
 
    function edit_upload_fied($value, $primary_key)
    {
        $files = $this->db->get_where($this->file_table, array($this->category_id_field => $primary_key))->result_array();
        $html = '
<div>
<span class="fileinput-button qq-upload-button" id="upload-button-svc">
<span>Upload a file</span>
<input type="file" name="multi_aploade" id="multi_aploade_field" >
</span> <span class="qq-upload-spinner" id="ajax-loader-file" style="display:none;"></span>
<span id="progress-multiple" style="display:none;"></span>
</div>';
 
        $html.= '<select name="files[]" multiple="multiple" size="8" class="multiselect" id="file_multiple_select" style="display:none;">';
        if (!empty($files))
        {
            foreach ($files as $items)
            {
                $html.="<option value=" . $items['file_name'] . " selected='selected'>" . $items['file_name'] . "</option>";
            }
        }
        $html.='</select>';
        $html.='<div id="file_list_svc" style="margin-top: 40px;">';
        if (!empty($files))
        {
            foreach ($files as $items)
            {
                if ($this->_is_image($items['file_name']) === true)
                {
                    $html.= '<div id="' . $items['file_name'] . '">';
                    $html.= '<a href="' . base_url() . $this->path_to_dirrectory . $items['file_name'] . '" class="image-thumbnail" id="fancy_' . $items['file_name'] . '">';
                    $html.='<img src="' . base_url() . $this->path_to_dirrectory . $items['file_name'] . '" height="50"/>';
                    $html.='</a>';
                    $html.="<a href='javascript:' onclick='delete_file_svc(this,\"" . $items['file_name'] . "\")' style='color:red;' >Delete</a>";
                    $html.='</div>';
                }
                else
                {
                    $html.="<div id='" . $items['file_name'] . "' ><span>" . $items['file_name'] . "</span><a href='javascript:' onclick='delete_file_svc(this,\"" . $items["file_name"] . "\")' style='color:red;' >Delete</a></div>";
                }
            }
        }
        $html.='</div>';
        $html.=$this->JS();
        return $html;
    }
 
    function _is_image($name)
    {
        return ((substr($name, -4) == '.jpg')
                || (substr($name, -4) == '.png')
                || (substr($name, -5) == '.jpeg')
                || (substr($name, -4) == '.gif' )
                || (substr($name, -5) == '.tiff')) ? true : false;
    }
 
    function JS()
    {
        $js = "<script>
function delete_file_svc(link,filename)
{
$('#file_multiple_select option[value=\"'+filename+'\"]').remove();
$(link).parent().remove();
    $.post('" . base_url() . $this->path_to_uploade_function . "/delete_file', 'file_name='+filename, function(json){
        if(json.succes == 'true')
        {
            console.log('json data', json);
        }
    }, 'json');   
}
$(document).ready(function() {
    $('#multi_aploade_field').fileupload({
         url: '" . base_url() . $this->path_to_uploade_function . "/uploade',
         sequentialUploads: true,
         cache: false,
          autoUpload: true,
          dataType: 'json',
          acceptFileTypes: /(\.|\/)(" . $this->config->item('grocery_crud_file_upload_allow_file_types') . ")$/i,
          limitMultiFileUploads: 1,
          beforeSend: function()
          {
          $('#upload-button-svc').slideUp('fast');
          $('#ajax-loader-file').css('display','block');
           $('#progress-multiple').css('display','block');
          },
          progress: function (e, data) {
        $('#progress-multiple').html(string_progress + parseInt(data.loaded / data.total * 100, 10) + '%');
        },
          done: function (e, data)
          {
           console.log(data.result);
           $('#file_multiple_select').append('<option value=\"'+data.result.file_name+'\" selected=\"selected\">'+data.result.file_name+'</select>');
           var is_image = (data.result.file_name.substr(-4) == '.jpg'  
                                        || data.result.file_name.substr(-4) == '.png' 
                                        || data.result.file_name.substr(-5) == '.jpeg' 
                                        || data.result.file_name.substr(-4) == '.gif' 
                                        || data.result.file_name.substr(-5) == '.tiff')
                                                ? true : false;
         var html;
         if(is_image==true)
         {
         html='<div id=\"'+data.result.file_name+'\" ><a href=\"" . base_url() . $this->path_to_dirrectory . "'+data.result.file_name+'\" class=\"image-thumbnail\" id=\"fancy_'+data.result.file_name+'\">';
         html+='<img src=\"" . base_url() . $this->path_to_dirrectory . "'+data.result.file_name+'\" height=\"50\"/>';
         html+='</a><a href=\"javascript:\" onclick=\"delete_file_svc(this,''+data.result.file_name+'')\" style=\"color:red;\" >Delete</a><div>';
        $('#file_list_svc').append(html);
$('.image-thumbnail').fancybox({
        'transitionIn'	:	'elastic',
        'transitionOut'	:	'elastic',
        'speedIn'		:	600, 
        'speedOut'		:	200, 
        'overlayShow'	:	true
});
         }
         else
         {
          html = '<div id=\"'+data.result.file_name+'\" ><span>'+data.result.file_name+'</span> <a href=\"javascript:\" onclick=\"delete_file_svc(this,''+data.result.file_name+'')\" style=\"color:red;\" >Delete</a><div>';
         $('#file_list_svc').append(html);
}
          $('#upload-button-svc').show('fast');
          $('#ajax-loader-file').css('display','none');
          $('#progress-multiple').css('display','none');
          $('#progress-multiple').html('');
          }
     });
 
});
</script>";
        return $js;
    }
 
    function multi_uploade($action = NULL)
    {
        switch ($action)
        {
            case 'uploade':
                $this->uploade_file();
 
                break;
            case 'delete_file':
                $this->delete_file();
 
                break;
 
            default:
 
                break;
        }
    }
 
    function uploade_file()
    {
        $json = NULL;
        $config['upload_path'] = $this->path_to_dirrectory;
        $config['allowed_types'] = $this->config->item('grocery_crud_file_upload_allow_file_types');
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['max_filename'] = 0;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('multi_aploade'))
        {
            $json['error'] = $this->upload->display_errors();
            $json['success'] = 'false';
        }
        else
        {
            $uploade_data = $this->upload->data();
            $json['success'] = 'true';
            $json['file_name'] = $uploade_data['file_name'];
        }
        echo json_encode($json);
        exit;
    }
 
    function _set_files($post_array)
    {
        $this->files = $post_array['files'];
        unset($post_array['files']);
        return $post_array;
    }
 
    function _save_files_into_db($post_array, $primary_key)
    {
        $this->db->delete($this->file_table, array($this->category_id_field => $primary_key));
        $files = array();
        if (!empty($this->files))
        {
            foreach ($this->files as $file)
            {
                $files[] = array($this->category_id_field => $primary_key, 'file_name' => $file);
            }
        }
        if (!empty($files))
        {
            $this->db->insert_batch($this->file_table, $files);
        }
        return true;
    }
 
    function delete_file($file_name = NULL)
    {
        $file_name = $this->input->post('file_name') ? $this->input->post('file_name') : $file_name;
        $this->db->delete($this->file_table, array($this->file_name_field => $file_name));
        if (file_exists($this->path_to_dirrectory . $file_name))
        {
            unlink($this->path_to_dirrectory . $file_name);
        }
        $json = array('success' => true);
        echo json_encode($json);
        exit;
    }
 
    function _example_output($output = null)
    {
        $this->load->view('example', $output);
        $page = "Data Table";
                $data['title'] = ucfirst($page); 
                
               
                $data['control_type'] = $this->CI->session->userdata('control_type');
                $this->load->view('template/header_data_table', $output);
                $this->load->view('template/page_header', $data);
                $this->load->view('template/'.$this->menu_name,$data);

                $this->load->view('tables/table_data',$output);
                
                //$this->load->view('template/page_right_sidebar', $data);
                $this->load->view('template/footer_data_table', $data);
    }
    
    
}
