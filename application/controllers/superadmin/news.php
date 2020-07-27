<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_Controller {
	
	public function __Construct()
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/
		
	   	parent::__Construct();
		ob_start();
		 $this->load->library('session');
		$this->load->helper('url');		
		$this->load->library("datatables");		
		$this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->model('home_model');
        $this->load->model('superadmin/news_model');
        
        //echo $_SERVER['REQUEST_URI'];die;
        if(!preg_match("/sitemap.xml/i",$_SERVER['REQUEST_URI']) && !preg_match("/robots.txt/i",$_SERVER['REQUEST_URI']))
        {
			$this->check_isvalidated();
		}
	}	
	
	public function index($type='news')
	{
		$this->page($type);
	}
	public function blog($type='blog')
	{
		$this->page($type);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
           redirect('superadmin/login');
           //redirect('registration/logout');
        }
    }	
		
	public function page($type)
	{
		$type = 'home';		
		$array_records = $this->news_model->GetHomePageRecords($type);

		$data['records'] = $array_records; 
		$this->load->view('superadmin/header');		
		
		$data['type']=$type; 		
		$this->load->view('superadmin/news-blog',$data);
		$this->load->view('superadmin/footer');
	}
	
	public function homebannerlist($type)
	{
		$type = 'home_header';		
		$array_records = $this->news_model->GetHomePageRecords($type);

		$data['records'] = $array_records; 
		$this->load->view('superadmin/header');		
		
		$data['type']=$type; 		
		$this->load->view('superadmin/homebannerlist',$data);
		$this->load->view('superadmin/footer');
	}
	
	
	public function bankbannerlist($id)
	{
		//$type = 'home_header';		
		$array_records = $this->news_model->GetBankHeaderRecords($id);
		$data['bankName'] = $this->news_model->GetBankNameById($id);
		$data['bankId'] = $id;
		$data['records'] = $array_records; 
		$this->load->view('superadmin/header');		
		
		$data['type']=$type; 		
		$this->load->view('superadmin/bankbannerlist',$data);
		$this->load->view('superadmin/footer');
	}
	
	public function banksliderlist($id)
	{
		//$type = 'home_header';		
		$array_records = $this->news_model->GetBankSliderRecords($id);
		$data['bankName'] = $this->news_model->GetBankNameById($id);
		$data['bankId'] = $id;
		$data['records'] = $array_records; 
		$this->load->view('superadmin/header');		
		
		$data['type']=$type; 		
		$this->load->view('superadmin/banksliderlist',$data);
		$this->load->view('superadmin/footer');
	}
	
	public function homesliderlist($type)
	{
		$type = 'home_slider';		
		$array_records = $this->news_model->GetHomePageRecords($type);

		$data['records'] = $array_records; 
		$this->load->view('superadmin/header');		
		
		$data['type']=$type; 		
		$this->load->view('superadmin/homesliderlist',$data);
		$this->load->view('superadmin/footer');
	}
	
	
	public function banklist($type)
	{
		$type = 'home_slider';		
		$array_records = $this->news_model->banklist($type);

		$data['records'] = $array_records; 
		$this->load->view('superadmin/header');		
		
		$data['type']=$type; 		
		$this->load->view('superadmin/banklist',$data);
		$this->load->view('superadmin/footer');
	}


	public function uploadData($type)
	{
		$id=$this->input->post('addedit');
		if($id)
		{
				if (is_uploaded_file($_FILES['filename']['tmp_name'])) 
				{
					echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
					//echo "<h2>Displaying contents:</h2>";
					//readfile($_FILES['filename']['tmp_name']);
					//redirect('superadmin/news/uploadData');

				}

				$handle = fopen($_FILES['filename']['tmp_name'], "r");
				
			

				while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
					
					//$import="INSERT into contacts(contact_first,contact_last,contact_email) values('$data[0]','$data[1]','$data[1]')";
					//mysqli_query($import) or die(mysqli_error());
					$data = array(
								'first_name'=>$data[0] ,
								'last_name'=>$data[1] ,
								'email_id'=>$data[2] ,
								'password'=>'3d2e6fd99d24647a434ea7e49fc8e2f56123a2b45d956a4208943fa2a057fb38' , //Gr8secure_cindia1
								'mobile_no'=>$data[3] ,
								'role'=>'1' ,
								'status'=>'1' ,
								'verify_status'=>'1' ,
								'user_type'=>'marketing' ,
								'register_as'=>'marketing' ,
								'indate'=>date('Y-m-d H:i:s'),
								'address1'=>$data[4] ,
								'country_id'=>$data[5] ,
								'state_id'=>$data[6] ,
								'city_id'=>$data[7] ,
								);
						
						$this->db->insert('tbl_user_registration',$data); 

				}

				fclose($handle);
		
				print "Import done";
    
		}

		$data['records'] = $array_records; 
		$this->load->view('superadmin/header');		
		
		$data['type']=$type; 		
		$this->load->view('superadmin/uploadDataBidder',$data);
		$this->load->view('superadmin/footer');
	}
	
	public function addeditbankslider($id,$param)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{		
			
			if($param){
				
				$array_records = $this->news_model->GetRecordById($param);
			}else{
				$array_records=array();
			}
			$data['bankName'] = $this->news_model->GetBankNameById($id);
			$data['bankId']=$id; 	
			$data['records'] = $array_records; 			
			$this->load->view('superadmin/header');		
			$this->load->view('superadmin/addeditbankslider',$data);
			$this->load->view('superadmin/footer');
		}else{
			
			//if($this->news_model->addEditRecords())
			{
				$id=$this->input->post('id');
				if($id>0)
				{
					$this->session->set_flashdata('message','Data Edit successfully');
				}else{
					$this->session->set_flashdata('message','Data created successfully');
				}
		}
			redirect('superadmin/news');
		}	
	}
	
	public function addeditbankheader($id,$param)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{		
			
			if($param){
				
				$array_records = $this->news_model->GetRecordById($param);
			}else{
				$array_records=array();
			}
			$data['bankName'] = $this->news_model->GetBankNameById($id);
			$data['bankId']=$id; 	
			$data['records'] = $array_records; 			
			$this->load->view('superadmin/header');		
			$this->load->view('superadmin/addeditbankheader',$data);
			$this->load->view('superadmin/footer');
		}else{
			
			//if($this->news_model->addEditRecords())
			{
				$id=$this->input->post('id');
				if($id>0)
				{
					$this->session->set_flashdata('message','Data Edit successfully');
				}else{
					$this->session->set_flashdata('message','Data created successfully');
				}
		}
			redirect('superadmin/news');
		}	
	}
	
	public function addedithomeheader($param)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{		
			
			if($param){
				
				$array_records = $this->news_model->GetRecordById($param);
			}else{
				$array_records=array();
			}
			$data['type']='home_header'; 	
			$data['records'] = $array_records; 			
			$this->load->view('superadmin/header');		
			$this->load->view('superadmin/add-edit-home-header',$data);
			$this->load->view('superadmin/footer');
		}else{
			
			if($this->news_model->addEditRecords())
			{
				$id=$this->input->post('id');
				if($id>0)
				{
					$this->session->set_flashdata('message','Data Edit successfully');
				}else{
					$this->session->set_flashdata('message','Data created successfully');
				}
		}
			redirect('superadmin/news');
		}	
	}
	
	
	public function addedithomeslider($param)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{		
			
			if($param){
				
				$array_records = $this->news_model->GetRecordById($param);
			}else{
				$array_records=array();
			}
			$data['type']='home_header'; 	
			$data['records'] = $array_records; 			
			$this->load->view('superadmin/header');		
			$this->load->view('superadmin/add-edit-home-slider',$data);
			$this->load->view('superadmin/footer');
		}else{
			
			if($this->news_model->addEditRecords())
			{
				$id=$this->input->post('id');
				if($id>0)
				{
					$this->session->set_flashdata('message','Data Edit successfully');
				}else{
					$this->session->set_flashdata('message','Data created successfully');
				}
		}
			redirect('superadmin/news');
		}	
	}
	
	public function addedithomeheaderSave()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('message','Please enter required fields');
				redirect('superadmin/news/addedithomeheader/'.$id);	
			}else{
				$this->session->set_flashdata('message','Please enter required fields');	
				redirect('superadmin/news/addedithomeheader');	
			}
				
				
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->news_model->upload_banner('image');
			}else{
				$image=$this->input->post('image_old');
			}

			$save = $this->news_model->addedithomeheaderSave($image);
			
			if($save){
				$id=$this->input->post('id');
				if($id)
				{
				$this->session->set_flashdata('message','Data successfully updated');	
				}else{
				$this->session->set_flashdata('message','Data successfully created');	
				}
				redirect('superadmin/news/homebannerlist');
			}else{
				
			}
		}	
	}
	
	
	public function addeditbankheaderSave()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('message','Please enter required fields');
				redirect('superadmin/news/addeditbankheader/'.$id);	
			}else{
				$this->session->set_flashdata('message','Please enter required fields');	
				redirect('superadmin/news/addeditbankheader');	
			}
				
				
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->news_model->upload_banner('image');
			}else{
				$image=$this->input->post('image_old');
			}
			$bankID = $this->input->post('bankID');
			$save = $this->news_model->addeditbankheaderSave($image,$bankID);
			
			
			if($save){
				 $id=$this->input->post('id');
				$bankId=$this->input->post('bankID');
				if($id)
				{
				$this->session->set_flashdata('message','Data successfully updated');	
				}else{
				$this->session->set_flashdata('message','Data successfully created');	
				}
				redirect('superadmin/news/bankbannerlist/'.$bankId);
			}else{
				
			}
		}	
	}
	
	
	public function addeditbankSliderSave()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('message','Please enter required fields');
				redirect('superadmin/news/addeditbankslider/'.$id);	
			}else{
				$this->session->set_flashdata('message','Please enter required fields');	
				redirect('superadmin/news/addeditbankslider');	
			}
				
				
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->news_model->upload_banner('image');
			}else{
				$image=$this->input->post('image_old');
			}
			$bankID = $this->input->post('bankID');
			$save = $this->news_model->addeditbankSliderSave($image,$bankID);
			
			
			if($save){
				 $id=$this->input->post('id');
				$bankId=$this->input->post('bankID');
				if($id)
				{
				$this->session->set_flashdata('message','Data successfully updated');	
				}else{
				$this->session->set_flashdata('message','Data successfully created');	
				}
				redirect('superadmin/news/banksliderlist/'.$bankId);
			}else{
				
			}
		}	
	}
	
	public function addedithomesliderSave()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('message','Please enter required fields');
				redirect('superadmin/news/addedithomeslider/'.$id);	
			}else{
				$this->session->set_flashdata('message','Please enter required fields');	
				redirect('superadmin/news/addedithomeslider');	
			}
				
				
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->news_model->upload_banner('image');
			}else{
				$image=$this->input->post('image_old');
			}

			$save = $this->news_model->addedithomesliderSave($image);
			
			if($save){
				$id=$this->input->post('id');
				if($id)
				{
				$this->session->set_flashdata('message','Data successfully updated');	
				}else{
				$this->session->set_flashdata('message','Data successfully created');	
				}
				redirect('superadmin/news/homesliderlist');
			}else{
				
			}
		}	
	}
	
	public function addedit($param)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');		
		if($this->form_validation->run() == FALSE)
		{
			if(is_numeric($param)){
				$data['heading']='Edit Homepage News'; 
				$webpage_id = $param;
			}else{
				$data['heading']='Add Homepage News'; 
			}			
			if($webpage_id){
				
				$array_records = $this->news_model->GetRecordById($webpage_id);
			}else{
				$array_records=array();
			}
			$data['type']='event'; 	
			$data['records'] = $array_records; 			
			$this->load->view('superadmin/header');		
			//$this->load->view('superadmin/sidebar');		
			$this->load->view('superadmin/add-edit-news-blog',$data);
			$this->load->view('superadmin/footer');
		}else{
			
			if($this->news_model->addEditRecords())
			{
				$id=$this->input->post('id');
				if($id>0)
				{
					$this->session->set_flashdata('message','News Edit successfully');
				}else{
					$this->session->set_flashdata('message','News is created successfully');
				}
		}
			redirect('superadmin/news');
		}	
	}
	
	public function blogaddedit($param)
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('author', 'Author', 'trim|required|xss_clean');
		$this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{
			if(is_numeric($param)){
				$data['heading']='Edit Blog'; 
				$webpage_id = $param;
			}else{
				$data['heading']='Add Blog'; 
			}			
			if($webpage_id){
				$array_records = $this->news_model->GetRecordById($webpage_id);
			}else{
				$array_records=array();
			}
			$data['type']='blog';
			$data['records'] = $array_records; 			
			$this->load->view('superadmin/header');		
			$this->load->view('superadmin/sidebar');		
			$this->load->view('superadmin/add-edit-news-blog',$data);
			$this->load->view('superadmin/footer');
		}else{
			if($this->news_model->addEditRecords()){
				$id=$this->input->post('id');
				if($id>0)
				{
					$this->session->set_flashdata('message','Blog is created successfully');
				}else{
					$this->session->set_flashdata('message','Blog is created successfully');
				}
				redirect('superadmin/news/blog');
			}
		}	
	}
	public function deleteRecord($param)
	{
		if(is_numeric($param)){
			$this->news_model->deleteRecord($param);
			redirect('superadmin/news');
		}
	}
	
	public function generatesitemap($param)
	{
	
		header("Content-Type: text/xml;charset=iso-8859-1");		
		$eventList = json_decode($this->home_model->liveAuctionDatatable(),true);
		$data['eventList'] = $eventList['aaData'];			
		$data['bankList'] = $this->home_model->bankList();		
		$this->load->view('superadmin/sitemap',$data);		
	}
	
	public function robots()
	{
		if($_FILES['robots']['name']!= ""){
			$res=$this->news_model->upload_robots('robots');
			if($res == "")
			{
				$this->session->set_flashdata('message','Robots has been uploaded successfully');
				redirect('superadmin/news/robots');
			}
			else
			{
				$this->session->set_flashdata('message',$res['error']);
				redirect('superadmin/news/robots');
			}
		}
	
		$this->load->view('superadmin/header');			
		$this->load->view('superadmin/robots',$data);
		$this->load->view('superadmin/footer');		
	}	
	public function getRobots()
	{
		$path = $this->news_model->path_robots;
		//$path = "/path/to/my/dir"; 

		$latest_ctime = 0;
		$latest_filename = '';    

		$d = dir($path);
		while (false !== ($entry = $d->read())) {
		  $filepath = "{$path}/{$entry}";
		  // could do also other checks than just checking whether the entry is a file
		  if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
			$latest_ctime = filectime($filepath);
			$latest_filename = $entry;
		  }
		}
		echo file_get_contents($path.$latest_filename);die;		
	}
}
?>
