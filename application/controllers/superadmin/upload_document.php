<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_document extends MY_Controller {
	
	public function __Construct() {
		
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));		
		$this->load->model('superadmin/upload_document_model');
		$this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
		$this->check_isvalidated();
	}	
	
	/*execute page action to show the list of city 
	in table format*/
	public function index($page_no) {
		$this->page($page_no);
	}	
	
	/*check session if not loged in then redirect 
	to login page*/
	private function check_isvalidated() {
        if(!$this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
			redirect('superadmin/login');
            //redirect('registration/logout');
        }		
    }

	/*check for unique upload document field*/
	function uniqueUploadDocumentFieldType() {
		$name = trim($this->input->post('upload_document_field_name'));
		$id = $this->input->post('upload_document_field_id');
		echo $this->upload_document_model->uniqueUploadDocumentFieldType($name,$id);
	}
	
	/*find all values from AccountType table 
	to list number of AccountType*/
	public function page($page_no) {
		if($this->input->post('submit'))
		$this->updateStatus('tblmst_upload_document_field');
		$data['heading']='Upload Document Field'; 
		$this->load->view('superadmin/header', $data);		

		//search query start//
		$search['title'] 	= trim($this->input->get('title')); 

		$data['search'] = $search;
		//serach query ends//
		$per_page=50;
		$total_record	= $this->upload_document_model->GetTotalRecord();	
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/upload_document/index?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
		$offset = ($limit) ? $limit : 0;
		$array_records = $this->upload_document_model->GetRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/upload_document_field_list', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to Add and Edit city form*/
	public function addedit($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit Upload Document Field'; 
		} else {
			$data['heading']='Add Upload Document Field'; 
		}
		if($param) {
			$array_records = $this->upload_document_model->GetRecordById($param);
		} else {
			$array_records = array();
		}
		$data['row'] = $array_records;		
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-upload-document-field', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update city by this action*/
	public function save($param) {		
		$id=$this->input->post('upload_document_field_id');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('upload_document_field_name', 'Upload Document Field Name', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) {

		} else {
			$isValid = $this->upload_document_model->uniqueUploadDocumentFieldType($this->input->post('upload_document_field_name'), $this->input->post('upload_document_field_id'));
			if($isValid=='true') {
				
				$checkHTMLTagsArr['name'] = $this->input->post('upload_document_field_name');
			
			if(is_array($checkHTMLTagsArr))
			{
				foreach($checkHTMLTagsArr as $input)
				{
					if($input != ''){
						$checkHTMLTags = checkHTMLTags($input);
						if($checkHTMLTags == "1"){
								$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
								$id = $this->input->post('id');
								if($id > 0)
								{
									redirect('superadmin/upload_document/addedit/'.$id);
								}
								else
								{
									redirect('superadmin/upload_document/addedit');
								}
						  }
					}
				}
			}
				
				
				
				$save = $this->upload_document_model->save_data();
				if($save) {
					if($id) {
						$this->session->set_flashdata('message','Upload Document Field is successfully updated');	
					} else {
						$this->session->set_flashdata('message','Upload Document Field is successfully created');
					}
					redirect('superadmin/upload_document/index');
				}
			} else {
				$data['account_type_exists'] = $this->input->post('upload_document_field_name');
			}
		}
		if(is_numeric($param)) {
			$data['heading']='Edit Upload Document Field'; 
		} else {
			$data['heading']='Add Upload Document Field'; 
		}
		
		if($param) {
			$array_records = $this->upload_document_model->GetRecordById($param);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-account-type', $data);
		$this->load->view('superadmin/footer');
	}
}?>
