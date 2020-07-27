<?php
ini_set('max_execution_time', 1000000000);

class Account_model extends CI_Model {
	
	private $path = 'public/uploads/bank/';
	public $credit_note_path = 'public/uploads/credit_note/';
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
		
	function displaySalesExecutiveAccountData($sales_executive_id,$aid='')
	{	
		//$this->db->query("SET @row = 0",false); 
		$this->datatables->select(" @row := @row + 1 as SNo,a.id as auction_id,a.reference_no,
		CASE a.status 
		WHEN '0' THEN 'Saved'
		WHEN '1' THEN 'Published'
		WHEN '2' THEN 'Initialize'
		WHEN '3' THEN 'Stay'
		WHEN '4' THEN 'Cancel'
		WHEN '5' THEN 'Deleted'
		WHEN '6' THEN 'Published'
		WHEN '7' THEN 'Event conclude'
		ELSE 'Saved' 
		END as status, 
		a.indate,
		IF(i.amount>0,'Yes','No') as amount,		
		IF(i.amount_recived > 0,'Yes','No') as realizationAmount",false)
		->where('s.sales_executive_id',$sales_executive_id)
		//->where('i.status','1')
		->from('tbl_auction as a')
		->join('tbl_event_log_sales s','s.id = a.eventID','left')
		->join('tbl_event_invoice i','i.auctionID=a.id and i.status=1','left');
		$this->db->where_in("a.status",array(1,3,4,6,7));
		$this->db->group_by('a.id');
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
			 if($aid == 9) // Sep
			 {
				 $startDate = $year.'-09-01 00:00:00';
				 $endDate = $year.'-09-30 23:59:59';
			 }
			 if($aid == 10) // Oct
			 {
				 $startDate = $year.'-10-01 00:00:00';
				 $endDate = $year.'-10-31 23:59:59';
			 }
			 if($aid == 11) // Nov
			 {
				 $startDate = $year.'-11-01 00:00:00';
				 $endDate = $year.'-11-30 23:59:59';
			 }
			 if($aid == 12) // Dec
			 {
				 $startDate = $year.'-12-01 00:00:00';
				 $endDate = $year.'-12-31 23:59:59';
			 }
			 $this->db->where('a.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'"');
			 
		}
		//$this->datatables->generate();
		//echo $this->db->last_query();die;
		return $this->datatables->generate();
	}
	
	function salesExecutiveData($aid)
	{	
		
		
		
		
		/*SELECT USR.id, concat(USR.first_name, ' ', USR.last_name) as uname, USR.c1zone, USR.c1zone_id, sum(AUC.status IN(1, 3, 4, 6, 7) ) as published, sum(AUC.status IN('7', '6')) as concluded, sum(AUC.status = '3' OR AUC.status = '4') as cancel, sum(AUC.status = 1) as lives FROM
		 (`tbl_auction` AUC) 
		 LEFT JOIN `tbl_event_log_sales` SAL ON `AUC`.`eventID`=`SAL`.`id` 
		  LEFT JOIN `tbl_user_registration` as USR  ON `SAL`.`sales_executive_id` = `USR`.`id` 
		  WHERE   `SAL`.`indate` BETWEEN "2016-08-01 00:00:00" AND "2016-08-31 23:59:59" 
		  GROUP BY `SAL`.`sales_executive_id`, `USR`.`id`*/
		
		
		$this->db->select("USR.id, concat(USR.first_name, ' ', USR.last_name) as uname, USR.c1zone, USR.c1zone_id, sum(AUC.status IN(1, 3, 4, 6, 7) ) as published, sum(AUC.status IN('7', '6')) as concluded, sum(AUC.status = '3' OR AUC.status = '4') as cancel, sum(AUC.status = 1) as lives",false)
		//->where('USR.user_type','sales')
		//->where('USR.status','1')
		//->where('SAL.id <=','27397')
		//->where_in('AUC.status',array(1,3,4,6,7))
		
		->from('tbl_auction as AUC')
		->join('tbl_event_log_sales SAL','AUC.eventID = SAL.id','left')
		->join('tbl_user_registration USR','SAL.sales_executive_id=USR.id','left');
		
		
		$this->db->group_by('SAL.sales_executive_id');
		$this->db->group_by('USR.id');
		if($aid > 0)
		{
			 $year = date('Y');
			 $nextyear = date('Y')+1;
			 //$date = date('d');
			 if($aid == 14) // Q1
			 {
				 $startDate = $year.'-04-01 00:00:00';
				 $endDate = $year.'-06-30 23:59:59';
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
			 if($aid == 9) // Sept
			 {
				 $startDate = $year.'-09-01 00:00:00';
				 $endDate = $year.'-09-30 23:59:59';
			 }
			 if($aid == 10) // Oct
			 {
				 $startDate = $year.'-10-01 00:00:00';
				 $endDate = $year.'-10-31 23:59:59';
			 }
			 if($aid == 11) // Nov
			 {
				 $startDate = $year.'-11-01 00:00:00';
				 $endDate = $year.'-11-30 23:59:59';
			 }
			 if($aid == 12) // Dec
			 {
				 $startDate = $year.'-12-01 00:00:00';
				 $endDate = $year.'-12-31 23:59:59';
			 }
			  $this->db->where('AUC.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'"');
			 
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return array();
		}
	}
	
	function zoneData()
	{	
		$this->db->select("USR.id,concat(USR.first_name,' ',USR.last_name) as uname , USR.c1zone, USR.c1zone_id, 
		
		sum(AUC.status != '0' and AUC.status != '2' ) as published, 
		
		sum(AUC.status = '7') as concluded,

		sum(AUC.status = '3' OR AUC.status = '4') as cancel,

		sum(AUC.status = '1' AND AUC.auction_end_date > now()) as lives
		
		",false)
		->where('USR.user_type','sales')
		->where('USR.status','1')
		->where('USR.c1zone_id > ','0')
		->from('tbl_user_registration as USR')
		->join('tbl_event_log_sales SAL','SAL.sales_executive_id = USR.id','left')
		->join('tbl_auction AUC','AUC.eventID=SAL.id','left');
		
		//$this->db->group_by('SAL.sales_executive_id');
		$this->db->group_by('USR.c1zone_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return array();
		}
	}
	
	function zonewisedata($zone_id)
	{	
		$this->db->select("USR.id,concat(USR.first_name,' ',USR.last_name) as uname , USR.c1zone, USR.c1zone_id, 
		
		sum(AUC.status != '0' and AUC.status != '2' ) as published, 
		
		sum(AUC.status = '7') as concluded,

		sum(AUC.status = '3' OR AUC.status = '4') as cancel,

		sum(AUC.status = '1' AND AUC.auction_end_date > now()) as lives
		
		",false)
		->where('USR.user_type','sales')
		->where('USR.status','1')
		->where('USR.c1zone_id',$zone_id)
		->from('tbl_user_registration as USR')
		->join('tbl_event_log_sales SAL','SAL.sales_executive_id = USR.id','left')
		->join('tbl_auction AUC','AUC.eventID=SAL.id','left');
		
		//$this->db->group_by('SAL.sales_executive_id');
		//$this->db->group_by('USR.c1zone_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return array();
		}
	}
	
	function misdata($aid){		 
	    $this->db->select("
							tb.id,
							tb.name as bank_name,
							count(*) as publishedAuction ,
							count(CASE WHEN a.status ='6' OR a.status ='7' THEN 1 ELSE NULL END) as concludeAuction ,
							count(CASE WHEN a.status =4 OR a.status =3  THEN 1 ELSE NULL END) as cancelAuction ,
							count(CASE WHEN a.status =1 and a.auction_end_date < CURDATE() THEN 1 ELSE NULL END) as liveAuction,
							count(CASE WHEN i.status =1 THEN 1 ELSE NULL END) as invoicedAuction,
							count(CASE WHEN i.amount_recived > 0  THEN 1 ELSE NULL END) as paidAuction"
						)
		->from('tbl_bank as tb')
		->join('tbl_auction a','a.bank_id=tb.id','left')
		->join('tbl_event_invoice i','i.auctionID=a.id','left')
		->where_in("a.status",array(1,3,4,6,7))
		->group_by('tb.id');

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
			  $this->db->where('a.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'"');
			 
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return array();
		}
	}
	
	function countTotalpaidAuction($bid){
		
		$sql="select count(a.id) as paidAuction from tbl_auction as a right join tbl_event_invoice as i on i.auctionID=a.id where a.bank_id=$bid and (a.status!='0' OR a.status!='5') AND i.amount_recived > 0";
		$query = $this->db->query($sql);
		//$query = $this->db->get($sql);
		$rows=$query->row();
		return $rows->paidAuction;
		
	}
	function countTotalbankinvoced($bid){
		
		$sql="select count(a.id) as invoicedAuction from tbl_auction as a right join tbl_event_invoice as i on i.auctionID=a.id where a.bank_id=$bid and (a.status!='0' OR a.status!='5') ";
		$query = $this->db->query($sql);
		//$query = $this->db->get($sql);
		$rows=$query->row();
		return $rows->invoicedAuction;
		
	}
	
	function misBankData($bank_id,$aid='')
	{	
		$this->db->select("tb.id,tb.name as bank_name,b.name as bank_branch, b.id as branch_id,
		count(*) as publishedAuction ,
		
		count(CASE WHEN a.status ='6' OR a.status ='7' THEN 1 ELSE NULL END) as concludeAuction ,
		
		count(CASE WHEN a.status =4 OR a.status =3  THEN 1 ELSE NULL END) as cancelAuction ,
		
		count(CASE WHEN a.status =1 and a.auction_end_date < CURDATE() THEN 1 ELSE NULL END) as liveAuction
		,
		count(CASE WHEN i.status =1 THEN 1 ELSE NULL END) as invoicedAuction

		,count(CASE WHEN i.amount_recived > 0  THEN 1 ELSE NULL END) as paidAuction
		")
		->from('tbl_bank as tb')
		->join('tbl_branch b','b.bank_id=tb.id','INNER')
		->join('tbl_auction a','a.branch_id=b.id','left')
		->join('tbl_event_invoice i','i.auctionID=a.id and i.status = 1','left')
		->where('a.bank_id',$bank_id)
		->where_in("a.status",array(1,3,4,6,7))
        ->where('a.branch_id !=', '')        
		->group_by('b.id');
		
		
		if($aid > 0)
		{
			
			 $year = date('Y');
			 $nextyear = date('Y')+1;
			 //$date = date('d');
			
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
			
			  $this->db->where('a.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'"');
			 
		}
			
				
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                        $data[] = $row;
                 }
		 return $data;
		}else{
		 return array();
		}
	}
	
	function misBankBranchData($branch_id)
	{	
		$this->db->select("a.id as auction_id,a.reference_no,
		CASE a.status 
		WHEN '0' THEN 'Saved'
		WHEN '1' THEN 'Published'
		WHEN '2' THEN 'Initialize'
		WHEN '3' THEN 'Stay'
		WHEN '4' THEN 'Cancel'
		WHEN '5' THEN 'Deleted'
		WHEN '6' THEN 'Published'
		WHEN '7' THEN 'Event Conclude'
		ELSE 'Saved' 
		END as status, 
		a.indate,
		IF(i.amount>0,'Yes','No') as amount,		
		IF(i.amount_recived>0,'Yes','No') as realizationAmount",false)		
		->from('tbl_auction as a')
		->join('tbl_event_invoice as i','i.auctionID=a.id and i.status = 1','left')
		->where('a.branch_id',$branch_id)
		//->where('i.status','1');
		->where_in('a.status',array(1,3,4,7,6));
		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
			         $data[] = $row;
			}
			return $data;
		}else{
			return array();
		}
	}
	
	function paymentdata()
	{		
        $startDate = $this->input->post('startDate');	
        $endDate = $this->input->post('endDate');
        
        $this->db->where("status",1);	
		$this->db->select("sum(tei.status = '1') as invoiced,
				(sum(round(tei.grandTotal))) as invoicedAmt,
				sum(tei.amount_recived != '0') as collected,
				sum(tei.amount_recived) as collectedAmt")
        ->from('tbl_event_invoice as tei');
        if($startDate=='' && $endDate=='')
        {        
			$this->db->where("(tei.invoiceDate BETWEEN '".date("Y-m-1 00:00:00")."' AND '".date("Y-m-t 23:59:59")."')");
		}
		else
		{
			$this->db->where("(tei.invoiceDate BETWEEN '".date("Y-m-d 00:00:00",strtotime($startDate))."' AND '".date("Y-m-d 23:59:59",strtotime($endDate))."')");
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
					$data[] = $row;
			}
			return $data;
		}
		else
		{
			return array();
		}
	}
	
	function paymentdata_collection()
	{		
        $startDate = $this->input->post('startDate');	
        $endDate = $this->input->post('endDate');	
		$this->db->select("sum(tei.status = '1') as invoiced,
				(sum(round(tei.grandTotal))) as invoicedAmt,
				sum(tei.amount_recived != '0') as collected,
				sum(tei.amount_recived) as collectedAmt")
        ->from('tbl_event_invoice as tei');
        if($startDate=='' && $endDate==''){
        $current_month = date('m');
		$this->db->where("(tei.realizationDate BETWEEN '".date("Y-m-1 00:00:00")."' AND '".date("Y-m-t 23:59:59")."')");
	}else{
		//$this->db->where("(tei.realizationDate BETWEEN '$startDate' AND '$endDate')");
		$this->db->where("(tei.realizationDate BETWEEN '".date("Y-m-d 00:00:00",strtotime($startDate))."' AND '".date("Y-m-d 23:59:59",strtotime($endDate))."')");
	}
	$this->db->where("tei.status",1);
	$query = $this->db->get();
		//echo $this->db->last_query();die;
	$data = array();
	if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
                $data[] = $row;
        }
	return $data;
		}else{
	return array();
		}
	}
	
	function onAccount_paymentdata()
	{		
        $startDate = $this->input->post('startDate');	
        $endDate = $this->input->post('endDate');	
		$this->db->select("
				sum(round(col.amount)) as amount,
				sum(col.justified_amount) as settled,
				sum(col.remaining) as remaining")
        ->from('tbl_branch_collection as col');
        if($startDate=='' && $endDate==''){        
			$this->db->where("(col.posted_date BETWEEN '".date("Y-m-1 00:00:00")."' AND '".date("Y-m-t 23:59:59")."')");
		}else{
			
			$this->db->where("(col.posted_date BETWEEN '".date("Y-m-d 00:00:00",strtotime($startDate))."' AND '".date("Y-m-d 23:59:59",strtotime($endDate))."')");
		}
		$query = $this->db->get();
			//echo $this->db->last_query();die;
		$data = array();
		if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
						$data[] = $row;
				}
				return $data;
			}else{
				return array();
		}
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
         $this->datatables->select(" @row := @row + 1 as SNo,sum(status = '1') as invoiced,sum(amount) as invoicedAmt,sum(amount_recived != '0') as collected,sum(amount_recived) as collectedAmt",false)
	->from('tbl_event_invoice as tei');
        return $this->datatables->generate();
		 
	}
   function paymentDuedatatable()
    {	
		
		        $this->db->query("SET @row = 0",false); 
		       
                $this->datatables->select(" @row := @row + 1 as SNo,ta.id,tei.invoiceNo, ta.event_title, CONCAT(tb.name ,' ','(',tbr.name  ,' )') as bank_branch_name,DATE_FORMAT(ta.indate,'%d/%b/%Y %h:%i:%s %p'),DATE_FORMAT(ta.auction_end_date,'%d/%b/%Y %h:%i:%s %p')",false)
		//->add_column('Actions', "<a  class='updateRealization_iframe' href='/account/updateRealizationPopup/$1'>Update Realization</a>", 'ta.id')
		->add_column('Actions', "<a  class='updateRealization_iframe1' href='#'>Update Realization</a>", 'ta.id')
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left')
		->where('ta.is_invoice_generated',0)
		->where('ta.is_payment_recived ',0)
		->where("(ta.status= '6' OR ta.status= '7' OR ta.status= '3' OR ta.status= '4')");
		$this->db->limit("1");
		//$this->datatables->generate();
		//$this->db_last_query();
		// echo 'test';die;
                return $this->datatables->generate();
    }
    
    function paymentDuedatatableCompleted()
    {	
		
		        $this->db->query("SET @row = 0",false); 
		       
                $this->datatables->select(" @row := @row + 1 as SNo,ta.id,tei.invoiceNo, ta.event_title, CONCAT(tb.name ,' ','(',tbr.name  ,' )') as bank_branch_name,DATE_FORMAT(ta.indate,'%d/%b/%Y %h:%i:%s %p'),DATE_FORMAT(ta.auction_end_date,'%d/%b/%Y %h:%i:%s %p')",false)
		->add_column('Actions', "<a  class='updateRealization_iframe' href='/account/updateRealizationPopup/$1'>Update Realization</a>", 'ta.id')
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left')
		->where('ta.is_invoice_generated',1)
		//->where('ta.is_payment_recived ',0)
		->where("( (tei.indate > '2016-05-13 17:00:00' && tei.balance_outstanding_amount > 0) || (tei.indate <= '2016-05-13 17:00:00' && ((tei.grandTotal - tei.amount_recived > 10) || tei.amount_recived IS NULL))) ")
		->where("(ta.status= '3' OR ta.status= '4' OR ta.status= '6' OR ta.status= '7')");
		//$this->db->order_by("ta.id","DESC");
		//$this->db->limit("1");
		//$this->datatables->generate();
		//$this->db_last_query();
		// echo 'test';die;
                return $this->datatables->generate();
    }
	
	function updateRealizationPopupData($auctionID){
		
		$tax = $this->db->get("tbl_taxmaster")->row_object();
		
		
		
		$this->db->where('auctionID', $auctionID);
		$query_invoice = $this->db->get("tbl_event_invoice");
		$data=$query_invoice->result();
                
                
                //credit note 
		$this->db->where('auctionID', $auctionID);
		//$this->db->where("(status= '6' OR status= '7')");  ///previous condition before 4-march-2016
         $this->db->where("(status= '1')");
		$credit = $this->db->get("tbl_auction_credit_note")->row_array();
		//$amount=$data[0]->amount+(($data[0]->amount*$tax->stax)/100)+(($data[0]->amount*$tax->educess)/100);
                $amount=$data[0]->amount;
		//$data[0]->amount = $amount - $credit['amount'];
		$this->db->select('reference_no,branch_id');
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction");
		$data[0]->auction=$query_auction->result();
                $data['credit_amount']=$credit['grandTotal'];
                return $data;
	}
	function getOutstandingBranchWise($branchID)
	{
		
		$sql="
		SELECT  A.auctionID,B.bank_id,B.branch_id,count(A.auctionID)as total_auction, B.bank_id,  C.name as bank_name,D.name as branch_name, sum(A.grandTotal) as invoiceamount,
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
		) as  tds_deduction_amount,
		SUM(case  
				when A.other_deduction_amount = 0 OR A.other_deduction_amount IS NULL then 0
				else A.other_deduction_amount
			end) as  other_deduction_amount,
		SUM(case  
				when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
				else tacn.grandTotal
			end) as credit_note,
			
		
	    (sum(A.grandTotal) -Sum(case when amount_recived IS NULL then 0 else amount_recived end)) as outstandingAmt,
	    (SELECT sum(amount) FROM tbl_branch_collection WHERE branch_id = B.branch_id  and status = 1) as onAccountPayment,
	    (SELECT sum(justified_amount) FROM tbl_branch_collection WHERE branch_id = B.branch_id  and status = 1) as settledAmount,
	    (SELECT sum(remaining) FROM tbl_branch_collection WHERE branch_id = B.branch_id  and status = 1) as remainingAmount 
		FROM `tbl_event_invoice` A
			Inner JOIN  tbl_auction B ON A.auctionID = B.id
			Inner JOIN tbl_bank C ON B.bank_id = C.id
			JOIN `tbl_branch` D ON `B`.`branch_id`=`D`.`id`
			Left JOIN tbl_taxmaster as tm ON tm.start_date <= A.invoiceDate and tm.end_date >= A.invoiceDate
			Left JOIN tbl_auction_credit_note as tacn ON A.auctionID = tacn.auctionID and tacn.status = 1 and tacn.verified = 1			
			Where B.branch_id='".$branchID."' AND (B.status= '6' OR B.status= '7' OR B.status= '3' OR B.status= '4')
		group by B.branch_id";
		$query=$this->db->query($sql);
		
		$totalRow=$query->num_rows();
		//echo $this->db->last_query();
		if($totalRow>0)
		{
			return $query->result();
		}
			
	}
	function updateBranchWisePayment()
	{
		$branchID 	= $this->input->get('branchID');
		$realizationAmount 	= $this->input->post('realizationAmount');
		$remark 	= $this->input->post('remark');
		$created_by 	= $this->input->post('created_by');		
		$realizationDate 	= $this->input->post('realizationDate');
		$userId = $this->session->userdata('id');
		
		$this->db->where("id",$branchID);	    
	    $this->db->limit('1');
	    $query=$this->db->get('tbl_branch');
	    $results=$query->result();
        foreach($results as $branch)
        {    
			$data = array(
						 'bank_id'=>$branch->bank_id,
						 'branch_id'=> $branchID,
						 'amount'=>$realizationAmount,
						 'justified_amount'=>0,
						 'remaining'=>$realizationAmount,
						 'posting_id'=>$created_by,
						 'createdBy'=>$userId,
						 'indate'=>date("Y-m-d H:i:s"),
						 'remark'=>$remark,
						 'posted_date'=>$realizationDate,
						 'status'=>'1'
					  );  
					  
				$this->db->insert('tbl_branch_collection',$data);
				return true;
		}		
		return false;
	    
	}
	
