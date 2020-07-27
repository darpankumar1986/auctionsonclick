<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>

<div class="centercontent tables" style="margin-left:0px;">
	
	<div id="contentwrapper" class="contentwrapper">
		<div class="subcontent">
			  <h4><?php echo $heading?></h4>
			 
			<table cellpadding="2" cellspacing="4" border="1" class="stdtable" id="dyntable">
			<tr>
			<th>Field Name</th>
			<th>Value</th>
			</tr>
				<tbody>
				<?php //print_r($detail_records);
				foreach($detail_records as $key=>$data){
				/*if($key=='auction'){
				foreach($detail_records->auction as $key1=>$data1){?>
				<tr class="gradeA odd">
					<th><?php echo ucfirst($key1)?></th>
					<th><?php echo $data1?></th>
				</tr>
				<?php }}else{*/?>
				<tr class="gradeA odd">
					<th><?php echo ucfirst($key)?></th>
					<th><?php echo $data?></th>
				</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->