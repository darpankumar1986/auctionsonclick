  <style>
  /* IE has layout issues when sorting (see #5413) */
.group { zoom: 1 }
  </style>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script>
  jQuery(function() {
    jQuery( "#accordion" )
      .accordion({
        header: "> div > h3",
		active: false,
		collapsible: true
      })
      .sortable({
        axis: "y",
        handle: "h3",
        stop: function( event, ui ) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children( "h3" ).triggerHandler( "focusout" );
           // Refresh accordion to handle new order
          $( this ).accordion( "refresh" );
		  
        }
      });
	  
	  jQuery('.sortable-article').sortable();
  });
  </script>



<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<form name="home_page_view" id="home_page_view" action="/superadmin/home_page_view/save/" method="POST">
	<div id="contentwrapper" class="contentwrapper">
		<?php if(count($records)>0){ ?>		
		<div id="accordion">		
			<?php foreach($records as $key=>$record){ ?>
			<div class="group">
				<h3><?php echo $record->name; ?></h3>
				<div>
				<input type="hidden" name="catg_sort[]" value="<?php echo $record->id; ?>">
				<?php if(count($articles[$record->id])>0){
				$inc = 1;
				?>
				<ul class="sortable-article sortlist">
				<?php
				foreach($articles[$record->id] as $article){ ?>
						<li class="subsortclass">
							<div class="label">
								<span class="moveicon"></span>
								<?php echo $article->title; ?>
							<input type="hidden" name="article_sort[<?php echo $record->id; ?>][]" value="<?php echo $article->id; ?>">
							</div>
						</li>
				<?php } ?>
				</ul>
				<?php } ?>
				</div>
			</div>
			<?php  } ?> 
			
		</div>
		<?php	} ?>
				<p class="stdformbutton">					
					<input type="submit"  name="addedit" id="addedit" value="Submit">
				</p>
		
		
		<div class="pagination" style="float:right">
			<?php echo $pagination_links; ?>
		</div>
	</div><!-- #updates -->
	</form>
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->















		

    
