<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pdfdata extends WS_Controller{
	private $apath = 'public/uploads/property_images/';
	public function __Construct()
	{       parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('Datatables');
                $this->load->library('table');
                $this->load->database();
		$this->load->helper(array('form'));
		$this->load->model('admin/bank_model');
		$this->load->model('helpdesk_executive_model');
		$this->load->model('banker_model');
		$this->load->model('account_model');
		$this->load->model('owner_model');
	}	
	
	function genete_pdf_highest_bid_report($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_highest_bid_report.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'Highest Bid Report'; // pass data to the view
		$auctionData=$this->banker_model->viewReportPDF($auctionID);
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='buyer'){
					$actiontype='mcg_auction_report'; 
					$mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>1,
                                       'user_type'=>$mainuser_type,
                                       'action_type'=>$actiontype,
                                       'action_type_event'=>"download",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>$mesage,
                                       'indate'=>date('Y-m-d H:i:s'),
                                      );
                $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 //Track Bidder View Report End
                $BidderRankData=$this->banker_model->getBidderRank($auctionID);
		$data['BidderRankData']=$BidderRankData;
		$data['auctionData']=$auctionData;
		$data['totalbidding']=$this->banker_model->CountAuctionBidingData($auctionID);
	         //print_r($data); die();
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		//ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('pdf_report_highest_bid', $data, true); // render the view into HTML
		//echo $html;die;

		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('hi');
		$pdf->AddPage('L');
				
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML

		//$pdf->SetDisplayMode('fullpage');
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		//$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
		//$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
	
	function genete_pdf_accepted_bid_report($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_accepted_bid_report.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'Accepted Bid Report'; // pass data to the view
		$auctionData=$this->banker_model->viewReportPDF($auctionID);
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='buyer'){
					$actiontype='mcg_auction_report'; 
					$mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>1,
                                       'user_type'=>$mainuser_type,
                                       'action_type'=>$actiontype,
                                       'action_type_event'=>"download",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>$mesage,
                                       'indate'=>date('Y-m-d H:i:s'),
                                      );
                $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 //Track Bidder View Report End
                $BidderRankData=$this->banker_model->getBidderRank($auctionID);
		$data['BidderRankData']=$BidderRankData;
		$data['auctionData']=$auctionData;
		$data['totalbidding']=$this->banker_model->CountAuctionBidingData($auctionID);
	         //print_r($data); die();
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		//ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('pdf_report_accepted_bid', $data, true); // render the view into HTML
		//echo $html;die;

		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('hi');
		$pdf->AddPage('L');
				
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML

		//$pdf->SetDisplayMode('fullpage');
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		//$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
		//$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
	
	function genete_pdf_rejected_bid_report($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_rejected_bid_report.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'Rejected Bid Report'; // pass data to the view
		$auctionData=$this->banker_model->rejectedBidsReportPDF($auctionID);
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='buyer'){
					$actiontype='mcg_auction_report'; 
					$mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>1,
                                       'user_type'=>$mainuser_type,
                                       'action_type'=>$actiontype,
                                       'action_type_event'=>"download",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>$mesage,
                                       'indate'=>date('Y-m-d H:i:s'),
                                      );
                $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 //Track Bidder View Report End
                $BidderRankData=$this->banker_model->getBidderRank($auctionID);
		$data['BidderRankData']=$BidderRankData;
		$data['auctionData']=$auctionData;
		$data['totalbidding']=$this->banker_model->CountAuctionBidingData($auctionID);
	         //print_r($data); die();
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		//ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('pdf_report_rejected_bid', $data, true); // render the view into HTML
		//echo $html;die;

		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('hi');
		$pdf->AddPage('L');
				
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML

		//$pdf->SetDisplayMode('fullpage');
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		//$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
		//$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
	function genete_pdf_all_bid_report($auctionID){

		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_all_bid_report.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'Highest Bid Report'; // pass data to the view
		$auctionData=$this->banker_model->allBidsReportPDF($auctionID);
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='buyer'){
					$actiontype='mcg_auction_report'; 
					$mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>1,
                                       'user_type'=>$mainuser_type,
                                       'action_type'=>$actiontype,
                                       'action_type_event'=>"download",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>$mesage,
                                       'indate'=>date('Y-m-d H:i:s'),
                                      );
                $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 //Track Bidder View Report End
                $BidderRankData=$this->banker_model->getBidderRank($auctionID);
		$data['BidderRankData']=$BidderRankData;
		$data['auctionData']=$auctionData;
		$data['totalbidding']=$this->banker_model->CountAuctionBidingData($auctionID);
	         //print_r($data); die();
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		////ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('pdf_report_all_bids', $data, true); // render the view into HTML
		//echo $html;die;

		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('hi');
		$pdf->AddPage('L');
				
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML

		//$pdf->SetDisplayMode('fullpage');
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		//$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
		//$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
	function genete_pdf_breakup_bids_report($auctionID){
		
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_break_bid_report.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'Item wise break up of bid'; // pass data to the view
		$auctionData=$this->banker_model->viewReportPDF($auctionID);
		
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='buyer'){
					$actiontype='mcg_auction_report'; 
					$mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>1,
                                       'user_type'=>$mainuser_type,
                                       'action_type'=>$actiontype,
                                       'action_type_event'=>"download",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>$mesage,
                                       'indate'=>date('Y-m-d H:i:s'),
                                      );
                $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 //Track Bidder View Report End
                $BidderRankData=$this->banker_model->getBidderRank($auctionID);
		$data['BidderRankData']=$BidderRankData;
		$data['auctionData']=$auctionData;
		
		$data['totalbidding']=$this->banker_model->CountAuctionBidingData($auctionID);
	         //print_r($data); die();
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		//ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('pdf_report_breakup_of_bid', $data, true); // render the view into HTML
		//echo $html;die;

		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('hi');
		$pdf->AddPage('L');
				
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML

		//$pdf->SetDisplayMode('fullpage');
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		//$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
		//$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
        
        function genetepdfuser($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_bidder_auction_report.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'Auction Report'; // pass data to the view
		$auctionData=$this->owner_model->viewReportPDFuser($auctionID);
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='buyer'){
                $actiontype='mcg_auction_report'; 
                $mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>1,
                                       'user_type'=>$mainuser_type,
                                       'action_type'=>$actiontype,
                                       'action_type_event'=>"download",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>$mesage,
                                       'indate'=>date('Y-m-d H:i:s'),
                                      );
                $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                 //Track Bidder View Report End
                $BidderRankData=$this->banker_model->getBidderRank($auctionID);
		$data['BidderRankData']=$BidderRankData;
		$data['auctionData']=$auctionData;
	        
		//ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('hi');
                $data['pdf']=$pdf;
                $html = $this->load->view('pdf_report_user', $data, true); // render the view into HTML
		$pdf->AddPage('L');

		//$pdf->SetDisplayMode('fullpage');
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">

		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
	function generateAccountInvoicePdf($auctionID) {
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename='invoice_'.time().'_'.$auctionID.'.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'eAuction Report'; // pass data to the view
		$data['auction_data']=$this->account_model->viewReport($auctionID);
		$data['invoice_data']=$this->account_model->generateInvoice($auctionID);
                $user_type=$this->session->userdata('user_type');
                $actiontype='account_invoice_report';
                $trackreportdata=array('event_id'=>$data['auction_data'][0]->eventID,
                                       'auction_id'=>$auctionID,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>$data['auction_data'][0]->bank_id,
                                       'user_type'=>$user_type,
                                       'action_type'=>$actiontype,
                                       'action_type_event'=>"download",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>'Account has successfully Downloaded Invoice',
                                       'indate'=>date('Y-m-d H:i:s'),
                                      );
               $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
                //Track Bidder View Report End
                //if (file_exists($pdfFilePath) == FALSE)
		//{
		//ini_set('memory_limit','128M'); 
		
		// boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('/account_view/account_invoicePdfReport', $data, true); // render the view into HTML
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML
		//echo $html;die;
		$this->load->library('pdf');
		
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		$pdf = $this->pdf->load();
		$pdf = new mPDF('hi');
		$pdf->AddPage();
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|');
		//$pdf->SetFooter('Plot No. 301, First Floor, Udyog Vihar, Phase - 2, Gurgoan (HR)-122015,Tel:+91-124-4302020 Fax:+91-124-4302010 www.c1india.com');
		$pdf->list_indent_first_level = 0;
		
		///for watermark////
		$pdfExists = $this->account_model->checkInvoicePdfEntry($auctionID);
		if($pdfExists) {
			$pdf->SetWatermarkText('DUPLICATE INVOICE');   //commented for water mark
			$pdf->showWatermarkText = true;
		} else {
			$details = array("invoice_id"=>$auctionID, "file_path"=>$pdfFilePath, "indate"=>date('Y-m-d H:i:s'));
			$this->account_model->saveInvoicePdfEntry($details);
		}
		//end watermark//
		$pdf->WriteHTML($html); // write the HTML into the PDF
		//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		$pdf->Output('invoice_'.time().'_'.$auctionID.'.pdf','D');
		//}
		//redirect($pdfFilePath);
	}
	
	function mailgenerateAccountInvoicePdf(){
		$submit = $this->input->post('submit');
		$auctionID 	= $this->input->post('auctionID');
		$filename='invoice_'.$auctionID.'.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'eAuction Report'; // pass data to the view
		$data['auction_data']=$this->account_model->viewReport($auctionID);
		$data['invoice_data']=$this->account_model->generateInvoice($auctionID);
		
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('is_invoice_generated'=>1));
		
		$this->db->where('auctionID', $auctionID);
		$this->db->update('tbl_event_invoice', array('status'=>1));
		
		
			
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		//ini_set('memory_limit','128M'); 
		// boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('/account_view/account_invoicePdfReport', $data, true); // render the view into HTML
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML
		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		$pdf = $this->pdf->load();
		$pdf = new mPDF('hi');
		$pdf->AddPage();
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		
		/*$project_id = 26;
		$this->db->where('auctionID', $auctionID);
		$query = $this->db->get('tbl_event_invoice');
		foreach($query->result() as $invoice)
		{
			$this->db->where('user.id', $data['auction_data'][0]->invoice_mail_to);
			$this->db->join('tbl_branch as branch','branch.state = state.id','');
			$this->db->join('tbl_user as user','user.user_type_id = branch.id');
			$query_state = $this->db->get('tbl_state as state');		
			if($query_state->num_rows() > 0)
			{
				$res_state = $query_state->result();
				$state_name = $res_state[0]->state_name;
			}		
			
			$data = array(
							 'invoice_no'=>$invoice->invoiceNo,
							 'invoice_amount'=> $invoice->amount,
							 'service_tax'=>15,
							 'gross_invoice_amount'=>$invoice->grandTotal,
							 'particular'=>"EventId: ".$data['auction_data'][0]->id." | Reference No.: ".$data['auction_data'][0]->event_title,
							 'invoice_date'=>$invoice->invoiceDate,
							 'invoice_uploaded_path'=>base_url().$pdfFilePath,
							 'remarks'=>$auctionID,
							 'user_id'=>'0',
							 'status_id'=>'1',
							 'project_id'=>$project_id,							 
							 'in_datetime'=>$invoice->invoiceDate
						 );  
					  
			$CI = &get_instance();	
			$this->db2 = $CI->load->database('db2', TRUE);	
			$this->db2->where('project_id',$project_id);
			$this->db2->where('division_name',$state_name);
			$query_division = $this->db2->get('tbldivision');
			if($query_division->num_rows() > 0)
			{
				$res_division = $query_division->result();
				$division_id = $res_division[0]->division_id;
			}
			else
			{
				$data_division = array(
										"project_id"=>$project_id,
										"division_name"=>$state_name,
										"status"=>1,
										"indate"=>$invoice->invoiceDate
										
									);
				$this->db2->insert('tbldivision',$data_division);
				$division_id = $this->db2->insert_id();
				
			}
			$data['division_id'] = $division_id;
			$this->db2->insert('tblinvoice',$data);
			
			$CI = &get_instance();	
			$this->db2 = $CI->load->database('default', TRUE);	  
		}*/
		
		
		$return=$this->account_model->invoiceMailTo1($pdfFilePath);
		if($return==1)
		{	$msg="Invoice has been send!";
			$this->session->set_flashdata('msg', $msg);
			//redirect('account/invoiceMailTo/'.$auctionID);	
			redirect('account/addInvoiceDetail/');	
		}
		redirect($pdfFilePath);
	}
	
	function creditNotePdf($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		//$filename=time().'_Invoice.pdf';
		$data = $this->account_model->insertCreditNote($auctionID);
		$filename='invoice_'.$auctionID.'.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'eAuction Report'; // pass data to the view
		
		//$data['auction_data']=$this->account_model->viewReport($auctionID);
		//$data['invoice_data']=$this->account_model->generateInvoice($auctionID);
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		//ini_set('memory_limit','128M'); 
		// boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('/account_view/account_creditNotePdfReport', $data, true); // render the view into HTML
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML
		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		$pdf = $this->pdf->load();
		$pdf = new mPDF('hi');
		$pdf->AddPage();
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF
		//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		
		//redirect($pdfFilePath);
		$pdf->Output('credit_note_'.time().'_'.$auctionID.'.pdf','D');
	}
    
        // 29-07-2017: Added by Azizur: For calculation of Auction demand notice.(For H1 Bidder)
        function genete_pdf_demand_notice_report($auctionID){
            // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
            $filename       =   'demand_notice_report_'.$auctionID.'.pdf';
            $pdfFilePath     =   $this->apath .$filename;

            $data['page_title'] = 'Demand Notice Report'; // pass data to the view
            $auctionData        =   $this->banker_model->demandNoticeReportPDF($auctionID);
            
            //Track Bidder View Report start
            $mainuser_type      =   $this->session->userdata('user_type');
            
            if($mainuser_type == 'buyer'){
                $actiontype =   'mcg_auction_report'; 
                $mesage     =   'Buyer has successfully downloaded demand notice report';
             }else{
                $actiontype =   'Bidder_report';  
                $mesage     =   'Bidder has successfully downloaded demand notice report';
             }

            $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                   'auction_id'=>$auctionData[0]->id,
                                   'bidder_id'=>$this->session->userdata('id'),
                                   'bank_id'=>1,
                                   'user_type'=>$mainuser_type,
                                   'action_type'=>$actiontype,
                                   'action_type_event'=>"download",
                                   'ip'=>$_SERVER['REMOTE_ADDR'],
                                   'status'=>'1',
                                   'message'=>$mesage,
                                   'indate'=>date('Y-m-d H:i:s'),
                                );

            $query_log  =   $this->db->insert("tbl_log_all_report_track",$trackreportdata);
             //Track Bidder View Report End

            $BidderRankData         =   $this->banker_model->getBidderRank($auctionID);
            $data['BidderRankData'] =   $BidderRankData;
            $data['auctionData']    =   $auctionData;
            $data['totalbidding']   =   $this->banker_model->CountAuctionBidingData($auctionID);
             //print_r($data); die();
            //if (file_exists($pdfFilePath) == FALSE)
            //{
            //ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
            $html   =   $this->load->view('pdf_report_demand_notice', $data, true); // render the view into HTML
            //echo $html;die;

           $this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('hi');
		$pdf->AddPage('L');

              
                
            //$pdf->SetDisplayMode('fullpage');
            //$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
            //$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
            //$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
            $pdf->list_indent_first_level = 0;
            $pdf->WriteHTML($html); // write the HTML into the PDF

            $pdf->Output($pdfFilePath, 'F'); // save to file because we can
            //}
            redirect($pdfFilePath);
          
	}

        // 29-07-2017: Added by Azizur: For  initiate refund scroll/cheque.
        function initiate_refund_pdf($auction_id, $dispose_order_no,$pdf_type)
        {
            // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
            $fileNameScroll     = 'refund_transfer/refund/scroll/'.$dispose_order_no.'S'.$auction_id.'.pdf';
            $fileNameCheque     = 'refund_transfer/refund/cheque/'.$dispose_order_no.'C'.$auction_id.'.pdf';
            $pdfFilePathScroll  = $this->apath .$fileNameScroll;
            $pdfFilePathCheque  = $this->apath .$fileNameCheque;

            $sData['page_title'] = 'Refund Scroll Report';
            $cData['page_title'] = 'Refund Cheque Report';
            $sRefundData         = $this->banker_model->initiate_refund_scroll_report($auction_id, $dispose_order_no);
            $cRefundData         = $this->banker_model->initiate_refund_cheque_report($auction_id, $dispose_order_no);
            $event_id            = GetTitleByField('tbl_auction','id='.$auction_id,'eventID');
           // echo "<pre>"; echo print_r($cRefundData); die;
            //Track Bidder View Report start
            $mainuser_type      =   $this->session->userdata('user_type');
            
            if($mainuser_type == 'buyer'){
                $actiontype =   'kda_auction_report'; 
                $mesage     =   'Seller has successfully created Refund Scroll/Cheque Report';
             }else{
                $actiontype =   'Bidder_report';  
                $mesage     =   'Bidder has successfully downloaded Refund Scroll/Cheque Report';
             }

            $trackReportData=array(
                'event_id'=>$event_id,
                'auction_id'=>$auction_id,
                'bidder_id'=>$this->session->userdata('id'),
                'bank_id'=>1,
                'user_type'=>$mainuser_type,
                'action_type'=>$actiontype,
                'action_type_event'=>"created",
                'ip'=>$_SERVER['REMOTE_ADDR'],
                'status'=>'1',
                'message'=>$mesage,
                'indate'=>date('Y-m-d H:i:s'),
            );

            $query_log  =   $this->db->insert("tbl_log_all_report_track", $trackReportData);
             //Track Bidder View Report End

            $sData['sRefundData']    =   $sRefundData;
            $sData['auction_details'] = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auction_id);
            $cData['cRefundData']    =   $cRefundData;
             //print_r($data); die();
            //if (file_exists($pdfFilePath) == FALSE)
            //{
            //ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
            $html_scroll   =   $this->load->view('pdf_report_initiate_refund_scroll', $sData, true); 
            $html_cheque   =   $this->load->view('pdf_report_initiate_refund_cheque', $cData, true); 
            //echo $html;die;

            //$this->load->library('pdf');
            //$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
            //$pdf = $this->pdf->load();
            //$pdf = new mPDF('hi');
            //$pdf->AddPage('L');
   
            //$pdf->SetDisplayMode('fullpage');
            //$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
            //$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
            //$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
            //$pdf->list_indent_first_level = 0;
            
            // For loop has been used to create Total number of pdf(Here total number of pdf is 2).
            for($i =0 ; $i<2; $i++)
            {
                $this->load->library('pdf');
                //$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
                $pdf = $this->pdf->load();
                $pdf = new mPDF('hi');
                //$pdf->AddPage('L');
                $pdf->AddPage("L","","","","",5,5,5,5);					
                $pdf->list_indent_first_level = 0;
                
                if($i==0)
                {
                    $pdf->WriteHTML($html_scroll);
                    $pdf->Output($pdfFilePathScroll, 'F');  
                }
                if($i==1)
                {
                    $pdf->WriteHTML($html_cheque);
                    $pdf->Output($pdfFilePathCheque, 'F');
                }
		
            }
            
            if($pdf_type == "S"){
                redirect($pdfFilePathScroll);
            }
            else{
                redirect($pdfFilePathCheque);
            }
            
            //}
            //$msg = "Scroll/Cheque for bank created suceesfully with Dispose Order No.: $dispose_order_no";
            //$this->session->set_flashdata('success', $msg);
            
            
            //redirect('buyer/initiate_refund_dashboard/'.$auction_id);
            //redirect($pdfFilePath);
	}
        
   
        // 29-07-2017: Added by Azizur: For  initiate Transfer scroll/cheque.
        function initiate_transfer_pdf($auction_id, $dispose_order_no,$pdf_type)
        {
            //echo $dispose_order_no;
           // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
            $fileNameScroll     = 'refund_transfer/transfer/scroll/'.$dispose_order_no.'S'.$auction_id.'.pdf';
            $fileNameCheque     = 'refund_transfer/transfer/cheque/'.$dispose_order_no.'C'.$auction_id.'.pdf';
            $pdfFilePathScroll  = $this->apath .$fileNameScroll;
            $pdfFilePathCheque  = $this->apath .$fileNameCheque;

            $sData['page_title'] = 'Transfer Scroll Report';
            $cData['page_title'] = 'Transfer Cheque Report';
            $sTransferData       = $this->banker_model->initiate_transfer_scroll_report($auction_id, $dispose_order_no);
            $cTransferData       = $this->banker_model->initiate_transfer_cheque_report($auction_id, $dispose_order_no);
            $event_id            = GetTitleByField('tbl_auction', 'id='.$auction_id, 'eventID');
            //echo "<pre>"; print_r($refundData); die;
            //Track Bidder View Report start
            $mainuser_type      =   $this->session->userdata('user_type');
            
            if($mainuser_type == 'buyer'){
                $actiontype =   'mcg_auction_report'; 
                $mesage     =   'Seller has successfully created Transfer Scroll/Cheque Report';
             }else{
                $actiontype =   'Bidder_report';  
                $mesage     =   'Bidder has successfully downloaded Transfer Scroll/Cheque Report';
             }
             
            $user_type = $this->session->userdata('user_type');
            
            $trackReportData=array(
                'event_id'=>$event_id,
                'auction_id'=>$auction_id,
                'bidder_id'=>$this->session->userdata('id'),
                'bank_id'=>1,
                'user_type'=>$mainuser_type,
                'action_type'=>$actiontype,
                'action_type_event'=>"created",
                'ip'=>$_SERVER['REMOTE_ADDR'],
                'status'=>'1',
                'message'=>$mesage,
                'indate'=>date('Y-m-d H:i:s'),
            );

            $query_log  =   $this->db->insert("tbl_log_all_report_track", $trackReportData);
             //Track Bidder View Report End

            $sData['sTransferData'] =   $sTransferData;
            $sData['auction_details'] = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auction_id);
            $cData['cTransferData'] =   $cTransferData;
         
            //ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
            //echo "<pre>";print_r($sData);die;
            //$this->load->view('pdf_report_initiate_transfer_scroll', $sData);die;
            $html_scroll   =   $this->load->view('pdf_report_initiate_transfer_scroll', $sData, true);
            $html_cheque   =   $this->load->view('pdf_report_initiate_transfer_cheque', $cData, true);
           
            //echo $html_cheque;die;

           //$this->load->library('pdf');
            //$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
            //$pdf = $this->pdf->load();
            //$pdf = new mPDF('hi');
            //$pdf->AddPage('L');

              
                
            //$pdf->SetDisplayMode('fullpage');
            //$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // kanwarjeet   Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
            //$pdf->addTTFfont('fonts/AnjaliOldLipi.ttf', 'TrueTypeUnicode', '', 32);
            //$pdf->SetFont('AnjaliOldLipi', '', 10,'false');
            //$pdf->list_indent_first_level = 0;
            
            // For loop has been used to create Total number of pdf(Here total number of pdf is 2).
            for($i =0 ; $i<2; $i++)
            {
                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                $pdf = new mPDF('hi');
                //$pdf->AddPage('L');
                $currentDate    =   date("d-m-Y h:i:sA");
                //$pdf->SetHTMLHeader('Auction ID','O',true);
                $pdf->SetHTMLFooter('
                <table width="100%">
                    <tr>
                        <td align="left" valign="top">Created On : '.$currentDate.'</td>
                        <td align="right" valign="top" >(Signature and Seal of Paying Authoritie(s))</td>
                    </tr>
                    <tr>
                        <td width="33%" colspan="2" align="center">Page : {PAGENO}</td>
                    </tr>
                </table>'); 
                $pdf->AddPage("L","","","","",5,5,5,5);
                $pdf->list_indent_first_level = 0;
                
                if($i==0)
                {
                    $pdf->WriteHTML($html_scroll);
                    $pdf->Output($pdfFilePathScroll, 'F');  
                }
                if($i==1)
                {
                    $pdf->WriteHTML($html_cheque);
                    $pdf->Output($pdfFilePathCheque, 'F');
                }
            }
          
            if($pdf_type == "S"){
                redirect($pdfFilePathScroll);
            }
            else{
                redirect($pdfFilePathCheque);
            }
	}
	
}
?>
