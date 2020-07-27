// JavaScript Document
// ****************************Seller category search tab*****************************
$(document).ready(function() {	
$('.cate_list_drop_down').click( function(event){
		event.stopPropagation();
        $('#search_categoryList').fadeIn(300);
});

$('.show_subCategory').click(function(event){
		event.stopPropagation();
		var catID=$(this).attr('id');
			$(".uncheckcommon").each(function() {
				cid=$(this).attr('id');
				if(cid!=catID){
					$('#subcategory_'+cid).hide();
					this.checked = false;   
					$("#closesubdiv_"+cid).hide();
				    $("#opensubdiv_"+cid).show();
									
				}
            }); 
		if($('#'+catID).is(':checked')){
			//uncheck previous chategory and subcategory also close all previous tab 
			$('#propertyDatatype').html($('#'+catID).val());
				$('#subcategory_'+catID).fadeIn();
				$("#opensubdiv_"+catID).hide();
				$("#closesubdiv_"+catID).show();
				
				$(".subcatecheck_"+catID).each(function() { 
				this.checked = true;       
				});
		}else{
				$("#closesubdiv_"+catID).hide();
				$("#opensubdiv_"+catID).show();
			$('#propertyDatatype').html('Property Types');
			$('#subcategory_'+catID).fadeOut();
			$(".subcatecheck_"+catID).each(function() { 
			    this.checked = false;                
            });}	
		$('#search_categoryList').fadeIn();
});

$(".subCategoryhide_plus").click(function(){
	labID=$(this).attr('id');
	labIDarr=labID.split('_');
	catid=labIDarr[1];
	$( "#"+catid).prop("checked", true);
	$('#propertyDatatype').html($('#'+catid).val());
	$(".uncheckcommon").each(function() {
				cid=$(this).attr('id');
				if(cid!=catid){
					$('#subcategory_'+cid).hide();
					this.checked = false;
					$("#closesubdiv_"+cid).hide();
				    $("#opensubdiv_"+cid).show();
				
						
				}
            });
	$('#subcategory_'+catid).fadeIn();
	$(".subcatecheck_"+catid).each(function() { 
                this.checked = true;                
            });
		$("#opensubdiv_"+catid).hide();
		$("#closesubdiv_"+catid).show();	
		
});

$(".subCategoryhide_minus").click(function(){
	labID=$(this).attr('id');
	labIDarr=labID.split('_');
	catid=labIDarr[1];
	$( "#"+catid).prop("checked", false);
	$('#propertyDatatype').html('Property Types');
	$(".uncheckcommon").each(function() {
				cid=$(this).attr('id');
				if(cid!=catid){
					$('#subcategory_'+cid).hide();
					this.checked = false;
					$("#closesubdiv_"+cid).hide();
				    $("#opensubdiv_"+cid).show();	
				}
            });
	$('#subcategory_'+catid).fadeOut();
	$(".subcatecheck_"+catid).each(function() { 
                this.checked = false;                
            });
		$("#closesubdiv_"+catid).hide();
		$("#opensubdiv_"+catid).show();
	
	
});


$("#close_subdive_sell").click(function(){
	event.stopPropagation();
	$('#search_categoryList').fadeOut();
});

});
$(document).click( function(){
		//event.stopPropagation();
        $('#search_categoryList').fadeOut();
    });

// ****************************Seller category search tab*****************************


$(document).ready(function() {	
	$('.cate_list_drop_down_rent').click( function(event){
		event.stopPropagation();
        $('#search_categoryList_rent').fadeIn(300);
	});
	
	$('.show_subCategory_rent').click(function(event){
		event.stopPropagation();
		var catID=$(this).attr('id');
		catIDArr=catID.split('_');
		catID=catIDArr[1];
			$(".uncheckcommon_rent").each(function() {
				cid=$(this).attr('id');
				catIDArr=cid.split('_');
				cid=catIDArr[1];
				if(cid!=catID){
					$('#subcategory_rent_'+cid).hide();
					this.checked = false;   
					$("#closesubdivrent_"+cid).hide();
				    $("#opensubdivrent_"+cid).show();
									
				}
            }); 
		if($('#rent_'+catID).is(':checked')){
			//uncheck previous chategory and subcategory also close all previous tab 
			$('#propertyDatatype_rent').html($('#rent_'+catID).val());
				$('#subcategory_rent_'+catID).fadeIn();
				$("#opensubdivrent_"+catID).hide();
				$("#closesubdivrent_"+catID).show();
				
				$(".subcatecheck_rent_"+catID).each(function() { 
				this.checked = true;       
				});
		}else{
				$("#closesubdivrent_"+catID).hide();
				$("#opensubdivrent_"+catID).show();
			$('#propertyDatatype_rent').html('Property Types');
			$('#subcategory_rent_'+catID).fadeOut();
			$(".subcatecheck_rent_"+catID).each(function() { 
			    this.checked = false;                
            });}	
		$('#search_categoryList_rent').fadeIn();
});

$("#close_subdive_rent").click(function(){
	event.stopPropagation();
	$('#search_categoryList_rent').fadeOut();
});
/*	
$(".close_rent").click(function(){
	labID=$(this).attr('id');
	labIDarr=labID.split('_');
	catid=labIDarr[1];
	//$( "#"+catid).prop("checked", false);
	$('#subcategory_rent_'+catid).fadeOut();
	$(".subcatecheck_rent_"+catid).each(function() { 
                this.checked = false;                
            });
	$("#closesubdivrent_"+catid).hide();
	$("#opensubdivrent_"+catid).show();
});
*/
$(".subCategoryhide_plus_rent").click(function(){
	labID=$(this).attr('id');
	labIDarr=labID.split('_');
	catid=labIDarr[1];
	$( "#rent_"+catid).prop("checked", true);
	$('#propertyDatatype_rent').html($('#rent_'+catid).val());
	$(".uncheckcommon_rent").each(function() {
				cid=$(this).attr('id');
				if(cid!=catid){
					$('#subcategory_rent_'+cid).hide();
					this.checked = false;
					$("#closesubdivrent_"+cid).hide();
				    $("#opensubdivrent_"+cid).show();
				
						
				}
            });
	$('#subcategory_rent_'+catid).fadeIn();
	$(".subcatecheck_rent_"+catid).each(function() { 
                this.checked = true;                
            });
		$("#opensubdivrent_"+catid).hide();
		$("#closesubdivrent_"+catid).show();	
		
});
$(".subCategoryhide_minus_rent").click(function(){
	labID=$(this).attr('id');
	labIDarr=labID.split('_');
	catid=labIDarr[1];
	$( "#rent_"+catid).prop("checked", false);
	$('#propertyDatatype_rent').html('Property Types');
	$(".uncheckcommon_rent").each(function() {
				cid=$(this).attr('id');
				if(cid!=catid){
					$('#subcategory_rent_'+cid).hide();
					this.checked = false;
					$("#closesubdivrent_"+cid).hide();
				    $("#opensubdivrent_"+cid).show();	
				}
            });
	$('#subcategory_rent_'+catid).fadeOut();
	$(".subcatecheck_rent_"+catid).each(function() { 
                this.checked = false;                
            });
		$("#closesubdivrent_"+catid).hide();
		$("#opensubdivrent_"+catid).show();
	
	
});		
});

