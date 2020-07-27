<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/article_model');
		$this->load->model('superadmin/category_model');
		$this->load->model('superadmin/author_model');
		$this->load->model('superadmin/location_model');
		$this->load->model('superadmin/publication_model');
	  $this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	public function page($page_no)
	{
		$data['heading']='Article'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		
		//search query start//
		$search['category_id'] 	= $this->input->post('category_id'); 
		$search['sub_category_id'] 	= $this->input->post('sub_category_id');
		$search['status'] 		= $this->input->post('status');
		$search['month'] 		= $this->input->post('month');
		$search['home_page'] 	= $this->input->post('home_page');
		$search['carousel'] 	= $this->input->post('carousel');
		$search['year'] 		= $this->input->post('year');
		$data['search'] = $search;
		//serach query ends//
		
		$category = $this->category_model->GetParentRecordsControl();
		$categorywdchild = array();
		foreach($category as $catg){
			$catg->child = $this->category_model->GetChildRecords($catg->id);
			$categorywdchild[] = $catg;
		}
		
		
		$data['category'] = $categorywdchild;
		
		$per_page=10;
		$total_record	= $this->article_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/article/index';
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
			
		$offset = ($limit) ? $limit : 0;
		
		$array_records = $this->article_model->GetRecords($offset,$per_page);
		
		$data['records'] = $array_records; 
		$this->load->view('superadmin/article', $data);
		$this->load->view('superadmin/footer');
	}

	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit article'; 
			$article_id = $param;
		}else{
			$data['heading']='Add article'; 
		}
		
		if($article_id){
			$array_records = $this->article_model->GetRecordById($article_id);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records; 
		
		$category = $this->category_model->GetParentRecordsControl();
		
		$data['category'] = $category;
		
		//category parent id
		$parent_id = $this->db->query("select parent_id from tbl_category where id = '".$array_records->category_id."'")->row()->parent_id;
		$data['parent_id'] = $parent_id;
		if($parent_id != 0){
			$sub_category = $this->category_model->GetChildRecordsControl($parent_id);
			$data['sub_category'] = $sub_category;
		}
		
		$authors = $this->author_model->GetRecordsControl();
		$data['authors'] = $authors;
		$data['gauthors']=$this->author_model->GetRecordsGuest();
		
		$publications = $this->publication_model->GetRecordsControl();
		$data['publications'] = $publications;
		
		$locations = $this->location_model->GetRecordsControl();
		$data['locations'] = $locations;
				
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-article', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			redirect('superadmin/article/addedit');
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->article_model->upload1('image');	
			}else{
				$image=$this->input->post('image_old');
			}
			
			$save = $this->article_model->save_article_data($image);
			
			if($save){
				redirect('superadmin/article');
			}else{
				
			}
		}	
	}	
}
?>
