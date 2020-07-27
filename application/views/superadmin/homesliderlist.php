<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<style>
table thead th{border: 1px solid #ccc;border-right: 0px;}

</style>

<section class="container_12">
<div class="centercontent tables">
	<div class="pageheader notab">

		<div class="row">						
			<a href="/superadmin/news/addedithomeslider" class=" button_grey">Create Homepage Slider Banner</a>
		</div>
		<?php  if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
		<?php } ?>
		<div class="box-head">Homepage Slider Banner's</div>
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
		
	<form action="" method="POST" id="searchfm" name="searchfm">
		<input type="hidden" name="controller" id="controller" value="news" />
		<div class="box-content no-pad">
		<div class="container-outer">
			<div class="container-inner">
				<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="">
					<colgroup>
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
					</colgroup>
					<thead>
						<tr>
							<th class="head0" style='width: 5%;'>ID</th>
							<th class="head1" style='width: 20%;'>Banner Title</th>
							<th class="head1" style='width: 20%;'>Image</th>
							<th class="head0" style='width: 8%;'>URL</th>
							<th class="head0" style='width: 8%;'>Order</th>
							<th class="head0" style='width: 8%;'>Status</th>
							<th class="head1" style='width: 10%;'>Creation Date</th>
							<th class="head1" style='width: 10%;'>Last Update Date</th>
							<th class="head1" style='width: 7%;'>Action</th>
						</tr>
					</thead>
					
					<tbody>
						<?php $i=0;foreach($records as $data){$i++;?>
							<tr class='gradeA'>
								<td><?php echo $i; ?></td>
								<td><?php echo $data->title; ?></td>
								<td><?php if($data->image){?><img width="100px" src="<?php echo $data->image;?>"><?php }else{echo 'N/A';} ?></td>
								<td><?php if($data->content){?><?php echo $data->content;?><?php }else{echo 'N/A';} ?></td>
								<td><?php echo $data->priority; ?></td>
								<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
								<td><?php echo $data->indate; ?></td>
								<td><?php echo $data->updated_date; ?></td>
								<td>
										<a href="/superadmin/news/addedithomeslider/<?php echo $data->id; ?>">Edit</a> 
									<!--<br>
									<a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>-->
									</td>
							</tr>
						<?php }
							?>
					</tbody>
				</table>
				</div>
			</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->
</section>

    
