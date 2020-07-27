<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_region extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/bank_model');
		
	  $this->check_isvalidated();
	}	
	
	public function index($bank_id,$page_no="")
	{
		$this->page($bank_id,$page_no);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')|| $this->session->userdata('arole')!='1'){
           redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	
	public function page($page_no)
	{
		if($this->input->post('submit'))
			$this->updateStatus('tbl_region');
		$data['heading']='Bank Region';
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		
		//search query start//
		$search['title'] 	= $this->input->get('title'); 
		//$search['status'] 		= $this->input->get('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=50;
		$total_record	= $this->bank_model->GetTotalRegionRecord();		
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/bank_region/page?k=2';
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
		
		$array_records = $this->bank_model->GetRegionRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/bank-region', $data);
		$this->load->view('superadmin/footer');
	}
	public function region_addedit($param=null)
	{
		if(is_numeric($param)){
			$data['heading']='Edit Bank Region'; 
			$region_id = $param;
		}else{
			$data['heading']='Add Bank Region'; 
		}
		
		if($region_id){
			$array_records = $this->bank_model->GetRegionRecordById($region_id);
		}else{
			$array_records=array();
		}
		$data['bank_id'] = $bank_id; 
		$data['row'] = $array_records; 
		
		$zones = $this->bank_model->GetZoneRecord();		
		$data['zones'] = $zones;
		$banks = $this->bank_model->GetBankRecords();		
		$data['banks'] = $banks;
		
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$cities = $this->bank_model->GetCity();		
		$data['cities'] = $cities;
		
		$lho = $this->bank_model->GetLho($data['row']->bank_id);		
		//print_r($lho);
		$data['lhoarr'] = $lho;
		
				
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-bank-region', $data);
		$this->load->view('superadmin/footer');
	}
	public function save_region()
	{
		$this->load->library('form_validation');
		$bank_id = $this->input->post('bank_id');
		$id = $this->input->post('id');
		$this->form_validation->set_rules('bank', 'Bank', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zone', 'Zone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address1', 'Address1', 'trim|required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
		$this->form_validation->set_rules('state_id', 'State', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city_id', 'City', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			
			if($id)
			{
				redirect('superadmin/bank_region/region_addedit/'.$bank_id.'/'.$id);	
			}
			else
			{
				redirect('superadmin/bank_region/region_addedit/'.$bank_id);	
			}
				
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->bank_model->upload1('image');
			}else{
				$image=$this->input->post('image_old');
			}
			
			
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
									redirect('superadmin/bank_region/region_addedit/'.$id);
								}
								else
								{
									redirect('superadmin/bank_region/region_addedit');
								}
						  }
					}
				}
			}
			
			
			$save = $this->bank_model->save_region_data($image);
			
			if($save){
				if($id)
				{
					$this->session->set_flashdata('message','Region is successfully updated');
				}else{
					$this->session->set_flashdata('message','Region is successfully created');
				}
				redirect('superadmin/bank_region/page/'.$bank_id);
			}
		}	
	}
	public function ajax_region($zone_id)
	{
		$array_records = $this->bank_model->FilterRegionRecords($zone_id);
		echo "<option value=''>Select Region</option>";
		foreach($array_records as $row)
		{
		echo "<option value='$row->id'>$row->name</option>";
		}
	}
}
?>
