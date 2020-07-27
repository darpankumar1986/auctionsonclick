<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __Construct() {
        header_remove("X-Powered-By");

        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('log4php');
        log_error('my_error');
        log_info('my_info');
        log_debug('my_debug');
        //error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('file');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model('home_model');
        $this->load->model('admin/news_model');
        $this->load->model('property_model');
		
		/* run auction completed script */
        $this->load->model('account_model');
        $this->account_model->completedAuctionScript();
        /* end run auction completed script */
		
        if ($this->session->userdata('user_type') == 'owner' || $this->session->userdata('user_type') == 'builder' || $this->session->userdata('user_type') == 'broker') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'helpdesk_ex') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'sales_cordinator') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'banker') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'account') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'helpdesk_admin') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'sales') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'mis') {
            redirect('/registration/logout');
        }

        if (preg_match("/index.php/", $_SERVER['REQUEST_URI'])) {
            redirect('/', 'location', 301);
        }
    }

    function page($slug) {
        $staticData = $this->home_model->getStaticContentsBySlug($slug);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/about_us', $data);
        $this->load->view('front_view/footer');
    }

    public function index_backup_2001_2016() {
        $upcomingAuctionData = $this->home_model->homeAuctionRecords();
        $pastAuctionData = $this->home_model->homeAuctionRecords('past');
        $bankData = $this->home_model->bankList();
        $newsData = $this->home_model->blogNewsRecords('news');
        $blogsData = $this->home_model->blogNewsRecords('blog');
        $bannerData = $this->home_model->frontBanner();
        $categoryList = $this->property_model->categoryList();
        $budgetArr = $this->property_model->getPropertyBudget();
        $data['upcomingAuctionData'] = $upcomingAuctionData;
        $data['bannerData'] = $bannerData;
        $data['pastAuctionData'] = $pastAuctionData;
        $data['categoryList'] = $categoryList;
        $data['bankData'] = $bankData;
        $data['newsData'] = $newsData;
        $data['blogsData'] = $blogsData;
        $data['budgetArr'] = $budgetArr;
        $data = array();
        $this->load->view('front_view/header');
        $this->load->view('front_view/home', $data);
        $this->load->view('front_view/footer');
    }


    public function archiveAuctionDatatable() {
        echo $this->home_model->archiveAuctionDatatable();
    }

    public function liveAuctionDatatableHome() {
        echo $this->home_model->liveAuctionDatatableHome();
    }

    public function checkdsclogin() {
        echo $this->home_model->checkdsclogin();
    }

    public function index() {
		/*
		$this->load->model('elastic_model');		
		$res = $this->elastic_model->property();
		*/
        $data = array();
        $bankData = $this->home_model->bankList();
        $eventData = $this->home_model->eventList();
        $homebreakingNews = $this->home_model->getHomeBreakingNewsDetails();
        $data['homebreakingNews'] = $homebreakingNews;
	
        $headerbankId = '0';
        $homeHeaderBanner = $this->home_model->getHomeHeaderBanner($headerbankId);
        $data['homeHeaderBanner'] = $homeHeaderBanner;

        $sliderbankId = '0';
        $homeSliderBanner = $this->home_model->getHomeSlider($sliderbankId);
        $data['homeSliderBanner'] = $homeSliderBanner;


        $data['controller'] = 'home';
        $data['bankData'] = $bankData;

        $data['eventData'] = $eventData;
		
		$data['aData'] = $this->home_model->liveAuctionDatatable();
		$data['assetsType'] = $this->home_model->getAllAssetsType();

        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/home', $data);
		}
        
        $this->load->view('front_view/footer');
    }
	
	
	public function archiveAuction() {
        $data = array();
        
        $data['controller'] = 'home';
        $data['bankData'] = $bankData;

        $data['eventData'] = $eventData;
        
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/archive_auction', $data);
        $this->load->view('front_view/footer');
    }
    
    function faqs() {
        //$staticData = $this->home_model->getStaticContents(4);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/faq', $data);   
        $this->load->view('front_view/footer');     
    }
    
    public function dsclogin() {
        $data = array();

        $bankData = $this->home_model->bankList();
        $eventData = $this->home_model->eventList();
        $data['controller'] = 'home';
        $data['bankData'] = $bankData;

        $data['eventData'] = $eventData;
        $this->load->view('front_view/header1', $data);
        $this->load->view('front_view/home', $data);
        $this->load->view('front_view/footer');
    }

    function aboutus() {
        $staticData = $this->home_model->getStaticContents(2);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/about_us', $data);
        $this->load->view('front_view/footer');
    }

    function contactus() {
        $staticData = $this->home_model->getStaticContents(3);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/contact_us', $data);
        $this->load->view('front_view/footer');
    }

    function privacy_policy() {
        $staticData = $this->home_model->getStaticContents(1);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/privecy-policy', $data);
        $this->load->view('front_view/footer');
    }

    function terms_of_use() {
        $staticData = $this->home_model->getStaticContents(5);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/terms_of_use', $data);
        $this->load->view('front_view/footer');
    }

    function externallogin() {
		//$this->session->sess_destroy();
        $this->load->view('front_view/header', $data);

        $tokenId = $this->input->get('tkn');		
        $url = EXTERNAL_LOGIN_URL . $tokenId;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $return = curl_exec($ch);
        /*
         if($errno = curl_errno($ch)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
        */
        curl_close($ch);
        //print_r($return);			
        $data = json_decode($return);

		/*
         echo "<pre>";
          print_r($data);
          echo "</pre>";die;
         */
 
        if ($data->Status == 'Success') {
			
            $this->session->set_userdata('jda_token', $tokenId);
			
            if (is_numeric($data->UserDetail->LoginName)) {
				
                $this->session->set_userdata('department_name', $data->UserDetail->DepartmentName);//Added by Aziz
                $this->session->set_userdata('designation_name', $data->UserDetail->DesignationName);//Added by Aziz
                $this->session->set_userdata('name_of_person', $data->UserDetail->NameOfPerson);//Added by Aziz
                //print_r($this->session->userdata);
                $nameArr = explode(' ', $data->UserDetail->NameOfPerson);
                
                $roleArr = $data->UserDetail->UserRoles;

                foreach ($roleArr as $key => $ra) {
                    //if ($ra->UserRole != 'Administrator') {

                    $this->db->where('jda_role', $ra->UserRoleID);
                    $this->db->where('status', 1);
                    $rQry = $this->db->get('tbl_role');
                    if ($rQry->num_rows() > 0) {
                        $rows = $rQry->result_array();
                        foreach ($rows as $rw) {
                            $roleIdArr[] = $rw['role_id'];
                            $roleNameArr[] = $rw['name'];
                        }
                    }
                    $departmentID[] = $ra->DepartmentID;
                    $departmentName[] = $ra->DepartmentName;
                    //}
                }

                //$roleIdArr = array_unique($roleIdArr);
                //$roleNameArr = array_unique($roleNameArr);


					$rolesIds = implode(',', $roleIdArr);


                    $user_type = 'buyer';
                    $uData = array(
						"id"=>$data->UserDetail->LoginName,
                        "first_name" => ucwords(strtolower($nameArr[0])),
                        "last_name" => ucwords(strtolower($nameArr[1])),
                        "email_id" => strtolower($data->UserDetail->Email),
                        "designation" => $data->UserDetail->DesignationName,
                        "mobile_no" => $data->UserDetail->MobileNumber,
                        "user_id" => strtolower($data->UserDetail->Email),
                        "user_type" => $user_type,
                        "role" => $rolesIds,
                        "role_id" => $rolesIds,
                        "status" => 1
                    );

                    $this->db->where('id', $data->UserDetail->LoginName);
                    $ckUQry = $this->db->get('tbl_user');
                    // echo $this->db->last_query();die;
                    if ($ckUQry->num_rows() > 0) {
                        $dataArr = $ckUQry->result_array();

                        $uData["date_modified"] = date("Y-m-d H:i:s");

                        $this->db->where('id', $data->UserDetail->LoginName);
                        //$this->db->where('id',$data->UserDetail->UserId);
                        $this->db->update('tbl_user', $uData);
                        $uId = $dataArr[0]['id'];
                        
                    } else {
                        $generatedPass = hash("sha256", '123');
                        $uData['password'] = $generatedPass;
                        $uData["indate"] = date("Y-m-d H:i:s");
                        //echo 'insert';die;						
                        $this->db->insert('tbl_user', $uData);
                        $uId = $this->db->insert_id();
                    }

                

                $data1 = array('status' => 0);
                $this->db->where('user_id', $uId);
                $this->db->update('tbl_user_department', $data1);

                foreach ($roleIdArr as $key => $ra) {
                    $uDepartArr = array(
                        'department_id' => $departmentID[$key],
                        'user_id' => $uId,
                        'role_id' => $ra,
                        'status' => 1
                    );
                    $dwhr = array(
                        'department_id' => $departmentID[$key],
                        'user_id' => $uId,
                        'role_id' => $ra,
                    );
                    $this->db->where($dwhr);
                    $dptQry = $this->db->get('tbl_user_department');
                    if ($dptQry->num_rows() > 0) {
                        $dArr = $dptQry->result_array();
                        $dwhr = array(
                            'department_id' => $departmentID[$key],
                            'user_id' => $uId,
                            'role_id' => $ra,
                        );
                        $this->db->where($dwhr);

                        $uDepartArr['date_modified'] = date("Y-m-d H:i:s");

                        $this->db->update('tbl_user_department', $uDepartArr);
                        $uDepartId[] = $dArr[0]['user_deprt_id'];
                    } else {
                        $uDepartArr['date_created'] = date("Y-m-d H:i:s");
                        $this->db->insert('tbl_user_department', $uDepartArr);
                        $uDepartId[] = $this->db->insert_id();
                    }
                }

                //print_r($roleIdArr);die;
				
                $departmentID = array_unique($departmentID);
                $departmentName = array_unique($departmentName);
                $departArr = implode(',', $departmentID);

                foreach ($departmentID as $key => $dept) {

                    $uDepartArr = array(
                        'department_id' => $dept,
                        'department_name' => $departmentName[$key],
                        'status' => 1
                    );
                    $dwhr = array(
                        'department_id' => $dept
                        //,'department_name' => $departmentName[$key]
                    );
                    $this->db->where($dwhr);
                    $dptQry = $this->db->get('tblmst_department');
                    if ($dptQry->num_rows() > 0) {
                        $dArr = $dptQry->result_array();
                        $dwhr = array(
                            'department_id' => $departmentID[$key]
                            //,'department_name' => $departmentName[$key]
                        );
                        $this->db->where($dwhr);

                        $uDepartArr['date_modified'] = date("Y-m-d H:i:s");

                        $this->db->update('tblmst_department', $uDepartArr);
                    } else {
                        $uDepartArr['date_created'] = date("Y-m-d H:i:s");
                        $this->db->insert('tblmst_department', $uDepartArr);
                    }
                }
				$this->db->select('ud.user_deprt_id, ud.user_id, ud.role_id, tr.jda_role, tr.name, md.department_id, md.department_name');
                $this->db->from('tbl_user_department as ud');
                $this->db->join('tbl_role as tr', 'tr.role_id=ud.role_id', 'left');
                $this->db->join('tblmst_department as md', 'md.department_id=ud.department_id', 'left');
                $this->db->where('ud.user_id', $uId);
                $this->db->where('ud.status', 1);
                //$this->db->limit(1);
                $ssoQry = $this->db->get();
                //echo $this->db->last_query();die;
                if ($ssoQry->num_rows() > 0) {
                    $ssoData = $ssoQry->result_array();
                    /*echo "<pre>";
                    print_r( $ssoData);die;
                    */
                } else {
                    $ssoData = array();
                }
                
                $this->session->set_userdata('role_id', $roleIdArr[0]);
                $this->session->set_userdata('depart_id', $departmentID[0]);
                $this->session->set_userdata('ssoData', $ssoData);
                
                //$ses = $this->session->userdata('ssoData');
                //echo'<pre>';
                //print_r($ses);die;
                //print_r($roleIdArr);die;
                
                if (in_array('6', $roleIdArr)) {
                $aData = array(
                                'adminid' => $uId,
                                'id' => $uId,
                                'aname' => $data->UserDetail->NameOfPerson,
                                'aemail' => $data->UserDetail->Email,
                                'validated' => true,
                                'arole' => 1
                                 );
                //print_r($aData);die;
                    $this->session->set_userdata($aData);
                   
                    redirect(base_url().'admin/home');
                }
                else{				
                $rand = rand(1000000000, 9999999999);
                $res = $this->bankuserupdate_login($uId);
                $this->session->set_userdata('id', $uId);
                $this->session->set_userdata('full_name', $nameArr[0]);
                $this->session->set_userdata('user_type', $user_type);
                $this->session->set_userdata('bank_id', 41);
                $this->session->set_userdata('branch_id', 0);
                
                $this->session->set_userdata('session_id_user', $rand);
                $this->session->set_userdata('table_session', 'banker_tb');                
                redirect("registration/redirectDashboard");
                exit;
                }
            } else {
                $nameArr = explode(' ', $data->UserDetail->NameOfPerson);
                if ($nameArr[2] != '') {
                    $first_name = $nameArr[0] . ' ' . $nameArr[1];
                    $last_name = $nameArr[2];
                } else {
                    $first_name = $nameArr[0];
                    $last_name = $nameArr[1];
                }
                $verifyCode = $data->UserDetail->Email . $data->UserDetail->UserId;
                $verifyCode = md5($verifyCode);


                $user_type = 'owner';
                $uData = array(
                    "first_name" => ucwords(strtolower($first_name)),
                    "last_name" => ucwords(strtolower($last_name)),
                    "email_id" => strtolower($data->UserDetail->Email),
                    "designation" => $data->UserDetail->DesignationName,
                    "mobile_no" => $data->UserDetail->MobileNumber,
                    "user_type" => $user_type,
                    "register_as" => $user_type,
                    "status" => 1,
                    "verify_status" => 1,
                    "verify_code" => $verifyCode,
                    "address1"=>$data->UserDetail->PostalAddress,
                    "country_id" => 1,
                    "state_id" => 1,
                    "city_id" => 1
                );

                $this->db->where('email_id', $data->UserDetail->Email);
                $this->db->where('id', $data->UserDetail->UserId);
                $ckUQry = $this->db->get('tbl_user_registration');
                if ($ckUQry->num_rows() > 0) {
                    //echo 'update';die;
                    $dataArr = $ckUQry->result_array();

                    $uData["date_modified"] = date("Y-m-d H:i:s");

                    $this->db->where('email_id', $data->UserDetail->Email);
                    $this->db->where('id', $data->UserDetail->UserId);
                    $this->db->update('tbl_user_registration', $uData);
                    $uId = $dataArr[0]['id'];
                } else {
                    $uData["id"] = $data->UserDetail->UserId;
                    $generatedPass = hash("sha256", '123');
                    $uData["password"] = $generatedPass;
                    $uData["indate"] = date("Y-m-d H:i:s");
                    //print_r($uData);die;
                    //echo 'insert';die;						
                    $this->db->insert('tbl_user_registration', $uData);
                    $uId = $this->db->insert_id();
                }

                //create bidder log
                $userlog = $uData;
                unset($userlog['id']);
                unset($userlog['date_modified']);
                $userlog['user_id'] = $data->UserDetail->UserId;
                $userlog['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $userlog['indate'] = date("Y-m-d H:i:s");
                //echo "<pre>";
                //print_r($userlog);die;
                
                /*
                $userlog = array(
                    'actiontype' => 'reg',
                    'email_id' => $data->UserDetail->Email,
                    'user_id' => $data->UserDetail->UserId,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_type' => $user_type,
                    'indate' => date("Y-m-d H:i:s"),
                    'status' => '1',
                    'message' => 'Bidder Registered Successfully'
                );
                */ 
                
                $this->db->insert('tbl_log_user_registration', $userlog);

                //set bidder session

                $this->session->set_userdata('id', $data->UserDetail->UserId);
                $this->session->set_userdata('full_name', $first_name);
                $this->session->set_userdata('user_type', trim($user_type));

                $rand = rand(10000000000, 99999999999);
                $this->session->set_userdata('session_id_user', $rand);

                $this->session->set_userdata('table_session', 'registration_tb');
                $this->userupdate_login($uId);

                redirect("registration/redirectDashboard");
                exit;
            }
        } else {
			
            redirect('registration/logout');
            exit();
        }
    }

    public function bankuserupdate_login($id) {
        $setarray = array('user_sess_val' => $this->session->userdata('session_id_user'));
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $setarray);
        return true;
    }

    public function userupdate_login($id) {
        $setarray = array('user_sess_val' => $this->session->userdata('session_id_user'));
        $this->db->where('id', $id);
        $this->db->update('tbl_user_registration', $setarray);
        return true;
    }   
    
    public function viewEventDocuments()
	{
		$data['controller'] = 'home';        
        $this->load->view('front_view/header', $data);
		$auctionID=$this->uri->segment(3);		
		$data['data'] = $this->home_model->GetAuctionDocuments($auctionID);
		$this->load->view('front_view/event_documents', $data);
		//$this->load->view('front_view/footer_m');
	}
	
	public function quick_view()
	{
		$this->load->view('front_view/quick_view', $data);
	}
	
	public function viewGoogleMap()
	{
		$data['heading']='Auction Event Map';
		$data['controller'] = 'home';        
        $this->load->view('front_view/header', $data);	
		$auctionID=$this->uri->segment(3);
		$data['data'] = $this->home_model->GetRecordByAuctionId($auctionID);
		$this->load->view('front_view/view_google_map', $data);
		//$this->load->view('front_view/footer_m');
	}
	
	function auctionDetailPopup($auctionID) {
            $data['auction_data'] = $this->home_model->aucDetailPopupData($auctionID);
            $data['uploadedDocs'] = $this->home_model->GetUploadedDocsByAuctionId($auctionID);
            $this->load->view('front_view/auction_detail_popup', $data);
        }
        
	//Added by Azizur Rahman for Archive auction details
	function archiveAuctionDetailPopup($auctionID) {
		$data['auction_data'] = $this->home_model->archiveAuctionDetailPopupData($auctionID);
		$data['uploadedDocs'] = $this->home_model->GetUploadedDocsByAuctionId($auctionID);
		$this->load->view('front_view/archive_auction_detail_popup', $data);
	}
	
	public function propertylisting()
	{	
		/*		
		$vdata['subCategory'] = $this->search_model->getSubCategories();
		
		
		$sub_cat_name = $vdata['subCategory'][0]['sub_categories'][0]['name'];
		if($sub_cat_name)
		{
			$subcatname = $sub_cat_name.', '.$sub_cat_name;
		}
		else
		{
			$subcatname = '';
		}
		//$data['title'] = $subcatname.' manufacturers, '.$sub_cat_name.' suppliers, '.$sub_cat_name.'  exporters | '.$this->siteurl;
		$data['title'] = 'Assets List';
		
		$this->load->view('front_view/header', $data);
		$vdata['topProducts'] = $this->search_model->getTopProducts();
		
		$vdata['products'] = $this->search_model->getProducts();
		
		//echo '<pre>';
	   // print_r($vdata['products']);die
		$vdata['total'] = $this->search_model->count_products();
		$vdata['country'] = $this->search_model->getSupplierLocation();
		//echo'<pre>'; print_r($vdata['country']);die;
		$this->load->view('productlist',$vdata);
		$this->load->view('front_view/footer');
		*/
		$data['assetsType'] = $this->home_model->getAllAssetsType();
		$this->load->view('front_view/header', $data);	
		$vdata['property'] = $this->home_model->getProperty();	
		
		 if(MOBILE_VIEW)
		{				
			$this->load->view('mobile/property_listing',$vdata);
		}
		else
		{				
			$this->load->view('front_view/property_listing',$vdata);
		}
		
		
		$this->load->view('front_view/footer');
	}
	
	public function search_product()
	{
		/*
		$this->load->model('elastic_model');		
		$res = $this->elastic_model->property();
		*/
		if(ELASTICSEARCH_STATUS != 'ON')
		{
			$this->home_model->query_search();
		}
		else
		{
			$q = strtolower(urldecode($_GET['q']));
			$assetsTypeId = $_GET['assetsTypeId'];
			$this->load->library('Elasticsearch');		
			$elasticSearch = new Elasticsearch();
			$elasticSearch->index = 'c1prop';
			/*$elasticsearch->type = 'details';
			$elasticsearch->create();
			$data = '{"author" : "jhon", "datetime" : "2001-09-09 00:02:04"}';
			$elasticsearch->add(1, $data);

			$elasticsearch->index = '';*/
			
			//$res = $elasticSearch->delete('');
			
			if($q != "")	
			{
				$search_data_1 = '{
							"query": {
								"bool": {								
									"should": [
											{"wildcard":{"search":"'.$q.'*"}}										
										]
								}
								
								
							}
						}';
			}
			else
			{
					$search_data_1 = null;
			}
				
			if($q != "")	
			{
				$search_data = '{
							  "query": {								  
								"query_string": {
								  "query": "'.$q.'~",
								  "boost" :         1.0,
									"fuzziness" :     2
								  
								}								
								
							  }
							}';
			}
			else
			{
					$search_data = null;
			}
								
				
			
			$res_1 = $elasticSearch->search_product('propertydata/_search?size=100',$search_data_1);
			//echo "<pre>";print_r($res_1);die;
			$data = array();		
			
			if(is_array($res_1->hits->hits))
			{
							
				foreach($res_1->hits->hits as $product)
				{
					//echo "<pre>";print_r($product);
					if(count($data) < 10)
					{
						//$data[] = $product->_source->search."(name,".$product->_source->category_id.")";	
						//echo $assetsTypeId .' '. $product->_source->category_id;die;
						if($assetsTypeId>0)
						{
							if($assetsTypeId == $product->_source->category_id)
							{
								$data[] = ucwords($product->_source->search);	
							}
						}
						else
						{
							$data[] = ucwords($product->_source->search);	
						}
						
						$data = array_unique($data);
					}					
				}
				
			}
			
			if(count($res_1->hits->hits) < 11)
			{
				$res = $elasticSearch->search_product('propertydata/_search?size=100',$search_data);
				if(is_array($res->hits->hits))
				{			
					foreach($res->hits->hits as $product)
					{
						if($product->_score > 2)
						{
							if(count($data) < 10)
							{
								//$data[] = $product->_source->search."(name,".$product->_source->product_id.")";						
								if($assetsTypeId>0)
								{
									if($assetsTypeId == $product->_source->category_id)
									{
										$data[] = ucwords($product->_source->search);	
									}
									
								}
								else
								{
									$data[] = ucwords($product->_source->search);	
								}
								$data = array_unique($data);					
							}
						}
					}
				}
			}
			
			echo json_encode($data);die;
		}
	}
	public function mobile_notification()
	{
		$data ='';
		$this->load->view('front_view/header', $data);		
		if(MOBILE_VIEW)
		{				
			$this->load->view('mobile/notification_on_mobile',$vdata);
		}
		
		$this->load->view('front_view/footer');
		
	}

}

?>
