<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Corrigendum extends MY_Controller {
	
	public function __Construct()
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		//$this->load->library('Email_new','email');
		$this->load->model('superadmin/corrigendum_model');
		$this->load->model('helpdesk_executive_model');
		$this->load->model('superadmin/bank_model');	
		$this->load->library('Datatables');		
		$this->load->library('table');	
		$this->load->library('Email_new','email');
		$this->check_isvalidated();		
	}	
	
	public function index()
	{
		$auctionid = $this->input->post('auctionid');
		
		if($auctionid > 0)
		{
			redirect('superadmin/corrigendum/searchevent/'.$auctionid);
		}
		$this->load->view('superadmin/header');
		$this->load->view('superadmin/corrigendum',$data);
		$this->load->view('superadmin/myActivityCorrigendum',$data);
		$this->load->view('superadmin/footer');
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }
    
    public function corrigendumdatatable()
    {
		echo $this->corrigendum_model->corrigendumdatatable();
	}
	
	public function viewCorrigendum($corrID)
	{
		$data['corrigendum'] = $this->corrigendum_model->getCorrigendumByCorrigendumId($corrID);
		$this->load->view('superadmin/view_corrigendum',$data);
		
	}
    
    public function preview($eid){
		
		$action = $this->input->post('final_submit');
		if($action == 'Final Submit')
		{
			$pModified_date = $this->corrigendum_model->updateAuction($eid);			
			$msg = "Event has been updated successfully.";
			
			$this->db->where('auctionID', $eid);
			$this->db->where('corrigendum_status', '2');
			$this->db->order_by("id","DESC");
			$corrigendum_query = $this->db->get("tbl_auction_corrigendum_approval");
			/*if ($corrigendum_query->num_rows() > 0) {				
				foreach ($corrigendum_query->result() as $corrigendum) {
										
					if($corrigendum->status != $corrigendum->status_old)
					{
						$this->db->where('id', $eid);			
						$query = $this->db->get("tbl_auction");
						if ($query->num_rows() > 0) {				
							foreach ($query->result() as $row) {
								
								if($row->status == 3 || $row->status == 4)
								{
									$this->db->where('auctionID', $eid);
									$this->db->where('status', '1');
									$invoice_query = $this->db->get("tbl_event_invoice");	
									if ($invoice_query->num_rows() > 0) {							
										foreach ($invoice_query->result() as $invoice) {
											$this->db->where('auctionID', $eid);
											$this->db->where('verified', '1');
											$credit_query = $this->db->get("tbl_auction_credit_note");	
											if ($credit_query->num_rows() == 0) {											
												$this->db->where("id",$eid);
												$this->db->update("tbl_auction",array("is_invoice_generated"=>'0'));
												
												$this->db->where("auctionID",$eid);
												$this->db->update("tbl_event_invoice",array("status"=>'0'));								
												$msg .= ' Previous generated invoice has been successfully updated. <br/>Please generate new invoice from Account Dashboard.';
											}
											else
											{
												$msg .= ' Previous generated invoice has been successfully updated. <br/>Please generate new invoice from Account Dashboard.';
											}
										}
									}			
									
								}
							}
						}
					}
				}
			}*/
						
			$this->session->set_flashdata('message',$msg);
			
			$email = new email_new();			
			//$email->backendCorrigendumSendMail($eid,$pModified_date);			
			redirect('/superadmin/corrigendum/');
		}
		
		$arows	=	 $this->helpdesk_executive_model->GetAutionRecordByAuctionId($eid);	
		
		if($eid!='' && $arows->productID != ''){
			
			$prows					=    $this->helpdesk_executive_model->GetProductDetailByProductID($arows->productID); // New Add from createEventAuction			
		 }
		
		$corrigendum = $this->corrigendum_model->getCorrigendumByAuctionId($eid);
		if(isset($corrigendum) && $corrigendum)
		{
			$data['auctionData']	=	 $corrigendum; 
			$data['corrigendumid']	=	 $corrigendumid; 
			
			$prows->product_type = $data['auctionData']->category_id;
			$prows->product_subtype_id = $data['auctionData']->subcategory_id;
			$prows->product_description = $data['auctionData']->product_description;		
		}
		else
		{			
			$data['auctionData']	=	 $auctionData; 
			$data['auctionData']->product_description = $prows->product_description;
		}

	    
		$data['bank_id'] = $data['auctionData']->bank_id;	
		$data['auctionID'] = $eid;

		$banksUsersList			= 	 $this->helpdesk_executive_model->getUserByBankId($data['bank_id']);
		
		$document_list			=	 $this->helpdesk_executive_model->document_list(); // New Add from createEventAuction
		$auctionData			=	 $this->helpdesk_executive_model->GetAutionbyId($eid); // New Add from createEventAuction
 
		$banks 					= 	 $this->bank_model->GetBankRecords(); // New Add from createEventAuction

		$category 				= 	 $this->helpdesk_executive_model->GetCategorylist(); // New Add from createEventAuction
		
		

		$data['document_list']	=	 $document_list;  	
	
		
		$data['banks']			=	 $banks; 
		$data['category']		=	 $category; 
		$data['prows']		    =    $prows; 
		$data['banksUsersList']	=	 $banksUsersList;
		$data['auctionID']		=	 $eid;
		$data['arows']			=	 $arows;
		$data['prows']			=	 $prows;
		$data['userID']			=	 $userID;
        $countries = $this->helpdesk_executive_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->helpdesk_executive_model->GetState();		
		$data['states'] = $states;
		$cities = $this->helpdesk_executive_model->GetCity();		
		$data['cities'] = $cities;
               
               
        $drt_user = $this->session->userdata('user_type');
		if($drt_user == 'drt')
		{	
			$bankId = $data['auctionData']->bank_id;
			if(!($bankId > 0))
			{
				if(is_array($data['banks']))
				{
					$bankId = $data['banks'][0]->id;
				}
			}
			
			$data['bank_id'] = $arows->bank_id;	
			$data['banksUsersList']			=	 $this->helpdesk_executive_model->getUserByBankId($bankId);			
			$data['bankbranch']			    =	 $this->helpdesk_executive_model->GetBranchdata($bankId);		
		}		
		
		$this->load->view('superadmin/header');
		$this->load->view('superadmin/preview_corrigendum',$data);
		$this->load->view('superadmin/footer');		
	}
    
    public function searchevent($eid){
		
		$action 	= $this->input->get('action');		
		
		if($action == "reset")
		{
			$this->corrigendum_model->resetCorrigendumByAuctionId($eid);
			$msg = "Corrigendum has been reset successfully!";
			$this->session->set_flashdata('message1',$msg);
			redirect('/superadmin/corrigendum/searchevent/'.$eid);
			die;
		}		
		
		$data['heading']='Create Auction'; 
		$data['controller']='corregendum';    
		
		$auctionData			=	 $this->helpdesk_executive_model->GetAutionbyId($eid); // New Add from createEventAuction
		
		//echo '<pre>';
		//print_r($auctionData->productID);
		
		if($eid!='' && $auctionData->productID != ''){
			
			$prows					=    $this->helpdesk_executive_model->GetProductDetailByProductID($auctionData->productID); // New Add from createEventAuction			
		 }else{
				$msg = "Event ID Not Found!";
				$this->session->set_flashdata('message1',$msg);
				redirect('/superadmin/corrigendum/');
				die;
		
			 
		}
		
		$corrigendum = $this->corrigendum_model->getCorrigendumByAuctionId($eid);
		if(isset($corrigendum) && $corrigendum)
		{
			$data['auctionData']	=	 $corrigendum; 
			$data['corrigendumid']	=	 $corrigendum->id; 
			
			$prows->product_type = $data['auctionData']->category_id;
			$prows->product_subtype_id = $data['auctionData']->subcategory_id;
			$prows->product_description = $data['auctionData']->product_description;	
			
			$data['auctionData']->bank_branch_id = $data['auctionData']->branch_id;	
		}
		else
		{			
			//echo '<pre>';
			//print_r($prows);die;
			$data['auctionData']	=	 $auctionData; 
			$data['auctionData']->bank_branch_id = $auctionData->branch_id;
			$data['auctionData']->product_description = $prows->product_description;
		}        
              
		$data['noofparticipate'] = $this->helpdesk_executive_model->getParticipateByAuctionId($eid);
		  
		$arows	=	 $this->helpdesk_executive_model->GetAutionRecordByAuctionId($eid);	

	    
		$data['bank_id'] = $data['auctionData']->bank_id;	

		$banksUsersList					= 	 $this->helpdesk_executive_model->getUserByBankId($data['bank_id']);		
		
		
		$document_list			=	 $this->helpdesk_executive_model->document_list(); // New Add from createEventAuction
		
 
		$banks 					= 	 $this->bank_model->GetBankRecords(); // New Add from createEventAuction

		$category 				= 	 $this->helpdesk_executive_model->GetCategorylist(); // New Add from createEventAuction
		 

		$data['document_list']	=	 $document_list;  
		
	
		
		$data['banks']			=	 $banks; 
		$data['category']		=	 $category; 
		$data['prows']		    =    $prows; 
		$data['banksUsersList']	=	 $banksUsersList;
		$data['auctionID']		=	 $eid;
		$data['arows']			=	 $arows;
		$data['prows']			=	 $prows;
		$data['userID']			=	 $userID;
        $countries = $this->helpdesk_executive_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->helpdesk_executive_model->GetState();		
		$data['states'] = $states;
		$cities = $this->helpdesk_executive_model->GetCity();		
		$data['cities'] = $cities;
		
		$data['approverFirstlist'] = $this->corrigendum_model->getApproverFirstList();
		$data['approverlist'] = $this->corrigendum_model->getApproverList();
               
               
        $userID = $auctionData->first_opener;
        $data['drt_user'] = GetTitleByField('tbl_user', "id='$userID'", 'user_type');
		if($data['drt_user'] == 'drt')
		{
			$bankId = $data['bank_id'];
			if(!($bankId > 0))
			{
				if(is_array($data['banks']))
				{
					$bankId = $data['banks'][0]->id;
				}
			}			
			$data['bank_id'] = $arows->bank_id;	
			$data['banksUsersList']			=	 $this->helpdesk_executive_model->getUserByBankId($bankId);			
			$data['bankbranch']			    =	 $this->helpdesk_executive_model->GetBranchdata($bankId);		
		}
		
		//echo '<pre>';
		//print_r($data);die;
		
		$this->load->view('superadmin/header');
		$this->load->view('superadmin/corrigendum_create_event',$data);		
		$this->load->view('superadmin/footer');
		
	}
	
	public function saveeventdata()
	{
		$preview 	= $this->input->post('preview');
		$auctionID 	=	 $this->input->post('auctionID');		
		if($preview == "Preview")
		{
			$this->corrigendum_model->previewUpdate($auctionID);
			//$msg = "Corrigendum has been reset successfully!";
			//$this->session->set_flashdata('message',$msg);
			redirect('/superadmin/corrigendum/preview/'.$auctionID);
			die;
		}
		$this->corrigendum_model->saveeventdata();
	}
	
	public function getsubcategory($category)
	{
		$subCategory = $this->helpdesk_executive_model->GetSubCategory($category);
		$str='<option value="">Select Subcategory</option>';
		foreach($subCategory as $subCategory_record)
		{
			$str.="<option value='$subCategory_record->id'>".$subCategory_record->name."</option>";
		}
		echo $str;
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
	
	public function getCityDropDown($state_id,$city_id)
	{
		$cities = $this->bank_model->GetCity($state_id);
		$str='<option value="">Select City</option>';
		foreach($cities as $city_record)
		{
		$str.="<option value='$city_record->id'"; if($city_record->id==$city_id)$str.='selected';$str.=" >$city_record->city_name</option>";
		}
                //$str.='<option value="others">Others</option>';
		echo $str;
	}
	
	function showbranchdata(){
		$bankid=$this->input->post('bankid');		
		if($bankid)
		{
			$catArr=$this->helpdesk_executive_model->GetBranchdata($bankid);
			$str='<option value="">Select Bank Branch</option>';
			if(count($catArr)>0){
				foreach($catArr as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$str.='<option '.$selected.' value="'.$row->id.'">'.$row->name.'</option>';
		
				}
			}
		echo $str;
		}
		
	}
	
	function showBankUserListdata(){
		$bankid=$this->input->post('bankid');		
		if($bankid)
		{
			$banksUsersList	 =	 $this->helpdesk_executive_model->getUserByBankId($bankid);			
			$str='<option value="">Select</option>';
			if(count($banksUsersList)>0){
				foreach($banksUsersList as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$option = $row->email_id.", ".$row->user_id.", ".ucfirst($row->first_name)." ".$row->last_name;
					$str.='<option '.$selected.' value="'.$row->id.'">'.$option.'</option>';
		
				}
			}
			echo $str;
		}
		
	}
	
	function showBankUserListdata1(){
		$bankid=$this->input->post('bankid');		
		if($bankid)
		{
			$banksUsersList					=	 $this->helpdesk_executive_model->getUserByBankId($bankid);			
			$str='';
			if(count($banksUsersList)>0){
				foreach($banksUsersList as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$option = $row->email_id.", ".$row->user_id.", ".ucfirst($row->first_name)." ".$row->last_name;
					$str.='<option '.$selected.' value="'.$row->id.'">'.$option.'</option>';
		
				}
			}
		echo $str;
		}
		
	}
	
	function showsubcategorydata(){
		$category=$this->input->post('category');
		$subcate=$this->input->post('subcate');
		if($category)
		{
			$catArr=$this->helpdesk_executive_model->GetsubCategorydata($category);
			$str='<option value="">Select Sub Category</option>';
			if(count($catArr)>0){
				foreach($catArr as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$str.='<option '.$selected.' value="'.$row->id.'">'.$row->name.'</option>';
		
				}
			}
		echo $str;
		}
		
	}
	
}
?>
