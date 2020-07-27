<style>
	.form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
	.datagrid table {width:100%; border:solid 1px #ccc;}
	table.dataTable thead th {font-weight: normal; border-right: solid 1px#ccc;  padding:10px 2%;   font-size: 12px;}
	table.dataTable thead th:last-child {border-right: none;}
	.datagrid table tbody td{border-right: solid 1px#ccc;}
	.datagrid table tbody td:last-child{border-right: none;}
	.datagrid table tbody td {font-size:9px; word-wrap:break-word; cursor:pointer;     word-break: break-all; }
	.dataTables_info{float:left; font-size:10px;}
	.btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
	.selected{background:#cccccc !important;}
	.row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
	#big_table_processing img{width: 50px;}
	#big_table_processing{background-color: transparent;border: 0px;}
	
	#menu1  {	 padding: 0px 0% 0 8%;  }
#menu1 li {display:inline-block; padding: 0px 2%; line-height:35px;    border-left: solid 1px #ccc; }
#menu1 li:last-child{border-right: solid 1px #ccc;}
#menu1 li a{color:#fff; text-decoration:none; font-size:.9em; text-transform:uppercase; }
#menu1 li:hover{background:#a71a00;}
.active{background:#a71a00;}
.color1{color:#F00;}
header {
    background: #fff;
    border-top: solid 3px #bd2000;
    width: 85%;
    border-bottom: solid 1px #961a00;
    padding: 5px 7.5%;
} 
</style>
<link rel="stylesheet" href="<?php echo base_url()?>css/colorbox.css" />
<script src="<?php echo base_url()?>js/jquery.colorbox.js"></script>
<section style="min-height:400px;">
  <?php echo $breadcrumb;
  ?>
  <div class="row" style="margin-top:5px;">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
			<?php
			/*
			echo "<pre>";
			print_r($data);
			*/
			
			foreach($data  as $img)
			{
				$name = str_replace('Upload','',$img['upload_document_field_name']);
			?>
				
				<div class="col-xs-6 col-sm-3 col-md-3 text-center" style="float:left;">
					<?php if($img['upload_document_field_type']==1) 
					{ 
						
						$imgExts = array("jpg", "jpeg", "png");
						$imgArr = explode('.',$img['file_path']);
						if(in_array($imgArr[1],$imgExts))
						{
						
					?>
							<a class="bidderwiseitem cboxElement thumbnail" href="<?php echo base_url();?>owner/quick_view/public/uploads/event_auction/<?php echo $img['file_path']; ?>" class="" data-toggle="modal" data-target="#lightbox">
						
								<img style="width:200px;height:200px;float:left;margin-left:5px;" src="<?php echo base_url();?>public/uploads/event_auction/<?php echo $img['file_path'];?>">                        						
							</a>
                    <?php 
						}
						if($imgArr[1] =='pdf')
						{
					?>	
							<a download class="" href="<?php echo base_url();?>public/uploads/event_auction/<?php echo $img['file_path']; ?>" class="">
								<img style="width:200px;height:200px;float:left;margin-left:5px;" src="<?php echo base_url();?>images/pdf-icon.jpg">
							</a>
					<?php
						}
						
					
                    } 
                    else {?>
						
						<a class="" href="<?php echo base_url();?>public/uploads/event_auction/<?php echo $img['file_path']; ?>" class="">
						<img download style="width:200px;height:200px;float:left;margin-left:5px;" src="<?php echo base_url();?>images/dummy_video.gif">
                    </a>
						<?php } ?>
                    <br>
                    <br>
                    <div style="text-align:center; width:75%;font-weight:bold; font-size:12px;"><?php echo $name;?></div>
                </div>
			<?php
			}
			
			?>			
      </div>
    </div>
  </div>
</section>
<script>
$(".bidderwiseitem").colorbox({iframe:true, width:"60%", height:"100%"});
</script>
