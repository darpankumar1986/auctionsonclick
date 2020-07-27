<div class="vernav2 iconmenu">
	<ul>			
		<li>
			<a href="#forcategory" class="editor">Category</a>
			<span class="arrow"></span>
			<ul id="forcategory" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='category')&&($this->uri->segment(3)=='main' || $this->uri->segment(3)=='addeditmain'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/category/main">View category</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/category/addeditmain">
						Add category
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#forsubcategory" class="editor">Sub category</a>
			<span class="arrow"></span>
			<ul id="forsubcategory" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='category')&&($this->uri->segment(3)=='index' || $this->uri->segment(3)=='addedit'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/category/index">View sub category</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/category/addedit">
						Add sub category
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#forcountry" class="editor">Country</a>
			<span class="arrow"></span>
			<ul id="forcountry" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='country')&&($this->uri->segment(3)=='index' || $this->uri->segment(3)=='addedit'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/country/index">View Country</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/country/addedit">
						Add Country
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#forstate" class="editor">State</a>
			<span class="arrow"></span>
			<ul id="forstate" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='state')&&($this->uri->segment(3)=='index' || $this->uri->segment(3)=='addedit'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/state/index">View State</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/state/addedit">
						Add State
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#forcity" class="editor">City</a>
			<span class="arrow"></span>
			<ul id="forcity" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='city')&&($this->uri->segment(3)=='index' || $this->uri->segment(3)=='addedit'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/city/index">View City</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/city/addedit">
						Add City
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#fordrt" class="editor">DRT</a>
			<span class="arrow"></span>
			<ul id="fordrt" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='drt'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/drt/index">View DRT</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/drt/addedit">
						Add DRT
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#forbank" class="editor">Bank</a>
			<span class="arrow"></span>
			<ul id="forbank" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='bank'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/bank">View Bank</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/bank/addedit">
						Add Bank
					</a>
				</li>
				
			</ul>
		</li>
		<li>
				<a href="#forLHO" class="editor">LHO</a>
				<span class="arrow"></span>
				<ul  id="forLHO" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='bank_lho'))?'style="display:block;"':''?>>
					<li>
					<a href="<?php echo base_url()?>superadmin/bank_lho">
						View LHO
					</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/bank_lho/lho_addedit">
						Add LHO
					</a>
				</li>
				</ul>
		</li>
		
		<li>
				<a href="#forZone" class="editor">Zone</a>
				<span class="arrow"></span>
				<ul  id="forZone" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='bank_zone'))?'style="display:block;"':''?>>
					<li>
					<a href="<?php echo base_url()?>superadmin/bank_zone">
						View Zone
					</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/bank_zone/zone_addedit">
						Add Zone
					</a>
				</li>
				</ul>
		</li>
		
		<li>
				<a href="#forRegion" class="editor">Region</a>
				<span class="arrow"></span>
				<ul id="forRegion" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='bank_region'))?'style="display:block;"':''?>>
					<li>
					<a href="<?php echo base_url()?>superadmin/bank_region">
						View Region
					</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/bank_region/region_addedit">
						Add Region
					</a>
				</li>
				</ul>
		</li>
		<li>
				<a href="#forBranch" class="editor">Branch</a>
				<span class="arrow"></span>
				<ul id="forBranch" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='bank_branch'))?'style="display:block;"':''?>>
					<li>
					<a href="<?php echo base_url()?>superadmin/bank_branch">
						View Branch
					</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/bank_branch/branch_addedit">
						Add Branch
					</a>
				</li>
				</ul>
		</li>
		
		<li>
				<a href="#fortaxmaster" class="editor">Tax</a>
				<span class="arrow"></span>
				<ul id="fortaxmaster" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='taxmaster'))?'style="display:block;"':''?>>
					<li>
					<a href="<?php echo base_url()?>superadmin/taxmaster">
						Tax
					</a>
				</li>
				</ul>
		</li>
		
		<li>
				<a href="#forc1zone" class="editor">C1zone</a>
				<span class="arrow"></span>
				<ul id="forc1zone" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='c1zone'))?'style="display:block;"':''?>>
					<li>
					<a href="<?php echo base_url()?>superadmin/c1zone">
						View C1zone
					</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/c1zone/addedit">
						Add C1zone
					</a>
				</li>
				</ul>
		</li>
		
		
		<li>
			<a href="#forarticle" class="editor">User</a>
			<span class="arrow"></span>
			<ul id="forarticle" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='user'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/user">View User</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/user/addedit">
						Add User
					</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/user/banker">View Bank User</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/user/bankeraddedit">
						Add Bank User
					</a>
				</li>
				<!--<li>
					<a href="<?php echo base_url()?>superadmin/user/addedit_b2c">
						Add B2c User
					</a>
				</li>-->
			</ul>
		</li>
		<li>
			<a href="#forattribute_group" class="editor">Atrribute Group</a>
			<span class="arrow"></span>
			<ul id="forattribute_group" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='attribute_group' ))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/attribute_group">View Group</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/attribute_group/addedit">
						Add Group
					</a>
				</li>
				
			</ul>
		</li>
		<li>
						<a href="#forattribute" class="editor">Atrribute</a>
						<span class="arrow"></span>
						<ul id="forattribute" <?php echo (($this->uri->segment(1)=='admin')&&( $this->uri->segment(2)=='attribute'))?'style="display:block;"':''?>>
							<li>
							<a href="<?php echo base_url()?>superadmin/attribute">
								View Atrribute
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>superadmin/attribute/addedit">
								Add Atrribute
							</a>
						</li>
						</ul>
				</li>
		<!--<li>
			<a href="#forarticle" class="editor">article</a>
			<span class="arrow"></span>
			<ul id="forarticle" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='article'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/article">View article</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/article/addedit">
						Add article
					</a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="#forbreaking" class="editor">Story of the Day</a>
			<span class="arrow"></span>
			<ul id="forbreaking" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='breaking_news'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/breaking_news">Add Story of the Day</a>
				</li>
				
			</ul>
		</li>
		
		<li>
			<a href="#formauthor" class="editor">Author</a>
			<span class="arrow"></span>
			<ul id="formauthor" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='author'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/author/addedit">ADD Author</a></li>
				<li><a href="<?php echo base_url()?>superadmin/author">List Author</a></li>
			</ul>
		</li>
		
		<li>
			<a href="#formfootermagazine" class="editor">Footer Magazine</a>
			<span class="arrow"></span>
			<ul id="formfootermagazine" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='footer_magazine'))?'style="display:block;"':''?>>
				
				<li><a href="<?php echo base_url()?>superadmin/footer_magazine">List Footer Magazine</a></li>
			</ul>
		</li>
		<li>
			<a href="#formbuyer_seller" class="editor">Buyer Seller</a>
			<span class="arrow"></span>
			<ul id="formbuyer_seller" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='buyer_seller'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/buyer_seller/addedit">ADD Buyer Seller</a></li>
				<li><a href="<?php echo base_url()?>superadmin/buyer_seller">List Buyer Seller</a></li>
			</ul>
		</li>-->
		<!--<li>
			<a href="#websiteuser" class="editor">Website User</a>
			<span class="arrow"></span>
			<ul id="websiteuser" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='website_user'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/website_user/addedit">ADD Website User</a></li>
				<li><a href="<?php echo base_url()?>superadmin/website_user">List Website User</a></li>
			</ul>
		</li>-->
		
		<?php 
		
		if($this->session->userdata('arole') == '1'){?>
		<!--
		<li>
			<a href="#formproperty" class="editor">Property</a>
			<span class="arrow"></span>
			<ul id="formproperty" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='dynamic_form'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/dynamic_form">View Property</a></li>
				<li><a href="<?php echo base_url()?>superadmin/dynamic_form/addedit">ADD Property</a></li>				
			</ul>
		</li>-->
		<li>
			<a href="#formrole" class="editor">Role</a>
			<span class="arrow"></span>
			<ul id="formrole" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='role'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/role">View Role</a></li>
				<li><a href="<?php echo base_url()?>superadmin/role/addedit">ADD Role</a></li>
				
			</ul>
		</li>
		<li>
			<a href="#formadmin" class="editor">Admin</a>
			<span class="arrow"></span>
			<ul id="formadmin" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='admin'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/admin">View Admin</a></li>
				<li><a href="<?php echo base_url()?>superadmin/superadmin/addedit">ADD Admin</a></li>
				
			</ul>
		</li>
		<?php } ?>
		<!--
		<li>
			<a href="#publication" class="editor">Publication</a>
			<span class="arrow"></span>
			<ul id="publication" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='publication'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/publication/addedit">ADD Publication</a></li>
				<li><a href="<?php echo base_url()?>superadmin/publication">List Publication</a></li>
			</ul>
		</li>
		
		<li>
			<a href="#home_page_view" class="editor">Home Page View</a>
			<span class="arrow"></span>
			<ul id="home_page_view" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='home_page_view'))?'style="display:block;"':''?>>
				
				<li><a href="<?php echo base_url()?>superadmin/home_page_view">Manage Home Page View</a></li>
			</ul>
		</li>
		
		
		
		<li><a href="#formpoll" class="editor">Poll</a>
			<span class="arrow"></span>
			<ul id="formpoll" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='poll'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/poll/addedit">ADD Poll</a></li>
				<li><a href="<?php echo base_url()?>superadmin/poll">List Poll</a></li>
			</ul>
		</li>-->
		<li>
			<a href="#forstatic" class="editor">Static pages</a>
			<span class="arrow"></span>
			<ul id="forstatic" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='webpage'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/webpage">View Static pages</a></li>
				<li><a href="<?php echo base_url()?>superadmin/webpage/addedit">ADD Static pages</a></li>
				
			</ul>
		</li>
          
		<li>
			<a href="#fornewsBlog" class="editor">News Blog</a>
			<span class="arrow"></span>
			<ul id="fornewsBlog" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='news'))?'style="display:block;"':''?>>
				<li><a href="<?php echo base_url()?>superadmin/news">View News</a></li>
				<li><a href="<?php echo base_url()?>superadmin/news/addedit">ADD News </a></li>
				<li><a href="<?php echo base_url()?>superadmin/news/blog">View Blog</a></li>
				<li><a href="<?php echo base_url()?>superadmin/news/blogaddedit">ADD  Blog</a></li>
				
			</ul>
		</li>      
		<li>
			<a href="#formessage" class="editor">Message</a>
			<span class="arrow"></span>
			<ul id="formessage" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='message')&&($this->uri->segment(3)=='main' || $this->uri->segment(3)=='addeditmain'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/message/main">View message</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>superadmin/message/addeditmain">
						Add message
					</a>
				</li>
			</ul>
		</li>
                <li>
			<a href="#forslider" class="editor">Home Page Slider</a>
			<span class="arrow"></span>
			<ul id="forslider" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='home_page_slider'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/home_page_slider">Home Page Slider</a>
				</li>
                                <li>
					<a href="<?php echo base_url()?>superadmin/home_page_slider/addedit">
						Add Slider Info
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#non_banker" class="editor">Non-banker Auction Property</a>
			<span class="arrow"></span>
			<ul id="non_banker" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='non_banker'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/non_banker/non_bank_auction_property">Non Bank Auction Property</a>
				</li>
            	<li>
					<a href="<?php echo base_url()?>superadmin/non_banker/non_bank_property">Non Bank Property</a>
				</li>
				<li><a href="<?php echo base_url()?>superadmin/dynamic_form/addedit">ADD Property</a></li>
			</ul>
		</li>
		
		<li>
			<a href="#auction_fees" class="editor">Manage Auction Fees</a>
			<span class="arrow"></span>
			<ul id="auction_fees" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='auction_fees'))?'style="display:block;"':''?>>
				<li>
				<a href="<?php echo base_url()?>superadmin/auction_fees/addedit">Add New</a>
				</li>
            	<li>
					<a href="<?php echo base_url()?>superadmin/auction_fees/">View All</a>
				</li>
			</ul>
		</li>
	
	
		<li>
			<a href="#transaction" class="editor">Manage Transaction</a>
			<span class="arrow"></span>
			<ul id="transaction" <?php echo (($this->uri->segment(1)=='admin')&&($this->uri->segment(2)=='transaction'))?'style="display:block;"':''?>>
				<li>
					<a href="<?php echo base_url()?>superadmin/transaction">View All</a>
				</li>
			</ul>
		</li>
		
		
		
		
		
		
		
	</ul>
	<a class="togglemenu"></a>
	<br /><br />
</div><!--leftmenu-->
        
