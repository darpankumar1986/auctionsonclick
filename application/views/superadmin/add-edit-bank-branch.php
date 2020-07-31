<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE ?>css/plugins/jquery.tagsinput.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/calender/jquery-ui-timepicker-addon.css">

<script>
    jQuery(document).ready(function () {
        //Examples of how to assign the Colorbox event to elements
        jQuery(".iframe").colorbox({iframe: true, width: "90%", height: "90%"});


    });
    var bankid;
    function getZone(bank_id) {
        //cat_id = jQuery('#zone').val();
        bankid = bank_id;
        jQuery('#zone').load('/superadmin/bank_zone/ajax_zone/' + bank_id);

    }
    function getRegion(zone_id) {
        //cat_id = jQuery('#zone').val();
        jQuery('#region').load('/superadmin/bank_region/ajax_region/' + zone_id);
        jQuery("#check-all-field").html("");

    }

    function checkBankBranchkeypress() {
        bankid = jQuery('#bank').val();
        zone = jQuery("#zone").val();
        region = jQuery("#region").val();
        drt = jQuery("#drt").val();
        if (bankid == '') {
            jQuery("#check-all-field").html("Please select bank");
            jQuery("#name").val('');
        } else if (zone == '') {
            jQuery("#check-all-field").html("Please select zone");
            jQuery("#name").val('');
        } else if (region == '') {
            jQuery("#check-all-field").html("Please select region");
            jQuery("#name").val('');
        } else if (drt == '') {
            jQuery("#check-all-field").html("Please select DRT");
            jQuery("#name").val('');
        } else {
            jQuery("#check-all-field").html("");
        }
    }
    function checkBankBranch(brancName) {
        bankid = jQuery('#bank').val();
        zone = jQuery("#zone").val();
        region = jQuery("#region").val();
        drt = jQuery("#drt").val();
        if (bankid == '' && zone != '' && region != '' && drt != '') {
            jQuery.ajax({
                type: "post",
                url: '/superadmin/bank_branch/checkBankBranch',
                data: "brancName=" + brancName + "&bankid=" + bankid + '&zone=' + zone + '&region=' + region + "&drt=" + drt + '&id=' + '<?php echo @$row->id; ?>',
                success: function (data) {
                    if (data == 1) {
                        jQuery("#branchName").show();
                    } else {
                        jQuery("#branchName").hide();
                    }
                }
            });
        }
    }
