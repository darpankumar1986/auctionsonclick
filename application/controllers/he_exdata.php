<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    //ini_set('max_execution_time', 10000);
   class He_exdata extends WS_Controller {
       public function __Construct() {
        parent::__Construct();
        ob_start();
		set_time_limit(0);
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
        $this->load->helper(array('form'));
        $this->load->model('mis_model');
        $this->load->model('account_model');
		
    }

    public function index() {
        $this->saveExelData();
    }

    /* private function check_isvalidated() {
        if (!$this->session->userdata('id') OR $this->session->userdata('user_type') != 'mis') {
            redirect('/registration/logout');
        }
    }
    * 
    */
   public function saveExelData() {
        $reportdata = $this->account_model->completeMISReportData();
        $trackreportdata = array(
            'event_id' => '',
            'auction_id' => '',
            'bidder_id' => $this->session->userdata('id'),
            'bank_id' => '',
            'user_type' => $this->session->userdata('user_type'),
            'action_type' => 'complete_MIS_report',
            'action_type_event' => "download",
            'ip' => $_SERVER['REMOTE_ADDR'],
            'status' => '1',
            'message' => 'Account User has successfully downloaded Complete Report',
            'indate' => date('Y-m-d H:i:s'),
        );
        $query_log = $this->db->insert("tbl_log_all_report_track", $trackreportdata);

        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Complete MIS Report worksheet');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Auction Details');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Opener Details');
        $this->excel->getActiveSheet()->setCellValue('O1', 'Bidders Detail');
        $miestilo = array(
                 'font' => array(
                        'bold' => false,
                        'color' => array('rgb' => 'ffffff')
                               ), 
                 'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => 'b88c00')
                               )
                        );

        $miestilo2 = array(
            'font' => array(
                    'bold' => false,
                    'color' => array('rgb' => '000000')
                           ),
            'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array('rgb' => 'ffd85d')
                           )
                         );
        $miestilo3 = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => '000000')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'fff3cd')
            )
        );

        $miestilo_tab = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => 'ffffff')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '867e4c')
            )
        );

        $miestilo_tab2 = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => '000000')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'c5be97')
            )
        );
        $miestilo_tab3 = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => '000000')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'eeece1')
            )
        );


        $miestilo_SEC = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => 'ffffff')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '0000cc')
            )
        );

        $miestilo_SEC2 = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => '000000')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '579bff')
            )
        );
        $miestilo_SEC3 = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => '000000')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'e0ebf8')
            )
        );
        $miestilo_AUC = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => 'ffffff')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '7030a0')
            )
        );

        $miestilo_AUC2 = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => '000000')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'c3b8d6')
            )
        );
        $miestilo_AUC3 = array('font' => array(
                'bold' => false,
                'color' => array('rgb' => '000000')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'efecf4')
            )
        );
        
        $this->excel->getDefaultStyle()->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getDefaultStyle()->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getDefaultStyle()->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getDefaultStyle()->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $this->excel->getActiveSheet()->mergeCells('A1:K1');
        $this->excel->getActiveSheet()->mergeCells('H1:Q1');
        $this->excel->getActiveSheet()->mergeCells('O1:X1');
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($miestilo);
        $this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('B2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('C2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('D2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('E2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('F2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('G2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('H2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('I2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('J2')->applyFromArray($miestilo2);
        $this->excel->getActiveSheet()->getStyle('K2')->applyFromArray($miestilo2);


        $this->excel->getActiveSheet()->setCellValue('A2', 'Event ID');
        $this->excel->getActiveSheet()->setCellValue('B2', 'NITRef No');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Tender Title');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Offer Submission Last Date');
        $this->excel->getActiveSheet()->setCellValue('E2', 'Opening Date');
        $this->excel->getActiveSheet()->setCellValue('F2', 'Auction Start Date');
        $this->excel->getActiveSheet()->setCellValue('G2', 'Auction End Date');
        $this->excel->getActiveSheet()->setCellValue('H2', 'Published Date');
        $this->excel->getActiveSheet()->setCellValue('I2', 'Is DSCEnabled');
        $this->excel->getActiveSheet()->setCellValue('J2', 'Status');
        $this->excel->getActiveSheet()->setCellValue('K2', 'No Of Auto Extn');
        $this->excel->getActiveSheet()->getStyle('L2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('M2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('N2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('O1')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('O2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('P2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('Q2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('R2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('S2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('T2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('U2')->applyFromArray($miestilo_SEC2);

        $this->excel->getActiveSheet()->setCellValue('L2', 'First Opener First  Name');
        $this->excel->getActiveSheet()->setCellValue('M2', 'First Opener Last Name');
        $this->excel->getActiveSheet()->setCellValue('N2', 'First Opener Contact No');
        $this->excel->getActiveSheet()->setCellValue('O2', 'First Opener User Id');
        $this->excel->getActiveSheet()->setCellValue('P2', 'First Opener Email ID');
        $this->excel->getActiveSheet()->setCellValue('Q2', 'Second Opener First Name');
        $this->excel->getActiveSheet()->setCellValue('R2', 'Second Opener Last Name');
        $this->excel->getActiveSheet()->setCellValue('S2', 'Second Opener Contact No');
        $this->excel->getActiveSheet()->setCellValue('T2', 'Second Opener User Id');
        $this->excel->getActiveSheet()->setCellValue('U2', 'Second Opener Email Id');
        $this->excel->getActiveSheet()->getStyle('V2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('W2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->getStyle('X2')->applyFromArray($miestilo_SEC2);
        $this->excel->getActiveSheet()->setCellValue('V2', 'Bidder Name');
        $this->excel->getActiveSheet()->setCellValue('W2', 'Bidder Email ID');
        $this->excel->getActiveSheet()->setCellValue('X2', 'Bidder Mobile No');
        
       			
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("8");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("18");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("18");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("18");
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("18");
		$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);			
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth("16");
		$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('W')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('X')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('X')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth("20");	



        if ($reportdata != 0) {
            $i = 3;
            foreach ($reportdata as $data) {
				$dateFormate = 'MMM D, YYYY h:mm';
                   //Check DSC Status
                if ($data->dsc_enabled == '1') {
                    $desccheck = 'ENABLED';
                } else {
                    $desccheck = 'DISABLED';
                }
                  //Check Status
                if ($data->status == 3) {
                    $feedback = "Stay";
                } elseif ($data->status == 4) {
                    $feedback = "Cancelled";
                } else if ($data->status == 7) {
                    $feedback = "Conclude";
                } else {
                    $feedback = "Published";
                }
                if ($data->total_bidder > 0) {
                    $result = "Successful";
                } else {
                    $result = "Un Successful";
                }

				$timeDiff = 19800;
                
                //$this->excel->getActiveSheet()->getRowDimension($i-1)->setRowHeight(16);			 
				$this->excel->getActiveSheet()->getStyle("A:AC")->getFont()->setSize(10);
				
				$this->excel->getActiveSheet()->getStyle('A'.$i.':AI'.$i)->getAlignment()->setWrapText(true);
			
				$rowHeight =  $this->getHeight1($data);
				$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight($rowHeight);

                $this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($miestilo3);
                $this->excel->getActiveSheet()->getStyle('B' . $i)->applyFromArray($miestilo3);
                $this->excel->getActiveSheet()->getStyle('C' . $i)->applyFromArray($miestilo3);
                $this->excel->getActiveSheet()->getStyle('D' . $i)->applyFromArray($miestilo3);
                $this->excel->getActiveSheet()->getStyle('E' . $i)->applyFromArray($miestilo3);
                $this->excel->getActiveSheet()->getStyle('F' . $i)->applyFromArray($miestilo3);
                $this->excel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($miestilo3);

                $this->excel->getActiveSheet()->setCellValue('A' . $i, $data->id);
                $this->excel->getActiveSheet()->setCellValue('B' . $i, $data->reference_no);
                $this->excel->getActiveSheet()->setCellValue('C' . $i, $data->event_title);

				//date('m/d/Y',strtotime($data->bid_last_date))
				 $this->excel->getActiveSheet()->setCellValue('D' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->bid_last_date) + $timeDiff));
				$this->excel->getActiveSheet()
							->getStyle('D'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);


               
                $this->excel->getActiveSheet()->setCellValue('E' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->bid_opening_date) + $timeDiff));
				$this->excel->getActiveSheet()
							->getStyle('E'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);
                $this->excel->getActiveSheet()->setCellValue('F' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->auction_start_date) + $timeDiff));
				$this->excel->getActiveSheet()
							->getStyle('F'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);
                $this->excel->getActiveSheet()->setCellValue('G' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->auction_end_date) + $timeDiff));
				$this->excel->getActiveSheet()
							->getStyle('G'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);

                /*                 * *********************************************************************** */

                $this->excel->getActiveSheet()->getStyle('H' . $i)->applyFromArray($miestilo_tab3);
                $this->excel->getActiveSheet()->getStyle('I' . $i)->applyFromArray($miestilo_tab3);
                $this->excel->getActiveSheet()->getStyle('J' . $i)->applyFromArray($miestilo_tab3);
                $this->excel->getActiveSheet()->getStyle('K' . $i)->applyFromArray($miestilo_tab3);
                $this->excel->getActiveSheet()->getStyle('L' . $i)->applyFromArray($miestilo_tab3);
                $this->excel->getActiveSheet()->getStyle('M' . $i)->applyFromArray($miestilo_tab3);
                $this->excel->getActiveSheet()->getStyle('N' . $i)->applyFromArray($miestilo_tab3);

                $this->excel->getActiveSheet()->setCellValue('H' . $i, PHPExcel_Shared_Date::PHPToExcel(strtotime($data->indate) + $timeDiff));
				$this->excel->getActiveSheet()
							->getStyle('H'.$i)
							->getNumberFormat()
							->setFormatCode($dateFormate);

                $this->excel->getActiveSheet()->setCellValue('I' . $i, $desccheck);
                $this->excel->getActiveSheet()->setCellValue('J' . $i, $feedback); //auction 
                $this->excel->getActiveSheet()->setCellValue('K' . $i, $data->no_of_auto_extn);
                $this->excel->getActiveSheet()->setCellValue('L' . $i, $data->first_name);
                $this->excel->getActiveSheet()->setCellValue('M' . $i, $data->last_name);
                $this->excel->getActiveSheet()->setCellValue('N' . $i, $data->mobile_no);

                /*                 * *********************************************************************** */
                $this->excel->getActiveSheet()->getStyle('O' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('P' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('Q' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('R' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('S' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('T' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('U' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('V' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('W' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->getStyle('X' . $i)->applyFromArray($miestilo_SEC3);
                //$this->excel->getActiveSheet()->getStyle('Y' . $i)->applyFromArray($miestilo_SEC3);
                //$this->excel->getActiveSheet()->getStyle('Z' . $i)->applyFromArray($miestilo_SEC3);
                $this->excel->getActiveSheet()->setCellValue('O' . $i, $data->user_id);
                $this->excel->getActiveSheet()->setCellValue('P' . $i, $data->email_id);
                $this->excel->getActiveSheet()->setCellValue('Q' . $i, $data->second_fname);
                $this->excel->getActiveSheet()->setCellValue('R' . $i, $data->second_lname);
                $this->excel->getActiveSheet()->setCellValue('S' . $i, $data->second_mobile);
                $this->excel->getActiveSheet()->setCellValue('T' . $i, $data->second_user_id);
                $this->excel->getActiveSheet()->setCellValue('U' . $i, $data->second_email_id);
                $this->excel->getActiveSheet()->setCellValue('V' . $i, rtrim($data->bidder_name, ','));
                $this->excel->getActiveSheet()->setCellValue('W' . $i, rtrim($data->bidder_email, ','));
                $this->excel->getActiveSheet()->setCellValue('X' . $i, rtrim($data->bidder_mobile, ','));
                $i++;
            }
        }
        
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(18);
		$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(18);

         
        $filename = 'Complete_mis_Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
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

}

?>
