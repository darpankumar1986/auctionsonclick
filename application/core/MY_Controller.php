<?php
class MY_Controller extends CI_Controller {
  public function __construct(){
    parent::__construct();	
  }
  
  function action($act, $id, $act_val = ''){
		$module = $this->uri->segment(2);
		switch($module){
			case 'category':
			$tableName = 'tbl_category';
			break;
			case 'bank':
			$tableName = 'tbl_bank';
			break;
			case 'bank_branch':
			$tableName = 'tbl_branch';
			break;
			case 'country':
			$tableName = 'tbl_country';
			break;
			case 'state':
			$tableName = 'tbl_state';
			break;
			case 'city':
			$tableName = 'tbl_city';
			break;
			case 'bank_zone':
			$tableName = 'tbl_zone';
			break;
			case 'bank_region':
			$tableName = 'tbl_region';
			break;
			case 'admin':
			$tableName = 'tbl_admin';
			break;
			case 'dynamic_form':
			$tableName = 'tbl_product';
			break;
			case 'product_image':
			$tableName = 'tbl_product_image';
			break;
			case 'product_video':
			$tableName = 'tbl_product_video';
			break;
			default:
			$tableName = 'tbl_'.$module;
			break;
		}
		
		switch($act){
			case 'delete':
			$data = array('status'=>5);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			$this->session->set_flashdata('message','Record has been deleted Successfully.!');
			break;
			
			case 'status':
			$data = array('status'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			$this->session->set_flashdata('message','Record has been updated Successfully.!');
			break;
			
			case 'menu_item':
			$data = array('menu_item'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'home_page':
			$data = array('home_page'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'show_home':
			$data = array('show_home'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'carousel':
			$data = array('carousel'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'thumbnail':
			$data = array('thumbnail'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'priority':
			$data = array('priority'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
		}
	}
	function updateStatus($table) {
		$status=$this->input->post('status');
		$val=($this->input->post('submit')=='Active all')?'1':0;
		foreach($status as $id)		
		{	$data['status']=$val;		
			$this->db->where('id', $id);
			$this->db->update($table, $data); 
		}
		
		return true;
	}
	
		function webupdateStatus($table) {
		$status=$this->input->post('status');
		$val=($this->input->post('submit')=='Active all')?'1':0;
		foreach($status as $id)		
		{	$data['status']=$val;		
			$this->db->where('webpage_id', $id);
			$this->db->update($table, $data); 
		}
		
		return true;
	}
	
}
?>