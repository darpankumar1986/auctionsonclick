// JavaScript Document
/*Top Most Filteration Slider*/
jQuery(document).ready(function ($) {
    showWidght();
    $(".showformpan").click(function () {
        var attids = $(this).attr('id');
        if (attids == 'pan_numberid') {
            $("#pan-no_data").show();
            $("#form_16-data").hide();
        } else if (attids == 'form_16id') {
            $("#form_16-data").show();
            $("#pan-no_data").hide();
        }
    });
    $(".slidesearch").click(function () {
        // Set the effect type
        var effect = 'slide';
        // Set the options for the effect type chosen
        var options = {direction: 'right'};
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
    if (div_id == 'resultpropertySearch') {
        $("#propertySearch").val(value);
        $("#resultpropertySearch").show();
        $("#resultpropertySearch").html('');

    } else if (div_id == 'resultpropertySearchRent') {
        $("#propertySearchRent").val(value);
        $("#resultpropertySearchRent").show();
        $("#resultpropertySearchRent").html('');
    }
    processform();
}
function submit_search_form() {
    $("#advance_search").submit();
}
function ajaxFormdata(category_id, productid) {
    if (category_id)
    {
        jQuery('#ajaxFormData').load('/helpdesk_executive/ajaxFormData/' + category_id + '/' + productid);
    }
}

function ajaxFormdatabanker(category_id, productid) {
    if (category_id)
    {
        $('#ajaxFormData').load('/buyer/ajaxFormData/' + category_id + '/' + productid);
    }
}

function ajaxFormdata_nonBanker(category_id, isauction, sele_rent, productid) {
    if (category_id)
    {
        //alert("ffffffffffffff0000");
        if (isauction == 1) {
            isauction = 'auction';
        } else {
            isauction = 'non-auction';
        }
        $('#ajaxFormData').load('/owner/ajaxFormData/' + category_id + '/' + isauction + '/' + sele_rent + '/' + productid);
    }
}
/*video question process end*/
function validateSubmitform(btn) {
    $('#spMsg').html("");
    flag = '';
    body = CKEDITOR.instances.contact_person_details_1.getData().trim();
    if (btn == "save")
    {
        // alert($('#rdoEventOthers').is(':checked'));
        /*   
         if ($('#rdoEventDRT').is(':checked') == false && $('#rdoEventSRFAESI').is(':checked') == false && $('#rdoEventOthers').is(':checked') == false) {
         $('#spMsg').append("<li>Please Select Account. </li>");
         flag = 1;
         }*/

        if ($('#account').val() == '') {
            $('#spMsg').append("<li>Please Select Institution</li>");
            flag = 1;
        }
        if ($('#reference_no').val() == '') {
            $('#spMsg').append("<li>Please Enter Property ID </li>");
            flag = 1;
        }
        /*if ($('#dispatch_date').val() == '') {
         $('#spMsg').append("<li>Please enter Dispatch Date </li>");
         flag = 1;
         }*/
       
        /*
        if ($('#area').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Property Area </li>");
            flag = 1;
        }
       
        if (isNaN($('#area').val().trim()) == true) {
            $('#spMsg').append("<li>Please Enter Valid Property Area </li>");
            flag = 1;
        }        
        
        if ($('#area_unit_id').val() == '') {
            $('#spMsg').append("<li>Please Select Area Unit </li>");
            flag = 1;
        }
        */
        if ($('#category').val() == '') {
            $('#spMsg').append("<li>Please Select Category/ Property Type </li>");
            flag = 1;
        }
	if ($('#bid_inc').val() == '') {
            $('#spMsg').append("<li>Please Enter Bid Increment value</li>");
            flag = 1;
        }
        if (isNaN($('#bid_inc').val().trim()) == true) {
            $('#spMsg').append("<li>Please Enter Valid Bid Increment value</li>");
            flag = 1;
        }

        if (body == '')
        {
            $('#spMsg').append("<li>Please Enter 1st Contact Person Details  </li>");
            flag = 1;
        }

        if ($('#latitude').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Latitude </li>");
            flag = 1;
        }
        if ($('#longitude').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Longitude </li>");
            flag = 1;
        }

        /*
         if($('#image').val()!='')
         {
         var ud = $('#image');
         lg = ud[0].files.length;
         var f = ud[0].files;		
         var fTypeErr = false;
         var fSizeErr = false;
         for (var i = 0; i < lg; i++) { 
         var ext = f[i].name.split('.').pop().toLowerCase();
         if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
         {
         flag=1; 
         fTypeErr = true;
         }
         else
         {
         var file_size = f[i].size;
         slimit=(1024*1024)*parseInt(5);
         if(file_size>slimit)
         {
         flag=1; 
         fSizeErr = true;
         }
         }
         }					
         if(fTypeErr)
         {
         $("#spMsg").append("<li>Please Upload Valid Image( Acceptable format are gif,png,jpg,jpeg)</li>");
         }
         if(fSizeErr)
         {
         $("#spMsg").append("<li>Please Upload Image files less than 5MB</li>");
         }
         }*/



        returnFlag = ValidateDate(btn);
        if (flag == 1 || returnFlag == 1) {

            //if(returnFlag==1){
            //alert("-------"+flag);
            $("#showerror_msg").show();
            $(".inline").colorbox({inline: true, width: "50%"});
            $(".inline").click();
            return false;
            // }
        } else {
            return true;
        }
    } else
    {
        //alert(body);
        if ($('#account').val() == '') {
            $('#spMsg').append("<li>Please Select Institution. </li>");
            flag = 1;
        }

        if ($('#reference_no').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Property ID </li>");
            flag = 1;
        }

        if ($('#description').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Address of the property </li>");
            flag = 1;
        }
		 /*
        if ($('#area').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Property Area </li>");
            flag = 1;
        }
       
        if (isNaN($('#area').val().trim()) == true) {
            $('#spMsg').append("<li>Please Enter Valid Property Area </li>");
            flag = 1;
        }
        
        if ($('#area_unit_id').val() == '') {
            $('#spMsg').append("<li>Please Select Area Unit </li>");
            flag = 1;
        }
        */

        if ($('#category').val() == '') {
            $('#spMsg').append("<li>Please Select Category/ Property Type </li>");
            flag = 1;
        }

        if ($('#zone_id').val() == '') {
            $('#spMsg').append("<li>Please Select Concerned Zone</li>");
            flag = 1;
        }
        /*   
         if ($('#height_unit_id').val() == '') {
         $('#spMsg').append("<li>Please Select Height Unit</li>");
         flag = 1;
         } */

        if ($('#reserve_price').val() == '') {
            $('#spMsg').append("<li>Please Enter Bid Start Price (BSP) </li>");
            flag = 1;
        }
        if (($('#reserve_price').val() == 0) && ($('#reserve_price').val() != '')) {
            $('#spMsg').append("<li>Bid Start Price (BSP) can not be zero</li>");
            flag = 1;
        }
        if (isNaN($('#reserve_price').val().trim()) == true) {
            $('#spMsg').append("<li>Please Enter Valid Bid Start Price (BSP)</li>");
            flag = 1;
        }

        if ($('#emd_amt').val() == '') {
            $('#spMsg').append("<li>Please Enter Emd Amount</li>");
            flag = 1;
        }
        if (($('#emd_amt').val() == 0) && ($('#emd_amt').val() != '')) {
            $('#spMsg').append("<li>Emd Amount can not be zero</li>");
            flag = 1;
        }
        
        if (isNaN($('#emd_amt').val().trim()) == true) {
            $('#spMsg').append("<li>Please Enter Valid Emd Amount </li>");
            flag = 1;
        }
        
        if ($('#tender_fee').val() == '') {
            $('#spMsg').append("<li>Please Enter Bank Processing Fee</li>");
            flag = 1;
        }
        
        if (isNaN($('#tender_fee').val().trim()) == true) {
            $('#spMsg').append("<li>Please Enter Valid Participation Fee </li>");
            flag = 1;
        }
        /* 
         if($('#second_opener').val()==''){
         $('#spMsg').append("<li>Please Select Auction Approver</li>");
         flag = 1;
         } 
         */

        /*
         if( ($('#emd_amt').val() != '') &&  ($('#reserve_price').val() != '')){	
         if (parseFloat($('#reserve_price').val()) <= parseFloat($('#emd_amt').val())) {
         $('#spMsg').append("<li>Bid Start Price (BSP) should be greater than EMD Amount<li/>");
         flag = 1;
         }
         }
         */

        if ($('#unit_id_of_price').val() == '') {
            $('#spMsg').append("<li>Please Select Reserve Price (Unit) </li>");
            flag = 1;
        }

        if ($('#press_release_date').val() == '') {
            $('#spMsg').append("<li>Please Enter Press Release Date</li>");
            flag = 1;
        }
        /*
        if ($('#inspection_date_to').val() == '') {
            $('#spMsg').append("<li>Please Enter Site Visit End Date</li>");
            flag = 1;
        }
        */
         if ($('#registration_start_date').val() == '') {
         $('#spMsg').append("<li>Please Enter Apply And EMD Start Date</li>");
         flag = 1;
         }
        
        if ($('#bid_last_date').val() == '') {
            $('#spMsg').append("<li>Please Enter Apply And EMD Last Date</li>");
            flag = 1;
        }

		/*
        if ($('#bid_opening_date').val() == '') {
            $('#spMsg').append("<li>Please Enter Shortlisting Start Date</li>");
            flag = 1;
        }
		*/
			
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
        
         if (($('#auto_extension').val() > 0 && ($("#auto_extension_time").val() <=0 || $("#auto_extension_time").val()=='')) || $('#auto_extension').val() =='' && ($("#auto_extension_time").val() <=0 || $("#auto_extension_time").val()=='')) {
            $('#spMsg').append("<li>Please Enter Valid Auto Extension Time</li>");
            flag = 1;
        }       
        if (isNaN($('#bid_inc').val().trim()) == true) {
            $('#spMsg').append("<li>Please Enter Valid Bid Increment value</li>");
            flag = 1;
        }
        
        if (body == '')
        {
            $('#spMsg').append("<li>Please Enter 1st Contact Person Details  </li>");
            flag = 1;
        }

        if ($('#latitude').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Latitude </li>");
            flag = 1;
        }
        if ($('#longitude').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Longitude </li>");
            flag = 1;
        }

        $('.fileRq').each(function () {
            var fieldId = $(this).attr('id');

            if ($('#old_' + fieldId).val() == '')
            {
                if ($(this).val() == '')
                {
                    fieldId = fieldId.replace(/\_+/g, ' ');
                    $('#spMsg').append("<li>Please " + fieldId + "</li>");
                    flag = 1;
                }
            }
        });


        if ($('#approverComments').size() > 0 && $('#approverComments').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Approver comments </li>");
            flag = 1;
        }




        /*if (jQuery('#old_related_doc').val() == '' && jQuery('#related_doc').val() == '' ) {
         jQuery('#spMsg').append("<li>Please Upload Related Document</li>");
         flag = 1;
         }
         */


        //if (jQuery('#old_image').val() == '' && jQuery('#image').val() == '') { 
        /*if (jQuery('#old_image').val() == '' && jQuery('#image').val() == '') { 
         jQuery('#spMsg').append("<li>Please Upload Image</li>");
         flag = 1;
         }*/
        /*
         if($('#image').val()!=''){
         var ext = $('#image').val().split('.').pop().toLowerCase();
         if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
         flag=1; 
         $("#spMsg").append("<li>Please Upload Valid Image( Acceptable format are gif,png,jpg,jpeg)</li>");
         }else{
         var file_size = $('#image')[0].files[0].size;
         slimit=(1024*1024)*parseInt(5);
         if(file_size>slimit){
         flag=1; 
         $("#spMsg").append("<li>Please Upload Image less than 5MB</li>");
         }     
         
         }
         }
         */


        var options = $('#doc_to_be_submitted > option:selected');
        if (options.length == 0) {
            $('#spMsg').append("<li>Please Select Documents to be submitted by Bidder </li>");
            flag = 1;
        }


        if (flag != 1) {
            returnFlag = ValidateDate(btn);
            if (returnFlag == 1) {
                $("#showerror_msg").show();
                $(".inline").colorbox({inline: true, width: "50%"});
                $(".inline").click();
                return false;
            } else {
                //return false;	
                return true;
            }

        } else {
            $("#showerror_msg").show();
            $(".inline").colorbox({inline: true, width: "50%"});
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
    flag = '';


    /*if ($('#reference_no').val() == '') {
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
     }*/

    if ($('#reserve_price').val() == '') {
        $('#spMsg').append("<li>Please Enter Reserve Price.</li>");
        flag = 1;
    }
    /*(if (($('#reserve_price').val() != '')) {
     $('#spMsg').append("<li>Estimated price cannot be zero.</li>");
     flag = 1;
     }*/


    /*if ($('#press_release_date').val() == '') {
     $('#spMsg').append("<li>Please Enter Press Release Date</li>");
     flag = 1;
     }*/

    if ($('#bid_last_date').val() == '') {
        $('#spMsg').append("<li>Please enter Registration last date.</li>");
        flag = 1;
    }

    /*if ($('#bid_opening_date').val() == '') {
     $('#spMsg').append("<li>Please Enter Sealed Bid Opening Date</li>");
     flag = 1;
     }*/

    if ($('#auction_start_date').val() == '') {
        $('#spMsg').append("<li>Please enter auction start date.</li>");
        flag = 1;
    }

    if ($('#auction_end_date').val() == '') {
        $('#spMsg').append("<li>Please enter auction end date.</li>");
        flag = 1;
    }


    if ($('#bid_inc1').val() == '') {
        $('#spMsg').append("<li>Please select bid increment value.</li>");
        flag = 1;
    }

    if ($('#bid_inc1').val() == 'others') {
        if ($('#bid_inc2').val() == '') {
            $('#spMsg').append("<li>Please enter bid increment value.</li>");
            flag = 1;
        }

    }





    /*if($('#old_related_doc').val()==''){
     
     if ($('#related_doc').val() == '') {
     $('#spMsg').append("<li>Please Upload Related Documents</li>");
     flag = 1;
     }
     }*/

    if ($('#old_image').val() == '') {
        if ($('#image').val() == '') {
            $('#spMsg').append("<li>Please upload property image(s).</li>");
            flag = 1;
        }
    }

    var options = $('#doc_to_be_submitted > option:selected');
    if (options.length == 0) {
        $('#spMsg').append("<li>Please select documents to be submitted.</li>");
        flag = 1;
    }



    if (flag != 1) {
        returnFlag = ValidateDate();
        if (returnFlag == 1) {
            $("#showerror_msg").show();
            $(".inline").colorbox({inline: true, width: "50%"});
            $(".inline").click();
            return false;
        } else {
            return true;
        }

    } else {
        $("#showerror_msg").show();
        $(".inline").colorbox({inline: true, width: "50%"});
        $(".inline").click();
        return false;
    }
    return false;
    // return flag;
}

function validateAdminformNonBank(btn) {
    $('#spMsg').html("");
    flag = '';


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
        $('#spMsg').append("<li>Please Enter Registration Last Date</li>");
        flag = 1;
    }

    /*if ($('#bid_opening_date').val() == '') {
     $('#spMsg').append("<li>Please Enter Sealed Bid Opening Date</li>");
     flag = 1;
     }*/

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

    if ($('#old_related_doc').val() == '') {
        if ($('#related_doc').val() == '') {
            $('#spMsg').append("<li>Please Upload Related Documents</li>");
            flag = 1;
        }
    }

    if ($('#old_image').val() == '') {
        if ($('#image').val() == '') {
            $('#spMsg').append("<li>Please Upload Image</li>");
            flag = 1;
        }
    }

    var options = $('#doc_to_be_submitted > option:selected');
    if (options.length == 0) {
        $('#spMsg').append("<li>Please Select Documents to be submitted</li>");
        flag = 1;
    }




    if (flag != 1) {
        returnFlag = ValidateDate();
        return false;
        if (returnFlag == 1) {
            $("#showerror_msg").show();
            $(".inline").colorbox({inline: true, width: "50%"});
            $(".inline").click();
            return false;
        } else {
            return true;
        }

    } else {
        $("#showerror_msg").show();
        $(".inline").colorbox({inline: true, width: "50%"});
        $(".inline").click();
        return false;
    }
    return false;
    // return flag;
}

function setDateFormate(dateTime) {
    var arr1 = dateTime.split(' ');
    var arr2 = arr1[0].split('/');
    var dateTime = arr2[2] + '/' + arr2[1] + '/' + arr2[0] + ' ' + arr1[1];
    return dateTime;
}

function ValidateDate(btn) {


    var pressReleasedate = "", inspecDateFrom = "", inspectionDateTo = "";
    var EMDStartDate = "", EMDEndDate = "", ShortListingDate = "";
    var auctionStartDate="", auctionEndDate = "";
    var flag = '';
    
    var currdate = $('#currdate').val();
    //var currentDate = 
    var currdatetime = new Date(setDateFormate(currdate));

    pressReleasedate    = $('#press_release_date').val();
    inspecDateFrom      = $('#inspection_date_from').val();
    inspectionDateTo    = $('#inspection_date_to').val();
    EMDStartDate        = $("#registration_start_date").val();
    EMDEndDate          = $('#bid_last_date').val();
    //ShortListingDate    = $('#bid_opening_date').val();
    auctionStartDate    = $('#auction_start_date').val();
    auctionEndDate      = $('#auction_end_date').val();
	
    pressReleasedate    = new Date(setDateFormate(pressReleasedate.replace(/-/g, '/')));
    if(inspecDateFrom != ''){
        inspecDateFrom      = new Date(setDateFormate(inspecDateFrom.replace(/-/g, '/')));
    }
    if(inspectionDateTo != ''){
        inspectionDateTo    = new Date(setDateFormate(inspectionDateTo.replace(/-/g, '/')));
    }
    
    EMDStartDate        = new Date(setDateFormate(EMDStartDate.replace(/-/g, '/')));
    EMDEndDate          = new Date(setDateFormate(EMDEndDate.replace(/-/g, '/')));
    //ShortListingDate    = new Date(setDateFormate(ShortListingDate.replace(/-/g, '/')));
    auctionStartDate    = new Date(setDateFormate(auctionStartDate.replace(/-/g, '/')));
    auctionEndDate      = new Date(setDateFormate(auctionEndDate.replace(/-/g, '/')));

    var is_corrigendum_backend = 0;
    if (typeof $('corrigendum_backend') != 'undefined')
    {
        var is_corrigendum_backend = $('#corrigendum_backend').val();
    }
	/*
    if (pressReleasedate != '') {
        if (pressReleasedate >= currdatetime && is_corrigendum_backend != 1) {
            $('#spMsg').append("<li>Press Release Date or time should be less than current date or time !! <li/>");
            flag = 1;
        }
        
    }
	*/
    if (inspecDateFrom != '' && $('#inspection_date_from').val() != '0000-00-00 00:00:00') {
        if (pressReleasedate >= inspecDateFrom) {
            $('#spMsg').append("<li> Site Visit Start Date time should be greater than Press release date !! <li/>");
            flag = 1;
        }
    }

    if (inspectionDateTo != '' && $('#inspection_date_to').val() != '0000-00-00 00:00:00' && inspecDateFrom != '' && $('#inspection_date_from').val() != '0000-00-00 00:00:00') {
        
        if (inspectionDateTo <= inspecDateFrom) {
            $('#spMsg').append("<li> Site Visit End Date time should be greater than  Site Visit Start Date time !! <li/>");
            flag = 1;
        }
        /*
        if (inspectionDateTo >= auctionStartDate) {
            $('#spMsg').append("<li> Site Visit End Date time should be less than Auction Start date or time !! <li/>");
            flag = 1;
        }*/
        
         if (inspectionDateTo >= auctionEndDate) {
            $('#spMsg').append("<li> Site Visit End Date time should be less than Auction End date or time !! <li/>");
            flag = 1;
        }
        
    }
    
    if (EMDStartDate != '' && $("#registration_start_date").val() != '0000-00-00 00:00:00') {
       
        if (EMDStartDate <= pressReleasedate) {
            $('#spMsg').append("<li> Apply And EMD Start Date time should be greater than Press Release Date time !! <li/>");
            flag = 1;
        }
    }
    
    if (EMDEndDate != '' && $("#bid_last_date").val() != '0000-00-00 00:00:00') {
        if (EMDEndDate <= EMDStartDate) {
            $('#spMsg').append("<li> Apply And EMD End Date time should be greater than Apply And EMD Start Date time !! <li/>");
            flag = 1;
        }
        
        
         
    }
    /*
    if (ShortListingDate != '' && $("#bid_opening_date").val() != '0000-00-00 00:00:00') {
        if (ShortListingDate <= EMDEndDate) {
            $('#spMsg').append("<li> Shortlisting Start Date time should be greater than Apply And EMD End Date time !! <li/>");
            flag = 1;
        }
    }
    */
    /*
    if (auctionStartDate != '' && $("#auction_start_date").val() != '0000-00-00 00:00:00') {
        if (auctionStartDate <= ShortListingDate) {
            $('#spMsg').append("<li> Auction Start Date time should be greater than Shortlisting Start Date time !! <li/>");
            flag = 1;
        }
    }
    */
    
    if (auctionStartDate != '' && $("#auction_start_date").val() != '0000-00-00 00:00:00') {
        if (auctionStartDate <= EMDStartDate) {
            $('#spMsg').append("<li> Auction Start Date time should be greater than Apply And EMD Start Date time !! <li/>");
            flag = 1;
        }
    }
    
   if (auctionEndDate != '' && $("#auction_end_date").val() != '0000-00-00 00:00:00') {
        if (auctionEndDate <= auctionStartDate) {
            $('#spMsg').append("<li> Auction End Date time should be greater than Auction Start Date time !! <li/>");
            flag = 1;
        }
        if (auctionEndDate <= EMDEndDate) {
            $('#spMsg').append("<li> Auction End Date time should be greater than Apply And EMD End Date time !! <li/>");
            flag = 1;
        }
    }
   
    return flag;
}
//End of ValidateDate() function

function CoriValidateDate() {

    var nitdate = "", FromInsdate = "", ToInsdate = "", offerdate = "", openingdate = "", starttime = "", endtime = "";
    var flag = '';
    var inspection_date_from = '';
    var inspection_date_to = '';

    var currdatetime = new Date($('#currdate').val());
    nitdate = $('#press_release_date').val();
    FromInsdate = $('#inspection_date_from').val();
    ToInsdate = $('#inspection_date_to').val();
    offerdate = $('#bid_last_date').val();
    openingdate = $('#bid_opening_date').val();
    starttime = $('#auction_start_date').val();
    endtime = $('#auction_end_date').val();
    inspection_date_from = $('#inspection_date_from').val();
    inspection_date_to = $('#inspection_date_to').val();

    nitdate = nitdate.replace(/-/g, '/');
    FromInsdate = FromInsdate.replace(/-/g, '/');
    ToInsdate = ToInsdate.replace(/-/g, '/');
    offerdate = offerdate.replace(/-/g, '/');
    openingdate = openingdate.replace(/-/g, '/');
    starttime = starttime.replace(/-/g, '/');
    endtime = endtime.replace(/-/g, '/');
    inspection_date_to = inspection_date_to.replace(/-/g, '/');
    inspection_date_from = inspection_date_from.replace(/-/g, '/');
    if (nitdate != '') {
        nitdate = new Date(nitdate);
    }

    if (FromInsdate == '0000/00/00 00:00:00')
    {
        FromInsdate = "";
    } else if (FromInsdate != '') {
        FromInsdate = new Date(FromInsdate);
    }

    if (ToInsdate == '0000/00/00 00:00:00')
    {
        ToInsdate = "";
    } else if (ToInsdate != '') {
        ToInsdate = new Date(ToInsdate);
    }
    if (offerdate != '') {
        offerdate = new Date(offerdate);
    }
    if (openingdate != '') {
        openingdate = new Date(openingdate);
    }
    if (starttime != '') {
        starttime = new Date(starttime);
    }
    if (endtime != '') {
        endtime = new Date(endtime);
    }


    /*  if(inspection_date_from!=''){  
     inspection_date_from= new Date(inspection_date_from); 
     
     if (nitdate >= inspection_date_from) { 
     $('#spMsg').append("<li> Date of inspection of asset(From) Date time should be greater than Press release date !! <li/>");
     flag = 1;
     }
     
     }
     if(inspection_date_to!=''){ 
     inspection_date_to= new Date(inspection_date_to); 
     if (inspection_date_to <= inspection_date_from) {
     $('#spMsg').append("<li> Date of inspection of asset(To) Date time should be greater than  Date of Inspection From Date time !! <li/>");
     flag = 1;
     }
     } */


    if (offerdate != '') {
        if (offerdate <= currdatetime && $('#bid_last_date').prop('disabled') == false) {
            $('#spMsg').append("<li>Registration End Date or time should be greater than current date or time !! <li/>");
            flag = 1;
        }
    }
    /*
    if (openingdate != '') {
        if (openingdate <= currdatetime && $('#bid_opening_date').prop('disabled') == false) {
            $('#spMsg').append("<li>Opening date or time should be greater than current date or  time !! <li/>");
            flag = 1;
        }
    }*/
    if (starttime != '') {
        if (starttime <= currdatetime && $('#auction_start_date').prop('disabled') == false) {
            $('#spMsg').append("<li>Auction date or time should be greater than current date or time !! <li/>");
            flag = 1;
        }
    }

    if (endtime != "") {
        if (starttime >= endtime && $('#auction_end_date').prop('disabled') == false) {
            $('#spMsg').append("<li>Auction End date should be greater than Auction Start date or time !! <li/>");
            flag = 1;
        }

    }

    if (flag != 1) {
        if (nitdate != '' && FromInsdate != '') {
            //alert(FromInsdate+"|"+nitdate);
            if (FromInsdate <= nitdate) {
                $('#spMsg').append("<li>(From) inspection of asset date and time should be greater than Press Release Date or time !! </li>");
                flag = 1;
            }
        }

        if (ToInsdate != '' && FromInsdate != '') {
            if (FromInsdate >= ToInsdate) {
                $('#spMsg').append("<li>(To) inspection of asset date and time should be greater than (From) inspection of asset date or time !! </li>");
                flag = 1;
            }
        }

        if (ToInsdate != '' && offerdate != '') {
            if (ToInsdate >= offerdate) {
                $('#spMsg').append("<li>Opening date and time should be greater than (To) inspection of asset date or time !! </li>");
                flag = 1;
            }
        }

       
        if (starttime != '' && openingdate != '' && $('#bid_opening_date').prop('disabled') == false && $('#auction_end_date').prop('disabled') == false) {
            if (starttime <= openingdate) {
                $('#spMsg').append("Auction Start date and time should be greater than Opening date or time !! <br/>");
                flag = 1;
            }
        }






    }
    return flag;
}

function corivalidateSubmitform()
{	
	
    $('#spMsg').html("");
    flag = '';
    if ($('#remarks').val() == '') {
        $('#spMsg').append("<li>Please Enter remarks </li>");
        flag = 1;
    }
    /*
    if ($('#bid_inc').val() == '') {
		$('#spMsg').append("<li>Please Enter Bid Increment value</li>");
		flag = 1;
	}
	
    if (isNaN($('#bid_inc').val().trim()) == true) {
		$('#spMsg').append("<li>Please Enter Valid Bid Increment value</li>");
		flag = 1;
	}
    
    if ($('#bid_inc').val().trim() <= '0.99') {		
		$('#spMsg').append("<li>Please Enter Valid Bid Increment value</li>");
		flag = 1;
	}
	
    if ($('#supporting_doc').val() != '')
    {
        var ext = $('#supporting_doc').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx', 'zip']) == -1)
        {
            flag = 1;
            $("#spMsg").append("<li>Please Upload Valid Special terms and conditions  Document( Acceptable format are zip,gif,png,jpg,jpeg,pdf,doc,docx)</li>");
        }
    }
    if ($('#related_doc').val() != '')
    {
        var ext = $('#related_doc').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx', 'zip']) == -1)
        {
            flag = 1;
            $("#spMsg").append("<li>Please Upload Valid  Related Documents ( Acceptable format are zip,gif,png,jpg,jpeg,pdf,doc,docx)</li>");
        } else
        {
            var file_size = $('#related_doc')[0].files[0].size;
            slimit = (1024 * 1024) * parseInt(5);
            if (file_size > slimit)
            {
                flag = 1;
                $("#spMsg").append("<li>Please Upload file less than 5MB</li>");
            }
        }
    }

    if ($('#image').val() != '')
    {
        var ext = $('#image').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            flag = 1;
            $("#spMsg").append("<li>Please Upload Valid Image( Acceptable format are gif,png,jpg,jpeg)</li>");
        } else {
            var file_size = $('#image')[0].files[0].size;
            slimit = (1024 * 1024) * parseInt(5);
            if (file_size > slimit) {
                flag = 1;
                $("#spMsg").append("<li>Please Upload file less than 5MB</li>");
            }

        }
    }
	*/
    if (flag != 1) {
        returnFlag = CoriValidateDate();
        if (returnFlag == 1) {
            $("#showerror_msg").show();
            $(".inline").colorbox({inline: true, width: "50%"});
            $(".inline").click();
            return false;
        } else {
            return true;
        }

    } else {
        $("#showerror_msg").show();
        $(".inline").colorbox({inline: true, width: "50%"});
        $(".inline").click();
        return false;
    }

    return false;
    // return flag;
}

function ValidateEmdTenderDate() {
    //alert('dgfndfjbfgbfb');
    var instrument_date = "", dd_expire_date = "", currdatetime = "", instrument_type = "";
    var flag = '';
    var currdatetime = new Date($('#currdate').val());
    instrument_date = $('#instrument_date').val();
    dd_expire_date = $('#dd_expire_date').val();
    instrument_type = $('#instrument_type').val();


    if (instrument_date != '') {
        instrument_date = new Date(instrument_date);
    }
    if (dd_expire_date != '') {
        dd_expire_date = new Date(dd_expire_date);
    }

    if (instrument_date > currdatetime) {
        $('#spMsg').html("<li>Instrument date should not be greater than current date!! <li/>");
        flag = 1;
    }

    if ((dd_expire_date < currdatetime) && ($('#dd_expire_date').val() != '')) {
        $('#spMsg').html("<li>Instrument expiry date should not be smaller than current date!! <li/>");
        flag = 1;
    }

    /* if ($('#supporting_doc_path').val()!='') { //alert($('#supporting_doc_path').val());
     var ext = $('#supporting_doc_path').val().split('.').pop().toLowerCase();
     if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','doc','docx']) == -1){
     flag=1; 
     $("#spMsg").text("Please Upload Valid document file( Acceptable format are gif,png,jpg,jpeg,pdf,doc,docx)");
     }
     } */


    if ($('#instrument_no').val().length > 30 && instrument_type == 1) {
        $('#spMsg').html("<li>RTGS/NEFT RECIEPT No. can not be greater than 30 digit!! <li/>");
        flag = 1;
    } else if ($('#instrument_no').val().length > 6 && instrument_type == 2) {
        $('#spMsg').html("<li>DD No. can not be greater than 6 digit!!</li>");
        flag = 1;
    } else if ($('#instrument_no').val().length > 30 && instrument_type == 3) {
        $('#spMsg').html("<li>Chalan No. can not be greater than 30 digit!! <li/>");
        flag = 1;
    }
    if (flag == 1) {
        return false;
    } else {
        return true;
    }

}

function validateParticipate(submitval) {

    var reserve_price = '', tender_paid = '', emd_paid = '', documents_paid = '', quote_price = '';
    reserve_price = $('#reserve_price').val();
    tender_paid = $('#tender_paid').val();
    emd_paid = $('#emd_paid').val();
    documents_paid = $('#documents_paid').val();
    var emd_utr_paid = $('#emd_utr_paid').val();
    var administrative_utr_paid = $('#administrative_utr_paid').val();
    quote_price = $('#quote_price').val();
    var tender_fee_paid = $('#tender_fee_paid').val();
    var emd_amount_paid = $('#emd_amount_paid').val();
    var document_uploaded = $('#document_uploaded').val();
    var final_submit = $('#final_submit').val();
    var flag = '';
    if (submitval == 'save') {		
        //new start
        if (tender_fee_paid == '0') {
            $('#spMsg').html("<li>Please Complete Payment of Tender Fee!!<li/>");
            flag = 1;
        } else if (emd_amount_paid == '0') {
            $('#spMsg').html("<li>Please Complete Payment of Bank Processing Fee!!<li/>");
            flag = 1;
        } else if (document_uploaded == '0') {
            $('#spMsg').html("<li>Please Upload neccasary documents!!<li/>");
            flag = 1;
        } else if(emd_utr_paid == '')
        {
			$('#spMsg').html("<li>Please enter UTR details for EMD fee!!<li/>");
            flag = 1;
		}
		/*
		else if(administrative_utr_paid == '')
        {
			$('#spMsg').html("<li>Please enter UTR details for Administrative fee!!<li/>");
            flag = 1;
		}
		*/
        //new end
        else if (quote_price == '') {
            $('#spMsg').html("<li>Please Enter Quote Price.!!<li/>");
            flag = 1;
        } else if (parseFloat(quote_price) < parseFloat(reserve_price)) {
            $('#spMsg').html("<li>Quote Price should not less than Reserve Price!<li/>");
            flag = 1;
        }
    } else {		
        //new start
        if (tender_fee_paid == '0') {
            $('#spMsg').html("<li>Please Complete Payment of Tender Fee.!!<li/>");
            flag = 1;
        } else if (emd_amount_paid == '0') {
            $('#spMsg').html("<li>Please Complete Payment of Bank Processing Fee.<li/>");
            flag = 1;
        } else if (document_uploaded == '0') {
            $('#spMsg').html("<li>Please Upload neccasary documents.!!<li/>");
            flag = 1;
        } else if(emd_utr_paid == '')
        {
			$('#spMsg').html("<li>Please enter UTR details for EMD fee!!<li/>");
            flag = 1;
		}
		/*
		else if(administrative_utr_paid == '')
        {
			$('#spMsg').html("<li>Please enter UTR details for Administrative fee!!<li/>");
            flag = 1;
		}
		*/

        //new end
        else if (quote_price == '') {
            $('#spMsg').html("<li>Please Enter Quote Price.!!<li/>");
            flag = 1;
        } else if (tender_paid == '') {
            $('#spMsg').html("<li>Please Submit Event/Tender Fee Data.!!<li/>");
            flag = 1;
        } /*else if (emd_paid == '') {
            $('#spMsg').html("<li>Please Submit EMD Amount Data.!!<li/>");
            flag = 1;
        }*/ else if (documents_paid == '') {
            $('#spMsg').html("<li>Please Submit Particular Document.!!<li/>");
            flag = 1;
        } else if (parseFloat(quote_price) < parseFloat(reserve_price)) {
            $('#spMsg').html("<li>Quote Price should not less than Reserve Price!<li/>");
            flag = 1;
        } else if (final_submit == '0') {
            $('#spMsg').html("<li>Please submit quote price</li>");
            flag = 1;
        }
    }

    if (flag == 1) {
        $(".success_msg").hide();
        return false;
    } else {
		
		return true;
        /*var retVal = confirm("Do you want to continue ?");
        if (retVal == true) {
            return true;
        } else {
            return false;
        }*/
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
function updateAuctionStatus(activity_type, auctionID) {
    $.ajax({
        url: "/buyer/ajaxbidActivity",
        type: "post",
        data: "activity_type=" + activity_type + "&auctionID=" + auctionID,
        success: function (results) {
            window.location.reload(true);
        }
    });

}

function ShowRemainTimer(divID) {
    $('#' + divID).countdowntimer({
        dateAndTime: "2015/06/15 00:00:00",
        size: "lg",
        regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
        regexpReplaceWith: "$1<sup class='displayformat'>days</sup> / $2<sup class='displayformat'>hours</sup> / $3<sup class='displayformat'>minutes</sup> / $4<sup class='displayformat'>seconds</sup>"
    });
}

function increseORdecriseBidValue(increseType, aid, actualVal) {
    var mtxtValue = $("#bidder_bid_value_" + aid).val();
    var startmtxtValue = $("#manual_bidder_bid_value_"+aid).val();
    var h1val = $("#h1val_"+aid).val();
    if (mtxtValue != null) {
        if (mtxtValue > 0) {
            var mBidFactor = $("#bidder_bid_inc_" + aid).val();
            var mBidopeningPrice = $("#bid_opening_price_" + aid).val();
            //alert(mBidFactor);
            if (mBidFactor != null) {
                if (increseType == 'increase')
                {
                    clicks += 1;
                    if (clicks == 4)
                    {
						//sweetAlert('Alert!', 'This bid is higher than 3 bid increments.\n Are you sure you want to submit this bid?', 'warning');
						
						/*$.alert({
							title: 'Alert!',							
							content: 'This bid is higher than 3 bid increments.\n Are you sure you want to submit this bid?',
						});
						*/ 
                        //alert("This bid is higher than 3 bid increments.\n Are you sure you want to submit this bid?");
                    }
                    cal = parseInt(mtxtValue) + parseInt(mBidFactor);
                    cal = cal.toFixed(2);
                    $("#bidder_bid_value_" + aid).val(cal);
                    $("#error_" + aid).html('');
                    //showText();
                    $("#bidder_bid_value_" + aid).change();
                    var areaVal = $("#areaVal_" + aid).val();
                    var totalVal = areaVal * $("#bidder_bid_value_" + aid).val();
                    $("#total_bid_val_" + aid).val(totalVal);

                } else
                {
					cal = parseInt(startmtxtValue); //+ parseInt(mBidFactor)
                    cal = cal.toFixed(2);
                    //alert(mtxtValue +' | '+ cal);
                    if (mtxtValue <= cal) {
						if(h1val != '' && h1val<= cal)
						{
							$error = "You have to submit bid higher than H1 price.";
							$("#error_" + aid).html($error);
							
						}
						else
						{
							$error = "You have to submit bid higher than Bid start price(BSP).";
							$("#error_" + aid).html($error);
						}
                    }
                    else {
                        $("#error_" + aid).html('');
                        cal = parseInt(mtxtValue) - parseInt(mBidFactor);
                        cal = cal.toFixed(2);
                        $("#bidder_bid_value_" + aid).val(cal);
                        //showText();
                        $("#bidder_bid_value_" + aid).change();
                        var areaVal = $("#areaVal_" + aid).val();
                        var totalVal = areaVal * $("#bidder_bid_value_" + aid).val();
                        $("#total_bid_val_" + aid).val(totalVal);
                    }
                }
            }
        }
    }
    return false;
}


function saveLiveAuctionBid(aid) {
    var max_auto_bid = parseInt($("#max_auto_bid_" + aid).val());
    var bidValue = parseFloat($("#bidder_bid_value_" + aid).val());
    var lastbidtextval = parseInt($("#lastbidtextval_" + aid).val());
    var bidder_bid_inc = $("#bidder_bid_inc_" + aid).val();
    var enteredbidtype = $("#enteredbidtype_" + aid).val();
    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    var auctionID = aid;
    calVal = parseFloat(bidValue) - parseFloat(lastbidtextval);
    mod = parseFloat(calVal) % parseFloat(bidder_bid_inc);
    
    swal({
		  title: "Confirm",
		  text: 'You are about to submit a bid of '+bidValue,
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: "Submit",
		  cancelButtonText: "Cancel"		  
		}).then(function () {
			if (enteredbidtype == 'opening_bid') {
				if (bidValue == '') {
					$("#error_" + aid).html('Please enter a some value to submit.');
					saveInvalidBid(aid, 'Please enter a some value to submit.');
					return false;
				} else if (isNaN(bidValue))
				{
					$("#error_" + aid).html('You are not allowed to enter Zero or Negative values.');
					saveInvalidBid(aid, 'You are not allowed to enter Zero or Negative values.');
					return false;
				} else if (mod > 0)
				{
					$("#error_" + aid).html('Please enter valid multiple of Bid Increment.');
					saveInvalidBid(aid, 'Please enter valid multiple of Bid Increment.');
					return false;
				} else if (bidValue == max_auto_bid)
				{
					$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
					saveInvalidBid(aid, 'Bid not Submitted. Please submit a value higher than H1 price.');
					return false;
				} else if (bidValue < lastbidtextval)
				{
					$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
					saveInvalidBid(aid, 'Bid not Submitted. Please submit a value higher than H1 price.');
					return false;
				} else {
					$.ajax({
						url: "/bidder/saveLiveauctionBid",
						type: "post",
						data: "bidValue=" + bidValue + "&auctionID=" + auctionID + "&enteredbidtype=" + enteredbidtype + "&lastbidtextval=" + lastbidtextval + "&bidder_bid_inc=" + bidder_bid_inc + "&csrf_test_name=" + csrf_token,
						success: function (results) {
							//alert(results);
							if (results == 'success')
							{
								window.location.reload(true);
							} else {
								$("#error_" + aid).html(results);
							}

						}
					});
				}

			} else {

				if (bidValue == '') {
					$("#error_" + aid).html('Please enter a some value to submit.');
					saveInvalidBid(aid, 'Please enter a some value to submit.');
					return false;
				} else if (isNaN(bidValue))
				{
					$("#error_" + aid).html('You are not allowed to enter Zero or Negative values.');
					saveInvalidBid(aid, 'You are not allowed to enter Zero or Negative values.');
					return false;
				} else if (mod > 0)
				{
					$("#error_" + aid).html('Please enter valid multiple of Bid Increment.');
					saveInvalidBid(aid, 'Please enter valid multiple of Bid Increment.');
					return false;
				} else if (bidValue == max_auto_bid)
				{
					$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
					$.ajax({
						url: "/bidder/saveLiveauctionBid",
						type: "post",
						data: "bidValue=" + bidValue + "&auctionID=" + auctionID + "&enteredbidtype=" + enteredbidtype + "&lastbidtextval=" + lastbidtextval + "&bidder_bid_inc=" + bidder_bid_inc + "&csrf_test_name=" + csrf_token,
						success: function (results) {
							//$("#error_"+aid).html(results); 
							//window.location.reload(true);
							if (results == 'success')
							{
								window.location.reload(true);
							} else {
								$("#error_" + aid).html(results);
							}
						}
					});
					return false;
				} else if (bidValue <= lastbidtextval)
				{
					$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
					saveInvalidBid(aid, 'Bid not Submitted. Please submit a value higher than H1 price.');
					return false;
				} else {
					$.ajax({
						url: "/bidder/saveLiveauctionBid",
						type: "post",
						data: "bidValue=" + bidValue + "&auctionID=" + auctionID + "&enteredbidtype=" + enteredbidtype + "&lastbidtextval=" + lastbidtextval + "&bidder_bid_inc=" + bidder_bid_inc + "&csrf_test_name=" + csrf_token,
						success: function (results) {

							if (results == 'success')
							{
								window.location.reload(true);
							} else {
								$("#error_" + aid).html(results);
							}

						}
					});
				}

			}
	  /*swal(
		'Submitted!',
		'Bid Submitted Successfully.',
		'success'
	  )*/
	}, function (dismiss) {
		  // dismiss can be 'cancel', 'overlay',
		  // 'close', and 'timer'
		  if (dismiss === 'cancel') {
		   swal("Cancelled", "Bid Not Submitted", "error")
		  }
	})

}


function saveInvalidBid(aid, error_msg)
{
    var max_auto_bid = parseInt($("#max_auto_bid_" + aid).val());
    var bidValue = parseFloat($("#bidder_bid_value_" + aid).val());
    var lastbidtextval = parseInt($("#lastbidtextval_" + aid).val());
    var bidder_bid_inc = $("#bidder_bid_inc_" + aid).val();
    var enteredbidtype = $("#enteredbidtype_" + aid).val();
    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    var auctionID = aid;
    calVal = parseFloat(bidValue) - parseFloat(lastbidtextval);
    mod = parseFloat(calVal) % parseFloat(bidder_bid_inc);

    $.ajax({
        url: "/bidder/saveLiveauctionBidInvalid",
        type: "post",
        data: "bidValue=" + bidValue + "&auctionID=" + auctionID + "&enteredbidtype=" + enteredbidtype + "&lastbidtextval=" + lastbidtextval + "&bidder_bid_inc=" + bidder_bid_inc + "&error_msg=" + error_msg + "&csrf_test_name=" + csrf_token,
        success: function (results) {

            if (results == 'success')
            {
                window.location.reload(true);
            } else {
                $("#error_" + aid).html(results);
            }

        }
    });
}


//.
function saveAutobidLiveAuctionBid(aid) {
    var max_auto_bid = parseInt($("#max_auto_bid_" + aid).val());
    var autobidValue = parseInt($("#bidder_autobid_value_" + aid).val());
    var manualValue = $("#manual_bidder_bid_value_" + aid).val();
    var lastbidtextval = parseInt($("#lastbidtextval_" + aid).val());
    var bidder_bid_inc = $("#bidder_bid_inc_" + aid).val();
    var enteredbidtype = $("#enteredbidtype_" + aid).val();
    var auctionID = aid;
    calVal = parseFloat(autobidValue) - parseFloat(lastbidtextval);
    mod = parseFloat(calVal) % parseFloat(bidder_bid_inc);
    //alert(max_auto_bid  +"--"+autobidValue);
   if (!isNaN(autobidValue))
    {
		swal({
			  title: "Confirm",
			  text: 'You are about to submit a auto bid of '+autobidValue,
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: "Submit",
			  cancelButtonText: "Cancel"		  
			}).then(function () {
				if (enteredbidtype == 'opening_bid')
				{
				
					if (autobidValue == '') {
						$("#error_" + aid).html('Please enter a some value to submit.');
						swal("Error", "Please enter a some value to submit.", "error")
						return false;
					} else if (isNaN(autobidValue))
					{
						$("#error_" + aid).html('You are not allowed to enter Zero or Negative values.');
						swal("Error", "You are not allowed to enter Zero or Negative values.", "error")
						return false;
					} else if (mod > 0)
					{
						$("#error_" + aid).html('Please enter valid multiple of Bid Increment.');
						swal("Error", "Please enter valid multiple of Bid Increment.", "error")
						return false;
					} else if (autobidValue == max_auto_bid)
					{
						$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
						swal("Error", "Bid not Submitted. Please submit a value higher than H1 price.", "error")
						return false;
					} else if (autobidValue < lastbidtextval)
					{
						$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
						swal("Error", "Bid not Submitted. Please submit a value higher than H1 price.", "error")
						return false;
					} else {
						//alert("yrdddd");
						$.ajax({
							url: "/bidder/saveAutoCutOffLiveauctionBid",
							type: "post",
							data: "bidValue=" + autobidValue + "&auto_bid=" + autobidValue + "&auctionID=" + auctionID + "&manualValue=" + manualValue + "&lastbidtextval=" + lastbidtextval + "&bidder_bid_inc=" + bidder_bid_inc + "&enteredbidtype=" + enteredbidtype,
							success: function (results) {
								//alert(results);
								if (results == 'success')
								{
									//window.location.reload(true);	 
									window.location.href = '/owner/buylistLiveAuctions/' + aid;
								} else {
									//$("#error_" + aid).html(results);
									swal("Error", results, "error")
									setTimeout(function () {
										window.location.reload(true);
									}, 3000);
									

								}

								//window.location.reload(true);	
							}
						});
					}

				} else {
			
				if (autobidValue == '') {
					$("#error_" + aid).html('Please enter a some value to submit.');
					swal("Error", "Please enter a some value to submit.", "error")
					return false;
				} else if (isNaN(autobidValue))
				{
					
					$("#error_" + aid).html('You are not allowed to enter Zero or Negative values.');
					swal("Error", "You are not allowed to enter Zero or Negative values.", "error")
					return false;
				} else if (mod > 0)
				{					
					$("#error_" + aid).html('Please enter valid multiple of Bid Increment.');
					swal("Error", "Please enter valid multiple of Bid Increment.", "error")
					return false;
				} else if (autobidValue == max_auto_bid)
				{
					
					$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
					swal("Error", "Bid not Submitted. Please submit a value higher than H1 price.", "error")
					
					$.ajax({
						url: "/bidder/saveAutoCutOffLiveauctionBid",
						type: "post",
						data: "bidValue=" + autobidValue + "&auto_bid=" + autobidValue + "&auctionID=" + auctionID + "&manualValue=" + manualValue + "&lastbidtextval=" + lastbidtextval + "&bidder_bid_inc=" + bidder_bid_inc,
						success: function (results) {
							$("#error_" + aid).html(results);
							//window.location.reload(true);
							setTimeout(function () {
								window.location.href = '/owner/buylistLiveAuctions/' + aid;
							}, 2000);

						}
					});
					return false;
				} else if (autobidValue <= lastbidtextval)
				{
					$("#error_" + aid).html('Bid not Submitted. Please submit a value higher than H1 price.');
					swal("Error", "Bid not Submitted. Please submit a value higher than H1 price.", "error")
					return false;
				} else {
					$.ajax({
						url: "/bidder/saveAutoCutOffLiveauctionBid",
						type: "post",
						data: "bidValue=" + autobidValue + "&auto_bid=" + autobidValue + "&auctionID=" + auctionID + "&manualValue=" + manualValue + "&lastbidtextval=" + lastbidtextval + "&bidder_bid_inc=" + bidder_bid_inc,
						success: function (results) {
							//alert(results);
							if (results == 'success')
							{
								//window.location.reload(true);	 
								window.location.href = '/owner/buylistLiveAuctions/' + aid;
							} else {
								$("#error_" + aid).html(results);
							}

							//window.location.reload(true);	
						}
					});
				}
			}
			  /*swal(
				'Submitted!',
				'Bid Submitted Successfully.',
				'success'
			  )*/
		}, function (dismiss) {
			  // dismiss can be 'cancel', 'overlay',
			  // 'close', and 'timer'
			  if (dismiss === 'cancel') {
			   swal("Cancelled", "Auto Bid Not Submitted", "error")
			  }
		})
	}
   
}

function showBidders(showval) {
    if (showval == 1) {
        $("#show_bidder").show();
    } else {
        $("#show_bidder").hide();
    }
}

function showhidedropdown()
{
    $(".login_dropdown").slideToggle();
}

function savefavorite(bankID) {
    if (confirm("Are You Sure Want to a add in Follow List ")) {
        $.ajax({
            url: "/owner/savefavorite",
            type: "post",
            data: "bankID=" + bankID,
            success: function (results) {
                window.location.reload(true);
            }
        });

    }
}

function removefollowsearchList(bankID) {

    if (confirm("Are You Sure Want to a Remove from Follow List ")) {
        $.ajax({
            url: "/owner/removefollows",
            type: "post",
            data: "bankID=" + bankID,
            success: function (results) {
                window.location.reload(true);
            }
        });

    }
}


function buyOwnerDashboardData(key, section, keytype)
{
    if (section == 'sell') {
        formaction = '/owner/ajaxSellDashboardData';
    } else if (section == 'banker') {

        formaction = '/buyer/ajaxdashboard';
    } else {
        formaction = '/owner/ajaxBuyDashboardData';
    }
    $.ajax({
        url: formaction,
        type: "post",
        data: "key=" + key + "&section=" + section + "&keytype=" + keytype,
        success: function (results) {
            $.each(JSON.parse(results), function (idx, obj) {
                if (idx == 'auctionConducted') {
                    $('#auctionConducted').html(obj);
                }
                if (idx == 'activeAuction') {
                    $('#activeauction').html(obj);
                }
                if (idx == 'propertyPosted') {
                    $('#propertyPosted').html(obj);
                }
                if (idx == 'activeProperties') {
                    $('#activeProperties').html(obj);
                }
                if (idx == 'interestedUsers') {
                    $('#interestedUsers').html(obj);
                }
                if (idx == 'auc_participated') {
                    $('#auc_participated').html(obj);
                }
                if (idx == 'auc_own') {
                    $('#auc_own').html(obj);
                }
                if (idx == 'auc_active') {
                    $('#auc_active').html(obj);
                }
                if (idx == 'requirementPosted') {
                    $('#requirementPosted').html(obj);
                }
                if (idx == 'responseReceived') {
                    $('#responseReceived').html(obj);
                }
                if (idx == 'propertyViewed') {
                    $('#propertyViewed').html(obj);
                }

                if (idx == 'total_invoice_reaised') {
                    $('#total_invoice_reaised').html(obj);
                }

                if (idx == 'bankactiveAuction') {
                    $('#bankactiveAuction').html(obj);
                }

                if (idx == 'payment_due') {
                    $('#payment_due').html(obj);
                }

                if (idx == 'outstanding_amount') {
                    $('#outstanding_amount').html(obj);
                }
            });
        }
    });
    return true;
}

function showWidght() {
    jQuery('.auction_prowidget').mouseover(function () {
        $('.overlay').hide();
        $(this).children('.overlay').show();
    });
    jQuery('.auction_prowidget').mouseout(function () {
        $('.overlay').hide();
    });
}

function propertyTypeList(auctionType) {
    window.location.href = "/property?act=" + auctionType;
}

function processform() {
    $('#property_serch').submit()
}
function propertyList(querystring) {
    auction_type = $('#auction_type').val();
}

jQuery(document).ready(function ($) {
    $('.close').click(function () {
        $(".popupcontainer").html('');
        $('.bidderHolePopup').hide();
        location.reload();
    });
});
function bidderHoleinfoPopup(infotype, auctionID) {

    if (infotype == 'uploaded_file') {
        $(".popupcontainer").load('/buyer/view_uploadedfile/' + auctionID);
    } else if (infotype == 'uploaded_file_v') {
        $(".popupcontainer").load('/bankviewer/view_uploadedfile/' + auctionID);
    } else if (infotype == 'bidder_detail') {
        $(".popupcontainer").load('/buyer/view_bid_history/' + auctionID);
    } else if (infotype == 'bidder_detail_v') {
        $(".popupcontainer").load('/bankviewer/view_bid_history/' + auctionID);
    } else if (infotype == 'eventDetaillist') {
        $(".popupcontainer").load('/buyer/eventDetailbidderHole/' + auctionID);
    } else if (infotype == 'viewBidders') {
        $(".popupcontainer").load('/helpdesk_executive/viewBidders/' + auctionID);
    } else if (infotype == 'viewauctionDetail') {
        $(".popupcontainer").load('/helpdesk_executive/eventDetailbidderHole/' + auctionID);
    } else if (infotype == 'owner_uploaded_file') {

        $(".popupcontainer").load('/owner/view_uploadedfile/' + auctionID);
    } else if (infotype == 'owner_bid_history') {
        $(".popupcontainer").load('/owner/view_own_bid_history/' + auctionID);
    } else if (infotype == 'owner_eventDetaillist') {

        $(".popupcontainer").load('/owner/eventDetailbidderHole/' + auctionID);
    } else if (infotype == 'owner_agreement_privacy_policy') {

        $(".popupcontainer").load('/owner/owneragreementprivacypolicy/' + auctionID);
    }
    $('.bidderHolePopup').toggle('explode');
}

function removeAttributeVal(searchtype, field_name)
{
    if (searchtype == 'propertytype')
    {
        $("#" + field_name).prop("checked", false);
        $("#property_serch").submit();
    } else if (searchtype == 'category')
    {

        $("#" + field_name).prop("checked", false);
        $("#property_serch").submit();

    } else if (searchtype == 'subcategory')
    {

        $("#subcate_" + field_name).prop("checked", false);
        $("#property_serch").submit();

    } else if (searchtype == 'postedby')
    {
        var x = document.getElementById("multiple-selected-postedby").options.length;
        for (i = 0; i < x; i++)
        {
            var xv = document.getElementById("multiple-selected-postedby").options[i].value;
            if (field_name == xv) {
                $("#multiple-selected-postedby option[value='" + field_name + "']").prop("selected", false);
                $("#property_serch").submit();
            }
        }

    } else if (searchtype == 'bank')
    {
        $("#banknameID_" + field_name).prop("checked", false);
        $("#property_serch").submit();
    }

}

function addViewGrid(vale) {
    $("#gridview").val(vale);
    $("#property_serch").submit();
}

function sortBydata(vale) {
    $("#sort_bydata").val(vale);
    $("#property_serch").submit();
}
function limitPerdata(vale) {
    $("#limit_perpagedata").val(vale);
    $("#property_serch").submit();
}
function searchCalenderData(key) {
    $.ajax({
        url: "/auction_calender/seachcalenderData",
        type: "post",
        data: "key=" + key,
        success: function (results) {
            //alert(results)
            $("#tabledata").html(results);
        }
    });


}
function loadAllReviewsData(pid) {
    $.ajax({
        url: "/property/allratingReview",
        type: "post",
        data: "pid=" + pid,
        success: function (results) {
            //alert(results);
            $("#reviewsList").html(results);
        }
    });
}
function is_accept_tc_update(aid) {
    $.ajax({
        url: "/owner/is_accept_tc_update",
        type: "post",
        data: "aid=" + aid,
        success: function (results) {
            //alert(results);
            $("#is_accept_tc_upid_" + aid).html(results);
            window.location.reload();
        }
    });
}


function showsubcategry(category, atype) {
    var subcate = $('#type').val();
    if (atype == 'executive')
    {
        actiontype = 'helpdesk_executive';
    } else if (atype == 'bank') {
        actiontype = 'buyer';
    } else if (atype == 'approver') {
        actiontype = 'buyerApprover';
    } else if (atype == 'admin') {
        actiontype = 'admin/corrigendum';
    } else {
        actiontype = 'owner';
    }

    $.ajax({
        url: "/" + actiontype + "/showsubcategorydata",
        type: "post",
        data: "category=" + category + "&subcate" + subcate,
        success: function (results) {
            // alert(results);
            if (atype == 'owner')
            {
                $("#property_type").html(results);
            } else {
                $("#type").html(results);
            }
        }
    });

}

function submitSubcatform() {
    $("#property_serch").submit();
}

function showbidder_detail() {
    if ($("#confirmbidder").is(":checked") == true)
    {
        $("#showbidder_detail").fadeIn();
    } else {
        $("#showbidder_detail").fadeOut();
    }
}


function closehomesearch(typeval, ptype) {

    if (ptype == 'home') {
        if (typeval == 'hide') {
            $(".static-home-search").animate({left: '-400px'});
            //$('.static-home-search').css({'display' : 'none'});
        } else {
            $('.static-home-search').css({'display': 'block'});
            $(".static-home-search").animate({left: '0px'});
        }
    } else {
        if (typeval == 'hide') {
            $(".static-inside-search").animate({left: '-400px'});
            //$('.static-home-search').css({'display' : 'none'});
        } else {
            //$('.static-inside-search').css({'display' : 'block'});
            $(".static-inside-search").animate({left: '0px'});
        }



    }
}

function favFunction(productId) {
    $.ajax({
        type: "post",
        url: "/property/savefavourite",
        data: "productId=" + productId,
        success: function (retrunData) {
            if (retrunData == 1) {
                //$("#favmsg"+productId).show();
                $('.fevoriteLogo_' + productId).addClass('ac-fav');
                //alert('favourites Added Successfully');
                //$("#favmsg"+productId).css({"color": "green", "font-size": "small"}); 
                //$("#favmsg"+productId).html('favourites Added Successfully');
                //$("#favmsg"+productId).delay(5000).fadeOut('slow');
            } else {
				sweetAlert('Alert!', 'This Property already added in your favourite list.', 'error');
                //alert('This Property already added in your favourite list');
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
    } else {
        return false;
    }
}

function submitForgotPassword(utype) {	
	var flag = '';
    email = $("#forgotemail").val();
    if (email != '') {

        if (validateEmail(email)) {
			/*
            $.ajax({
                url: "/registration/forgotPassword",
                type: "post",
                data: "utype=" + utype + "&email=" + email,
                success: function (results) {
                    //alert(results);
                    $("#forgot_email").html(results);
                }
            });
            */            
        } else {
            $("#forgot_email").html('Please Enter Valid User ID / Email!');
            flag =1;
        }
    } else {
        $("#forgot_email").html('Please Enter User ID / Email!');
        flag =1;
    }
    
    if($("#fp_captcha").val() == "")
     {
		 $(".field-signupform-captcha").text("Please enter captcha code.");
        flag='1';
	 }
	 else if ($("#fp_captcha").val().length < 6) 
	 {
        $(".field-signupform-captcha").text("Please enter valid captcha code.");
        flag='1';
     }
     else
     {
		 var rand = Math.random() * 10000000000000000;
			$.ajax({
				url: "/registration/checkforgetCaptchaCode/"+$("#fp_captcha").val()+"/?rand="+rand, 
				async: false,
				success: function(result){
					if(result != "success")
					{
						$("#captcha_cont").html(result);
						$(".field-signupform-captcha").text("Please enter valid captcha code.");
						flag='1';	
					}
				}
			});
		
	 }
    
    
	if (flag == 1) {
        return false;
    } else {
         $( "#formValidateForgot" ).trigger( "submit" );
    }

}

function submitResetPassword(utype) {
	var status = '';
    
    
     if($("#newpassword").val()==''){
       status='1';
       $(".field-signupform-password").text("New Password cannot be blank");
      }
      
    if($("#newpassword").val()!='')
    {		
		 var password = $("#newpassword").val();
		 var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,30}$/; 
		 if(!password.match(decimal))
		 { 
			status='1'; 
		    $(".field-signupform-password").text('New Password should contain minimum 8 digits/letters, 1 Uppercase Letter with Special character.(Do not use $,<,>,&,#) )');
		 }
		 else
		 { 			 
			 var pattern = /[$<>&-]/;
			 if(password.match(pattern)) {
				$(".field-signupform-password").text('New Password should contain minimum 8 digits/letters, 1 Uppercase Letter with Special character.(Do not use $,<,>,&,#) )');
			 }
			
		 }  
    }
    if($("#re_password").val()==''){
      status='1';
      $(".field-signupform-cpassword").text("Confirm Password cannot be blank");
    }
    if($("#re_password").val()!=''&& $("#newpassword").val()!=''){   
      var n = $("#newpassword").val().localeCompare($("#re_password").val());
    if(n!='0'){  
      status='1'; 
      $(".field-signupform-cpassword").text("Confirm password Should be equal to New Password");
     }
    }
       
    
	if (status == 1) {
        return false;
    } else {
         $( "#resetPassword" ).trigger( "submit" );
    }

}

function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;

    //if (charCode != 46  && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57))
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    } else {
        return true;
    }
}

function ImageValidate(field_name, sizelimit) {
    //2097152
    //$("#file_error").html("");
    //$(".demoInputBox").css("border-color","#F0F0F0");
    $(".images_error" + field_name).remove();
    var file_size = $('#' + field_name)[0].files[0].size;
    slimit = (1024 * 1024) * parseInt(sizelimit);
    if (file_size > slimit) {
        //$("#file_error").html("File size is greater than 2MB");
        $("#" + field_name).val('');
        $("<span class='images_error" + field_name + "' style='color:red;'>File size is greater then " + sizelimit + "MB.</span>").insertAfter("#" + field_name);
        return false;
    } else {
        $(".images_error" + field_name).remove();
        return true;
    }
}

function checkboxval(lid, id) {
    //chkname=jQuery(this).attr("id");
    var count_checked = $("[name='form_field_" + id + "[]']:checked").length;
    if (count_checked > 0)
    {
        $("#" + id).val('yes');
    } else {
        $("#" + id).val('');
    }
}
/*		
 function numToWords(number) {
 //Validates the number input and makes it a string
 if (typeof number === 'string') {
 number = parseInt(number, 10);
 }
 if (typeof number === 'number' && isFinite(number)) {
 number = number.toString(10);
 } else {
 return 'This is not a valid number';
 }
 
 //Creates an array with the number's digits and
 //adds the necessary amount of 0 to make it fully 
 //divisible by 3
 var digits = number.split('');
 while (digits.length % 3 !== 0) {
 digits.unshift('0');
 }
 
 
 //Groups the digits in groups of three
 var digitsGroup = [];
 var numberOfGroups = digits.length / 3;
 for (var i = 0; i < numberOfGroups; i++) {
 digitsGroup[i] = digits.splice(0, 3);
 }
 // console.log(digitsGroup); //debug
 
 //Change the group's numerical values to text
 var digitsGroupLen = digitsGroup.length;
 var numTxt = [
 [null, 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'], //hundreds
 [null, 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'], //tens
 [null, 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'] //ones
 ];
 var tenthsDifferent = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
 
 // j maps the groups in the digitsGroup
 // k maps the element's position in the group to the numTxt equivalent
 // k values: 0 = hundreds, 1 = tens, 2 = ones
 for (var j = 0; j < digitsGroupLen; j++) {
 for (var k = 0; k < 3; k++) {
 var currentValue = digitsGroup[j][k];
 digitsGroup[j][k] = numTxt[k][currentValue];
 if (k === 0 && currentValue !== '0') { // !==0 avoids creating a string "null hundred"
 digitsGroup[j][k] += ' lakh ';
 } else if (k === 1 && currentValue === '1') { //Changes the value in the tens place and erases the value in the ones place
 digitsGroup[j][k] = tenthsDifferent[digitsGroup[j][2]];
 digitsGroup[j][2] = 0; //Sets to null. Because it sets the next k to be evaluated, setting this to null doesn't work.
 }
 }
 }
 // console.log(digitsGroup); //debug
 //Adds '-' for gramar, cleans all null values, joins the group's elements into a string
 for (var l = 0; l < digitsGroupLen; l++) {
 if (digitsGroup[l][1] && digitsGroup[l][2]) {
 //digitsGroup[l][1] += '-';
 digitsGroup[l][1] += ' ';
 }
 digitsGroup[l].filter(function (e) {return e !== null});
 digitsGroup[l] = digitsGroup[l].join('');
 }
 
 // console.log(digitsGroup); //debug
 
 //Adds thousand, millions, billion and etc to the respective string.
 var posfix = [null, 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion'];
 if (digitsGroupLen > 1) {
 var posfixRange = posfix.splice(0, digitsGroupLen).reverse();
 for (var m = 0; m < digitsGroupLen - 1; m++) { //'-1' prevents adding a null posfix to the last group
 if (digitsGroup[m]) {
 digitsGroup[m] += ' ' + posfixRange[m];
 }
 }
 }
 //console.log(digitsGroup); //debug
 
 //Joins all the string into one and returns it
 //alert("("+digitsGroup.join(' ')+")");
 return "("+digitsGroup.join(' ')+")";
 
 } 
 
 */


function numToWords(value) {
    var fraction = Math.round(frac(value) * 100);
    var f_text = "";

    if (fraction > 0) {
        f_text = "AND " + convert_number(fraction);//+" PAISE"
    }

    return convert_number(value); //+" RUPEE "+f_text+" ONLY"
}

function frac(f) {
    return f % 1;
}

function convert_number(number)
{
    if ((number < 0) || (number > 999999999))
    {
        return "NUMBER OUT OF RANGE!";
    }
    var Gn = Math.floor(number / 10000000);  /* Crore */
    number -= Gn * 10000000;
    var kn = Math.floor(number / 100000);     /* lakhs */
    number -= kn * 100000;
    var Hn = Math.floor(number / 1000);      /* thousand */
    number -= Hn * 1000;
    var Dn = Math.floor(number / 100);       /* Tens (deca) */
    number = number % 100;               /* Ones */
    var tn = Math.floor(number / 10);
    var one = Math.floor(number % 10);
    var res = "";

    if (Gn > 0)
    {
        res += (convert_number(Gn) + " CRORE");
    }
    if (kn > 0)
    {
        res += (((res == "") ? "" : " ") +
                convert_number(kn) + " LAKH");
    }
    if (Hn > 0)
    {
        res += (((res == "") ? "" : " ") +
                convert_number(Hn) + " THOUSAND");
    }

    if (Dn)
    {
        res += (((res == "") ? "" : " ") +
                convert_number(Dn) + " HUNDRED");
    }


    var ones = Array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN", "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN", "NINETEEN");
    var tens = Array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY", "SEVENTY", "EIGHTY", "NINETY");

    if (tn > 0 || one > 0)
    {
        if (!(res == ""))
        {
            res += " AND ";
        }
        if (tn < 2)
        {
            res += ones[tn * 10 + one];
        } else
        {

            res += tens[tn];
            if (one > 0)
            {
                res += ("-" + ones[one]);
            }
        }
    }

    if (res == "")
    {
        res = "zero";
    }
    return res;
}

function checkvaliddocumentimage() {
    var message = [];
    var status = 0;
    var mctr = 1;
    $('.input').each(function () {
		var oldDocs = $("#old_doc_name_" + mctr).val();
		var input_id = $(this).attr('id');	
		
		if(input_id != 'doc_name_16')
		{	
			if (this.value == '') {
				message[mctr] = "<li>Please Upload  " + $("#doc_" + mctr).val() + "</li>";
				status = 1;
			}
			if (this.value != '' && this.value != 'Nan')
			{
				var ext = this.value.split('.').pop().toLowerCase();

				if ($.inArray(ext, ['jpg','pdf']) == -1) { //, 'doc', 'docx', 'zip', 'gif', 'png',  'jpeg', 
					message[mctr] = "<li>Please Upload Valid " + $("#doc_" + mctr).val() + " ( Acceptable format are jpg, pdf)</li>"; //, doc, docx, zip, gif, png, jpeg 
					status = 1;
				} else {
					var file_size = this.files[0].size;
					slimit = (1024 * 1024) * parseInt(5);
					if (file_size > slimit) {
						status = '1';
						message[mctr] = "<li>Please Upload  " + $("#doc_" + mctr).val() + " File less than 5MB</li>";
					}
				}

			}
		}
        mctr++;
    });

    if (status == 1) {
        $(".error_class").html(message.toString().replace(/,/g, ''));
        return false;
    } else {
        return true;
    }
}


function removefromlivefavlist(auctionID)
{


    if (confirm('Are you sure want to remove from Favourite Live and Upcoming Auction?')) {
        if (auctionID) {

            jQuery.ajax({
                url: '/owner/liveupcomingauciton_fav_remove',
                type: 'POST',
                data: {
                    auctionID: auctionID,
                    message: "Remove Successfully"
                },
                success: function (data) {
                    //alert(data);
                }
            });
        }
    }

}



function addtolivefavlist(auctionID)
{
    if (confirm('Are you sure want to Added in Favourite Auction?')) {
        if (auctionID) {

            jQuery.ajax({
                url: '/owner/liveupcomingauciton_fav_add',
                type: 'POST',
                data: {
                    auctionID: auctionID,
                    message: "Added Successfully"
                },
                success: function (data) {
                    //alert(data);
                }
            });
        }
    }

}

function addtoeventfavlist(auctionID)
{
    
    swal({
		  title: "Confirm",
		  text: 'Are you sure want to Added in Favourite Event?',
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: "Yes",
		  cancelButtonText: "No"		  
		}).then(function () {
			
			if (auctionID) {

            jQuery.ajax({
                url: '/owner/liveupcomingauciton_event_add',
                type: 'POST',
                data: {
                    auctionID: auctionID,
                    message: "Added Successfully"
                },
                success: function (data) {
                    //alert(data);
                    var rand = Math.random() * 10000000000000000;
                    location.href = "?rand=" + rand;
                }
            });
        }
	})
    
    
    
    /*
    if (confirm('Are you sure want to Added in Favourite Event?')) {
        if (auctionID) {

            jQuery.ajax({
                url: '/owner/liveupcomingauciton_event_add',
                type: 'POST',
                data: {
                    auctionID: auctionID,
                    message: "Added Successfully"
                },
                success: function (data) {
                    //alert(data);
                    var rand = Math.random() * 10000000000000000;
                    location.href = "?rand=" + rand;
                }
            });
        }
    }
	*/
}

function removefromlivefavEventlist(auctionID)
{
	swal({
		  title: "Confirm",
		  text: 'Are you sure want to remove from Favourite Event?',
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: "Yes",
		  cancelButtonText: "No"		  
		}).then(function () {
			
			if (auctionID) {

            jQuery.ajax({
                url: '/owner/liveupcomingauciton_favevent_remove',
                type: 'POST',
                data: {
                    auctionID: auctionID,
                    message: "Remove Successfully"
                },
                success: function (data) {
                    //alert(data);
                    var rand = Math.random() * 10000000000000000;
                    location.href = "?rand=" + rand;
                }
            });
        }
	})
	
	/*
    if (confirm('Are you sure want to remove from Favourite Event?')) {
        if (auctionID) {

            jQuery.ajax({
                url: '/owner/liveupcomingauciton_favevent_remove',
                type: 'POST',
                data: {
                    auctionID: auctionID,
                    message: "Remove Successfully"
                },
                success: function (data) {
                    //alert(data);

                    var rand = Math.random() * 10000000000000000;
                    location.href = "?rand=" + rand;
                }
            });
        }
    }
    */ 

}
function showBranch(bankid, atype) {

    if (atype == 'executive')
    {
        actiontype = 'helpdesk_executive';
    } else if (atype == 'bank') {
        actiontype = 'buyer';
    } else if (atype == 'admin') {
        actiontype = 'admin/corrigendum';
    } else {
        actiontype = 'owner';
    }

    $("#bank_name1").val(bankid);
    $("#bank_name").val(bankid);
    $("#nodal_bank_n").val(bankid);
    $("#bank_id").val(bankid);

    $.ajax({
        url: "/" + actiontype + "/showbranchdata",
        type: "post",
        data: "bankid=" + bankid,
        success: function (results) {
            // alert(results);
            if (atype == 'owner')
            {
                $("#property_type").html(results);
            } else {
                $("#bank_branch_name").html(results);
            }
        }
    });

    $.ajax({
        url: "/" + actiontype + "/showBankUserListdata",
        type: "post",
        data: "bankid=" + bankid,
        success: function (results) {
            // alert(results);
            if (atype == 'owner')
            {
                $("#property_type").html(results);
            } else {
                $("#invoice_mail_to").html(results);
            }
        }
    });

    $.ajax({
        url: "/" + actiontype + "/showBankUserListdata1",
        type: "post",
        data: "bankid=" + bankid,
        success: function (results) {
            // alert(results);
            if (atype == 'owner')
            {
                $("#property_type").html(results);
            } else {
                $("#invoice_mailed").html(results);
            }
        }
    });

}
function validateFrmInitTrans() {
    $('#spMsg').html("");
    flag = '';

    
	if ($('#remitter_account').val() == '') {
		$('#spMsg').append("<li>Please Select Remitter Account</li>");
		flag = 1;
	}

	
	if (isNaN($('#account_number').val().trim()) == true) {
		$('#spMsg').append("<li>Please Enter Valid Remitter Account Number </li>");
		flag = 1;
	}  
	if ($('#cheque_no').val().trim() == '') {
		$('#spMsg').append("<li>Please Enter Cheque No.</li>");
		flag = 1;
	}
	if ($('#cheq_date').val().trim() == '') {
		$('#spMsg').append("<li>Please Enter Cheque Date</li>");
		flag = 1;
	}
        

       //Checking Amount to be Refunded Can not be Blank.
       var recAccount   = document.getElementsByName('receiver_account[]');
       var recAmount    = document.getElementsByName('amt_to_be_paid[]');

        if (recAccount.length > 0){
            var cAmt = 0;
            var cAmtStatus = 0;
            var cSelStatus = 0;
            for (i=0; i<recAccount.length; i++)
            {   
                cAmt += parseFloat(recAmount[i].value);
                if ((recAccount[i].value != "") && ((parseFloat(recAmount[i].value) <= 0) || (recAmount[i].value ==""))) 
                { 
                    cAmtStatus = 1;
                }
                else if((recAccount[i].value == "") && (parseFloat(recAmount[i].value) > 0))
                {  
                    cSelStatus = 1;
                }
            }
        }
       
        if(cAmt <= 0 && cAmtStatus != 1)
	{   
            $('#spMsg').append("<li>Please Enter Receiver Amount to be Transfered.</li>");
            flag = 1;
	}
        
        if(cAmtStatus == 1)
	{   
            $('#spMsg').append("<li>Please Enter Receiver Amount.</li>");
            flag = 1;
	}
        
        if(cSelStatus == 1)
	{   
            $('#spMsg').append("<li>Please Select Receiver Account.</li>");
            flag = 1;
	}
 
       //Checking Amount to be Refunded Can not be greater than Amount Remaining.
        var amtToBePaid = document.getElementsByName('amt_to_be_paid[]');
        var remAmount      = document.getElementsByName('amt_remaining[]');

        if (amtToBePaid.length > 0){
            var chkStatus = 0;
            for (i=0; i<amtToBePaid.length; i++)
            {   
                if(parseFloat(amtToBePaid[i].value) > (parseFloat(remAmount[i].value)))
                {
                   chkStatus ++; 
                }
            }
        }
        if(chkStatus > 0 )
	{   
            $('#spMsg').append("<li>Amount to be Transfered Can not be greater than Amount Remaining.</li>");
            flag = 1;
	}
        

	if (flag == 1) {

		//if(returnFlag==1){
		//alert("-------"+flag);
		$("#showerror_msg").show();
		$(".inline").colorbox({inline: true, width: "50%"});
		$(".inline").click();
		
		
		return false;
		// }
	} else {
            $('.b_submit').css('display','none');
            $('.rfq-loader').css('display','block');
		return true;
	}

}

    //Added by Azizur Rahman 12-09-2017
    function validateFrmInitRefund() 
    { 
        $('#spMsg').html("");
        flag = '';

        if ($('#remitter_account').val() == '') {
            $('#spMsg').append("<li>Please Select Remitter Account</li>");
            flag = 1;
        }

        if ($('#cheque_no').val().trim() == '') {
            $('#spMsg').append("<li>Please Enter Cheque No.</li>");
            flag = 1;
        }
        
        if ($('#cheq_date').val().trim() == '') {
                $('#spMsg').append("<li>Please Enter Cheque Date</li>");
                flag = 1;
        }
 
        //Checking Amount to be Refunded Can not be Blank.
        var recAmount    = document.getElementsByName('amt_to_be_paid[]');
        if (recAmount.length > 0){
            var cAmt = 0;
            for (i=0; i<recAmount.length; i++)
            {   
                if((parseFloat(recAmount[i].value) > 0))
                {
                    cAmt++;
                }
            }
        }else{
            $('#spMsg').append("<li>Sorry!... There is no Bidder to be Refunded.</li>");
            flag = 1;
        }
 
        if(cAmt <= 0 )
	{   
            $('#spMsg').append("<li>Please Enter Receiver Amount to be Refunded.</li>");
            flag = 1;
	}
        
        //Checking Amount to be Refunded Can not be greater than Amount Remaining.
        var amtToBePaid = document.getElementsByName('amt_to_be_paid[]');
        var remEmd      = document.getElementsByName('remaining_emd[]');

        if (amtToBePaid.length > 0){
            var chkStatus = 0;
            for (i=0; i<amtToBePaid.length; i++)
            {   
                if(parseFloat(amtToBePaid[i].value) > (parseFloat(remEmd[i].value)))
                {
                   chkStatus ++; 
                }
            }
        }
        if(chkStatus > 0 )
	{   
            $('#spMsg').append("<li>Amount to be Refunded Can not be greater than Amount Remaining.</li>");
            flag = 1;
	}
       
        //Checking Receiver Account Details can not be blank.
        var aToBePaid   = document.getElementsByName('amt_to_be_paid[]');
        var rName       = document.getElementsByName('receiver_name[]');
        var rBName      = document.getElementsByName('receiver_bank_name[]');
        var rIFSCCode   = document.getElementsByName('receiver_ifsc_code[]');
        var rAcNo       = document.getElementsByName('receiver_account_no[]');

        if (aToBePaid.length > 0){ 
            var rStatus = 0;
            for (i=0; i<aToBePaid.length; i++)
            {   
                if ((parseFloat(aToBePaid[i].value) > 0) && ((rName[i].value == '') || (rBName[i].value == '') || (rIFSCCode[i].value == '') || (rAcNo[i].value == '')))
                {
                   rStatus = 1; 
                }
            }
        }
        if(rStatus > 0 )
	{   
            $('#spMsg').append("<li>Receiver Account Details is insufficient.!</li>");
            flag = 1;
	}
    
     
        
	if (flag == 1) {
            $("#showerror_msg").show();
            $(".inline").colorbox({inline: true, width: "50%"});
            $(".inline").click();
            return false;
		
	} else {
            $('.b_submit').css('display','none');
            $('.rfq-loader').css('display','block');
            return true;
	} 
    }

function validateFrmICD() {	
    $('#spMsg').html("");
    flag = '';
    if(typeof($('.instrument_no').val()) == 'undefined')
    {
		$('#spMsg').append("<li>Please Add input fields </li>");
		flag = 1;
	}
	else
	{
		if ($('.instrument_no').val() == '') {
			$('#spMsg').append("<li>Please Enter Instrument No.</li>");
			flag = 1;
		}

		if ($('.instrument_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Instrument Date </li>");
			flag = 1;
		}
	   
		if ($('.amount_paid').val().trim() == '') {
			$('#spMsg').append("<li>Please Enter Amount paid </li>");
			flag = 1;
		}
	}

	if (flag == 1) {

		//if(returnFlag==1){
		//alert("-------"+flag);
		$("#showerror_msg").show();
		$(".inline").colorbox({inline: true, width: "50%"});
		$(".inline").click();
		
		
		return false;
		// }
	} else {
		return true;
	}

}
function validateFrmDN() {	
    $('#spMsg').html("");
    flag = '';
    if(typeof($('.demand_note_no').val()) == 'undefined')
    {
		$('#spMsg').append("<li>Please Add Demand Note </li>");
		flag = 1;
	}
	else
	{
		if ($('.demand_note_no').val() == '') {
			$('#spMsg').append("<li>Please Enter Demand Note No.</li>");
			flag = 1;
		}

		if ($('.demand_note_date').val() == '') {
			$('#spMsg').append("<li>Please Enter Demand Note Date </li>");
			flag = 1;
		}
	   
		if ($('.percentage_payment').val().trim() == '') {
			$('#spMsg').append("<li>Please Enter Payment Percentage </li>");
			flag = 1;
		}
		if(($('.percentage_payment').val() <= 0.99 || $('.percentage_payment').val() >= 100.01) && ($('.percentage_payment').val() != ''))
		{
			$('#spMsg').append("<li>Payment Percentage should be between 1 to 100 </li>");
			flag = 1;
		}
	}

	if (flag == 1) {

		//if(returnFlag==1){
		//alert("-------"+flag);
		$("#showerror_msg").show();
		$(".inline").colorbox({inline: true, width: "50%"});
		$(".inline").click();
		
		
		return false;
		// }
	} else {
		return true;
	}
        
}
