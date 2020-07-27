<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class exldata extends WS_Controller
{
	
	public function __Construct()
	{
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('Datatables');
		$this->load->library('table');
		$this->load->database();
		$this->load->helper(array('form'));
		$this->load->model('mis_model');
		$this->load->model('account_model');
		//$this->check_isvalidated();
		//ini_set('display_errors', 1);
		//error_reporting(E_ALL);
	}	
	
	public function index()
	{
		$this->saveExelData1();
	}		
	private function check_isvalidated(){
        if(!$this->session->userdata('id') OR $this->session->userdata('user_type')!='mis'){
          redirect('/registration/logout');
        }			
    }
	
	public function saveExelData1()
	{              
		$reportdata=$this->account_model->getcompleteMISReportData();

		//Track Bidder View Report start
		$trackreportdata=array(
				'event_id'=>'',
				'auction_id'=>'',
				'bidder_id'=>$this->session->userdata('id'),
				'bank_id'=>'',
				'user_type'=>$this->session->userdata('user_type'),
				'action_type'=>'complete_MIS_report',
				'action_type_event'=>"download",
				'ip'=>$_SERVER['REMOTE_ADDR'],
				'status'=>'1',
				'message'=>'Account User has successfully downloaded Complete Report',
				'indate'=>date('Y-m-d H:i:s'),
			);
	   $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);     

	header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=misreport.csv');

	$str = "Event ID,NITRefNo,Property State,Property City Name,Event Type,Auction End Date Time,Auction Status,Event BankID,Event Organization Name,Event Branch ID,Event Branch Name,Banker Email ID,Bank Contact Person,Banker Mobile No,Banker Designation,Invoice Branch Id,Invoice Branch Name,Invoice No.,Invoice Date,Invoiced Amount,Payment Date,Payment Recived Amount,Outstanding Balance,Created By,State,City Name,Paper Published Date,Logged Date,Published Date,Bidder Count,Borrower Name,Result,Last Bid Submission Date".PHP_EOL; //,Branch Address1,Branch Address2
		
	if($reportdata!=0)
	{
		$i=3;
		foreach($reportdata as $data)
		{

			//if(30691 != $data->auctionid) continue;
			
			$dateFormate = 'MMM D, YYYY h:mm';
			
			if($data->status==3)
			{
				$feedback="Stay";
			}elseif($data->status==4){
				$feedback="Cancelled";
			}else if($data->status==7)
			{
				$feedback="Conclude";
			}else{
				$feedback="Published";
			}
			
			if(isset($data->property_cityname_other) && $data->property_cityname_other!='')
			{
				$property_cityname = $data->property_cityname_other;
			}else{
				$property_cityname = $data->property_cityname;
			}
			$property_statename = $data->property_statename;
			
			if($data->status == 3)
			{
				$result="Stay";
			}	
			else if($data->status == 4)
			{
				$result="Cancel";
			}
			/*else if($data->status == 6)
			{
				$result="Successful";
			}*/
			else if($data->bidder_count > 0 && ($data->status == 6 || $data->status == 7))
			{
				$result="Successful";
			}
			else if($data->status == 6 || $data->status == 7)
			{
				$result="Un Successful";
			}
			else
			{
				$result = "N/A";
			}
				
			$timeDiff = 19800;
			
			$str .= $data->auctionid.",";
			$str .= str_replace(","," ",$data->reference_no).",";
					
		
			if($property_statename == "")
			{
					$property_statename = 'NULL';
			}
			$str .= str_replace(","," ",$property_statename).",";
			
			if($property_cityname == "" && $data->property_cityname_other != "")
			{
				$property_cityname = $data->property_cityname_other;
			}
			else if($property_cityname == "")
			{
				$property_cityname = 'NULL';
			}
			$str .= str_replace(","," ",$property_cityname).",";
			$str .= str_replace(","," ",$data->event_type).",";
			$str .= str_replace(","," ",$data->auction_end_date2).",";

			$str .= $feedback.",";


			$str .= $data->bank_id.",";
			$str .= str_replace(","," ",$data->bank_name).",";
			$str .= $data->branch_id.",";
			$str .= str_replace(","," ",$data->branch_name).",";
			//$str .= str_replace(","," ",($data->address1)).",";
			//$str .=  str_replace(","," ",($data->address2)).",";

			$str .=  str_replace(","," ",$data->email_id).",";
			$str .=  str_replace(","," ",$data->ContectPerson).",";
			$str .=  $data->mobile_no.",";
			$str .=  str_replace(","," ",$data->designation).",";
			$str .=  $data->invoice_branch_id.",";
			$str .=  str_replace(","," ",$data->invoice_branch_name).",";


			
			if($data->invoiceNo == '')
			{
				$data->invoiceNo = 'NULL';	
			}

			$str .=  $data->invoiceNo.",";
			
			if($data->invoiceDate == '')
			{
				$data->invoiceDate = 'NULL';	
				$str .=  $data->invoiceDate.",";
			}else{
				$str .=  $data->invoiceDate.",";			
			}
			
			
			if($data->invoice_amount == '')
			{
				$data->invoice_amount = 'NULL';	
				$str .=  $data->invoice_amount.",";
			}
			else
			{
				$str .=  $data->invoice_amount.",";
			}
			
			if($data->realizationDate == '')
			{
				$data->realizationDate = 'NULL';	
				$str .=  $data->realizationDate.",";
			}else{
				$str .=  $data->realizationDate.",";				
			}
			if($data->amount_recived_main == '')
			{
				$str .=  "NULL,";
			}
			else
			{
				$str .=  $data->amount_recived_main.",";
			}
			if($data->outstanding_amount > 10)
			{
				$str .=  $data->outstanding_amount.",";
			}
			else if($data->outstanding_amount <= 10)
			{
				$str .=  "0,";
			}
			else
			{
				$str .=  "NULL,";
			}
			
			$str .=  str_replace(","," ",$data->SalesExecutive).",";
			$str .=  str_replace(","," ",$data->state_name).",";
			$str .=  str_replace(","," ",$data->city_name).",";
			$str .=  str_replace(","," ",$data->press_release_date).",";
			$str .=  str_replace(","," ",$data->indate).",";
			$str .=  str_replace(","," ",$data->publish_indate).",";

			$str .=  str_replace(","," ",$data->bidder_count).",";
			$str .=  str_replace(","," ",$data->borrower_name).",";
			$str .=  str_replace(","," ",$result).",";
			$str .=  str_replace(","," ",$data->bid_last_date).PHP_EOL;


	
			}
		}
		
					 
		echo $str;

	}

	public function saveExelData()
	{              
		$reportdata=$this->account_model->getcompleteMISReportData();
		//Track Bidder View Report start
		$trackreportdata=array(
				'event_id'=>'',
				'auction_id'=>'',
				'bidder_id'=>$this->session->userdata('id'),
				'bank_id'=>'',
				'user_type'=>$this->session->userdata('user_type'),
				'action_type'=>'complete_MIS_report',
				'action_type_event'=>"download",
				'ip'=>$_SERVER['REMOTE_ADDR'],
				'status'=>'1',
				'message'=>'Account User has successfully downloaded Complete Report',
				'indate'=>date('Y-m-d H:i:s'),
			);
	   $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);     
		
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Complete MIS Report worksheet');
		//set cell A1 content with some text
		//$this->excel->getActiveSheet()->setCellValue('A1', 'LOG IN DETAILS');
		//$this->excel->getActiveSheet()->setCellValue('H1', 'E-AUCTION SCHEDULE');
		//$this->excel->getActiveSheet()->setCellValue('O1', 'BANK/DRT DETAILS');
		//$this->excel->getActiveSheet()->setCellValue('AA1', 'E-AUCTION PROCESS');
		//change the font size
		//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);
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
						
		//$this->excel->getActiveSheet()->mergeCells('A1:G1');
		//$this->excel->getActiveSheet()->mergeCells('H1:M1');
		//$this->excel->getActiveSheet()->mergeCells('N1:Y1');
		//$this->excel->getActiveSheet()->mergeCells('Z1:AK1');
		//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		//$this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		//$this->excel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		//$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	
		//$this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($miestilo);
		
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
        
		$this->excel->getActiveSheet()->getStyle("A:AI")->getFont()->setSize(9);
		$this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('B2')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('C2')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('D2')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('E2')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('F2')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('G2')->applyFromArray($miestilo2);
	
		$this->excel->getActiveSheet()->setCellValue('A2', 'Event ID'); 			// Event ID ($data->indate)
		$this->excel->getActiveSheet()->setCellValue('B2', 'NITRefNo'); 				// NITRefNo
		$this->excel->getActiveSheet()->setCellValue('C2', 'Property State');    		// Property State
		$this->excel->getActiveSheet()->setCellValue('D2', 'Property City Name');				// Property  City Name
		$this->excel->getActiveSheet()->setCellValue('E2', 'Event Type');			// Event Type
		$this->excel->getActiveSheet()->setCellValue('F2', 'Auction End Date Time');					// Auction End Date Time (Date + Time)
		$this->excel->getActiveSheet()->setCellValue('G2', 'Auction Status');					// Status
		
		/**************************************************************************/
		//$this->excel->getActiveSheet()->getStyle('H1')->applyFromArray($miestilo_tab);
		$this->excel->getActiveSheet()->getStyle('H2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('I2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('J2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('K2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('L2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('M2')->applyFromArray($miestilo_tab2);
		//$this->excel->getActiveSheet()->getStyle('N2')->applyFromArray($miestilo_tab2);
		
		$this->excel->getActiveSheet()->setCellValue('H2', 'Event BankID');   // Event BankID
		$this->excel->getActiveSheet()->setCellValue('I2', 'Event Organization Name');				    // Event BankName
		$this->excel->getActiveSheet()->setCellValue('J2', 'Event Branch ID');						// Event BranchID
		$this->excel->getActiveSheet()->setCellValue('K2', 'Event Branch Name');				// Event Branch Name
		$this->excel->getActiveSheet()->setCellValue('L2', 'Branch Address1');				// Branch Address1
		$this->excel->getActiveSheet()->setCellValue('M2', 'Branch Address2');				// Branch Address2
		//$this->excel->getActiveSheet()->setCellValue('N2', 'NITRef No');
		
		/**************************************************************************/
		//$this->excel->getActiveSheet()->getStyle('N1')->applyFromArray($miestilo_SEC);
		$this->excel->getActiveSheet()->getStyle('N2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('O2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('P2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('Q2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('R2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('S2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('T2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('U2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('V2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('W2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('X2')->applyFromArray($miestilo_SEC2);
		$this->excel->getActiveSheet()->getStyle('Y2')->applyFromArray($miestilo_SEC2);
		
		$this->excel->getActiveSheet()->setCellValue('N2', 'Buyer Email ID');					// Banker Email ID
		$this->excel->getActiveSheet()->setCellValue('O2', 'Buyer Contact Person');				// Bank Contact Person (FIRST NAME + LAST NAME)
		$this->excel->getActiveSheet()->setCellValue('P2', 'Buyer Mobile No');			// Banker Mobile No
		$this->excel->getActiveSheet()->setCellValue('Q2', 'Buyer Designation');		// Banker Designation
		$this->excel->getActiveSheet()->setCellValue('R2', 'Invoice Branch Id');			// Invoice Branch Id
		$this->excel->getActiveSheet()->setCellValue('S2', 'Invoice Branch Name');			// Invoice Branch Name
		$this->excel->getActiveSheet()->setCellValue('T2', 'Invoice No.');			// Invoice No.
		
		$this->excel->getActiveSheet()->setCellValue('U2', 'Invoice Date');				// Invoice Date
		
		$this->excel->getActiveSheet()->setCellValue('V2', 'Invoiced Amount'); 	// Invoiced Amount
		$this->excel->getActiveSheet()->setCellValue('W2', 'Payment Date');		// Payment Date
		$this->excel->getActiveSheet()->setCellValue('X2', 'Payment Recived Amount');			// Payment Recived Amount
		$this->excel->getActiveSheet()->setCellValue('Y2', 'Outstanding Balance');			// Outstanding Balance
		/**************************************************************************/
		//$this->excel->getActiveSheet()->getStyle('Z1')->applyFromArray($miestilo_tab);
		$this->excel->getActiveSheet()->getStyle('Z2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AA2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AB2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AC2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AD2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AE2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AF2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AG2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AH2')->applyFromArray($miestilo_tab2);
		$this->excel->getActiveSheet()->getStyle('AI2')->applyFromArray($miestilo_tab2);
		//$this->excel->getActiveSheet()->getStyle('AJ2')->applyFromArray($miestilo_tab2);
		//$this->excel->getActiveSheet()->getStyle('AK2')->applyFromArray($miestilo_tab2);
		
		$this->excel->getActiveSheet()->setCellValue('Z2', 'Created By');		// CreatedBy
		$this->excel->getActiveSheet()->setCellValue('AA2', 'State');// State
		$this->excel->getActiveSheet()->setCellValue('AB2', 'City Name');			// City Name
		$this->excel->getActiveSheet()->setCellValue('AC2', 'Paper Published Date');					// Paper Published Date
		$this->excel->getActiveSheet()->setCellValue('AD2', 'Logged Date');				// Logged Date
		$this->excel->getActiveSheet()->setCellValue('AE2', 'Published Date');		// Published Date
		$this->excel->getActiveSheet()->setCellValue('AF2', 'Bidder Count');		// BidderCount
		$this->excel->getActiveSheet()->setCellValue('AG2', 'Borrower Name');			// BorrowerName
		$this->excel->getActiveSheet()->setCellValue('AH2', 'Result');			// Result
		$this->excel->getActiveSheet()->setCellValue('AI2', 'Last Bid Submission Date');			// Last Bid Submission Date
		
		
			
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);	
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");		
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);	
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");		
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("11");
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
		$this->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth("11");
		$this->excel->getActiveSheet()->getColumnDimension('W')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('X')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('X')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth("16");
		$this->excel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(false);		
		$this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth("16");
		$this->excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth("16");
		$this->excel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AE')->setWidth("16");
		$this->excel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AF')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AG')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AH')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('AI')->setWidth("17");

		
		
	if($reportdata!=0)
	{
		$i=3;
		foreach($reportdata as $data)
		{
			
			$dateFormate = 'MMM D, YYYY h:mm';
			
			if($data->status==3)
			{
				$feedback="Stay";
			}elseif($data->status==4){
				$feedback="Cancelled";
			}else if($data->status==7)
			{
				$feedback="Conclude";
			}else{
				$feedback="Published";
			}
			
			if(isset($data->property_cityname_other) && $data->property_cityname_other!='')
			{
				$property_cityname = $data->property_cityname_other;
			}else{
				$property_cityname = $data->property_cityname;
			}
			$property_statename = $data->property_statename;
			
			if($data->status == 3)
			{
				$result="Stay";
			}	
			else if($data->status == 4)
			{
				$result="Cancel";
			}
			/*else if($data->status == 6)
			{
				$result="Successful";
			}*/
			else if($data->bidder_count > 0 && ($data->status == 6 || $data->status == 7))
			{
				$result="Successful";
			}
			else if($data->status == 6 || $data->status == 7)
			{
				$result="Un Successful";
			}
			else
			{
				$result = "N/A";
			}
				
			$timeDiff = 19800;
			
			//$this->excel->getActiveSheet()->getRowDimension($i-1)->setRowHeight(16);			 
			$this->excel->getActiveSheet()->getStyle("A:AI")->getFont()->setSize(9);
			$this->excel->getActiveSheet()->getStyle('A'.$i.':AI'.$i)->getAlignment()->setWrapText(true);
			
			$rowHeight =  $this->getHeight1($data);
			$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight($rowHeight);
			
			
			$this->excel->getActiveSheet()->getStyle('A'.$i.':AK'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);			
			$this->excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			
			$this->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($miestilo3);
			$this->excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($miestilo3);
			$this->excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($miestilo3);
			$this->excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($miestilo3);
			$this->excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($miestilo3);
			$this->excel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($miestilo3);
			$this->excel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($miestilo3);
		
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $data->auctionid);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $data->reference_no);
			
			if($property_statename == "")
			{
					$property_statename = 'NULL';
			}
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $property_statename);
			
			if($property_cityname == "" && $data->property_cityname_other != "")
			{
				$property_cityname = $data->property_cityname_other;
			}
			else if($property_cityname == "")
			{
				$property_cityname = 'NULL';
			}
			$this->excel->getActiveSheet()->setCellValue('D'.$i, $property_cityname);
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $data->event_type);
			//$this->excel->getActiveSheet()->setCellValue('F'.$i, $data->auction_end_date.' '.$data->auction_end_time);
			$this->excel->getActiveSheet()->setCellValue('F' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->auction_end_date2) + $timeDiff));
				$this->excel->getActiveSheet()
							->getStyle('F'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);
			//$this->excel->getActiveSheet()->setCellValue('F'.$i, $data->auction_end_date2);
			
			$this->excel->getActiveSheet()->setCellValue('G'.$i, $feedback);
			
			/**************************************************************************/
			
			$this->excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($miestilo_tab3);
			//$this->excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($miestilo_tab3);
			
			$this->excel->getActiveSheet()->setCellValue('H'.$i, $data->bank_id);
			$this->excel->getActiveSheet()->setCellValue('I'.$i, $data->bank_name);
			$this->excel->getActiveSheet()->setCellValue('J'.$i, $data->branch_id); //auction 
			$this->excel->getActiveSheet()->setCellValue('K'.$i, $data->branch_name);
			$this->excel->getActiveSheet()->setCellValue('L'.$i, $data->address1);
			$this->excel->getActiveSheet()->setCellValue('M'.$i, $data->address2);
			//$this->excel->getActiveSheet()->setCellValue('N'.$i, $data->reference_no);
			
			/**************************************************************************/
			$this->excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('R'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('S'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('T'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('U'.$i)->applyFromArray($miestilo_SEC3);
			
								
			$this->excel->getActiveSheet()->getStyle('V'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('W'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('X'.$i)->applyFromArray($miestilo_SEC3);
			$this->excel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($miestilo_SEC3);
			
			$this->excel->getActiveSheet()->setCellValue('N'.$i, $data->email_id);
			$this->excel->getActiveSheet()->setCellValue('O'.$i, $data->ContectPerson);
			$this->excel->getActiveSheet()->setCellValue('P'.$i, $data->mobile_no);
			$this->excel->getActiveSheet()->setCellValue('Q'.$i, $data->designation);
			$this->excel->getActiveSheet()->setCellValue('R'.$i, $data->invoice_branch_id);
			$this->excel->getActiveSheet()->setCellValue('S'.$i, $data->invoice_branch_name);
			
			if($data->invoiceNo == '')
			{
				$data->invoiceNo = 'NULL';	
			}
			$this->excel->getActiveSheet()->setCellValue('T'.$i, $data->invoiceNo);
			
			if($data->invoiceDate == '')
			{
				$data->invoiceDate = 'NULL';	
				$this->excel->getActiveSheet()->setCellValue('U'.$i, $data->invoiceDate);
			}else{
			//$this->excel->getActiveSheet()->setCellValue('U'.$i, $data->invoiceDate);
			$this->excel->getActiveSheet()->setCellValue('U' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->invoiceDate) + $timeDiff));

				$this->excel->getActiveSheet()
							->getStyle('U'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);
			}
			
			
			if($data->invoice_amount == '')
			{
				$data->invoice_amount = 'NULL';	
				$this->excel->getActiveSheet()->setCellValue('V'.$i, $data->invoice_amount);
			}
			else
			{
				$this->excel->getActiveSheet()->setCellValue('V'.$i,$data->invoice_amount);
			}
			
			if($data->realizationDate == '')
			{
				$data->realizationDate = 'NULL';	
				$this->excel->getActiveSheet()->setCellValue('W'.$i, $data->realizationDate);
			}else{
				$this->excel->getActiveSheet()->setCellValue('W' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->realizationDate) + $timeDiff));
				$this->excel->getActiveSheet()
							->getStyle('W'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);
			}
			if($data->amount_recived_main == '')
			{
				$this->excel->getActiveSheet()->setCellValue('X'.$i, 'NULL');
			}
			else
			{
				$this->excel->getActiveSheet()->setCellValue('X'.$i, $data->amount_recived_main);
			}
			if($data->outstanding_amount > 10)
			{
				$this->excel->getActiveSheet()->setCellValue('Y'.$i, $data->outstanding_amount);
			}
			else if($data->outstanding_amount <= 10)
			{
				$this->excel->getActiveSheet()->setCellValue('Y'.$i, '0');
			}
			else
			{
				$this->excel->getActiveSheet()->setCellValue('Y'.$i, 'NULL');				
			}
			/**************************************************************************/
			$this->excel->getActiveSheet()->getStyle('Z'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('AA'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('AB'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->getStyle('AC'.$i)->applyFromArray($miestilo_tab3);
			$this->excel->getActiveSheet()->setCellValue('Z'.$i, $data->SalesExecutive);
			$this->excel->getActiveSheet()->setCellValue('AA'.$i, $data->state_name);
			$this->excel->getActiveSheet()->setCellValue('AB'.$i, $data->city_name);
			//$this->excel->getActiveSheet()->setCellValue('AC'.$i, $data->press_release_date);
			$this->excel->getActiveSheet()->setCellValue('AC' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->press_release_date) + $timeDiff));
			$this->excel->getActiveSheet()
				->getStyle('AC'.$i)
				->getNumberFormat()
				->setFormatCode($dateFormate);

			//$this->excel->getActiveSheet()->setCellValue('AD'.$i, $data->indate);
			$this->excel->getActiveSheet()->setCellValue('AD' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->indate) + $timeDiff));
			$this->excel->getActiveSheet()
				->getStyle('AD'.$i)
				->getNumberFormat()
				->setFormatCode($dateFormate);
				
			//$this->excel->getActiveSheet()->setCellValue('AE'.$i, $data->publish_indate);
			$this->excel->getActiveSheet()->setCellValue('AE' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->publish_indate) + $timeDiff));
			$this->excel->getActiveSheet()
				->getStyle('AE'.$i)
				->getNumberFormat()
				->setFormatCode($dateFormate);
				
			$this->excel->getActiveSheet()->setCellValue('AF'.$i, $data->bidder_count);
			$this->excel->getActiveSheet()->setCellValue('AG'.$i, $data->borrower_name);
			$this->excel->getActiveSheet()->setCellValue('AH'.$i, $result);
			//$this->excel->getActiveSheet()->setCellValue('AI'.$i, $data->bid_last_date);
			
			$this->excel->getActiveSheet()->setCellValue('AI' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->bid_last_date) + $timeDiff));
			$this->excel->getActiveSheet()
				->getStyle('AI'.$i)
				->getNumberFormat()
				->setFormatCode($dateFormate);				
								
			$i++;	
		}
		}
		
		
		$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(18);
		$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(18);
		
		
		$filename='Complete_mis_Report.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

	}
	
	public function getHeight1($data)
	{
		 
		$height = 16;
		$netHeight = 16;
		foreach($data as $key => $v)
		{
			$length = strlen($v);
			$div = ceil($length/28) * $height;
			
			if($netHeight < $div)
			{
				$netHeight = $div;
			}
			
		}
		return $netHeight;
	}
	
	public function saveExelData2()
	{              
		$qry = "select e.id as EventID,reference_no as NITRefNo,borrower_name as BorrowerName ,

(CASE

        WHEN event_type = 'sarfaesi' THEN

         'SARFAESI'

        ELSE

         'DRT' END) as EventType,      

         br.Name as Bank_Name,

       b.name as Circle_Name, s.state_name as 'State_Name',  c.city_name , auction_end_date,

       (CASE

        WHEN price_bid_applicable = 'applicable' THEN

         'Yes'

        ELSE

         'No'

       END) as PriceBidApplicable,    

       (CASE

        WHEN e.status = 0 THEN

         'Saved'

          WHEN e.status = 1 THEN

         'Published'

          WHEN e.status = 2 THEN

         'Initialize'

          WHEN e.status = 3 THEN

         'Stay'

          WHEN e.status = 4 THEN

         'cancel'

          WHEN e.status = 5 THEN

         'deleted'

          WHEN e.status = 6 THEN

         'Published'

          ELSE

         'Conclude'

       END) as Status,                   

       reserve_price,opening_price as Auction_OpeningPrice,     

       (select COUNT(*) from tbl_auction_participate eb where eb.auctionID = e.id and

eb.final_submit=1) as FRQ_no_of_bidder,

(select MAX(frq.frq) from tbl_auction_participate_frq frq inner join tbl_auction_participate ebb

on frq.auctionID = ebb.auctionID and frq.bidderID=ebb.bidderID where frq.auctionID = e.id

and ebb.final_submit = 1) as Frq_Price,

(select COUNT(distinct bidderID) from tbl_live_auction_bid eb

where eb.auctionID = e.id ) as Auction_no_of_bidder,

(select max(EP.bid_value) from tbl_live_auction_bid EP where EP.auctionID = e.id ) as Auction_Max_Price,

cat.name as 'Category', sub.Name as 'Sub_Category',

e.bid_last_date as 'Bid_Submission_Last_Date'

from tbl_auction e

inner join tbl_bank br on br.id = e.bank_id

inner join tbl_branch b on b.bank_id = e.bank_id and b.id = e.branch_id

inner join tbl_city c on b.city=c.id

inner join tbl_state  s on b.state = s.id

inner join tbl_category cat on e.category_id=cat.id

inner join tbl_category sub on e.subcategory_id=sub.id

where e.status not in (0,5,2)";
	
		$query = $this->db->query($qry);
		$reportdata = $query->result_array();
		$filename = "AllBankDataReport_".date("Y-m-d His");
		header('Content-type: text/csv');
        header('Content-disposition: attachment;filename='.$filename.'.csv');

		$str = "Event ID,NITRefNo,Borrower Name,Event Type,Organization Name,Circle Name,State Name,City Name,Auction End Date,Price Bid Applicable,Status,Reserve Price,Auction Opening Price,FRQ No_Bidder,FRQ Price,Auction No_Bidder,Auction Max Price,Category,Sub-category,Last Bid Submission Date".PHP_EOL; //,Branch Address1,Branch Address2
		
		if($reportdata!=0)
		{
			$i=3;
			foreach($reportdata as $data)
			{
				//if(30691 != $data->auctionid) continue;
				
				$dateFormate = 'MMM D, YYYY h:mm';
				
				$str .=  str_replace(',',' ',$data['EventID']).",";
				$str .=  str_replace(',',' ',$data['NITRefNo']).",";
				$str .=  str_replace(',',' ',$data['BorrowerName']).",";
				$str .=  str_replace(',',' ',$data['EventType']).",";
				$str .=  str_replace(',',' ',$data['Bank_Name']).",";
				$str .=  str_replace(',',' ',$data['Circle_Name']).",";
				$str .=  str_replace(',',' ',$data['State_Name']).",";
				$str .=  str_replace(',',' ',$data['city_name']).",";
				$str .=  str_replace(',',' ',$data['auction_end_date']).",";
				$str .=  str_replace(',',' ',$data['PriceBidApplicable']).",";
				$str .=  str_replace(',',' ',$data['Status']).",";
				$str .=  str_replace(',',' ',$data['reserve_price']).",";
				$str .=  str_replace(',',' ',$data['Auction_OpeningPrice']).",";
				$str .=  str_replace(',',' ',$data['FRQ_no_of_bidder']).",";
				$str .=  str_replace(',',' ',$data['Frq_Price']).",";
				$str .=  str_replace(',',' ',$data['Auction_no_of_bidder']).",";
				$str .=  str_replace(',',' ',$data['Auction_Max_Price']).",";
				$str .=  str_replace(',',' ',$data['Category']).",";
				$str .=  str_replace(',',' ',$data['Sub_Category']).",";
				$str .=  str_replace(',',' ',$data['Bid_Submission_Last_Date']).PHP_EOL;
			}
		}	 
		echo $str;

	}
	
	
	public function saveXLSData()
	{              
		//$reportdata=$this->account_model->getcompleteMISReportData(); 
		$formdate = $_GET['start_date'];
		$todate = $_GET['end_date'];
		$this->db->select("e.ID,e.invoiceNo,e.invoiceDate,b.name,br.id as branch_id,br.address1,br.address2,c.city_name,e.amount,e.grandTotal");
		$this->db->from("tbl_event_invoice as e");
		$this->db->join("tbl_auction as a","a.id=e.auctionID","inner");
		$this->db->join("tbl_bank as b","b.id=a.bank_id","inner");
		$this->db->join("tbl_branch as br","br.id=a.branch_id","inner");
		$this->db->join("tbl_city as c","c.id=br.city","inner");
		$this->db->where("e.invoiceDate between  '$formdate'  and '$todate' ");
		$this->db->order_by("e.invoiceDate");
		//$this->db->limit(20);
		$qry = $this->db->get();
		$reportdata = $qry->result_array();
		
		//print_r($reportdata);
		//die;
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Invoice Report');
	
		$miestilo2= array('font' => array(
							'bold' => true
						),'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID
						)
						);
        
		$this->excel->getActiveSheet()->getStyle("A:AI")->getFont()->setSize(9);
		$this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('B1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('C1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('D1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('E1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('F1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('G1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('H1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('I1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('J1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('K1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('L1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('M1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('N1')->applyFromArray($miestilo2);
		$this->excel->getActiveSheet()->getStyle('O1')->applyFromArray($miestilo2);
		
	
		$this->excel->getActiveSheet()->setCellValue('A1', 'Voucher Auto No'); 			
		$this->excel->getActiveSheet()->setCellValue('B1', 'Date'); 				
		$this->excel->getActiveSheet()->setCellValue('C1', 'Ledger Name');    		
		$this->excel->getActiveSheet()->setCellValue('D1', 'Group');				
		$this->excel->getActiveSheet()->setCellValue('E1', 'Under Group');			
		$this->excel->getActiveSheet()->setCellValue('F1', 'Under Group');				
		$this->excel->getActiveSheet()->setCellValue('G1', 'Branch Code');
		$this->excel->getActiveSheet()->setCellValue('H1', 'Address');
		$this->excel->getActiveSheet()->setCellValue('I1', 'City');
		$this->excel->getActiveSheet()->setCellValue('J1', 'Voucher Ref No');
		$this->excel->getActiveSheet()->setCellValue('K1', 'Ref Type');
		$this->excel->getActiveSheet()->setCellValue('L1', 'Ref Name');
		$this->excel->getActiveSheet()->setCellValue('M1', 'Dr. Amount');
		$this->excel->getActiveSheet()->setCellValue('N1', 'Cr. Amount');
		$this->excel->getActiveSheet()->setCellValue('O1', 'Narration');
		
		
			
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);	
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");		
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);	
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");		
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth("30");

		
		
		if(count($reportdata))
		{
			$i=2; $increment = 1;
			foreach($reportdata as $data)
			{
				$invoiceDate = date("m/d/Y",strtotime($data['invoiceDate']));
				for($j=1;$j<=3;$j++)
				{
					$this->excel->getActiveSheet()->getStyle("A:O")->getFont()->setSize(9);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getAlignment()->setWrapText(true);
					
					//$rowHeight =  $this->getHeight1($data);
					//$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight($rowHeight);
					$this->excel->getActiveSheet()->setCellValue('A'.$i, $data['ID']);
					$this->excel->getActiveSheet()->setCellValue('B'.$i, $invoiceDate );
					
					if($j == 1)
					{
						$this->excel->getActiveSheet()->setCellValue('C'.$i, $data['name']." - ".$data['branch_id']);
						$this->excel->getActiveSheet()->setCellValue('D'.$i, 'DEBTOR - '.$data['name'] );
						$this->excel->getActiveSheet()->setCellValue('E'.$i, "DRT DEBTORS");
						$this->excel->getActiveSheet()->setCellValue('F'.$i, "Sundry Debtors");
						$this->excel->getActiveSheet()->setCellValue('G'.$i, $data['branch_id']);
						
						$address = $data['address1'];
						if($data['address2'])
						{
							$address.=",".$data['address2'];
						}
						$this->excel->getActiveSheet()->setCellValue('H'.$i, $address);
						$this->excel->getActiveSheet()->setCellValue('I'.$i, $data['city_name']);
						$this->excel->getActiveSheet()->setCellValue('J'.$i, $data['invoiceNo']); 	 
						$this->excel->getActiveSheet()->setCellValue('K'.$i, "New Ref" );
						$this->excel->getActiveSheet()->setCellValue('L'.$i, $data['invoiceNo']);
						$this->excel->getActiveSheet()->setCellValue('M'.$i, round($data['grandTotal']));
						//$this->excel->getActiveSheet()->setCellValue('N'.$i, "");
						$this->excel->getActiveSheet()->setCellValue('O'.$i, $data['invoiceNo']);
					}
					else if($j == 2)
					{
						$this->excel->getActiveSheet()->setCellValue('C'.$i, "auction service");
						$this->excel->getActiveSheet()->setCellValue('D'.$i, 'Indirect Incomes');
						$this->excel->getActiveSheet()->setCellValue('N'.$i, round($data['amount']));
					}
					else
					{
						$this->excel->getActiveSheet()->setCellValue('C'.$i, "service Tax (DRT) Payable");
						$this->excel->getActiveSheet()->setCellValue('D'.$i, 'Service Tax');
						$this->excel->getActiveSheet()->setCellValue('E'.$i, 'Duties & Taxes');
						$this->excel->getActiveSheet()->setCellValue('N'.$i, (round($data['grandTotal'])-round($data['amount'])));
					}
					$i++; // first increment
				}
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
?>
