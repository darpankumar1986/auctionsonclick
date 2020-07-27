<ul>
	<li class="has-sub <?php if($tabtype=='MyAuction'){echo $act='active';}else{$act='';}?>">
		<a href="#"><span>My Auction</span></a>
		<ul style="display: <?php if($tabtype=='MyAuction'){echo $dis='block';}else{$dis='none';}?> ;">
			<li>
				<a href="/owner/sellBidToBeOpened" <?php if($this->uri->segment(2)=='sellBidToBeOpened' || $this->uri->segment(2)=='sellMyActivity'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/ico-add_eventbid.png"></span>Bids to be opened</a>
			</li>
			<li>
				<a href="/owner/sellliveAuction" <?php if($this->uri->segment(2)=='sellliveAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_live2.png"></span>Live Auction</a> 
			</li>
			<li>
				<a href="/owner/sellliveAuctionList" <?php if($this->uri->segment(2)=='sellliveAuctionList'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_live2.png"></span>Live Auction List</a>
			</li>
			<li>
				<a href="/owner/sellupcomingAuction" <?php if($this->uri->segment(2)=='sellupcomingAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/ico-add_eventbid.png"></span>Upcoming Auction</a>
			</li>
			<li>
				<a href="/owner/sellcompletedAuction" <?php if($this->uri->segment(2)=='sellcompletedAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_auction-complete.png"></span>Completed Auction</a>
			</li>
			<li>
				<a href="/owner/sellCancelAuction" <?php if($this->uri->segment(2)=='sellCancelAuction'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_auction-cancel.png"></span>Cancel Auction</a> 
			</li>
			<!--<li><a href="/owner/postRequirement">Report Generated</a> </li>-->
		</ul>
	</li>
	<li class="has-sub <?php if($tabtype=='MyProperty'){echo $act='active';}else{$act='';}?>"><a href="#"><span>My Properties</span></a>
		<ul style="display: <?php if($tabtype=='MyProperty'){echo $dis='block';}else{$dis='none';}?> ;">
			<li>
				<a href="/owner/sellerPostPropety" <?php if($this->uri->segment(2)=='sellerPostPropety'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/property-posted.png"></span>Post Properties</a> 
			</li>
				<li>
	<a href="/owner/manageSellersavedPropety" <?php if($this->uri->segment(2)=='manageSellersavedPropety'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/property-saved.png"></span>Saved Properties</a> 
			</li>
			<li>
				<a href="/owner/manageSellerPropety" <?php if($this->uri->segment(2)=='manageSellerPropety'){echo 'class="active"';} ?>><span class="circle-wrapper2"><img src="/images/icon_manage-required.png"></span>Manage Properties</a>
			</li>
		</ul>
	</li>
</ul>