<table cellpadding="0" cellspacing="0" border="0" class="stdtable">

			<thead>
				<tr>
					<th class="head0" style='width: 5%;'>ID</th>
					<th class="head1" style='width: 20%;'>Name</th>
					<th class="head1" style='width: 20%;'>Type</th>
					<!--<th class="head0" style='width: 7%;'>status</th>-->					
					<th class="head1" style='width: 10%;'>Added Date</th>
					<th class="head1" style='width: 20%;'>Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $data->id; ?></td>
						<td><?php echo $data->name; ?></td>
						<td><?php echo $data->type_id;//GetTitleById('tbl_attribute_group',$data->type_id,'name'); ?></td>
						<!--<td><input type="checkbox" data-id="<?php echo $data->id; ?>" class="status" name="status" id="status_<?php echo $i; ?>" value="1" <?php echo ($data->status == 1)?'checked':''; ?>></td>-->
						
						
						<td><?php echo GetDateFormat($data->indate); ?></td>
						
						<td>
							<a href="/dynamic_form/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a>
							
						</td>
					</tr>
				<?php }?>	
			</tbody>
		</table>
<ul>
	<?php echo $pagination_links; ?>
</ul>