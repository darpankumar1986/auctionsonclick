/*
 * 	Additional function for forms.html
 *	Written by ThemePixels	
 *	http://themepixels.com/
 *
 *	Copyright (c) 2012 ThemePixels (http://themepixels.com)
 *	
 *	Built for Amanda Premium Responsive Admin Template
 *  http://themeforest.net/category/site-templates/admin-templates
 */
jQuery.noConflict();
jQuery(document).ready(function(){

	///// FORM TRANSFORMATION /////
	jQuery('input:checkbox, input:radio, select.uniformselect, input:file').uniform();
	
	
	updateAction = function(controller, action, id, action_value) {
		var actUrl = '/admin/'+controller+'/action/'+action+'/'+id;
		if(action_value){
			actUrl = actUrl+"/"+action_value;
		}
		var action = action;
		
		jQuery.ajax({
			url: actUrl
		})
		.done(function( msg ) {
			//alert( msg );
			if(action == 'delete'){
				location=location;
			}
		});
		
		
		//return confirm("Are you sure you want to delete this record?")
	};
	
	
	jQuery(".status").change(function(){
		action_value = (jQuery(this).is(':checked'))?'1':'0';
		id = jQuery(this).data("id");
		action = 'status';
		controller = jQuery('#controller').val();
		alert(controller);
		if(confirm("Are you sure to change status!!")){
			updateAction(controller, action, id, action_value);
		}
		else{
			jQuery(this).prop('checked', !(jQuery(this).is(':checked')));
		}
	});
	jQuery(".menu_item").change(function(){
		action_value = (jQuery(this).is(':checked'))?'1':'0';
		id = jQuery(this).data("id");
		action = 'menu_item';
		controller = jQuery('#controller').val();
		if(confirm("Are you sure!!")){
			updateAction(controller, action, id, action_value);
		}
		else{
			jQuery(this).prop('checked', !(jQuery(this).is(':checked')));
		}
	});
	
	jQuery(".home_page").change(function(){
		action_value = (jQuery(this).is(':checked'))?'1':'0';
		id = jQuery(this).data("id");
		action = 'home_page';
		controller = jQuery('#controller').val();
		if(confirm("Are you sure!!")){
			updateAction(controller, action, id, action_value);
		}
		else{
			jQuery(this).prop('checked', !(jQuery(this).is(':checked')));
		}
	});
	
	jQuery(".show_home").change(function(){
		action_value = (jQuery(this).is(':checked'))?'1':'0';
		id = jQuery(this).data("id");
		action = 'show_home';
		controller = jQuery('#controller').val();
		if(confirm("Are you sure!!")){
			updateAction(controller, action, id, action_value);
		}
		else{
			jQuery(this).prop('checked', !(jQuery(this).is(':checked')));
		}
	});
	
	jQuery(".carousel").change(function(){
		action_value = (jQuery(this).is(':checked'))?'1':'0';
		id = jQuery(this).data("id");
		action = 'carousel';
		controller = jQuery('#controller').val();
		if(confirm("Are you sure!!")){
			updateAction(controller, action, id, action_value);
		}
		else{
			jQuery(this).prop('checked', !(jQuery(this).is(':checked')));
		}
	});
	
	jQuery(".thumbnail").change(function(){
		action_value = (jQuery(this).is(':checked'))?'1':'0';
		id = jQuery(this).data("id");
		action = 'thumbnail';
		controller = jQuery('#controller').val();
		if(confirm("Are you sure!!")){
			updateAction(controller, action, id, action_value);
		}
		else{
			jQuery(this).prop('checked', !(jQuery(this).is(':checked')));
		}
	});
	
	jQuery(".deletelink").click(function(){
		id = jQuery(this).data("id");
		action = 'delete';
		controller = jQuery('#controller').val();
		if(confirm("Are you sure to delete!!")){
			updateAction(controller, action, id);
		}
	});
	
	jQuery(".priority").change(function(){
		action_value = jQuery(this).val();
		id = jQuery(this).data("id");
		action = 'priority';
		controller = jQuery('#controller').val();
		updateAction(controller, action, id, action_value);
	});
	
	
	jQuery("#title").blur(function(){
		if(jQuery("#meta_title").val() == '')
		jQuery("#meta_title").val(jQuery(this).val());
	});
	
	jQuery("#excerpt").blur(function(){
		if(jQuery("#meta_description").val() == '')
		jQuery("#meta_description").val(jQuery(this).val());
	});
	
	jQuery("#tags").blur(function(){
		if(jQuery("#meta_keywords").val() == '')
		jQuery("#meta_keywords").val(jQuery(this).val());
	});
	
	///// TAG INPUT /////
	
	//jQuery('#tags').tagsInput();

	
	///// SPINNER /////
	
	//jQuery("#spinner").spinner({min: 0, max: 100, increment: 2});
	
	
	///// CHARACTER COUNTER /////
	
	/*jQuery("#textarea2").charCount({
		allowed: 120,		
		warning: 20,
		counterText: 'Characters left: '	
	});*/
	
	
	///// SELECT WITH SEARCH /////
	//jQuery(".chzn-select").chosen();
	
	
});

//for select all
