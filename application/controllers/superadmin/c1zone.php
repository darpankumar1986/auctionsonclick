<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C1zone extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/c1zone_model');
		$this->load->model('superadmin/bank_model');
		$this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
	  $this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(!$this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
          redirect('superadmin/login');
            //redirect('registration/logout');
        }
				
    }	
		
	public function page($page_no)
	{
		if($this->input->post('submit'))
			$this->updateStatus('tbl_c1zone');
		$data['heading']='C1zone'; 
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');
		
		//search query start//
		$search['title'] 	= $this->input->get('title'); 
		//$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=50;
		$total_record	= $this->c1zone_model->GetTotalRecord();
		
			
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/c1zone/index?k=2';
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
		
		$array_records = $this->c1zone_model->GetRecord($offset,$per_page);
		
		$data['records'] = $array_records; 
		$this->load->view('superadmin/c1zone', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit C1zone'; 
		}else{
			$data['heading']='Add C1zone'; 
		}
		
		if($param){
			$array_records = $this->c1zone_model->GetRecordById($param);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records;
		
		$roles = $this->c1zone_model->GetRecords();
		$data['roles'] = $roles;
		
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$cities = $this->bank_model->GetCity();		
		$data['cities'] = $cities;
		
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-c1zone', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address1', 'Address1', 'trim|required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
		$this->form_validation->set_rules('state_id', 'State', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city_id', 'City', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
		
		
		$id = $this->input->post('id');
		if($this->form_validation->run() == FALSE){
			redirect('superadmin/c1zone/addedit');
		}
		else{
			
			
			$checkHTMLTagsArr['name'] = $this->input->post('name');
			$checkHTMLTagsArr['address1'] = $this->input->post('address1');
			$checkHTMLTagsArr['address2'] = $this->input->post('address2');
			$checkHTMLTagsArr['street'] = $this->input->post('street');
			$checkHTMLTagsArr['zip'] = $this->input->post('zip');
			$checkHTMLTagsArr['phone'] = $this->input->post('phone');
			$checkHTMLTagsArr['fax'] = $this->input->post('fax');
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
									redirect('superadmin/c1zone/addedit/'.$id);
								}
								else
								{
									redirect('superadmin/c1zone/addedit');
								}
						  }
					}
				}
			}
			
			$save = $this->c1zone_model->save_data($image);
			if($save){
				if($id)
				{
					$this->session->set_flashdata('message','C1zone is successfully updated');
				}else{
					$this->session->set_flashdata('message','C1zone is successfully created');
				}
				redirect('superadmin/c1zone/index');
			}else{
				
			}
		}	
	}	
}
?>
