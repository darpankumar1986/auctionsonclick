// JavaScript Document
/*Top Most Filteration Slider*/
$(document).ready(function() {	
showWidght();


$(".showformpan").click(function(){
	var attids=$(this).attr('id');
	if(attids=='pan_numberid'){
			$("#pan-no_data").show();
			$("#form_16-data").hide();
	}else if(attids=='form_16id'){
			$("#form_16-data").show();
			$("#pan-no_data").hide();		
	}
});

$(".slidesearch").click(function () {
 
 //alert("adfasfsfdsfa");
    // Set the effect type
    var effect = 'slide';
 
    // Set the options for the effect type chosen
    var options = { direction: 'right' };
    // Set the duration (default: 400 milliseconds)
    var duration = 7000;
    $('.banner_search').toggle(effect, options, duration);
});


  /*  $("#propertySearchRent").keyup(function(){
		//alert("adsfadsfdsa");
    var searchtxt = $("#propertySearchRent").val().trim();  
    if(searchtxt!='') // If Not Empty   
        {  
		  $.ajax({
              url:  "/property/searchcity",
              type: "post",
              data: "searchtxt="+searchtxt,
              success: function(results){
				  alert(results);
				 $("#resultpropertySearchRent").css('display','block');
				 $("#resultpropertySearchRent").html(results); 
              }
            });
        }else{  
        $("#resultpropertySearchRent").html('');       
        }  
    });*/	
});

function fillme(value)  
{ 
var div_id = $('#fbresult').parents('div').attr('id');
if(div_id == 'resultpropertySearch'){
$("#propertySearch").val(value);   
$("#resultpropertySearch").show();
$("#resultpropertySearch").html('');
	
} else if(div_id == 'resultpropertySearchRent') {
$("#propertySearchRent").val(value);   
$("#resultpropertySearchRent").show();
$("#resultpropertySearchRent").html('');
}
 processform();  
} 
function submit_search_form(){
	$("#advance_search").submit();
}
	function ajaxFormdata(category_id,productid){
		if(category_id)
		{
			jQuery('#ajaxFormData').load('/helpdesk_executive/ajaxFormData/'+category_id+'/'+productid);
		}
	}
	
	function ajaxFormdatabanker(category_id,productid){
		if(category_id)
		{
			$('#ajaxFormData').load('/banker/ajaxFormData/'+category_id+'/'+productid);
		}
	}
	
	function ajaxFormdata_nonBanker(category_id,isauction,sele_rent,productid){
		if(category_id)
		{
			//alert("ffffffffffffff0000");
			if(isauction==1){
				isauction='auction';	
			}else{
				isauction='non-auction';
			}
			$('#ajaxFormData').load('/owner/ajaxFormData/'+category_id+'/'+isauction+'/'+sele_rent+'/'+productid);
		}
	}
