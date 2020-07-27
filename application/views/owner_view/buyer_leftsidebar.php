<div class="secttion-left">
	<div class="left-widget">
		<div id="cssmenu">
			<ul>
				<li class="has-sub <?php if($tabtype=='MyAuction'){echo $act='active';}else{$act='';}?>"><a href="#"><span>My Auction</span></a>
					<ul style="display: <?php if($tabtype=='MyAuction'){echo $dis='block';}else{$dis='none';}?> ;">
					  
						<li>
							<a href="/owner/liveAuction" <?php if($this->uri->segment(2)=='liveAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_live2.png"></span>Live Auction</a> 
						</li>
					  
						<li><a href="/owner/buylistLiveAuctions" <?php if($this->uri->segment(2)=='buylistLiveAuctions'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_live2.png"></span>Live Auction List</a> </li>
					  
						<li><a href="/owner/upcomingAuction" <?php if($this->uri->segment(2)=='upcomingAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/ico-add_eventbid.png"></span>Upcoming Auction</a> </li>
					  
						<li><a href="/owner/completedAuction" <?php if($this->uri->segment(2)=='completedAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_auction-complete.png"></span>Completed Auction</a> </li>
					  
						<li><a href="/owner/cancelAuction" <?php if($this->uri->segment(2)=='cancelAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_auction-cancel.png"></span>Cancel Auction</a> </li>
						
						<!--<li><a href="/owner/postRequirement">Report Generated</a> </li>-->
					
					</ul>
				</li>
			  
				<li class="has-sub <?php if($tabtype=='MyRequirement'){echo $act='active';}else{$act='';}?>"><a href="#"><span>My Requirement</span></a>
					<ul style="display: <?php if($tabtype=='MyRequirement'){echo $dis='block';}else{$dis='none';}?> ;">
						<li><a href="/owner/postRequirement" <?php if($this->uri->segment(2)=='postRequirement'){echo 'class="active"';} ?> ><span class="circle-wrapper2"><img src="/images/requirement-posted.png"></span>Post Requirement</a> </li>
						<li><a href="/owner/manageRequirement" <?php if($this->uri->segment(2)=='manageRequirement'){echo 'class="active"';} ?> ><span class="circle-wrapper2"><img src="/images/icon_manage-required.png"></span>Manage Requirement</a> </li>
						<li><a href="/owner/matchingRequirement" <?php if($this->uri->segment(2)=='matchingRequirement'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/ico-search.png"></span>Matching Requirement</a> </li>
					</ul>
				</li>
			
				<li class="<?php if($tabtype=='bankyoufollow'){echo $act='active';}else{$act='';}?>"><a href="/owner/followBank" class="no-drop"><span>Bank you follow</span></a></li>
				
				<li class="<?php if($tabtype=='allFavourites'){echo $act='active';}else{$act='';}?>"><a href="/owner/allFavorites" class="no-drop"><span>All Favourites</span></a></li>
				
				<li class="<?php if($tabtype=='ViewLastSearch'){echo $act='active';}else{$act='';}?>"><a href="/owner/lastSearch" class="no-drop"><span>View Last Search</span></a></li>
			
			</ul>
		</div>
	</div>
</div>