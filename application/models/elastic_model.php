<?php
class Elastic_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->database();        
    }
    
    function property($auction_id=0)
    {
		if(ELASTICSEARCH_STATUS == 'ON')
		{
			$this->load->library('Elasticsearch');		
			$elasticSearch = new Elasticsearch();
			$elasticSearch->index = 'c1prop';
			$elasticSearch->type = 'propertydata';
			
			//$this->db->where('approvalStatus',2);
			if($auction_id>0)
			{	
				//$this->db->where('status',1);			
				$this->db->where('id',$auction_id);					
			}
			else
			{
				$page = 0;
				if($page == 0)
				{
					$res = $elasticSearch->delete('');
				}
				$this->db->limit(10,$page*10);
				$this->db->where('status',1);	
			}
			$query = $this->db->get('tbl_auction');
			
			$isAdd = false;
			$data = null;
			
			
			//echo $query->num_rows();die;
			if($query->num_rows()>0)
			{
				foreach ($query->result() as $row)
				{
					
				
					$res = $elasticSearch->delete($row->id);
						


					$search_word_arr = array("search"=>$row->PropertyDescription,"auction_id"=>$row->id,"category_id"=>$row->category_id,"type"=>"property");					

					$isAdd = true;
					$data = $row;	

					$res = $elasticSearch->add(str_replace(" ","_",$search_word_arr['auction_id']),json_encode($search_word_arr));
					//print_r($res);die;
				} 
			}
			/*else
			{
					$this->session->set_flashdata('msg','All Product has been updated Successfully in elasticseach plugin');						  
					redirect('admin/elasticsearch');	
			}*/				
		}
		return true;
	}	
	
	
}
