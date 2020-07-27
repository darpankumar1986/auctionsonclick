<?php
if($auctionDetails)
{
		foreach($auctionDetails as $val)
		{
				$aucId = $val->id;
				$reference_no = $val->reference_no;
				$event_title = $val->event_title;
				$bankid = $this->viewer_model->getbankName($val->bank_id);
				$borrower_name = $val->borrower_name;
				$startDate= $val->auction_start_date;
				$endDate = $val->auction_end_date;
		
		}
}
?>
<section class="container_12">		
		<?php if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
		<?php } ?>
		<div class="box-head">Event Detail : <?php echo $aucId; ?></div>
			<div class="centercontent">
        <div class="pageheader">
            <span class="pagedesc"><div style="color:red; text-align:center;"><?php echo validation_errors(); ?></div></span>
        </div><!--pageheader-->
        <div id="contentwrapper" class="contentwrapper box-content2">
            <div id="validation" class="subcontent">            	                
                    <div class="row">
                        <div class="lft_heading">Event ID </div>
                        <div class="rgt_detail">
                            <?php echo $aucId; ?>
                        </div>					
                    </div>
                     <div class="row">
                        <div class="lft_heading">Property ID </div>
                        <div class="rgt_detail">
                             <?php echo $reference_no; ?>
                        </div>					
                    </div>
                     <div class="row">
                        <div class="lft_heading">Tender / Event Title </div>
                        <div class="rgt_detail">
                             <?php echo $event_title; ?>
                        </div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">Event Bank </div>
                        <div class="rgt_detail">
                             <?php echo $bankid; ?>
                        </div>					
                    </div>
                     <div class="row">
                        <div class="lft_heading">Borrower Name </div>
                        <div class="rgt_detail">
                             <?php echo $borrower_name; ?>
                        </div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">Event Start Date </div>
                        <div class="rgt_detail">
                             <?php echo $startDate; ?>
                        </div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">Event End Date </div>
                        <div class="rgt_detail">
                             <?php echo $endDate; ?>
                        </div>					
                    </div>
                  
				</div>
			</div><!--contentwrapper-->
			<br clear="all" />
	</div><!-- centercontent -->
            
            
		<div class="box-head">Add Buyer Viewer</div>
		<div class="centercontent tables">
			<div class="pageheader notab">
				<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
				<?php //echo $this->session->flashdata('message'); ?><?php } ?></span>
			</div><!--pageheader-->	
			<div id="contentwrapper" class="contentwrapper box-content2">
			<form action="" method="GET" id="searchfm" name="searchfm">
					<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
						<tbody>
							<tr>
								
								<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" class="custom_select no_top_mrgn" placeholder="Enter Search" name="title" value="<?php echo $search['title']?>"></td>
								<td rowspan="3" style="width:35%; vertical-align:middle; border-top: 1px solid #ddd;">
									<input type="submit" class="search_submit  button_grey no_top_mrgn" name="btnSearch" id="btnSearch" value="Search">
									<a href="<?php echo base_url().'superadmin/viewer/addviewer/'.$auction_id.''?>" class="button_grey">Reset</a> 
								</td>
							</tr>
						</tbody>
					</table>
				<input type="hidden" name="controller" id="controller" value="user" />
				<div class="box-content no-pad">
					<div class="container-outer">
						<div class="container-inner">
				<table cellpadding="0" cellspacing="0" border="0" class="stdtable display">
					
					<colgroup>
						<col class="con0" />
						<col class="con1" style="width:50px !important"/>
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />				
					</colgroup>
					<thead>
						<tr>
							<th class="head0" >ID</th>
							<th class="" style="width:50px !important">Email ID</th>
							<th class="head1">Name</th>
							<th class="head0" style="width:50px !important">User ID</th>
							<th class="head1">Organization Name</th>
							<th class="head1">Branch Name</th>
							<th class="head0">User Status</th>
							<th class="head0">Type</th>
							<th class="head1">Creation Date</th>
							<th class="head0">Action</th>
						</tr>
					</thead>
					
					<tbody>
						<?php $i=0;foreach($records as $data){$i++;?>
							<tr class='gradeA'>
								<td><?php echo $data->id; ?></td>
								<td style="width:50px !important"><?php echo $data->email_id; ?></td>
								<td><?php echo $data->first_name.' '.$data->last_name; ?></td>
								<td><?php echo $data->user_id; ?></td>
								<td><?php echo $data->bank_name; ?></td>
								<td><?php echo $data->branch_name; ?></td>
								<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
								<td><?php echo $data->user_type; ?></td>
								<td><?php echo $data->indate; ?></td>
								<td>
									<?php $status = $this->viewer_model->checkUserExists($auction_id,$data->id); ?>
									<?php if($status == '1') { ?>
									<a href="/superadmin/viewer/removeviewer/<?php echo $auction_id; ?>/<?php echo $data->id; ?>">Remove User</a>
									<?php }else{ ?>
									<a href="/superadmin/viewer/saveviewer/<?php echo $auction_id; ?>/<?php echo $data->id; ?>">Add User</a>
									<?php } ?>
								</td>
							</tr>
						<?php }?>	
						
					</tbody>
				</table>
						<div class="row" style="text-align:center;">						
							<a href="<?php echo base_url().'superadmin/viewer'?>" class="button_grey">Back</a> 
						</div>
					</div>
				</div>
				<div class="pagination">
					<span style="float:right;padding-top: 9px;"><?php echo $pagination_links; ?></span>
				</div>
			</form>
			</div><!-- #updates -->
		</div><!--contentwrapper-->
		<br clear="all" />
		</div><!-- centercontent -->
	</section>
	