	function updateRealizationOnAccount($auctionID,$branchCollectionID){ 
		
		if($this->db->table_exists('tbl_branch_collection'))
		{
		
			$this->db->where('id', $branchCollectionID);
			$this->db->where('status', '1');
			$query = $this->db->get('tbl_branch_collection');
			if($query->num_rows() > 0)
			{
		        $result = $query->result();
		        $branchCollection = $result[0];
		        
		        if($branchCollection->remaining >= $net_amount_recived)
		        {
		        
					$userId = $this->session->userdata('id');
			
					$tds_deduction_amount 	= $this->input->post('tds_deduction_amount');
					$other_deduction_amount 	= $this->input->post('other_deduction_amount');
					$net_amount_recived 	= $this->input->post('realizationAmount');                
					$remark 	= $this->input->post('remark');       
					$realizationDate 	= $this->input->post('realizationDate');         
					
					$this->db->where('auctionID', $auctionID);
					$eventdetail=$this->db->get('tbl_event_invoice')->result();
					$invoice = $eventdetail[0];
					
					$amount_recived = (float)$invoice->amount_recived + $net_amount_recived;
						 
					$remainingAmount =  $invoice->grandTotal - round($invoice->credit_note_amount) - $tds_deduction_amount -  $other_deduction_amount - $amount_recived;
					
					$netreciviable_amount = $invoice->grandTotal - round($invoice->credit_note_amount) - $tds_deduction_amount -  $other_deduction_amount;
					
					if($remainingAmount >= 0)
					{
						$data = array(					 
							 'tds_deduction_amount'=>$tds_deduction_amount,
							 'other_deduction_amount'=>$other_deduction_amount,
							 'net_reciviable_amount'=>$netreciviable_amount,
							 'balance_outstanding_amount'=>$remainingAmount,
							 'realizationDate'=>$realizationDate,
							 'realizationAmount'=>$remainingAmount,
							 'remark'=>$remark,
							 'amount_recived'=>$amount_recived
						  );

						$this->db->where('auctionID', $auctionID);
						$this->db->update('tbl_event_invoice',$data);
						
						$this->db->where('id', $auctionID);
						$status=$this->db->update('tbl_auction',array('is_payment_recived'=>1));	
						
						if($this->db->table_exists('tbl_collection_log'))
						{
							$logData = array(
								 'auctionID'=>$auctionID,
								 'branch_collection_id'=>$branchCollectionID,
								 'amount_recived'=>$net_amount_recived,
								 'tds_deduction_amount'=>$tds_deduction_amount,
								 'other_deduction_amount'=>$other_deduction_amount,
								 'realizationDate'=>$realizationDate,
								 'createdBy'=>$userId,
								 'ip'=>$_SERVER['REMOTE_ADDR'],
								 'indate'=>date("Y-m-d H:i:s")
							  );
						  
							  $this->db->insert('tbl_collection_log',$logData);
						}
					
					
						
						  
						  $collectionData = array(
							 'justified_amount'=>$branchCollection->justified_amount + $net_amount_recived,
							 'remaining'=>$branchCollection->remaining - $net_amount_recived
						  );					  
						  $this->db->where('id', $branchCollectionID);
						  $this->db->update('tbl_branch_collection',$collectionData);
						
					}
				}
			}
		}
                  
	return $status;
}
	       
	       
	function updateRealization(){                           
				$userId = $this->session->userdata('id');
		
                $invoiceamount 	= $this->input->post('invoiceamount');
                $service_tax_amount 	= $this->input->post('service_tax_amount');
                $swacchbharat_tax_amount 	= $this->input->post('swacchbharat_tax_amount');
                $credit_note_amount 	= $this->input->post('credit_note_amount');
                $tds_deduction_amount 	= $this->input->post('tds_deduction_amount');
                
              //  if($invoiceamount->tds_deduction_amount){
              //      $tds_deduction_amount=$invoiceamount->tds_deduction_amount+$tds_deduction_amount;
              //  }
                $other_deduction_amount 	= $this->input->post('other_deduction_amount');
                // if($invoiceamount->other_deduction_amount){
                //    $other_deduction_amount=$invoiceamount->other_deduction_amount+$other_deduction_amount;
               // }
                
                $net_reciviable_amount 	= $this->input->post('net_reciviable_amount');
                $netreciviable_amount = $this->input->post('netreciviable_amount');
                $balance_outstanding_amount 	= $this->input->post('balance_outstanding_amount');
                $amount_recived 	= $this->input->post('amount_recived');
                
                $realizationAmount 	= $this->input->post('realizationAmount');
                $remark 	= $this->input->post('remark');
                $auctionID 	= $this->input->post('auctionID');
                $this->db->where('auctionID', $auctionID);
                $eventdetail=$this->db->get('tbl_event_invoice')->result();
                 
               
				$realizationDate 	= $this->input->post('realizationDate');
                
                /*if(!empty($realizationAmount)){ 
                   $amount_recived=$realizationAmount+$amount_recived;
                }*/
                
                if(!empty($realizationAmount)){ 
                   $amount_recived = $net_reciviable_amount + $realizationAmount;
                }
                
                $remainingAmount = number_format($netreciviable_amount - $amount_recived,2,".","");
                
                
		//$created_by	= $this->session->userdata['id'];
				$data = array(
					 'amount'=>$invoiceamount,
					 'service_tax_amount'=> $service_tax_amount,
					 'swacchbharat_tax_amount'=>$swacchbharat_tax_amount,
					 'credit_note_amount'=>$credit_note_amount,
					 'tds_deduction_amount'=>$tds_deduction_amount,
					 'other_deduction_amount'=>$other_deduction_amount,
					 'net_reciviable_amount'=>$netreciviable_amount,
					 'balance_outstanding_amount'=>$remainingAmount,
					 'realizationDate'=>$realizationDate,
					 'realizationAmount'=>$remainingAmount,
					 'remark'=>$remark,
					  'amount_recived'=>$amount_recived
                  );
                  //echo '<pre>';
              //print_r($data);die;
                $this->db->where('auctionID', $auctionID);
				$this->db->update('tbl_event_invoice',$data);
				$this->db->where('id', $auctionID);
				$status=$this->db->update('tbl_auction',array('is_payment_recived'=>1));	
				
				if($this->db->table_exists('tbl_collection_log'))
				{
					$logData = array(
						 'auctionID'=>$auctionID,
						 'amount_recived'=>$amount_recived,
						 'tds_deduction_amount'=>$tds_deduction_amount,
						 'other_deduction_amount'=>$other_deduction_amount,
						 'realizationDate'=>$realizationDate,
						 'createdBy'=>$userId,
						 'ip'=>$_SERVER['REMOTE_ADDR'],
						 'indate'=>date("Y-m-d H:i:s")
					  );
                  
					$this->db->insert('tbl_collection_log',$logData);
			    }
                  
				return $status;
	       }
               
        function fetchTax($auctionID)
        {
			  $auctionInvoiceDate = $this->getInvoiceDate($auctionID);
			  
			  $this->db->where("start_date <= '".$auctionInvoiceDate."' and end_date >= '".$auctionInvoiceDate."'");
			  $this->db->order_by('id DESC');
			  $this->db->limit('1');
              $query=$this->db->get('tbl_taxmaster');
              
             // echo $this->db->last_query();
            //  die;	
              $result=$query->result();
              
             
			  return $result;  
                
        }  
        
        function getauctionendDate($auctionID)
        {
			
              $this->db->where('id', $auctionID);
              $endDate=$this->db->get('tbl_auction')->result();
              if(isset($endDate[0]))
              {
				return $endDate[0]->auction_end_date;  
				}else{
					return 0;
				}
                
        } 
        
        function getInvoiceDate($auctionID)
        {
			
              $this->db->where('auctionID', $auctionID);
              $endDate=$this->db->get('tbl_event_invoice')->result();
              if(isset($endDate[0]))
              {
				return $endDate[0]->invoiceDate;  
				}else{
					
				  return  '0000-00-00 00:00:00';  
			
				}
                
        } 
		
		function getMailUser($auctionid)
		{

			 $this->db->where('id', $auctionid);
             $results = $this->db->get('tbl_auction')->result();
			 $mailArr = array();
			 foreach($results as $user)
			 {
				 if($user->invoice_mail_to > 0)
				 {
					 $mailArr[] = $user->invoice_mail_to;
				 }

				 if($user->invoice_mailed != '0')
				 {

					 $arr = explode(",",$user->invoice_mailed);
					 if(is_array($arr))
					 {
						 foreach($arr as $m)
						 {
							 $mailArr[] = $m;
						 }
					 }
				 }
			 }
				
			$mailUserArr = array();
			if(is_array($mailArr) && count($mailArr))
			{
			  $this->db->where_in('id', $mailArr);              
			  $results = $this->db->get('tbl_user')->result();

			  foreach($results as $user)
			  {

				$mailUserArr[] = array("email" => $user->email_id,"first_name"=>$user->first_name,"designation"=>$user->designation);
			  }

			}
			return $mailUserArr;


		}
        
	
		
