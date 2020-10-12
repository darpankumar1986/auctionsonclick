<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auctionapi extends WS_Controller
{	
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
	}	
	

		
	public function getAuctionList($auction_id = 0)
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/

		if($auction_id > 0)
		{
			$this->db->where('a.id',$auction_id);
		}
		else
		{

			$this->db->where('a.status IN(1)');

			if($_GET['date'] == '')
			{
				$this->db->where("a.indate >= '".date('Y-m-d 00:00:00')."'");	
				$this->db->where("a.indate <= '".date('Y-m-d 23:59:59')."'");
			}
			else
			{
				$this->db->where("a.indate >= '".$_GET['date']." 00:00:00'");
				$this->db->where("a.indate <= '".$_GET['date']." 23:59:59'");
			}
		}


		
		$this->db->select('a.id,a.bank_id,a.branch_id,a.event_type,a.category_id,a.subcategory_id,a.event_title,p.product_description,a.borrower_name,a.countryID,a.state,a.city,a.reserve_price,a.emd_amt,a.bid_last_date,a.auction_start_date,a.auction_end_date,a.related_doc,a.supporting_doc,u.mobile_no as c_mobile_no,u.first_name as c_first_name,u.last_name as c_last_name');
		
		$this->db->join("tbl_product as p","p.id = a.productID","left");
		$this->db->join("tbl_user as u","u.id = a.first_opener","left");
		$query1 = $this->db->get('tbl_auction as a');

		$data = $query1->result();

		echo $myJSON = json_encode($data);
	}

	public function getBankList($bank_id = 0)
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/

		if($bank_id > 0)
		{
			$this->db->where('id > ',$bank_id);
		}
		
		$query1 = $this->db->get('tbl_bank');

		$data = $query1->result();

		echo $myJSON = json_encode($data);
	}

	public function getBranchList($branch_id = 0)
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/

		if($branch_id > 0)
		{
			$this->db->where('id > ',$branch_id);
		}
		
		$query1 = $this->db->get('tbl_branch');

		$data = $query1->result();

		echo $myJSON = json_encode($data);
	}

	public function getCityList($city_id = 0)
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/

		if($city_id > 0)
		{
			$this->db->where('id > ',$city_id);
		}
		
		$query1 = $this->db->get('tbl_city');

		$data = $query1->result();

		echo $myJSON = json_encode($data);
	}

	public function getCategoryList($category_id = 0)
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/

		if($category_id > 0)
		{
			$this->db->where('id > ',$category_id);
		}
		
		$query1 = $this->db->get('tbl_category');

		$data = $query1->result();

		echo $myJSON = json_encode($data);
	}
}
?>
