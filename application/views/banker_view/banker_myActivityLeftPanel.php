<div class="secttion-left">
	<div class="left-widget">
                  <div class="auction-category-heading">My Auction
                    <div class="arrow-down"></div>
                  </div>
                  <div class="continer">
                    <ul>
                      <li> <a href="/buyer/myActivity" <?php echo (($this->uri->segment(2)=='index')or($this->uri->segment(2)==''))?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img1.png"></span> Dashboard</a></li>
					  <li> <a href="/buyer/createEvent?action=create" <?php echo ($this->uri->segment(2)=='createEvent')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img2.png"></span> Create Auction</a></li>
                      <li> <a href="/buyer/savedEvents" <?php echo ($this->uri->segment(2)=='savedEvents')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img2.png"></span> Saved Auctions</a></li>
                      <!--<li> <a href="/banker/liveEvent"> <span class="circle-wrapper2"><img src="/images/myactivity-img3.png"></span> Live Event</a></li>-->
                      <li> <a href="/buyer/liveAuctions" <?php echo ($this->uri->segment(2)=='liveAuctions')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img4.png"></span> Live Auctions</a></li>
                      <li> <a href="/buyer/listLiveAuctions" <?php echo ($this->uri->segment(2)=='listLiveAuctions')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img5.png"></span> List Live Auctions</a></li>
                      <li> <a href="/buyer/bidsToBeOpened" <?php echo ($this->uri->segment(2)=='bidsToBeOpened')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img6.png"></span> Bids to be Opened</a></li>
                      <li> <a href="/buyer/completedEvents" <?php echo ($this->uri->segment(2)=='completedEvents')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img7.png"></span> Completed Auctions</a></li>
                      <li> <a href="/buyer/corrigendum" <?php echo ($this->uri->segment(2)=='corrigendum')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img8.png"></span> Corrigendum</a></li>
                      <li> <a href="/buyer/MISReport" <?php echo ($this->uri->segment(2)=='MISReport')?'class="active"':''?>> <span class="circle-wrapper2"><img src="/images/myactivity-img9.png"></span>MIS Report</a></li>
                    </ul>
                  </div>
                </div>
			</div>