	    function invoiceMailTo1($path){
		$auctionID 	= $this->input->post('auctionID');
		$mailTo1 	= $this->input->post('mailTo1');
		$mailTo 	= $this->input->post('mailTo');
		$mailTo[]=$mailTo1;
		$mailCc 	= $this->input->post('mailCc');
		$email_msg ="<p><b>Dear Sir/ Madam</b>, <br/> <br/>
		Please find the enclosed invoice raised on ".date("d/m/Y")." for e-auction conducted. The invoice is due for payment. Kindly release our payment at earliest. Also mail the payment details to the undersigned at support@c1india.com after sending the payment.</p>  <br/><br/>
		<p>Regards,<br/>
		Accounts & Controls <br/>";
		
		$email_msg .= BRAND_NAME."<br/>
					Plot Number 301,<br/>
					1st Floor,<br/>
					Udyog Vihar Phase – 2,<br/>
					Gurgaon- 122015<br/>
					Haryana, India<br/>
					www.c1india.com<br/>
					Tel: +91-124-4302 000<br/>
					email: accounts@c1india.com	<br/></p>";	
		
		$mailTo = array_unique($mailTo);
		$mailCc = array_unique($mailCc);
		$createdTime = date("Y-m-d H:i:s");
		if(is_array($mailTo))
		{		
				
				foreach($mailTo as $mail)
				{
					
					$this->db->where('email_id', $mail);
					$users=$this->db->get('tbl_user')->result();
					if(isset($users[0]))
					{
						$UserNo = $users[0]->id;
					}	
					if($UserNo > 0)
					{				
						$data = array();
						$data['EventID']= $auctionID;
						$data['UserNo']= $UserNo;
						$data['SendTo']= 'MT';
						$data['CreationDate']= $createdTime;
						//print_r($data);die;
						
						$this->db->insert('tbl_mailsend',$data);	
					}				
					
				}
		}
		
		if(is_array($mailCc))
		{	
			$idArr = array();		
				foreach($mailCc as $mail)
				{
					if(!in_array($mail,$idArr))
					{
						$idArr[] = $mail;
						$this->db->where('email_id', $mail);
						$users=$this->db->get('tbl_user_registration')->result();
						if(isset($users[0]))
						{
							$UserNo = $users[0]->id;
						}
						if($UserNo > 0)
						{
							$data = array();
							$data['EventID']= $auctionID;
							$data['UserNo']= $UserNo;
							$data['SendTo']= 'CC';
							$data['CreationDate']= $createdTime;
						
							$this->db->insert('tbl_mailsend',$data);
						}
					}
				}
		}
		
		//print_r($mailCc);die;
		//die;
		$this->load->library('Email_new','email');
		$email = new email_new();
		//$res = $email->sendMailToUser($mailTo,'E-auction invoice due for payment',$email_msg,$path,$mailCc);
		if($res)
		{
				return 1;
		}
		else
		{
				return 0;
		}
}

