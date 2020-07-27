<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Define Demand Note</title>
<meta name="description" content="bankEauction" />
<meta name="keywords" content="bankEauction" />
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php echo base_url()?>/css/bace.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/admin-style.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/nav.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/banner.css">
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/common.js"></script>
<script  type="text/javascript" src="<?php echo base_url(); ?>/js/ckeditor/ckeditor.js"></script>
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->

</head>
<style>
    .box-head {
        width: 98%;
        float: left;
        padding-top: 7px;
        padding-left: 2%;
        cursor: pointer;
        margin: 15px 0 0 0;
        border-radius: 3px;
        border: 1px solid #bbb;
        color: #fff;
        font-size: .9em;
        font-weight: 600;
        text-shadow: 0 1px 0 #222;
        background: #dc4020;
        height: 27px;
    }
    
    .outer {
        width: 98%;
        padding: 1%;
        margin: 15px 0;
        border: solid 1px #ccc;
    }
    
    .half_acct {
        width: 40%;
        float: right;
        text-align: right;
    }
    
    .red {
        color: #F00;
    }
    
    .half_acct> label {
        float: left;
        text-align: right;
        font-size: 12px;
        color: #000;
        font-weight: bold;
        padding-top: 3px;
        padding-right: 1%;
        font-family: Arial;
    }

    .half_acct> select {
        display: inline;
        float: left;
        border: solid 1px #ccc;
        color: #737373;
        font-size: 12px;
        background: #fff;
        padding: 3px 1%;
        width: 38%;
        font-family: Arial;
        margin-top: 0;
    }
    
    table td {
    border: 0;
}
</style>

<body>
<section>
    <form id="define_demand_note" name="define_demand_note" action="<?php echo base_url('buyer/abc.....')?>" method="post" enctype="multipart/form-data" > 
    <div class="row">
        <div class="wrapper-full">
            <div class="dashboard-wrapper">
                <div class="container">
                    <div class="secttion-right" style="width:100%;">
                        
                        <div class="table-wrapper btmrg20">
                            <div class="table-heading btmrg">
                                <?php if(isset($this->session->userdata['flash:old:message'])){?>
                                    <div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
                                <?php } ?>
                                <?php if(isset($this->session->userdata['flash:old:error_msg'])){?>
                                        <div class="fail_msg"> <?php echo @$this->session->userdata['flash:old:error_msg']; ?></div>
                                 <?php } ?>
                                <div class="box-head">Define Demand Note Format</div>
                            </div>

                            <div class="outer">
                                <div class="half_acct">
                                    <label>Token<span class="red"></span>:</label>
                                    <select name="token" id="token">
                                        <option value="">Select Token</option>
                                        <?php foreach($tokens as $tkn): ?>
                                        <option value="<?php echo $tkn->token_id; ?>"><?php echo $tkn->token_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input name="insert" value="Insert" type="button" style="float: left; margin-left: 1%; padding: 4px 10px!important;" class="b_submit button_grey" onclick="insertToken(this);">
                                </div>
                            </div>
                            
                             <div style="min-height: 0px; display: block; margin-left: 18%;" style="margin-left: 18%;" class="box-content no-pad table-tp-space"> 		
                                <div class="container-outer">
                                    <div class="container-inner">
                                        <div class="row">
                                            <div class="lft_heading">Demand Note Body<span class="red"> *</span></div>
                                            <div class="rgt_detail">
                                                <textarea name="demand_note" id="demand_note"><?php echo $demand_note_body; ?></textarea>
                                            </div>	
                                        </div>	
                                        <script>
                                            CKEDITOR.replace('demand_note');
                                            CKEDITOR.config.width = 900;
                                            CKEDITOR.config.height = 400;
                                        </script>
                                    </div>
                                </div>
                            </div> 
                    </div>
                        
                        
                        
                        <div class="table-section" style="padding-top: 10px; padding-bottom: 10px;"> 						
                        <table  align="center" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">								
                                <tr>								 
                                    <td align="center" valign="top" >
                                        <input name="define_note" id="define_note" value="Save" type="submit" class="button_grey b_submit" onclick="return validateFrmDefineNote();">
                                        <input name="exit" value="Exit" onclick="parent.$.colorbox.close();"  type="button" class="b_submit button_grey">
                                    </td>								  
                                </tr>
                            </tbody>             
                        </table>
                    </div>
                        
                        
                </div>
            </div>
        </div>
    </div>
   </form>
</section>
</body>
</html>
<script>
    //Function to insert token
    function insertToken(tkn)
    {   
        var token_id = $.trim($(tkn).prev('[name="token"]').find('option:selected').val());
        if(token_id != '')
        {
            var token_name = $.trim($(tkn).prev('[name="token"]').find('option:selected').text());
            CKEDITOR.instances['demand_note'].insertText(token_name);
        }
        
    }
</script>
<script>
  $("#apply_online").click(function() {
   parent.$.colorbox.close();
});
    </script>
