
<div class="centercontent tables">
	<!--pageheader-->
	<div id="contentwrapper" class="contentwrapper">
	<?php //Search start ?>
		<form action="" method="POST" id="searchfm" name="searchfm">
		<?php //search ends ?>
	
		<input type="hidden" name="controller" id="controller" value="bank" />
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable">
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
					<th class="head0" style='width: 5%;'>OrderID</th>
					<th class="head1" style='width: 10%;'>Auction ID</th>
					<th class="head1" style='width: 10%;'>Product</th>
					<th class="head1" style='width: 10%;'>userID</th>
					<th class="head0" style='width: 5%;'>Amount</th>
					<th class="head1" style='width: 5%;'>Email</th>					
					<th class="head0" style='width: 5%;'>Status</th>
					<th class="head0" style='width: 8%;'>TrackingID</th>
					<th class="head0" style='width: 8%;'>Bank ref No</th>
					<th class="head0" style='width: 5%;'>Card Name</th>
					<th class="head0" style='width: 10%;'>Payment Mode</th>
					<th class="head0" style='width: 15%;'>Order status</th>
					
					<th class="head1" style='width: 10%;'>Added Date</th>
					
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
				<tr class='gradeA'>
					<td><?php echo $data->id; ?></td>
					<td><?php 
					if($data->auctionID){
						echo $data->auctionID;
					}else{
						echo "Non Auction";	
					} ?></td>
					<td><?php
					echo GetTitleByField ('tbl_product' , 'id='.$data->productID , 'name');
					 ?></td>
					<td><?php 
					echo GetTitleByField ('tbl_user_registration' , 'id='.$data->userID , 'first_name');
					  ?></td>
					<td><?php echo $data->amount ?></td>
					<td><?php echo $data->billing_email ?></td>
					<td><?php echo ($data->status == 1)?'Paid':'Not Paid'; ?></td>
					<td><?php echo $data->tracking_id ?></td>
					<td><?php echo $data->bank_ref_no ?></td>
					<td><?php echo $data->order_status ?></td>
					<td><?php echo $data->payment_mode ?></td>
					<td><?php echo $data->card_name ?></td>
					<td><?php echo ($data->indate); ?></td>
					
				</tr>
				<?php }?>	
			</tbody>
		</table>
		<div class="pagination">
			
			<span style="float:right"><ul><?php echo $pagination_links; ?></ul></span>
		</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->



    