   function completedEventPaymentDuedatatable(){	
       $this->db->query("SET @row = 0",false); 
         $this->datatables->select(" @row := @row + 1 as SNo,ta.id,tei.invoiceNo, ta.event_title, CONCAT(tb.name ,' ','(',tbr.name  ,' )') as bank_branch_name,DATE_FORMAT(ta.auction_start_date,'%d/%b/%Y %h:%i:%s %p'),DATE_FORMAT(ta.auction_end_date,'%d/%b/%Y %h:%i:%s %p')",false)
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->where('ta.is_invoice_generated',1)
		->where('ta.is_payment_recived ',0)
		->where("(ta.status= '6' OR ta.status= '7')");
        return $this->datatables->generate();
    }
   function searchDatatable()
    {	        $bank_id        =$this->input->get('bank');
		$salesExecutive =$this->input->get('salesExecutive');
		$zone           =$this->input->get('zone');
		$status         =$this->input->get('status');
		$invoiceRasied  =$this->input->get('invoiceRasied');
		$paymentRecieved=$this->input->get('paymentRecieved');
		$auctionID      =$this->input->get('auctionID');
        $this->db->query("SET @row = 0",false); 
        $this->datatables->select(" @row := @row + 1 as SNo,ta.id,  CONCAT(tb.name ,' ','(',tbr.name  ,' )') as bank_branch_name, ta.reference_no ,(
    CASE 
        WHEN tei.invoiceNo != '' and tei.status =1 THEN tei.invoiceNo
        ELSE 'No'
    END) as invoiceNo,
      IF(ta.is_payment_recived = '1','Yes','No') as  payment_recived,tur.first_name,  CASE ta.status
      WHEN 0 THEN 'Saved'
      WHEN 1 THEN 'Published'
      WHEN 3 THEN 'Stay'
      WHEN 4 THEN 'Cancel'
      WHEN 6 THEN  CASE (select count(*) from tbl_auction_participate WHERE final_submit = 1 and auctionID = ta.id) WHEN 0 THEN 'Unsuccess' ELSE 'Success' END
      WHEN 7 THEN 'Conclude'
      ELSE 'Published'
      END AS status ,DATE_FORMAT(ta.indate,'%d/%b/%Y %h:%i:%s %p')",false)
		//->unset_column('bank_name')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_event_log_sales as tesl','ta.eventID=tesl.id','left ')
		->join('tbl_user_registration as tur','tur.id=tesl.sales_executive_id','left ')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->join('tbl_c1zone as tbz','tbz.id = tur.c1zone_id','left ');
		if($bank_id)
		{
				$this->datatables->where('ta.bank_id',$bank_id);	
		}
		if($paymentRecieved !='')
		{
				$this->datatables->where('ta.is_payment_recived',$paymentRecieved);
		}	
		if($invoiceRasied !=''){
				$this->datatables->where('ta.is_invoice_generated',$invoiceRasied);	
		}
		if($auctionID){
				$this->datatables->where('ta.id',$auctionID);	
		}
		if($status==1){
				$this->datatables->where('ta.status IN(1,3,4,6,7)');
		}
		if($status==6){
				$this->datatables->where('ta.status IN(6,7)');
		}
		if($zone > 0)
		{
			/*if($zone == '2')
			{
				$zone = '1';	
			}
			else if($zone == '4')
			{
				$zone = '2';	
			}*/
			
			$this->datatables->where('tbz.id', $zone);
		}
		if($salesExecutive > 0)
		{
			$this->datatables->where('tesl.sales_executive_id', $salesExecutive);
		}
       
	    return $this->datatables->generate();
    }
	
	
   function addInvoiceDetailDatatable() {
        $this->datatables->select(" ta.id, ta.reference_no,tb.name as bank_name, tbr.name as branch_name,
				DATE_FORMAT(ta.auction_end_date,'%d/%b/%Y %h:%i:%s %p'),CASE ta.status
				WHEN 3 THEN 'Stay'
				WHEN 4 THEN 'cancel'
				WHEN 6 THEN CASE (select count(*) from tbl_auction_participate WHERE final_submit = 1 and auctionID = ta.id) WHEN 0 THEN 'Unsuccess' ELSE 'Success' END
				WHEN 7 THEN 'Conclude'
				ELSE 'Published'
				END AS status",false)
				->add_column('Actions', "<a  href='/account/generateInvoice/$1'>Generate Invoice</a>", 'ta.id')
				->from('tbl_auction as ta')
				->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
				->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
				//->join('tbl_auction_participate as tap','tap.auctionID=ta.id and tap.final_submit = 1','left')
				//->where('ta.auction_type',0)
				->where('ta.is_invoice_generated',0)
				//->where('tap.final_submit',1)
				->where('now() >= ta.auction_end_date')
				//->where("(ta.auction_bidding_activity_status IS NULL OR ta.auction_bidding_activity_status = '0')")
				->where("(ta.status= '6' OR ta.status= '7' OR ta.status= '3' OR ta.status= '4')");
//				->group_by("tap.auctionID");
				//$this->db->order_by("ta.id","ASC");
				
				//$this->datatables->generate();
				
				//echo $this->db->last_query();die;
				
				
				return $this->datatables->generate();
    }
	 function duplicateaddInvoiceDetailDatatable() {
        $this->datatables->select(" ta.id, ta.reference_no,tb.name as bank_name, tbr.name as branch_name,
				DATE_FORMAT(ta.auction_end_date,'%d/%b/%Y %h:%i %p'),  CASE ta.status
				WHEN 3 THEN 'Stay'
				WHEN 4 THEN 'cancel'
				WHEN 6 THEN CASE (select count(*) from tbl_auction_participate WHERE final_submit = 1 and auctionID = ta.id) WHEN 0 THEN 'Unsuccess' ELSE 'Success' END
				WHEN 7 THEN CASE (select count(*) from tbl_auction_participate WHERE final_submit = 1 and auctionID = ta.id) WHEN 0 THEN 'Unsuccess' ELSE 'Success' END
				ELSE 'Published'
				END AS status",false)
				->add_column('Actions', "<a target='_blank' href='/pdfdata/generateAccountInvoicePdf/$1'>Duplicate Invoice</a>", 'ta.id')
				->from('tbl_auction as ta')
				->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
				->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
				//->where('ta.auction_type',0)
				->where('ta.is_invoice_generated',1)
				->where("(ta.status= '6' OR ta.status= '7'  OR ta.status= '3' OR ta.status= '4')");
				return $this->datatables->generate();
    }
	
	public function onAccountPaymentDetailTable()
    {	
	
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');	
		$controller = $this->input->get('controller');
		$type = $this->input->get('type');
		$id = $this->input->get('id');
		
		if(preg_match("/00:00:00/",$end_date))
		{
			$end_date = date("Y-m-d 23:59:59",strtotime($end_date));
		}
			
        $this->db->query("SET @row = 0",false); 
        $this->datatables->select("c.posted_date,
									b.name as bank_name,
									br.name as branch_name,
									(c.amount),
									(c.justified_amount) as justified,
									(c.remaining) as remaining,
									c.id as id
									",false)
		->add_column('Actions', "<a  class='followUpNote_iframe' href='/".$controller."/showbranchWiseInvoice/$1'>Show Detail</a>", 'id')		
		->unset_column('id')
        ->from('tbl_branch_collection as c')        
        ->join('tbl_bank as b','b.id=c.bank_id','left')        
		->join('tbl_branch as br','br.id=c.branch_id','left ');
		
		
		$this->db->where("c.status","1");	
			
				
		if($start_date != "" && $end_date != "")
		{
			$this->db->where("(c.posted_date >= '".$start_date."' && c.posted_date <= '".$end_date."')");
		}
		
		if($id > 0 && $type == 'branch')
		{
			$this->db->where("c.branch_id",$id);	
		}
		else if($id > 0 && $type == 'bank')
		{
			$this->db->where("c.bank_id",$id);
		}	
		
		//$this->db->where("c.remaining > 0");
		
        return  $this->datatables->generate();
    }
    
    public function showbranchWiseInvoiceTable($branchCollectionID = "")
    {
		
		$this->datatables->select("E.posted_date,E.amount,B.id,A.invoiceNo,A.grandTotal,Case WHEN A.amount_recived IS NULL THEN 0 ELSE A.amount_recived END as amount_recived,A.balance_outstanding_amount,B.id as eventID",false)
		->add_column('Actions', "<a  class='followUpNote_iframe' href='/collection/updatePaymentOnAccount/$1/".$branchCollectionID."'>Update Payment</a>", 'eventID')		
		->unset_column('eventID')
        ->from('tbl_event_invoice as A')
        ->join('tbl_auction as B','A.auctionID = B.id')        
		->join('tbl_bank as C','B.bank_id = C.id')
		->join('tbl_branch as D','B.branch_id=D.id')
		->join('tbl_branch_collection as E','E.branch_id=D.id')
		->join('tbl_auction_credit_note as tacn','A.auctionID = tacn.auctionID','left');
		
		$this->db->where_in("B.status",array(3,4,6,7));
		$this->db->where("E.id",$branchCollectionID);	
		$this->db->where("A.balance_outstanding_amount > 0");
		
		return  $this->datatables->generate();
	}
	
	
   function paymentFollowUpListDatatable()
    {	
	
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');	
		$controller = $this->input->get('controller');
		
		if(preg_match("/00:00:00/",$end_date))
		{
			$end_date = date("Y-m-d 23:59:59",strtotime($end_date));
		}
			
        $this->db->query("SET @row = 0",false); 
        $this->datatables->select(" @row := @row + 1 as SNo,ta.id, ta.reference_no, tei.invoiceNo,
		FORMAT(round(tei.grandTotal),2) as amount,DATE_FORMAT(tei.invoiceDate,'%d/%b/%Y %h:%i %p'), 
		CASE ta.status 
		WHEN '0' THEN 'Saved'
		WHEN '1' THEN 'publish'
		WHEN '2' THEN 'initialize'
		WHEN '3' THEN 'stay'
		WHEN '4' THEN 'cancel'
		WHEN '5' THEN 'deleted'
		WHEN '6' THEN 'completed'
		WHEN '7' THEN 'conclude'
		ELSE 'Saved' 
		END as status, 
		(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id and tbl_auction_participate.final_submit = 1 ) as total_bidder, (select count(tfu.id) from tbl_follow_up tfu where tfu.auctionID= ta.id ) as total_follow, (select remarks from tbl_follow_up where tbl_follow_up.auctionID= ta.id order by id desc limit 1) as remarks ,(select count(id) from tbl_follow_up where tbl_follow_up.auctionID= ta.id and tbl_follow_up.forwardedToSales=1 ) as forwarded",false)
		->add_column('Actions', "<a  class='followUpNote_iframe' href='/".$controller."/followUpPopup/$1'>Folloup Note</a>", 'ta.id')
		->unset_column('forwarded')
                ->from('tbl_auction as ta')
        ->join('tbl_follow_up as fup','ta.id=fup.auctionID','left')        
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID','left ')	
		->where('ta.is_invoice_generated',1)		
		->where('ta.is_payment_recived = 0')
		->where("(ta.status= '6' OR ta.status= '7' OR ta.status= '3' OR ta.status= '4')");	
			
		$this->db->having('forwarded >= 0');		
		if($start_date != "" && $end_date != "")
		{
			$this->db->where("(followUp >= '".$start_date."' && followUp <= '".$end_date."')");
		}
		$this->db->group_by('ta.id');
		$this->db->order_by('fup.followUp','DESC');
        return  $this->datatables->generate();
    }
    
    function excutiveWiseFollowUpListDatatable()
    {	
	
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');	
		$controller = $this->input->get('controller');
		
		if(preg_match("/00:00:00/",$end_date))
		{
			$end_date = date("Y-m-d 23:59:59",strtotime($end_date));
		}
		
		if($start_date != "" && $end_date != "")
		{
			$addSql = "(f.followUp >= '".$start_date."' && f.followUp <= '".$end_date."')";
		}
		else
		{
			$addSql = "(f.followUp >= '2008-01-01' && f.followUp <= '".date("Y-m-d H:i:s")."')";
		}
			
        $this->db->query("SET @row = 0",false); 
        //@row := @row + 1 as SNo
        $this->datatables->select(" fup.id,
									CONCAT(u.first_name,' ',u.last_name) as name,
									count(fup.auctionID) as total,
									count(CASE WHEN (SELECT id FROM tbl_follow_up as fup2 WHERE fup2.auctionID = fup.auctionID and fup2.indate >= fup.followUp limit 1) THEN NULL ELSE 0 END) as pendingFollowUp,
									count(CASE WHEN (SELECT id FROM tbl_follow_up as fup2 WHERE fup2.auctionID = fup.auctionID and fup2.indate >= fup.followUp limit 1) THEN 1 ELSE NULL END) as doneFollowUp,
									sum(round(g.outstandingAmount))",false)
        ->from('tbl_auction as ta')        
        ->join('tbl_follow_up as fup','ta.id=fup.auctionID') 
        ->join('(select MAX(f.id) as id,(i.grandTotal - 
												CASE WHEN i.amount_recived IS NULL THEN 0 ELSE i.amount_recived END - 
												CASE WHEN i.credit_note_amount IS NULL THEN 0 ELSE i.credit_note_amount END  - 
												CASE WHEN i.tds_deduction_amount IS NULL THEN 0 ELSE i.tds_deduction_amount END -
												CASE WHEN i.other_deduction_amount IS NULL THEN 0 ELSE i.other_deduction_amount END) as outstandingAmount from tbl_event_invoice as i,tbl_follow_up as f WHERE i.auctionID = f.auctionID and '.$addSql.' group by f.auctionID) as g',"g.id = fup.id","left")                       
        ->join('tbl_user_registration as u','fup.user_id=u.id')
		->join('tbl_event_invoice as tei','ta.id=tei.auctionID')	
		->where('ta.is_invoice_generated',1)
		->where('ta.is_payment_recived',0)
		//->where('ta.id',26360)
		//->where('(fup.id IN(SELECT MAX(id) FROM tbl_follow_up where id = fup.id group by auctionID))')
		->where("(ta.status= '6' OR ta.status= '7' OR ta.status= '3' OR ta.status= '4')");		
		
		if($start_date != "" && $end_date != "")
		{
			$this->db->where("(fup.followUp >= '".$start_date."' && fup.followUp <= '".$end_date."')");
		}
		else
		{
			$this->db->where("(fup.followUp >= '2008-01-01' && fup.followUp <= '".date("Y-m-d H:i:s")."')");
		}
		$this->db->group_by('u.id');		
        return  $this->datatables->generate();
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
    {	        //$this->db->select('reference_no,branch_id');
		 $this->db->where('auctionID', $auctionID);
		 $query_auction = $this->db->get("tbl_follow_up");
		 $data=array();
		foreach($query_auction->result() as $row){
		 $data[]=$row;
		}
		return $data; 
    }
    function insertFollowUp(){
		
		$auctionID 	= $this->input->post('auctionID');
		$status 	= $this->input->post('status');
		$remarks 	= $this->input->post('remarks');
		$nextFollow = $this->input->post('nextFollow');
		$froward 	= $this->input->post('froward');
		$eventID 	= $this->input->post('eventID');
		$created_by	= $this->session->userdata('id');
		$user_type	= $this->session->userdata('user_type');
		
		$indate=date('Y-m-d H:i:s');
		$data = array(          
					'auctionID'=>$auctionID,
					'eventID'=>$eventID,
					'status'=>$status,
					'remarks'=>$remarks,
					'followUp'=>$nextFollow,
					'indate'=>$indate,
					'user_id'=>$created_by,
					'forwardedToSales'=>$froward,
					'user_type'=>$user_type
		);
		$this->db->insert('tbl_follow_up',$data);
		//echo $this->db->last_query();die(123);
    }
    function insertCreditNote($auctionID){
		if(!($auctionID > 0))
		{
			$auctionID 	= $this->input->post('auctionID');
		}
		$submit = $this->input->post('search');
		if(isset($submit) and !empty($submit))
		{
			$financial_year = $this->input->post('financial_year');
			$financial_yearArr = explode("-",$financial_year);
			$this->db->where("invoiceDate >= '".$financial_yearArr[0]."-04-01 00:00:00'");
			$this->db->where("invoiceDate <= '".$financial_yearArr[1]."-03-31 23:59:59'");
		}
        
		$this->db->where('auctionID', $auctionID);
		$this->db->where('status', '1');
		$query2 = $this->db->get("tbl_event_invoice");
		//echo $this->db->last_query();die;
		if($query2->num_rows()==0)
		{ 
			return false;
		}
		else
		{
			/* get invoice data */
			$invoicedamount = $query2->result();
			$data['invoice'] = $invoicedamount[0];
			$data['outstanding'] = (Float)$data['invoice']->grandTotal - (Float)$data['invoice']->tds_deduction_amount - (Float)$data['invoice']->other_deduction_amount - (Float)$data['invoice']->amount_recived - (Float)$data['invoice']->credit_note_amount;
			
			$year = date("Y",strtotime($data['invoice']->invoiceDate));
			if(date("m",strtotime($data['invoice']->invoiceDate)) > 3)
			{
				$data['financial_year'] = $year ." - ".($year+1);
			}
			else
			{
				$data['financial_year'] = ($year-1)." - ".$year;
			}
				
			/* get credit note data */		
			$this->db->where('auctionID', $auctionID);			
			$query3 = $this->db->get("tbl_auction_credit_note");
			if($query3->num_rows() > 0)
			{
				$creditnot = $query3->result();
				$data['creditnote'] = $creditnot[0];	
			}
			
			/* get auction data */
			$this->db->where('id', $auctionID);			
			$query4 = $this->db->get("tbl_auction");
			if($query4->num_rows() > 0)
			{
				$auctiondata = $query4->result();
				$data['auctionData'] = $auctiondata[0];	
			}
			
			/* get tax data */
			$this->db->where('start_date <=', $data['invoice']->invoiceDate);			
			$this->db->where('end_date >=', $data['invoice']->invoiceDate);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);	
			$query5 = $this->db->get("tbl_taxmaster");
			//echo $this->db->last_query();die;
			if($query5->num_rows() > 0)
			{
				$taxdata = $query5->result();
				$data['taxData'] = $taxdata[0];				
			}
			
			/* get tax data */
			$this->db->where("(register_as = 'mis' or user_type = 'mis')");	
			$this->db->where("status",1);		
			$query6 = $this->db->get("tbl_user_registration");
			
			//echo $this->db->last_query();die;
			if($query6->num_rows() > 0)
			{
				$misData = $query6->result();
				$data['misData'] = $misData;				
			}
			
		}
		//echo '<pre>';
		//print_r($data);die;
		return $data;
	}
	
	function getCreditNoteNo($auctionID)
	{
		
		/* get credit note data */		
		$this->db->where('auctionID', $auctionID);			
		$query3 = $this->db->get("tbl_auction_credit_note");
		if($query3->num_rows() > 0)
		{
			$creditnot = $query3->result();
			$data['creditnote'] = $creditnot[0];	
		}
		if($data['creditnote']->verified == 1)
		{
			return $data['creditnote']->credit_noteID;
		}
		
		/* get auction data */
		$this->db->where('id', $auctionID);			
		$query4 = $this->db->get("tbl_auction");
		if($query4->num_rows() > 0)
		{
			$auctiondata = $query4->result();
			$data['auctionData'] = $auctiondata[0];	
		}
		
		$financialyeardate = (date('m')<'04') ? date('y-04-01',strtotime('-1 year')) : date('y-04-01'); 
		list($startfinyear, $month, $day)  = explode("-", $financialyeardate);
		$fy = $startfinyear + 1;
	
		$branch_id = GetTitleByField('tbl_user', "id='".$data['auctionData']->invoice_mail_to."'", 'user_type_id');
		$bank_name = GetTitleByField('tbl_bank', "id='".$data['auctionData']->bank_id."'", 'name');
		
		$this->db->where('verified', '1');			
		$this->db->where('status', '1');
		$this->db->where('serial_no IS NOT NULL');
		$this->db->order_by('serial_no', 'DESC');
		$this->db->limit(1);
		$query3 = $this->db->get("tbl_auction_credit_note");
		if($query3->num_rows() > 0)
		{
			$creditnot = $query3->result();
			$id = $creditnot[0]->serial_no;	
			$id += 1;
		}
		else
		{
			$this->db->where('verified', '1');			
			$this->db->where('status', '1');			
			$this->db->order_by('id', 'DESC');
			$this->db->limit(1);
			$query3 = $this->db->get("tbl_auction_credit_note");
			$creditnot = $query3->result();
			$id = $creditnot[0]->id;
			$id += 1;
		}
		
		$len = 6;
		$i = strlen($id);
		while($i < $len)
		{
			$id = "0".$id;
			$i++;
		}
		$credit['no'] = 'CN\E-AUCTION\ ' .$startfinyear.'-'.$fy.'\ '. $bank_name.'\ '.$branch_id.'\ '.$id;
		$credit['serial_no'] = (int)$id;
		
		
		return $credit;
	}
	
	function generateCreditNote($auctionID){
        
        $amount 	= $this->input->post('base_credit_note_amount');
        $remark 	= $this->input->post('remark');
        $approval 	= $this->input->post('approval1');
        $data = $this->insertCreditNote($auctionID);
        
        $stax=$data['taxData']->stax;
        $swacchbharat_tax=$data['taxData']->swacchbharat_tax; 
        $krishi_kalyan=$data['taxData']->krishi_kalyan;
        $educationalCess=$data['taxData']->educess;         
        $secondaryhighertax = $data['taxData']->secondaryhighertax;        
         
		$stax = round($amount*$stax/100);	
		$swacchbharat_tax = round($amount*$swacchbharat_tax/100);
		$educess = round($amount*$educationalCess/100);		      
        $krishi_kalyan = round($amount*$krishi_kalyan/100);
        $secondaryhighertax = round($amount*$secondaryhighertax/100);       
        
		
		$grandTotal = $amount + $stax + $swacchbharat_tax + $educess + $krishi_kalyan + $secondaryhighertax;       
       
        $userID = $this->session->userdata('id');
		$indate=date('Y-m-d H:i:s');
		$cdata = array(         
						'auctionID'=>$auctionID,
						'amount'=>$amount,
						'service_tax'=>$stax,
						'educationalCess'=>$educess,
						'secondaryCess'=>$secondaryhighertax,
						'swacchbharat_tax'=>$swacchbharat_tax,  //swacchbharat
						'krishi_kalyan'=>$krishi_kalyan,  //krishi_kalyan
						'grandTotal'=>$grandTotal,
						'remark'=>$remark,
						'indate'=>$indate,
						'verified'=>2,
						'status'=>0,
						'remark'=>$remark,
						'approval' => $approval,
						'createdby' => $userID
					);
					
		$inamount= round($data['invoice']->grandTotal);

		$tds_deduction_amount = $data['invoice']->tds_deduction_amount;
		$other_deduction_amount = $data['invoice']->other_deduction_amount;
		$amount_recived = $data['invoice']->amount_recived;
	   
		$inamounttotal = $inamount - $tds_deduction_amount - $other_deduction_amount - $amount_recived;
		
		//echo $grandTotal."|".$inamounttotal;die;
	  if($grandTotal <= $inamounttotal && $grandTotal > 0 ){
		  
		  
		$this->db->where("auctionID",$auctionID);
		$query1 = $this->db->get('tbl_auction_credit_note');
		if($query1->num_rows() == 0)
		{
			$this->db->insert('tbl_auction_credit_note',$cdata);
			$id=$this->db->insert_id();
		}
		else
		{
			$this->db->where("auctionID",$auctionID);
			$this->db->update('tbl_auction_credit_note',$cdata);
			//echo $this->db->last_query();die;
			$id = $auctionID;
		}
						
		//$financialyeardate = (date('m')<'04') ? date('y-04-01',strtotime('-1 year')) : date('y-04-01'); 
		//list($startfinyear, $month, $day)  = explode("-", $financialyeardate);
		//$fy = $startfinyear + 1;
	
		//$branch_id = GetTitleByField('tbl_user', "id='".$invoice_mail_to."'", 'user_type_id');
		
		//$creditNo = 'CN\E-AUCTION\ ' .$startfinyear.'-'.$fy.'\ '. $bank_name.'\ '.$branch_id.'\ '.$id;
		
		//$balance_outstanding_amount = $data['invoice']->grandTotal - $data['invoice']->tds_deduction_amount - $data['invoice']->other_deduction_amount - $data['invoice']->amount_recived - $grandTotal;
		//$this->db->where('auctionID', $auctionID);
		//$this->db->update('tbl_event_invoice', array('credit_note_amount'=> $grandTotal,'balance_outstanding_amount'=>$balance_outstanding_amount));
		
		//$this->db->where('id', $id);
		//$this->db->update('tbl_auction_credit_note', array('credit_noteID'=>"$creditNo"));
		return $id;
	  }
    }
    
    function generateCreditNoteStep2($auctionID)
    {
		
		/* get invoice data */
		$this->db->where('auctionID', $auctionID);			
		$query4 = $this->db->get("tbl_event_invoice");
		if($query4->num_rows() > 0)
		{
			$result = $query4->result();
			$data['invoice'] = $result[0];	
		}
		
		/* get credit note data */
		$this->db->where('auctionID', $auctionID);			
		$query4 = $this->db->get("tbl_auction_credit_note");
		if($query4->num_rows() > 0)
		{
			$result = $query4->result();
			$data['creditnote'] = $result[0];	
		}
		
		$balance_outstanding_amount_without_cn = $data['invoice']->grandTotal - $data['invoice']->tds_deduction_amount - $data['invoice']->other_deduction_amount - $data['invoice']->amount_recived;
		
		if($data['creditnote']->grandTotal <= $balance_outstanding_amount_without_cn)
		{
		
			if($_FILES['document']['name'])
			{
				$document = $this->credit_note_document_upload('document');
				
			}
					
			$creditnoteArr = $this->getCreditNoteNo($auctionID);		
			$cdata = array(         
							'credit_noteID'=>$creditnoteArr['no'],
							'serial_no'=>$creditnoteArr['serial_no'],
							'indate'=>date("Y-m-d H:i:s"),
							'verified'=>1,
							'status'=>1
						);
						
			if($document != "")
			{
				$cdata['document'] = $document;
			}
			
			$this->db->where("auctionID",$auctionID);
			$this->db->update('tbl_auction_credit_note',$cdata);
			
		
			
			
			$balance_outstanding_amount = $data['invoice']->grandTotal - $data['invoice']->tds_deduction_amount - $data['invoice']->other_deduction_amount - $data['invoice']->amount_recived - $data['creditnote']->grandTotal;
			$this->db->where('auctionID', $auctionID);
			$this->db->update('tbl_event_invoice', array('credit_note_amount'=> $data['creditnote']->grandTotal,'balance_outstanding_amount'=>$balance_outstanding_amount));
		}
		else
		{
			$data['msg']='Net Credit Note Amount should be less than invoice/outstanding amount.';
			$this->session->set_flashdata('msg', $data['msg']);
			redirect('/account/creditNoteList');
		}
	}
	
    function frowardToSalesExecutiveListDatatable()
    {	
	 $query = $this->db->query("SELECT @row := @row + 1     as SNo, 
								ta.id, is_payment_recived, 
								CONCAT(u.first_name, ' ', u.last_name) as user_name, 
								ta.reference_no, 
								tei.invoiceNo, tei.amount, 
								tei.invoiceDate, 
								CASE ta.status 
								WHEN '0' THEN 'Saved' 
								WHEN '1' THEN 'publish' 
								WHEN '2' THEN 'initialize' 
								WHEN '3' THEN 'stay' 
								WHEN '4' THEN 'cancel' 
								WHEN '5' THEN 'deleted' 
								WHEN '6' THEN 'completed' 
								WHEN '7' THEN 'conclude' 
								ELSE 'Saved' END as status, 
								(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id and tbl_auction_participate.final_submit = 1) as total_bidder, 
								(select count(id) from tbl_follow_up where tbl_follow_up.auctionID= ta.id and tbl_follow_up.forwardedToSales=1 ) as forwarded 
								FROM (`tbl_auction` as ta) 
								LEFT JOIN `tbl_follow_up` as up ON `up`.`auctionID`=`ta`.`id` 
								LEFT JOIN `tbl_bank` as tb ON `ta`.`bank_id`=`tb`.`id` 
								LEFT JOIN `tbl_event_invoice` as tei ON `ta`.`id`=`tei`.`auctionID` 								
								LEFT JOIN `tbl_event_log_sales` as sales ON `sales`.`id`=`ta`.`eventID` 
								LEFT JOIN `tbl_user_registration` as u ON `u`.`id`=`sales`.`sales_executive_id` 
								WHERE `ta`.`is_invoice_generated` = 1 
								AND (ta.status= '6' OR ta.status= '7' OR ta.status= '3' OR ta.status= '4') 
								AND `ta`.`is_payment_recived` = 0 and up.`forwardedToSales` = 1 group by ta.id ORDER BY `SNo`"); 
	 
       
		return $query->result_array();
    }
    
    function downloadCreditNoteList()
	{
		$download 	= $this->input->get('download');
		$creditNote = $this->creditNoteListDatatable(true);
		$creditNoteLIst = $creditNote->result();
		
					
					$this->load->library('excel');
						//activate worksheet number 1
						$this->excel->setActiveSheetIndex(0);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('Invoice Report worksheet');
						$miestilo= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'b88c00')
										)
										);
								
						$miestilo2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'ffd85d')
														)
										);
						$miestilo3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'fff3cd')
														)
										);

						$miestilo_tab= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '867e4c')
										)
										);
										
						$miestilo_tab2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'c5be97')
														)
										);
						$miestilo_tab3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'eeece1')
														)
										);	
							
						
					   $miestilo_SEC= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '0000cc')
										)
										);
										
						$miestilo_SEC2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '579bff')
														)
										);
						$miestilo_SEC3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'e0ebf8')
														)
										);
						$miestilo_AUC= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '7030a0')
										)
										);
										
						$miestilo_AUC2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'c3b8d6')
														)
										);
						$miestilo_AUC3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'efecf4')
														)
										);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getTop()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getBottom()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getLeft()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getRight()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						
						$this->excel->getActiveSheet()->getStyle("A:S")->getFont()->setSize(9);
						$this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('B1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('C1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('D1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('E1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('F1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('G1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('H1')->applyFromArray($miestilo2);
					
						$this->excel->getActiveSheet()->setCellValue('A1', 'Event ID'); 			
						$this->excel->getActiveSheet()->setCellValue('B1', 'Invoice No'); 				
						$this->excel->getActiveSheet()->setCellValue('C1', 'Invoice Date');    		
						$this->excel->getActiveSheet()->setCellValue('D1', 'Invoice Amount');			
						if($download != 'approved')
						{
							$this->excel->getActiveSheet()->setCellValue('E1', 'Credit Note Amount');									
							$this->excel->getActiveSheet()->setCellValue('F1', 'Send for approval date');					
							$this->excel->getActiveSheet()->setCellValue('G1', 'Approval Remarks');					
							$this->excel->getActiveSheet()->setCellValue('H1', 'Approval Action');
						}
						else
						{
							$this->excel->getActiveSheet()->setCellValue('E1', 'CreditNote');
							$this->excel->getActiveSheet()->setCellValue('F1', 'Credit Note Amount');			
							$this->excel->getActiveSheet()->setCellValue('G1', 'Credit Note Date');
						}
						
							
						$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);	
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");		
						$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("45");
						$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);	
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");		
						$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
						
						if($download != 'approved')
						{
							$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);			
							$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
							$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("18");
							$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);			
							$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("20");
							$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("12");
						}
						else
						{
							$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);			
							$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("45");
							$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("15");
							$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);			
							$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("20");							
						}

					if(count($creditNoteLIst) > 0)
					{					
						$i=2;
						foreach($creditNoteLIst as $row)
						{
							$dateFormate = 'MMM D, YYYY h:mm';	
							
						
							$timeDiff = 19800;
							
							$this->excel->getActiveSheet()->getStyle("A:S")->getFont()->setSize(9);
							$this->excel->getActiveSheet()->getStyle('A'.$i.':S'.$i)->getAlignment()->setWrapText(true);
							
							
							$this->excel->getActiveSheet()->getStyle('A'.$i.':S'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);			
							//$this->excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);						
							$this->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($miestilo3);
						
							$this->excel->getActiveSheet()->setCellValue('A'.$i, $row->id);
							$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->invoiceNo);
							
							$this->excel->getActiveSheet()->setCellValue('C' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($row->invoiceDate) + $timeDiff));
							$this->excel->getActiveSheet()
								->getStyle('C'.$i)
								->getNumberFormat()
								->setFormatCode($dateFormate);				
							
							$this->excel->getActiveSheet()->setCellValue('D'.$i, $row->amount);
							
							if($download != 'approved')
							{
								$this->excel->getActiveSheet()->setCellValue('E'.$i, $row->camount);
															
								$this->excel->getActiveSheet()->setCellValue('F' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($row->indate) + $timeDiff));
								$this->excel->getActiveSheet()
									->getStyle('F'.$i)
									->getNumberFormat()
									->setFormatCode($dateFormate);
									
								$this->excel->getActiveSheet()->setCellValue('G'.$i, $row->approvalRemark);
								$this->excel->getActiveSheet()->setCellValue('H'.$i, $row->verified);
							}
							else
							{
								$this->excel->getActiveSheet()->setCellValue('E'.$i, $row->credit_noteID);
								$this->excel->getActiveSheet()->setCellValue('F'.$i, $row->camount);														
								$this->excel->getActiveSheet()->setCellValue('G' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($row->indate) + $timeDiff));
								$this->excel->getActiveSheet()
									->getStyle('G'.$i)
									->getNumberFormat()
									->setFormatCode($dateFormate);
									
																
							}
							
									
							$i++;	
						}
	
					}
						
						$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(18);
						$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(18);
						
						
						$filename='Invoice_Report.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
									 
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');
	}
   
    function creditNoteListDatatable($is_download = false)
    {
		$approved 	= $this->input->get('approved');
		$download 	= $this->input->get('download');
		
		if($approved > 0 || $download == 'approved')
		{
			$this->datatables->select("ta.id, tei.invoiceNo,tei.invoiceDate,tei.grandTotal as amount,tacn.credit_noteID,tacn.grandTotal as camount,tacn.indate,tacn.document",false);
		}
		else
		{
			$this->datatables->select("ta.id, tei.invoiceNo,
									   tei.invoiceDate,
									   tei.grandTotal as amount,
									   tacn.grandTotal as camount,
									   tacn.indate,
									   tacn.approvalRemark,									  
									   CASE tacn.verified
									  WHEN 0 THEN 'Pending'
									  WHEN 2 THEN 'Pending'
									  WHEN 3 THEN 'Accepted'
									  WHEN 4 THEN 'Rejected'									  
									  END AS verified",false);
		}

        $this->db->from('tbl_auction_credit_note as tacn')
		->join('tbl_event_invoice as tei','tacn.auctionID=tei.auctionID and tei.status="1"','left ')
		->join('tbl_auction as ta','ta.id=tacn.auctionID');
		
		if($approved > 0 || $download == 'approved')
		{
			$this->db->where("tacn.verified","1");
			//$this->db->add_column('Actions', "<a  class='followUpNote_iframe' href='/public/uploads/credit_note/$1'>Folloup Note</a>", 'tacn.document');
		}
		else
		{
			$this->db->where("tacn.verified !=",1);	
		}
		if($is_download)
		{
			$this->db->order_by("tacn.indate","ASC");	
			return $this->db->get();
		}
		else
		{
			return $this->datatables->generate();
		}
    }
   
    function credit_note_document_upload($fieldname)
	{
		$config['upload_path'] = $this->credit_note_path;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '10000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
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
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		
		$data = array();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();
			
			$this->db->select('name,stax ,educess,secondaryhighertax,agreementnodate,validity_from');
			$this->db->where('id', $data[0]->branch_id);
			$query_branch = $this->db->get("tbl_branch");
			
			
			
			$auctionEndDate = $data[0]->auction_end_date;		
			
			$this->db->where('auctionID', $auction_id);
			
            $endinvoiceDate = $this->db->get('tbl_event_invoice')->result();
            
              if(isset($endinvoiceDate[0]))
              {
				$endinvoiceDate_main =  $endinvoiceDate[0]->invoiceDate;  
			  }else{
				  //$endinvoiceDate_main =  '0000-00-00 00:00:00';  
				  $endinvoiceDate_main =  date("Y-m-d H:i:s");  
			  }
				
			//echo $endinvoiceDate_main;die;
			
			$this->db->select('stax,educess,secondaryhighertax,swacchbharat_tax,krishi_kalyan');
			$this->db->where("start_date <= '".$endinvoiceDate_main."' and end_date >= '".$endinvoiceDate_main."'");
			$this->db->where('status', 1);
			$this->db->order_by('id DESC');
			$this->db->limit('1');
			$query_tax = $this->db->get("tbl_taxmaster");
			$data_tax=$query_tax->result();
			$data_branch=$query_branch->result();
			$data[0]->stax=$data_tax[0]->stax;
			$data[0]->educess=$data_tax[0]->educess;
            $data[0]->swacchbharat_tax=$data_tax[0]->swacchbharat_tax;
            $data[0]->krishi_kalyan=$data_tax[0]->krishi_kalyan;
			$data[0]->secondaryhighertax=$data_tax[0]->secondaryhighertax;
			$data[0]->agreementnodate=$data_branch[0]->agreementnodate;  //Comment By Saurabh to change to validity_from from tbl_branch
			
			
			//$data[0]->agreementnodate= date('Y-m-d',strtotime($data_branch[0]->validity_from));
			$data[0]->branch=$data_branch[0]->name;
			
			
			$this->db->where('auctionID', $auction_id);
			$query_credit_note = $this->db->get("tbl_auction_credit_note");
			$query_credit_note=$query_credit_note->result();			
			$data[0]->credit_note=$query_credit_note;
			$data[0]->invoice=$endinvoiceDate;
			//echo '<pre>';
			//print_r($data[0]->invoice[0]->invoiceNo);die;
		}
		//echo '<pre>';
		//print_r($data);die;
		return $data;
		
     }
	function generateInvoice($auction_id)
	{ 		
		$this->db->where('auctionID', $auction_id);
		$this->db->where('status', '1');
		$query = $this->db->get("tbl_event_invoice");
		if ($query->num_rows() > 0) {		
			return $query->result();
		}
		else
		{
			
			//Get Auction Record
			$this->db->select('bank_id,branch_id,invoice_mail_to,status');
			$this->db->where('id', $auction_id);
			$query = $this->db->get("tbl_auction");
			$auction_data=$query->result();
			//echo $this->db->last_query();die;
			//$branch_id =$auction_data[0]->branch_id;			
			$branch_id = GetTitleByField('tbl_user', "id='".$auction_data[0]->invoice_mail_to."'", 'user_type_id');
			$bank_id =$auction_data[0]->bank_id;
			if($bank_id){
			$bank_name= GetTitleByField('tbl_bank',"id=$bank_id",'name');
			}
			
			//Get Auction successful/unsuccessful
			$this->db->select('count(id) as total ',false);
			$this->db->where('auctionID', $auction_id);
			$this->db->where('final_submit', 1);
			$query = $this->db->get("tbl_auction_participate");
			$no_of_participate=$query->result();
		
			if($bank_id)
			{
			   //condition if auction is stay/cancel
				if($auction_data[0]->status == 4)
				{
				   $amount= GetTitleByField('tbl_branch',"id=$branch_id",'cancel_amount');   
				} 
				else if($auction_data[0]->status == 3)
				{
					$amount= GetTitleByField('tbl_branch',"id=$branch_id",'stay_amount');     
				} 
				else if($no_of_participate[0]->total)
				{
					$amount= GetTitleByField('tbl_branch',"id=$branch_id",'revenueamount');
				}
				else
				{
					$amount= GetTitleByField('tbl_branch',"id=$branch_id",'unsuc_revenueamount');
				}
		   }
		   
		   
			$date=date('Y-m-d H:i:s');
			//$date = date('2016-12-29 H:i:s'); //dheeraj
			
			
			$user_id=$this->session->userdata('id');
			
			$this->db->where("start_date <= '".$date."' AND end_date >= '".$date."' ");
			$this->db->where("status","1");
			$this->db->order_by("id","DESC");
			$query = $this->db->get("tbl_taxmaster");
			$taxmaster = $query->result();
			
			if(isset($taxmaster[0]))
			{
				$service_tax_amount = round($amount * $taxmaster[0]->stax / 100);
				$swacchbharat_tax_amount = round($amount * $taxmaster[0]->swacchbharat_tax / 100);
				$krishi_kalyan_amount = round($amount * $taxmaster[0]->krishi_kalyan / 100);
			}
			
			$data=array(
			  'auctionID'=>$auction_id,
			  'indate' =>date('Y-m-d H:i:s'), //dheeraj
			  'amount' =>$amount,
			  'service_tax_amount' =>$service_tax_amount,
			  'swacchbharat_tax_amount' =>$swacchbharat_tax_amount,
			  'krishi_kalyan_amount' =>$krishi_kalyan_amount,
			  'grandTotal' =>$amount + $service_tax_amount + $swacchbharat_tax_amount + $krishi_kalyan_amount,
			  'balance_outstanding_amount' => $amount + $service_tax_amount + $swacchbharat_tax_amount + $krishi_kalyan_amount,
			  'invoiceDate'=>$date,
			  'created_by' =>$user_id,
			  'status' =>'0'
			  );
			  
				$this->db->where('auctionID', $auction_id);				
				$query = $this->db->get("tbl_event_invoice");
				if ($query->num_rows() > 0) {		
					$restul = $query->result();
					$this->db->where('auctionID', $auction_id);
					$this->db->update('tbl_event_invoice',$data);
					$id = $restul[0]->id;
				}
				else
				{
					$this->db->insert('tbl_event_invoice',$data);
					$id=$this->db->insert_id();
				}
			  
			
			

			$financialyeardate = (date('m')<'04') ? date('y-04-01',strtotime('-1 year')) : date('y-04-01'); 
			list($startfinyear, $month, $day)  = explode("-", $financialyeardate);
			$fy = $startfinyear + 1;

			$startfinancialyear = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
			$this->db->where('user.user_type_id =', $branch_id);
			$this->db->where('i.invoiceNo !=','');
			$this->db->where('i.status','1');
			$this->db->where("i.invoiceDate >= '".$startfinancialyear."' and i.invoiceDate <= '".date("Y-03-31 23:59:59",strtotime('+1 year',strtotime($startfinancialyear)))."'");
			$this->db->join('tbl_auction as ta','ta.ID = i.auctionID','left');
			$this->db->join('tbl_user as user','user.id = ta.invoice_mail_to','left');
			$this->db->order_by("i.indate", "desc");
			$this->db->limit(1);
			$query = $this->db->get("tbl_event_invoice as i");
			//echo $this->db->last_query();die;
			 if ($query->num_rows() > 0) {
				$data = $query->result();
 				$invoice = $data[0]->invoiceNo;
				$invoiceArr = explode('\\',$invoice);
				$invoiceArr = array_reverse($invoiceArr);
				//print_r($invoiceArr);
				$invoiceArr[0] = (int)$invoiceArr[0] + 1;
				if($invoiceArr[0] < 10)
				{
					$invoice_no_new = "00000".$invoiceArr[0];
				}
				else if($invoiceArr[0] < 100)
				{
					$invoice_no_new = "0000".$invoiceArr[0];
				}
				else if($invoiceArr[0] < 1000)
				{
					$invoice_no_new = "000".$invoiceArr[0];
				}
				else if($invoiceArr[0] < 10000)
				{
					$invoice_no_new = "00".$invoiceArr[0];
				}
				else if($invoiceArr[0] < 10000)
				{
					$invoice_no_new = "0".$invoiceArr[0];
				}
				else 
				{
					$invoice_no_new = $invoiceArr[0];
				}
			 }
			 else
			 {
				$invoice_no_new = "000001";
			 }
			 
			 //echo $invoice_no_new;die;


			//$this->db->where("invoiceNo IS NULL || invoiceNo = ''");				
			$this->db->where("status !=",'1');	
			$this->db->where('auctionID', $auction_id);			
			$query = $this->db->get("tbl_event_invoice");
			if ($query->num_rows() > 0)	
			{
				$invoiceNo = 'DELHI\\E-AUCTION\\' .$startfinyear.'-'.$fy.'\\'. $bank_name.'\\'.$branch_id.'\\'.$invoice_no_new;
				$this->db->where('auctionID', $auction_id);
				$this->db->update('tbl_event_invoice', array('invoiceNo'=>"$invoiceNo"));
			}
			
			/*$this->db->where('id', $auction_id);
			$this->db->update('tbl_auction', array('is_invoice_generated'=>1)); */
			
			$this->db->where('auctionID', $auction_id);
			$query = $this->db->get("tbl_event_invoice");
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}
    }
    function fetchopener($id){ 
       
        $this->db->select("first_name,last_name,email_id,mobile_no,user_id",false);
                   $this->db->from('tbl_user');
                   $this->db->where('id',$id);
                  $query = $this->db->get();
                 
		if ($query->num_rows() > 0) {
                    return $query->result();
    }
    }
    function fetchbidder($id){
       
               $this->db->select("ta.first_name,ta.last_name,ta.email_id,ta.mobile_no,ta.register_as,ta.organisation_name",false);
               $this->db->from('tbl_auction_participate tb');
               $this->db->join('tbl_user_registration as ta','ta.id=tb.bidderID','left');
               $this->db->join('tbl_auction as au','au.id=tb.auctionID','left');
               $this->db->where('tb.auctionID',$id);
                $this->db->where('tb.final_submit',1);
               $this->db->where("(((au.second_opener IS NOT NULL || au.second_opener = 0)  and tb.operner2_accepted = 1) || ((au.second_opener IS NULL || au.second_opener = 0) and tb.operner1_accepted = 1))");
               $query = $this->db->get();
              if ($query->num_rows() > 0)
              {
              return $query->result();
              }
    }
    function fetchbidder_helpdesk($id){
       
               $this->db->select("ta.first_name,ta.last_name,ta.email_id,ta.mobile_no,ta.register_as,ta.organisation_name",false);
               $this->db->from('tbl_auction_participate tb');
               $this->db->join('tbl_user_registration as ta','ta.id=tb.bidderID','left');
               $this->db->join('tbl_auction as au','au.id=tb.auctionID','left');
               $this->db->where('tb.auctionID',$id);
               $this->db->where('tb.final_submit',1);
              //$this->db->where("(((au.second_opener IS NOT NULL || au.second_opener = 0)  and tb.operner2_accepted = 1) || ((au.second_opener IS NULL || au.second_opener = 0) and tb.operner1_accepted = 1))");
               $query = $this->db->get();
               if($id == 25197)
                {
               //echo $this->db->last_query();
				}
              if ($query->num_rows() > 0)
                {
				  if($id == 25197)
                  {
					//echo '<pre>';
					//print_r($query->result());die;
				  }
				  return $query->result();
              }
              if($id == 25197)
                {
					//echo 'et';die;
				}
    }
	function completeMISReportData()
    {	      
		
        $start_date =$this->input->post('start_date');
		$end_date   =$this->input->post('end_date');
                 $this->db->select(" ta.id,ta.reference_no,ta.event_title,ta.event_title,ta.press_release_date,ta.inspection_date_from,ta.inspection_date_to,ta.bid_opening_date,ta.bid_last_date,ta.dsc_enabled,ta.auction_end_date,ta.auction_start_date,ta.reference_no,UCASE(ta.event_type) as type,ta.bid_inc,ta.price_bid,ta.auto_extension_time,ta.no_of_auto_extn,  ta.status
		  status,ta.first_opener,ta.second_opener,ta.bank_id ,tb.name as bank_name,ta.branch_id, tbr.name as branch_name, tu.address1, tu.address2, tu.user_id, tu.first_name, tu.last_name, tu.email_id, tu.mobile_no, tu.designation, tei.invoiceNo, tei.invoiceDate, tei.amount, tei.realizationDate,  tei.amount_recived as realizationAmount, ta.created_by, tp.state, tp.city , ta.indate, (select count(bidderID) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id and tbl_auction_participate.final_submit=1) as total_bidder, ta.borrower_name,ta.other_city as property_cityname_other,
                    (SELECT u.first_name from tbl_user u   WHERE u.id=ta.second_opener ) as 'second_fname' ,
                    (SELECT u.last_name from tbl_user u   WHERE u.id=ta.second_opener ) as 'second_lname' ,
                    (SELECT u.user_id from tbl_user u   WHERE u.id=ta.second_opener ) as 'second_user_id' ,
                    (SELECT u.email_id from tbl_user u   WHERE u.id=ta.second_opener ) as 'second_email_id',
                    (SELECT u.mobile_no from tbl_user u   WHERE u.id=ta.second_opener ) as 'second_mobile'",false)
                    ->from('tbl_auction as ta')
                    ->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
                    ->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
                   // ->join('tbl_event_log_sales as lss','lss.id=ta.eventID','left ')
                    ->join('tbl_event_invoice as tei','tei.auctionID=ta.id and tei.status = 1','left ')
                    ->join('tbl_user as tu','tu.id=ta.first_opener','left ')
                    ->join('tbl_product as tp','ta.id=tp.auctionID','left ');
                   $this->db->where_in('ta.status',array(1,3,4,6,7));                   
                 if($start_date!='' && $end_date!=''){
					  $this->db->where('ta.indate  BETWEEN "'. date('Y-m-d H:i:s', strtotime($start_date)). '" and "'. date('Y-m-d H:i:s', strtotime($end_date)).'"');
				 }
                $this->db->group_by('ta.id');
				$query = $this->db->get();
              //echo $this->db->last_query();die;
              
                if ($query->num_rows() > 0) {    
           foreach ($query->result() as $row) {
           if($row->total_bidder>0){
            $total_bidder1=$this->fetchbidder_helpdesk($row->id);
           
           foreach($total_bidder1 as  $bidder){
                if($bidder->register_as=='builder'){
                $row->bidder_name.=$bidder->organisation_name.',';    
                }else{
                $row->bidder_name.=$bidder->first_name.' '.$bidder->last_name.',';      
                }
                $row->bidder_email.=$bidder->email_id.',';
                $row->bidder_mobile.=$bidder->mobile_no.',';
             }
            }else{
            $row->bidder_name='';
            $row->bidder_email='';
            $row->bidder_mobile='';  
            }
                                
                $data[] = $row;
            }
           // echo '<pre>';
            //print_r($data);die;
          /*if ($query->num_rows() > 0) {
                    $usertype=$this->session->userdata('user_type');
                    if($usertype=='helpdesk_ex'){
                     $action_type="he_mis_report";
                     $message='Help desk Executive  has successfully downloaded report';
                      }else{
                     $action_type="complete_MIS_report";  
                     $message='Account User has successfully downloaded report';
                    }
                  //Track Bidder View Report start
                        $trackreportdata=array(
                            'event_id'=>'',
                            'auction_id'=>'',
                            'bidder_id'=>$this->session->userdata('id'),
                            'bank_id'=>'',
                            'user_type'=>$usertype,
                            'action_type'=>$action_type,
                            'action_type_event'=>"download",
                            'ip'=>$_SERVER['REMOTE_ADDR'],
                            'status'=>'1',
                            'message'=>$message,
                             'indate'=>date('Y-m-d H:i:s'),
                        );
                    $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 * */
     
                //Track Bidder View Report End  
                    
                    
                    
                    
                    
           //foreach ($query->result() as $row) {
           //     $data[] = $row;
           // }
            return $data;
        }
        return false;
		
    }
    
    
    function completeMISReportData_backup()
    {	        $data=array(); 
                $start_date =$this->input->post('start_date');
				$end_date   =$this->input->post('end_date');  
				/*
					$this->db->where('ta.indate BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
	                $this->db->from('tbl_auction ta');
		            $query = $this->db->get();
				*/
                 $query=$this->db->query('SELECT ta.id,ta.reference_no,ta.event_title,ta.event_title,ta.press_release_date,ta.inspection_date_from,ta.inspection_date_to,ta.bid_opening_date,ta.bid_last_date,ta.dsc_enabled,ta.auction_end_date,ta.indate,ta.auction_start_date,ta.reference_no,UCASE(ta.event_type) as type,ta.bid_inc,ta.price_bid,ta.auto_extension_time,ta.no_of_auto_extn,  ta.status
		  status,ta.first_opener,ta.second_opener,ta.bank_id  FROM tbl_auction as ta where ta.indate BETWEEN "'.$start_date.'" AND "'.$end_date.'" LIMIT 100');
		  //$query = $this->db->get();
                /*->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->join('tbl_event_invoice as tei','tei.auctionID=ta.id','left ')
		 ->join('tbl_user as tu','tu.id=ta.first_opener','left ')
                 ->join('tbl_product as tp','ta.id=tp.auctionID','left ');*/
                /* if($start_date!='' && $end_date!=''){
		  $this->db->where("ta.indate BETWEEN date('$start_date') AND date('$end_date')");
		}
                $this->db->group_by('ta.id');
		$this->db->where('ta.indate  BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$query = $this->db->get();*/
              //echo $this->db->last_query();die;
            //  echo $query->num_rows();
                if ($query->num_rows() > 0) { 
                       foreach ($query->result() as $row) {
                          $first=$this->fetchopener($row->first_opener);
                        //  print_r($first);
                          $second=$this->fetchopener($row->second_opener);
                         // print_r($second);
                          $row->last_name=$first[0]->last_name;
                          $row->email_id=$first[0]->email_id;
                          $row->mobile_no=$first[0]->mobile_no;
                          $row->user_id=$first[0]->user_id;
                          $row->second_fname=$second[0]->first_name;
                          $row->second_lname=$second[0]->last_name;
                          $row->second_email=$second[0]->email_id;
                          $row->second_mobile=$second[0]->mobile_no;
                          $row->second_user_id=$second[0]->user_id;
                          if($row->total_bidder>0){
                          $total_bidder1=$this->fetchbidder($row->id);
                            foreach($total_bidder1 as  $bidder){
                                if($bidder->register_as=='builder'){
                                $row->bidder_name.=$bidder->organisation_name.',';    
                                }else{
                                $row->bidder_name.=$bidder->first_name.' '.$bidder->last_name.',';      
                                }
                                $row->bidder_email.=$bidder->email_id.',';
                                $row->bidder_mobile.=$bidder->mobile_no.',';
                             }
                            }else{
                            $row->bidder_name='';
                            $row->bidder_email='';
                            $row->bidder_mobile='';  
                            }
                          $data[]=$row;
                           
                }
           // print_r($data);
          //  die;
          /*if ($query->num_rows() > 0) {
                    $usertype=$this->session->userdata('user_type');
                    if($usertype=='helpdesk_ex'){
                     $action_type="he_mis_report";
                     $message='Help desk Executive  has successfully downloaded report';
                      }else{
                     $action_type="complete_MIS_report";  
                     $message='Account User has successfully downloaded report';
                    }
                  //Track Bidder View Report start
                        $trackreportdata=array(
                            'event_id'=>'',
                            'auction_id'=>'',
                            'bidder_id'=>$this->session->userdata('id'),
                            'bank_id'=>'',
                            'user_type'=>$usertype,
                            'action_type'=>$action_type,
                            'action_type_event'=>"download",
                            'ip'=>$_SERVER['REMOTE_ADDR'],
                            'status'=>'1',
                            'message'=>$message,
                             'indate'=>date('Y-m-d H:i:s'),
                        );
                    $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 * */
     
                //Track Bidder View Report End  
                    
                    
                    
                    
                    
           //foreach ($query->result() as $row) {
           //     $data[] = $row;
           // }
            return $data;
            
        }
        return false;
		
    }
	function dashboardData($type='',$start_date='',$end_date='')
	{
		$searchDate = false;
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
				$start_date = date("Y-m-01 00:00:00");
				$end_date = date("Y-m-t 23:59:59");
		}
		else if($type=='tillDate')
		{
				$start_date = date("2001-01-01 00:00:00");
				$end_date = date("Y-m-t 23:59:59",strtotime("+1 year"));
		}
		else
		{
				$searchDate = true;
				$start_date = date("Y-m-d 00:00:00",strtotime($start_date));
				$end_date = date("Y-m-d 23:59:59",strtotime($end_date));	
		}
		
		$this->db->select('count(id) as total ',false);
		$this->db->where_in('status', array(1,3,4,6,7));
		//$this->db->where('status !=', 2);
		/*if($type=='today')$this->db->where('date(updated_date) = date(NOW())');
		if($type=='week')$this->db->where('date(updated_date) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		if($type=='month')$this->db->where('date(updated_date) BETWEEN date(NOW())  - INTERVAL 30 DAY AND date(NOW())');
		if($type=='select')$this->db->where("date(updated_date) BETWEEN '$start_date' AND '$end_date'");*/
		$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("tbl_auction");		
		$publishedData=$query->result();


		$this->db->select('count(id) as total ',false);
		$this->db->where_in('status ', array(6,7));
		if($searchDate)
		{
			$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		}
		else
		{
			$this->db->where("auction_end_date BETWEEN '$start_date' AND '$end_date'");
		}		
		$query = $this->db->get("tbl_auction");
		$concludedData=$query->result();
		if($type=='today')
		{
			//echo $this->db->last_query();die;
		}
		
		
			$this->db->select('count(distinct (a.id)) as total ',false);
		//$this->db->where_in('a.status ', array(6));
		/*if($type=='today')$this->db->where('date(updated_date) = date(NOW())');
		if($type=='week')$this->db->where('date(updated_date) BETWEEN date(NOW()) - INTERVAL 8 DAY AND date(NOW()) ');
		if($type=='month')$this->db->where('date(updated_date) BETWEEN date(NOW())  - INTERVAL 30 DAY AND date(NOW())');
		if($type=='select')$this->db->where("date(updated_date) BETWEEN '$start_date' AND '$end_date'");*/
		$this->db->where("a.indate BETWEEN '$start_date' AND '$end_date'");
		$this->db->join('tbl_auction_participate p','a.id=p.auctionID');
		$this->db->where('p.final_submit', '1');
		//$this->db->group_by('p.auctionID');
		$query = $this->db->get("tbl_auction as a");
		$successData = $query->result();
		if($type=='tillDate')
		{
			//echo $this->db->last_query();die;
		}
		
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('status ', 1);
		
		if($searchDate)
		{
			$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		}
		else
		{
			$this->db->where("auction_end_date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get("tbl_auction");
		$inProgressData = $query->result();
		
		$this->db->select('count(id) as total ',false);
		$this->db->where('(status=3 OR status=4)');
	
		if($searchDate)
		{
			$this->db->where("indate BETWEEN '$start_date' AND '$end_date'");
		}
		else
		{
			$this->db->where("auction_start_date BETWEEN '$start_date' AND '".date("Y-m-d H:i:s")."'");
		}	
		$query = $this->db->get("tbl_auction");
		$cancelStatData=$query->result();
		
		$this->db->select('count(ev.id) as total,sum(ev.grandTotal) as invoice_amount',false);
		$this->db->where("ev.status","1");
		if($searchDate)
		{
			$this->db->join('tbl_auction as a','a.id=ev.auctionID');
			$this->db->where("a.indate BETWEEN '$start_date' AND '$end_date'");
		}
		else
		{
			$this->db->where("ev.invoiceDate BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get("tbl_event_invoice AS ev");		
		$invoicedData=$query->result();
		if($type=='today')
		{
			//echo $this->db->last_query();die;
		}
		
		$this->db->select('count(i.id) as total,sum(i.amount_recived) as total_amount',false);				
		$this->db->where('i.amount_recived > 0');
		
		if($searchDate)
		{
			$this->db->join('tbl_auction as a','a.id=i.auctionID');
			$this->db->where("a.indate BETWEEN '$start_date' AND '$end_date'");
		}
		else
		{
			$this->db->where("i.realizationDate BETWEEN '".$start_date."' AND '".$end_date."'");
		}
		
		$query = $this->db->get("tbl_event_invoice as i");
		$collectionData=$query->result();
		
		//if($type == 'select')
		{
			//echo $this->db->last_query();die;
		}
		
		$this->db->select('count(i.id) as total,sum(i.amount_recived) as total_amount',false);				
		$this->db->where('i.amount_recived > 0');
		
		if($searchDate)
		{
			$this->db->join('tbl_auction as a','a.id=i.auctionID');
			$this->db->where("a.indate BETWEEN '$start_date' AND '$end_date'");
		}
		else
		{
			$this->db->where("i.realizationDate BETWEEN '".$start_date."' AND '".$end_date."'");
		}
		
		$query = $this->db->get("tbl_event_invoice as i");
		$collectionData=$query->result();
		
		//if($type == 'select')
		{
			//echo $this->db->last_query();die;
		}
                
	    $data['allPublished']=$publishedData[0]->total;
	    $data['allSuccess']=$successData[0]->total;
		$data['allConcluded']=$concludedData[0]->total;
		$data['allInProgress']=$inProgressData[0]->total;
		$data['allCancelStay']=$cancelStatData[0]->total;
		$data['allInvoiced']=$invoicedData[0]->total;
		$data['allCollection']=$collectionData[0]->total;
		//$tax = $this->db->get("tbl_taxmaster")->row_object();
		//$amount=$invoicedData[0]->total_amount;
		//$amount=$amount+(($amount*$tax->stax)/100)+(($amount*$tax->educess)/100);
		$data['allInvoicedamt']=$invoicedData[0]->invoice_amount;
		$data['allCollectionamt']=$collectionData[0]->total_amount;
		return $data;
	
	}
	
	
	function allSalesOrAccountsUser(){
		$userArr=array("account","sales");
		$this->db->where_in('user_type',$userArr);
		$this->db->where('status',1);
		$query = $this->db->get("tbl_user_registration");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	
	public function getCityName($id){
		$this->db->where('id',$id);
		$query = $this->db->get("tbl_city");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row->city_name;
            }
            return $data;
        }
        return false;
	}
	
	public function getStateName($id){
		$this->db->where('id',$id);
		$query = $this->db->get("tbl_state");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row->state_name;
            }
            return $data;
        }
        return false;
	}
	
	public function getCountryName($id){
		$this->db->where('id',$id);
		$query = $this->db->get("tbl_country");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row->country_name;
            }
            return $data;
        }
        return false;
	}
	
	
	function countTotalbidder($aid){
		$this->db->where('auctionID',$aid);
		$query = $this->db->get("tbl_auction_participate");
		$total=$query->num_rows();
		return $total;
        
	}
	
	public function updatecreditnote($id){
		$this->db->where('auctionID', $id);
		$data = array('verified'=>1,'status'=>1);
		$this->db->update('tbl_auction_credit_note',$data);
		return true;
	}
	
	function getInvoiceReportData(){
		 $this->db->where('status',1);		 
		 $taxRow = $this->db->get("tbl_taxmaster")->row_object();
		 $stax		=	$taxRow->stax;
		 $educess	=	$taxRow->swacchbharat_tax;
		  //(i.amount+i.amount*@stax/100 +  i.amount*@educess/100) as amount
		  
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		
		if($this->input->get('start_date') != "")
		{
			$start_date=$this->input->get('start_date');
		}
		
		if($this->input->get('end_date') != "")
		{
			$end_date=$this->input->get('end_date');
		}
		
		/* create log data */
		$user_type=$this->session->userdata('user_type');
		$actiontype='account_full_invoice_report';
		$trackreportdata=array('event_id'=>0,
							   'auction_id'=>0,
							   'bidder_id'=>$this->session->userdata('id'),
							   'bank_id'=>0,
							   'user_type'=>$user_type,
							   'action_type'=>$actiontype,
							   'action_type_event'=>"download",
							   'ip'=>$_SERVER['REMOTE_ADDR'],
							   'status'=>'1',
							   'message'=>ucfirst($user_type).' has successfully Downloaded Invoice Report',
							   'indate'=>date('Y-m-d H:i:s'),
							  );
		$query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
         /* end log data */      
		
		$this->db->select("i.*,a.id, a.reference_no, a.bank_id,a.bank_id, b.name as bank_name, a.branch_id, br.name as branch_name,a.auction_end_date,i.invoiceNo, i.amount as invoiceamount,i.invoiceDate,c.credit_noteID,DATE_FORMAT(c.indate,'%d/%b/%Y %h:%i %p') as indate,c.verified,a.bank_branch_id,a.event_type,c.grandTotal as cgrandTotal,i.invoiceDate",false);
		$this->db->from('tbl_event_invoice as i');
		$this->db->join('tbl_auction as a','a.id=i.auctionID');
		$this->db->join('tbl_auction_credit_note as c','a.id=c.auctionID and c.verified = 1','left');
		$this->db->join('tbl_bank as b','b.id=a.bank_id','left');
		$this->db->join('tbl_branch as br','br.id=a.branch_id','left');		
		$this->db->join('tbl_taxmaster as tm','tm.start_date <= i.invoiceDate and tm.end_date >= i.invoiceDate','right');
		$this->db->where("(a.status= '6' OR a.status= '7' OR a.status= '3' OR a.status= '4')");
		  if($start_date!='' && $end_date!=''){
				$this->db->where("date(invoiceDate) BETWEEN date('$start_date') AND date('$end_date')");
		  }
	    $this->db->where("is_invoice_generated","1");
	    $this->db->order_by("i.id","DESC");    
		$query = $this->db->get();
		//echo $this->db->last_query();die;
	      if ($query->num_rows() > 0) {
               foreach ($query->result() as $row) {
                $total_bidder=$this->countTotalbidder($row->id);
                $row->total_bidder=$total_bidder;
                $data[] = $row;
              }              
            return $data;
              }else{
		return $data=0;	
	      }
	}
	
	function getcompleteMISReportData(){
		
		
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		
		if($start_date == "" && $end_date == "")
		{
			$start_date=$this->input->get('start_date');
			$end_date=$this->input->get('end_date');
		}
		
		
		//$this->db->select('CONCAT(rs.first_name," ",rs.last_name)as SalesExecutive ,MONTHNAME(e.indate) as month, IF(e.event_type=1,"DRT","SARFAESI") as event_type, ci.city_name , st.state_name , i.invoiceDate, i.amount as payment, a.id as auctionid,  e.id as eventid,  a.reference_no, a.bank_id,a.bank_id, CONCAT(bu.first_name," ",bu.last_name)as ContectPerson, bu.designation, bu.mobile_no, bu.email_id,  b.name as bank_name,DATE_FORMAT(e.publish_date,"%b %d %Y %h:%i %p") as log_publishdate, e.created_by as SalesLoginNo ,e.indate, a.branch_id, br.name as branch_name,br.address1,br.address2, br.city as location, DATE_FORMAT(a.auction_start_date,"%b %d %Y") as auction_start_date, DATE_FORMAT(a.auction_start_date,"%h:%i %p") as auction_start_time, DATE_FORMAT(a.auction_end_date,"%b %d %Y %h:%i %p") as auction_end_date, DATE_FORMAT(a.bid_last_date,"%b %d %Y %h:%i %p") as bid_last_date, DATE_FORMAT("a.press_release_date","%b %d %Y %h:%i %p")as press_release_date, a.status',false);
		$this->db->select('a.id,
							cid.city_name as property_cityname,
							cid_other.city_name as property_cityname_other,
							st_pro.state_name as property_statename,
							CONCAT(rs.first_name," ",rs.last_name)as SalesExecutive ,
							MONTHNAME(e.indate) as month, 
							UCASE(a.event_type) as event_type, 
							ci.city_name , 
							st.state_name , 
							i.invoiceDate, 
							i.amount as payment,
							i.amount_recived as amount_recived_main, 
							a.id as auctionid,  
							e.id as eventid,  
							a.reference_no, 
							a.bank_id,
							a.bank_id, 
							CONCAT(bu.first_name," ",bu.last_name)as ContectPerson, 
							bu.designation, 
							bu.mobile_no, 
							bu.email_id,  
							b.name as bank_name,
							DATE_FORMAT(e.publish_date,"%b %d %Y %h:%i %p") as log_publishdate, 
							e.created_by as SalesLoginNo ,
							e.indate,
							a.branch_id, 
							br.name as branch_name,
							br.address1,
							br.address2, 
							ci.city_name as location, 
							a.auction_end_date as auction_end_date2, 
							DATE_FORMAT(a.auction_end_date,"%b %d %Y") as auction_end_date, 
							DATE_FORMAT(a.auction_end_date,"%h:%i %p") as auction_end_time, 
							DATE_FORMAT(a.auction_end_date,"%b %d %Y %h:%i %p") as auction_end_date1, 
							DATE_FORMAT(a.bid_last_date,"%b %d %Y %h:%i %p") as bid_last_date, 
							DATE_FORMAT(a.press_release_date,"%b %d %Y %h:%i %p") as press_release_date, 
							a.status,
							a.indate as publish_indate,
							i.invoiceNo as invoiceNo,
							(select b.id from tbl_user as u,tbl_branch as b where b.id = u.user_type_id and u.id = a.invoice_mail_to) as invoice_branch_id,
							(select b.name from tbl_user as u,tbl_branch as b where b.id = u.user_type_id and u.id = a.invoice_mail_to) as invoice_branch_name,
							i.realizationDate as realizationDate,
							a.borrower_name as borrower_name,
							(select count(id) from tbl_auction_participate where auctionID = a.id and final_submit = 1) as bidder_count,
							i.grandTotal as invoice_amount,
							(
								i.grandTotal -
								case  
									when i.amount_recived = 0 OR i.amount_recived IS NULL then 0
									else i.amount_recived
								end  
								 -
								case  
									when tacn.grandTotal = 0 OR tacn.grandTotal IS NULL then 0
									else tacn.grandTotal
								end  
								- 
								case  
									when i.tds_deduction_amount = 0 OR i.tds_deduction_amount IS NULL then 0
									else i.tds_deduction_amount
								end  
								- 
								case  
									when i.other_deduction_amount = 0 OR i.other_deduction_amount IS NULL then 0
									else i.other_deduction_amount
								end  								
							) as outstanding_amount
							',false);
		
                //$this->db->from('tbl_event_log_sales as e');
		//$this->db->join('tbl_auction as a','e.id=a.eventID');
		
		
		$this->db->from('tbl_auction as a');
		$this->db->join('tbl_event_log_sales as e','e.id=a.eventID','left');
		
		
		$this->db->join('tbl_event_invoice as i','a.id=i.auctionID and i.status = 1' ,'left');
		$this->db->join('tbl_bank as b','b.id=a.bank_id','left');
		$this->db->join('tbl_branch as br','br.id=a.branch_id','left');
		$this->db->join('tbl_city as ci','ci.id=br.city','left');
		$this->db->join('tbl_state as st','st.id=br.state','left');
		$this->db->join('tbl_state as st_pro','st_pro.id=a.state','left');
		$this->db->join('tbl_city as cid','cid.id=a.city','left');
		$this->db->join('tbl_city as cid_other','cid_other.id=a.other_city','left');
		$this->db->join('tbl_user_registration as rs','rs.id=e.sales_executive_id','left');
		$this->db->join('tbl_user as bu','bu.id=a.first_opener','left');
		$this->db->join('tbl_auction_credit_note as tacn','tacn.auctionID = a.id','left');
		$this->db->where_in('a.status', array(1,3,4,6,7));
		if($start_date!='' && $end_date!=''){
			$this->db->where("( a.indate BETWEEN '".$start_date."' AND '".$end_date."' )");
		}				
		$query = $this->db->get();
		//echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$total_bidder=$this->countTotalbidder($row->auctionid);
				$row->total_bidder=$total_bidder;
                $data[] = $row;
            }
            return $data;
        }else{
			return $data=0;	
		}
	}	
	
	////insert pdf entry to db when generate pdf first time///
	function saveInvoicePdfEntry($data) {
		$this->db->insert("tbl_invoice_entry", $data);
	}
	
	//get invoice entry by invoice id////
	function getInvoicePdfEntry($id=null) { 
		if(!empty($id)) {
			$this->db->where("invoice_id", $id);
			$data = $this->db->get("tbl_invoice_entry")->row_array();
			if(!empty($data)) {
				return true;
			} else {
				return false;
			}
		}
	}
	function checkInvoicePdfEntry($id=null) { 
		if(!empty($id)) {
					$this->db->where("id", $id);
					$this->db->where("is_invoice_generated", 1);
					$data = $this->db->get("tbl_auction")->row_array();
					if(!empty($data)) {
							return true;
					} else {
							return false;
					}
		 }
	}
	
	function completedAuctionScript() { 
		$this->load->library('Elasticsearch');		
		$elasticSearch = new Elasticsearch();
		$elasticSearch->index = 'c1prop';
		$elasticSearch->type = 'propertydata';
		
		
		$sql="SELECT id,auction_end_date,status  FROM tbl_auction where (auction_end_date < NOW() OR status=7) AND status!=6";
		$query = $this->db->query($sql); 
		if ($query->num_rows() > 0) {			
               foreach ($query->result() as $row) {
                $id = $row->id;
                $updatesql="UPDATE tbl_auction set status='6', stageID='7' WHERE id='".$id."' AND status=1";
                $update = $this->db->query($updatesql);
                
                //delete expire auction from elastic search
                //echo $id;die;
                //$res = $elasticSearch->delete($id);
                //echo '<pre>';print_r($res);die;
               }                      
            }
	}
	
	/*Generete invoice Report*/
	function invoiceGenerateReport(){
	$submit = $this->input->post('submit');	
	if(isset($submit) and !empty($submit))
		{
			$invoideSearchData=$this->getInvoiceReportData();
			

				if($invoideSearchData!=0)
				{
					
					//echo '<pre>';
					//print_r($invoideSearchData);die;
					
					$this->load->library('excel');
						//activate worksheet number 1
						$this->excel->setActiveSheetIndex(0);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('Invoice Report worksheet');
						$miestilo= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'b88c00')
										)
										);
								
						$miestilo2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'ffd85d')
														)
										);
						$miestilo3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'fff3cd')
														)
										);

						$miestilo_tab= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '867e4c')
										)
										);
										
						$miestilo_tab2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'c5be97')
														)
										);
						$miestilo_tab3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'eeece1')
														)
										);	
							
						
					   $miestilo_SEC= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '0000cc')
										)
										);
										
						$miestilo_SEC2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '579bff')
														)
										);
						$miestilo_SEC3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'e0ebf8')
														)
										);
						$miestilo_AUC= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => 'ffffff')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => '7030a0')
										)
										);
										
						$miestilo_AUC2= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'c3b8d6')
														)
										);
						$miestilo_AUC3= array('font' => array(
											'bold' => false,
											'color' => array('rgb' => '000000')
										),'fill' => array(
											'type' => PHPExcel_Style_Fill::FILL_SOLID,
											'startcolor' => array('rgb' => 'efecf4')
														)
										);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getTop()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getBottom()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getLeft()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$this->excel->getDefaultStyle()
							->getBorders()
							->getRight()
								->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						
						$this->excel->getActiveSheet()->getStyle("A:S")->getFont()->setSize(9);
						$this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('B1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('C1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('D1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('E1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('F1')->applyFromArray($miestilo2);
						$this->excel->getActiveSheet()->getStyle('G1')->applyFromArray($miestilo2);
					
						$this->excel->getActiveSheet()->setCellValue('A1', 'Event ID'); 			
						$this->excel->getActiveSheet()->setCellValue('B1', 'NIT Ref No'); 				
						$this->excel->getActiveSheet()->setCellValue('C1', 'Bank ID');    		
						$this->excel->getActiveSheet()->setCellValue('D1', 'Organization Name');			
						$this->excel->getActiveSheet()->setCellValue('E1', 'Branch ID');			
						$this->excel->getActiveSheet()->setCellValue('F1', 'Branch Name');					
						$this->excel->getActiveSheet()->setCellValue('G1', 'Auction End Date');					
						
						/**************************************************************************/
						//$this->excel->getActiveSheet()->getStyle('H1')->applyFromArray($miestilo_tab);
						$this->excel->getActiveSheet()->getStyle('H1')->applyFromArray($miestilo_tab2);
						$this->excel->getActiveSheet()->getStyle('I1')->applyFromArray($miestilo_tab2);
						$this->excel->getActiveSheet()->getStyle('J1')->applyFromArray($miestilo_tab2);
						$this->excel->getActiveSheet()->getStyle('K1')->applyFromArray($miestilo_tab2);
						$this->excel->getActiveSheet()->getStyle('L1')->applyFromArray($miestilo_tab2);
						$this->excel->getActiveSheet()->getStyle('M1')->applyFromArray($miestilo_tab2);
						//$this->excel->getActiveSheet()->getStyle('N2')->applyFromArray($miestilo_tab2);
						
						$this->excel->getActiveSheet()->setCellValue('H1', 'Invoice No');
						$this->excel->getActiveSheet()->setCellValue('I1', 'Base Amount');			
						$this->excel->getActiveSheet()->setCellValue('J1', 'Service tax');				
						$this->excel->getActiveSheet()->setCellValue('K1', 'Swacch Bharat Cess%');			
						$this->excel->getActiveSheet()->setCellValue('L1', 'Krishi Kalyan Cess%');				
						$this->excel->getActiveSheet()->setCellValue('M1', 'Educess');				
						
						/**************************************************************************/
						//$this->excel->getActiveSheet()->getStyle('N1')->applyFromArray($miestilo_SEC);
						$this->excel->getActiveSheet()->getStyle('N1')->applyFromArray($miestilo_SEC2);
						$this->excel->getActiveSheet()->getStyle('O1')->applyFromArray($miestilo_SEC2);
						$this->excel->getActiveSheet()->getStyle('P1')->applyFromArray($miestilo_SEC2);
						$this->excel->getActiveSheet()->getStyle('Q1')->applyFromArray($miestilo_SEC2);
						$this->excel->getActiveSheet()->getStyle('R1')->applyFromArray($miestilo_SEC2);
						$this->excel->getActiveSheet()->getStyle('S1')->applyFromArray($miestilo_SEC2);
						
						$this->excel->getActiveSheet()->setCellValue('N1', 'Secondary Higher Tax');		
						$this->excel->getActiveSheet()->setCellValue('O1', 'Invoice Amount');				
						$this->excel->getActiveSheet()->setCellValue('P1', 'Credit Note ID');			
						$this->excel->getActiveSheet()->setCellValue('Q1', 'Credit Note Date');		
						$this->excel->getActiveSheet()->setCellValue('R1', 'Credit Note Amount');
						$this->excel->getActiveSheet()->setCellValue('S1', 'Invoice Date');	
						



							
						$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);	
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");		
						$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
						$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);	
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");		
						$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);			
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
						$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("25");
						$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);			
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("60");
						$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);			
						$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth("12");
						$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth("20");
						$this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth("12");
						$this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
						$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth("20");

					if($invoideSearchData!=0)
					{					
						$i=2;
						foreach($invoideSearchData as $row)
						{
							$dateFormate = 'MMM D, YYYY h:mm';
							$BaseAmount = $row->invoiceamount;
							
							if($row->verified==1)
							{
								$verified='Yes';
							}else if($row->verified==0){
								$verified='No';
							}
							$timeDiff = 19800;
							
							$this->excel->getActiveSheet()->getStyle("A:S")->getFont()->setSize(9);
							$this->excel->getActiveSheet()->getStyle('A'.$i.':S'.$i)->getAlignment()->setWrapText(true);
							
							/*$rowHeight =  $this->getHeight1($data);
							$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight($rowHeight);*/
							
							$this->excel->getActiveSheet()->getStyle('A'.$i.':S'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);			
							//$this->excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);						
							$this->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($miestilo3);
							$this->excel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($miestilo3);
						
							$this->excel->getActiveSheet()->setCellValue('A'.$i, $row->id);
							$this->excel->getActiveSheet()->setCellValue('B'.$i, $row->reference_no);
							$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->bank_id);
							$this->excel->getActiveSheet()->setCellValue('D'.$i, $this->replaceComma($row->bank_name));
							$this->excel->getActiveSheet()->setCellValue('E'.$i, $row->branch_id);
							$this->excel->getActiveSheet()->setCellValue('F'.$i, $this->replaceComma($row->branch_name));
							$this->excel->getActiveSheet()->setCellValue('G'.$i, $row->auction_end_date);
							
							/**************************************************************************/
							
							$this->excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($miestilo_tab3);
							$this->excel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($miestilo_tab3);
							$this->excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($miestilo_tab3);
							$this->excel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($miestilo_tab3);
							$this->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($miestilo_tab3);
							$this->excel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($miestilo_tab3);
							//$this->excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($miestilo_tab3);
							
							$this->excel->getActiveSheet()->setCellValue('H'.$i, $row->invoiceNo);
							$this->excel->getActiveSheet()->setCellValue('I'.$i, (int)$row->amount);
							$this->excel->getActiveSheet()->setCellValue('J'.$i, (int)$row->service_tax_amount); //auction 
							$this->excel->getActiveSheet()->setCellValue('K'.$i, (int)$row->swacchbharat_tax_amount);
							$this->excel->getActiveSheet()->setCellValue('L'.$i, (int)$row->krishi_kalyan_amount);
							$this->excel->getActiveSheet()->setCellValue('M'.$i, (int)($BaseAmount * $row->educess/100));
							//$this->excel->getActiveSheet()->setCellValue('N'.$i, $data->reference_no);
							
							/**************************************************************************/
							$this->excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($miestilo_SEC3);
							$this->excel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($miestilo_SEC3);
							$this->excel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($miestilo_SEC3);
							$this->excel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($miestilo_SEC3);
							$this->excel->getActiveSheet()->getStyle('R'.$i)->applyFromArray($miestilo_SEC3);
							$this->excel->getActiveSheet()->getStyle('S'.$i)->applyFromArray($miestilo_SEC3);

							
							$this->excel->getActiveSheet()->setCellValue('N'.$i, (int)($BaseAmount * $row->secondaryhighertax/100));
							$this->excel->getActiveSheet()->setCellValue('O'.$i, (int)$row->grandTotal);
							$this->excel->getActiveSheet()->setCellValue('P'.$i, $row->credit_noteID);
							$this->excel->getActiveSheet()->setCellValue('Q'.$i, $row->indate);
							$this->excel->getActiveSheet()->setCellValue('R'.$i, (int)$row->cgrandTotal);
							$this->excel->getActiveSheet()->setCellValue('S'.$i, $row->invoiceDate);		
							$i++;	
						}
	
					}
						
						$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(18);
						$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(18);
						
						
						$filename='Invoice_Report.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
									 
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');
										
				}					
		}	
		
	}
	
	function getcompleteMonthReportData(){
		
		
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		
		if($start_date == "" && $end_date == "")
		{
			$start_date=$this->input->get('start_date');
			$end_date=$this->input->get('end_date');
		}
		
		/*$this->db->select("e.id as EventID,reference_no as NITRefNo,borrower_name as BorrowerName ,
 (CASE WHEN event_type = 'sarfaesi' THEN 'SARFAESI' ELSE 'DRT' END) as EventType, br.Name as Bank_Name, b.name as Circle_Name, s.state_name as State_Name1, c.city_name, auction_end_date, (CASE WHEN price_bid_applicable = 'applicable' THEN 'Yes' ELSE 'No' END) as PriceBidApplicable, (CASE WHEN e.status = 0 THEN 'Saved' WHEN e.status = 1 THEN 'Published' WHEN e.status = 2 THEN 'Initialize' WHEN e.status = 3 THEN 'Stay' WHEN e.status = 4 THEN 'cancel' WHEN e.status = 5 THEN 'deleted' WHEN e.status = 6 THEN 'Published' ELSE 'Conclude' END) as Status, reserve_price, opening_price as Auction_OpeningPrice, (select COUNT(*) from tbl_auction_participate eb where eb.auctionID = e.id and eb.final_submit=1) as FRQ_no_of_bidder, (select MAX(frq.frq) from tbl_auction_participate_frq frq inner join tbl_auction_participate ebb on frq.auctionID = ebb.auctionID and frq.bidderID=ebb.bidderID where frq.auctionID = e.id and ebb.final_submit = 1) as Frq_Price, (select COUNT(distinct bidderID) from tbl_live_auction_bid eb where eb.auctionID = e.id ) as Auction_no_of_bidder, (select max(EP.bid_value) from tbl_live_auction_bid EP where EP.auctionID = e.id ) as Auction_Max_Price, cat.name as 'Category', sub.Name as 'Sub_Category' 	",false);
		
		$this->db->from('tbl_auction as e');
		$this->db->join('tbl_bank as br','br.id = e.bank_id','left');
		$this->db->join('tbl_branch as b','b.bank_id = e.bank_id and b.id = e.branch_id','left');
		$this->db->join('tbl_city as c','b.city=c.id','left');
		$this->db->join('tbl_state  as s','b.state = s.id','left');
		$this->db->join('tbl_category as cat','e.category_id=cat.id','left');
		$this->db->join('tbl_category as sub','e.subcategory_id=sub.id','left');
		
		$this->db->where_in('e.status', array(1,3,4,6,7));
		if($start_date!='' && $end_date!=''){
			$this->db->where("( e.updated_date BETWEEN '".$start_date."' AND '".$end_date."' )");
		}			*/	
		
		
		$query=$this->db->query("SELECT e.id as EventID, reference_no as NITRefNo, borrower_name as BorrowerName, (CASE WHEN event_type = 'sarfaesi' THEN 'SARFAESI' ELSE 'DRT' END) as EventType, br.Name as Bank_Name, b.name as Circle_Name, s.state_name as State_Name1, c.city_name, auction_end_date, (CASE WHEN price_bid_applicable = 'applicable' THEN 'Yes' ELSE 'No' END) as PriceBidApplicable, (CASE WHEN e.status = 0 THEN 'Saved' WHEN e.status = 1 THEN 'Published' WHEN e.status = 2 THEN 'Initialize' WHEN e.status = 3 THEN 'Stay' WHEN e.status = 4 THEN 'cancel' WHEN e.status = 5 THEN 'deleted' WHEN e.status = 6 THEN 'Published' ELSE 'Conclude' END) as Status, reserve_price, opening_price as Auction_OpeningPrice, (select COUNT(*) from tbl_auction_participate eb where eb.auctionID = e.id and eb.final_submit=1) as FRQ_no_of_bidder, (select MAX(frq.frq) from tbl_auction_participate_frq frq inner join tbl_auction_participate ebb on frq.auctionID = ebb.auctionID and frq.bidderID=ebb.bidderID where frq.auctionID = e.id and ebb.final_submit = 1) as Frq_Price, (select COUNT(distinct bidderID) from tbl_live_auction_bid eb where eb.auctionID = e.id ) as Auction_no_of_bidder, (select max(EP.bid_value) from tbl_live_auction_bid EP where EP.auctionID = e.id ) as Auction_Max_Price, cat.name as 'Category', sub.Name as 'Sub_Category' FROM (`tbl_auction` as e) LEFT JOIN `tbl_bank` as br ON `br`.`id` = `e`.`bank_id` LEFT JOIN `tbl_branch` as b ON `b`.`bank_id` = `e`.`bank_id` and b.id = e.branch_id LEFT JOIN `tbl_city` as c ON `b`.`city`=`c`.`id` LEFT JOIN `tbl_state` as s ON `b`.`state` = `s`.`id` LEFT JOIN `tbl_category` as cat ON `e`.`category_id`=`cat`.`id` LEFT JOIN `tbl_category` as sub ON `e`.`subcategory_id`=`sub`.`id` WHERE `e`.`status` IN (1, 3, 4, 6, 7) AND ( e.updated_date BETWEEN '2016-07-01 00:00:00' AND '2016-07-06 00:00:00' )")->result();
       //$data1 =  $query->result_array();
       
      // echo '<pre>';
       //print_R($query);
      // die;
        
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
               //print_r($row);
            }
            
            echo '<pre>';
            print_r($data);die;
            return $data;
        }else{
			return $data=0;	
		}
	}
	
	
	function replaceComma($field)
	{		 
		return str_replace(',',' ',$field);
	}
}

?>
