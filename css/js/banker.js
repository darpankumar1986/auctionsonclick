
function movetoauction(auctionID)
{
	if(confirm('Want to move this event to auction – Yes/ No?')){
            if(auctionID){
            jQuery.colorbox({width:"65%", inline:true,href:'#inline_content3'});    
             jQuery.ajax({
			url: '/banker/movetoauction',
			type: 'POST',
			data: {
				auctionID: auctionID,
                                type:"move_to_auction",
                                message:"Banker moved Auction Successfully"
			},
			success: function(data) {}
		});	
	}
		
	}

}




function open_price_bid1(auctionID)
{
	if(opening_price){
		jQuery.ajax({
			url: '/banker/open_price_bid1',
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
	if(opening_price){
		jQuery.ajax({
			url: '/banker/movetosecondopener',
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
	if(opening_price){
		jQuery.ajax({
			url: '/banker/setopeningprice',
			type: 'POST',
			data: {
				auctionID: auctionID,
				opening_price: opening_price,
				currentStatus: currentStatus
			},
			success: function(data) {
				location.reload();
			}
		});	
	}
}

function MoveT(auctionID)
{
	var checkConfirm = confirm('Are you sure, that want to conclude the event?');
	if(checkConfirm== true)
	{
		jQuery.ajax({
			url: '/banker/concludeEvent',
			type: 'POST',
			data: {auctionID:auctionID},
			success: function(data) {
				//location=location;
				//alert(data);
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
			url: '/banker/concludeEvent',
			type: 'POST',
			data: {auctionID:auctionID},
			success: function(data) {
				location.reload();
				//alert(data);
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
