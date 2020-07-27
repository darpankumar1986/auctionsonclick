<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

<section class="container_12">

<div class="centercontent tables">
	<div class="pageheader notab">
			<div class="row">						
					<a href="<?php echo base_url()?>superadmin/bank_account/addedit" class="button_grey">Create Bank Account</a>
				</div>
				<?php if( $this->session->flashdata('message')) {?>
								<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
								<?php echo $this->session->flashdata('message'); ?></span>		
				<?php } ?>
				<div class="box-head">Create Bank Account</div>
				<?php /* ?>
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/city/addedit" class="b_green"><strong>Add New City</strong></a>	</span></h1>
		<?php */ ?>
	
	</div><!--pageheader-->	
	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="GET" id="searchfm" name="searchfm">
            <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
                    <tbody>
                            <tr>

                                    <td style="width:3%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" placeholder="Search..." name="title" class="custom_select no_top_mrgn" value="<?php echo $search['title']?>"></td>
                                    <td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
                                            <input type="submit" name="btnSearch" id="btnSearch" class="search_submit no_top_mrgn button_grey" value="Search">
                                    </td>
                            </tr>

                    </tbody>
            </table>
		
		
	<input type="hidden" name="controller" id="controller" value="email_controller" />
		<div class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
							<table cellpadding="0" cellspacing="0" border="0" class="stdtable display">
								
								<colgroup>
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
                                                                        <th class="head0">Id</th>
                                                                        <th class="head1">Organization Name</th>
                                                                        <th class="head1">Account Holder Name</th>
                                                                        <th class="head0">Bank Name</th>
                                                                        <th class="head1">Account Number</th>
                                                                        <th class="head0">IFSC Code</th>
                                                                        <th class="head1">Account Nick Name</th>
                                                                        <th class="head0">Status</th>
                                                                        <th class="head1">Actions</th>
                                                                    </tr>
								</thead>
								
								<tbody>
                                                                    <?php $i=0;foreach($records as $data){ $i++;
                                                                    $totalrows=$this->bank_account_model->GetTotalRecord($data->bank_account_id);

                                                                    ?>
                                                                        <tr class='gradeA'>
                                                                            <td><?php echo $data->bank_account_id; ?> </td>
                                                                            <td><?php echo GetTitleByField('tbl_bank', 'id="'.$data->organization_id.'"', 'name'); ?> </td> 
                                                                            <td><?php echo $data->account_holder_name; ?> </td> 
                                                                            <td><?php echo $data->bank_name; ?> </td>
                                                                            <td><?php echo $data->account_number; ?> </td>
                                                                            <td><?php echo $data->ifsc_code; ?> </td>
                                                                            <td><?php echo $data->account_nick_name; ?> </td>
                                                                            <td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
                                                                            <td>
                                                                                <a href="/superadmin/bank_account/addedit/<?php echo $data->bank_account_id; ?>">Edit</a>

                                                                            </td>
                                                                        </tr>
                                                                    <?php }?>	
									
								</tbody>
							</table>
							
						<div class="row" style="text-align:center;">						
											<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a> 
										</div>
									</div>
								</div>
					
						<div class="pagination">
		
							<span style="float:right;padding-top:9px;"><?php echo $pagination_links; ?></span>
						</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->
</section>

