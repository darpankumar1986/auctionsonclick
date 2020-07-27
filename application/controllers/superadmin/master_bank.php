<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_bank extends MY_Controller {
	
	public function __Construct() {
		
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));		
		$this->load->model('superadmin/master_bank_model');
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

	/*check for unique Bank Name*/
	function uniqueMasterbank() {
		$name = trim($this->input->post('bank_name'));
		$id = $this->input->post('bank_id');
		echo $this->master_bank_model->uniqueMasterbank($name,$id);
	}
	
	/*find all values from AccountType table 
	to list number of AccountType*/
	public function page($page_no) {
		if($this->input->post('submit'))
		$this->updateStatus('tblmst_bank');
		$data['heading']='Bank List'; 
		$this->load->view('superadmin/header', $data);		

		//search query start//
		$search['title'] 	= trim($this->input->get('title')); 

		$data['search'] = $search;
		//serach query ends//
		$per_page=50;
		$total_record	= $this->master_bank_model->GetTotalRecord();	
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/master_bank/index?k=2';
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
		$array_records = $this->master_bank_model->GetRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/master_bank_list', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to Add and Edit city form*/
	public function addedit($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit Bank'; 
		} else {
			$data['heading']='Add Bank'; 
		}
		if($param) {
			$array_records = $this->master_bank_model->GetRecordById($param);
		} else {
			$array_records = array();
		}
		$data['row'] = $array_records;		
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-master-bank', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update city by this action*/
	public function save($param) {		
		$id=$this->input->post('bank_id');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('bank_name', 'Name', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) {

		} else {
			$isValid = $this->master_bank_model->uniqueMasterbank($this->input->post('bank_name'), $this->input->post('bank_id'));
			if($isValid=='true') {
				
				$checkHTMLTagsArr['name'] = $this->input->post('bank_name');
			
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
									redirect('superadmin/master_bank/addedit/'.$id);
								}
								else
								{
									redirect('superadmin/master_bank/addedit');
								}
						  }
					}
				}
			}
				
				
				
				$save = $this->master_bank_model->save_data($image);
				if($save) {
					if($id) {
						$this->session->set_flashdata('message','Bank updated successfully');	
					} else {
						$this->session->set_flashdata('message','Bank created successfully');
					}
					redirect('superadmin/master_bank/index');
				}
			} else {
				$data['master_bank_exists'] = $this->input->post('bank_name');
			}
		}
		if(is_numeric($param)) {
			$data['heading']='Edit Bank'; 
		} else {
			$data['heading']='Add Bank'; 
		}
		
		if($param) {
			$array_records = $this->master_bank_model->GetRecordById($param);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-master-bank', $data);
		$this->load->view('superadmin/footer');
	}
}?>
