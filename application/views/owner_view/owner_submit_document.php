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
        <script src="<?php echo base_url() ?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>/js/common.js"></script>
        <style>
            .error_class{
               font-family:verdana;
               color:#F00;
               font-size:10.5px;
            }
            
        </style>
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!--[if IE]>
        <script type="text/javascript" src="/js/respond.js"></script>
        <![endif]-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    </head>
    <body>
        <?php
        //echo $auction_id;
//print_r($document);
        ?>
        <section>
            <div class="row">
                <div class="wrapper-full">
                    <div class="dashboard-wrapper">

                        <div class="container">
                            <div><ul class="error_class"></ul>
                                <span class="success_msg" style="color:#009000; font-weight: bold;"><?=$msg;?></span>
                            </div>
                            <div class="secttion-right" style="width:100%;"> 
                                <div class="form" style="text-align:center;">
                                    <form name="submitdoc" action="/owner/uploadAuctionDocument" method="post" onsubmit="return checkvaliddocumentimage();" enctype="multipart/form-data">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        <div class="heading4 btmrg20">Upload Document</div>
                                        <div class="seprator btmrg20"></div>
                                        <?php
                                        if (count($document) > 0) {
                                            $id=1;
                                            $documentIDs = implode(",", $document);
                                            foreach ($document as $key => $doc) {												
                                                $name = GetTitleByField('tbl_auction_participate_doc', "bidderID='" . $bidderid . "' AND auctionID='" . $auction_id . "' AND documentID='" . $key . "' ", 'document_name');
                                                //echo $this->db->last_query();
                                                ?>			
                                                <dl>
                                                    <dt <?php
                                                    if (!$name && $key !='16') {
                                                        echo 'class="required"';
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?> >
                                                    <label><?php echo $doc; ?></label>
                                                    <input type="hidden" value="<?=$doc;?>" id="doc_<?=$id?>" >
                                                    </dt>
                                                    <dd>
                                                        <input <?php
                                                       // if (!$name) { echo "required";} else { echo ''; }
                                                        ?>  name="doc_name_<?php echo trim($key); ?>" type="file" id="doc_name_<?php echo trim($key); ?>"  class="input">

                                                        <?php if ($name) { ?>
                                                            <div style="width: 100%;float: left;padding-bottom:5px;text-align: left;font-size: 12px;font-weight: bold; margin-top:-5px;">
                                                                <a target="_blank" href="/public/uploads/document/<?php echo $auction_id; ?>/<?php echo $bidderid; ?>/<?php echo $name; ?>">View</a></div>

                                                            <input type="hidden" name="old_doc_name_<?php echo trim($key); ?>" id="old_doc_name_<?php echo trim($key); ?>" value="<?php echo $name; ?>"> 
                                                <?php } ?>	
                                                    </dd>
                                                </dl>
        <?php  $id++;
    }
}
?>                                     <div class="seprator btmrg20"></div>
                                        <div class="button-row"> 
                                            <input type="hidden" name="documentid" value="<?php echo $doc_to_be_submitted; ?>" >
                                            <input type="hidden" name="auction_id" value="<?php echo $auction_id; ?>" >
                                            <input type="hidden" name="bidderid" value="<?php echo $bidderid; ?>" >
                                            <input name="submit" value="Submit" type="submit" class="b_submit"  style="margin-top:5px;">
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
<script>
    jQuery(document).ready(function(){
		
		jQuery('.input').change(function () {
			var getValue = this.value;
			var ext1 = getValue.split('.');
			var arr = ext1.length;
			var indexValuee = arr-1;
			if(typeof ext1[indexValuee] == "undefined")
			{
				alert('This is not an allowed file type.');
				this.value = '';
			}
			//var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext1[indexValuee]) {
				//case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
                                case 'jpg':case 'pdf':
				$('.input').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type. Only jpg and pdf file is allowed.');
					this.value = '';
			}
		});
		
		
  <?php if($msg){	?>
		 setTimeout(function(){ parent.jQuery.colorbox.close() }, 3000);
	<?php } ?> 
             });
    </script>
