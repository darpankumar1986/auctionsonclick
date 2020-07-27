<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxmaster extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/taxmaster_model');
	  $this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		//$this->page($page_no);
		$this->addedit(0);
		
	}	
	
	private function check_isvalidated(){
        if(!$this->session->userdata('validated')|| $this->session->userdata('arole')!='10'){
          redirect('superadmin/login');
          //redirect('registration/logout');
        }
				
    }	
		
	public function page($page_no)
	{
		if($this->input->post('submit'))
			$this->updateStatus('tbl_taxmaster');
		$data['heading']='Taxmaster'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		$per_page=50;
		$total_record	= $this->taxmaster_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/taxmaster/index';
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
		
		$array_records = $this->taxmaster_model->GetRecords($offset,$per_page);
		
		$data['records'] = $array_records; 
		$this->load->view('superadmin/taxmaster', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit tax'; 
		}else{
			$data['heading']='Add tax'; 
		}
		
		if($param){
			$array_records = $this->taxmaster_model->GetRecordById($param);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records;
		
		$roles = $this->role_model->GetRecords();
		$data['roles'] = $roles;
		
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-taxmaster1', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function taxlist($param='')
	{
		if(is_numeric($param)){
			$data['heading']='Tax List'; 
		}else{
			$data['heading']='Tax List'; 
		}
		

		$array_records = $this->taxmaster_model->GetAllRecord();

		
		$data['records'] = $array_records;
		
		$roles = $this->role_model->GetRecords();
		$data['roles'] = $roles;
		
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/tax-list', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('stax', 'stax', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			redirect('superadmin/taxmaster');
		}
		else{
			
			$save = $this->taxmaster_model->save_taxmaster_data();
			if($save){
				
				$id = $this->input->post('id');
				if(isset($id) && $id!='')
				{
					$this->session->set_flashdata('message','Tax is successfully updated');
				}else{
					$this->session->set_flashdata('message','Tax is successfully added');
				}
				redirect('superadmin/taxmaster/taxlist');
			}else{
				
			}
		}	
	}	
}
?>
