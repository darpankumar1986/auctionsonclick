<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends WS_Controller{

private $apath = 'public/uploads/property_images/';
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
		$this->load->model('bidder_model');
		$this->load->model('admin/bank_model');
		$this->load->model('helpdesk_executive_model');
		$this->load->model('banker_model');
		
	}	
	
	
	
	
function showpdfData(){
			
// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
$pdfFilePath = $this->apath."test_data.pdf";
$data['page_title'] = 'Hello world'; // pass data to the view
 
//if (file_exists($pdfFilePath) == FALSE)
//{
    ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
    $html = $this->load->view('pdf_report', $data, true); // render the view into HTML
     
    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
    $pdf->WriteHTML($html); // write the HTML into the PDF
    $pdf->Output($pdfFilePath, 'F'); // save to file because we can
//}
 
	redirect($this->apath."test_data.pdf");
	}
	
	
}
?>