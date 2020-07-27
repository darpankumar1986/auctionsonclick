<?php
class Mis_model extends CI_Model {
	private $path = 'public/uploads/bank/';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	function displayMISSalesExecutiveDatatable()
	{	
		 $this->datatables->select("concat(USR.first_name,' ',USR.last_name) as uname , USR.c1zone , sum(AUC.status != '0' and AUC.status != '2' ) as published, sum(AUC.status = '7') as concluded, sum(AUC.status = '3' OR AUC.status = '4') as cancel, sum(AUC.status = '1' AND AUC.auction_end_date < CURDATE()) as lives",false)
	     ->where('USR.user_type','sales')
	     ->where('USR.status','1')
	    //->unset_column('tur.id')
	     ->from('tbl_user_registration as USR')
	     ->join('tbl_event_log_sales SAL','SAL.sales_executive_id = USR.id','left ')
	     ->join('tbl_auction AUC','AUC.eventID=SAL.id','left ');
	     $this->db->group_by('SAL.sales_executive_id');
	     $this->db->group_by('USR.id');
	   
	   
        return $this->datatables->generate();
		 
	}
	function displayMISBankDatatable()
	{		 
		
        $this->datatables->select("tb.name,(select count(id) from tbl_auction as ta where  ta.bank_id=tb.id and ta.status !=0 and ta.status !=2) as publishedAuction ,(select count(id) from tbl_auction as ta where  ta.bank_id=tb.id and ta.status =7) as concludeAuction ,(select count(id) from tbl_auction as ta where  ta.bank_id=tb.id and (ta.status =4 OR ta.status =3)) as cancelAuction ,(select count(id) from tbl_auction as ta where  ta.bank_id=tb.id and ta.status =1 and ta.auction_end_date < CURDATE()) as liveAuction ,(select count(id) from tbl_auction as ta where  ta.bank_id=tb.id and ta.is_invoice_generated =1 ) as invoicedAuction,(select count(id) from tbl_auction as ta where  ta.bank_id=tb.id and ta.is_payment_recived =1 ) as paidAuction",false)
       ->from('tbl_bank as tb');
	   //->join('tbl_event_log_sales as tels','tur.id=tels.sales_executive_id','left ');
	   //$this->db->group_by('tur.id');
	   
	   
        return $this->datatables->generate();
	}
	function displayMISZoneDatatable()
	{		 
		 $this->datatables->select(" USR.c1zone , sum(AUC.status != '0' and AUC.status != '2' ) as published, sum(AUC.status = '7') as concluded, sum(AUC.status = '3' OR AUC.status = '4') as cancel, sum(AUC.status = '1' AND AUC.auction_end_date < CURDATE()) as lives",false)
	     ->where('USR.user_type','sales')
	     ->where('USR.status','1')
	    //->unset_column('tur.id')
	     ->from('tbl_user_registration as USR')
	     ->join('tbl_event_log_sales SAL','SAL.sales_executive_id = USR.id','left ')
	     ->join('tbl_auction AUC','AUC.eventID=SAL.id','left ');
	     $this->db->group_by('SAL.sales_executive_id');
	     $this->db->group_by('USR.c1zone');
	   
	   
        return $this->datatables->generate();
	}
	function displayMonthWisePaymentStatusDatatable()
	{		
		$this->db->query("SET @row = 0",false); 
         $this->datatables->select(" @row := @row + 1 as SNo,sum(status = '1') as invoiced,sum(amount) as invoicedAmt,sum(realizationAmount != '0') as collected,sum(realizationAmount) as collectedAmt",false)
		
        ->from('tbl_event_invoice as tei');
        return $this->datatables->generate();
		 
	}
   function paymentDuedatatable()
    {	
		$this->db->query("SET @row = 0",false); 
         $this->datatables->select(" @row := @row + 1 as SNo,ta.id,tei.invoiceNo, ta.event_title, CONCAT(tb.name ,' ','(',tbr.name  ,' )') as bank_branch_name,  ta.indate as auction_start_date,ta.auction_end_date",false)
		->add_column('Actions', "<a  class='updateRealization_iframe' href='/mis/updateRealizationPopup/$1'>Update Realization</a>", 'ta.id')
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->where('ta.is_invoice_generated',1)
		->where('ta.is_payment_recived ',0);
        return $this->datatables->generate();
    }
	
	function updateRealizationPopupData($auctionID)
	{
		
		$this->db->where('auctionID', $auctionID);
		$query_invoice = $this->db->get("tbl_event_invoice");
		$data=$query_invoice->result();
		
		$this->db->select('reference_no,branch_id');
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction");
		$data[0]->auction=$query_auction->result();
		return $data; 
	}
	