</script>
<?php
if (!empty($row)) {
    $id = $row->id;
    $name = $row->name;
    $DRTId = $row->drt_id;
    $bank_id = $row->bank_id;
    $lho = $row->lho_id;
    $zone_id = $row->zone_id;
    $region_id = $row->region_id;
    $shortname = $row->shortName;
    $address1 = $row->address1;
    $address2 = $row->address2;
    $street = $row->street;
    $country = $row->country;
    $state = $row->state;
    $city = $row->city;
    $zip = $row->zip;
    $phone = $row->phone;
    $fax = $row->fax;
    $agreementnodate = $row->agreementnodate;
    $revenueamount = $row->revenueamount;
    $unsuc_revenueamount = $row->unsuc_revenueamount;
    $stax = $row->stax;
    $educess = $row->educess;
    $secondaryhighertax = $row->secondaryhighertax;
    $total = $row->total;
    $status = $row->status;
    $indate = $row->inadate;
    $agreementstartdate = $row->validity_from;
    $agreementenddate = $row->validity_to;
    $cancel_amount=$row->cancel_amount;
    $stay_amount=$row->stay_amount;
} else {

    $status = 0;
    $id = 0;
    $slug = '';
    extract($_POST);
    $name = $_POST['name'];
    $DRTId = $_POST['drt'];
    $bank_id = $_POST['bank'];
    $lho = $_POST['lho_id'];
    $zone_id = $_POST['zone'];
    $region_id = $_POST['region'];
    $shortname = $_POST['shortName'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $street = $_POST['street'];
    $country = $_POST['country_id'];
    $state = $_POST['state_id'];
    $city = $_POST['city_id'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    $agreementnodate = $_POST['agreementnodate'];
}
?> 

<section class="body_main1">	
    <div class="row">						
        <a href="/superadmin/bank_branch" class="button_grey">Branch List</a>
    </div>
    <div class="box-head">Create Branch</div>
    <div class="centercontent">
        <div class="pageheader">
            <span class="pagedesc"><div style="color:red; text-align:center;"><?php echo validation_errors(); ?></div></span>
        </div><!--pageheader-->
        <div id="contentwrapper" class="contentwrapper box-content2">
            <div id="validation" class="subcontent">            	
                <form enctype="multipart/form-data" method="post" class="stdform" id="bank1" name="add_data_view" accept-charset="utf-8" action="/superadmin/bank_branch/save_branch/<?php if (!empty($id)) echo @$id; ?>"  autocomplete="off">	
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                    <div class="row">
                        <div class="lft_heading">Name of the Organization <span class="red"> *</span></div>
                        <div class="rgt_detail">
                            <select name="bank" id="bank" onchange="getZone(jQuery(this).val())" class="html_found">
                                <option value="">Select Organization </option>
<?php foreach ($banks as $bank_record) { ?>
                                    <option value="<?php echo $bank_record->id; ?>" <?php echo ($bank_record->id == $bank_id) ? 'selected' : ''; ?>><?php echo $bank_record->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>					
                    </div>
                    <?php /* ?>
                     <div class="row">
                        <div class="lft_heading">LHO </div>
                        <div class="rgt_detail">
                            <select name="lho_id" id="lho_id">
                                  <option value="">Select LHO</option>
                                  <?php
                                  foreach($lhoarr as $lho_record){?>
                                  <option value="<?php echo $lho_record->id; ?>" <?php echo ($lho_record->id==$lho)?'selected':''; ?>><?php echo $lho_record->name; ?></option>
                                  <?php }?>
                              </select>
                        </div>					
                    </div>
                    <?php */ ?>
                    <div class="row">
                        <div class="lft_heading">Zone </div>
                        <div class="rgt_detail">
                            <select name="zone" id="zone" onchange="getRegion(jQuery(this).val())" class="html_found">
                                <option value="" >Select Zone</option>
<?php foreach ($zones as $bzone_record) { ?>
                                    <option value="<?php echo $bzone_record->id; ?>" <?php echo ($bzone_record->id == $zone_id) ? 'selected' : ''; ?>><?php echo $bzone_record->zone_name; ?></option>
<?php } ?>
                            </select>
                        </div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">Region </div>
                        <div class="rgt_detail">
                            <select name="region" id="region" class="html_found">
                                <option value="">Select Region</option>
<?php foreach ($regions as $region_record) { ?>
                                    <option value="<?php echo $region_record->id; ?>" <?php echo ($region_record->id == $region_id) ? 'selected' : ''; ?>><?php echo $region_record->name; ?></option>
<?php } ?>
                            </select>
                        </div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">DRT Name </div>
                        <div class="rgt_detail">
                            <select name="drt" id="drt" class="html_found">
                                <option value="">Select DRT</option>
<?php foreach ($drts as $drts_record) { ?>
                                    <option value="<?php echo $drts_record->id; ?>" <?php echo ($drts_record->id == $DRTId) ? 'selected' : ''; ?>><?php echo $drts_record->name; ?></option>
<?php } ?>
                            </select>
                        </div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">Branch Name <span class="red"> *</span></div>
                        <div class="rgt_detail">
                            <input maxlength="150" type="text" name="name" id="name" class="longinput html_found" value="<?php echo $name ?>" /><!--onblur="checkBankBranch(this.value);" onkeyup="return checkBankBranchkeypress();" -->
                            <label class="error" id="check-all-field"></label>
                            <label class="error" style="display:none;">Please enter Name</label>

                            <label class="error" id="branchName" <?php if (empty($name_exists)) { ?> style="display:none;"<?php } ?>>Name already exist</label>
                        </div>					
                    </div>

                    <div class="row">
                        <div class="lft_heading">Address 1 </div>
                        <div class="rgt_detail">
                            <textarea maxlength="200" name="address1" class="html_found"><?php echo $address1 ?></textarea>
                            <label class="error" style="display:none;">Please enter address1</label>
                        </div>					
                        </p>

                        <div class="row">
                            <div class="lft_heading">Address 2 </div>
                            <div class="rgt_detail">
                                <textarea maxlength="200" name="address2" id="address2" rows="5" cols="60" class="html_found"><?php echo $address2 ?></textarea>
                                <label class="error" style="display:none;">Please enter address2</label>
                            </div>					
                        </div>
                        <div class="row">
                            <div class="lft_heading">Street</div>
                            <div class="rgt_detail">
                                <textarea maxlength="100" name="street" id="street" rows="5" cols="60" class="html_found"><?php echo $street ?></textarea>
                                <label class="error" style="display:none;">Please enter street</label>
                            </div>					
                        </div>
                        <div class="row">
                            <div class="lft_heading">Country </div>
                            <div class="rgt_detail">
                                <select name="country_id" id="country_id" class="html_found">
                                    <option value="">Select country</option>
<?php foreach ($countries as $country_record) { ?>
                                        <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id == $country) ? 'selected' : ''; ?>><?php echo $country_record->country_name; ?></option>
<?php } ?>
                                </select>
                            </div>					
                        </div>
                        <div class="row">
                            <div class="lft_heading">State </div>
                            <div class="rgt_detail">
                                <select name="state_id" id="state_id" class="html_found">
                                    <option value="">Select state</option>
<?php foreach ($states as $state_record) { ?>
                                        <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id == $state) ? 'selected' : ''; ?>><?php echo $state_record->state_name; ?></option>
<?php } ?>
                                </select>
                            </div>					
                        </div>

                        <div class="row">
                            <div class="lft_heading">City </div>
                            <div class="rgt_detail">
                                <select name="city_id" id="city_id" class="html_found">
                                    <option value="">Select city</option>
<?php foreach ($cities as $city_record) { ?>
                                        <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id == $city) ? 'selected' : ''; ?>><?php echo $city_record->city_name; ?></option>
<?php } ?>
                                </select>
                            </div>					
                        </div>
                        <div class="row">
                            <div class="lft_heading">Pin/Zip Code </div>
                            <div class="rgt_detail">
                                <input maxlength="6" type="text" name="zip" id="zip" onkeypress="return isNumberKey(event);" class="longinput html_found" value="<?php echo $zip ?>" />
                                <label class="error" style="display:none;">Please enter zip</label>
                            </div>					
                        </div>
                        <div class="row">
                            <div class="lft_heading">Phone Number </div>
                            <div class="rgt_detail">
                                <input maxlength="15" type="text" onkeypress="return isNumberKey(event);" name="phone" maxlength="12" id="phone" class="longinput html_found" value="<?php echo $phone ?>" />
                                <label class="error" style="display:none;">Please enter phone</label>
                            </div>					
                            </p>
                            <div class="row">
                                <div class="lft_heading">Fax Number </div>
                                <div class="rgt_detail">
                                    <input maxlength="15"  type="text" name="fax" onkeypress="return isNumberKey(event);"  id="fax" class="longinput html_found" value="<?php echo $fax ?>" />
                                    <label class="error errorfax" style="display:none;">Please enter valid fax number </label>
                                </div>					
                            </div>
                            <div class="row">
                                <div class="lft_heading">Agreement No Date   </div>
                                <div class="rgt_detail"> 
                                    <input maxlength="255" type="text" name="agreementnodate" id="agreementnodate" class="longinput html_found" value="<?php echo $agreementnodate ?>"  />
                                    <label class="error" style="display:none;">Please enter Agreement No. Date</label>
                                </div>					
                            </div>
                            <div class="row">
                                <div class="lft_heading">Revenue Amount(Successful)  </div>
                                <div class="rgt_detail">
                                    <input onkeypress="return isNumberKey(event);" maxlength="13" type="text" name="revenueamount" id="revenueamount" class="longinput html_found" value="<?php echo $revenueamount ?>"  />
                                    <label class="error" style="display:none;">Please enter Revenue Amount</label>
                                </div>					
                            </div>
