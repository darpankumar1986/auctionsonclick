<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/dashboard.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.slimscroll.js"></script>


<style>
@media screen and (max-width: 500px) {
	table, thead, tbody, th, td, tr { 
			display: block; 
		}
		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr { 
			position: absolute;
			top: -9999px;
			left: -9999px;
		}
		td { 
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee; 
			position: relative;
			padding-left: 50%; 
		}	
		td:before { 
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 6px;
			left: 6px;
			width: 45%; 
			padding-right: 10px; 
			white-space: nowrap;
		}

		.display tr:nth-child(odd){background:#fff!important;}
		.display tr:nth-child(even){background:#fff!important;}		
		
		}
</style>





<section class="container_12">
			<?php 
				if($this->session->userdata('arole') != '10')
				{ ?>
			<div class="box-head">Dashboard</div>
			<?php } ?>
				<div style="min-height: 0px; display: block;" class="box-content no-pad">
				<div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
					<div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
 
				<div class="box-content no-pad">
					<?php 
					if($this->session->userdata('arole') == '1')
					{ ?>
						<?php ?>
						<table class="display" id="dt1" >       
						<tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td> 
							<td></td> 
							
							<?php /* ?>
							<td><a href="<?php echo base_url('/admin/user/banker');?>">Branch User List</a></td> 
							<td><a href="<?php echo base_url('/admin/user/assignDeptlist');?>">Assigned Department List</a></td> 
							<td><a href="<?php echo base_url()?>admin/rolepage/addeditrole">Create Roles</a></td>	
							<td><a href="<?php echo base_url('/admin/user/assignRolelist');?>">Assigned Role List</a></td> 
							<?php */ ?>
							
						</tr>    
						
						
						</table>
						<?php ?>		
					<?php } ?>
				</div>
			</div>
		</div>
	</div>	
</section>


