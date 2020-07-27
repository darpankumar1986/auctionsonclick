<?php
class Sales_executive_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	
	function dashboardData($type='',$start_date='',$end_date='')
	{
		$this->db->select('count(id) as total ',false);
		$this->db->where('status !=', 0);
		$this->db->where('status !=', 2);
		if($type=='today')$this->db->where('updated_date = CURDATE()');
		if($type=='week')$this->db->where('updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("updated_date BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$publishedData=$query->result();
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('status ', 7);
		if($type=='today')$this->db->where('updated_date = CURDATE()');
		if($type=='week')$this->db->where('updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("updated_date BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$concludedData=$query->result();
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('status ', 1);
		if($type=='today')$this->db->where('updated_date = CURDATE()');
		if($type=='week')$this->db->where('updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("updated_date BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$inProgressData=$query->result();
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('(status=3 OR status=4)');
		if($type=='today')$this->db->where('updated_date = CURDATE()');
		if($type=='week')$this->db->where('updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("updated_date BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");
		$cancelStatData=$query->result();
		
		$this->db->select('count(id) as total,sum(amount) as total_amount',false);
		//$this->db->where('is_invoice_generated',1);
		if($type=='today')$this->db->where('invoiceDate = CURDATE()');
		if($type=='week')$this->db->where('invoiceDate BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('invoiceDate BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("invoiceDate BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_event_invoice");
		$invoicedData=$query->result();
		
		$this->db->select('count(id) as total,sum(realizationAmount) as total_amount',false);
		//$this->db->where('realizationAmount',1);
		if($type=='today')$this->db->where('realizationDate = CURDATE()');
		if($type=='week')$this->db->where('realizationDate BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('realizationDate BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("realizationDate BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_event_invoice");
		$collectionData=$query->result();
	
		$data['allPublished']=$publishedData[0]->total;
		$data['allConcluded']=$concludedData[0]->total;
		$data['allInProgress']=$inProgressData[0]->total;
		$data['allCancelStay']=$cancelStatData[0]->total;
		$data['allInvoiced']=$invoicedData[0]->total;
		$data['allCollection']=$collectionData[0]->total;
		$data['allInvoicedamt']=$invoicedData[0]->total_amount;
		$data['allCollectionamt']=$collectionData[0]->total_amount;
		return $data;
	
	}
	function targetDatatable()
    {	
		 $user_id=$this->session->userdata('id');
		$rowsdata= $this->db->query(" SELECT `tt`.`sales_user_id`,B.name,tt.publishingTarget,tt.collectionTarget,
  count(case  
              when  `ta`.`status` NOT IN(1,4,6,7) then  ta.id
              else null
           end) as actualcount,
 count(case  
              when ta.is_payment_recived =1 AND `ta`.`status` NOT IN(5,0,2,3)  then ta.is_payment_recived 
              else null 
           end) as actualcollectioncount 
 FROM (`tbl_target` AS tt)  JOIN `tbl_bank` B ON `tt`.`bankID`=`B`.`id` JOIN `tbl_event_log_sales` els ON `tt`.`sales_user_id`=`els`.`sales_executive_id` JOIN `tbl_auction` ta ON `ta`.`eventID`=`els`.`id` WHERE `tt`.`sales_user_id` = '$user_id' group by `tt`.`bankID`
 ")->result_object();
		 /*
         $this->datatables->select("B.name,tt.publishingTarget , count(ta.id) as actualcount, tt.collectionTarget ,count(ta.is_payment_recived=1) as actualcollectioncount ",false)
        ->where('tt.sales_user_id',$user_id)
       // ->where('ta.status','1')
        ->from('tbl_target AS tt')
		->join('tbl_bank B','tt.bankID=B.id')
		->join('tbl_event_log_sales els','tt.sales_user_id=els.sales_executive_id')
		->join('tbl_auction ta','ta.eventID=els.id1');
        return $this->datatables->generate();*/
		//echo $this->db->last_query();
		return $rowsdata;
    }
	function eventsNotInvoicedDatatable()
    {	
		$user_id=$this->session->userdata('id');
         $this->db->query("SET @row = 0",false); 
         $this->datatables->select(" A.id,A.reference_no,B.name as bank_name,BR.name as branch_name,A.indate,A.status AS status_name",false)
		
        ->where('A.is_invoice_generated !=',1);
		if($user_id)
         $this->datatables->where('els.sales_executive_id',$user_id);
         $this->datatables->from('tbl_auction AS A')
		->join('tbl_bank B','A.bank_id=B.id','left ')
		->join('tbl_branch BR','A.branch_id=BR.id','left')
		->join('tbl_event_log_sales els','A.eventID=els.id','left');
		//$this->db->group_by('A.bank_id');
		
        return $this->datatables->generate();
    }
	function paymentNotCollectedDatatable()
    {	
         $user_id=$this->session->userdata('id');
         $this->db->query("SET @row = 0",false); 
         $this->datatables->select("A.id,A.reference_no,B.name as bank_name,BR.name as branch_name,A.indate, A.status AS status_name",false)
		
        ->where('A.is_payment_recived !=',1);
		if($user_id)
         $this->datatables->where('els.sales_executive_id',$user_id);
         $this->datatables->from('tbl_auction AS A')
		->join('tbl_bank B','A.bank_id=B.id','left ')
		->join('tbl_branch BR','A.branch_id=BR.id','left')
		->join('tbl_event_log_sales els','A.eventID=els.id','left');
		
        return $this->datatables->generate();
    }
	function frowardByAccountUserDatatable()
    {	
         $user_id=$this->session->userdata('id');
         $this->db->query("SET @row = 0",false); 
        /* $this->datatables->select(" A.id,A.reference_no, tei.invoiceNo, tei.amount,tei.invoiceDate, 
		  CASE A.status
		  WHEN 1 THEN 'Under process'
		  WHEN 2 THEN 'Payment sent'
		  WHEN 3 THEN 'Resend Invoice'
		  WHEN 4 THEN 'Callback'
		  WHEN 4 THEN 'Query'
		  END AS status 
		,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= tf.auctionID ) as total_bidder",false)
		*/
         $this->datatables->select(" A.id,A.reference_no, tei.invoiceNo, tei.amount,tei.invoiceDate,A.status,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= tf.auctionID ) as total_bidder",false)
        ->where('tf.forwardedToSales',1);
		if($user_id)
         $this->datatables->where('els.sales_executive_id',$user_id);
         $this->datatables->from('tbl_follow_up AS tf')
		->join('tbl_auction AS A','tf.auctionID=A.id','left ')
		->join('tbl_event_invoice tei','tf.auctionID=tei.auctionID','left')
		->join('tbl_event_log_sales els','A.eventID=els.id','left');
        return $this->datatables->generate();
    }
	function eventLogListDatatable()
    {	
		$id=$this->session->userdata('id');
		$this->db->query("SET @row = 0",false); 
		$this->datatables->select("@row := @row + 1 as SNo, els.id,  td.name as drt_name, tb.name as bank_name, tbr.name as bname, IF(els.event_type = 0,'DRT','SARFAESI') as type, els.uploaded_doc,akm.sname AS status ",false)
		->unset_column('els.uploaded_doc')
		->add_column('Download',$this->addDownload('$1'), 'els.uploaded_doc')
		->from('tbl_event_log_sales as els')
		->join('tbl_bank as tb','els.bank_id=tb.id','left')
		->join('tbl_branch as tbr','els.branch_id=tbr.id','left')
                ->join('tbl_auction_status as akm','els.status=akm.s_id and akm.ac_status=2','left')      
		->join('tbl_drt td','els.drt_id=td.id','left ')
		->where('els.sales_executive_id',$id);
             
		return $this->datatables->generate();
    }
		function addDownload($file)
	{
		if($file){
			$html = '<a download href="/public/uploads/bank/'.$file.'">Download</a>';
		}else{
			$html = '';
		}
		return $html;						
	}
		function dashboard_exeData($type='',$start_date='',$end_date='')
	{		
		$id=$this->session->userdata('id');	
		$this->db->select('count(e.id) as total ');
		$this->db->from('tbl_auction as a');
		$this->db->where('a.status !=', 0);
		$this->db->where('e.sales_executive_id', $id);
		if($type=='today')$this->db->where('date(a.updated_date) = CURDATE()');
		if($type=='week')$this->db->where('a.updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('a.updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("a.updated_date BETWEEN '$start_date' AND '$end_date'");
		$this->db->join("tbl_event_log_sales as e",'e.id=a.eventID');	
		$query = $this->db->get();
		//echo $this->db->last_query();
		$publishedData=$query->result();
		
		
		
		
		
		$this->db->select('count(e.id) as total');
		$this->db->where('a.status', 7);
		$this->db->from('tbl_auction as a');
		$this->db->where('e.sales_executive_id', $id);
		if($type=='today')$this->db->where('date(a.updated_date) = CURDATE()');
		if($type=='week')$this->db->where('a.updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('a.updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("a.updated_date BETWEEN '$start_date' AND '$end_date'");
		$this->db->join("tbl_event_log_sales as e",'e.id=a.eventID');	
		$query = $this->db->get();
		$concludedData=$query->result();
		
		
		$this->db->select('count(e.id) as total ',false);
		$this->db->where('a.status', 1);
		$this->db->where('e.sales_executive_id', $id);
		$this->db->from('tbl_auction as a');
		if($type=='today')$this->db->where('date(a.updated_date) = CURDATE()');
		if($type=='week')$this->db->where('a.updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('a.updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("a.updated_date BETWEEN '$start_date' AND '$end_date'");
		$this->db->join("tbl_event_log_sales as e",'e.id=a.eventID');	
		$query = $this->db->get();
		$inProgressData=$query->result();
		
		
		
		$this->db->select('count(e.id) as total ',false);
		$this->db->where('(a.status=3 OR a.status=4)');
		$this->db->from('tbl_auction as a');
		$this->db->where('e.sales_executive_id', $id);
		if($type=='today')$this->db->where('date(a.updated_date) = CURDATE()');
		if($type=='week')$this->db->where('a.updated_date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('a.updated_date BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("a.updated_date BETWEEN '$start_date' AND '$end_date'");
		$this->db->join("tbl_event_log_sales as e",'e.id=a.eventID');	
		$query = $this->db->get();
		$cancelStatData=$query->result();
		
		
		
		$this->db->select('count(i.id) as total,sum(i.amount) as total_amount',false);
		//$this->db->where('is_invoice_generated',1);
		$this->db->from('tbl_auction as a');
		$this->db->where('e.sales_executive_id', $id);
		if($type=='today')$this->db->where('date(i.invoiceDate) = CURDATE()');
		if($type=='week')$this->db->where('i.invoiceDate BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('i.invoiceDate BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("i.invoiceDate BETWEEN '$start_date' AND '$end_date'");
		$this->db->join("tbl_event_invoice as i",'i.auctionID=a.id');
		$this->db->join("tbl_event_log_sales as e",'e.id=a.eventID');
		//$query = $this->db->get("tbl_event_invoice as i");
		$query = $this->db->get();
		$invoicedData=$query->result();
		
		
		$this->db->select('count(i.id) as total,sum(i.realizationAmount) as total_amount',false);
		$this->db->from('tbl_auction as a');
		//$this->db->where('realizationAmount',1);
		$this->db->where('e.sales_executive_id', $id);
		if($type=='today')$this->db->where('date(i.realizationDate) = CURDATE()');
		if($type=='week')$this->db->where('i.realizationDate BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() ');
		if($type=='month')$this->db->where('i.realizationDate BETWEEN CURDATE()  - INTERVAL 30 DAY AND CURDATE()');
		if($type=='select')$this->db->where("i.realizationDate BETWEEN '$start_date' AND '$end_date'");
		$this->db->join("tbl_event_invoice as i",'i.auctionID=a.id');
		$this->db->join("tbl_event_log_sales as e",'e.id=a.eventID');
		//$query = $this->db->get("tbl_event_invoice as i");
		$query = $this->db->get();
		//echo $this->db->last_query();
		$collectionData=$query->result();
	
		$data['allPublished']=$publishedData[0]->total;
		$data['allConcluded']=$concludedData[0]->total;
		$data['allInProgress']=$inProgressData[0]->total;
		$data['allCancelStay']=$cancelStatData[0]->total;
		$data['allInvoiced']=$invoicedData[0]->total;
		$data['allCollection']=$collectionData[0]->total;
		$data['allInvoicedamt']=$invoicedData[0]->total_amount;
		$data['allCollectionamt']=$collectionData[0]->total_amount;
		return $data;
	
	}
}

?>
