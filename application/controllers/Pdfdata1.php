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
	
	function genetepdf($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_test_data1.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'eAuction Report'; // pass data to the view
		$auctionData=$this->banker_model->viewReportPDF($auctionID);
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='branch'||$mainuser_type=='sales'||$mainuser_type=='helpdesk_ex'||$mainuser_type=='drt'||$mainuser_type=='region'){
                $actiontype='Bank_auction_report'; 
                $mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>$data[0]->bank_id,
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
	         //print_r($data); die();
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('pdf_report', $data, true); // render the view into HTML
		//echo $html;die;

		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		$pdf = $this->pdf->load();
		$pdf->AddPage();
				
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML

		//$pdf->SetDisplayMode('fullpage');
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">

		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
	
        
        function genetepdfuser($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$filename=time().'_test_data1.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'eAuction Report'; // pass data to the view
		$auctionData=$this->banker_model->viewReportPDF($auctionID);
                //Track Bidder View Report start
                $mainuser_type=$this->session->userdata('user_type');
                if($mainuser_type=='branch'||$mainuser_type=='sales'||$mainuser_type=='helpdesk_ex'||$mainuser_type=='drt'||$mainuser_type=='region'){
                $actiontype='Bank_auction_report'; 
                $mesage='Buyer has successfully Downloaded report';
                 }else{
                $actiontype='Bidder_report';  
                $mesage='Bidder has successfully Downloaded report';
                 }
                $user_type=$this->session->userdata('user_type');
                $trackreportdata=array('event_id'=>$auctionData[0]->eventID,
                                       'auction_id'=>$auctionData[0]->id,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>$data[0]->bank_id,
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
	        
		ini_set('memory_limit','128M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
                $data['pdf']=$pdf;
                $html = $this->load->view('pdf_report_user', $data, true); // render the view into HTML
		$pdf->AddPage();

		//$pdf->SetDisplayMode('fullpage');
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'); // .date(DATE_RFC822)  // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">

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
		ini_set('memory_limit','128M'); 
		// boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('/account_view/account_invoicePdfReport', $data, true); // render the view into HTML
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML
		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		$pdf = $this->pdf->load();
		$pdf->AddPage();
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|');
		//$pdf->SetFooter('Plot No. 301, First Floor, Udyog Vihar, Phase - 2, Gurgoan (HR)-122015,Tel:+91-124-4302020 Fax:+91-124-4302010 www.c1india.com');
		$pdf->list_indent_first_level = 0;
		
		///for watermark////
		$pdfExists = $this->account_model->checkInvoicePdfEntry($auctionID);
		if($pdfExists) {
			//$pdf->SetWatermarkText('DUPLICATE INVOICE');   //commented for water mark
			//$pdf->showWatermarkText = true;
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
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		ini_set('memory_limit','128M'); 
		// boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		 $html = $this->load->view('/account_view/account_invoicePdfReport', $data, true); // render the view into HTML
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML
		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		$pdf = $this->pdf->load();
		$pdf->AddPage();
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		$return=$this->account_model->invoiceMailTo1($pdfFilePath);
		if($return==1)
		{	$msg="Invoice has been send!";
			$this->session->set_flashdata('msg', $msg);
			redirect('account/invoiceMailTo/'.$auctionID);	
		}
		redirect($pdfFilePath);
	}
	
	function creditNotePdf($auctionID){
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		//$filename=time().'_Invoice.pdf';
		$filename='invoice_'.$auctionID.'.pdf';
		$pdfFilePath = $this->apath .$filename;
		$data['page_title'] = 'eAuction Report'; // pass data to the view
		$data['auction_data']=$this->account_model->viewReport($auctionID);
		$data['invoice_data']=$this->account_model->generateInvoice($auctionID);
		//if (file_exists($pdfFilePath) == FALSE)
		//{
		ini_set('memory_limit','128M'); 
		// boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		$html = $this->load->view('/account_view/account_creditNotePdfReport', $data, true); // render the view into HTML
		//$html = $this->load->view('pdf_report', $data); // render the view into HTML
		$this->load->library('pdf');
		//$pdf->SetHTMLHeader("<h2>eAuction Report</h2>");
		$pdf = $this->pdf->load();
		$pdf->AddPage();
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|');
		$pdf->list_indent_first_level = 0;
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		redirect($pdfFilePath);
	}
	
}
?>
