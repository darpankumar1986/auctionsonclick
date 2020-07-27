<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>bankEauction</title>
<meta name="description" content="bankEauction" />
<meta name="keywords" content="bankEauction" />
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php echo base_url()?>/css/bace.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/admin-style.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/nav.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/banner.css">
<link rel="stylesheet" href="<?php echo base_url()?>bankeauc/css/common.css">
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/common.js"></script>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->
<style>
table tr.odd td {
    background-color: transparent;
}
table.dataTable{border-collapse: collapse;}
</style>
</head>
<body>
<?php //print_r($emdrow);?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
			<div class="heading4 btmrg20">Corrigendum Detail</div><?php //print_r($corrigendum)?>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
			<thead><tr class="bg_color">
			<th width="">Fields</th>
			<th width="150">Actual(Current)</th>
			<th width="150">Scheduled(Previous)</th>
			</tr>
		  </thead>
		  
		  
              <tbody role="alert" aria-live="polite" aria-relevant="all">
			  <tr class="odd">
                  <td  align="left" valign="top" class=""><strong>Corrigendum By</strong></td>
                  <td  align="left" valign="top" class="" >
				  <?php 
		echo $name=GetTitleByField('tbl_user','id='.$corrigendum[0]->created_by,"user_id");
				   ?></td>
				  <td></td>
                </tr>
			  
			  <?php if($corrigendum[0]->remarks){?>
                <tr class="even">
                  <td  align="left" valign="top" class=""><strong>Remarks</strong></td>
                  <td  align="left" valign="top" class="" >
				  <?php echo $corrigendum[0]->remarks?></td>
				  <td></td>
                </tr>
                <?php }if($corrigendum[0]->product_description){?>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Property Address</strong></td>
                  <td align="left" valign="top" class=""><?php echo $corrigendum[0]->product_description?></td>
				  <td></td>
				</tr>
                <?php }
                if($corrigendum[0]->NIT_date){?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
                  <td align="left" valign="top" class=""><?php echo ($corrigendum[0]->NIT_date!='0000-00-00 00:00:00')? $corrigendum[0]->NIT_date:'';?></td>
				  <td><?php echo ($corrigendum[0]->old_NIT_date!='0000-00-00 00:00:00')? $corrigendum[0]->old_NIT_date:'';?></td>
				</tr>
				<?php }if($corrigendum[0]->inspection_date_from){?>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Date of inspection of asset(From Date)</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo ($corrigendum[0]->inspection_date_from!='0000-00-00 00:00:00')? $corrigendum[0]->inspection_date_from:'';?>
				  </td>
				  <td>
				  <?php echo ($corrigendum[0]->old_inspection_date_from!='0000-00-00 00:00:00')? $corrigendum[0]->old_inspection_date_from:'';?>
				  </td>
				</tr>
				<?php }if($corrigendum[0]->inspection_date_to){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Date of inspection of asset(To Date)</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo ($corrigendum[0]->inspection_date_to!='0000-00-00 00:00:00')? $corrigendum[0]->inspection_date_to:'';?>				 
				  <td> <?php echo ($corrigendum[0]->old_inspection_date_to!='0000-00-00 00:00:00')? $corrigendum[0]->old_inspection_date_to:'';?></td>
				</tr>
				<?php }if($corrigendum[0]->bid_last_date){ ?>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Sealed Bid Submission Last Date</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo ($corrigendum[0]->bid_last_date!='0000-00-00 00:00:00')? $corrigendum[0]->bid_last_date:'';?>
				  </td>
				  <td><?php echo ($corrigendum[0]->old_bid_last_date!='0000-00-00 00:00:00')? $corrigendum[0]->old_bid_last_date:'';?></td>
				</tr>
				<?php }if($corrigendum[0]->related_doc){?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Uploaded document</strong></td>
                  <td align="left" valign="top" class=""><a href="/public/uploads/event_auction/<?php echo $corrigendum[0]->related_doc?>" download  target="_blank"><?php echo $corrigendum[0]->related_doc?></a></td>
				  <td><a href="/public/uploads/event_auction/<?php echo $corrigendum[0]->old_related_doc?>" download target="_blank"><?php echo $corrigendum[0]->old_related_doc?></a></td>
				</tr>
				<?php }if($corrigendum[0]->bid_opening_date){?>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Sealed Bid Opening Date</strong></td>
                  <td align="left" valign="top" class=""><?php echo ($corrigendum[0]->bid_opening_date!='0000-00-00 00:00:00')? $corrigendum[0]->bid_opening_date:'';?></td>
				  <td><?php echo ($corrigendum[0]->old_bid_opening_date!='0000-00-00 00:00:00')? $corrigendum[0]->old_bid_opening_date:'';?></td>
				</tr>
				<?php }if($corrigendum[0]->auction_start_date){?>
                  <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo ($corrigendum[0]->auction_start_date!='0000-00-00 00:00:00')? $corrigendum[0]->auction_start_date:'';?>
				 </td>
				  <td><?php echo ($corrigendum[0]->old_auction_start_date!='0000-00-00 00:00:00')? $corrigendum[0]->old_auction_start_date:'';?></td>
				</tr>
				<?php }if($corrigendum[0]->auction_end_date){?>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
                  <td align="left" valign="top" class=""><?php echo ($corrigendum[0]->auction_end_date!='0000-00-00 00:00:00')? $corrigendum[0]->auction_end_date:'';?></td>
				  <td><?php echo ($corrigendum[0]->old_auction_end_date!='0000-00-00 00:00:00')? $corrigendum[0]->old_auction_end_date:'';?></td>
				</tr>
                  <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Special Terms And Conditions</strong></td>
                  <td align="left" valign="top" class="">
                                <?php if(($corrigendum[0]->supporting_doc!='' && $corrigendum[0]->supporting_doc!='0')){?> <a href="/public/uploads/event_auction/<?php echo ($corrigendum[0]->supporting_doc!='' && $corrigendum[0]->supporting_doc!='0')? $corrigendum[0]->supporting_doc:'';?>" download target="_blank"><?php echo ($corrigendum[0]->supporting_doc!='' && $corrigendum[0]->supporting_doc!='0')? $corrigendum[0]->supporting_doc:'';?></a><?php }?></td>
                  <td><?php if(($corrigendum[0]->old_supporting_doc!='' && $corrigendum[0]->old_supporting_doc!='0')){?><a href="/public/uploads/event_auction/<?php echo ($corrigendum[0]->old_supporting_doc!='' && $corrigendum[0]->supporting_doc!='0')? $corrigendum[0]->old_supporting_doc:'';?>" download target="_blank"><?php echo ($corrigendum[0]->old_supporting_doc!='0')? $corrigendum[0]->old_supporting_doc:'';?></a><?php } ?></td>
				</tr>               
               <?php }
               if($corrigendum[0]->image!='0' && $corrigendum[0]->image!=''){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Upload Images</strong></td>
                  <td align="left" valign="top" class=""><?php if($corrigendum[0]->image!='0' && $corrigendum[0]->image!=''){?><a href="/public/uploads/event_auction/<?php echo $corrigendum[0]->image?>" download target="_blank"><?php echo $corrigendum[0]->image?></a><?php } ?></td>
                                  <td><?php if($corrigendum[0]->old_image!='0' && $corrigendum[0]->old_image!=''){ ?><a href="/public/uploads/event_auction/<?php echo $corrigendum[0]->old_image;?>" download target="_blank"><?php echo $corrigendum[0]->old_image?></a><?php } ?></td>
				</tr>
				<?php }
                                if($corrigendum[0]->status){?>
                <tr class="odd">
                  <td align="left" valign="top" class=""><strong>Status</strong></td>
                  <td align="left" valign="top" class=""><?php
				  
				  if($corrigendum[0]->status==1){
					  echo "publish"  ;
				  }else if($corrigendum[0]->status==0)
				  {
					echo "saved"   ; 
				  }else if($corrigendum[0]->status==2)
				  {
					echo "initialize" ;   
				  }else if($corrigendum[0]->status==3)
				  {
					echo "stay" ;   
				  }else if($corrigendum[0]->status==4)
				  {
					echo "cancel" ;   
				  }
				  ?></td>
				  <td><?php
				  if($corrigendum[0]->old_status==1){
					  echo "publish" ; 
				  }else if($corrigendum[0]->old_status==0)
				  {
					echo "saved"  ;  
				  }else if($corrigendum[0]->old_status==2)
				  {
					echo "initialize"  ;  
				  }else if($corrigendum[0]->old_status==3)
				  {
					echo "stay" ;   
				  }else if($corrigendum[0]->old_status==4)
				  {
					echo "cancel" ;   
				  }
				 ?></td>
				</tr>
               <?php }?>
              </tbody>
             
            </table>
            
			</div>
          </div>
        </div>
    </div><span style="float:right;">
      </span>
    </div>
  </div>
</section>

</body>

</html>
