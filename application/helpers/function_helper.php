<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('GetSlug'))
{
	function GetSlug($name, $id){		
		//$clean=Translate($name);
		
		$slug = url_title($name, '-', TRUE);
		$slug = $id.'-'.$slug;
		return $slug;
	}
}

if(!function_exists('remove_http'))
{
	function remove_http($url) {
	   $disallowed = array('http://', 'https://');
	   foreach($disallowed as $d) {
		  if(strpos($url, $d) === 0) {
			 return str_replace($d, '', $url);
		  }
	   }
	   return $url;
	}
}


if (!function_exists('createURL'))
{
	$curr_url='';
	function createURL($array){		
		foreach($array as $key=>$value)
		{
		$curr_url.=$value.'/';
		}
		
		return base_url($curr_url);
	}
} 
if (!function_exists('GetSlugTitle'))
{
	function GetSlugTitle($name, $id){		
		//$clean=Translate($name);
		
		$slug = url_title($name, '-', TRUE);
		$slug = $id.'-'.$slug;
		return $slug;
	}
} 

if (!function_exists('GetSlugnew'))
{
	function GetSlugnew($name, $id, $table, $inc=0){
		$clean = Translate($name);
		$slug = url_title($clean, 'dash', TRUE);
		
		if($inc > 0)
		$slug = $slug.'-'.$inc;
		
		$CI =& get_instance();
		$CI->load->database();
		$query = $CI->db->query("SELECT slug FROM ".$table." where slug = '$slug' and id != '$id' ");
		//echo $CI->db->last_query();
		if ($query->num_rows() > 0) {
			$inc++;
			$slug = GetSlugnew($name, $id, $table, $inc);
		}
		return $slug; 
	}
}

if(!function_exists('GetUrl')){
    function GetUrl($slug1='', $slug2=''){
            if($slug1!='' && $slug2='')
                    $url=base_url().$slug1;
            if($slug1!='' && $slug2!='')
                    $url=base_url().$slug1.'/'.$slug2;
            return $url;
    }
}


if (!function_exists('GetStatus')){
	function GetStatus($val){
		$status = '';
		switch($val)
		{
			case 1:
			$status = '<span class="active">Active</span>';
			break;
			case 0:
			$status = '<span class="inactive">Inactive</span>';
			break;
			case 5:
			$status = '<span class="deleted">Deleted</span>';
			break;
			default:
			$status = '<span class="active">Active</span>';
		}
		return $status;
	}
}

if (!function_exists('GetDateFormat'))
{
	function GetDateFormat($date){
		if($date){
			return strtoupper(date("M d \, Y", strtotime($date)));
		}
		else{
			return '-';
		}
	}
}

if (!function_exists('GetDateTimeFormat'))
{
	function GetDateTimeFormat($date){
		if(strpos($date, '0000-00-00') === false){
			return strtoupper(date("M d \, Y H:i a", strtotime($date)));
		}
		else{
			return '-';
		}
		
	}
}

if (!function_exists('GetTitleById'))
{
	function GetTitleById($table, $id, $column = 'name'){
		$CI =& get_instance();
		$CI->load->database();
		$query = $CI->db->query("SELECT $column FROM $table where id = '$id' LIMIT 1");
		$row = $query->row();
		return $row->$column;
	}
}

if (!function_exists('GetTitleByField'))
{
	function GetTitleByField($table, $condition, $column = 'name'){
		$CI =& get_instance();
		$CI->load->database();
		$query = @$CI->db->query("SELECT $column FROM $table where $condition LIMIT 1");
		$row = $query->row();
		return $row->$column;
	}
}

if (!function_exists('SetPriority'))
{
	function SetPriority($table, $where = '', $column = 'priority'){
		$CI =& get_instance();
		$CI->load->database();
		
		$query = $CI->db->query("SELECT max($column) as max_priority FROM $table where 1=1 $where");
		$row = $query->row();
		return $row->max_priority+1;
	}
}




function curl($url,$params = array(),$is_coockie_set = false)
{

if(!$is_coockie_set){
/* STEP 1. let’s create a cookie file */
$ckfile = tempnam ("/tmp", "CURLCOOKIE");

/* STEP 2. visit the homepage to set the cookie properly */
$ch = curl_init ($url);
curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
}

$str = ''; $str_arr= array();
foreach($params as $key => $value)
{
$str_arr[] = urlencode($key)."=".urlencode($value);
}
if(!empty($str_arr))
$str = '?'.implode('&',$str_arr);

/* STEP 3. visit cookiepage.php */

$Url = $url.$str;

$ch = curl_init ($Url);
curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec ($ch);
return $output;
}

