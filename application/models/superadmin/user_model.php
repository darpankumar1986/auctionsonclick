<?php

class User_model extends CI_Model {

    private $path = 'public/uploads/';

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('superadmin/role_model');
    }

    /*     * ************ Start: Block User Code ******* */

    public function GetRecordsuserblock($start = 0, $limit = 10) {

        //search query start//
        $title = trim($this->input->post('title'));
        $status = $this->input->post('status1');
        $type = $this->input->post('type');
        if ($status != '')
            $this->db->where('status ', $status);
        if ($title != '')
            $this->db->where('(email_id like ' . "'%" . $title . "%'   OR first_name like " . "'%" . $title . "%') ");
        if ($type != '')
            $this->db->like('user_type', $type);
        //serach query ends//
        $this->db->where('status =', 9); // Blocked User
        $this->db->where('(user_type like ' . "'%owner%'   OR user_type like " . "'%broker%' OR user_type like " . "'%builder%') "); // Change
        //$this->db->where('user_type =', 'owner');  // Change
        //$this->db->where('user_type =', 'broker');  // Change
        //$this->db->where('user_type =', 'builder');  // Change
        $this->db->order_by('id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_user_registration");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetTotalRecorduserblock() {
        $this->db->select('count(*) as total');

        //search query start//
        $title = trim($this->input->post('title'));
        $status = $this->input->post('status1');
        $type = $this->input->post('type');
        if ($status != '')
            $this->db->where('status ', $status);
        if ($title != '')
            $this->db->where('(email_id like ' . "'%" . $title . "%'   OR first_name like " . "'%" . $title . "%') ");
        if ($type != '') {
            $this->db->like('user_type', $type);
        }
        //serach query ends//

        $this->db->where('status =', 9);  // Blocked User
        $this->db->where('(user_type like ' . "'%owner%'   OR user_type like " . "'%broker%' OR user_type like " . "'%builder%') "); // Change
        $query = $this->db->get("tbl_user_registration");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function fetchmodulesubcategory($parent_id, $selected) {
        $dataapp = '';
        $this->db->where('parent_id', $parent_id);
        $this->db->where('status', 1);
        $query = $this->db->get("tbl_show_module");
        if ($query->num_rows() > 0) {
            $dataapp.='';
            foreach ($query->result() as $resultdata) {
                if ($selected != null && $selected != '' && $selected == $resultdata->category_value) {
                    $dataapp.='<option value="' . $resultdata->category_value . '" selected="selected">' . $resultdata->category_name . '</option>';
                } else {
                    $dataapp.='<option value="' . $resultdata->category_value . '">' . $resultdata->category_name . '</option>';
                }
            }
            
            if($parent_id == 5)
            {
				if ($selected != null && $selected != '' && $selected == 'InvalidBid Submission') {
					$dataapp.='<option value="InvalidBid Submission" selected="selected">InvalidBid Submission</option>';
				}
				else
				{
					$dataapp.='<option value="InvalidBid Submission">InvalidBid Submission</option>';
				}
			}
        }
        return $dataapp;
    }

    public function GetTotalRecordbankblock() {
        $this->db->select('count(*) as total');

        //search query start//
        $title = trim($this->input->post('title'));
        $status = $this->input->post('status1');
        $type = $this->input->post('type');
        if ($status != '')
            $this->db->where('status ', $status);
        if ($title != '')
            $this->db->where('(email_id like ' . "'%" . $title . "%'   OR first_name like " . "'%" . $title . "%') ");
        if ($type != '')
            $this->db->like('user_type', $type);
        //serach query ends//

        $this->db->where('status =', 9);
        $query = $this->db->get("tbl_user");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    /*
     * 
     * //user log start
     * 
     * 
     * 
     * */

    public function GetUserTotalogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($_GET['email_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(login_datetime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }        
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $query = $this->db->get("tbl_user_log");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    //corriggendum start
 
 public function GetUserTotalcorrigndomlogs() {
        /*$from_date = trim($this->input->post('from_date'));
        $to_date = trim($this->input->post('to_date'));
        $auctionId = trim($this->input->post('auctionId'));
        $eventId = trim($this->input->post('eventId'));
        $createdby = trim($this->input->post('createdby'));
        $activity_done = trim($this->input->post('Change_status'));
         * *
         */
       $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auctionId = trim($_GET['auction_id']);        
        $this->db->select('count(*) as total');
        $this->db->from('tbl_log_auction_corrigendum AS A');
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionId != '') {
            $this->db->where("A.auctionID", $auctionId);
        }                
        if ($createdby != '') {
            $this->db->where("A.created_by", $createdby);
        }
        $this->db->join('tbl_user as D', 'D.id=A.created_by', 'left');       
        $this->db->order_by('A.id DESC');
       // $this->db->limit($limit, $start);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
        return false;
    }

    
    
    
    
    public function GetRecordsUserlogs($start = 0, $limit = 10) {

        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($_GET['email_id']);
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(login_datetime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $this->db->order_by('id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_user_log");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordscorrigndomUserlogs($start = 0, $limit = 10) {
      /*  $from_date = trim($this->input->post('from_date'));
        $to_date = trim($this->input->post('to_date'));
        $auctionId = trim($this->input->post('auctionId'));
        $eventId = trim($this->input->post('eventId'));
        $createdby = trim($this->input->post('createdby'));
        $activity_done = trim($this->input->post('Change_status'));
        */
        
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auctionId = trim($_GET['auction_id']);        

        $this->db->select('A.*,D.user_type as usercategory,D.email_id');
        $this->db->from('tbl_log_auction_corrigendum AS A');
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionId != '') {
            $this->db->where("A.auctionID", $auctionId);
        }
        $this->db->join('tbl_user as D', 'D.id=A.created_by', 'left');        
        
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function checkActivitycorrigndum($id) {
        $query = $this->db->get('tbl_log_auction_corrigendum');
        if ($query->num_rows() > 0) {
            $result = $query->result();
            if ($result[0]->old_NIT_date) {
                
            }
        }
    }

    public function completeMISLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($_GET['email_id']); 
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(login_datetime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }              
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $this->db->order_by('id DESC');
        $query = $this->db->get("tbl_user_log");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     

    /*     * *
     * //user log end
     * 
     */

    public function completeMISCorrigondomLogData() {
       
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auctionId = trim($_GET['auction_id']);
       
        
       $this->db->select('A.*,D.user_type as usercategory,D.email_id');
        $this->db->from('tbl_log_auction_corrigendum AS A');
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionId != '') {
            $this->db->where("A.auctionID", $auctionId);
        }        
        $this->db->join('tbl_user as D', 'D.id=A.created_by', 'left');        
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //corriggendum end
    //live auction log start
   //live auction log start
    public function GetUserTotalcorrigndomlogs_liveauction() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auctionId = trim($this->input->get('auctionId'));
        $eventId = trim($this->input->get('eventId'));
        $createdby = trim($this->input->get('createdby'));
        $activity_done = trim($this->input->get('Change_status'));
        $this->db->select('count(*) as total');
        if ($activity_done != '') {
            //Live Auction Agreement
            if ($activity_done == 'LiveAuction agreement') {
                $this->db->select('A.id,A.auctionID,A.is_accept_tc_date as indate,C.name as bankname,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.is_accept_tc_ip as ip_address,A.is_accept_tc_message as activity_done');
                $this->db->from('tbl_log_auction_participate AS A');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->where("A.is_accept_tc", 1);
            }
            //AutoCutoff Bid Submission
            if ($activity_done == 'AutoCutoff Bid Submission') {
                $this->db->from('tbl_live_auction_bid AS A');
                $this->db->where("E.auto_bid_cut_off", 1);
            }
            //NormalBid Submission
            if ($activity_done == 'NormalBid Submission') {
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->from('tbl_live_auction_bid AS A');
            }
              //InvalidBid Submission
            if ($activity_done == 'InvalidBid Submission') {
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->from('tbl_live_auction_bid_invalid AS A');
            }
   
            //Pause Auction
            if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
                $this->db->from('tbl_log_auction_pause_resume AS A');
                if ($activity_done == 'ResumeAuction') {
                    $this->db->where("A.status", 0);
                }
                if ($activity_done == 'Pause Auction') {
                    $this->db->where("A.status", 1);
                }
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
            }
        } else {
                $this->db->select('A.id,A.auctionID,A.is_accept_tc_date as indate,C.name as bankname,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.is_accept_tc_ip as ip_address,A.is_accept_tc_message as activity_done');
                $this->db->from('tbl_log_auction_participate AS A');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->where("A.is_accept_tc", 1);
        }
        if ($auctionId != '') {
            $this->db->where("A.auctionID", $auctionId);
        }
        if ($eventId != '') {
            $this->db->where("E.eventID", $eventId);
        }
        if ($createdby != '') {
            if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
                $this->db->where("A.userID", $createdby);
            } else {
                $this->db->where("A.bidderID", $createdby);
            }
        }
        //check when banker has paused auction /resume auction
        if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
            $this->db->join('tbl_user as D', 'D.id=A.userID', 'left');
        } else {
            $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        }
        $this->db->join('tbl_auction as E', 'E.id=A.auctionID', 'left');
        $this->db->join('tbl_bank as C', 'C.id=E.bank_id', 'left');
        $this->db->order_by('A.id DESC');

        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        //echo $query->num_rows();die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }

    public function completeMISCorrigondomLogData_liveauction() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auctionId = trim($this->input->get('auctionId'));
        $eventId = trim($this->input->get('eventId'));
        $createdby = trim($this->input->get('createdby'));
        $activity_done = trim($this->input->get('Change_status'));
       // if ($activity_done != '') {
            //Live Auction Agreement
            if ($activity_done == 'LiveAuction agreement'||$activity_done == '') {
                $this->db->select('A.id,A.auctionID,A.is_accept_tc_date as indate,C.name as bankname,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.is_accept_tc_ip as ip_address,A.is_accept_tc_message as activity_done,D.email_id');
                $this->db->from('tbl_log_auction_participate AS A');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->where("A.is_accept_tc", 1);
            }
            //AutoCutoff Bid Submission
            if ($activity_done == 'AutoCutoff Bid Submission') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.ip as ip_address,A.message as activity_done,D.email_id');
                $this->db->from('tbl_live_auction_bid AS A');
                $this->db->where("E.auto_bid_cut_off", 1);
            }
            //NormalBid Submission
            if ($activity_done == 'NormalBid Submission') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.ip as ip_address,A.message as activity_done,D.email_id');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->from('tbl_live_auction_bid AS A');
            }
             //InvalidBid Submission
            if ($activity_done == 'InvalidBid Submission') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.ip as ip_address,A.message as activity_done,D.email_id');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->from('tbl_live_auction_bid_invalid AS A');
            }
            //Pause Auction
            if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate as indate,E.eventID as eventID,D.user_type as usercategory,A.userID as bidderID ,A.ip as ip_address,A.message as activity_done,D.email_id');
                $this->db->from('tbl_log_auction_pause_resume AS A');
                if ($activity_done == 'ResumeAuction') {
                    $this->db->where("A.status", 0);
                }
                if ($activity_done == 'Pause Auction') {
                    $this->db->where("A.status", 1);
                }
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
            }
        //}
        /*else {
                $this->db->select('A.id,A.auctionID,A.is_accept_tc_date as indate,C.name as bankname,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.is_accept_tc_ip as ip_address,A.is_accept_tc_message as activity_done');
                $this->db->from('tbl_log_auction_participate AS A');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->where("A.is_accept_tc", 1);
           
               }
         * */
        if ($auctionId != '') {
            $this->db->where("A.auctionID", $auctionId);
        }
        if ($eventId != '') {
            $this->db->where("E.eventID", $eventId);
        }
        if ($createdby != '') {
            if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
                $this->db->where("A.userID", $createdby);
            } else {
                $this->db->where("A.bidderID", $createdby);
            }
        }

        //check when banker has paused auction /resume auction
        if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
            $this->db->join('tbl_user as D', 'D.id=A.userID', 'left');
        } else {
            $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        }
        $this->db->join('tbl_auction as E', 'E.id=A.auctionID', 'left');
        $this->db->join('tbl_bank as C', 'C.id=E.bank_id', 'left');
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordscorrigndomUserlogs_liveauction($start = 0, $limit = 10) {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auctionId = trim($this->input->get('auctionId'));
        $eventId = trim($this->input->get('eventId'));
        $createdby = trim($this->input->get('createdby'));
        $activity_done = trim($this->input->get('Change_status'));
        if ($activity_done != '') {
            //Live Auction Agreement
            if ($activity_done == 'LiveAuction agreement') {
                $this->db->select('A.id,A.auctionID,A.is_accept_auct_training_date as indate,C.name as bankname,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.is_accept_auct_training_ip as ip_address,A.is_accept_tc_message as activity_done,D.email_id');
                $this->db->from('tbl_log_auction_participate AS A');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.is_accept_auct_training_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->where("A.is_accept_auct_training", 1);
            }
            //AutoCutoff Bid Submission
            if ($activity_done == 'AutoCutoff Bid Submission') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.ip as ip_address,A.message as activity_done,D.email_id');
                $this->db->from('tbl_live_auction_bid AS A');
                $this->db->where("E.auto_bid_cut_off", 1);
            }
            //NormalBid Submission
            if ($activity_done == 'NormalBid Submission') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate,E.eventID as eventID,D.user_type as usercategory,D.email_id,A.ip as ip_address,A.message as activity_done');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                //$this->db->join('tbl_user_registration as D1', 'D1.id=A.bidderID', 'left');
                $this->db->from('tbl_live_auction_bid AS A');
                
            }
            //InvalidBid Submission
            if ($activity_done == 'InvalidBid Submission') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.ip as ip_address,A.message as activity_done,D.email_id');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->from('tbl_live_auction_bid_invalid AS A');
            }
            //Pause Auction
            if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
                $this->db->select('A.id,A.auctionID,A.bid_type,C.name as bankname,A.indate as indate,E.eventID as eventID,D.user_type as usercategory,A.userID as bidderID ,A.ip as ip_address,A.message as activity_done,D.email_id');
                $this->db->from('tbl_log_auction_pause_resume AS A');
                if ($activity_done == 'ResumeAuction') {
                    $this->db->where("A.status", 0);
                }
                if ($activity_done == 'Pause Auction') {
                    $this->db->where("A.status", 1);
                }
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
            }
        } else {
               
                $this->db->select('A.id,A.auctionID,A.is_accept_tc_date as indate,C.name as bankname,E.eventID as eventID,D.user_type as usercategory,A.bidderID,A.is_accept_tc_ip as ip_address,A.is_accept_tc_message as activity_done');
                $this->db->from('tbl_log_auction_participate AS A');
                if ($from_date != '' && $to_date != '') {
                    $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
                }
                $this->db->where("A.is_accept_tc", 1);
           
        }
        if ($auctionId != '') {
            $this->db->where("A.auctionID", $auctionId);
        }
        if ($eventId != '') {
            $this->db->where("E.eventID", $eventId);
        }
        if ($createdby != '') {
            if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
                $this->db->where("A.userID", $createdby);
            } else {
                $this->db->where("A.bidderID", $createdby);
            }
        }
        //check when banker has paused auction /resume auction
        if ($activity_done == 'Pause Auction' || $activity_done == 'ResumeAuction') {
            $this->db->join('tbl_user as D', 'D.id=A.userID', 'left');
        } else {
            $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        }
        $this->db->join('tbl_auction as E', 'E.id=A.auctionID', 'left');
        $this->db->join('tbl_bank as C', 'C.id=E.bank_id', 'left');
        $this->db->order_by('A.id DESC');
        //echo $this->db->last_query();die;
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //live auction log end
 
    //live auction log end
    public function GetRecordsbankblock($start = 0, $limit = 10) {

        //search query start//
        $title = trim($this->input->post('title'));
        $status = $this->input->post('status1');
        $type = $this->input->post('type');
        if ($status != '')
            $this->db->where('status ', $status);
        if ($title != '')
            $this->db->where('(email_id like ' . "'%" . $title . "%'   OR first_name like " . "'%" . $title . "%') ");
        if ($type != '')
            $this->db->like('user_type', $type);
        //serach query ends//
        $this->db->where('status =', 9);
        $this->db->order_by('id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_user");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function save_data_banker_block() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->from('tbl_user');
        $query = $this->db->get();
        $row = $query->result();
        $numRow = $query->num_rows();
        if ($numRow > 0) {
            $email = trim($row[0]->email_id);
        }


        $comment = $this->input->post('comment');
        $status = $this->input->post('status');

        if ($id) {

            $this->db->where('id', $id);
            $data = array(
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user', $data);

            $query = $this->db->query("DELETE FROM tbl_user_block WHERE user_type = 'banker' AND email_id = '" . $email . "'", false);

            /* $email_msg ="<p><b>Dear ".$name."</b>, <br/> <br/>
              ".$comment."</p><br/>
              <br/>
              <br/>
              <p>Regards,<br/>
              C1 India Pvt. Ltd.<br/>
              C-104, Sector-2, Noida-201301<br/>
              www.c1india.com<br/>
              Tel: +91-120-4746800<br/>
              Tel: +91-120-4888887<br/>
              <br/></p>";
              $this->load->library('email');
              $this->email->set_mailtype("html");
              $this->email->from('info@c1indiabankeauction.com', 'C1india');
              $this->email->to($email);
              //$this->email->to('sunil.singh@afaqs.com');
              $this->email->subject("Bankeauction: Account Activation Mail");
              $this->email->message($email_msg);
              //$this->email->attach($path);
              //$this->email->print_debugger();

              if($this->email->send())
              {
              return 1;
              }else {
              return 0;
              } */
        }
        return true;
    }

    public function save_data_user_block() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->from('tbl_user_registration');
        $query = $this->db->get();
        $row = $query->result();
        $numRow = $query->num_rows();
        if ($numRow > 0) {
            $email = trim($row[0]->email_id);
        }


        $comment = $this->input->post('comment');
        $status = $this->input->post('status');

        if ($id) {

            $this->db->where('id', $id);
            $data = array(
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user_registration', $data);


            if ($status == '1') {
                $query = $this->db->query("DELETE FROM tbl_user_block WHERE user_type = 'bidder' AND email_id = '" . $email . "'", false);
            }
            /* $email_msg ="<p><b>Dear ".$name."</b>, <br/> <br/>
              ".$comment."</p><br/>
              <br/>
              <br/>
              <p>Regards,<br/>
              Jaipur Development Authority<br/>
              C-104, Sector-2, Noida-201301<br/>
              www.c1india.com<br/>
              Tel: +91-120-4746800<br/>
              Tel: +91-120-4888887<br/>
              <br/></p>";
              $this->load->library('email');
              $this->email->set_mailtype("html");
              $this->email->from('info@c1indiabankeauction.com', 'C1india');
              $this->email->to($email);
              //$this->email->to('sunil.singh@afaqs.com');
              $this->email->subject("Bankeauction: Account Activation Mail");
              $this->email->message($email_msg);
              //$this->email->attach($path);
              //$this->email->print_debugger();

              if($this->email->send())
              {
              return 1;
              }else {
              return 0;
              } */
        }
        return true;
    }

    /*     * ************ End: Block User Code ******* */

    public function GetTotalRecord() {
        //$this->db->select('count(*) as total');

        //search query start//
        $title 	= str_replace("'","",trim($this->input->get('departments')));
         
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.first_name", "u.id" , "u.designation", "u.user_id", "tb.name", "branch.name","u.user_type");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_user as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id LEFT JOIN tbl_branch as branch ON branch.id = u.user_type_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND (u.user_type = 'branch' OR u.user_type = 'viewer') ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }
    
    public function GetTotalRecordViewer() {
        //$this->db->select('count(*) as total');

        //search query start//
        $title 	= str_replace("'","",trim($this->input->get('title')));
        $status = $this->input->get('status1');
        $type = $this->input->get('type');

        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.first_name", "u.id" , "u.designation", "u.user_id", "tb.name", "branch.name","u.user_type");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_user as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id LEFT JOIN tbl_branch as branch ON branch.id = u.user_type_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND (u.user_type = 'viewer') ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);
        
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function GetTotalRecordadmin() {
        //$this->db->select('count(*) as total');

        //search query start//
        $title = str_replace("'","",trim($this->input->get('title')));
        
       /* $this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.email_id like ' . "'%" . $title . "%'   OR u.last_name like " . "'%" . $title . "%' OR u.first_name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.user_id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%' OR u.designation like " . "'%" . $title . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
        $query = $this->db->get("tbl_bank_admin as u");*/
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.last_name", "u.first_name", "u.id", "u.user_id", "u.designation" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_bank_admin as u WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5  ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);
        

        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function GetRecords($start = 0, $limit = 10) {

        //search query start//
        $title 	= str_replace("'","",trim($this->input->get('title')));
        $status = $this->input->get('status1');
        $type = $this->input->get('type');
		
		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.first_name", "u.id" , "u.designation", "u.user_id", "tb.name", "branch.name","u.user_type");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
			$query = "SELECT u.* FROM tbl_user as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND (u.user_type = 'buyer')";
		$query .= "ORDER BY u.id DESC ";
		$query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		//echo $this->db->last_query();die;
		
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->bank_name = $this->getbankName($row->bank_id);
                $row->branch_name = $this->getbranchName($row->user_type_id);
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }
    
     public function GetRecordsViewer($start = 0, $limit = 10) {

        //search query start//
        $title 	= str_replace("'","",trim($this->input->get('title')));
        $status = $this->input->get('status1');
        $type = $this->input->get('type');
		
		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.first_name", "u.id" , "u.designation", "u.user_id", "tb.name", "branch.name","u.user_type");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_user as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id LEFT JOIN tbl_branch as branch ON branch.id = u.user_type_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND (u.user_type = 'viewer')";
		$query .= "ORDER BY u.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		
		
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->bank_name = $this->getbankName($row->bank_id);
                $row->branch_name = $this->getbranchName($row->user_type_id);
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }

    public function getbankName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_bank');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
			$rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }

    public function getzoneName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_zone');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }

    public function getbranchName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_branch');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           $rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }

    public function GetRecordsadmin($start = 0, $limit = 10) {

        //search query start//
        $title = str_replace("'","",trim($this->input->get('title')));
        
        
        
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.email_id like ' . "'%" . $title . "%'   OR u.last_name like " . "'%" . $title . "%' OR u.first_name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.user_id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%' OR u.designation like " . "'%" . $title . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit, $start);
        $query = $this->db->get("tbl_bank_admin as u");*/

		
		
		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.last_name", "u.first_name", "u.id", "u.user_id", "u.designation" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_bank_admin as u WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5  ";
		$query .= "ORDER BY u.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		

        //serach query ends//

        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }

    public function GetTotalRecord1() {
       // $this->db->select('count(*) as total');

        //search query start//
        $title = trim($this->input->post('title'));
        



		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.first_name like " . "'%" . $title . "%' OR u.last_name like " . "'%" . $title . "%' OR u.email_id like " . "'%" . $title . "%' OR c1.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}

		$this->db->where('u.status != ', 5);
		$this->db->where('u.user_type =', 'sales');
		$this->db->join('tbl_c1zone as c1','c1.id = u.c1zone_id','left');
        $query = $this->db->get("tbl_user_registration as u");*/
        
        	
		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.first_name", "u.last_name", "u.email_id" , "c1.name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_user_registration as u LEFT JOIN tbl_c1zone as c1 ON c1.id = u.c1zone_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND u.user_type ='sales' ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);


        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function GetTotalRecord1help() {

        //$this->db->select('count(*) as total');

        //search query start//
        $title 	= str_replace("'","",trim($this->input->get('title')));


       /* $this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.first_name like " . "'%" . $title . "%' OR u.last_name like " . "'%" . $title . "%' OR u.email_id like " . "'%" . $title . "%' OR u.user_type like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}

		$this->db->where('u.status != ', 5);
		$this->db->where('(u.user_type like ' . "'%helpdesk_admin%'   OR u.user_type like " . "'%helpdesk_ex%') ");
        $query = $this->db->get("tbl_user_registration as u");*/
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.first_name", "u.last_name", "u.email_id", "u.user_type" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_user_registration as u WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND (u.user_type like '%helpdesk_admin%'   OR u.user_type like '%helpdesk_ex%') ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);


        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function getc1zoneName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_c1zone');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           $rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }

    public function GetRecords1($start = 0, $limit = 10) {

        //search query start//
        $title 	= str_replace("'","",trim($this->input->get('title')));
        
        

		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.first_name like " . "'%" . $title . "%' OR u.last_name like " . "'%" . $title . "%' OR u.email_id like " . "'%" . $title . "%' OR c1.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}

		$this->db->where('u.status != ', 5);
		$this->db->where('u.user_type =', 'sales');
		$this->db->join('tbl_c1zone as c1','c1.id = u.c1zone_id','left');
		
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_user_registration as u");	*/
        
        
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.first_name", "u.last_name", "u.email_id" , "c1.name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_user_registration as u LEFT JOIN tbl_c1zone as c1 ON c1.id = u.c1zone_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND u.user_type ='sales' ";
		$query .= "ORDER BY u.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		
		


        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->c1_zone_name = $this->getc1zoneName($row->c1zone_id);
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecords1help($start = 0, $limit = 10) 
    {

		$title 	= str_replace("'","",trim($this->input->get('title')));

		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.first_name like " . "'%" . $title . "%' OR u.last_name like " . "'%" . $title . "%' OR u.email_id like " . "'%" . $title . "%' OR u.user_type like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}

		$this->db->where('u.status != ', 5);
		$this->db->where('(u.user_type like ' . "'%helpdesk_admin%'   OR u.user_type like " . "'%helpdesk_ex%') ");
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
        $query = $this->db->get("tbl_user_registration as u");*/
        
        
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.first_name", "u.last_name", "u.email_id", "u.user_type" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_user_registration as u WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5 AND (u.user_type like '%helpdesk_admin%'   OR u.user_type like '%helpdesk_ex%') ";
		$query .= "ORDER BY u.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
        


        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordById($id, $type = 'banker') {
        $this->db->where('id', $id);
        if ($type == 'banker')
            $query = $this->db->get("tbl_user");
        else
            $query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordByIdbankadmin($id) {
        $this->db->where('id', $id);

        $query = $this->db->get("tbl_bank_admin");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordByIdhelp($id, $type = '') {


        $this->db->where('id', $id);
        if ($type == 'banker') {
            $query = $this->db->get("tbl_user");
        } else {
            $query = $this->db->get("tbl_user_registration");
        }


        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function save_data($image = null) {
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $designation = $this->input->post('designation');
        $mobile_no = $this->input->post('mobile_no');
        $email_id = $this->input->post('email_id');
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        $user_type_id = $this->input->post($user_type . '_user_type_id');
        $c1zone_id = $this->input->post('c1zone_user_type_id');
        if ($c1zone_id)
            $c1zone = GetTitleById('tbl_c1zone', $c1zone_id);
        $role = $this->input->post('role');
        $indate = $this->input->post('indate');
        $status = $this->input->post('status');
        $password = $this->input->post('password');
        if ($id) {
            $this->db->where('id', $id);
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                //'password'=>$password ,
                'c1zone_id' => $c1zone_id,
                'c1zone' => $c1zone,
                'email_id' => $email_id,
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'verify_status' => 1,
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user_registration', $data);
        } else {
            $data['indate'] = date('Y-m-d H:i:s');
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                'password' => hash("sha256", $password),
                'c1zone_id' => $c1zone_id,
                'c1zone' => $c1zone,
                'email_id' => $email_id,
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'verify_status' => 1,
                'indate' => date('Y-m-d H:i:s'),
                'status' => $status
            );
            
            $this->db->insert('tbl_user_registration', $data);
            $insert_id=  mysql_insert_id();
            $userlog=array(
                'actiontype'=>'create_se_user',
                'email_id'=>$email_id,
                'user_id'=>$insert_id,
                'ip_address'=>$_SERVER['REMOTE_ADDR'],
                'user_type'=>$user_type,
                'indate'=> date('Y-m-d H:i:s'),
                'status'=>'1',
                'message'=>'SE User Registered Successfully'
               ); 
         $this->db->insert('tbl_log_user_registration',$userlog); 
        }
        return true;
    }

    public function save_datahelp($image = null) {
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $designation = $this->input->post('designation');
        $mobile_no = $this->input->post('mobile_no');
        $email_id = $this->input->post('email_id');
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        $user_type_id = $this->input->post($user_type . '_user_type_id');
        $c1zone_id = $this->input->post('c1zone_user_type_id');
        if ($c1zone_id)
            $c1zone = GetTitleById('tbl_c1zone', $c1zone_id);
        $role = $this->input->post('role');
        $indate = $this->input->post('indate');
        $status = $this->input->post('status');
        $password = $this->input->post('password');
        if ($id) {
            $this->db->where('id', $id);
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                //'password'=>$password ,
                'c1zone_id' => $c1zone_id,
                'c1zone' => $c1zone,
                //'email_id'=>$email_id,		
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'verify_status' => 1,
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user_registration', $data);
        } else {
            $data['indate'] = date('Y-m-d H:i:s');
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                'password' => hash("sha256", $password),
                'c1zone_id' => $c1zone_id,
                'c1zone' => $c1zone,
                'email_id' => $email_id,
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'verify_status' => 1,
                'indate' => date('Y-m-d H:i:s'),
                'status' => $status
                );
            $this->db->insert('tbl_user_registration', $data);
            $insert_id=  mysql_insert_id();
            if($user_type=='helpdesk_ex'){
                   $actiontype='create_he_user'; 
                   $message='Help Desk Executive Registered Successfully';
                }else{
                   $actiontype='create_ha_user';   
                   $message='Help Desk Admin Registered Successfully';
                }
             $userlog=array(
                'actiontype'=>$actiontype,
                'email_id'=>$email_id,
                'user_id'=>$insert_id,
                'ip_address'=>$_SERVER['REMOTE_ADDR'],
                'user_type'=>$user_type,
                'indate'=>date('Y-m-d H:i:s'),
                'status'=>'1',
                'message'=>$message
                ); 
            $this->db->insert('tbl_log_user_registration',$userlog);
            
            
            
            
        }
        return true;
    }

    public function save_data_banker($doc = null) {
		$id = $this->input->post('id');
		$user_type = $this->input->post('user_type');
		$branch_zone = $this->input->post('branch_zone');
		$email_id = $this->input->post('email_id');
		$user_id = $this->input->post('user_id');
		$bank_id = $this->input->post('bank_id');
		$password = $this->input->post('password');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$designation = $this->input->post('designation');
		$mobile_no = $this->input->post('mobile_no');
		$status = $this->input->post('status');
		
		 $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email_id' => $email_id,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                'bank_id' => $bank_id,
                'zone_id' => $branch_zone,
                'user_type' => $user_type,
                'status' => $status                
            );
       
       if($id) {
		   $data['date_modified'] = date('Y-m-d H:i:s');
		   $this->db->where('id', $id);
           $this->db->update('tbl_user', $data);
           
        } else {
			$data['indate'] = date('Y-m-d H:i:s');
			$data['password'] = hash("sha256", $password);
			
			$this->db->insert('tbl_user', $data);
			
            $insertedID = $this->db->insert_id();
            if ($insertedID) 
            {

                $id = $insertedID;
                $bankName = GetTitleByField('tbl_bank', "id='" . $bank_id . "'", 'shortName');
                $bankName = str_replace(' ', '', $bankName);
                if ($user_type == 'branch') {
                    $userid = strtoupper($bankName) . '_branch' . $id;
                } else if ($user_type == 'region') {

                    $userid = strtoupper($bankName) . '_region' . $id;
                } else if ($user_type == 'zone') {
                    $userid = strtoupper($bankName) . '_zone' . $id;
                } else if ($user_type == 'drt') {
                    $userid = 'drt_' . $id;
                }
                if($user_type=='helpdesk_ex'){
                   $actiontype='create_he_user'; 
                   $message='Help Desk E Registered Successfully';
                }else{
                   $actiontype='create_branch_user';   
                   $message='Branch User Registered Successfully';
                }
                $userlog=array(
                   // 'actiontype'=>$actiontype,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'email_id'=>$email_id,
                    'designation' => $designation,
                    'mobile_no' => $mobile_no,
                    'user_id'=>$id,
                    'ip_address'=>$_SERVER['REMOTE_ADDR'],
                    'user_type'=>$user_type,
                    'indate'=>date('Y-m-d H:i:s'),
                    'status'=>'1',
                    'remark'=>'Branch User Registrated Successfully'
                     ); 
                $this->db->insert('tbl_log_user_registration',$userlog); 
                
                //$this->load->library('Email_new');		
				//$email_new = new Email_new();
				//$email_new->sendMailToUserCreatedBYAdmin($email_id,$password);
            }
        }
        return true;
    }
    
    
    public function save_data_banker_viewer($doc = null) 
    {
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $designation = $this->input->post('designation');
        $mobile_no = $this->input->post('mobile_no');
        $email_id = $this->input->post('email_id');
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        $user_type_id = $this->input->post($user_type . '_user_type_id');
        $bank_id = $this->input->post($user_type . '_bank');
        //$zone_id = $this->input->post($user_type . '_zone');
        $zone_id = '';
        $c1zone_id = $this->input->post('c1zone_user_type_id');
        if ($c1zone_id)
            $c1zone = GetTitleById('tbl_c1zone', $c1zone_id);
        $region_id = $this->input->post($user_type . '_region');
        $lho_id = $this->input->post($user_type . '_lho');
        $role = $this->input->post('role');
        $indate = $this->input->post('indate');
        $status = $this->input->post('status');
        $password = $this->input->post('password');
		
		if($role == '1')
		{
			$user_type1 = 'branch';
		}else{
			$user_type1 = 'viewer';
		}
        if ($id) {
            $this->db->where('id', $id);
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                //'password'=>$password ,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'user_type' => $user_type1,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user', $data);
        } else {
            $data['indate'] = date('Y-m-d H:i:s');
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'password' => hash("sha256", $password),
                'user_type' => $user_type1,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'indate' => date('Y-m-d H:i:s'),
                'status' => $status
            );
            $this->db->insert('tbl_user', $data);
            $insertedID = $this->db->insert_id();
            if ($insertedID) 
            {

                $id = $insertedID;
                $bankName = GetTitleByField('tbl_bank', "id='" . $bank_id . "'", 'shortName');
                $bankName = str_replace(' ', '', $bankName);
                if ($user_type == 'branch') {
                    $userid = strtoupper($bankName) . '_branch' . $id;
                } else if ($user_type == 'region') {

                    $userid = strtoupper($bankName) . '_region' . $id;
                } else if ($user_type == 'zone') {
                    $userid = strtoupper($bankName) . '_zone' . $id;
                } else if ($user_type == 'drt') {
                    $userid = 'drt_' . $id;
                }

                if($user_type=='helpdesk_ex'){
                   $actiontype='create_he_user'; 
                   $message='Help Desk E Registered Successfully';
                }else{
                   $actiontype='create_branch_user';   
                   $message='Branch User Registered Successfully';
                }
                $userlog=array(
                    'actiontype'=>$actiontype,
                    'email_id'=>$email_id,
                    'user_id'=>$id,
                    'ip_address'=>$_SERVER['REMOTE_ADDR'],
                    'user_type'=>$user_type,
                    'indate'=>date('Y-m-d H:i:s'),
                    'status'=>'1',
                    'message'=>$message
                     ); 
                $this->db->insert('tbl_log_user_registration',$userlog); 
                
                //$this->load->library('Email_new');		
				//$email_new = new Email_new();
				//$email_new->sendMailToUserCreatedBYAdmin($email_id,$password);
            }
        }
        return true;
    }

    public function save_data_bankeradmin($doc = null) {

        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $designation = $this->input->post('designation');
        $mobile_no = $this->input->post('mobile_no');
        $email_id = $this->input->post('email_id');
        $user_id = $this->input->post('user_id');
        $bank_id = $this->input->post('branch_bank');
        //$role = $this->input->post('role');
        $indate = $this->input->post('indate');
        $status = $this->input->post('status');
        $password = $this->input->post('password');

        if ($id) {
            $this->db->where('id', $id);
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                //'password'=>$password ,
                'bank_id' => $bank_id,
                'email_id' => $email_id,
                //'role'=>$role,
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_bank_admin', $data);
        } else {
            $data['indate'] = date('Y-m-d H:i:s');
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                'bank_id' => $bank_id,
                'email_id' => $email_id,
                'pwd' => hash("sha256", $password),
                //'role'=>$role,
                'indate' => date('Y-m-d H:i:s'),
                'status' => $status
            );
            $this->db->insert('tbl_bank_admin', $data);
            $insertedID = $this->db->insert_id();
            if ($insertedID) {
                $id = $insertedID;
                $bankName = GetTitleByField('tbl_bank', "id='" . $bank_id . "'", 'shortName');
                $bankName = str_replace(' ', '', $bankName);

                $userid = strtoupper($bankName) . '_admin' . $id;


                //$this->db->where('id', $id);
                //$udata = array('user_id' => $userid);
                //$this->db->update('tbl_bank_admin', $udata);
            }
        }
        return true;
    }
	
	
	public function uniquecheckDuplicateEmailDRT($email_id, $id) {
			if($id > 0){
				$this->db->where('id !=', $id);
			}
			$this->db->where('email_id', $email_id);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_user");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
    }
    
    
    public function checkDuplicateEmail($data) {
        $email = $data['email'];
        $this->db->from('tbl_user_registration');
        if (!empty($data['id'])) {
            $this->db->where('id !=', $data['id']);
        }
        $this->db->where('email_id', $email);
        $this->db->where('status !=', 5);
        $query = $this->db->get()->num_rows();
        return $query;
    }
    
    public function checkDuplicateEmailDRT($data) {
        $email = $data['email'];
        $this->db->from('tbl_user');
        if (!empty($data['id'])) {
            $this->db->where('id !=', $data['id']);
        }
        $this->db->where('email_id', $email);
        $this->db->where('status !=', 5);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    public function checkDuplicateEmailhelp($data) {
        $email = $data['email'];
        $this->db->from('tbl_user_registration');
        if (!empty($data['id'])) {
            $this->db->where('id !=', $data['id']);
        }
        $this->db->where('email_id', $email);
        $this->db->where('status !=', 5);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    public function checkDuplicateEmail_bank($email) {
        $this->db->from('tbl_user');
        $this->db->where('email_id', $email['email']);
        //$this->db->where('status !=', 5);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    
    public function checkduplicateuseridexist($email) {
        $this->db->from('tbl_user');
        $this->db->where('user_id', $email['user_id']);
        //$this->db->where('status !=', 5);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    
    public function checkduplicateuseridexistadmin($email) {
        $this->db->from('tbl_bank_admin');
        $this->db->where('user_id', $email['user_id']);
        //$this->db->where('status !=', 5);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function upload1($fieldname) {
        $config['upload_path'] = $this->path;
        $config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
        $config['max_size'] = '5120';
        $config['remove_spaces'] = true;
        $config['overwrite'] = false;
        $config['encrypt_name'] = true;
        $config['max_width'] = '';
        $config['max_height'] = '';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($fieldname)) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }
    }

    public function GetRecordByIdregion($id, $type = 'banker') {
        $this->db->where('id', $id);
        if ($type == 'banker')
            $query = $this->db->get("tbl_user");
        else
            $query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordByIdzone($id, $type = 'banker') {
        $this->db->where('id', $id);
        if ($type == 'banker')
            $query = $this->db->get("tbl_user");
        else
            $query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordByIddrt($id, $type = 'banker') {
        $this->db->where('id', $id);
        if ($type == 'banker')
            $query = $this->db->get("tbl_user");
        else
            $query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetTotalRecordregion() {
        $this->db->select('count(*) as total');

        //search query start//
        $title = str_replace("'","",trim($this->input->get('title')));

       $this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.email_id like ' . "'%" . $title . "%'   OR u.last_name like " . "'%" . $title . "%' OR u.first_name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.designation like " . "'%" . $title . "%' OR u.user_id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%' OR tb.name like " . "'%" . $title . "%' OR region.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
        $this->db->where('u.user_type =', 'region');  // Change
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_region as region','region.id = u.user_type_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.zone_id','left');
		$this->db->order_by('u.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_user as u");
        
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function GetTotalRecordzone() {
        $this->db->select('count(*) as total');

        //search query start//
        $title = str_replace("'","",trim($this->input->get('title')));
		$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.email_id like ' . "'%" . $title . "%'   OR u.last_name like " . "'%" . $title . "%' OR u.first_name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.user_id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%' OR tb.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
        $this->db->where('u.user_type =', 'zone');  // Change
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.user_type_id','left');
        $query = $this->db->get("tbl_user as u");


        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function GetTotalRecorddrt() {
     
		$title = str_replace("'","",trim($this->input->get('title')));
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.last_name", "u.first_name", "u.id", "tb.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_user as u LEFT JOIN tbl_drt as tb ON tb.id = u.user_type_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5  AND u.user_type = 'drt' ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);


        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function GetRecordsregion($start = 0, $limit = 10) {
        //search query start//
        $title = str_replace("'","",trim($this->input->get('title')));
        
        //$status = $this->input->post('status1');
        //$type = $this->input->post('type');
        //if ($status != '')
         //   $this->db->where('status ', $status);
        //if ($title != '')
          //  $this->db->where('(email_id like ' . "'%" . $title . "%'   OR first_name like " . "'%" . $title . "%') ");
        //if ($type != '')
        //echo $type;
        //$this->db->like('user_type', $type);
        
        
            //$this->db->like('user_type', 'region');   // Change
            
        $this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.email_id like ' . "'%" . $title . "%'   OR u.last_name like " . "'%" . $title . "%' OR u.first_name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.designation like " . "'%" . $title . "%' OR u.user_id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%' OR tb.name like " . "'%" . $title . "%' OR region.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
        $this->db->where('u.user_type =', 'region');  // Change
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_region as region','region.id = u.user_type_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.zone_id','left');
		$this->db->order_by('u.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_user as u");
            
            
       /* $this->db->where('status !=', 5);
        $this->db->where('user_type =', 'region');  // Change
        $this->db->order_by('id DESC');
        $this->db->limit($limit, $start);

        $query = $this->db->get("tbl_user");*/

        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->bank_name = $this->getbankName($row->bank_id);
                $row->zone_name = $this->getzoneName($row->zone_id);
                $row->region_name = $this->getregionName($row->user_type_id); //region_user_type_id
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }

    public function getregionName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_region');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           $rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }

    public function GetRecordszone($start = 0, $limit = 10) {
        //search query start//
        $title = str_replace("'","",trim($this->input->get('title')));
       
		

		$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.email_id like ' . "'%" . $title . "%'   OR u.last_name like " . "'%" . $title . "%' OR u.first_name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.user_id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%' OR tb.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
        $this->db->where('u.user_type =', 'zone');  // Change
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.user_type_id','left');
		$this->db->order_by('u.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_user as u");


        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->bank_name = $this->getbankName($row->bank_id);
                $row->zone_name = $this->getzoneName($row->user_type_id);
                //$row->region_name = $this->getregionName($row->user_type_id); //region_user_type_id
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }

    public function GetRecordsdrt($start = 0, $limit = 10) {
        //search query start//
        $title = str_replace("'","",trim($this->input->get('title')));
        
        
        
        /*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.email_id like ' . "'%" . $title . "%'   OR u.last_name like " . "'%" . $title . "%' OR u.first_name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%'OR u.status like " . "'%" . $status . "%' OR tb.name like " . "'%" . $title . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
        $this->db->where('u.user_type =', 'drt');  // Change
		$this->db->join('tbl_drt as tb','tb.id = u.user_type_id','left');
		$this->db->order_by('u.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_user as u");*/
        
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.email_id", "u.last_name", "u.first_name", "u.id", "tb.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_user as u LEFT JOIN tbl_drt as tb ON tb.id = u.user_type_id WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND u.status != 5  AND u.user_type = 'drt' ";
		$query .= "ORDER BY u.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		

        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->drt_name = $this->getdrtName($row->user_type_id);
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }

    public function getdrtName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_drt');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
			$rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }

    public function save_data_bankerregion($doc = null) {
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $designation = $this->input->post('designation');
        $mobile_no = $this->input->post('mobile_no');
        $email_id = $this->input->post('email_id');
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        $user_type_id = $this->input->post($user_type . '_user_type_id');
        $bank_id = $this->input->post($user_type . '_bank');
        $zone_id = $this->input->post($user_type . '_zone');
        $c1zone_id = $this->input->post('c1zone_user_type_id');
        if ($c1zone_id)
            $c1zone = GetTitleById('tbl_c1zone', $c1zone_id);
        $region_id = $this->input->post($user_type . '_region');
        $lho_id = $this->input->post($user_type . '_lho');
        $role = $this->input->post('role');
        $indate = $this->input->post('indate');
        $status = $this->input->post('status');
        $password = $this->input->post('password');

        if ($id) {
            $this->db->where('id', $id);
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                //'password'=>$password ,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user', $data);
        } else {
            $data['indate'] = date('Y-m-d H:i:s');
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'password' => hash("sha256", $password),
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'indate' => date('Y-m-d H:i:s'),
                'status' => $status
            );
            $this->db->insert('tbl_user', $data);
            $insertedID = $this->db->insert_id();
            if ($insertedID) {

                $id = $insertedID;
                $bankName = GetTitleByField('tbl_bank', "id='" . $bank_id . "'", 'shortName');
                $bankName = str_replace(' ', '', $bankName);
                if ($user_type == 'branch') {
                    $userid = strtoupper($bankName) . '_branch' . $id;
                } else if ($user_type == 'region') {

                    $userid = strtoupper($bankName) . '_region' . $id;
                } else if ($user_type == 'zone') {
                    $userid = strtoupper($bankName) . '_zone' . $id;
                } else if ($user_type == 'drt') {
                    $userid = 'drt_' . $id;
                }

                $this->db->where('id', $id);
               // $udata = array('user_id' => $userid);
               // $this->db->update('tbl_user', $udata);
                // $this->db->last_query();
                //die;
            }
        }
        return true;
    }

    public function save_data_bankerzone($doc = null) {
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $designation = $this->input->post('designation');
        $mobile_no = $this->input->post('mobile_no');
        $email_id = $this->input->post('email_id');
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        $user_type_id = $this->input->post($user_type . '_user_type_id');
        $bank_id = $this->input->post($user_type . '_bank');
        $zone_id = $this->input->post($user_type . '_zone');
        $c1zone_id = $this->input->post('c1zone_user_type_id');
        if ($c1zone_id)
            $c1zone = GetTitleById('tbl_c1zone', $c1zone_id);
        $region_id = $this->input->post($user_type . '_region');
        $lho_id = $this->input->post($user_type . '_lho');
        $role = $this->input->post('role');
        $indate = $this->input->post('indate');
        $status = $this->input->post('status');
        $password = $this->input->post('password');

        if ($id) {
            $this->db->where('id', $id);
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                //'user_id'=>$user_id ,
                //'password'=>$password ,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user', $data);
        } else {
            $data['indate'] = date('Y-m-d H:i:s');
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                'user_id' => $user_id,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'password' => hash("sha256", $password),
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'indate' => date('Y-m-d H:i:s'),
                'status' => $status
            );
            $this->db->insert('tbl_user', $data);
            $insertedID = $this->db->insert_id();
            if ($insertedID) {

                $id = $insertedID;
                $bankName = GetTitleByField('tbl_bank', "id='" . $bank_id . "'", 'shortName');
                $bankName = str_replace(' ', '', $bankName);
                if ($user_type == 'branch') {
                    $userid = strtoupper($bankName) . '_branch' . $id;
                } else if ($user_type == 'region') {

                    $userid = strtoupper($bankName) . '_region' . $id;
                } else if ($user_type == 'zone') {
                    $userid = strtoupper($bankName) . '_zone' . $id;
                } else if ($user_type == 'drt') {
                    $userid = 'drt_' . $id;
                }

                //$this->db->where('id', $id);
                ///$udata = array('user_id' => $userid);
               // $this->db->update('tbl_user', $udata);
                // $this->db->last_query();
                //die;
            }
        }
        return true;
    }

    public function save_data_bankerdrt($doc = null) {
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $designation = $this->input->post('designation');
        $mobile_no = $this->input->post('mobile_no');
        $email_id = $this->input->post('email_id');
        //$user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        $user_type_id = $this->input->post($user_type . '_user_type_id');
        $bank_id = $this->input->post($user_type . '_bank');
        $zone_id = $this->input->post($user_type . '_zone');
        $c1zone_id = $this->input->post('c1zone_user_type_id');
        if ($c1zone_id)
            $c1zone = GetTitleById('tbl_c1zone', $c1zone_id);
        $region_id = $this->input->post($user_type . '_region');
        $lho_id = $this->input->post($user_type . '_lho');
        $role = $this->input->post('role');
        $indate = $this->input->post('indate');
        $status = $this->input->post('status');
        $password = $this->input->post('password');

        if ($id) {
            $this->db->where('id', $id);
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                //'user_id' => $user_id,
                //'password'=>$password ,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'status' => $status,
                'date_modified' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_user', $data);
        } else {
            $data['indate'] = date('Y-m-d H:i:s');
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'designation' => $designation,
                'mobile_no' => $mobile_no,
                //'user_id' => $user_id,
                'bank_id' => $bank_id,
                'zone_id' => $zone_id,
                'lho_id' => $lho_id,
                'region_id' => $region_id,
                'email_id' => $email_id,
                'password' => hash("sha256", $password),
                'user_type' => $user_type,
                'user_type_id' => $user_type_id,
                'role' => $role,
                'indate' => date('Y-m-d H:i:s'),
                'status' => $status
            );
            $this->db->insert('tbl_user', $data);
            $insertedID = $this->db->insert_id();
            if ($insertedID) {

                $id = $insertedID;
                $bankName = GetTitleByField('tbl_bank', "id='" . $bank_id . "'", 'shortName');
                $bankName = str_replace(' ', '', $bankName);
                if ($user_type == 'branch') {
                    $userid = strtoupper($bankName) . '_branch' . $id;
                } else if ($user_type == 'region') {
                    $userid = strtoupper($bankName) . '_region' . $id;
                } else if ($user_type == 'zone') {
                    $userid = strtoupper($bankName) . '_zone' . $id;
                } else if ($user_type == 'drt') {
                    $userid = 'drt_' . $id;
                }

              ////  $this->db->where('id', $id);
               // $udata = array('user_id' => $userid);
               //// $this->db->update('tbl_user', $udata);
                // $this->db->last_query();
                //die;
            }
        }
        return true;
    }

    //Author:Amit Sahu
    //user registration log start
    public function GetUserTotalregistrationlogs($type) {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $user_id = trim($this->input->get('createdby'));
        $activity_done = trim($this->input->get('Change_status'));
        $this->db->select('count(*) as total');
        $this->db->from("tbl_log_user_registration");
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($activity_done != '') {
            $this->db->where('actiontype', $activity_done);
        }else{
          if($type==1){  $this->db->where('actiontype','reg');}
          if($type==2){  $this->db->where('actiontype','create_branch');}  
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
             return $data[0]->total;
        } else {
            return 0;
        }
    }

    public function completeMISregistrationLogData($type){
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $user_id = trim($this->input->get('createdby'));
        $activity_done = trim($this->input->get('Change_status'));
        $this->db->select('id,email_id,user_id,ip_address,user_type,date_modified,indate,status,message,actiontype');
        $this->db->from("tbl_log_user_registration");
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
          if ($activity_done != '') {
            $this->db->where('actiontype', $activity_done);
        }else{
          if($type==1){  $this->db->where('actiontype','reg');}
          if($type==2){  $this->db->where('actiontype','create_branch');}  
        }
        $this->db->order_by('id DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return 0;
        }
    }

    public function GetRecordsregistrationUserlogs($start = 0, $limit = 10,$type) {

        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $user_id = trim($this->input->get('createdby'));
        $activity_done = trim($this->input->get('Change_status'));
        $this->db->select('id,email_id,user_id,ip_address,user_type,date_modified,indate,status,message,actiontype');
        $this->db->from("tbl_log_user_registration");
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($activity_done != '') {
            $this->db->where('actiontype', $activity_done);
        }else{
           if($type==1){  $this->db->where('actiontype','reg');}
           if($type==2){  $this->db->where('actiontype','create_branch');}
            
        }
          if ($user_id != '') {
            $this->db->where('email_id', $user_id);
        }
      $this->db->order_by('id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
       if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return 0;
        }
    }

    //user registration log end
    //bid opening log start
    public function GetUserTotalbidopeninglogs() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));        
        $auctionID = trim($this->input->get('auctionId'));
        $this->db->select('count(*) as total');
        $this->db->from('tbl_log_bid_track as A');
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }       
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join('tbl_user as D', 'D.id=A.bank_user_id', 'left');
        $this->db->order_by('A.id DESC');
        $query=$this->db->get();
      if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }

    public function completeMISbidopeningLogData() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));        
        $auctionID = trim($this->input->get('auctionId'));
        $this->db->select('A.id,A.event_id as eventID,C.name as bankname,D.id as user_id,D.user_type,A.auction_id as auctionID,A.bank_id,A.bidder_id,A.indate,A.status,A.ip as ip_address,A.message,D.email_id,E.email_id as emailid');
         $this->db->from('tbl_log_bid_track as A');
        if ($activity_done != '') {
        $this->db->where('A.action_type', $activity_done);
        }
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }       
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join('tbl_user as D', 'D.id=A.bank_user_id', 'left');
        $this->db->join('tbl_user_registration as E', 'E.id=A.bidder_id', 'left');
        $this->db->order_by('A.id DESC');
       // $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return 0;
        }
    }

    public function GetRecordsbidopeningUserlogs($start = 0, $limit = 10) {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auctionID = trim($this->input->get('auctionId'));
        $this->db->select('A.id,A.event_id as eventID,C.name as bankname,D.id as user_id,D.user_type as usercategory,A.auction_id as auctionID,A.bank_id,A.bidder_id,A.indate,A.status,A.ip as ip_address,A.message,D.email_id,E.email_id as emailid');
        $this->db->from('tbl_log_bid_track as A');
      
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }
       
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join('tbl_user as D', 'D.id=A.bank_user_id', 'left');
		$this->db->join('tbl_user_registration as E', 'E.id=A.bidder_id', 'left');
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            $data = $query->result();
           // echo '<pre>';
           // print_r($data);die;
            return $data;
        } else {
            return 0;
        }
    }

    //bid opening log end
    //bid submission log
    //bid opening log start
    public function GetUserTotalbidsubmissionlogs() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $createdby = trim($this->input->get('createdby'));
        $auctionID = trim($this->input->get('auctionId'));
        $eventID = trim($this->input->get('eventId'));
        $activity_done = trim($this->input->get('Change_status'));
        $this->db->select('count(*) as total');
        $this->db->from('tbl_log_bidsubmission_track as A');
        if ($activity_done != '') {
           $this->db->where('A.action_type', $activity_done);
        }else{
           $this->db->where('A.action_type', 'participitation_agreement');    
        }
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }
        if ($eventID != '') {
            $this->db->where('A.event_id', $eventID);
        }
        if ($createdby != '') {
            $this->db->where('A.bidder_id', $createdby);
        }
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidder_id', 'left');
        $this->db->order_by('A.id DESC');
        $query=$this->db->get();
      
      if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }

    public function completeMISbidsubmissionLogData() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $createdby = trim($this->input->get('createdby'));
        $auctionID = trim($this->input->get('auctionId'));
        $eventID = trim($this->input->get('eventId'));
        $activity_done = trim($this->input->get('Change_status'));
        $this->db->select('A.id,A.event_id as eventID,C.name as bankname,D.id as user_id,D.user_type,A.auction_id as auctionID,A.bank_id,A.bidder_id,A.indate,A.status,A.ip as ip_address,A.message,D.email_id');
        $this->db->from('tbl_log_bidsubmission_track as A');
        if ($activity_done != '') {
        $this->db->where('A.action_type', $activity_done);
        }else{
           $this->db->where('A.action_type', 'participitation_agreement');    
        }
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }
        if ($eventID != '') {
            $this->db->where('A.event_id', $eventID);
        }
        if ($createdby != '') {
            $this->db->where('A.bidder_id', $createdby);
        }
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidder_id', 'left');
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
      
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return 0;
        }
    }

    public function GetRecordsbidsubmissionUserlogs($start = 0, $limit = 10) {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $createdby = trim($this->input->get('createdby'));
        $auctionID = trim($this->input->get('auctionId'));
        $eventID = trim($this->input->get('eventId'));
        $activity_done = trim($this->input->get('Change_status'));
        $this->db->select('A.id,A.event_id as eventID,C.name as bankname,D.id as user_id,D.user_type,A.auction_id as auctionID,A.bank_id,A.bidder_id,A.indate,A.status,A.ip as ip_address,A.message,D.email_id');
        $this->db->from('tbl_log_bidsubmission_track as A');
        if ($activity_done != '') {
           $this->db->where('A.action_type', $activity_done);
            }else{
           $this->db->where('A.action_type', 'participitation_agreement');    
        }
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }
        if ($eventID != '') {
            $this->db->where('A.event_id', $eventID);
        }
        if ($createdby != '') {
            $this->db->where('A.bidder_id', $createdby);
        }
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidder_id', 'left');
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
         // print_r($this->db->last_query()); die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return 0;
        }
    }
     //Reports log start
     public function GetUserTotalreportslogs() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $createdby = trim($this->input->get('createdby'));
        $auctionID = trim($this->input->get('auctionId'));
        $eventID = trim($this->input->get('eventId'));
        $activity_done = trim($this->input->get('Change_status'));
        
        if(in_array($activity_done,array('mcg_auction_report')))
        {
			$table_name = "tbl_user";
		}
		else
		{
			$table_name = "tbl_user_registration";
		}
		
		if(in_array($activity_done,array('mcg_auction_report')))
		{
			$user_type = array("buyer");
		}
		else
		{
			$user_type = array("owner");
		}
		
		
		
        $this->db->select('count(*) as total');
        $this->db->from('tbl_log_all_report_track as A');
        if ($activity_done != '') {
           $this->db->where('A.action_type', $activity_done);
        }else{
           $this->db->where('A.action_type','Bidder_report');    
        }
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }
        if ($eventID != '') {
            $this->db->where('A.event_id', $eventID);
        }
         if ($createdby != '') {
            $this->db->where('A.bidder_id', $createdby);
        }
        
        //$this->db->where_in('D.register_as', $user_type);
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join($table_name.' as D', 'D.id=A.bidder_id', 'left');
        
       // $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        //$this->db->join('tbl_user_registration as D', 'D.id=A.bidder_id', 'left');
        $this->db->order_by('A.id DESC');
        $query=$this->db->get();
      if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
   public function completeMISreportsLogData() {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $createdby = trim($this->input->get('createdby'));
        $auctionID = trim($this->input->get('auctionId'));
        $eventID = trim($this->input->get('eventId'));
        $activity_done = trim($this->input->get('Change_status'));
        
        
        if(in_array($activity_done,array('mhada_auction_report')))
        {
			$table_name = "tbl_user";
		}
		else
		{
			$table_name = "tbl_user_registration";
		}
         
        $this->db->select('A.id,A.auction_id,C.name as bankname,A.action_type_event,D.id as user_id,D.user_type,A.auction_id as auctionID,A.bank_id,A.bidder_id,A.indate,A.status,A.ip as ip_address,A.message,D.email_id');
        $this->db->from('tbl_log_all_report_track as A');
        if ($activity_done == 'mhada_auction_report') {
           $this->db->where('A.action_type', 'mcg_auction_report');
            }else{
           $this->db->where('A.action_type','Bidder_report');    
        }
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }
        if ($eventID != '') {
            $this->db->where('A.event_id', $eventID);
        }
       if ($createdby != '') {
            $this->db->where('A.bidder_id', $createdby);
        }
       // $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        //$this->db->join('tbl_user_registration as D', 'D.id=A.bidder_id', 'left');
         $this->db->where_in('D.register_as', $user_type);
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join($table_name.' as D', 'D.id=A.bidder_id', 'left');
        
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return 0;
        }
    }

    public function GetRecordsreportsUserlogs($start = 0, $limit = 10) {
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $createdby = trim($this->input->get('createdby'));
        $auctionID = trim($this->input->get('auctionId'));
        $eventID = trim($this->input->get('eventId'));        
        $activity_done = trim($this->input->get('Change_status'));
        
        if(in_array($activity_done,array('mhada_auction_report')))
        {
			$table_name = "tbl_user";
		}
		else
		{
			
			$table_name = "tbl_user_registration";
		}
       
        
        $this->db->select('A.id,A.auction_id,C.name as bankname,A.action_type_event,D.id as user_id,D.user_type,A.auction_id as auctionID,A.bank_id,A.bidder_id,A.indate,A.status,A.ip as ip_address,A.message,D.email_id');
        $this->db->from('tbl_log_all_report_track as A');
        if ($activity_done == 'mhada_auction_report') {
           $this->db->where('A.action_type', 'mcg_auction_report');
            }else{
           $this->db->where('A.action_type','Bidder_report');    
        }
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auctionID != '') {
            $this->db->where('A.auction_id', $auctionID);
        }
        if ($eventID != '') {
            $this->db->where('A.event_id', $eventID);
        }
        if ($createdby != '') {
            $this->db->where('A.bidder_id', $createdby);
        }
        $this->db->where_in('D.register_as', $user_type);
        $this->db->join('tbl_bank as C', 'C.id=A.bank_id', 'left');
        $this->db->join($table_name.' as D', 'D.id=A.bidder_id', 'left');
        $this->db->order_by('A.id DESC');
        //print_r( $this->db->last_query()); die();
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return 0;
        }
    }
    //Reports log end
    
    
     function completeBidsubmitLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '')
        {				 
			//$bidderID = GetTitleByField('tbl_user_registration', "email_id='" . $email_id . "'", 'id');
			$this->db->where('D.email_id',$email_id);
        
		}
        $this->db->select('A.id,A.auctionID,A.bid_value,A.bid_type,D.email_id,A.ip,A.indate,A.modified_date');
        $this->db->from('tbl_live_auction_bid AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
   public function GetBidSubmissionlogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auctionId = trim($_GET['auctionId']);
        $eventId = trim($_GET['eventId']);
        $createdby = trim($_GET['createdby']);
        $activity_done = trim($_GET['Change_status']);
		
        $email_id = trim($this->input->get('email_id'));
        
        $this->db->select('A.id,A.auctionID,A.bid_value,A.bid_type,D.email_id,A.ip,A.indate,A.modified_date');
        $this->db->from('tbl_live_auction_bid AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '')
        {				 
			//$bidderID = GetTitleByField('tbl_user_registration', "email_id='" . $email_id . "'", 'id');
			$this->db->where('D.email_id',$email_id);
        
		}
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
     public function Gettotalbidlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
         if ($email_id != '')
         {				 
			 $bidderID = GetTitleByField('tbl_user_registration', "email_id='" . $email_id . "'", 'id');
			$this->db->where('bidderID',$bidderID);
        
		}
        $query = $this->db->get("tbl_live_auction_bid");
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function completefinalApprovalLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($_GET['auction_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(opener2_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
          $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.opener2_accepted_ip,A.opener2_accepted_date,A.operner2_accepted,A.operner2_comment');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.operner2_accepted is not null');
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetFinalApproverlogs($start = 0, $limit = 10) {
    $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.opener2_accepted_ip,A.opener2_accepted_date,A.operner2_accepted,A.operner2_comment');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.operner2_accepted is not null');
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.opener2_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
    public function Gettotalapproverlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(opener2_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auction_id != '') {
            $this->db->where("auctionID",$auction_id);
        }
        $this->db->where('operner2_accepted is not null');
        $query = $this->db->get("tbl_log_auction_participate");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    
    /******* Bidder final submission Logs start*******************/
    
    function completefinalsubmissionLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($_GET['auction_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.final_submit_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
        $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.final_submit,A.final_submit_date,A.final_submit_ip,A.final_submit_message');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.final_submit',1);
        $this->db->where('A.final_submit_date is not null');
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function Gettotalfinalsubmissionlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.final_submit_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auction_id != '') {
            $this->db->where("A.auctionID",$auction_id);
        }
        $this->db->where('A.final_submit',1);
        $this->db->where('A.final_submit_date is not null');
        $query = $this->db->get("tbl_log_auction_participate as A");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    
     public function GetFinalSubmissionLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.final_submit_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
        $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.final_submit,A.final_submit_date,A.final_submit_ip,A.final_submit_message');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.final_submit',1);
        $this->db->where('A.final_submit_date is not null');
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
                
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
    /******* Bidder final submission Logs end*******************/
    
    
    /******* 	User Agreement & Privacy Policy Acceptance Logs start*******************/
    
    function completeiagreelogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($_GET['auction_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
        $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.is_accept_tc,A.is_accept_tc_date,A.is_accept_tc_ip,A.is_accept_tc_message');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.is_accept_tc',1);
        $this->db->where('A.is_accept_tc_date is not null');
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function Gettotaliagreelogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auction_id != '') {
            $this->db->where("auctionID",$auction_id);
        }
        $this->db->where('A.is_accept_tc',1);
        $this->db->where('A.is_accept_tc_date is not null');
        $query = $this->db->get("tbl_log_auction_participate as A");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    
     public function GetIAgreeLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.is_accept_tc_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
        $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.is_accept_tc,A.is_accept_tc_date,A.is_accept_tc_ip,A.is_accept_tc_message');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.is_accept_tc',1);
        $this->db->where('A.is_accept_tc_date is not null');
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
                
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
    /************User Agreement & Privacy Policy Acceptance Log End*******************/
    
    
    /*******Auction Training Acceptance Log start*******************/
    
    function completeauctiontraininglogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($_GET['auction_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.is_accept_auct_training_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
        $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.is_accept_auct_training,A.is_accept_auct_training_date,A.is_accept_auct_training_ip,A.is_accept_auct_training_message');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.is_accept_auct_training',1);
        $this->db->where('A.is_accept_auct_training_ip is not null');
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function Gettotalauctiontrainingloglogs() {
        $this->db->select('count(A.id) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.is_accept_auct_training_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auction_id != '') {
            $this->db->where("auctionID",$auction_id);
        }
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.is_accept_auct_training',1);
        $this->db->where('A.is_accept_auct_training_ip is not null');
        
        $this->db->order_by('A.id DESC');
        $query = $this->db->get("tbl_log_auction_participate as A");
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    
     public function GetAuctionTrainingLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.is_accept_auct_training_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
		
        $this->db->select('A.id,A.auctionID,D.first_name,D.last_name,D.user_type,D.organisation_name,A.is_accept_auct_training,A.is_accept_auct_training_date,A.is_accept_auct_training_ip,A.is_accept_auct_training_message');
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.is_accept_auct_training',1);
        $this->db->where('A.is_accept_auct_training_ip is not null');
        
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
                
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
    /************Auction Training Acceptance Log End*******************/
    
    function completeInvalidLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        $this->db->select('A.id,A.auctionID,D.user_type,D.organisation_name,D.first_name,D.last_name,A.bid_value,A.ip,A.indate,A.modified_date,A.message');
        $this->db->from(' tbl_live_auction_bid_invalid AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->order_by('A.bidderID DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
   
    public function InvalidBidlogs($start = 0, $limit = 10) {
    $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $eventId = trim($_GET['eventId']);
        $createdby = trim($_GET['createdby']);
        $activity_done = trim($_GET['Change_status']);

        $this->db->select('A.id,A.auctionID,D.user_type,D.organisation_name,D.first_name,D.last_name,A.bid_value,A.ip,A.indate,A.modified_date,A.message');
        $this->db->from(' tbl_live_auction_bid_invalid AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->order_by('A.bidderID DESC');
        $this->db->limit($limit, $start);
         if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id !='') {
			$this->db->where("auctionID", $auction_id);
		}
       
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
      public function Gettotalinvalidlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
         if ($auction_id != '') {
            $this->db->where("auctionID",$auction_id);
        }
        $query = $this->db->get("tbl_live_auction_bid_invalid");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function completeDocApproverLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(opener1_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
       $this->db->select('A.id,A.auctionID,D.user_type,D.organisation_name,D.first_name,D.last_name,A.opener1_accepted_ip,A.opener1_accepted_date,A.operner1_accepted,A.operner1_comment');
        $this->db->from(' tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.opener1_move_to_opener2',1);
        $this->db->where('A.opener1_accepted_ip is not null');
        $this->db->order_by('A.bidderID DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
      public function Doc_Approver_logs($start = 0, $limit = 10) {
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $activity_done = trim($_GET['Change_status']);

        $this->db->select('A.id,A.auctionID,D.user_type,D.organisation_name,D.first_name,D.last_name,A.opener1_accepted_ip,A.opener1_accepted_date,A.operner1_accepted,A.operner1_comment');
        $this->db->from(' tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.opener1_move_to_opener2',1);
        $this->db->where('A.opener1_accepted_ip is not null');
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        if($from_date != '' && $to_date != '')
        {
			$this->db->where('(A.opener1_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");  
		}
			
		if($auction_id != '')
		{
			$this->db->where("A.auctionID",$auction_id); 
		}
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
      public function GetdocApproverlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(opener1_accepted_date  BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != ''){
			$this->db->where("auctionID",$auction_id);
		} 
		$this->db->where('opener1_move_to_opener2',1);
        $this->db->where('opener1_accepted_ip is not null');
        $query = $this->db->get("tbl_log_auction_participate");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function completePaymentApproverLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(payment_verifier_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($auction_id != '') {
            $this->db->where("auctionID",$auction_id);
        }
      
        
        $this->db->select('A.id,A.auctionID,D.user_type,D.organisation_name,D.first_name,D.last_name,A.payment_verifier_accepted_ip,A.payment_verifier_accepted_date 	,A.payment_verifier_accepted,A.payment_verifier_comment');
        $this->db->from(' tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.payment_verifier_accepted_ip is not null');
        $this->db->order_by('A.bidderID DESC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function Payment_Approver_logs($start = 0, $limit = 10) {
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $activity_done = trim($_GET['Change_status']);

        $this->db->select('A.id,A.auctionID,D.user_type,D.organisation_name,D.first_name,D.last_name,A.payment_verifier_accepted_ip,A.payment_verifier_accepted_date 	,A.payment_verifier_accepted,A.payment_verifier_comment');
        $this->db->from(' tbl_log_auction_participate AS A');
        $this->db->join('tbl_user_registration as D', 'D.id=A.bidderID', 'left');
        $this->db->where('A.payment_verifier_accepted_ip is not null');
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.payment_verifier_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '') {
			$this->db->where("A.auctionID",$auction_id);
		}
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
      public function GetpaymentApproverlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date	'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(payment_verifier_accepted_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($auction_id != '') {
			$this->db->where("auctionID",$auction_id);
		}
		$this->db->where('payment_verifier_accepted_ip is not null');
        $query = $this->db->get("tbl_log_auction_participate");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function completeRegistrationPaymentLogData() {		
        //search query start//
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $track_id = trim($_GET['track_id']);
        $ref_number = trim($_GET['ref_number']);
        $email_id = trim($_GET['email_id']);
        $payment_status = trim($_GET['payment_status']);
        
        //$this->db->select('*');
        $this->db->from('tbl_payment');
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(sendTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
         if($auction_id !='') {
			$this->db->where("auctionID",$auction_id);
		}
         
        if($track_id !='') {
			$this->db->like("data",$track_id);
		}
		 if ($ref_number != '') 
		{
           $this->db->like("data",$ref_number);
        }
        if ($email_id != '') {
           $this->db->like("payu_email",$email_id);
        }  
        if ($payment_status != '') 
		{
		   if(strtolower($payment_status) != 'pending')
		   {
			   $this->db->like("data",$payment_status);
		   }
		   else
		   {
			 $this->db->where("data",NULL);
		   }
        }              
        $this->db->order_by('id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
   public function GettotalRegistrationPaymentlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $ref_number = trim($this->input->get('ref_number'));
        $email_id = trim($this->input->get('email_id'));
        $payment_status = trim($_GET['payment_status']);
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(sendTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        
        if ($ref_number != '') {
           $this->db->like("data",$ref_number);
        }
        if ($email_id != '') {
           $this->db->like("data",$email_id);
        }
        if ($payment_status != '') 
		{
		   if(strtolower($payment_status) != 'pending')
		   {
			   $this->db->like("data",$payment_status);
		   }
		   else
		   {
			 $this->db->where("data",NULL);
		   }
        }  
        $query = $this->db->get("tbl_payment");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    public function registrationPaymentLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $track_id = trim($_GET['track_id']);
        $ref_number = trim($_GET['ref_number']);
        $email_id = trim($_GET['email_id']);
        $payment_status = trim($_GET['payment_status']);
        $pay_res = json_decode($data->data);
        

        $this->db->select('A.*');
        $this->db->from(' tbl_payment AS A');
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(sendTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
                 
        if($track_id !='') {
			$this->db->like("data",$track_id);
		}
		 if ($ref_number != '') 
		{
           $this->db->like("data",$ref_number);
        }
        if ($email_id != '') {
           $this->db->like("data",$email_id);
        }
        if ($payment_status != '') 
		{
		   if(strtolower($payment_status) != 'pending')
		   {
			   $this->db->like("data",$payment_status);
		   }
		   else
		   {
			 $this->db->where("data",NULL);
		   }
        } 
         
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
   
   public function completePaymentLogData() {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $track_id = trim($_GET['track_id']);
        $ref_number = trim($_GET['ref_number']);
        $email_id = trim($_GET['email_id']);
        $payment_status = trim($_GET['payment_status']);
        $pay_res = json_decode($data->payment_response);
        

       // $this->db->select('*');
        $this->db->from('tbl_jda_payment_log');
       
        $this->db->order_by('payment_log_id DESC');
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(date_created BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
         if($auction_id !='') {
			$this->db->where("auction_id",$auction_id);
		}
         
        if($track_id !='') {
			$this->db->like("payment_response",$track_id);
		}
		 if ($ref_number != '') 
		{
           $this->db->like("payment_response",$ref_number);
        }
        if ($email_id != '') {
           $this->db->like("payment_response",$email_id);
        }
        if ($payment_status != '') 
		{
           $this->db->where("payment_status",$payment_status);
        }
         
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    public function paymentLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $track_id = trim($_GET['track_id']);
        $ref_number = trim($_GET['ref_number']);
        $email_id = trim($_GET['email_id']);
        $payment_status = trim($_GET['payment_status']);
        $pay_res = json_decode($data->payment_response);
        

        $this->db->select('A.*');
        $this->db->from(' tbl_jda_payment_log AS A');
       
        $this->db->order_by('A.payment_log_id DESC');
        $this->db->limit($limit, $start);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(date_created BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
         if($auction_id !='') {
			$this->db->where("auction_id",$auction_id);
		}
         
        if($track_id !='') {
			$this->db->like("payment_response",$track_id);
		}
		 if ($ref_number != '') 
		{
           $this->db->like("payment_response",$ref_number);
        }
         if ($payment_status != '') 
		{
           $this->db->where("payment_status",$payment_status);
        }
        if ($email_id != '') {
           $this->db->like("payment_response",$email_id);
        }
         
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    public function GettotalPaymentlogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        $ref_number = trim($this->input->get('ref_number'));
        $email_id = trim($this->input->get('email_id'));
        $payment_status = trim($this->input->get('payment_status'));
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(date_created BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
         if ($auction_id != '') {
            $this->db->where("auction_id",$auction_id);
        }
         if ($ref_number != '') {
           $this->db->like("payment_response",$ref_number);
        }
        if ($payment_status != '') 
		{
           $this->db->where("payment_status",$payment_status);
        }
        if ($email_id != '') {
           $this->db->like("payment_response",$email_id);
        }
        $query = $this->db->get("tbl_jda_payment_log");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    
    
    
    
   public function GetBidder_Reglogs($start = 0, $limit = 10) {
    $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $email_id = trim($_GET['email_id']);

        $this->db->select('A.*');
        $this->db->from('tbl_log_user_registration AS A');
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
         if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
         
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    public function GetBidder_Reg_logs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $query = $this->db->get("tbl_log_user_registration");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function completeBidderRegLogData() {
      
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        //$this->db->select('A.id,A.first_name,A.last_name,A.email_id,A.mobile_no,A.ip_address,A.address1');
        $this->db->select('A.*');
        $this->db->from('tbl_log_user_registration AS A');
        $this->db->order_by('A.id DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetBidder_listing($start = 0, $limit = 10) {
    $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $email_id = trim($_GET['email_id']);

        $this->db->select('A.*');
        $this->db->from('tbl_user_registration AS A');
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
         if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
         
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    public function GetBidder_list() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $query = $this->db->get("tbl_user_registration");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function completeBidderListData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        $this->db->order_by('id DESC');
        $query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    
    public function GetJDA_listing($start = 0, $limit = 10) {
    $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $email_id = trim($_GET['email_id']);
      
 

      $this->db->select('A.id,A.first_name,A.last_name,A.email_id,A.mobile_no,B.department_id,C.department_name,group_concat(R.name) AS name');
      $this->db->from('tbl_user_department as B');
      $this->db->join('tbl_user AS A', 'B.user_id = A.id', 'left');
      $this->db->join('tblmst_department as C', 'B.department_id = C.department_id', 'left');
      $this->db->join('tbl_role AS R', 'B.role_id = R.role_id', 'left');
      $this->db->where('B.status',1);
       $this->db->group_by('A.id'); 
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
         if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
   
    public function GetJDA_list() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $query = $this->db->get("tbl_user");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function completeJDAListData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        
         $this->db->select('A.id,A.first_name,A.last_name,A.email_id,A.mobile_no,B.department_id,C.department_name,group_concat(R.name SEPARATOR " |  ") AS name');
		  $this->db->from('tbl_user_department as B');
		  $this->db->join('tbl_user AS A', 'B.user_id = A.id', 'left');
		  $this->db->join('tblmst_department as C', 'B.department_id = C.department_id', 'left');
		  $this->db->join('tbl_role AS R', 'B.role_id = R.role_id', 'left');
		  $this->db->where('B.status',1);
		   $this->db->group_by('A.id'); 
        
			$query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     function completeAwardedListLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        
        $reference_no = trim($this->input->get('reference_no'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        $this->db->select('A.auctionID,D.reference_no,CONCAT(B.first_name , " ",  B.last_name) AS bidder_name,B.organisation_name, B.user_type,B.email_id,A.awardedStatus,CONCAT(C.first_name , " ",  C.last_name) AS awarded_by_name,A.awarded_date,A.awarded_ip, MAX(bid.bid_value) as h1_price',false);
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_auction as D', 'D.id=A.auctionID', 'left');
        $this->db->join('tbl_user as C', 'C.id=A.awarded_by', 'left');
        $this->db->join('tbl_user_registration as B', 'B.id=A.bidderID', 'left');
        $this->db->join('tbl_live_auction_bid as bid','bid.auctionID=D.id','left');
        $this->db->group_by('bid.auctionID');
        $this->db->where('A.awardedStatus',1);
        $this->db->order_by('A.id DESC');
       // $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     public function Gettotalawardedlogs() {
        $this->db->select('count(*) as total');
        $this->db->select('A.auctionID,D.reference_no,CONCAT(B.first_name , " ",  B.last_name) AS bidder_name,B.email_id,A.awardedStatus,CONCAT(C.first_name , " ",  C.last_name) AS awarded_by_name,A.awarded_date,A.awarded_ip',false);
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_auction as D', 'D.id=A.auctionID', 'left');
        $this->db->join('tbl_user as C', 'C.id=A.awarded_by', 'left');
        $this->db->join('tbl_user_registration as B', 'B.id=A.bidderID', 'left');
        $this->db->where('A.awardedStatus',1);
        
        
        $reference_no = trim($this->input->get('reference_no'));
       
      
       
        $query = $this->db->get();
        
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    public function GetAwardedListlogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auctionId = trim($_GET['auctionId']);
        $reference_no = trim($_GET['reference_no']);
		
        
        $this->db->select('A.auctionID,D.reference_no,CONCAT(B.first_name , " ",  B.last_name) AS bidder_name, B.organisation_name, B.user_type, B.email_id, B.id as user_id, A.awardedStatus, CONCAT(C.first_name , " ",  C.last_name) AS awarded_by_name, A.awarded_date, A.awarded_ip,  MAX(bid.bid_value) as h1_price',false);
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_auction as D', 'D.id=A.auctionID', 'left');
        $this->db->join('tbl_user as C', 'C.id=A.awarded_by', 'left');
        $this->db->join('tbl_user_registration as B', 'B.id=A.bidderID', 'left');
        $this->db->join('tbl_live_auction_bid as bid','bid.auctionID=D.id','left');
        $this->db->group_by('bid.auctionID');
        $this->db->where('A.awardedStatus',1);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($reference_no != '') {
           $this->db->like("reference_no",$reference_no);
        }
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GettotalNotawardedlogs() {
        $this->db->select('count(*) as total');
        
        $this->db->select('A.auctionID,D.reference_no,CONCAT(B.first_name , " ",  B.last_name) AS bidder_name,A.awardedStatus,CONCAT(C.first_name , " ",  C.last_name) AS awarded_by_name,A.awarded_date,A.awarded_ip',false);
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_auction as D', 'D.id=A.auctionID', 'left');
        $this->db->join('tbl_user as C', 'C.id=A.awarded_by', 'left');
        $this->db->join('tbl_user_registration as B', 'B.id=A.bidderID', 'left');
        $this->db->where('A.awardedStatus',2);
        
        
       $reference_no = trim($this->input->get('reference_no'));
        $query = $this->db->get();
        
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    public function GetNotAwardedListlogs($start = 0, $limit = 10) {
		
		$reference_no = trim($_GET['reference_no']);
        
        $this->db->select('A.auctionID,D.reference_no,CONCAT(B.first_name , " ",  B.last_name) AS bidder_name,B.email_id,B.id as user_id, B.organisation_name, B.user_type, A.awardedStatus,CONCAT(C.first_name , " ",  C.last_name) AS awarded_by_name,A.awarded_date,A.awarded_ip,MAX(bid.bid_value) as h1_price',false);
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_auction as D', 'D.id=A.auctionID', 'left');
        $this->db->join('tbl_user as C', 'C.id=A.awarded_by', 'left');
        $this->db->join('tbl_user_registration as B', 'B.id=A.bidderID', 'left');
        $this->db->join('tbl_live_auction_bid as bid','bid.auctionID=D.id','left');
        $this->db->group_by('bid.auctionID');
        $this->db->where('A.awardedStatus',2);
        if ($reference_no != '') {
           $this->db->like("reference_no",$reference_no);
        }
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        
			//echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    function completeNotAwardedListLogData() {
        //search query start//
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
         $reference_no = trim($this->input->get('reference_no'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        $this->db->select('A.auctionID,D.reference_no,CONCAT(B.first_name , " ",  B.last_name) AS bidder_name,B.organisation_name, B.user_type,B.email_id,A.awardedStatus,CONCAT(C.first_name , " ",  C.last_name) AS awarded_by_name,A.awarded_date,A.awarded_ip,MAX(bid.bid_value) as h1_price',false);
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_auction as D', 'D.id=A.auctionID', 'left');
        $this->db->join('tbl_user as C', 'C.id=A.awarded_by', 'left');
        $this->db->join('tbl_user_registration as B', 'B.id=A.bidderID', 'left');
        $this->db->join('tbl_live_auction_bid as bid','bid.auctionID=D.id','left');
        $this->db->group_by('bid.auctionID');
        $this->db->where('A.awardedStatus',2);
        $this->db->order_by('A.id DESC');
       // $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
     public function GetAssignedDepts($start = 0, $limit = 10) {

        $this->db->select('A.user_id,A.dept_assign_id,A.department_id,B.department_name,C.first_name,C.last_name,C.email_id,A.date_created');
        $this->db->from('tbl_user_assign_department AS A');
         $this->db->join('tblmst_department as B', 'B.department_id=A.department_id	', 'left');
         $this->db->join('tbl_user as C', 'C.id=A.user_id', 'left');
         $this->db->where('A.status',1);
         //$this->db->group_by('B.department_name DESC');
         //$this->db->order_by('A.date_created DESC');
       
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
     public function GetAssignedRoles($start = 0, $limit = 10) {
		$this->db->select('A.user_id, A.department_id, GROUP_CONCAT(R.name) AS role_name, B.department_name, C.first_name, C.last_name, C.email_id, A.date_created');
		$this->db->from('tbl_user_department AS A');
		$this->db->join('tblmst_department as B', 'B.department_id=A.department_id	', 'left');			
		$this->db->join('tbl_user as C', 'C.id=A.user_id', 'left');
		$this->db->join('tbl_role as R', 'R.role_id=A.role_id', 'left');
		$this->db->where('A.status',1);
		$this->db->group_by('A.user_id, A.department_id');
		//$this->db->order_by('A.user_deprt_id DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
    }
    
    
    public function bidder_forgot_pass_total_data() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(in_date_time BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $query = $this->db->get("tblforget_pass");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function bidder_forgot_pass_csv_data() {
      
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(in_date_time BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        //$this->db->select('A.id,A.first_name,A.last_name,A.email_id,A.mobile_no,A.ip_address,A.address1');
        $this->db->select('A.*');
        $this->db->from('tblforget_pass AS A');
        $this->db->order_by('A.forget_pass_id DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function bidder_forgot_pass_listing_data($start = 0, $limit = 10) {
    $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $email_id = trim($_GET['email_id']);

        $this->db->select('A.*');
        $this->db->from('tblforget_pass AS A');
       
        $this->db->order_by('A.forget_pass_id DESC');
        $this->db->limit($limit, $start);
         if ($from_date != '' && $to_date != '') {
            $this->db->where('(in_date_time BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
         
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
   
   
   public function bidder_reset_pass_total_data() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(createTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        $query = $this->db->get("tbl_log_password");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    function bidder_reset_pass_csv_data() {
      
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $email_id = trim($this->input->get('email_id'));
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(createTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
        //$this->db->select('A.id,A.first_name,A.last_name,A.email_id,A.mobile_no,A.ip_address,A.address1');
        $this->db->select('A.*');
        $this->db->from('tbl_log_password AS A');
        $this->db->order_by('A.log_pass_id DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function bidder_reset_pass_listing_data($start = 0, $limit = 10) {
    $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $email_id = trim($_GET['email_id']);

        $this->db->select('A.*');
        $this->db->from('tbl_log_password AS A');
       
        $this->db->order_by('A.log_pass_id DESC');
        $this->db->limit($limit, $start);
         if ($from_date != '' && $to_date != '') {
            $this->db->where('(createTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if ($email_id != '') {
           $this->db->like("email_id",$email_id);
        }
         
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
    function completeGSTRegData() {		
        //search query start//
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $track_id = trim($_GET['track_id']);
        $email_id = trim($_GET['email_id']);
        $payment_status = trim($_GET['payment_status']);        
        //$this->db->select('*');
        $this->db->from('tbl_payment');
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(sendTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
         
        if($track_id !='') {
			$this->db->like("data",$track_id);
		}
		
        if ($email_id != '') {
           $this->db->like("payu_email",$email_id);
        }  
                
        $this->db->where("paymentStatus",'success');          
        $this->db->order_by('id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
   
    public function gstRegLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $track_id = trim($_GET['track_id']);
        $email_id = trim($_GET['email_id']);
        $payment_status = trim($_GET['payment_status']);     
        $pay_res = json_decode($data->payment_response);
        

        $this->db->select('A.*');
        $this->db->from('tbl_payment AS A');
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(sendTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if($track_id !='') {
			$this->db->like("data",$track_id);
		}
		 
        if ($email_id != '') {
           $this->db->like("payu_email",$email_id);
        }
        
        $this->db->where("paymentStatus",'success'); 
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    public function GettotalGSTReglogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $track_id = trim($_GET['track_id']);
        $email_id = trim($this->input->get('email_id'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(sendTime BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        
        if($track_id !='') {
			$this->db->like("data",$track_id);
		}
        
        if ($email_id != '') {
           $this->db->like("payu_email",$email_id);
        }
        $this->db->where("paymentStatus",'success'); 
        $query = $this->db->get("tbl_payment");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    
    function completeGSTBankData() {		
        //search query start//
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $track_id = trim($_GET['track_id']);
        $ref_number = trim($_GET['ref_number']);
        $email_id = trim($_GET['email_id']);
        $payment_status = trim($_GET['payment_status']);
        
        //$this->db->select('*');
        $this->db->from('tbl_jda_payment_log');
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(date_created BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
         if($auction_id !='') {
			$this->db->where("auction_id",$auction_id);
		}
         
        if($track_id !='') {
			$this->db->like("payment_response",$track_id);
		}
		 if ($ref_number != '') 
		{
           $this->db->where("control_number",$ref_number);
        }
        if ($payment_status != '') 
		{
           $this->db->where("payment_status",$payment_status);
        }
        if ($email_id != '') {
           $this->db->like("payment_response",$email_id);
        }       
        $this->db->where("payment_status",'success');          
        $this->db->order_by('payment_log_id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
   
    public function gstBankLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $track_id = trim($_GET['track_id']);
        $ref_number = trim($_GET['ref_number']);
        $email_id = trim($_GET['email_id']);
        $pay_res = json_decode($data->payment_response);
        

        $this->db->select('A.*');
        $this->db->from(' tbl_jda_payment_log AS A');
       
        $this->db->order_by('A.payment_log_id DESC');
        $this->db->limit($limit, $start);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(date_created BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
         if($auction_id !='') {
			$this->db->where("auction_id",$auction_id);
		}
         
        if($track_id !='') {
			$this->db->like("payment_response",$track_id);
		}
		 if ($ref_number != '') 
		{
           $this->db->where("control_number",$ref_number);
        }
		
        if ($email_id != '') {
           $this->db->like("payment_response",$email_id);
        }
        
        $this->db->where("payment_status",'success'); 
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    public function GettotalGSTBanklogs() {
        $this->db->select('count(*) as total');
        $from_date = trim($this->input->get('from_date'));
        $to_date = trim($this->input->get('to_date'));
        $auction_id = trim($this->input->get('auction_id'));
        $ref_number = trim($this->input->get('ref_number'));
        $email_id = trim($this->input->get('email_id'));
        $payment_status = trim($this->input->get('payment_status'));
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(date_created BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
         if ($auction_id != '') {
            $this->db->where("auction_id",$auction_id);
        }
         if ($ref_number != '') {
           $this->db->where("control_number",$ref_number);
        }
        
        if ($email_id != '') {
           $this->db->like("payment_response",$email_id);
        }
        $this->db->where("payment_status",'success');
        $query = $this->db->get("tbl_jda_payment_log");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    public function completeEMDDepositData() {		
        //search query start//
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $utr_no = trim($_GET['utr_no']);
        $email_id = trim($_GET['email_id']);
        
        //$this->db->select('*');
        $this->db->from('tbl_auction_bidder_utr_no');
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(emd_deposit_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if($auction_id !='') {
			$this->db->where("auctionID",$auction_id);
		}
		if ($account_holder_name != '') 
		{
           $this->db->where("account_holder_name",$account_holder_name);
        }
        if ($utr_no != '') 
		{
           $this->db->where("utr_no",$utr_no);
        }       
        
        $this->db->order_by('utr_id DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
   public function GettotalEMDDepositlogs() {
        
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $utr_no = trim($_GET['utr_no']);
        $email_id = trim($_GET['email_id']);
       
        $this->db->select('count(*) as total');
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(emd_deposit_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if($auction_id !='') {
			$this->db->where("auctionID",$auction_id);
		}
		if ($account_holder_name != '') 
		{
           $this->db->where("account_holder_name",$account_holder_name);
        }
        if ($utr_no != '') 
		{
           $this->db->where("utr_no",$utr_no);
        }       
        
        $query = $this->db->get("tbl_auction_bidder_utr_no");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    public function emdDepositLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $auction_id = trim($_GET['auction_id']);
        $utr_no = trim($_GET['utr_no']);
        $email_id = trim($_GET['email_id']);
        

        $this->db->select('A.*');
        //$this->db->from('tbl_auction_bidder_utr_no AS A');
       
        $this->db->order_by('A.utr_id DESC');
        $this->db->limit($limit, $start);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(emd_deposit_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
           
        }
        if($auction_id !='') {
			$this->db->where("A.auctionID",$auction_id);
		}
        if($email_id !='') {
			$this->db->where("B.email_id",$email_id);
		}
		if ($account_holder_name != '') 
		{
           $this->db->where("A.account_holder_name",$account_holder_name);
        }
        if ($utr_no != '') 
		{
           $this->db->where("A.utr_no",$utr_no);
        }       
        $this->db->join('tbl_user_registration as B','B.id=A.bidderID','inner');
        $query = $this->db->get('tbl_auction_bidder_utr_no AS A');
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
    
    public function completeEMDRefundData() {		
        //search query start//
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $account_number = trim($_GET['account_number']);
        $email_id = trim($_GET['email_id']);
        
        $this->db->select('A.*, B.bank_name');
       
       
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");           
        }
       
        if($email_id !='') {
			$this->db->where("A.email_id",$email_id);
		}
		if ($account_number != '') 
		{
           $this->db->where("A.account_number",$account_number);
        }
        if ($utr_no != '') 
		{
           $this->db->where("A.utr_no",$utr_no);
        }        
        
        $this->db->order_by('A.id DESC');
        $this->db->join('tblmst_bank as B','B.bank_id=A.bank_id','left');     
        $query = $this->db->get('tbl_user_registration AS A');
        
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
   public function GettotalEMDRefundlogs() {
        
        $from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $account_number = trim($_GET['account_number']);
        $email_id = trim($_GET['email_id']);
       
        $this->db->select('count(*) as total');
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");           
        }
       
        if($email_id !='') {
			$this->db->where("A.email_id",$email_id);
		}
		if ($account_number != '') 
		{
           $this->db->where("A.account_number",$account_number);
        }
        if ($utr_no != '') 
		{
           $this->db->where("A.utr_no",$utr_no);
        }  
        $this->db->join('tblmst_bank as B','B.bank_id=A.bank_id','left');     
        $query = $this->db->get('tbl_user_registration AS A');
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
    public function emdRefundLogs($start = 0, $limit = 10) {
		$from_date = trim($_GET['from_date']);
        $to_date = trim($_GET['to_date']);
        $account_number = trim($_GET['account_number']);
        $email_id = trim($_GET['email_id']);
        

        $this->db->select('A.*, B.bank_name');
       
        $this->db->order_by('A.id DESC');
        $this->db->limit($limit, $start);
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(A.indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");           
        }
       
        if($email_id !='') {
			$this->db->where("A.email_id",$email_id);
		}
		if ($account_number != '') 
		{
           $this->db->where("A.account_number",$account_number);
        }
        if ($utr_no != '') 
		{
           $this->db->where("A.utr_no",$utr_no);
        }  
        $this->db->join('tblmst_bank as B','B.bank_id=A.bank_id','left');     
        $query = $this->db->get('tbl_user_registration AS A');
        //echo $this->db->last_query();die;
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
   
   }
  

?>
