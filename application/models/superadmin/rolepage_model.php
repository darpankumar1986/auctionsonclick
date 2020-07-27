<?php
class Rolepage_model extends CI_Model {
    
	private $path = 'public/uploads/category/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetRoleById($role_id)
	{
		$this->db->where('role_id',$role_id);
		$qry = $this->db->get('tbl_role');
		$res = $qry->result_array();
		return $res[0];
	}
	
	public function GetAllRoles()
	{
		if(isset($_GET['title']))
		{
			$search = $_GET['title'];
			$this->db->where("name like '%$search%' ");
		}
		$qry = $this->db->get('tbl_role');
		$res = $qry->result();
		return $res;
	}
	
	public function managerole($role_id)
	{
		$name = $this->input->post('name');
		$status = $this->input->post('status');		
		$jda_role = $this->input->post('jdarole');
		$date = date("Y-m-d H:i:s");
		
		$data = array(
					'name'=>$name,
					'status'=>$status,
					'indate'=>$date,
					'jda_role' => $jda_role
				);
		if($role_id>0)
		{
			$this->db->where('role_id',$role_id);
			$this->db->update('tbl_role',$data);
		}
		else
		{
			$this->db->insert('tbl_role',$data);
			$role_id = $this->db->insert_id();
		}
		return $role_id;
	}
	
	public function GetPageById($page_id)
	{
		$this->db->where('role_page_id',$page_id);
		$qry = $this->db->get('tbl_role_page');
		$res = $qry->result_array();
		return $res[0];
	}
	
	public function GetAllPages()
	{
		if(isset($_GET['title']))
		{
			$search = $_GET['title'];
			$this->db->where("name like '%$search%' ");
		}
		$qry = $this->db->get('tbl_role_page');
		$res = $qry->result();
		return $res;
	}
	
	public function managepage($page_id)
	{
		$name = $this->input->post('name');
		$status = $this->input->post('status');		
		$link = $this->input->post('links');
		$is_show_menu = $this->input->post('is_show_menu');
		$order = $this->input->post('order');
		$date = date("Y-m-d H:i:s");
		
		$data = array(
					'name'=>$name,
					'status'=>$status,
					'in_date'=>$date,
					'link' => $link,
					'is_show_menu' => $is_show_menu,
					'order' => $order
				);
		if($page_id>0)
		{
			$this->db->where('role_page_id',$page_id);
			$this->db->update('tbl_role_page',$data);
		}
		else
		{
			$this->db->insert('tbl_role_page',$data);
			$page_id = $this->db->insert_id();
		}
		return $page_id;
	}
	
	
	public function GetRolePages($role_id)
	{
		$this->db->select('group_concat(role_page_id) as pages');
		$this->db->where('role_id',$role_id);
		$this->db->where('status',1);
		$qry = $this->db->get('tbl_role_page_permission');
		$res = $qry->result_array();
		return $res[0]['pages'];
	}
	
	public function GetAllRolePages()
	{
		if(isset($_GET['title']))
		{
			$search = $_GET['title'];
			$this->db->where("role_id like '%$search%' ");
		}
		$qry = $this->db->get('tbl_role_page_permission');
		$res = $qry->result();
		return $res;
	}
	
	public function managerolepage($rolepage_id)
	{
		$pages = $this->input->post('pages');
		$role_id = $this->input->post('role_id');
		
		$date = date("Y-m-d H:i:s");
		$this->db->where('role_id',$role_id);
		$this->db->update('tbl_role_page_permission',array("status"=>0));
		foreach($pages as $page)
		{
		
			$this->db->where('role_id',$role_id);
			$this->db->where('role_page_id',$page);
			$q = $this->db->get('tbl_role_page_permission');
			
			if($q->num_rows() > 0)
			{
				$this->db->where('role_id',$role_id);
				$this->db->where('role_page_id',$page);
				$this->db->update('tbl_role_page_permission',array("status"=>1));
			}
			else
			{
				$data = array(
						'role_page_id'=>$page,
						'status'=>1,
						'in_date'=>$date,
						'role_id' => $role_id,
					);
				$this->db->insert('tbl_role_page_permission',$data);
				$rolepage_id = $this->db->insert_id();
			}
		}
		return $rolepage_id;
	}
}