function Translate($word, $conversion = 'hi_to_en')
{
	$word = urlencode($word);

	if($conversion == 'en_to_hi')
	$url = 'http://translate.google.com/translate_a/t?client=t&text='.$word.'&tl=hi&ie=UTF-8&oe=UTF-8&multires=0&otf=1&ssel=3&tsel=3&sc=1';
	
	else if($conversion == 'hi_to_en')
	$url = 'http://translate.google.com/translate_a/t?client=t&text='.$word.'&tl=en&ie=UTF-8&oe=UTF-8&multires=0&otf=1&ssel=3&tsel=3&sc=1';

	$response = curl($url);
	
	$response = str_replace("[","",$response);
	$response = str_replace("]","",$response);
	$response = "[".preg_replace('/,+/', ',', $response)."]";
	
	$name_en = json_decode($response);
	
	
	$trans_str = $name_en[0];
	
	if($trans_str == ''){
		$trans_str = $name_en[1];
	}
	
	if($trans_str == ''){
		$trans_str = $word;
	}
	
	//echo $trans_str;
	
	return $trans_str;
}

if (!function_exists('getCatSubcatTitle'))
{
	function getCatSubcatTitle($id){
		$CI =& get_instance();
		$CI->load->database();
		
		$query = $CI->db->query("SELECT id, parent_id, name FROM tbl_category where id = '$id' LIMIT 1");
		$row = $query->row();
		if(($row->parent_id) != 0){
			$query1 = $CI->db->query("SELECT name FROM tbl_category where id = '$row->parent_id' LIMIT 1");
			$row1 = $query1->row();
			$parent_name=$row1->name;			
		}
		if($parent_name)
			return $parent_name." &rarr; ".$row->name;
		else
			return $row->name;
	}
}

if (!function_exists('redirect404'))
{
	function redirect404(){
		ob_start();
		header("Location: /error", TRUE, 301);
		exit;
	}
}

if ( ! function_exists('get_random_password'))
{
    /**
     * Generate a random password. 
     * 
     * get_random_password() will return a random password with length 6-8 of lowercase letters only.
     *
     * @access    public
     * @param    $chars_min the minimum length of password (optional, default 6)
     * @param    $chars_max the maximum length of password (optional, default 8)
     * @param    $use_upper_case boolean use upper case for letters, means stronger password (optional, default false)
     * @param    $include_numbers boolean include numbers, means stronger password (optional, default false)
     * @param    $include_special_chars include special characters, means stronger password (optional, default false)
     *
     * @return    string containing a random password 
     */    
    function get_random_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=true, $include_special_chars=false)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                

      return $password;
    }

}