<?php /* 	<p>
  <label>Revenue Amount(Successful)<font color='red'>*</font></label>
  <span class="field">
  <input onkeypress="return isNumberKey(event);" maxlength="13" type="text" name="revenueamount" id="revenueamount" class="longinput" value="<?php echo $revenueamount?>" onblur="calculateTax(jQuery(this).val())" />
  <label class="error" style="display:none;">Please enter Revenue Amount</label>
  </span>
  </p>

  <p>
  <label>Stax<font color='red'>*</font></label>
  <span class="field">
  <input readonly onkeypress="return isNumberKey(event);" type="text" name="stax" id="stax" class="longinput"  value="<?php echo $stax?>" />
  <label class="error" style="display:none;">Please enter Stax</label>
  </span>
  </p>
  <p>
  <label>Educess<font color='red'>*</font></label>
  <span class="field">
  <input onkeypress="return isNumberKey(event);" type="text" name="educess"  readonly id="educess"  class="longinput" value="<?php echo $educess?>" />
  <label class="error" style="display:none;">Please enter Educess</label>
  </span>
  </p>
  <p>
  <label>Secondary Higher Tax<font color='red'>*</font></label>
  <span class="field">
  <input onkeypress="return isNumberKey(event);"   type="text" name="secondaryhighertax" id="secondaryhighertax" class="longinput" readonly value="<?php echo $secondaryhighertax?>" />
  <label class="error" style="display:none;">Please enter Secondary Higher Tax</label>
  </span>
  </p>
  <p>
  <label>Total<font color='red'>*</font></label>
  <span class="field">
  <input onkeypress="return isNumberKey(event);"  type="text" name="total" id="total" class="longinput" value="<?php echo $total?>" readonly />
  <label class="error" style="display:none;">Please enter Total</label>
  </span>
  </p>
 */ ?>

                            <div class="row">
                                <div class="lft_heading">Start Date  </div>
                                <div class="rgt_detail">
                                    <input type="text" name="agreementstartdate" id="agreementstartdate" class="longinput html_found" value="<?php echo $agreementstartdate ?>" >
                                    <label class="error" style="display:none;">Please enter start date</label>
                                </div>
                            </div>


                            <div class="row">
                                <div class="lft_heading">End Date  </div>
                                <div class="rgt_detail"><input type="text" name="agreementenddate" onchange="checkvalidate();" id="agreementenddate" class="longinput html_found" value="<?php echo $agreementenddate ?>" ></div>
                                <span id="spMsg" style="color:red; font-size:11px;margin-left:310px;"></span>
                            </div>

                            <!--<div class="row">
                                <div class="lft_heading">Total Amount( For No Bid) </div>
                                <div class="rgt_detail"><input name="" type="checkbox" checked disabled="disabled" value="" style="width:20px;"></div>
                            </div>-->

                            <div class="row">
                                <div class="lft_heading">Revenue Amount(Un Successful)  </div>
                                <div class="rgt_detail">
                                    <input onkeypress="return isNumberKey(event);" maxlength="13" type="text" name="unsuc_revenueamount" id="unsuc_revenueamount" class="longinput html_found" value="<?php echo $unsuc_revenueamount ?>"  />
                                    <label class="error" style="display:none;">Please enter Revenue Amount</label>
                                </div>					
                            </div>
                              <div class="row">
                                <div class="lft_heading">Stay Amount </div>
                                <div class="rgt_detail">
                                   <input onkeypress="return isNumberKey(event);" maxlength="13" type="text" name="stay_amount" id="stay_amount" class="longinput html_found" value="<?php echo $stay_amount ?>"  />
                                    <label class="error" style="display:none;">Please enter Cancel/Stay Amount</label>  
                                 </div>
                            </div>
                             <div class="row">
                                <div class="lft_heading">Cancel Amount </div>
                                <div class="rgt_detail">
                                   <input onkeypress="return isNumberKey(event);" maxlength="13" type="text" name="cancel_amount" id="cancel_amount" class="longinput html_found" value="<?php echo $cancel_amount ?>"  />
                                    <label class="error" style="display:none;">Please enter Cancel/Stay Amount</label>  
                                 </div>
                            </div>


                            <div class="stdformbutton row" style="text-align:center;">
                                <a href="<?php echo base_url() . 'superadmin/home' ?>" class="button_grey">Back</a>	
                                <input type="submit"  name="addedit" value="<?php echo ($id) ? 'Update' : 'Submit' ?>" class="button_grey">
                                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">

                            </div>

                            </form>
                        </div>
                    </div><!--contentwrapper-->
                    <br clear="all" />
            </div><!-- centercontent -->

            <script>


                jQuery(document).ready(function ($) {
					jQuery('.html_found').change(function() {
					   if ($(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
						  alert('Invalid html content found');
						  $(this).focus();
						  $(this).val('');
					   }
					});
	
                    jQuery('input[type=checkbox]').each(function () {
                        jQuery(this).css({opacity: "1"});
                    });
                    jQuery("#bank1").validate({
                        rules: {
                            name: {
                                required: true
                                        //,alphanumeric: true
                            },
                            //address1: "required",
                            //drt: "required",
                            bank: "required"
                            //zone: "required",
                            //region: "required",
                            //country_id: "required",
                            //state_id: "required",
                            //city_id: "required",
                            //unsuc_revenueamount: "required",
                            //agreementstartdate: "required",
                            //agreementenddate: "required",
                            //cancel_amount:"required",
                            //stay_amount:"required",
                            /*zip: {
                                required: true,
                                alphanumeric: true
                                        //number: true
                            },
                            phone: {
                                required: true,
                                number: true
                            },
                            agreementnodate: {
                                required: true,
                                //alphanumeric: true
                            },
                            revenueamount: {
                                required: true,
                                number: true
                            },
                            stax: {
                                required: true,
                                number: true
                            },
                            educess: {
                                required: true,
                                number: true
                            },
                            secondaryhighertax: {
                                required: true,
                                number: true
                            },
                            total: {
                                required: true,
                                number: true
                            }*/
                        },
                        messages: {
                            bank: "Please select bank",
                            name: {
                                required: "Please enter name"
                            }
							/*,
                            address1: "Please enter address1",
                            drt: "Please select drt",
                            zone: "Please select zone",
                            region: "Please select region",
                            country_id: "Please select country",
                            state_id: "Please select state",
                            city_id: "Please select city",
                            agreementstartdate: "Please enter start date",
                            agreementenddate: "Please enter end date",
                            cancel_amount:"Please Enter Auction Cancelled Amount",
                            stay_amount:"Please Enter Auction Stay Amount",
                            zip: {
                                required: "Please enter zip code",
                                number: "Please enter valid zip code"
                            },
                            phone: {
                                required: "Please enter phone number",
                                number: "Please enter valid phone number"
                            },
                            agreementnodate: {
                                required: "Please enter Agreement No. Date"
                                        //number: "Please enter decimal or float value"
                            },
                            revenueamount: {
                                required: "Please enter Revenue ",
                                number: "Please enter decimal or float value"
                            },
                            stax: {
                                required: "Please enter Stax",
                                number: "Please enter decimal or float value"
                            },
                            educess: {
                                required: "Please enter Educess",
                                number: "Please enter decimal or float value"
                            },
                            secondaryhighertax: {
                                required: "Please enter Secondary Higher Tax",
                                number: "Please enter decimal or float value"
                            },
                            total: {
                                required: "Please enter total",
                                number: "Please enter decimal or float value"
                            },
                            unsuc_revenueamount: {
                                required: "Please enter unsuccess revenueamount",
                                number: "Please enter decimal or float value"
                            }*/

                        }
                    });

                    jQuery.validator.addMethod("alphanumeric", function (value, element) {
                        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
                    }, "Name must contain only letters, numbers, or dashes.");

                    jQuery("#fax").blur(function () {
                        // alert( "Handler for .blur() called." );
                        valuestr = jQuery(this).val();
                        var regEx = /^[+ -]?\d+$/;
                        if (!regEx.test(valuestr) && valuestr != '') // this will be true
                        {
                            jQuery(".errorfax").show();
                            jQuery(this).val('');
                        } else {
                            jQuery(".errorfax").hide();
                        }
                    });

                    jQuery("#date_published").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        yearRange: '1910:'
                    });
                  /*   jQuery("#agreementnodate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        yearRange: '1910:'
                    });
                    */
                    

                    jQuery('#country_id').change(function () {
                        var country_id = jQuery(this).val();
                        if (country_id)
                        {
                            var state_id = jQuery('#state_id').val();
                            jQuery('#state_id').load('/superadmin/bank/getstateDropDown/' + country_id + '/' + state_id);
                        }

                    });
                    jQuery('#state_id').change(function () {
                        var state_id = jQuery(this).val();
                        if (state_id)
                        {
                            var city_id = jQuery('#city_id').val();
                            jQuery('#city_id').load('/superadmin/bank/getcityDropDown/' + state_id + '/' + city_id);
                        }

                    });

                    jQuery('#bank').change(function () {
                        var bank_id = jQuery(this).val();
                        var lho_id = jQuery('#lho_id').val();
                        jQuery("#check-all-field").html("");
                        //alert(bank_id);
                        if (bank_id > 0) {
                            jQuery('#lho_id').load('/superadmin/bank/getLhoDropDown/' + bank_id + '/' + lho_id);
                        }


                    });
                    jQuery("#region").change(function () {
                        jQuery("#check-all-field").html("");
                    })
                    jQuery("#drt").change(function () {
                        jQuery("#check-all-field").html("");
                    })
                    jQuery('textarea.tinymce').tinymce({
                        // Location of TinyMCE script
                        script_url: '<?php echo VIEWBASE ?>js/plugins/tinymce/tiny_mce.js',
                        // General options
                        theme: "advanced",
                        skin: "themepixels",
                        width: "85%",
                        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
                        inlinepopups_skin: "themepixels",
                        // Theme options
                        theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,|,fontselect,fontsizeselect",
                        theme_advanced_buttons2: "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview",
                        theme_advanced_buttons3: "formatselect,|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
                        theme_advanced_toolbar_location: "top",
                        theme_advanced_toolbar_align: "left",
                        theme_advanced_statusbar_location: "bottom",
                        theme_advanced_resizing: true,
                        relative_urls: false,
                        // Example content CSS (should be your site CSS)
                        content_css: "css/plugins/tinymce.css",
                        // Drop lists for link/image/media/template dialogs
                        template_external_list_url: "lists/template_list.js",
                        external_link_list_url: "lists/link_list.js",
                        external_image_list_url: "lists/image_list.js",
                        media_external_list_url: "lists/media_list.js",
                        // Replace values for the template plugin
                        template_replace_values: {
                            username: "Some User",
                            staffid: "991234"
                        }
                    });



                });
                function calculateTax(amount)
                {

                    jQuery.ajax({
                        url: '/superadmin/bank_branch/ajax_taxcalculate',
                        data: {amount: amount},
                        dataType: 'json',
                        type: 'POST',
                        success: function (data) {
                            //$('#captcha-img').html(data);
                            jQuery('#stax').val(data.stax);
                            jQuery('#educess').val(data.educess);
                            jQuery('#secondaryhighertax').val(data.secondaryhighertax);
                            jQuery('#total').val(data.total);
                        }
                    });
                }



                function isNumberKey(evt)
                {  
                    var charCode = (evt.which) ? evt.which : event.keyCode;
                    console.log(charCode);
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                        return false;

                    return true;
                }
            function    checkvalidate(){
                  jQuery('#spMsg').text("");
                    var startdate 		=	jQuery('#agreementstartdate').val();
                    var enddate 		=	jQuery('#agreementenddate').val();
                    startdate				= startdate.replace(/-/g, '/');
                    enddate				        = enddate.replace(/-/g, '/');
                   
                    var startdate1=new Date(startdate);
                    var enddate1=new Date(enddate);
                    var dateTime1 = new Date(startdate).getTime(),
                    dateTime2 = new Date(enddate1).getTime();
                    var diff = dateTime2 - dateTime1;
                   if (diff <= 0) { 
                      setTimeout(function(){ jQuery('#spMsg').text("End Date should be greater than Start Date");  }, 500);
                    
                    jQuery('#agreementenddate').prop('value','');
                     return false;
                    }
       } 
       
      </script>
            <script>

            <!--calender with timepicker-->

                jQuery('#agreementstartdate').datetimepicker({
                    controlType: 'select',
                    oneLine: true,
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'HH:mm:00',
                    yearRange: '2014:2016',
                });
                jQuery('#agreementenddate').datetimepicker({
                    controlType: 'select',
                    oneLine: true,
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'HH:mm:00',
                    yearRange: '2016:2018',
                     minDate: 0
                });

            </script>
