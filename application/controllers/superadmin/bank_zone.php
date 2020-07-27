<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_zone extends MY_Controller {
	
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
	
	public function index($page_no="")
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')|| $this->session->userdata('arole')!='1'){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	
	/*check for unique zone name duplicate zone name not allowed*/
	function uniquezone() {
		$name = trim($this->input->post('zone_name'));
		$id = $this->input->post('zone_id');
		echo $this->bank_model->uniquezone($name,$id);
	}	
	
	public function page($page_no)
	{
		if($this->input->get('submit'))
			$this->updateStatus('tbl_zone');
		$data['heading']='Bank Zone';
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		
		//search query start//
		$search['title'] 	= $this->input->get('title'); 
		//$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=50;
		$total_record	= $this->bank_model->GetTotalZoneRecord();	
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/bank_zone?k=2';
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
		
		$array_records = $this->bank_model->GetZoneRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/bank-zone', $data);
		$this->load->view('superadmin/footer');
	}
	public function zone_addedit($param=null)
	{
		if(is_numeric($param)){
			$data['heading']='Edit Zone'; 
			$zone_id = $param;
		}else{
			$data['heading']='Add Zone'; 
		}
		
		if($zone_id){
			$array_records = $this->bank_model->GetZoneRecordById($zone_id);
		}else{
			$array_records=array();
		}
		$data['row'] = $array_records;
		
		//print_r($data['row']);
		
				
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-bank-zone', $data);
		$this->load->view('superadmin/footer');
	}
	public function save_zone()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('zone_name', 'Zone Name', 'trim|required|xss_clean');		
		
		
		if($this->form_validation->run() == FALSE)
		{			
			$zone_id = $this->input->post('zone_id');
			if($zone_id)
			{
				$this->session->set_flashdata('message','Please enter required fields');
				redirect('superadmin/bank_zone/zone_addedit/'.$zone_id);	
			}
			else
			{
				$this->session->set_flashdata('message','Please enter required fields');	
				redirect('superadmin/bank_zone/zone_addedit');	
			}
				
		}
		else{			
			
		$isValid = $this->bank_model->uniquezone($this->input->post('zone_name'), $this->input->post('zone_id'));
			if($isValid=='true') 
			{				
				$checkHTMLTagsArr['zone_name'] = $this->input->post('zone_name');
				
				if(is_array($checkHTMLTagsArr))
				{
					foreach($checkHTMLTagsArr as $input)
					{
						if($input != ''){
							$checkHTMLTags = checkHTMLTags($input);
							if($checkHTMLTags == "1"){
									$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									$zone_id = $this->input->post('zone_id');
									if($zone_id > 0)
									{
										redirect('superadmin/bank_zone/zone_addedit/'.$zone_id);
									}
									else
									{
										redirect('superadmin/bank_zone/zone_addedit');
									}
							  }
						}
					}
				}
				
				
				$save = $this->bank_model->save_zone_data($image);
				
				if($save){
				$this->session->set_flashdata('message','Zone is successfully created');
					redirect('superadmin/bank_zone/page');
				}else{
					
				}
			} else {
				$data['zone_exists'] = $this->input->post('zone_name');
				redirect('superadmin/bank_zone/zone_addedit');
			}
		}	
	}
	public function ajax_zone($bank_id)
	{
		$array_records = $this->bank_model->FilterZoneRecords($bank_id);
		$str= "<option value=''>Select Zone</option>";
		foreach($array_records as $row)
		{
		$str.= "<option value='$row->id'>$row->name</option>";
		}
		echo $str;
	}
}
?>