if ( ! function_exists('getAmountInWords'))
{
function getAmountInWords($input)
		{
			
			$numArr=explode('.',$input);
			$numArr=
			$input=$numArr[0];
			$paise=$numArr[1];
			
				 $arr_name = array('1'=>'','','hundreds','thousand','lacs');
				 $arr_num = array('1'=>'One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen', 'Eighteen','NineTeen');
				 $arr_one =array('1'=>'One','Two','Three','Four','Five','Six','Seven','Eight','Nine');
				 $arr_tens =array('2'=>'Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety');
			 if(is_numeric($input))
			  { 
  				if(strlen($input)>9)
				 $moreDate = "input is more then 999999999";
				 $inputnew = $input;
				 $inputnew;
				 $arr_int  = str_split($inputnew);
				 $count  = count($arr_int);
				$ones =  (int)substr($input,-2);
				if($count > 2)
				 $hunderads =  (int)substr($input,-3,1);
				if($count > 3){
				if($count==4){
				$input;
				  $thousands =  (int)substr($input,-4,1);
				 }
				else{
				  $thousands =  (int)substr($input,-5,2);
				 }
				}
				if($count > 5){
				if($count==6)
				 $lacs =  (int)substr($input,-6,1);
				else
				 $lacs =  (int)substr($input,-7,2);
				}
				if($count > 7){
				if($count==8)
				 $cror =  (int)substr($input,-8,1);
				else
				 $cror =  (int)substr($input,-9,2);
				}
				//************************************************************************************************************************************
				if($cror<=19)
				{
				$cror = $arr_num[$cror];
				}	
				if($cror>19)
				{
				$onepart= (int)substr($cror,0,1);
				$secoundpart= (int)substr($cror,1,1);
				$cror = $arr_tens[$onepart]." ".$arr_one[$secoundpart];
				}
				//echo $cror."test";
				if($lacs<=19)
				{
				$lacs = $arr_num[$lacs];
				}
				$lacs;
				if($lacs>19)
				{
				$onepart=substr($lacs,0,1);
				$secoundpart=substr($lacs,1,1);
				$lacs = $arr_tens[$onepart]." ".$arr_one[$secoundpart];
				}

				if($thousands<=19)
				{
				$thousands = $arr_num[$thousands];
				}
				if($thousands>19)
				{
				$onepart=substr($thousands,0,1);
				$secoundpart=substr($thousands,1,1);
				$thousands = $arr_tens[$onepart]." ".$arr_one[$secoundpart];
				}
				
				if($hunderads<=19)
				{
				if($hunderads!=10)
				$hunderads = str_replace("0","", $hunderads);
				$hunderads = $arr_num[$hunderads];
				}
				if($hunderads>19)
				{
				$onepart=substr($hunderads,0,1);
				$secoundpart=substr($hunderads,1,1);
				$hunderads = $arr_tens[$onepart]." ".$arr_one[$secoundpart];
				}
				if($ones<=19)
				{
				if($ones!=10)
				$ones = str_replace("0","", $ones);
				$ones = $arr_num[$ones];
				}
				if($ones>19)
				{
				$onepart=substr($ones,0,1);
				$secoundpart=substr($ones,1,1);
				if($onepart!=0)
				$ones = $arr_tens[$onepart]." ".$arr_one[$secoundpart];
				else
				$ones = $arr_tens[$secoundpart];
				}
				//**********************************************************************************************************************
				if($cror!="")
				$Cror = "Crors";
				if($lacs!="")
				$lakh = "Lakh";
				if($thousands!="")
				$thoussn = "Thousand";
				if($hunderads!="")
				$hun = "hundred";
				$outPut = $cror." ".$Cror." ".$lacs." ".$lakh." ".$thousands." ".$thoussn." ".$hunderads." ".$hun." ".$ones;
				return $outPut."".$moreDate;
			 }
			 else 
			 {
			 	$outPut = "INPUT IS NOT NUMERIC";
			 	return $outPut;
			 }
		}
}

// For datatable listing 

if (!function_exists('auctionWithoutloggedEventDropDown'))
{
		function auctionWithoutloggedEventDropDown($bankID,$branchID,$eid){
		$CI =& get_instance();
		$CI->load->database();
		//Rupesh code 
		//$query1=$CI->db->query("SELECT id,reference_no FROM tbl_auction where bank_id = $bankID AND status=1 order by indate DESC");
		$query1=$CI->db->query("SELECT id,reference_no FROM tbl_auction where bank_id = $bankID AND  status=1 AND eventID =0 AND  auction_start_date >= CURDATE() order by indate DESC");
		$data = '';
		if ($query1->num_rows() > 0) {
			$data='<select onchange="fnLinkAuctionEventLogs($(this).val(),'.$eid.')"><option>Select</option>';
            foreach ($query1->result() as $row) {
				 $data.='<option value="'.$row->id.'">'.$row->reference_no.'-'.$row->id.'</option>';			
            }
			$data.='</select>';
           
        }else{
			$data='No Auction!';
		}
        echo  $data;
	}
}