	function updateRealization()
	{
		
		$auctionID 	= $this->input->post('auctionID');
		$realizationAmount 	= $this->input->post('realizationAmount');
		$realizationDate 	= $this->input->post('realizationDate');
		//$created_by	= $this->session->userdata['id'];
		$data = array(
					'realizationDate'=>$realizationDate,
					'realizationAmount'=>$realizationAmount);
		
			$this->db->where('auctionID', $auctionID);
			$this->db->update('tbl_event_invoice',$data);
			
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction',array('is_payment_recived'=>1));	
		
	}
	function invoiceMailTo()
	{
		
		$auctionID 	= $this->input->post('auctionID');
		$mailTo 	= $this->input->post('mailTo');
		//$realizationDate 	= $this->input->post('realizationDate');
		//$created_by	= $this->session->userdata['id'];
		$mail_id=implode(',',$mailTo );
		$tender_no	=	GetTitleByField('tbl_auction', "id='".$auctionID."'", 'tender_no');
		$email_msg ="Hi  ,<br> Invoice for Auction ".$tender_no ."<br>"."<a href='".site_url()."/pdfdata/generateAccountInvoicePdf/$auctionID'>Download Invoice</a>";
		$fromemail = "info@c1indiabankeauction.com";
		$mailsubject = $reference_no." Invoice By C1india";
        $to = $mail_id;
		$headers  = "From: $fromemail\r\n";
		$headers .= "Content-type: text/html\r\n";
		//echo $mailsubject;
		
		mail($to, $mailsubject, $email_msg, $headers);	
		//$this->db->where('id', $auctionID);
		//$this->db->update('tbl_auction',array('is_payment_recived'=>1));	
		
	}
   function completedEventPaymentDuedatatable()
    {	
       $this->db->query("SET @row = 0",false); 
         $this->datatables->select(" @row := @row + 1 as SNo,ta.id,tei.invoiceNo, ta.event_title, CONCAT(tb.name ,' ','(',tbr.name  ,' )') as bank_branch_name,  ta.auction_start_date,ta.auction_end_date",false)
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->where('ta.is_invoice_generated',1)
		->where('ta.is_payment_recived ',0);
        return $this->datatables->generate();
    }
   function searchDatatable()
    {	
	
		$bank_id        =$this->input->get('bank');
		$salesExecutive =$this->input->get('salesExecutive');
		$zone           =$this->input->get('zone');
		$status         =$this->input->get('status');
		$invoiceRasied  =$this->input->get('invoiceRasied');
		$paymentRecieved=$this->input->get('paymentRecieved');
		$auctionID      =$this->input->get('auctionID');
		
		
        $this->db->query("SET @row = 0",false); 
        $this->datatables->select(" @row := @row + 1 as SNo,ta.id,  CONCAT(tb.name ,' ','(',tbr.name  ,' )') as bank_branch_name, ta.reference_no ,IF(tei.invoiceNo != NULL,tei.invoiceNo,'NA') as invoiceNo ,  IF(ta.is_payment_recived = '1','Yes','No') as  payment_recived,tur.first_name,  CASE ta.status
      WHEN 0 THEN 'Saved'
      WHEN 1 THEN 'Published'
      WHEN 3 THEN 'Stay'
      WHEN 4 THEN 'Cancel'
      WHEN 6 THEN 'Completed'
      WHEN 7 THEN 'Conclude'
      ELSE 'Published'
      END AS status ,  ta.indate",false)
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_log_sales as tesl','ta.eventID=tesl.id','left ')
		->join('tbl_user_registration as tur','tur.id=tesl.sales_executive_id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ');
		if($bank_id)$this->datatables->where('ta.bank_id',$bank_id);
		
		if(isset($paymentRecieved) && $paymentRecieved != '')$this->datatables->where('ta.is_payment_recived',$paymentRecieved);
		if(isset($invoiceRasied) && $invoiceRasied != '')$this->datatables->where('ta.is_invoice_generated',$invoiceRasied);
		if($auctionID)$this->datatables->where('ta.id',$auctionID);
		if($status==1)$this->datatables->where('ta.status IN(1,3,4,6,7)');
		if($status==6)$this->datatables->where('ta.status IN(6,7)');
		//$this->datatables->generate();
		//echo $this->db->last_query();die;
        return $this->datatables->generate();
    }
   function addInvoiceDetailDatatable()
    {	
        $this->datatables->select(" ta.id,ta.reference_no,tb.name as bank_name, tbr.name as branch_name, ta.auction_start_date,ta.auction_end_date",false)
		->add_column('Actions', "<a  href='/account/generateInvoice/$1'>Generate Invoice</a>", 'ta.id')
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->where('(ta.auction_end_date < CURDATE()  or ta.status= 4 OR ta.status= 6 OR ta.status= 7)')
		->where('ta.auction_type is NULL || ta.auction_type=0');
		//->where('ta.is_invoice_generated !=',1);
        return $this->datatables->generate();
    }
   
   function paymentFollowUpListDatatable()
    {	
	//,(select count(id) from tbl_follow_up where tbl_follow_up.auctionID= ta.id and tbl_follow_up.forwardedToSales=1 ) as forwarded HAVING `forwarded` =0
       $this->db->query("SET @row = 0",false); 
         $this->datatables->select(" @row := @row + 1 as SNo,ta.id, ta.reference_no, tei.invoiceNo,tei.amount, tei.invoiceDate, ta.status,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id ) as total_bidder, (select count(tfu.id) from tbl_follow_up tfu where tfu.auctionID= ta.id ) as total_follow, (select remarks from tbl_follow_up where tbl_follow_up.auctionID= ta.id order by id desc limit 1) as remarks ,(select count(id) from tbl_follow_up where tbl_follow_up.auctionID= ta.id and tbl_follow_up.forwardedToSales=1 ) as forwarded",false)
		->add_column('Actions', "<a  class='followUpNote_iframe' href='/account/followUpPopup/$1'>Folloup Note</a>", 'ta.id')
		->unset_column('forwarded')
        ->from('tbl_auction as ta')
		
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')
		
		->where('ta.is_invoice_generated',1)		
		->where('ta.is_payment_recived = 0');
		$this->db->having('forwarded = 0'); 
        return $this->datatables->generate();
    }
    function followUpPopupData($auctionID)
    {	
		
		//$this->db->select('reference_no,branch_id');
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction");
		$data=$query_auction->result();
		return $data; 
    }
    function followUpListPopupData($auctionID)
    {	
		
		//$this->db->select('reference_no,branch_id');
		$this->db->where('auctionID', $auctionID);
		$query_auction = $this->db->get("tbl_follow_up");
		$data=array();
		foreach($query_auction->result() as $row){
		$data[]=$row;
		}
		return $data; 
    }
    function insertFollowUp()
    {	
		$auctionID 	= $this->input->post('auctionID');
		$status 	= $this->input->post('status');
		$remarks 	= $this->input->post('remarks');
		$nextFollow 	= $this->input->post('nextFollow');
		$froward 	= $this->input->post('froward');
		$eventID 	= $this->input->post('eventID');
		$created_by	= $this->session->userdata['id'];
		
		$indate=date('Y-m-d H:i:s');
		$data = array(
					'auctionID'=>$auctionID,
					'eventID'=>$eventID,
					'status'=>$status,
					'remarks'=>$remarks,
					'followUp'=>$nextFollow,
					'indate'=>$indate,
					'user_id'=>$created_by,
					'forwardedToSales'=>$froward);
			$this->db->insert('tbl_follow_up',$data);
    }
	function insertCreditNote()
    {	
		$auctionID 	= $this->input->post('auctionID');
		$amount 	= $this->input->post('amount');
		//$created_by	= $this->session->userdata['id'];
		
		$this->db->select('id');
		$this->db->where('auctionID', $auctionID);
		$query = $this->db->get("tbl_auction_credit_note");
		$credit_note_data=$query->result();
		if($query->num_rows()>0) return false;
		
		$this->db->select('id');
		$this->db->where('auctionID', $auctionID);
		$query = $this->db->get("tbl_event_invoice");
		if($query->num_rows()==0) return false;		
		
		
		$this->db->select('bank_id,branch_id,');
		$this->db->where('id', $auctionID);
		$query = $this->db->get("tbl_auction");
		$auction_data=$query->result();
		$branch_id =$auction_data[0]->branch_id;
		$bank_id =$auction_data[0]->bank_id;
		$bank_name= GetTitleByField('tbl_bank',"id=$bank_id",'name');
		
		if($auction_data[0]->is_payment_recived) return false;
		
		$this->db->select('stax,educess,secondaryhighertax');
		$this->db->where('id', $branch_id);
		$query = $this->db->get("tbl_branch");
		$branch_data=$query->result();
		
		$service_tax=$amount*$branch_data[0]->stax/100;
		$educationalCess=$amount*$branch_data[0]->educess/100;
		$secondaryCess=$amount*$branch_data[0]->secondaryhighertax/100;
		$grandTotal=$amount+$service_tax+$educationalCess+$secondaryCess;
		
		$indate=date('Y-m-d H:i:s');
		$data = array(
					'auctionID'=>$auctionID,
					'amount'=>$amount,
					'service_tax'=>$service_tax,
					'educationalCess'=>$educationalCess,
					'secondaryCess'=>$secondaryCess,
					'grandTotal'=>$grandTotal,
					'remark'=>$remark,
					'indate'=>$indate,
					'verified'=>1,
					'status'=>1);
			$this->db->insert('tbl_auction_credit_note',$data);
			$id=$this->db->insert_id();
			$creditNo= 'CN\E-AUCTION\ ' .date('Y')."\ $bank_name\ $id";
			$this->db->where('id', $id);
			$this->db->update('tbl_auction_credit_note', array('credit_noteID'=>"$creditNo"));
		return true;
    }
   function frowardToSalesExecutiveListDatatable()
    {	
	 $this->db->query("SET @row = 0",false); 
         $this->datatables->select(" @row := @row + 1 as SNo,ta.id, ta.reference_no, tei.invoiceNo,tei.amount, tei.invoiceDate, ta.status,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id ) as total_bidder, (select count(id) from tbl_follow_up where tbl_follow_up.auctionID= ta.id and tbl_follow_up.forwardedToSales=1 ) as forwarded",false)
		->add_column('Actions', "<a  class='followUpNote_iframe' href='/account/followUpPopup/$1'>Folloup Note</a>", 'ta.id')
		->unset_column('forwarded')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')
		->where('ta.is_invoice_generated',1)		
		->where('ta.is_payment_recived = 0');
		$this->db->having('forwarded = 1'); 
        return $this->datatables->generate();
    }
    function approvedCreditNote()
    {
		$eventID =  $this->input->get('eventID');
		$status =  $this->input->get('status');
		$remark =  $this->input->get('remark');
		
		$userid = $this->session->userdata('id');
		
		$this->db->where("auctionID",$eventID);
		$this->db->where("approval",$userid);
		$results = $this->db->get('tbl_auction_credit_note');
		if($results->num_rows() > 0)
		{		
			$cdata = array(         
							'approvalBy'=>$userid,
							'approvalRemark'=>$remark,
							'ApprovalStatus'=>$status	
						);
			if($status == 'accepted')
			{		
				$cdata['verified'] = 3;			
			}
			else
			{
				$cdata['verified'] = 4;			
			}
			$this->db->where("auctionID",$eventID);
			$this->db->update('tbl_auction_credit_note',$cdata);
		}
	}
	
   function creditNoteListDatatable()
    {	
        
        $approved 	= $this->input->get('approved');
		$userID = $this->session->userdata('id');
		
		if($approved > 0)
		{
			$this->datatables->select("ta.id, tei.invoiceNo,tei.invoiceDate,tei.grandTotal as amount,tacn.credit_noteID,tacn.grandTotal as camount,tacn.indate,tacn.document",false);
		}
		else
		{
			$this->datatables->select("
										ta.id, 
										tei.invoiceNo,
										tei.invoiceDate,
										tei.grandTotal as amount,
										tacn.grandTotal as camount,
										CONCAT(u.first_name,' ',u.last_name) as createdby,
										tacn.remark,
										'' as abc,
										'' as bcd,
										'' as cdf",false);
		}

        $this->db->from('tbl_auction_credit_note as tacn')
		->join('tbl_event_invoice as tei','tacn.auctionID=tei.auctionID','left ')
		->join('tbl_user_registration as u','tacn.createdby=u.id','left ')
		->join('tbl_auction as ta','ta.id=tacn.auctionID');
		
		if($approved > 0)
		{
			$this->db->where("tacn.verified","1");
		}
		else
		{
			$this->db->where("tacn.verified = 2");
			$this->db->where("tacn.approval",$userID);
		}

        return $this->datatables->generate();
    }
   
	
	
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	function allBankRecords()
	{
		$this->db->where('status',1);
		$query = $this->db->get("tbl_bank");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	function allSales_ex()
	{
		$this->db->where('status',1);
		$this->db->where('user_type','sales');
		$query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	function allc1zone()
	{
		$this->db->where('status',1);
		$query = $this->db->get("tbl_c1zone");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	function viewReport($auction_id)
	{
		//$this->db->select('id, event_title, event_type, auction_start_date, auction_end_date, related_doc, first_opener, second_opener');
		//$this->db->select('id, bank_id,branch_id,invoice_mail_to');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			$this->db->select('stax, educess,secondaryhighertax,agreementnodate');
			$this->db->where('id', $data[0]->branch_id);
			$query_branch = $this->db->get("tbl_branch");
			$data_branch=$query_branch->result();
			$data[0]->stax=$data_branch[0]->stax;
			$data[0]->educess=$data_branch[0]->educess;
			$data[0]->secondaryhighertax=$data_branch[0]->secondaryhighertax;
			$data[0]->agreementnodate=$data_branch[0]->agreementnodate;
		}
		return $data;
		
     }
	function generateInvoice($auction_id)
	{
		
		$this->db->where('auctionID', $auction_id);
		$query = $this->db->get("tbl_event_invoice");
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else{
			
			//Get Auction Record
			$this->db->select('bank_id,branch_id');
			$this->db->where('id', $auction_id);
			$query = $this->db->get("tbl_auction");
			$auction_data=$query->result();
			$branch_id =$auction_data[0]->branch_id;
			$bank_id =$auction_data[0]->bank_id;
			$bank_name= GetTitleByField('tbl_bank',"id=$bank_id",'name');
			
			//Get Auction successful/unsuccessful
			$this->db->select('count(id) as total ',false);
			$this->db->where('auctionID', $auction_id);
			$this->db->where('status', 1);
			$query = $this->db->get("tbl_auction_participate");
			$no_of_participate=$query->result();
			
			if($no_of_participate[0]->total)
			$amount= GetTitleByField('tbl_branch',"id=$branch_id",'revenueamount');
			else
			$amount= GetTitleByField('tbl_branch',"id=$branch_id",'unsuc_revenueamount');
			$date=date('Y-m-d H:i:s');
			$user_id=$this->session->userdata('id');
			$data=array(
			  'auctionID'=>$auction_id,
			  'indate' =>$date,
			  'amount' =>$amount,
			  'invoiceDate'=>$date,
			  'created_by' =>$user_id,
			  'status' =>'1'
			  );
			$this->db->insert('tbl_event_invoice',$data);
			$id=$this->db->insert_id();
			$invoiceNo= 'Delhi\E-AUCTION\ ' .date('Y')."\ $bank_name\ $id";
			$this->db->where('id', $id);
			$this->db->update('tbl_event_invoice', array('invoiceNo'=>"$invoiceNo"));
			$this->db->where('id', $auction_id);
			$this->db->update('tbl_auction', array('is_invoice_generated'=>1)); 
			$this->db->where('auctionID', $auction_id);
			$query = $this->db->get("tbl_event_invoice");
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}
    }
	function completeMISReportData()
    {	
		$start_date =$this->input->get('start_date');
		$end_date   =$this->input->get('end_date');
        $this->db->select(" ta.id,ta.reference_no,IF(ta.event_type = 'drt','DRT','SARFAESI') as  type,ta.auction_end_date , CASE ta.status
      WHEN 0 THEN 'Saved'
      WHEN 1 THEN 'Published'
      WHEN 3 THEN 'Stay'
      WHEN 4 THEN 'Cancel'
      WHEN 6 THEN 'Completed'
      WHEN 7 THEN 'Conclude'
      ELSE 'Published'
      END AS status , ta.bank_id ,tb.name as bank_name,ta.branch_id , tbr.name as branch_name, tu.address1, tu.address2, tu.user_id, tu.first_name, tu.last_name, tu.mobile_no, tu.designation, tei.invoiceNo, tei.invoiceDate, tei.amount, tei.realizationDate,  tei.realizationAmount, ta.created_by, tp.state, tp.city , ta.indate, (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id ) as total_bidder, ta.borrower_name",false)
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->join('tbl_event_invoice as tei','tei.auctionID=ta.id','left ')
		->join('tbl_user as tu','ta.first_opener=tu.id','left ')
		->join('tbl_product as tp','ta.id=tp.auctionID','left ');
		//$this->db->where('ta.indate  BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
		
    }
	function dashboardData($type='',$start_date='',$end_date='')
	{

		if($type=='today')
		{
				$start_date = date("Y-m-d 00:00:00");
				$end_date = date("Y-m-d 23:59:59");
		}
		else if($type=='week')
		{
				$start_date = date("Y-m-d 00:00:00",strtotime("last sunday"));
				$end_date = date("Y-m-d 23:59:59",strtotime("next saturday"));
		}
		else if($type=='month')
		{
				$start_date = date("Y-m-1 00:00:00");
				$end_date = date("Y-m-t 23:59:59");
		}
		else if($type=='tillDate')
		{
				$start_date = date("2001-01-01 00:00:00");
				$end_date = date("Y-m-t 23:59:59");
		}
		
		
		$this->db->select('count(id) as total ',false);
		$this->db->where_in('status', array(1,3,4,6,7));
		//All published records
		/*if($type=='today')
		{
				$this->db->where('date(updated_date) = date(NOW())');
		}	
		if($type=='week'){
			$this->db->where('date(updated_date) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		}
		
		if($type=='month'){
			$this->db->where('date(updated_date) BETWEEN date(NOW())  - INTERVAL 30 DAY AND date(NOW())');	
		}
		if($type=='select')
		{
			$this->db->where("date(updated_date) BETWEEN '$start_date' AND '$end_date'");
		}*/
		$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$publishedData=$query->result();
		
		//echo $this->db->last_query();
		
		//All published records
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('status ', 7);
		//if($type=='today')$this->db->where('date(updated_date) = date(NOW())');
		//if($type=='week')$this->db->where('date(updated_date) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		//if($type=='month')$this->db->where('date(updated_date) BETWEEN date(NOW())  - INTERVAL 30 DAY AND date(NOW())');
		//if($type=='select')$this->db->where("date(updated_date) BETWEEN '$start_date' AND '$end_date'");
		$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$concludedData=$query->result();
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('status ', 1);
		/*if($type=='today')$this->db->where('date(updated_date) = date(NOW())');
		if($type=='week')$this->db->where('date(updated_date) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		if($type=='month')$this->db->where('date(updated_date) BETWEEN date(NOW())  - INTERVAL 30 DAY AND date(NOW())');
		if($type=='select')$this->db->where("date(updated_date) BETWEEN '$start_date' AND '$end_date'");*/
		$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$inProgressData=$query->result();
		//echo $this->db->last_query();die;
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('(status=3 OR status=4)');
		/*if($type=='today')$this->db->where('date(updated_date) = date(NOW())');
		if($type=='week')$this->db->where('date(updated_date) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		if($type=='month')$this->db->where('date(updated_date) BETWEEN date(NOW()) - INTERVAL 30 DAY AND date(NOW())');
		if($type=='select')$this->db->where("date(updated_date) BETWEEN '$start_date' AND '$end_date'");*/
		$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$cancelStatData=$query->result();
		
		
		
		$this->db->select('count(ev.id) as total,sum(ev.amount) as total_amount',false);
		//$this->db->where('ev.amount > 0');
		/*if($type=='today')$this->db->where('date(invoiceDate) = date(now())');
		if($type=='week')$this->db->where('date(invoiceDate) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		if($type=='month')$this->db->where('date(invoiceDate) BETWEEN date(NOW())  - INTERVAL 30 DAY AND date(NOW())');
		if($type=='select')$this->db->where("date(invoiceDate) BETWEEN '$start_date' AND '$end_date'");*/
		$this->db->where("date(ev.invoiceDate) BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_event_invoice AS ev");		
		$invoicedData=$query->result();
		
		$this->db->select('count(i.id) as total,sum(i.amount_recived) as total_amount,sum(round(i.amount)+ round(tm.stax*i.amount/100) + round(tm.educess*i.amount/100) + round(tm.secondaryhighertax*i.amount/100) + round(tm.swacchbharat_tax*i.amount/100) ) as invoice_amount',false);
		$this->db->join('tbl_taxmaster as tm','tm.start_date <= i.invoiceDate and tm.end_date >= i.invoiceDate');
		/*if($type=='today')$this->db->where('date(realizationDate) = date(NOW())');
		if($type=='week')$this->db->where('date(realizationDate) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		if($type=='month')$this->db->where('date(realizationDate) BETWEEN date(NOW())  - INTERVAL 30 DAY AND date(NOW())');
		if($type=='select')$this->db->where("date(realizationDate) BETWEEN '$start_date' AND '$end_date'");*/
		$this->db->where("date(i.invoiceDate) BETWEEN '$start_date' AND '$end_date'");
		$this->db->where('i.amount_recived > 0');
		$query = $this->db->get("tbl_event_invoice as i");
		$collectionData=$query->result();
	
		$data['allPublished']=$publishedData[0]->total;
		$data['allConcluded']=$concludedData[0]->total;
		$data['allInProgress']=$inProgressData[0]->total;
		$data['allCancelStay']=$cancelStatData[0]->total;
		$data['allInvoiced']=$invoicedData[0]->total;
		$data['allCollection']=$collectionData[0]->total;
		$data['allInvoicedamt']=$collectionData[0]->invoice_amount;
		$data['allCollectionamt']=$collectionData[0]->total_amount;
		return $data;
	
	}
	
	function showMISSummeryData(){
		$sql="SELECT SUM(CASE WHEN a.status = 1 THEN 1 else 0 end) as published,
		SUM(CASE WHEN a.status = 7 THEN 1 else 0 end) as concluded,
		SUM(CASE WHEN a.status = 4 or a.status=3 THEN 1 else 0 end) as cancel,		
		sum(i.amount+ (tm.stax*i.amount/100) + (tm.educess*i.amount/100) + (tm.secondaryhighertax*i.amount/100) + (tm.swacchbharat_tax*i.amount/100) ) as invoiced,
		sum(i.amount_recived) as collection,
		SUM(CASE WHEN a.auction_end_date >= now() AND a.bid_last_date <= now() THEN 1 else 0 end) as InProgress
		from tbl_auction as a left join tbl_event_invoice as i ON i.auctionID=a.id left join tbl_taxmaster as tm ON tm.start_date <= i.invoiceDate and tm.end_date >= i.invoiceDate";
		$query=$this->db->query($sql)->row_object();
		return $query;
	}
	
    function eventLogStatusDatatable()
    {	
        $this->datatables->select("tels.id, 
								tur1.first_name, 
								Case ta.id WHEN ta.id THEN ta.id ELSE 'N/A' END as auctionID, 
								tb.name,  
								IF(ta.id,'Event Created','Event Logged ') as status ,
								CONCAT(tur2.first_name,' ',tur2.last_name,'(',tur2.email_id,')') as sales_cordinator ,
								Case CONCAT(tur.first_name,' ',tur.last_name,'(',tur.email_id,')') WHEN CONCAT(tur.first_name,' ',tur.last_name,'(',tur.email_id,')') THEN CONCAT(tur.first_name,' ',tur.last_name,'(',tur.email_id,')') ELSE 'N/A' END as assigned_user , 
								Case tels.indate WHEN tels.indate THEN tels.indate ELSE 'N/A' END as indate,
								Case tea.indate WHEN tea.indate THEN tea.indate ELSE 'N/A' END as updated_date,
								Case ta.indate WHEN ta.indate THEN ta.indate ELSE 'N/A' END as aindate,
								",false)
      
        ->from('tbl_event_log_sales as tels')
		->join('tbl_bank as tb','tels.bank_id=tb.id','left ')
		->join('tbl_event_assign as tea','tels.id=tea.event_id and tea.status = 1','left ')
		->join('tbl_user_registration as tur','tur.id=tea.assign_to_id ','left ')
		->join('tbl_user_registration as tur1','tur1.id=tels.sales_executive_id','left ')
		->join('tbl_user_registration as tur2','tur2.id=tels.created_by','left ')
		->join('tbl_auction as ta','tels.id=ta.eventID and ta.status IN(1,3,4,6,7)','left');
		//->join('tbl_auction as ta','ta.id=tacn.auctionID','left ');
		$this->db->where_not_in("tels.status",array(5));

		$this->db->order_by('tels.id','DESC');
		
        return $this->datatables->generate();
    }
	
	function accountSummaryDatatable() 
	{	
			/*$query = $this->db->query("SELECT @row := @row + 1 as SNo, tbr.id, tb.name, ta.branch_id, ta.bank_id, tbr.name as branch_name, 
			sum(ta.status = '1' OR ta.status = '3' OR ta.status = '4' OR ta.status = '6' OR ta.status = '7' ) as published, 
			sum(ta.status = '7' OR ta.status = '6') as concluded, 
			sum(ta.status = '1' AND (ta.auction_end_date > NOW()) AND (ta.auction_start_date < NOW()) ) as lives, 
			sum(ta.is_invoice_generated='1') as invoiced, 
			sum(ta.is_payment_recived='1') as collected 
			FROM (`tbl_branch` as tbr) LEFT JOIN `tbl_bank` as tb ON `tb`.`id`=`tbr`.`bank_id` 
			 JOIN `tbl_auction` as ta ON `ta`.`branch_id`=`tbr`.`id` 
			GROUP BY `tbr`.`id`  ORDER BY `published` DESC");
			return $query->result_array();*/
		$_POST['bSearchable_0'] = false;
		$_POST['bSearchable_1'] = true;
		$_POST['bSearchable_2'] = true;
		$_POST['bSearchable_3'] = false;
		$_POST['bSearchable_4'] = false;
		$_POST['bSearchable_5'] = false;
		$_POST['bSearchable_6'] = false;
		$_POST['bSearchable_7'] = false;
		$_POST['bSearchable_8'] = false;
		$_POST['bSearchable_9'] = false;
		
		$this->db->query("SET @row = 0",false); 
		
		$this->datatables->select("@row := @row + 1 as SNo,  ta.branch_id,tb.name, tbr.name as branch_name,
			sum(ta.status = '1' OR ta.status = '3' OR ta.status = '4' OR ta.status = '6' OR ta.status = '7' ) as published, 
			sum(ta.status = '7' OR ta.status = '6') as concluded, 
			sum(ta.status = '1' AND (ta.auction_end_date > NOW()) AND (ta.auction_start_date < NOW()) ) as lives, 
			sum(i.status = '1') as invoiced, 
			sum(ta.is_payment_recived='1') as collected",false)
			->add_column('Actions', "<a  class='followUpNote_iframe' href='/mis/branchAccountauctionSummary/$1'>View</a>", 'ta.branch_id')
      
        ->from('tbl_branch as tbr')
		->join('tbl_bank as tb','tb.id=tbr.bank_id','left')
		->join('tbl_auction as ta','ta.branch_id=tbr.id')
		->join('tbl_event_invoice as i','i.auctionID=ta.id','left');
		$this->db->group_by('tbr.id'); 
		$this->db->order_by('published','DESC');
		
		
        return $this->datatables->generate();
    }
	
		function accountSummaryBranchDatatable($branchID) {	
			$query = $this->db->query("SELECT @row := @row + 1 as SNo, ta.id as auctionID, ta.reference_no, ta.auction_start_date, ta.auction_end_date, tb.name,ta.branch_id,ta.bank_id, tbr.name as branch_name,
			 case  
			   when grandTotal > 0 then grandTotal
			else 'No'
			end as invoiced,
			case  
			   when amount_recived > 0 then amount_recived
			else 'No'
			end as paymentCollected
			FROM (`tbl_branch` as tbr) 
			LEFT JOIN `tbl_bank` as tb ON `tb`.`id`=`tbr`.`bank_id` 
			JOIN `tbl_auction` as ta ON `ta`.`branch_id`=`tbr`.`id`
			LEFT JOIN `tbl_event_invoice` as I  ON I.auctionID=ta.id
			
			WHERE ta.branch_id='$branchID' AND ta.status NOT IN(0,2,5) ORDER BY ta.id DESC");
			//echo $this->db->last_query();
		return $query->result_array();
    }
    
    function branchInvoiceAccountSummaryDatatable($branch_id)
    {	
		$sql="
		SELECT  B.id,B.event_title,A.invoiceNo,A.grandTotal,A.invoiceDate,A.amount_recived             
		FROM `tbl_event_invoice` A
			Inner JOIN  tbl_auction B ON A.auctionID = B.id
			Inner JOIN tbl_bank C ON B.bank_id = C.id
			JOIN `tbl_branch` D ON `B`.`branch_id`=`D`.`id`
			Left JOIN tbl_taxmaster as tm ON tm.start_date <= A.invoiceDate and tm.end_date >= A.invoiceDate
			Left JOIN tbl_auction_credit_note as tacn ON A.auctionID = tacn.auctionID
			Where B.branch_id='$branch_id' AND (B.status= '6' OR B.status= '7' OR B.status= '3' OR B.status= '4')
		order by B.id";
		$query=$this->db->query($sql);
		
		$totalRow=$query->num_rows();
		//echo $this->db->last_query();
		if($totalRow>0)
		{
			return $query->result();
		}
		
    }
	
	function branchAccountSummaryDatatable($bank_id)
    {	
		$sql="
		SELECT  A.auctionID,B.bank_id,B.branch_id,count(A.auctionID)as total_auction, B.bank_id,  C.name as bank_name,D.name as branch_name, sum(A.grandTotal) as invoiceamnout,
		count(case  
			when amount_recived = 0 then null
			else amount_recived
			end) 
			as totalnoofcollection,
		Sum(case  
			  when amount_recived IS NULL then 0
			  else amount_recived
			 end) as totalcollection,
		Sum(
			case  
				when A.tds_deduction_amount = 0 OR A.tds_deduction_amount IS NULL then 0
				else A.tds_deduction_amount
			end 
			+
			case  
				when A.other_deduction_amount = 0 OR A.other_deduction_amount IS NULL then 0
				else A.other_deduction_amount
			end 
			+
			case  
				when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
				else tacn.grandTotal
			end 
			
		) 
		as netDeduction,
	    (sum(A.grandTotal) -Sum(case when amount_recived IS NULL then 0 else amount_recived end)) as outstandingAmt,
	    (SELECT sum(bcol.amount) FROM tbl_branch_collection as bcol inner join tbl_auction as auc on auc.branch_id = bcol.branch_id WHERE bcol.status = 1 and auc.id = A.auctionID) as onAccountPayment,	
		(SELECT sum(bcol.justified_amount) FROM tbl_branch_collection as bcol inner join tbl_auction as auc on auc.branch_id = bcol.branch_id WHERE bcol.status = 1 and auc.id = A.auctionID) as settledAmount,
		(SELECT sum(bcol.remaining) FROM tbl_branch_collection as bcol inner join tbl_auction as auc on auc.branch_id = bcol.branch_id WHERE bcol.status = 1 and auc.id = A.auctionID) as remainingAmount	           
		FROM `tbl_event_invoice` A
			Inner JOIN  tbl_auction B ON A.auctionID = B.id
			Inner JOIN tbl_bank C ON B.bank_id = C.id
			JOIN `tbl_branch` D ON `B`.`branch_id`=`D`.`id`
			Left JOIN tbl_taxmaster as tm ON tm.start_date <= A.invoiceDate and tm.end_date >= A.invoiceDate
			Left JOIN tbl_auction_credit_note as tacn ON A.auctionID = tacn.auctionID and tacn.status = 1 and tacn.verified = 1
			Where B.bank_id='$bank_id' AND (B.status= '6' OR B.status= '7' OR B.status= '3' OR B.status= '4')
		group by B.branch_id";
		$query=$this->db->query($sql);
		
		$totalRow=$query->num_rows();
		//echo $this->db->last_query();
		if($totalRow>0)
		{
			return $query->result();
		}
		
    }
	function bankWiseAmtOutStandingDatatable()
    {	
		$sql="SELECT A.auctionID, count(A.auctionID)as total_auction, B.bank_id, C.name, sum(A.grandTotal) as invoiceamnout,
		count(case  
			when amount_recived = 0 then null
			else amount_recived
			end) 
			as totalnoofcollection,
		Sum(case  
			when amount_recived = 0 then 0
			else amount_recived
			end) 
			as totalcollection,
		Sum(
			case  
				when A.tds_deduction_amount = 0 OR A.tds_deduction_amount IS NULL then 0
				else A.tds_deduction_amount
			end 
			+
			case  
				when A.other_deduction_amount = 0 OR A.other_deduction_amount IS NULL then 0
				else A.other_deduction_amount
			end 
			+
			case  
				when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
				else tacn.grandTotal
			end 
			
			) 
			as netDeduction,
		(sum(A.grandTotal) - Sum(case when amount_recived = 0 then 0 else amount_recived end) -
			Sum(
				case  
					when A.tds_deduction_amount = 0 OR A.tds_deduction_amount IS NULL then 0
					else A.tds_deduction_amount
				end 
				+
				case  
					when A.other_deduction_amount = 0 OR A.other_deduction_amount IS NULL then 0
					else A.other_deduction_amount
				end 
				+
				case  
					when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
					else tacn.grandTotal
				end 			
			) 
		)  as outstandingAmt,
		(SELECT sum(bcol.amount) FROM tbl_branch_collection as bcol inner join tbl_auction as auc on auc.bank_id = bcol.bank_id WHERE bcol.status = 1 and auc.id = A.auctionID) as onAccountPayment,	
		(SELECT sum(bcol.justified_amount) FROM tbl_branch_collection as bcol inner join tbl_auction as auc on auc.bank_id = bcol.bank_id WHERE bcol.status = 1 and auc.id = A.auctionID) as settledAmount,	
		(SELECT sum(bcol.remaining) FROM tbl_branch_collection as bcol inner join tbl_auction as auc on auc.bank_id = bcol.bank_id WHERE bcol.status = 1 and auc.id = A.auctionID) as remainingAmount	
		FROM `tbl_event_invoice` A 
		INNER JOIN  tbl_auction B ON A.auctionID = B.id 
		Inner JOIN tbl_bank C ON B.bank_id = C.id 
		Left JOIN tbl_taxmaster as tm ON tm.start_date <= A.invoiceDate and tm.end_date >= A.invoiceDate
		Left JOIN tbl_auction_credit_note as tacn ON A.auctionID = tacn.auctionID and tacn.verified = 1 and tacn.status = 1		
		Where (B.status= '6' OR B.status= '7' OR B.status= '3' OR B.status= '4')
		group by B.bank_id
		";
		
		
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		$totalRow=$query->num_rows();
		if($totalRow>0)
		{
			return $query->result();
		}
		
		
    }
	function getUserAjax()
    {	
        $role=$this->input->post('user_type');
		if($role)
		{
			$this->db->select("id,CONCAT(first_name,' ',last_name) as name",false);
			$this->db->where('role',$role);
			$this->db->where("(user_type='sales' OR user_type='sales_coordinator')");
			$query=$this->db->get('tbl_user_registration');
			$str='';
			foreach($query->result() as $row)
			{
				$str.="<option value='$row->id'>".$row->name ."</option>";
			}
			return $str;
		}
		
		
        return false;
    }
	function targetSheetDatatable()
    {	
        $this->db->query("SET @row = 0",false); 
         $this->datatables->select(" @row := @row + 1 as SNo,tt.id,tt.yearID ,MONTHNAME(STR_TO_DATE(tt.month, '%m')) as month , CONCAT(tur.first_name,' ',tur.last_name) as user_name,  tt.publishingTarget , tt.collectionTarget",false)
		// ->where('ta.branch_id',$branch_id)
		 ->add_column('Actions', "<a   href='/mis/targetSheet/$1'>Update</a>", 'tt.id')
        ->from('tbl_target as tt')
		->join('tbl_bank as tb','tb.id=tt.bankID','left ')
		->join('tbl_user_registration as tur','tur.id=tt.sales_user_id','left ');
        return $this->datatables->generate();
    }
	
    function addTargetData()
    {	
		$sales_user_id 	= $this->input->post('user');
		$month 	          = $this->input->post('month');
		$yearID 	        = $this->input->post('year');
		$bankID 	        = $this->input->post('bankID');
		$publishingTarget 	= $this->input->post('pTarget');
		$collectionTarget 	= $this->input->post('cTarget');
		$target_sheet_id 	        = $this->input->post('target_sheet_id');
		$created_by	        = $this->session->userdata['id'];
		$indate=date('Y-m-d H:i:s');
		$status=1;
		$data = array('sales_user_id'=>$sales_user_id,
					'month'=>$month,
					'yearID'=>$yearID,
					'bankID'=>$bankID,
					'publishingTarget'=>$publishingTarget,
					'collectionTarget'=>$collectionTarget,
					'indate'=>$indate,
					'status'=>$status);
		if($target_sheet_id)
		{
			$modified_date = date('Y-m-d H:i:s');
			$data1 = array('publishingTarget'=>$publishingTarget,
					'collectionTarget'=>$collectionTarget,
					'modified_date'=>$modified_date,
					);
			$this->db->where('id',$target_sheet_id);
			$this->db->update('tbl_target',$data1);
		}
		else
		{
			$data['indate']=$indate;
			$this->db->insert('tbl_target',$data);
		}
    }
	function targetData($target_sheet_id)
    {
		$this->db->where('id',$target_sheet_id);
		$query=$this->db->get('tbl_target');
		return $query->result();
	}
	
	function executiveWiseAmtOutStandingDatatable()
    {	
			$query =$this->db->query("SELECT @row := @row + 1 as SNo, SAL.sales_executive_id, USR.email_id as userID, concat(USR.first_name, ' ', USR.last_name) as uname, 
			count(AUC.status = 1 OR AUC.status = 3 OR AUC.status = 4 OR AUC.status = 6 OR AUC.status = 7 ) as published,
			count(INV.id) as invoiced, 
			sum(INV.grandTotal) as invoiced_amount,
			count(case  
						when amount_recived IS NULL then 0
						else amount_recived
						end) 
						as totalnoofcollection,
			Sum(case  
						when amount_recived IS NULL then 0
						else amount_recived
						end) 
						as totalcollection,
			Sum(
						case  
							when INV.tds_deduction_amount = 0 OR INV.tds_deduction_amount IS NULL then 0
							else INV.tds_deduction_amount
						end 
						+
						case  
							when INV.other_deduction_amount = 0 OR INV.other_deduction_amount IS NULL then 0
							else INV.other_deduction_amount
						end 
						+
						case  
							when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
							else tacn.grandTotal
						end 			
			) 
			as netDeduction,
			count(INV.id) - count(case  
						when amount_recived IS NULL then null
						else amount_recived
						end) 
						as outstanding,		
			(SUM(INV.grandTotal)-Sum(amount_recived)) as outstandingAmt	
			FROM `tbl_user_registration` as USR
			LEFT JOIN `tbl_event_log_sales` SAL ON `SAL`.`sales_executive_id` = `USR`.`id`
			JOIN `tbl_auction` AUC ON `AUC`.`eventID`=`SAL`.`id` 
			LEFT JOIN `tbl_event_invoice` INV ON `AUC`.`id`=`INV`.`auctionID` 
			LEFT JOIN `tbl_auction_credit_note` tacn ON `AUC`.`id`=`tacn`.`auctionID` and tacn.verified = 1 and tacn.status = 1
			WHERE `AUC`.`status` IN(1,3,4,6,7) GROUP BY `SAL`.`sales_executive_id`");
		return $query->result_array();
   }
   
   function executiveBankWiseAmtOutStandingDatatable($executive_id)
    {	
			$query =$this->db->query("SELECT @row := @row + 1 as SNo, 
			bank.name as bank_name,
			`SAL`.`sales_executive_id`,
			`AUC`.`bank_id`,
			count(INV.id) as invoiced, 
			sum(INV.grandTotal) as invoiced_amount,
			count(amount_recived > 0) 
						as totalnoofcollection,
			Sum(case  
						when amount_recived IS NULL then 0
						else amount_recived
						end) 
						as totalcollection,
			Sum(
				case  
					when INV.tds_deduction_amount = 0 OR INV.tds_deduction_amount IS NULL then 0
					else INV.tds_deduction_amount
				end 
				+
				case  
					when INV.other_deduction_amount = 0 OR INV.other_deduction_amount IS NULL then 0
					else INV.other_deduction_amount
				end 
				+
				case  
					when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
					else tacn.grandTotal
				end 
			
			) 
			as netDeduction,
			count(INV.id) - count(case  
						when amount_recived IS NULL then null
						else amount_recived
						end) 
						as outstanding,		
			case (SUM(INV.grandTotal)-Sum(amount_recived)) when (SUM(INV.grandTotal)-Sum(amount_recived)) THEN (SUM(INV.grandTotal)-Sum(amount_recived)) ELSE 0.00 END as outstandingAmt	
			FROM `tbl_user_registration` as USR
			LEFT JOIN `tbl_event_log_sales` SAL ON `SAL`.`sales_executive_id` = `USR`.`id`
			JOIN `tbl_auction` AUC ON `AUC`.`eventID`=`SAL`.`id` 
			LEFT JOIN `tbl_event_invoice` INV ON `AUC`.`id`=`INV`.`auctionID` 
			LEFT JOIN `tbl_bank` bank ON `AUC`.`bank_id`=`bank`.`id`
			LEFT JOIN `tbl_auction_credit_note` tacn ON `AUC`.`id`=`tacn`.`auctionID` AND tacn.status = 1 AND tacn.verified = 1
			WHERE `AUC`.`status` IN(1,3,4,6,7) and  `SAL`.`sales_executive_id` = '".$executive_id."' GROUP BY `AUC`.`bank_id`");
		return $query->result_array();
   }
   
   function executiveBranchWiseAmtOutStandingDatatable($executive_id,$bank_id)
    {	
			$query =$this->db->query("SELECT @row := @row + 1 as SNo, 
			bank.name as bank_name,
			branch.name as branch_name,
			`SAL`.`sales_executive_id`,
			`AUC`.`branch_id`,
			count(INV.id) as invoiced, 
			sum(INV.grandTotal) as invoiced_amount,
			count(amount_recived > 0) 
						as totalnoofcollection,
			Sum(
				case  
					when amount_recived IS NULL then 0
					else amount_recived
				end
			) 
			as totalcollection,
			Sum(
				case  
					when INV.tds_deduction_amount = 0 OR INV.tds_deduction_amount IS NULL then 0
					else INV.tds_deduction_amount
				end 
				+
				case  
					when INV.other_deduction_amount = 0 OR INV.other_deduction_amount IS NULL then 0
					else INV.other_deduction_amount
				end 
				+
				case  
					when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
					else tacn.grandTotal
				end
			) 
			as netDeduction,
			count(INV.id) - count(case  
						when amount_recived IS NULL then null
						else amount_recived
						end) 
						as outstanding,		
			case (SUM(INV.grandTotal)-Sum(amount_recived)) when (SUM(INV.grandTotal)-Sum(amount_recived)) THEN (SUM(INV.grandTotal)-Sum(amount_recived)) ELSE 0.00 END as outstandingAmt	
			FROM `tbl_user_registration` as USR
			LEFT JOIN `tbl_event_log_sales` SAL ON `SAL`.`sales_executive_id` = `USR`.`id`
			JOIN `tbl_auction` AUC ON `AUC`.`eventID`=`SAL`.`id` 
			LEFT JOIN `tbl_event_invoice` INV ON `AUC`.`id`=`INV`.`auctionID` 
			LEFT JOIN `tbl_bank` bank ON `AUC`.`bank_id`=`bank`.`id`
			LEFT JOIN `tbl_branch` branch ON `AUC`.`branch_id`=`branch`.`id`
			LEFT JOIN `tbl_auction_credit_note` tacn ON `AUC`.`id`=`tacn`.`auctionID` and tacn.status = 1 and tacn.verified = 1
			WHERE `AUC`.`status` IN(1,3,4,6,7) and  `SAL`.`sales_executive_id` = '".$executive_id."' and AUC.bank_id = '".$bank_id."' GROUP BY `AUC`.`branch_id`");
		return $query->result_array();
   }
   
	function targetCollectionStatusDatatable($aid)
    {						
		if($aid > 0)
		{
			 $year = date('Y');
			 $nextyear = date('Y')+1;
			 //$date = date('d');
			 if($aid == 14) // Q1
			 {
				 $startDate = $year.'-04-01 00:00:00';
				 $endDate = $year.'-06-30 23:59:59';
				 //$startDate = '2016-01-01 00:00:00';
				 //$endDate = '2016-03-31 23:59:59';
				
			 }
			 if($aid == 15) // Q2
			 {
				 $startDate = $year.'-07-01 00:00:00';
				 $endDate = $year.'-09-30 23:59:59';
			 }
			 if($aid == 16) // Q3
			 {
				 $startDate = $year.'-10-01 00:00:00';
				 $endDate = $year.'-12-31 23:59:59';
			 }
			 if($aid == 17) // Q4
			 {
				 $startDate = $nextyear.'-01-01 00:00:00';
				 $endDate = $nextyear.'-03-31 23:59:59';
			 }
			 if($aid == 1) // Jan
			 {
				 $startDate = $year.'-01-01 00:00:00';
				 $endDate = $year.'-01-31 23:59:59';
			 }
			 if($aid == 2) // Feb
			 {
				 $startDate = $year.'-02-01 00:00:00';
				 $endDate = $year.'-02-29 23:59:59';
			 }
			 if($aid == 3) // Mar
			 {
				 $startDate = $year.'-03-01 00:00:00';
				 $endDate = $year.'-03-31 23:59:59';
			 }
			 if($aid == 4) // Apr
			 {
				 $startDate = $year.'-04-01 00:00:00';
				 $endDate = $year.'-04-30 23:59:59';
			 }
			 if($aid == 5) // May
			 {
				 $startDate = $year.'-05-01 00:00:00';
				 $endDate = $year.'-05-31 23:59:59';
			 }
			 if($aid == 6) // Jun
			 {
				 $startDate = $year.'-06-01 00:00:00';
				 $endDate = $year.'-06-30 23:59:59';
			 }
			 if($aid == 7) // JuL
			 {
				 $startDate = $year.'-07-01 00:00:00';
				 $endDate = $year.'-07-31 23:59:59';
			 }
			 if($aid == 8) // Aug
			 {
				 $startDate = $year.'-08-01 00:00:00';
				 $endDate = $year.'-08-31 23:59:59';
			 }
			 if($aid == 9) // Aug
			 {
				 $startDate = $year.'-09-01 00:00:00';
				 $endDate = $year.'-09-30 23:59:59';
			 }
			 if($aid == 10) // Aug
			 {
				 $startDate = $year.'-10-01 00:00:00';
				 $endDate = $year.'-10-31 23:59:59';
			 }
			 if($aid == 11) // Aug
			 {
				 $startDate = $year.'-11-01 00:00:00';
				 $endDate = $year.'-11-30 23:59:59';
			 }
			 if($aid == 12) // Aug
			 {
				 $startDate = $year.'-12-01 00:00:00';
				 $endDate = $year.'-12-31 23:59:59';
			 }
			 
			 $query = $this->db->query("SELECT @row := @row + 1 as SNo, 
										CONCAT(tur.first_name, ' ', tur.last_name) as name, 
										count(ta.id) as collection_count, 
										sum(tei.amount_recived) as collection_amt 
										FROM (`tbl_auction` as ta) 
										LEFT JOIN `tbl_event_log_sales` as els ON `els`.`id`=`ta`.`eventID` 
										LEFT JOIN `tbl_event_invoice` as tei ON `tei`.`auctionID`=`ta`.`id` 
										LEFT JOIN `tbl_user_registration` as tur ON `tur`.`id`=`els`.`sales_executive_id` 
										WHERE `tur`.`id`>0 AND `tei`.`amount_recived` > 0 AND realizationDate BETWEEN  '".$startDate."' AND '".$endDate."'
										GROUP BY `els`.`sales_executive_id`"); // tbl_event_invoice realizationDate
										
			  //$this->db->where('els.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'"');
			 
		}else{
			$query = $this->db->query("SELECT @row := @row + 1 as SNo, 
										CONCAT(tur.first_name, ' ', tur.last_name) as name, 
										count(ta.id) as collection_count, 
										sum(tei.amount_recived) as collection_amt 
										FROM (`tbl_auction` as ta) 
										LEFT JOIN `tbl_event_log_sales` as els ON `els`.`id`=`ta`.`eventID` 
										LEFT JOIN `tbl_event_invoice` as tei ON `tei`.`auctionID`=`ta`.`id` 
										LEFT JOIN `tbl_user_registration` as tur ON `tur`.`id`=`els`.`sales_executive_id` 
										WHERE `tur`.`id`>0 AND `tei`.`amount_recived` > 0 
										GROUP BY `els`.`sales_executive_id`"); // tbl_event_invoice realizationDate
		}							
										
		 $data=$query->result_array();
		// echo $this->db->last_query();die;
		 return $data;
    }
	
	function timeSheetDatatable($aid)
    {	
		$this->datatables->select("els.id,
		CONCAT(tu.first_name ,' ',tu.last_name)  as executive_name,
		tb.name as bank_name, 
		CASE els.status 
		WHEN '0' THEN 'New'
		WHEN '1' THEN 'Assign'
		WHEN '2' THEN 'Reassign'
		WHEN '4' THEN 'Event Created'
		WHEN '5' THEN 'Deleted'
		ELSE 'New' 
		END as status, 
		tua.email_id,
		CASE els.indate WHEN els.indate THEN els.indate ELSE 'N/A' END as log_date,
		CASE tea.indate WHEN tea.indate THEN tea.indate ELSE 'N/A' END as assigned_date,
		CASE FORMAT((time_to_sec(timediff(tea.indate, els.indate)) / 3600),2) WHEN FORMAT((time_to_sec(timediff(tea.indate, els.indate)) / 3600),2) THEN FORMAT((time_to_sec(timediff(tea.indate, els.indate)) / 3600),2) ELSE 'N/A' END as time1,
		case a.indate WHEN a.indate THEN a.indate ELSE 'N/A' END as auction_date,
		case FORMAT((time_to_sec(timediff(a.indate,tea.indate)) / 3600),2) WHEN FORMAT((time_to_sec(timediff(a.indate,tea.indate)) / 3600),2) THEN FORMAT((time_to_sec(timediff(a.indate,tea.indate)) / 3600),2) ELSE 'N/A' END as time2,
		",false)
		->from('tbl_event_log_sales as els')
		->join('tbl_user_registration as tu','els.sales_executive_id=tu.id','left')		
		->join('tbl_bank as tb','els.bank_id=tb.id','left')
		->join('tbl_branch as tbr','els.branch_id=tbr.id','left')
		->join('tbl_drt td','els.drt_id=td.id','left')
		->join('tbl_event_assign tea','els.id=tea.event_id and els.is_assign != 0 and tea.status = 1','left')
		->join('tbl_user_registration as tua','tea.assign_to_id=tua.id','left')
		->join('tbl_auction as a','a.eventID=els.id and a.status IN(1,3,4,6,7)','left');
		//->where('tea.status',1)
		$this->db->where_not_in('els.status',array(5));
		//$this->db->where_not_in('a.status',array(2,5));
		$this->db->order_by('els.id','DESC');
		if($aid > 0)
		{
			 $year = date('Y');
			 $nextyear = date('Y')+1;
			 if($aid == 1) // Jan
			 {
				 $startDate = $year.'-01-01 00:00:00';
				 $endDate = $year.'-01-31 23:59:59';
			 }
			 if($aid == 2) // Feb
			 {
				 $startDate = $year.'-02-01 00:00:00';
				 $endDate = $year.'-02-29 23:59:59';
			 }
			 if($aid == 3) // Mar
			 {
				 $startDate = $year.'-03-01 00:00:00';
				 $endDate = $year.'-03-31 23:59:59';
			 }
			 if($aid == 4) // Apr
			 {
				 $startDate = $year.'-04-01 00:00:00';
				 $endDate = $year.'-04-30 23:59:59';
			 }
			 if($aid == 5) // May
			 {
				 $startDate = $year.'-05-01 00:00:00';
				 $endDate = $year.'-05-31 23:59:59';
			 }
			 if($aid == 6) // Jun
			 {
				 $startDate = $year.'-06-01 00:00:00';
				 $endDate = $year.'-06-30 23:59:59';
			 }
			 if($aid == 7) // JuL
			 {
				 $startDate = $year.'-07-01 00:00:00';
				 $endDate = $year.'-07-31 23:59:59';
			 }
			 if($aid == 8) // Aug
			 {
				 $startDate = $year.'-08-01 00:00:00';
				 $endDate = $year.'-08-31 23:59:59';
			 }
			 if($aid == 9) // Aug
			 {
				 $startDate = $year.'-09-01 00:00:00';
				 $endDate = $year.'-09-30 23:59:59';
			 }
			 if($aid == 10) // Aug
			 {
				 $startDate = $year.'-10-01 00:00:00';
				 $endDate = $year.'-10-31 23:59:59';
			 }
			 if($aid == 11) // Aug
			 {
				 $startDate = $year.'-11-01 00:00:00';
				 $endDate = $year.'-11-30 23:59:59';
			 }
			 if($aid == 12) // Aug
			 {
				 $startDate = $year.'-12-01 00:00:00';
				 $endDate = $year.'-12-31 23:59:59';
			 }
			  $this->db->where('tea.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'"');
			 
		}
		//$this->datatables->generate();
		//echo $this->db->last_query();die;

		return $this->datatables->generate();
    }
	
}

?>
