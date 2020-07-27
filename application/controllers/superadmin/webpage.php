<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webpage extends MY_Controller {
	
	public function __Construct()
	{
	   	parent::__Construct();
		ob_start();
		 $this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/webpage_model');
	   	$this->check_isvalidated();
	}	
	
	public function index()
	{
		$this->page();
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	public function page()
	{
		if($this->input->post('submit'))
			$this->webupdateStatus('tbl_webpage');
		$this->load->view('superadmin/header');		
		$this->load->view('superadmin/sidebar');
		$array_records = $this->webpage_model->GetRecords();
		$data['records'] = $array_records; 		
		$data['heading']='Static Page'; 		
		$this->load->view('superadmin/webpage',$data);
		$this->load->view('superadmin/footer');
	}

	public function addedit($param)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{
			
			if(is_numeric($param)){
				$data['heading']='Edit Static Page'; 
				$webpage_id = $param;
			}else{
				$data['heading']='Add Static Page'; 
			}			
			if($webpage_id){
				$array_records = $this->webpage_model->GetRecordById($webpage_id);
			}else{
				$array_records=array();
			}
			$data['records'] = $array_records; 			
			$this->load->view('superadmin/header');		
			$this->load->view('superadmin/sidebar');		
			$this->load->view('superadmin/add-edit-webpage',$data);
			$this->load->view('superadmin/footer');
		}else{
			$webpage_id = $this->input->post('webpage_id');
			$save =$this->webpage_model->addEditRecords();
			if($save){
				
				if($webpage_id)
				{
					$this->session->set_flashdata('message','Webpage is successfully updated');
				}else{
					$this->session->set_flashdata('message','Webpage is successfully created');
				}
			}	
			redirect('superadmin/webpage');
		}	
	}
	
	public function deleteRecord($param)
	{
		if(is_numeric($param)){
			$this->webpage_model->deleteRecord($param);
			redirect('superadmin/webpage');
		}
	}	
}
?>