if (!function_exists('findRemainTime'))
{
	function findRemainTime($event_date,$currenttime){
		if($currenttime!=''&& $event_date!='')
		{
			$date='';
			$now='' ;
			if($event_date>=$currenttime)
			{	
				$now = new DateTime($currenttime);
				$future_date = new DateTime($event_date);
				$interval = $future_date->diff($now);
				$days =$interval->format('%d');
				$hours =$interval->format('%h');
				$minute =$interval->format('%i');
				$second =$interval->format('%s');
				$remainTime=array();
				$remainTimeArr['days']=$days;
				$remainTimeArr['hours']=$hours;
				$remainTimeArr['minute']=$minute;
				$remainTimeArr['second']=$second;
				$date=$remainTimeArr;
			}else{
				$remainTimeArr['days']=0;
				$remainTimeArr['hours']=0;
				$remainTimeArr['minute']=0;
				$remainTimeArr['second']=0;
				$date=$remainTimeArr;
			}
			
			//print_r($date);
			return $date;

		}
	}
}
	function getStaticContentsList(){
		$CI =& get_instance();
		$CI->load->database();
		$CI->db->where('status', 1);
        $CI->db->from("tbl_webpage");
        $query = $CI->db->get();
        if ($query->num_rows() > 0) {
            $data = array();
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else{
			$data=0;
			return $data;
		}
    }
function checkfavoriteAuctionExist($userid,$pid){
		$CI =& get_instance();
		$CI->load->database();
		$CI->db->where('user_id',$userid);
		$CI->db->where('product_id',$pid);
        $CI->db->from("tbl_user_favorites");
		$query = $CI->db->get();
		$CI->db->last_query();
		$total=$query->num_rows();
		if($total>0)
							{
								$cls='ac-fav';
							}else{
								$cls="";
							}	
		return $cls;
}
	
function showsocialSharingIcon($product_id){
	$data="<a title='Share On facebook' href=\"https://www.facebook.com/sharer/sharer.php?u=".base_url()."property/detail/$product_id\" onclick=\"javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"/images/icon-fb.png\"></a>
	<a title='Share on Twitter' href=\"https://twitter.com/intent/tweet?text=".base_url()."property/detail/$product_id\" onclick=\"javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"/images/icon-tw.png\"></a>
	<a title=\"Share on Google+\" href=\"https://plus.google.com/share?url=".base_url()."property/detail/$product_id\" onclick=\"javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"/images/icon-gp.png\"></a>";
	echo $data;
}
function checkloginUserstatus($userid,$type){
		$CI =& get_instance();
		$CI->load->database();
		$CI->db->where('id',$userid);
		$CI->db->where('status !=',1);
		if($type=='user'){
			$CI->db->from("tbl_user_registration");
		}else{
			$CI->db->from("tbl_user");
		}
		$query = $CI->db->get();
		$total=$query->num_rows();
		if($total>0)
		{
			redirect(base_url().'/registration/logout');
		}			
					
							
}

if (!function_exists('checkHTMLTags'))
{
	function checkHTMLTags($string)
    {
		if($string != strip_tags($string)) 
		{
			// contains HTML
			return '1';
		}
		else
		{
			return '0';	
		}
	}
}

if (!function_exists('checkMultipleExtension'))
{
	function checkMultipleExtension($filename=null) 
	{
		$strArray = count_chars($filename,1);

		foreach ($strArray as $dotkey=>$dotCountVal)
		  {
			  if(chr($dotkey) == '.')
			  {
				$dotCountValue[] = $dotCountVal;
			  }
		  }	
		  if($dotCountValue[0] > 1)
		  {
			return 'mul';
		  }else{

					if($dotCountValue[0] == '1')
						  {
							  $getFileExt = explode('.',$filename);
							  $getFileExt = $getFileExt[1];
							  $allowed =  array('gif','png' ,'jpg','jpeg','xls','doc','docx','zip','pdf');
							  if(!in_array($getFileExt,$allowed) ) 
								{
									 return 'mul';
								}
								
						  }
					
					return 'sin';
		   }		
		  return 'sin';
	}
}
if(!function_exists('moneyFormatIndia'))
{
	function moneyFormatIndia($num){
        $nums = explode(".",$num);
        if(count($nums)>2){
            return "0";
        }else{
        if(count($nums)==1){
            $nums[1]="00";
        }
        $num = $nums[0];
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; 
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){

                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].","; 
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash.".".$nums[1]; 
        }
    }
}
if (!function_exists('GetAllData'))
{
	function GetAllData($column = 'name', $table, $where){
		$CI =& get_instance();
		$CI->load->database();
		//echo "SELECT $column FROM $table where 1=1 and $where";die;
		$query = $CI->db->query("SELECT $column FROM $table where 1=1 and $where");
		
		$result = $query->result_array();
		return $result;
	}
}
