<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account extends WS_Controller{
	
	public function __Construct()
	{       
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('log4php');
		log_error('my_error');
		log_info('my_info');
		log_debug('my_debug');
		//error_reporting(0);
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('Datatables');
		$this->load->library('table');
		$this->load->database();
		$this->load->helper(array('form'));
		$this->load->model('account_model');
		$this->check_isvalidated();
		$this->account_model->completedAuctionScript();
	}	
	/* check account user sign in */
	private function check_isvalidated(){
		checkloginUserstatus($this->session->userdata('id'),'user');
        if(!$this->session->userdata('id') OR $this->session->userdata('user_type')!='account'){
          redirect('/registration/logout');
        }
				
    }	
	/* Show dashboard property "Display MIS - Sales Executive",Display MIS - Bank,Display MIS - Zone,Display Month Wise Payment Status  ---Start Code-----*/
	public function index()
	{
		$this->dashboard();
	}	
	
	
	public function dashboard()
	{    
		$todaydata=$this->account_model->dashboardData('today');
		$tillDatedata=$this->account_model->dashboardData('tillDate');
		$weekdata=$this->account_model->dashboardData('week');
		$monthdata=$this->account_model->dashboardData('month');
		if(isset($_POST['misSalesExxecutive'])){$misSalesExxecutive_id=$_POST['misSalesExxecutive'];}else{$misSalesExxecutive_id=0;}
		if(isset($_POST['misSalesExxecutive_bank'])){$misSalesExxecutive_id_bank=$_POST['misSalesExxecutive_bank'];}else{$misSalesExxecutive_id_bank=0;}
		$data['tillDatedata']=$tillDatedata;		
		$data['todaydata']=$todaydata;		
		$data['weekdata']=$weekdata;		
		$data['monthdata']=$monthdata;
			
		$data['salesdata'] = $this->account_model->salesExecutiveData($misSalesExxecutive_id);
        $data['misdata'] = $this->account_model->misdata($misSalesExxecutive_id_bank); //COMMENT DUE TO LOAD
		//$data['zonedata'] = $this->account_model->zoneData(); //COMMENT DUE TO LOAD
		$this->account_header();
		$data['controller']='account';

        $this->load->view('account_view/account_dashboard',$data);
		$this->executive_footer();
	}
	
	public function dashboardAjax()
	{
		$start_date=$this->input->post('startDate');
		$end_date=$this->input->post('endDate');
		$monthdata=$this->account_model->dashboardData('	select',$start_date,$end_date);
		echo json_encode($monthdata);
	}
	
	function displayMISSalesExecutiveDatatable()
	{		 
		echo $this->account_model->displayMISSalesExecutiveDatatable();
	}
	
	function salesExecutiveDataAccnt()
	{		 
		echo $this->account_model->salesExecutiveDataAccnt();
	}
	
	
	function displayMISBankDatatable()
	{		 
		echo $this->account_model->displayMISBankDatatable();
	}
	
	function displayMISZoneDatatable()
	{		 
		echo $this->account_model->displayMISZoneDatatable();
	}
	
	function displayMonthWisePaymentStatusDatatable()
	{		 
		echo $this->account_model->displayMonthWisePaymentStatusDatatable();
	}
	/*end Code*/
	
        public function paymentDuesubmit(){
          	$status=$this->account_model->updateRealization();  
                if($status){
                      echo 'Record Successfully updated';  
                }else{
                  echo 'Server Not Responding Pls Try Again';  
                }
        }
	
	/* account payment Dues data */
	public function paymentDue()
	{
		$submit = $this->input->post('submit');
		if(isset($submit) and !empty($submit))
		{
			$status=$this->account_model->updateRealization();
			if($status){
			 $this->session->set_userdata('user_message','Realization Updated Successfully');  
			 
			}
			redirect('account/paymentDue');	
			die;										
		}
		$data['heading']='Payment Due '; 
		$this->account_header();
		$data['controller']='account';
                
        //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
      //$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
        $this->load->view('account_view/account_paymentDue',$data);
		$this->executive_footer();
	}
	
	function paymentDuedatatable()
	{	
			
		echo $this->account_model->paymentDuedatatable();
	}
	
	function paymentDuedatatableCompleted()
	{	
			
		echo $this->account_model->paymentDuedatatableCompleted();
	}
	/* update Realization Popup */
	function updateRealizationPopup($auctionID){
		
		$data['invoice_data']=$this->account_model->updateRealizationPopupData($auctionID);
		$this->load->view('account_view/account_updateRealizationPopup', $data);
	}
	/* Completed Auction Payment Due */
	public function completedEventPaymentDue()
	{
		$data['heading']='Completed Auction Payment Due'; 
		$this->account_header();
		$data['controller']='account';
    	//$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
        $this->load->view('account_view/account_completedEventPaymentDueList',$data);
		$this->executive_footer();
	}
	function completedEventPaymentDuedatatable()
	{		 
		echo $this->account_model->completedEventPaymentDuedatatable();
	}
	
	/* Add Invoice Detail Data*/
	public function addInvoiceDetail() {
		$data['heading']='Add Invoice Detail';
		$this->account_header();
		$data['controller']='account';
        //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb', $data, true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar', $data, true);
        $this->load->view('account_view/account_addInvoiceDetailList',$data);
		$this->executive_footer();
	}
	public function duplicateInvoice() {
		$data['heading']='Generate Duplicate Invoice';
		$this->account_header();
		$data['controller']='account';
        $data['breadcrumb']=$this->load->view('common/executive_breadcrumb', $data, true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar', $data, true);
        $this->load->view('account_view/account_duplicatenvoiceDetailList.php',$data);
		$this->executive_footer();
	}
	function duplicateaddInvoiceDetailDatatable()
	{		 
		echo $this->account_model->duplicateaddInvoiceDetailDatatable();
	}
	function addInvoiceDetailDatatable()
	{		 
		echo $this->account_model->addInvoiceDetailDatatable();
	}
	/* generate Invoice of Add Invoice Detail Data*/ 
	function generateInvoice($auctionID)
	{
		$data['heading']='Generate Invoice';
		$data['auction_data']=$this->account_model->viewReport($auctionID);
               // echo '<pre>';
               // print_r($data['auction_data']); die();
		$data['invoice_data']=$this->account_model->generateInvoice($auctionID);
		
		$this->account_header();		
		$data['controller']='account';
		//$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
		$data['breadcrumb']='';
		$data['account_leftsidebar']='';
		$data['invoice']=$this->account_model->getInvoicePdfEntry($auctionID);
        
        $this->load->view('account_view/account_Invoice', $data);
		$this->executive_footer();
	}
	/* End Invoice mail */ 
	public function invoiceMailTo($auctionID)
	{
		$submit = $this->input->post('submit');
		if(isset($submit) and !empty($submit))
		{
				$this->account_model->invoiceMailTo1();
				redirect('account/paymentDue');	
		}
		$data['auctionID']=$auctionID;
		$data['auction_data']=$this->account_model->viewReport($auctionID);
		$data['heading']='Invoice MailTo'; 
		$data['allSalesOrAccountsUser']=$this->account_model->allSalesOrAccountsUser();
		$this->account_header();
		$data['controller']='account';
        $data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
        $this->load->view('account_view/account_invoiceMailTo',$data);
		$this->executive_footer();
	}
	/* Payment FollowUp List Data */
	public function paymentFollowUpList()
	{
		$submit = $this->input->post('submit');
		if(isset($submit) and !empty($submit))
		{
				$this->account_model->insertFollowUp();
				die;				
		}
		$data['heading']='Payment FollowUp List'; 
		$this->account_header();
		$data['controller']='account';
       // $data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
        $this->load->view('account_view/account_paymentFollowUpList',$data);
		$this->executive_footer();
	}
	
	function followUpPopup($auctionID){
		$data['auction_data']=$this->account_model->followUpPopupData($auctionID);
		$data['followup_data']=$this->account_model->followUpListPopupData($auctionID);
		$this->load->view('account_view/account_followUPPopup', $data);
	}
	
	function paymentFollowUpListDatatable()
	{		 
		echo $this->account_model->paymentFollowUpListDatatable();
	}
	
	/* Display MIS - Sales Executive (froward To Sales ExecutiveList)*/
	public function frowardToSalesExecutiveList()
	{
		$data['heading']='Forward To Sales Executive List'; 		
		$this->account_header();
		$data['controller']='account';
        //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
		$data['salesdata'] = $this->account_model->frowardToSalesExecutiveListDatatable();
        $this->load->view('account_view/account_frowardToSalesExecutiveListDatatable',$data);
		$this->executive_footer();
	}
	
	function frowardToSalesExecutiveListDatatable()
	{		 
		echo $this->account_model->frowardToSalesExecutiveListDatatable();
	}
	/*Search and show credit NoteList Data */
	public function creditNoteList($id)
	{
		$download = $this->input->get('download');
		if(isset($download) && $download != '')
		{
			$this->account_model->downloadCreditNoteList();die;			
		}
		
		
		$submit = $this->input->post('search');
		$base_credit_note_amount = $this->input->post('base_credit_note_amount');
		if(isset($submit) and !empty($submit))
		{
			$auctionID 	= $this->input->post('auctionID');
			$auth = $this->account_model->insertCreditNote($auctionID);			
			if($auth['auctionData']->id != $auctionID)
			{
				$data['msg']='Event ID not found.';	
			}
			else if($auth['invoice']->auctionID != $auctionID)
			{
				$data['msg']='Invoice has been not generated.';
			}
			else if($auth['creditnote']->verified == 2)
			{
				$data['msg']='Credit Note has been sent for Approval.';
			}
			else if($auth['creditnote']->verified == 1)
			{
				$data['msg']='Credit Note has been generated.';
			}
			if($data['msg'] != "")
			{
				//$data['msg']='Invoice not generated or Invoice payment received or already Credit Note generated.';
				$this->session->set_flashdata('msg', $data['msg']);
				redirect('/account/creditNoteList');
			}			
			else
			{ 
                
				redirect('/account/creditNoteList/'.$auctionID);	
			}				
		}
		
		$data['heading']='Credit Note List'; 
		$this->account_header();
		$data['controller']='account';
		
		if($id > 0)
		{
		
			$data = $this->account_model->insertCreditNote($id);
			$data['auctionID']=$id;
			
			$generate = $this->input->post('generate');
			if(($data['creditnote']->verified == 3 || $data['creditnote']->verified == 1) && isset($generate) && $generate != '')
			{
				if(isset($generate) && $generate != '')
				{
					$this->account_model->generateCreditNoteStep2($id);	
					
					$data = $this->account_model->insertCreditNote($id);
					$this->load->view('account_view/credit_note',$data);																	
				}			
			}
			else if(isset($base_credit_note_amount) && $base_credit_note_amount > 0 && $data['creditnote']->verified != 1 && $data['creditnote']->verified != 2 && $data['creditnote']->verified != 3)
			{
				$this->account_model->generateCreditNote($id);				
				$data['msg']='Credit Note has been sent for Approval (EventID: '.$id.').';				
				$this->session->set_flashdata('msg', $data['msg']);				
				redirect('/account/creditNoteList/');
				
			}
			else if($data['creditnote']->verified == 3)
			{
				$creditnoteArr = $this->account_model->getCreditNoteNo($id);
				$data['creditnote']->credit_noteID = $creditnoteArr['no'];
			}			
			
			$data['is_amount_change'] = true;
			//echo $data['creditnote']->verified;die;
			if($data['creditnote']->verified == 3 || $data['creditnote']->verified == 1 || $data['creditnote']->verified == 2)
			{
				$data['is_amount_change'] = false;
			}
			
			if($data['creditnote']->verified != 1)
			{
				$this->load->view('account_view/account_credit_not_step_1',$data);				
			}
			
				
			
		}
		else
		{
			$this->load->view('account_view/account_credit_not_step_1',$data);
			$this->load->view('account_view/account_creditNoteList',$data);
		}
		
		$this->executive_footer();
	}
	
	function creditNoteListDatatable()
	{		 
		echo $this->account_model->creditNoteListDatatable();
	}
	
	/* Searching account data*/
	public function search()
	{
		$data=array();
		$submit = $this->input->post('submit');
		$data['first_time'] = 0;
		if(isset($submit) and !empty($submit))
		{
			$search=array();
			$search_string='';
			$search['bank']=$this->input->post('bank');
			$search['salesExecutive']=$this->input->post('salesExecutive');
			$search['zone']=$this->input->post('zone');
			$search['status']=$this->input->post('status');
			$search['invoiceRasied']=$this->input->post('invoiceRasied');
			$search['paymentRecieved']=$this->input->post('paymentRecieved');
			$search['auctionID']=$this->input->post('auctionID');
			
			if(!empty($search['bank'])){
				$search_string.='bank='.$search['bank'].'&';
				$data['first_time'] = 1;
			}
			
			if(!empty($search['salesExecutive'])){
				$search_string.='salesExecutive='.$search['salesExecutive'].'&';
				$data['first_time'] = 1;	
			}
			
			if(!empty($search['zone'])){
				$search_string.='zone='.$search['zone'].'&';
			}					
			
			if(isset($search['status'])){
				$search_string.='status='.$search['status'].'&';
				$data['first_time'] = 1;
			}					
			
			if(isset($_POST['invoiceRasied'])){
				$search_string.='invoiceRasied='.$search['invoiceRasied'].'&';
				$data['first_time'] = 1;
			}	
				
			if(isset($search['paymentRecieved'])){
				$search_string.='paymentRecieved='.$search['paymentRecieved'].'&';
				$data['first_time'] = 1;
			}
			
			if(!empty($search['auctionID'])){
				$search_string.='auctionID='.$search['auctionID'].'&';
				$data['first_time'] = 1;
			}
                        $search['search_string']=$search_string;
			$data['search_data']=$search;		
		}
		$data['heading']='Search '; 
		$data['bank_records']=$this->account_model->allBankRecords();
		$data['sales_ex']=$this->account_model->allSales_ex();
		$data['c1zone']=$this->account_model->allc1zone();
		$this->account_header();
		$data['controller']='account';
        //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
        $this->load->view('account_view/account_search',$data);
		$this->executive_footer();
	}
	
	function searchDatatable()
	{		 
		echo $this->account_model->searchDatatable();
	}
	
	function replaceComma($field)
	{		 
		return str_replace(',',' ',$field);
	}
	
	function invoiceSearch(){
		$submit = $this->input->post('submit');
		if($submit=='Search'){	
		}
		
		
	}
	
	
	public function completeMISReport()
	{
		$submit = $this->input->post('submit');
		if(isset($submit) and !empty($submit))
		{
				if($this->input->post('start_date') && $this->input->post('end_date'))
				$reportData=$this->account_model->completeMISReportData();
				else
				$reportData='';
				
				if(!empty($reportData))
				{
				header('Content-type: text/csv');
				header('Content-disposition: attachment;filename=misreport.csv');
				echo "Auctionid,NITRefNo,EventType,AuctionEndDate,Status,BankID,BankName,BranchID,BranchName,Address1,Address2,UserID,FirstName,LastName, MobileNo, Designation ,InvoiceNo , InvoiceDate, InvoicedAmount, PaymentDate, PaymentRecivedAmount, CreatedBy, State, CityName, PublishedDate, BidderCount, BorrowerName".PHP_EOL;
				//echo "1,1,XXXX,YYYYYYY,10,700,7000".PHP_EOL;
				foreach($reportData as $row)
				{
					echo $row->id .','.$row->reference_no .','.$row->type .','.$row->auction_end_date .','.$row->status .','.$row->bank_id .','.$this->replaceComma($row->bank_name) .','.$row->branch_id .','.$this->replaceComma($row->branch_name) .','.$this->replaceComma($row->address1) .','.$this->replaceComma($row->address2) .','.$row->user_id .','.$row->first_name .','.$row->last_name.','.$row->mobile_no .','.$row->designation .','.$row->invoiceNo .','.$row->invoiceDate .','.$row->amount .','.$row->realizationDate .','.$row->realizationAmount .','.$row->created_by .','.$row->state .','.$row->city .',' .$row->indate .','.$row->total_bidder .','.$row->borrower_name .PHP_EOL;
				}
				die;
														

				}
							
								
		}	
		
		$data['heading']='Complete MIS Report'; 
		
		$this->account_header();
		
		$data['controller']='account';
        //set table id in table open tag
        
		//$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
                $this->load->view('account_view/account_completeMISReport',$data);
		$this->executive_footer();
	}
	
	/*Account update Payment  with Search Criteria*/
	public function updatePayment()
	{
		//echo $this->session->userdata('id');
		//OR $this->session->userdata('user_type')!='account';
		
		$submit = $this->input->post('submit');
		if(isset($submit) and !empty($submit))
		{	
				$this->account_model->updateRealization();
				$auctionID=$this->input->post('auctionID');
				$msg="Amount has been updated successfully!";
				$this->session->set_flashdata('msg',$msg);
				redirect('account/updatePayment?auctionID='.$auctionID.'&serach=Search');	
				die;										
		}
		$serach = $this->input->get('serach');
		if(isset($serach) and !empty($serach))
		{
			$auctionID = $this->input->get('auctionID');
			$data['auctionID']=$auctionID;
			$data['invoice_data']=$this->account_model->updateRealizationPopupData($auctionID);	
            $data['tax']=$this->account_model->fetchTax($auctionID);	
            
           // print_r($data['tax']);
		}
		$data['heading']='Update Payment'; 
		$this->account_header();
		$data['controller']='account';
       // $data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
        $this->load->view('account_view/account_updatePayment',$data);
		$this->executive_footer();
	}
	
	/* invoice Report Search and showdata*/
	public function invoiceReport()
	{
		$submit = $this->input->post('submit');		
		$data['heading']='Invoice Report'; 
		$this->account_header();
		$data['controller']='account';
        //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['account_leftsidebar']=$this->load->view('account_view/account_left_bar',$data,true);
		if(isset($submit) and !empty($submit))
		{	// echo '<pre/>';
			//if($this->input->post('start_date') && $this->input->post('end_date'))
			
			$invoideSearchData=$this->account_model->getInvoiceReportData();
                        //print_r($invoideSearchData); die();
			$invoiceSearchData['invoiceData']=$invoideSearchData;
			$invoiceSearchData['controller']='account';
			
			
			$invoicedata=$this->load->view('account_view/invoiceReport',$invoiceSearchData,true);
							
		}else{
			$invoicedata='';
		}
		
		$data['invoicedata']=$invoicedata; 
        $this->load->view('account_view/account_invoiceReport',$data);
		$this->executive_footer();
	}
	
	public function invoiceXls()
	{
		$data['heading']='Invoice Excel'; 
		$this->account_header();
		$data['controller']='account';
        $this->load->view('account_view/invoiceXls',$data);
		$this->executive_footer();
	}
	
	function invoiceGenerateReport(){
		$this->account_model->invoiceGenerateReport();
	}
	
	/* Show sales executive popup (Display MIS - Sales Executive) */
	function displaySalesExecutiveAccountData($sales_executive_id)
	{	
		$pid = $this->input->get('m', TRUE);	 
		echo $this->account_model->displaySalesExecutiveAccountData($sales_executive_id,$pid);
	}
	/* Show MIS - Bank popup (Display MIS - Bank) */
	public function salesExecutiveAccountData($sales_executive_id){
	    $data['sales_executive_id'] = $sales_executive_id;
		$data['controller']='account';
		$this->account_header();
		$this->load->view('account_view/salesExecutiveAccountData',$data);
		$this->executive_footer();
	}
	
	function displayMisBankData($bank_id)
	{		 
		echo $this->account_model->displayMisBankData($bank_id);
	}
	/* Display MIS - Bank popup (Display MIS - Bank) */
	public function misBankData($bank_id){
		$data['bank_id'] = $bank_id;
		$data['controller']='account';
		$this->account_header();
		if(isset($_POST['misSalesExxecutive'])){$misSalesExxecutive_id=$_POST['misSalesExxecutive'];}else{$misSalesExxecutive_id=0;}
		$data['misbankdata'] = $this->account_model->misBankData($bank_id,$misSalesExxecutive_id);
		
		$this->load->view('account_view/misBankData',$data);
		$this->executive_footer();
	}
	
	public function misBankBranchData($branch_id,$bank_id){
		$data['branch_id'] = $branch_id;
		$data['bank_id'] = $bank_id;
		$data['controller']='account';
		$this->account_header();
		$data['misbankbranchdata'] = $this->account_model->misBankBranchData($branch_id);
		$this->load->view('account_view/misBankBranchData',$data);
		$this->executive_footer();
	}
	/* Display MIS - Zone popup (Display MIS - Zone) */
	public function zoneWiseData($zone_id){
		$data['zone_id'] = $zone_id;
		$data['controller']='account';
		$data['zonewisedata'] = $this->account_model->zoneWiseData($zone_id);
		$this->load->view('account_view/zoneWiseData',$data);
	}
	
	function paymentdataAjax()
	{		 
		$payment_data = $this->account_model->paymentdata();
		$payment_collection_data = $this->account_model->paymentdata_collection();
		if(count($payment_data)>0 && $payment_data[0]->invoiced!=''){
			foreach($payment_data as $pdata){
				$html='<td>'.(int)$pdata->invoiced.'</td>
				<td align="right">'.number_format($pdata->invoicedAmt,2,".",",").'</td>
				<td>'.(int)$payment_collection_data [0]->collected.'</td>
				<td align="right">'.number_format($payment_collection_data[0]->collectedAmt,2,".",",").'</td>';
			}
		}else{
			$html = '<td colspan="4">No Record Found</td>';
		}
		echo $html;
	}
	
	function on_paymentdataAjax()
	{		 
		$payment_data = $this->account_model->onAccount_paymentdata();
		$payment_collection_data = $this->account_model->paymentdata_collection();
		if(count($payment_data)>0){
			foreach($payment_data as $pdata){
				$html='<td align="right">'.number_format($payment_collection_data[0]->collectedAmt+$pdata->remaining,2,".",",").'</td>
				<td align="right">'.number_format($pdata->amount,2,".",",").'</td>
				<td align="right">'.number_format($pdata->settled,2,".",",").'</td>
				<td align="right">'.number_format($pdata->remaining,2,".",",").'</td>';
			}
		}else{
			$html = '<td colspan="4">No Record Found</td>';
		}
		echo $html;
	}	
	
	public function updatecreditnote($id){
		$str = $this->account_model->updatecreditnote($id);
		redirect('/account/creditNoteList/');
	}
	
	public function completeMonthEndReport()
	{
		$submit = $this->input->post('submit');
		if(isset($submit) and !empty($submit))
		{
				//if($this->input->post('start_date') && $this->input->post('end_date'))
				//$reportData=$this->account_model->completeMonthEndReportData();
				//else
				//$reportData='';
				
				/*if(!empty($reportData))
				{
						header('Content-type: text/csv');
						header('Content-disposition: attachment;filename=misreport.csv');
						echo "Auctionid,NITRefNo,EventType,AuctionEndDate,Status,BankID,BankName,BranchID,BranchName,Address1,Address2,UserID,FirstName,LastName, MobileNo, Designation ,InvoiceNo , InvoiceDate, InvoicedAmount, PaymentDate, PaymentRecivedAmount, CreatedBy, State, CityName, PublishedDate, BidderCount, BorrowerName".PHP_EOL;
						//echo "1,1,XXXX,YYYYYYY,10,700,7000".PHP_EOL;
						foreach($reportData as $row)
						{
							echo $row->id .','.$row->reference_no .','.$row->type .','.$row->auction_end_date .','.$row->status .','.$row->bank_id .','.$this->replaceComma($row->bank_name) .','.$row->branch_id .','.$this->replaceComma($row->branch_name) .','.$this->replaceComma($row->address1) .','.$this->replaceComma($row->address2) .','.$row->user_id .','.$row->first_name .','.$row->last_name.','.$row->mobile_no .','.$row->designation .','.$row->invoiceNo .','.$row->invoiceDate .','.$row->amount .','.$row->realizationDate .','.$row->realizationAmount .','.$row->created_by .','.$row->state .','.$row->city .',' .$row->indate .','.$row->total_bidder .','.$row->borrower_name .PHP_EOL;
						}
						die;
				}	*/				
		}	
		$data['heading']='Complete Month End Report'; 
		$this->account_header();
		
		$data['controller']='account';
		$this->load->view('account_view/completeMonthEndReport',$data);
		$this->executive_footer();
	}
}
?>