$(document).click( function(){
		//event.stopPropagation();
        $('#search_categoryList_rent').fadeOut();
    });

// ****************************Search page category List (Listing page)*********************************


$(document).ready(function() {	
	$('.cate_list_drop_down_listing').click( function(event){
		event.stopPropagation();
        $('#search_categoryList_listing').fadeIn(300);
	});
	
	
	$('.show_subCategory_list').click(function(event){
		
		// Post search Form
		
		
		event.stopPropagation();
		var catID=$(this).attr('id');
			$(".uncheckcommon").each(function() {
				cid=$(this).attr('id');
				if(cid!=catID){
					$('#subcategorylist_'+cid).hide();
					this.checked = false;   
					$("#closesubdivlist_"+cid).hide();
				    $("#opensubdivlist_"+cid).show();
									
				}
            }); 
		if($('#'+catID).is(':checked')){
			//uncheck previous chategory and subcategory also close all previous tab 
			$('#propertyDatatype').html($('#'+catID).val());
				$('#subcategorylist_'+catID).fadeIn();
				$("#opensubdivlist_"+catID).hide();
				$("#closesubdivlist_"+catID).show();
				
				//$(".subcatechecklist_"+catID).each(function() { 
				//this.checked = true;       
				//});
			$("#property_serch").submit();	
		}else{
				$("#closesubdivlist_"+catID).hide();
				$("#opensubdivlist_"+catID).show();
			$('#propertyDatatype').html('Property Types');
			$('#subcategorylist_'+catID).fadeOut();
			//$(".subcatechecklist_"+catID).each(function() { 
			 //   this.checked = false;                
            //});
			$("#property_serch").submit();
			}	
		$('#search_categoryList_listing').fadeIn();
		
	$("#property_serch").submit();	
});
	

$(".subCategoryhidelist_plus").click(function(){
	labID=$(this).attr('id');
	labIDarr=labID.split('_');
	catid=labIDarr[1];
	//$( "#"+catid).prop("checked", true);
	$('#propertyDatatype').html($('#'+catid).val());
	$(".uncheckcommon").each(function() {
				cid=$(this).attr('id');
				if(cid!=catid){
					//$('#subcategorylist_'+cid).hide();
					//this.checked = false;
					$("#closesubdivlist_"+cid).hide();
				    $("#opensubdivlist_"+cid).show();
	
				}
            });
	$('#subcategorylist_'+catid).fadeIn();
	//$(".subcatechecklist_"+catid).each(function() { 
     //   this.checked = true;                
      //      });
		$("#opensubdivlist_"+catid).hide();
		$("#closesubdivlist_"+catid).show();		
});	
	
$(".subCategoryhidelist_minus").click(function(){
	labID=$(this).attr('id');
	labIDarr=labID.split('_');
	catid=labIDarr[1];
	//$( "#"+catid).prop("checked", false);
	$('#propertyDatatype').html('Property Types');
	$(".uncheckcommon").each(function() {
				cid=$(this).attr('id');
				if(cid!=catid){
					//$('#subcategorylist_'+cid).hide();
					//this.checked = false;
					$("#closesubdivlist_"+cid).hide();
				    $("#opensubdivlist_"+cid).show();	
				}
            });
	$('#subcategorylist_'+catid).fadeOut();
	//$(".subcatechecklist_"+catid).each(function() { 
         //       this.checked = false;                
         //   });
		$("#closesubdivlist_"+catid).hide();
		$("#opensubdivlist_"+catid).show();
	
	
});

	
	
$("#close_subdive_list").click(function(){
	event.stopPropagation();
	$('#search_categoryList_listing').fadeOut();
});
		
});
$(document).click( function(){
		//event.stopPropagation();
        $('#search_categoryList_listing').fadeOut();
    });



