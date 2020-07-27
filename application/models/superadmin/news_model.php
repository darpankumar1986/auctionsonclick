<?php
class News_model extends CI_Model {
    private $path = 'public/uploads/news_blog/';
    public $path_robots = 'public/uploads/robots/';
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
    
    public function GetHomePageRecords($type) {
		$this->db->where('status !=', 5);
		$this->db->where('category', $type); //home
		$this->db->where('bank_id', 0);  //for Homepage
	    $query = $this->db->get("tbl_news_blog");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '0';
    }
    
    public function GetBankHeaderRecords($id) {
		$this->db->where('status !=', 5);
		$this->db->where('category', 'bank_header'); //Bank
		$this->db->where('bank_id', $id);  //for bank
	    $query = $this->db->get("tbl_news_blog");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '0';
    }
    
    public function GetBankSliderRecords($id) {
		$this->db->where('status !=', 5);
		$this->db->where('category', 'bank_slider'); //Bank
		$this->db->where('bank_id', $id);  //for bank
	    $query = $this->db->get("tbl_news_blog");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '0';
    }
    
    
    public function banklist($type) {
		$this->db->where('status !=', 5);
	    $query = $this->db->get("tbl_bank");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '0';
    }
    
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_news_blog");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetBankNameById($id) {
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_bank");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $name = $row->name;
            }
            return $name;
        }
        return false;
    }
	
		
	
	public function addEditRecords()
	{		
		$category = 'home';
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$status = $this->input->post('status');
		$bank_id = "0"; // URL
		$priority=$this->input->post('priority'); // URL
		$curr_date = date('Y-m-d H:i:s');
		$publish_date = $curr_date;
		$data = array('category'=>$category ,
				'bank_id'=>$bank_id ,
				'title'=>$title ,
				'priority'=>$priority,	
				'publish_date'=>$publish_date,	
				'status'=>$status
				);
		if($id)			
		{	
			//$slug=GetSlugTitle($title,$id);
			$data['updated_date']=$curr_date;
			$this->db->where('id', $id);
			$this->db->update('tbl_news_blog', $data); 
		}
		else
		{
			$data['indate']=$curr_date;
			$this->db->insert('tbl_news_blog',$data);
			$id=$this->db->insert_id();
			//$slug=GetSlugTitle($title,$id);
			$this->db->where('id', $id);
			$this->db->update('tbl_news_blog', array('slug'=>$slug)); 
		}
		return true;
	}
	
	public function addedithomeheaderSave($image=null) 
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$status = $this->input->post('status');	
		$url = $this->input->post('url');	
		
		$data = array(
					'title'=>$name,
					'image'=>$image,
					'content'=>$url,
					'bank_id'=>'0',
					'category'=>'home_header',
					'status' =>$status
				);
        if($id)			
		{
			$data['updated_date']=date('Y-m-d H:i:s');		
			$this->db->where('id', $id);
			$this->db->update('tbl_news_blog', $data); 
		}
		else
		{			
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_news_blog',$data); 
			$id = $this->db->insert_id();

		}
		return true;
	}
	
	public function addeditbankheaderSave($image=null,$bankId='') 
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$status = $this->input->post('status');	
		$url = $this->input->post('url');	
		
		$data = array(
					'title'=>$name,
					'image'=>$image,
					'content'=>$url,
					'bank_id'=>$bankId,
					'category'=>'bank_header',
					'status' =>$status
				);
        if($id)			
		{
			$data['updated_date']=date('Y-m-d H:i:s');		
			$this->db->where('id', $id);
			$this->db->update('tbl_news_blog', $data); 
		}
		else
		{			
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_news_blog',$data); 
			$id = $this->db->insert_id();

		}
		return true;
	}
	
	
	public function addeditbankSliderSave($image=null,$bankId='') 
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$status = $this->input->post('status');	
		$url = $this->input->post('url');	
		
		$data = array(
					'title'=>$name,
					'image'=>$image,
					'content'=>$url,
					'bank_id'=>$bankId,
					'category'=>'bank_slider',
					'status' =>$status
				);
        if($id)			
		{
			$data['updated_date']=date('Y-m-d H:i:s');		
			$this->db->where('id', $id);
			$this->db->update('tbl_news_blog', $data); 
		}
		else
		{			
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_news_blog',$data); 
			$id = $this->db->insert_id();

		}
		return true;
	}
	
	public function addedithomesliderSave($image=null) 
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$status = $this->input->post('status');	
		$priority = $this->input->post('order');	
		$url = $this->input->post('url');	
		
		$data = array(
					'title'=>$name,
					'image'=>$image,
					'content'=>$url,
					'priority'=>$priority,
					'bank_id'=>'0',
					'category'=>'home_slider',
					'status' =>$status
				);
        if($id)			
		{
			$data['updated_date']=date('Y-m-d H:i:s');		
			$this->db->where('id', $id);
			$this->db->update('tbl_news_blog', $data); 
		}
		else
		{			
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_news_blog',$data); 
			$id = $this->db->insert_id();

		}
		return true;
	}
	
	function upload_banner($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '5120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		//$config['max_width']  = '105';
		//$config['max_height']  = '100';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
			echo '<script>alert("'.$this->upload->display_errors().'")</script>';
		}else{
			$upload_data = $this->upload->data();
			if($upload_data['file_name'])
			return '/'.$this->path.$upload_data['file_name'];
			
			return false;
		}							
	}
	function upload_robots($fieldname)
	{
		$config['upload_path'] = $this->path_robots;
		if (!is_dir($this->path_robots))
		{
			mkdir($this->path_robots, 0777);
		}
		$config['allowed_types'] = 'txt';
		$config['max_size'] = '5120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}else{
			$upload_data = $this->upload->data();
			if($upload_data['file_name'])
				return "";
		}							
	}
	
	function upload_image($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '5120';
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
			if($upload_data['file_name'])
			return $this->path.$upload_data['file_name'];
			else 
            return false;			
		}							
	}
}