/*video question process end*/
function validateSubmitform(btn) { //alert("yuiuyuiyuiuy");
    $('#spMsg').html("");
	flag=''; 
	if (btn == "save") {
		
	  if ($('#rdoEventDRT').is(':checked') == false && $('#rdoEventSRFAESI').is(':checked') == false) {
            $('#spMsg').append("<li>Please Select Account. </li>");
            flag = 1;
        }
		if ($('#reference_no').val() == '') {
            $('#spMsg').append("<li>Please Enter NIT Ref. No. </li>");
            flag = 1;
        }
		if ($('#event_title').val() == '') {
			$('#spMsg').append("<li>Please Enter Tender Title </li>");
			flag = 1;
		}
		if(flag == 1){
			//alert("-------"+flag);
			$("#showerror_msg").show();
			$(".inline").colorbox({inline:true, width:"50%"});
			$(".inline").click();
			return false;
		}	
		return true;
	}else{
		
		if ($('#rdoEventDRT').is(':checked') == false && $('#rdoEventSRFAESI').is(':checked') == false) {
            $('#spMsg').append("<li>Please Select Account. </li>");
            flag = 1;
        }
		if ($('#reference_no').val() == '') {
            $('#spMsg').append("<li>Please Enter NIT Ref. No. </li>");
            flag = 1;
        }
		if ($('#event_title').val() == '') {
			$('#spMsg').append("<li>Please Enter Tender Title </li>");
			flag = 1;
		}
		/*
		if ($('#category_id').val() == '') {
			$('#spMsg').append("<li>Please Select Category of item to be auctioned </li>");
			flag = 1;
		}
		if ($('#subcategory_id').val() == '') {
			$('#spMsg').append("<li>Please Select Sub Category </li>");
			flag = 1;
		}*/
		if ($('#borrower_name').val() == '') {
			$('#spMsg').append("<li>Please Enter Borrower Name </li>");
			flag = 1;
		}
		if ($('#invoice_mail_to').val() == '') {
			$('#spMsg').append("<li>Please Select Kind Attention User for the Invoice Mailing</li>");
			flag = 1;
		}
		
		if ($('#reserve_price').val() == '') {
			$('#spMsg').append("<li>Please Enter Reserve Price</li>");
			flag = 1;
		}
		if (($('#reserve_price').val() == 0) && ($('#reserve_price').val() != '')) {
			$('#spMsg').append("<li>Reserve Price can not be zero</li>");
			flag = 1;
		}
		if ($('#emd_amt').val() == '') {
			$('#spMsg').append("<li>Please Enter Reserve Price</li>");
			flag = 1;
		}
		if (($('#emd_amt').val() == 0) && ($('#emd_amt').val() != '')) {
			$('#spMsg').append("<li>Reserve Price can not be zero</li>");
			flag = 1;
		}
		
		if( ($('#emd_amt').val() != '') &&  ($('#reserve_price').val() != '')){	
			if (parseFloat($('#reserve_price').val()) <= parseFloat($('#emd_amt').val())) {
				$('#spMsg').append("<li>Reserve Price should be greater than EMD Amount<li/>");
				flag = 1;
			}
		}
		
		if ($('#nodal_bank_name').val() == '') {
			$('#spMsg').append("<li>Please Select Nodal Bank Name </li>");
			flag = 1;
		}
		if ($('#nodal_bank_account').val() == '') {
			$('#spMsg').append("<li>Please Enter Nodal Bank account number </li>");
			flag = 1;
		}
		if ($('#branch_ifsc_code').val() == '') {
			$('#spMsg').append("<li>Please Enter Nodal Bank IFSC Code </li>");
			flag = 1;
		}
		
		
		if ($('#press_release_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Press Release Date</li>");
			flag = 1;
		}
		
		if ($('#bid_last_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Sealed Bid Submission Last Date</li>");
			flag = 1;
		}
		if (jQuery('#old_related_doc').val() == '' && jQuery('#related_doc').val() == '' ) {
			jQuery('#spMsg').append("<li>Please Select Related Document</li>");
			flag = 1;
		}
		if (jQuery('#old_image').val() == '' && jQuery('#image').val() == '') {
			jQuery('#spMsg').append("<li>Please Select Image</li>");
			flag = 1;
		}
		if ($('#bid_opening_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Sealed Bid Opening Date</li>");
			flag = 1;
		}
		
		if ($('#auction_start_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Auction Start date</li>");
			flag = 1;
		}
		
		if ($('#auction_end_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Auction End date</li>");
			flag = 1;
		}
		
		if ($('#bid_inc').val() == '') {
			$('#spMsg').append("<li>Please Enter Bid Increment value</li>");
			flag = 1;
		}
		
		if($('#old_related_doc').val()==''){
			if ($('#related_doc').val() == '') {
				$('#spMsg').append("<li>Please Upload Related Documents</li>");
				flag = 1;
			}
		}
		
		if($('#old_image').val()==''){
			if ($('#image').val() == '') {
				$('#spMsg').append("<li>Please Upload Image</li>");
				flag = 1;
			}
		}
				
		 var options = $('#doc_to_be_submitted > option:selected');
         if(options.length == 0){
             $('#spMsg').append("<li>Please Select Documents to be submitted</li>");
             flag = 1;
         }
			
		
			
		if(flag != 1){
			returnFlag	=	ValidateDate();
			if(returnFlag==1){
				$("#showerror_msg").show();
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".inline").click();
				return false;
			}else{
				//return false;	
				return true;	
			}
				
		}else{
			$("#showerror_msg").show();
			$(".inline").colorbox({inline:true, width:"50%"});
			$(".inline").click();
			return false;
		}
	}
	
return false;
   // return flag;
}
/*video question process end*/
function validateSubmitformNonBank(btn) {
    $('#spMsg').html("");
	flag='';

		
		if ($('#reference_no').val() == '') {
            $('#spMsg').append("<li>Please Enter NIT Ref. No. </li>");
            flag = 1;
        }
		if ($('#event_title').val() == '') {
			$('#spMsg').append("<li>Please Enter Tender Title </li>");
			flag = 1;
		}

		if ($('#borrower_name').val() == '') {
			$('#spMsg').append("<li>Please Enter Borrower Name </li>");
			flag = 1;
		}
		
		if ($('#reserve_price').val() == '') {
			$('#spMsg').append("<li>Please Enter Reserve Price</li>");
			flag = 1;
		}
		if (($('#reserve_price').val() == 0) && ($('#reserve_price').val() != '')) {
			$('#spMsg').append("<li>Reserve Price can not be zero</li>");
			flag = 1;
		}
	
		
		if ($('#press_release_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Press Release Date</li>");
			flag = 1;
		}
		
		if ($('#bid_last_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Sealed Bid Submission Last Date</li>");
			flag = 1;
		}
		
		if ($('#bid_opening_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Sealed Bid Opening Date</li>");
			flag = 1;
		}
		
		if ($('#auction_start_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Auction Start date</li>");
			flag = 1;
		}
		
		if ($('#auction_end_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Auction End date</li>");
			flag = 1;
		}
		
		if ($('#bid_inc').val() == '') {
			$('#spMsg').append("<li>Please Enter Bid Increment value</li>");
			flag = 1;
		}
		
		if($('#old_related_doc').val()==''){
			if ($('#related_doc').val() == '') {
				$('#spMsg').append("<li>Please Upload Related Documents</li>");
				flag = 1;
			}
		}
		
		if($('#old_image').val()==''){
			if ($('#image').val() == '') {
				$('#spMsg').append("<li>Please Upload Image</li>");
				flag = 1;
			}
		}
				
		 var options = $('#doc_to_be_submitted > option:selected');
         if(options.length == 0){
             $('#spMsg').append("<li>Please Select Documents to be submitted</li>");
             flag = 1;
         }
			
		
			
		if(flag != 1){
			returnFlag	=	ValidateDate();
			if(returnFlag==1){
				$("#showerror_msg").show();
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".inline").click();
				return false;
			}else{
				return true;	
			}
				
		}else{
			$("#showerror_msg").show();
			$(".inline").colorbox({inline:true, width:"50%"});
			$(".inline").click();
			return false;
		}
return false;
   // return flag;
}

function validateAdminformNonBank(btn) {
    $('#spMsg').html("");
	flag='';

		
		if ($('#reference_no').val() == '') {
            $('#spMsg').append("<li>Please Enter NIT Ref. No. </li>");
            flag = 1;
        }
		if ($('#event_title').val() == '') {
			$('#spMsg').append("<li>Please Enter Tender Title </li>");
			flag = 1;
		}
		/*
		if ($('#category_id').val() == '') {
			$('#spMsg').append("<li>Please Select Category of item to be auctioned </li>");
			flag = 1;
		}
		if ($('#subcategory_id').val() == '') {
			$('#spMsg').append("<li>Please Select Sub Category </li>");
			flag = 1;
		}*/
		if ($('#borrower_name').val() == '') {
			$('#spMsg').append("<li>Please Enter Borrower Name </li>");
			flag = 1;
		}
		
		if ($('#reserve_price').val() == '') {
			$('#spMsg').append("<li>Please Enter Reserve Price</li>");
			flag = 1;
		}
		if (($('#reserve_price').val() == 0) && ($('#reserve_price').val() != '')) {
			$('#spMsg').append("<li>Reserve Price can not be zero</li>");
			flag = 1;
		}
		/*
		if ($('#emd_amt').val() == '') {
			$('#spMsg').append("<li>Please Enter Reserve Price</li>");
			flag = 1;
		}
		if (($('#emd_amt').val() == 0) && ($('#emd_amt').val() != '')) {
			$('#spMsg').append("<li>Reserve Price can not be zero</li>");
			flag = 1;
		}
		
		if( ($('#emd_amt').val() != '') &&  ($('#reserve_price').val() != '')){	
			if (parseFloat($('#reserve_price').val()) <= parseFloat($('#emd_amt').val())) {
				$('#spMsg').append("<li>Reserve Price should be greater than EMD Amount<li/>");
				flag = 1;
			}
		}*/
		
		if ($('#press_release_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Press Release Date</li>");
			flag = 1;
		}
		
		if ($('#bid_last_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Sealed Bid Submission Last Date</li>");
			flag = 1;
		}
		
		if ($('#bid_opening_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Sealed Bid Opening Date</li>");
			flag = 1;
		}
		
		if ($('#auction_start_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Auction Start date</li>");
			flag = 1;
		}
		
		if ($('#auction_end_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Auction End date</li>");
			flag = 1;
		}
		
		if ($('#bid_inc').val() == '') {
			$('#spMsg').append("<li>Please Enter Bid Increment value</li>");
			flag = 1;
		}
		
		if($('#old_related_doc').val()==''){
			if ($('#related_doc').val() == '') {
				$('#spMsg').append("<li>Please Upload Related Documents</li>");
				flag = 1;
			}
		}
		
		if($('#old_image').val()==''){
			if ($('#image').val() == '') {
				$('#spMsg').append("<li>Please Upload Image</li>");
				flag = 1;
			}
		}
				
		 var options = $('#doc_to_be_submitted > option:selected');
         if(options.length == 0){
             $('#spMsg').append("<li>Please Select Documents to be submitted</li>");
             flag = 1;
         }
			
		
			
		if(flag != 1){
			returnFlag	=	ValidateDate();
			if(returnFlag==1){
				$("#showerror_msg").show();
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".inline").click();
				return false;
			}else{
				return true;	
			}
				
		}else{
			$("#showerror_msg").show();
			$(".inline").colorbox({inline:true, width:"50%"});
			$(".inline").click();
			return false;
		}
return false;
   // return flag;
}


function ValidateDate() {
var nitdate = "", FromInsdate = "", ToInsdate = "", offerdate = "", openingdate = "", starttime = "", endtime = "";	
var flag = '';
	currdate 	 = $('#currdate').val()
var currdatetime = new Date(currdate);

	nitdate 		=	$('#press_release_date').val();
	FromInsdate 	=	$('#inspection_date_from').val();
	ToInsdate 		=	$('#inspection_date_to').val();
	offerdate 		=	$('#bid_last_date').val();
	openingdate 	=	$('#bid_opening_date').val();
	starttime 		=	$('#auction_start_date').val();
	endtime 		=	$('#auction_end_date').val();
	
	nitdate				= nitdate.replace(/-/g, '/');
	FromInsdate			= FromInsdate.replace(/-/g, '/');
	ToInsdate			= ToInsdate.replace(/-/g, '/');
	offerdate			= offerdate.replace(/-/g, '/');
	openingdate			= openingdate.replace(/-/g, '/');
	starttime			= starttime.replace(/-/g, '/');
	endtime				= endtime.replace(/-/g, '/');
	
	if (nitdate != ''){
		 nitdate = new Date(nitdate); 
		if (nitdate > currdatetime) {
        $('#spMsg').append("<li>Press Release Date or time should be less than current date or time !! <li/>");
        flag = 1;
		}	 
	}   
	if (FromInsdate != ''){
		 FromInsdate = new Date(FromInsdate); 
	}
	if (ToInsdate != ''){
		 ToInsdate = new Date(ToInsdate); 
	}
	if (offerdate != ''){
		 offerdate = new Date(offerdate); 
	}
	if (openingdate != ''){
		 openingdate = new Date(openingdate); 
	}
	if (starttime != ''){
		 starttime = new Date(starttime); 
	}
	if (endtime != ''){
		 endtime = new Date(endtime); 
	}	  	
	
	if (offerdate <= currdatetime) {
        $('#spMsg').append("<li>Offer Submission last date or time should be greater than current date or time !! <li/>");
        flag = 1;
    }
    if (openingdate <= currdatetime) {
        $('#spMsg').append("<li>Opening date or time should be greater than current date or  time !! <li/>");
        flag = 1;
    }
    if (starttime <= currdatetime) {
        $('#spMsg').append("<li>Auction date or time should be greater than current date or time !! <li/>");
        flag = 1;
    }
    if (endtime != "") {
        if (starttime >= endtime) {
            $('#spMsg').append("<li>Auction End date should be greater than Auction Start date or time !! <li/>");
            flag = 1;
        }

    }
	
	if(flag != 1){
		if (openingdate <= offerdate) {
				$('#spMsg').append("Opening date or time should be greater than Offer submission last date or time !! <br/>");
				flag = 1;
			}
		if (starttime <= openingdate) {
				$('#spMsg').append("Auction Start date and time should be greater than Opening date or time !! <br/>");
				flag = 1;
			}
	}
return flag;
}
function CoriValidateDate() {
var nitdate = "", FromInsdate = "", ToInsdate = "", offerdate = "", openingdate = "", starttime = "", endtime = "";	
var flag = '';

var currdatetime = new Date($('#currdate').val());
	nitdate 		=	$('#press_release_date').val();
	FromInsdate 	=	$('#inspection_date_from').val();
	ToInsdate 		=	$('#inspection_date_to').val();
	offerdate 		=	$('#bid_last_date').val();
	openingdate 	=	$('#bid_opening_date').val();
	starttime 		=	$('#auction_start_date').val();
	endtime 		=	$('#auction_end_date').val();
	
	nitdate				= nitdate.replace(/-/g, '/');
	FromInsdate			= FromInsdate.replace(/-/g, '/');
	ToInsdate			= ToInsdate.replace(/-/g, '/');
	offerdate			= offerdate.replace(/-/g, '/');
	openingdate			= openingdate.replace(/-/g, '/');
	starttime			= starttime.replace(/-/g, '/');
	endtime				= endtime.replace(/-/g, '/');

	if (nitdate != ''){
		 nitdate = new Date(nitdate); 
	} 
	
	if (FromInsdate != ''){
		 FromInsdate = new Date(FromInsdate); 
	}
	if (ToInsdate != ''){
		 ToInsdate = new Date(ToInsdate); 
	}
	if (offerdate != ''){
		 offerdate = new Date(offerdate); 
	}
	if (openingdate != ''){
		 openingdate = new Date(openingdate); 
	}
	if (starttime != ''){
		 starttime = new Date(starttime); 
	}
	if (endtime != ''){
		 endtime = new Date(endtime); 
	}	  
	

	 if(offerdate!=''){
		if (offerdate <= currdatetime && $('#bid_last_date').prop('disabled')==false) {
			$('#spMsg').append("<li>Offer Submission last date or time should be greater than current date or time !! <li/>");
			flag = 1;
		}
	 }
	if(openingdate!=''){ 
		if (openingdate <= currdatetime && $('#bid_opening_date').prop('disabled')==false) {
			$('#spMsg').append("<li>Opening date or time should be greater than current date or  time !! <li/>");
			flag = 1;
		}
	}
	if(starttime!=''){
		if (starttime <= currdatetime  && $('#auction_start_date').prop('disabled')==false) {
			$('#spMsg').append("<li>Auction date or time should be greater than current date or time !! <li/>");
			flag = 1;
		}
	}

    if (endtime != "") {
        if (starttime >= endtime  && $('#auction_end_date').prop('disabled')==false ) {
            $('#spMsg').append("<li>Auction End date should be greater than Auction Start date or time !! <li/>");
            flag = 1;
        }

    }
	
	if(flag != 1){
		
		if(openingdate!='' && offerdate!='' &&  $('#bid_opening_date').prop('disabled')==false  && $('#bid_last_date').prop('disabled')==false){
		if (openingdate <= offerdate ) {
				$('#spMsg').append("Opening date or time should be greater than Offer submission last date or time !! <br/>");
				flag = 1;
			}
		}
		if(starttime!='' && openingdate!=''  &&  $('#bid_opening_date').prop('disabled')==false && $('#auction_end_date').prop('disabled')==false ){
		if (starttime <= openingdate) {
				$('#spMsg').append("Auction Start date and time should be greater than Opening date or time !! <br/>");
				flag = 1;
			}
		}
	}
	
	return flag; 	   
}
function CorivalidateSubmitform() {
    $('#spMsg').html("");
	flag='';
		if ($('#remarks').val() == '') {
			$('#spMsg').append("<li>Please Enter remarks </li>");
			flag = 1;
		}

		if(flag != 1){
			returnFlag	=	CoriValidateDate();
			if(returnFlag==1){
				$("#showerror_msg").show();
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".inline").click();
				return false;
			}else{
				return true;	
			}
				
		}else{
			$("#showerror_msg").show();
			$(".inline").colorbox({inline:true, width:"50%"});
			$(".inline").click();
			return false;
		}
		
return false;
   // return flag;
}

function ValidateEmdTenderDate() {
var instrument_date = "", dd_expire_date = "", currdatetime = "",instrument_type="";	
var flag = '';
var currdatetime 			= 	new Date($('#currdate').val());
	instrument_date 		=	$('#instrument_date').val();
	dd_expire_date 			=	$('#dd_expire_date').val();
	instrument_type 		=	$('#instrument_type').val();
	
	
	if (instrument_date != ''){
		 instrument_date = new Date(instrument_date); 
	}   
	if (dd_expire_date != ''){
		 dd_expire_date = new Date(dd_expire_date); 
	}
	
	if (instrument_date > currdatetime) {
        $('#spMsg').html("<li>Instrument date should not be greater than current date!! <li/>");
        flag = 1;
    }

	if ((dd_expire_date < currdatetime) && ($('#dd_expire_date').val()!='')) {
        $('#spMsg').html("<li>Instrument expiry date should not be smaller than current date!! <li/>");
        flag = 1;
    }
	
	if ($('#instrument_no').val().length > 16 && instrument_type == 1) {
		$('#spMsg').html("<li>RTGS/NEFT RECIEPT No. can not be greater than 16 digit!! <li/>");
		flag = 1;
	}
	else if ($('#instrument_no').val().length > 6 && instrument_type == 2) {
		$('#spMsg').html("<li>DD No. can not be greater than 6 digit!!</li>");
		flag = 1;
	}
	else if ($('#instrument_no').val().length > 16 && $instrument_type == 3) {
		$('#spMsg').html("<li>Chalan No. can not be greater than 16 digit!! <li/>");
		flag = 1;
	}
	if(flag==1){
		return false;
	}else{
		return true;
	}
	
}

function validateParticipate(submitval) {
	
	var reserve_price= '', tender_paid= '', emd_paid= '', documents_paid= '', quote_price= '';
	reserve_price 		=	$('#reserve_price').val();
	tender_paid 		=	$('#tender_paid').val();
	emd_paid 			=	$('#emd_paid').val();
	documents_paid 		=	$('#documents_paid').val();
	quote_price 		=	$('#quote_price').val();
	var flag='';
	
	if(submitval=='save'){
		if(quote_price==''){
			$('#spMsg').html("<li>Please Enter Quote Price.!!<li/>");
			flag=1;
		}else if(parseFloat(quote_price) < parseFloat(reserve_price)){
			$('#spMsg').html("<li>Quote Price should not less than Reserve Price!<li/>");
			flag=1;
		}
	}else{
		if(quote_price==''){
			$('#spMsg').html("<li>Please Enter Quote Price.!!<li/>");
			flag=1;
		}else if(tender_paid==''){
			$('#spMsg').html("<li>Please Submit Event/Tender Fee Data.!!<li/>");
			flag=1;
		}else if(emd_paid==''){
			$('#spMsg').html("<li>Please Submit EMD Amount Data.!!<li/>");
			flag=1;
		}else if(documents_paid==''){
			$('#spMsg').html("<li>Please Submit Particular Document.!!<li/>");
			flag=1;
		}else if(parseFloat(quote_price) < parseFloat(reserve_price)){
			$('#spMsg').html("<li>Quote Price should not less than Reserve Price!<li/>");
			flag=1;
		}
	}

	if(flag==1){
		return false;
	}else{
		return true;
	}
	
}
//

/*
function checkNumeric(event) {
            kcode = event.keyCode || event.charCode;
            if (kcode == 45) {
                //IE
                if (window.ActiveXObject) {
                    event.keyCode = 0
                    return false;
                }
                else {
                    event.charCode = 0
                    return false;
                } 
            }
            if ((kcode > 57 || kcode < 48) && (kcode != 46 && kcode != 45 && kcode != 8 && kcode != 9)) {
                //IE
                if (window.ActiveXObject) {
                    event.keyCode = 0
                    return false;
                }
                else {
                    event.charCode = 0
                    return false;
                } 
            }
        }
*/
function updateAuctionStatus(activity_type,auctionID){
	   $.ajax({
              url:  "/banker/ajaxbidActivity",
              type: "post",
              data: "activity_type="+activity_type+"&auctionID="+auctionID,
              success: function(results){
				window.location.reload(true);	
              }
            });
		
	}
	
function ShowRemainTimer(divID){
	$('#'+divID).countdowntimer({
		dateAndTime : "2015/06/15 00:00:00",
		size : "lg",
		regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
		regexpReplaceWith: "$1<sup class='displayformat'>days</sup> / $2<sup class='displayformat'>hours</sup> / $3<sup class='displayformat'>minutes</sup> / $4<sup class='displayformat'>seconds</sup>"
	});                             
}
function increseORdecriseBidValue(increseType,aid,actualVal){
            var mtxtValue = $("#bidder_bid_value_"+aid).val();
			if (mtxtValue != null) {
                if (mtxtValue > 0) {
                    var mBidFactor = $("#bidder_bid_inc_"+aid).val();
                    var mBidopeningPrice = $("#bid_opening_price_"+aid).val();
					//alert(mBidFactor);
                    if (mBidFactor != null) {
						if(increseType=='increase'){
							cal=parseInt(mtxtValue) + parseInt(mBidFactor);
							cal = cal.toFixed(2);
							$("#bidder_bid_value_"+aid).val(cal);	
							$("#error_"+aid).html('');							
						}else{
							
						if(mtxtValue <= mBidopeningPrice){
							$error="You cannot submit smaller Bid Amount than your Opening Price.";
							$("#error_"+aid).html($error);						
						}else{
							$("#error_"+aid).html('');
							cal=parseInt(mtxtValue) - parseInt(mBidFactor);	
							cal = cal.toFixed(2);	
							$("#bidder_bid_value_"+aid).val(cal);	
						}	
						}  
                    }
                }
            }
            return false;	
}


function saveLiveAuctionBid(aid){
	 var max_auto_bid	= parseInt($("#max_auto_bid_"+aid).val());
	 var bidValue 		= parseInt($("#bidder_bid_value_"+aid).val());
	 var lastbidtextval = parseInt($("#lastbidtextval_"+aid).val());
	 var bidder_bid_inc = $("#bidder_bid_inc_"+aid).val();
	 var enteredbidtype = $("#enteredbidtype_"+aid).val();
	 var auctionID=aid;	 
	 calVal	=	parseFloat(bidValue) - parseFloat(lastbidtextval);	
	 mod	=	parseFloat(calVal) % parseFloat(bidder_bid_inc);
	 	 
if(enteredbidtype=='opening_bid'){
		if(bidValue==''){
			$("#error_"+aid).html('Please enter a some value to submit.');
			return false;
		 }else if(bidValue<=0)
		 {
			$("#error_"+aid).html('You are not allowed to enter Zero or Negative values.'); 
			return false;	
		 }else if(mod>0)
		 {
			  $("#error_"+aid).html('Please enter valid multiple of Bid Increment.'); 
			  return false;
		 }else if(bidValue==max_auto_bid)
		 {
			 $("#error_"+aid).html('Bid not Submitted. You are trying to submit a equal Bid Value as Auto bid value.'); 
			  return false; 
		 }else if(bidValue<lastbidtextval)
		 {
			 $("#error_"+aid).html('Bid not Submitted. You are trying to submit a Smaller bid value.'); 
			  return false; 
		 }else{
		   $.ajax({
				  url:  "/bidder/saveLiveauctionBid",
				  type: "post",
				  data: "bidValue="+bidValue+"&auctionID="+auctionID+"&enteredbidtype="+enteredbidtype+"&lastbidtextval="+lastbidtextval+"&bidder_bid_inc="+bidder_bid_inc,
				  success: function(results){
				 //alert(results);
				 if(results=='success')
				 {
					window.location.reload(true);	 
				 }else{
					$("#error_"+aid).html(results); 
				 }
				  
				  }
				});
		 }
		 
	}else{
		
		if(bidValue==''){
			$("#error_"+aid).html('Please enter a some value to submit.');
			return false;
		 }else if(bidValue<=0)
		 {
			$("#error_"+aid).html('You are not allowed to enter Zero or Negative values.'); 
			return false;	
		 }else if(mod>0)
		 {
			  $("#error_"+aid).html('Please enter valid multiple of Bid Increment.'); 
			  return false;
		 }else if(bidValue==max_auto_bid)
		 {
			 $("#error_"+aid).html('Bid not Submitted. You are trying to submit a equal bid value as auto bid value.'); 
			 	$.ajax({
						  url:  "/bidder/saveLiveauctionBid",
						  type: "post",
						  data: "bidValue="+bidValue+"&auctionID="+auctionID+"&enteredbidtype="+enteredbidtype+"&lastbidtextval="+lastbidtextval+"&bidder_bid_inc="+bidder_bid_inc,
						  success: function(results){
							$("#error_"+aid).html(results); 
						      window.location.reload(true);	
						  }
				});
			  return false; 
		 }else if(bidValue<=lastbidtextval)
		 {
			 $("#error_"+aid).html('Bid not Submitted. You are trying to submit a Smaller or Equal Bid Value.'); 
			  return false; 
		 }else{
		   $.ajax({
				  url:  "/bidder/saveLiveauctionBid",
				  type: "post",
				  data: "bidValue="+bidValue+"&auctionID="+auctionID+"&enteredbidtype="+enteredbidtype+"&lastbidtextval="+lastbidtextval+"&bidder_bid_inc="+bidder_bid_inc,
				  success: function(results){
				// alert(results);
				 if(results=='success')
				 {
					window.location.reload(true);	 
				 }else{
					$("#error_"+aid).html(results); 
				 }
				 
				  }
				});
		 }

	}
	 
}


//.
function saveAutobidLiveAuctionBid(aid){
	var max_auto_bid	= parseInt($("#max_auto_bid_"+aid).val());
	 var autobidValue 	= $("#bidder_autobid_value_"+aid).val();
	 var manualValue 	= $("#manual_bidder_bid_value_"+aid).val();
	 var lastbidtextval = $("#lastbidtextval_"+aid).val();
	 var bidder_bid_inc = $("#bidder_bid_inc_"+aid).val();
	 var enteredbidtype = $("#enteredbidtype_"+aid).val();
	 var auctionID=aid;
	 calVal	=	parseFloat(autobidValue) - parseFloat(lastbidtextval);	
	 mod	=	parseFloat(calVal) % parseFloat(bidder_bid_inc);
	 alert(max_auto_bid  +"--"+autobidValue);
	if(enteredbidtype=='opening_bid')
	{ 
			if(autobidValue==''){
				$("#error_"+aid).html('Please enter a some value to submit.');
				return false;
			 }else if(autobidValue<=0)
			 {
				$("#error_"+aid).html('You are not allowed to enter Zero or Negative values.'); 
				return false;	
			 }else if(mod>0)
			 {
				  $("#error_"+aid).html('Please enter valid multiple of Bid Increment.'); 
				  return false;
			}else if(autobidValue==max_auto_bid)
		 {
			 $("#error_"+aid).html('Bid not Submitted. You are trying to submit a equal Bid Value as Auto bid value.iiiii'); 
			  return false; 
		 }else if(autobidValue<lastbidtextval)
			 {
				 $("#error_"+aid).html('Bid not Submitted. You are trying to submit a Smaller Bid Value.'); 
				  return false; 
			 } else{
				//alert("yrdddd");
			   $.ajax({
					  url:  "/bidder/saveAutoCutOffLiveauctionBid",
					  type: "post",
					  data: "auto_bid="+autobidValue+"&auctionID="+auctionID+"&manualValue="+manualValue+"&lastbidtextval="+lastbidtextval+"&bidder_bid_inc="+bidder_bid_inc+"&enteredbidtype="+enteredbidtype,
					  success: function(results){
						 //alert(results);
						 if(results=='success')
						 {
							window.location.reload(true);	 
						 }else{
							$("#error_"+aid).html(results); 
						 }
						
					  //window.location.reload(true);	
					  }
					});
			}
	
	}else{
		
		if(autobidValue==''){
				$("#error_"+aid).html('Please enter a some value to submit.');
				return false;
			 }else if(autobidValue<=0)
			 {
				$("#error_"+aid).html('You are not allowed to enter Zero or Negative values.'); 
				return false;	
			 }else if(mod>0)
			 {
				  $("#error_"+aid).html('Please enter valid multiple of Bid Increment.'); 
				  return false;
			 }else if(autobidValue==max_auto_bid)
			 {
					$("#error_"+aid).html('Bid not Submitted. You are trying to submit a equal Bid Value as Auto bid valueuuuu.ii'); 
					$.ajax({
						  url:  "/bidder/saveAutoCutOffLiveauctionBid",
						  type: "post",
						  data: "auto_bid="+autobidValue+"&auctionID="+auctionID+"&manualValue="+manualValue+"&lastbidtextval="+lastbidtextval+"&bidder_bid_inc="+bidder_bid_inc,
						  success: function(results){
							$("#error_"+aid).html(results); 
						  window.location.reload(true);	
						  }
						});
				  return false; 
		 }else if(autobidValue<=lastbidtextval)
			 {
				 $("#error_"+aid).html('Bid not Submitted. You are trying to submit a Smaller or Equal Bid Value.'); 
				  return false; 
			 }else{
				 $.ajax({
					  url:  "/bidder/saveAutoCutOffLiveauctionBid",
					  type: "post",
					  data: "auto_bid="+autobidValue+"&auctionID="+auctionID+"&manualValue="+manualValue+"&lastbidtextval="+lastbidtextval+"&bidder_bid_inc="+bidder_bid_inc,
					  success: function(results){
						 //alert(results);
						 if(results=='success')
						 {
							window.location.reload(true);	 
						 }else{
							$("#error_"+aid).html(results); 
						 }
						
					  //window.location.reload(true);	
					  }
					});
			}
	}
}
function showBidders(showval){
	if(showval==1){
	$("#show_bidder").show();
	}else{
	$("#show_bidder").hide();	
	}
}

function showhidedropdown()
{
	$(".login_dropdown").slideToggle();
}

function savefavorite(bankID){
	if(confirm("Are You Sure Want to a add in Follow List ")){
	  $.ajax({
              url:  "/owner/savefavorite",
              type: "post",
              data: "bankID="+bankID,
              success: function(results){
			  window.location.reload(true);	
              }
            });
	
	}
}

function removefollowsearchList(bankID){
	
	if(confirm("Are You Sure Want to a Remove from Follow List ")){
	  $.ajax({
              url:  "/owner/removefollows",
              type: "post",
              data: "bankID="+bankID,
              success: function(results){
				window.location.reload(true);
              }
            });
	
	}	
}


function buyOwnerDashboardData(key,section,keytype)
{
	if(section=='sell'){
		formaction='/owner/ajaxSellDashboardData';
	}else if(section=='banker'){
		
		formaction='/banker/ajaxdashboard';
	}else{
		formaction='/owner/ajaxBuyDashboardData';
	}
	  $.ajax({
              url:  formaction,
              type: "post",
              data: "key="+key+"&section="+section+"&keytype="+keytype,
              success: function(results){
				$.each(JSON.parse(results), function(idx, obj) {
					if(idx=='auctionConducted'){
						$('#auctionConducted').html(obj);	
					}
					if(idx=='activeAuction'){
						$('#activeauction').html(obj);	
					}
					if(idx=='propertyPosted'){
						$('#propertyPosted').html(obj);	
					}
					if(idx=='activeProperties'){
						$('#activeProperties').html(obj);	
					}
					if(idx=='interestedUsers'){
						$('#interestedUsers').html(obj);	
					}
					if(idx=='auc_participated'){
						$('#auc_participated').html(obj);	
					}
					if(idx=='auc_own'){
						$('#auc_own').html(obj);	
					}
					if(idx=='auc_active'){
						$('#auc_active').html(obj);	
					}
					if(idx=='requirementPosted'){
						$('#requirementPosted').html(obj);	
					}
					if(idx=='responseReceived'){
						$('#responseReceived').html(obj);	
					}
					if(idx=='propertyViewed'){
						$('#propertyViewed').html(obj);	
					}

					if(idx=='total_invoice_reaised'){
						$('#total_invoice_reaised').html(obj);	
					}
					
					if(idx=='bankactiveAuction'){
						$('#bankactiveAuction').html(obj);	
					}
					
					if(idx=='payment_due'){
						$('#payment_due').html(obj);	
					}
					
					if(idx=='outstanding_amount'){
						$('#outstanding_amount').html(obj);	
					}
				});
              }
            });
	return true;	
}

function showWidght(){
	 $('.auction_prowidget').mouseover(function(){
		$('.overlay').hide();
		$(this).children('.overlay').show();
	 });
	 $('.auction_prowidget').mouseout(function(){
		$('.overlay').hide();
	 });
}

function propertyTypeList(auctionType){
	 window.location.href="/property?act="+auctionType;
}

function processform(){
	$('#property_serch').submit()
}
function propertyList(querystring){
	auction_type=$('#auction_type').val();
}

$(document).ready(function() {
$('.close').click(function(){
		$(".popupcontainer").html('');
		$('.bidderHolePopup').hide();
		location.reload();
	});
});
function bidderHoleinfoPopup(infotype,auctionID){
	if(infotype=='uploaded_file'){
		$(".popupcontainer").load('/banker/view_uploadedfile/'+auctionID);
	}else if(infotype=='bidder_detail'){
		$(".popupcontainer").load('/banker/view_bid_history/'+auctionID);
	}else if(infotype=='eventDetaillist'){
		$(".popupcontainer").load('/banker/eventDetailbidderHole/'+auctionID);
	}
	else if(infotype=='viewBidders'){
		$(".popupcontainer").load('/helpdesk_executive/viewBidders/'+auctionID);
	}else if(infotype=='viewauctionDetail'){
		$(".popupcontainer").load('/helpdesk_executive/eventDetailbidderHole/'+auctionID);
	}else if(infotype=='owner_uploaded_file'){
		
			$(".popupcontainer").load('/owner/view_uploadedfile/'+auctionID);
	}else if(infotype=='owner_eventDetaillist'){
		
			$(".popupcontainer").load('/owner/eventDetailbidderHole/'+auctionID);
	}
	else if(infotype=='owner_agreement_privacy_policy'){
		
			$(".popupcontainer").load('/owner/owneragreementprivacypolicy/'+auctionID);
	}
	$('.bidderHolePopup').toggle('explode');
}

function removeAttributeVal(searchtype,field_name)
{
	if(searchtype=='propertytype')
	{
			$("#"+field_name).prop( "checked", false );
			$("#property_serch").submit();	
	}else if(searchtype=='category')
	{
		
		$( "#"+field_name).prop("checked", false);
		$("#property_serch").submit();	
		
	}else if(searchtype=='subcategory')
	{
		
		$( "#subcate_"+field_name).prop("checked", false);
		$("#property_serch").submit();	
		
	}else if(searchtype=='postedby')
	{
		var x = document.getElementById("multiple-selected-postedby").options.length;
		for(i=0 ; i<x ; i++)
		{
			var xv = document.getElementById("multiple-selected-postedby").options[i].value;
			if(field_name==xv){
					$("#multiple-selected-postedby option[value='"+field_name+"']").prop("selected", false);
					$("#property_serch").submit();
				}				
		}
		
	}
	else if(searchtype=='bank')
	{
		$("#banknameID_"+field_name ).prop( "checked", false );
		$("#property_serch").submit();	
	}

}

function addViewGrid(vale){
	$("#gridview").val(vale);
	$("#property_serch").submit();
}

function sortBydata(vale){
	$("#sort_bydata").val(vale);
	$("#property_serch").submit();
}
function limitPerdata(vale){
	$("#limit_perpagedata").val(vale);
	$("#property_serch").submit();
}
function searchCalenderData(key){
	 $.ajax({
              url:  "/auction_calender/seachcalenderData",
              type: "post",
              data: "key="+key,
              success: function(results){
				  //alert(results)
				  $("#tabledata").html(results);
			  }
            });
	
	
}
function loadAllReviewsData(pid){
	 $.ajax({
              url:  "/property/allratingReview",
              type: "post",
              data: "pid="+pid,
              success: function(results){
				  //alert(results);
				  $("#reviewsList").html(results);
			  }
            });
}
function is_accept_tc_update(aid){
	 $.ajax({
              url:  "/owner/is_accept_tc_update",
              type: "post",
              data: "aid="+aid,
              success: function(results){
				  //alert(results);
				  $("#is_accept_tc_upid_"+aid).html(results);
			  }
            });
}


function showsubcategry(category,atype){
	var subcate = $('#type').val();
	if(atype=='executive')
	{
		actiontype='helpdesk_executive';
	}else if(atype=='bank'){
		actiontype='banker';
	}else{
		actiontype='owner';	
	}
	
	   $.ajax({
              url:  "/"+actiontype+"/showsubcategorydata",
              type: "post",
              data: "category="+category+"&subcate"+subcate,
              success: function(results){
				 // alert(results);
				 if(atype=='owner')
				{
				$("#property_type").html(results);	
				}else{
				$("#type").html(results);
				}
              }
            });
		
	}

function submitSubcatform(){
	$("#property_serch").submit();
}

function showbidder_detail(){
	if($("#confirmbidder").is(":checked")== true)
	{
		$("#showbidder_detail").fadeIn();	
	}else{
		$("#showbidder_detail").fadeOut();	
	}
}


function closehomesearch(typeval,ptype){
	
	if(ptype=='home'){
		if(typeval=='hide'){
				$(".static-home-search").animate({left: '-400px'});
				//$('.static-home-search').css({'display' : 'none'});
		}else{
			 $('.static-home-search').css({'display' : 'block'});
			 $(".static-home-search").animate({left: '0px'});
		}
	}else{
		if(typeval=='hide'){
				$(".static-inside-search").animate({left: '-400px'});
				//$('.static-home-search').css({'display' : 'none'});
		}else{
			 //$('.static-inside-search').css({'display' : 'block'});
			 $(".static-inside-search").animate({left: '0px'});
		}

		
		
	}
}

    function favFunction(productId){
		$.ajax({
           type:"post",
           url:"/property/savefavourite",
           data:"productId=" + productId,
           success:function(retrunData){
               if(retrunData == 1){
				    //$("#favmsg"+productId).show();
					$('.fevoriteLogo_'+productId).addClass('ac-fav');
                    //alert('favourites Added Successfully');
					//$("#favmsg"+productId).css({"color": "green", "font-size": "small"}); 
					//$("#favmsg"+productId).html('favourites Added Successfully');
                    //$("#favmsg"+productId).delay(5000).fadeOut('slow');
                }else{
					alert('This Property already added in your favourite list');
					//$("#favmsg"+productId).show();
					//$("#favmsg"+productId).css({"color": "red", "font-size": "small"}); 
                    //$("#favmsg"+productId).html('This Property already added in your favourite list');
                    //$("#favmsg"+productId).delay(5000).fadeOut('slow');
				}
            }
        });
    }

function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
	
	function submitForgotPassword(utype){
		
		
		email= $("#forgotemail").val();
		if(email!=''){
			
			if(validateEmail(email)){
			 $.ajax({
				  url:  "/registration/forgotPassword",
				  type: "post",
				  data: "utype="+utype+"&email="+email,
				  success: function(results){
					  //alert(results);
					 $("#forgot_email").html(results);
				  }
				});
			}else{
				$("#forgot_email").html('Please Enter Valid Email!');
			}
		}else{
			$("#forgot_email").html('Please Enter Email!');
		}	
		
		
	}
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	console.log(charCode);
	if (charCode != 46 && charCode != 45 && charCode > 31
			&& (charCode < 48 || charCode > 57))
		return false;

	return true;
}

function ImageValidate(field_name,sizelimit) {
	//2097152
	//$("#file_error").html("");
	//$(".demoInputBox").css("border-color","#F0F0F0");
	$(".images_error"+field_name).remove();
	var file_size = $('#'+field_name)[0].files[0].size;
	slimit=(1024*1024)*parseInt(sizelimit);
	if(file_size>slimit){
		//$("#file_error").html("File size is greater than 2MB");
		$("#"+field_name).val('');
		$("<span class='images_error"+field_name+"' style='color:red;'>Images size is greater then "+sizelimit+"MB.</span>" ).insertAfter("#"+field_name);
		return false;
	}else{
		$( ".images_error"+field_name).remove();
		return true;
	} 
}

function checkboxval(lid,id){
		//chkname=jQuery(this).attr("id");
		var count_checked = $("[name='form_field_"+id+"[]']:checked").length;	
		if(count_checked>0)
		{
			$("#"+id).val('yes');
		}else{
			$("#"+id).val('');
		}
		}
