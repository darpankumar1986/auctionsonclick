<section class="middle-container tpmrgn">
  <div class="wrapper clear">
    <div id="left-container">
     <div id="breadcrum">
		<a href="/">Home</a>&nbsp;»&nbsp;<span>Search</span>
	</div>
      <div id="commentary-inner" class="btmrg">
       
        <div class="heading1"><span class="redbg">Search Result : "<?php echo urldecode($search_key); ?>"</span></div>
		<?php 
			if(count($article_record) <= 0){
			?>
			Record not found.
			<?php
			}
			else
			{
			$i = 1;
			foreach($article_record as $key=>$article_data){ 
			$article_redirct_url=base_url().$article_data->category_slug.'/'.$article_data->slug;
		?>		
         <div class="widget_arch <?php echo (($i%3) == 0)?'rtmrgn0':''?>">
          <div class="widget_img"><a href="<?php echo $article_redirct_url; ?>"><img src="<?php echo base_url(thumb('public/uploads/article/'.$article_data->image,'190','133')); ?>" alt="<?php echo $article_data->title; ?>"></a></div>
          <div class="desc float-left">
            <div class="heading"><a href="<?php echo $article_redirct_url; ?>" class="bold"><?php echo $article_data->title; ?></a></div>
           
            <!--<div class="share_sec">
              <div class="left-section">
                <div class="row writter float-left btmr1"><a><?php echo $article->author_name?></a></div>                
                <div class="watch float-right btmr1 clear-right"><?php echo GetDateFormat($article->date_published)?></div>
               <div class="location float-right btmr1 clear-right">Delhi</div>
              </div>
            </div>-->
            <p><?php if($article_data->excerpt!='default'){?><?php echo strtok(wordwrap($article_data->excerpt, 400, "...\n"), "\n");?><?php }?></p>
           </div>
        </div>
		<?php $i++;}}?>
        

              
        <!--<div class="pagination float-right"> <span class="disabled">PRE</span> <span class="current">1</span><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">NEXT</a> </div>-->
      </div>
    </div>