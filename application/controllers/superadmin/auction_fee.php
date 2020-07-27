<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auction_fee extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/auction_fee_model');
		$this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	public function page($page_no)
	{
		if($this->input->post('submit'))
			$this->updateStatus('tbl_bank');
		$data['heading']='Auction fee'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		
		//search query start//
		$search['title'] 	= $this->input->post('title'); 
		$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=50;
		$total_record	= $this->bank_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/bank/index';
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
			
		$offset = ($limit) ? $limit : 0;
		
		$array_records = $this->bank_model->GetRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/auction_fees_list', $data);
		$this->load->view('superadmin/footer');
	}

	function uniqueBank()
	{
		$name=$this->input->post('name');
		$id=$this->input->post('id');
		echo $this->bank_model->uniqueBank($name,  $id);
	}
	
	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit bank'; 
			$bank_id = $param;
		}else{
			$data['heading']='Add bank'; 
		}
		
		if($bank_id){
			$array_records = $this->bank_model->GetRecordById($bank_id);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records; 
		
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$cities = $this->bank_model->GetCity();		
		$data['cities'] = $cities;
		
				
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-bank', $data);
		$this->load->view('superadmin/footer');
	}
	public function getStateDropDown($country_id,$state_id)
	{
		$states = $this->bank_model->GetState($country_id);
		$str='<option value="">Select State</option>';
		foreach($states as $state_record)
		{
		$str.="<option value='$state_record->id'"; if($state_record->id==$state_id)$str.='selected';$str.=" >$state_record->state_name</option>";
		}
		echo $str;
	}
	public function getCityDropDown($state_id=null,$city_id=null)
	{
		
		$state_id	=	$this->input->post('state_id');
		$city_id	=	$this->input->post('city_id');
		$cities = $this->bank_model->GetCity($state_id);
		$str='<option value="">Select City</option>';
		foreach($cities as $city_record)
		{
		$str.="<option value='$city_record->id'"; if($city_record->id==$city_id)$str.='selected';$str.=" >$city_record->city_name</option>";
		}
		echo $str;
	}
	
	public function getLhoDropDown($bank_id,$lho_id)
	{
		$lho = $this->bank_model->GetLho($bank_id);
		$str='<option value="">Select LHO</option>';
		foreach($lho as $lho_record)
		{
		$str.="<option value='$lho_record->id'"; if($lho_record->id==$lho_id)$str.='selected';$str.=" >$lho_record->name</option>";
		}
		echo $str;
	}
	
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$id = $this->input->post('id');
			if($id)
				redirect('superadmin/bank/addedit/'.$id);
			else
				redirect('superadmin/bank/addedit');
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->bank_model->upload1('image');
			}else{
				$image=$this->input->post('image_old');
			}
			
			$save = $this->bank_model->save_data($image);
			
			if($save){
				redirect('superadmin/bank');
			}else{
				
			}
		}	
	}
	
}
?>
