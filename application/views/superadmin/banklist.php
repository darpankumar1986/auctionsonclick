<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<style>
table thead th{border: 1px solid #ccc;border-right: 0px;}

</style>

<section class="container_12">
<div class="centercontent tables">
	<div class="pageheader notab">		
		<?php if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
		<?php } ?>
		<div class="box-head">Bank List</div>
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
							<th class="head1" style='width: 40%;'>Organization Name</th>
							<th class="head1" style='width: 20%;'>Action</th>
						</tr>
					</thead>
					
					<tbody>
						<?php $i=0;foreach($records as $data){$i++;?>
							<tr class='gradeA'>
								<td><?php echo $i; ?></td>
								<td><?php echo $data->name; ?></td>
								<td><a href="/superadmin/news/bankbannerlist/<?php echo $data->id; ?>">Header Banner List  </a> || <a href="/superadmin/news/banksliderlist/<?php echo $data->id; ?>">Middle Banner List  </a></td>
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

    
