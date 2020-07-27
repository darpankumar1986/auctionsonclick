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
<link rel="stylesheet" href="/css/bace.css">
<link rel="stylesheet" href="/css/admin-style.css">
<link rel="stylesheet" href="/css/nav.css">
<link rel="stylesheet" href="/css/banner.css">
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>
<body>
<?php //echo $auction_id;
//print_r($document);
?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;"> 
           <div class="form" style="text-align:center;">
			<form name="submitdoc" action="/helpdesk_executive/uploadAuctionDocument" method="post" enctype="multipart/form-data">
			<div class="heading4 btmrg20">Upload Document</div>
			<div class="seprator btmrg20"></div>
			<?php
			if(count($document)>0){
				$documentIDs=implode(",",$document);
				foreach ($document as $key=>$doc){
				$name=GetTitleByField('tbl_auction_participate_doc', "bidderID='".$bidderid."' AND auctionID='".$auction_id."' AND documentID='".$key."' ", 'document_name');	
				//echo $this->db->last_query();?>			
			<dl>
                <dt <?php if(!$name){ echo 'class="required"';}else{ echo '';}?> >
                  <label><?php echo $doc;?></label>
                </dt>
                <dd>
                  <input <?php if(!$name){ echo "required";}else{ echo '';}?>  name="doc_name_<?php echo $key; ?>" type="file"  class="input">
				  
				<?php if($name){ ?>
				<div style="clear:both;">
				<a download href="/public/uploads/document/<?php echo $auction_id;?>/<?php echo $bidderid;?>/<?php echo $name;?>"><?php echo $name;?></a></div>
				<?php } ?>	
                </dd>
             </dl>
					<?php
				}
				
			}
			?>
              
            <div class="seprator btmrg20"></div>
            <div class="button-row"> 
				<input type="hidden" name="documentid" value="<?php echo $doc_to_be_submitted;?>" >
				<input type="hidden" name="auction_id" value="<?php echo $auction_id;?>" >
				<input type="hidden" name="bidderid" value="<?php echo $bidderid;?>" >
				<input name="submit" value="Submit" type="submit" class="b_submit float-right">
			</div>
			
			</form>
			
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>