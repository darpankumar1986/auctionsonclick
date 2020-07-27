function movetoauction(auctionID)
{
	 var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
	if(confirm('Want to move this event to auction – Yes/ No?')){
            if(auctionID){
            jQuery.colorbox({width:"65%", inline:true,href:'#inline_content3'});
            jQuery.ajax({
			url: '/buyer/movetoauction',
			type: 'POST',
			data: {
				auctionID: auctionID,
                                type:"move_to_auction",
                                message:"Buyer moved auction auccessfully",
                                csrf_test_name: csrf_token
			},
			success: function(data) {}
		});
        }
	}

}
function open_price_bid1(auctionID)
{
	 var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
	  if(auctionID){
             jQuery.ajax({
			url: '/buyer/open_price_bid1',
			type: 'POST',
			data: {
				auctionID: auctionID,
				csrf_test_name: csrf_token
			},
			success: function(data) {
				location.reload();
			}
		});	
	}
}
/*

function move_to_first_opener(auctionID)
{
	//if(opening_price){
          if(auctionID){
		jQuery.ajax({
			url: '/buyer/movetofirstopener',
			type: 'POST',
			data: {
				auctionID: auctionID
			},
			success: function(data) {
				location.reload();
			}
		});	
	}
}

function move_to_second_opener(auctionID)
{
	//if(opening_price){
          if(auctionID){
		jQuery.ajax({
			url: '/buyer/movetosecondopener',
			type: 'POST',
			data: {
				auctionID: auctionID
			},
			success: function(data) {
				location.reload();
			}
		});	
	}
}
*/

function move_to_approver(auctionID)
{
	//if(opening_price){
          if(auctionID){
		jQuery.ajax({
			url: '/buyer/movetoapprover',
			type: 'POST',
			data: {
				auctionID: auctionID
			},
			success: function(data) {
				location.reload();
			}
		});	
	}
}


function set_opening_price(auctionID, opening_price, currentStatus)
{
	var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
	if(opening_price){
		if(confirm('Want to move this event to auction?')){		
			jQuery.ajax({
				url: '/buyer/setopeningprice',
				type: 'POST',
				data: {
					auctionID: auctionID,
					opening_price: opening_price,
					currentStatus: currentStatus,
					csrf_test_name: csrf_token
				},
				success: function(data) {
					location.reload();
				}
			});
		}
	}
}

function MoveT(auctionID)
{
	var checkConfirm = confirm('Are you sure, that want to conclude the event?');
	if(checkConfirm== true)
	{
		jQuery.ajax({
			url: '/buyer/concludeEvent',
			type: 'POST',
			data: {auctionID:auctionID},
			success: function(data) {
				//location=location;
			}
		});	
		return true;
	}
	else{
		return true;
	}
}

function validateopenerfrm(str){
	
	var flag = true;
	jQuery('#'+str+' .bid_acceptance').each(function(){
		if(!jQuery(this).val()){
			jQuery(this).addClass('error');
			flag = false;
		}else{
			jQuery(this).removeClass('error');
		}
	});
	
	jQuery('#'+str+' .txtComment').each(function(){
		if(!jQuery(this).val()){
			jQuery(this).addClass('error');
			flag = false;
		}else{
			jQuery(this).removeClass('error');
		}
	});
	
	if(flag){
		return true;
	}else{
		return false;
	}	
}
	
function concludeEvent(auctionID)
{
	var checkConfirm = confirm('Are you sure, that want to conclude the event?');
	if(checkConfirm== true)
	{
		jQuery.ajax({
			url: '/buyer/concludeEvent',
			type: 'POST',
			data: {auctionID:auctionID},
			success: function(data) {
				location.reload();
				
			}
		});	
		return true;
	}
	else{
		return true;
	}
}

jQuery(document).ready(function(jQuery){
	/*------- tab pannel --------------- */
	jQuery(".tab_content5").hide();
	//jQuery(".tab_content5:first").show(); 
	var activeTab = jQuery("ul.tabs5 li.active").attr("rel");
	jQuery("#"+activeTab).show(); 	
	jQuery("ul.tabs5 li").click(function() {
		jQuery("ul.tabs5 li").removeClass("active");
		jQuery(this).addClass("active");
		jQuery(".tab_content5").hide();
		var activeTab = jQuery(this).attr("rel"); 
		jQuery("#"+activeTab).fadeIn(); 
	});
});

jQuery(document).ready(function(){		
	
	jQuery(".inline_auctiondetail").colorbox({inline:true, width:"65%"});
	
	jQuery(".inline_auctiondetail1").colorbox({inline:true, width:"65%"});
	
	jQuery(".inline_auctiondetail2").colorbox({inline:true, width:"65%"});
	
	jQuery(".inline_auctiondetail3").colorbox({inline:true, width:"65%"});
	
	jQuery(".inline_auctiondetail5").colorbox({inline:true, width:"65%"});
		
	jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {
			jQuery(".inline_auctiondetail1").click();
			jQuery(".inline_auctiondetail2").click();
		}
	});
	
	jQuery(".tenderfee_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {
			jQuery(".inline_auctiondetail1").click();
			jQuery(".inline_auctiondetail2").click();
		}
	});
	
	jQuery(".doc_detail_iframe").colorbox({iframe:true, width:"42%", height:"40%",onClosed: function () {
			jQuery(".inline_auctiondetail1").click();
			jQuery(".inline_auctiondetail2").click();
		}
	});

});
