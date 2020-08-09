	<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<div class="container-fluid container_margin">
            <div class="row">
               <div class="container">
                   <div class="row">
                <div class="col-sm-12">
                    <div class="thankyou">
                        <h1>Thank You!</h1>
                        <img src="<?php echo base_url(); ?>assets/auctiononclick/images/big_correct_icon.png">
                        <h3>You are successfully subscribed to AuctionsOnClick.com</h3>
                        <p>We have sent you an email with your receipt.</p>
                    </div><!--thankyou-->
                </div>
                   </div>
            </div>
            </div><!--row-->
        </div><!--container-fluid-->
           <div class="container">
               <div class="row">
                   <div class="col-sm-12">
                       <div class="form_wrap_anction_search form-wrap thankyou_wrap">
                           <p><a href="#">Explore <?php echo (int)$total_auction; ?> Live Bank Auctions</a></p>
                           <form class="form_desc">
                               <div class="dropdown">
                                   <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Category
                                       <span class="caret"></span></button>
                                   <ul class="dropdown-menu">
                                       <?php $parentCat = $this->home_model->getAllCategory(0); ?>
										<?php foreach($parentCat as $key => $parCat){ ?>
										<li class="dropdown-header">
										<input type="radio" id="test<?php echo $key; ?>" class="s_parent_id" s-data-parent-id="<?php echo $parCat->id;?>" name="parentCat" value="<?php echo $parCat->id;?>">
											<label for="test<?php echo $key; ?>">All <?php echo $parCat->name; ?></label></li>
											<?php $Cats = $this->home_model->getAllCategory($parCat->id); ?>
											<?php foreach($Cats as $cat){ ?>
												<li><label class="checkbox-inline"><input type="checkbox" s-data-parent="<?php echo $parCat->id;?>" name="s_sub_id" value="<?php echo $cat->id;?>"><?php echo $cat->name; ?></label></li>
											<?php } ?>
									   
										<?php } ?>   
                                   </ul>
                               </div>
                               <div class="custom-dropdown-select1">
                                   <div class="custom-select1">
				
										<input type="text" id="txt-search1" class="form-control item-suggest btn-default dropdown-toggle" name="x" placeholder="Type City" value="" style="border-left: 0px solid #ccc;">

                                    
                                   </div>
                               </div>
							   <?php $allbank = $this->home_model->getAllBank(); ?>
                               <div class="custom-dropdown-select">
                                   <div class="custom-select">
                                       <select name="bank" id="bank">
                                           <option value="">Select Bank</option>
                                           <option value="">All Cities</option>
										   <?php foreach($allbank as $bank){ ?>
	                                           <option value="<?php echo $bank->id; ?>"><?php echo $bank->name; ?></option>
										   <?php } ?>
                                       </select>
                                   </div>
                               </div>
                               <div class="search_btn_section">
                                   <button class="btn btn-default btn-search" type="button" onclick="goForSearch1(this)">
                                        <i class="fa fa-search"></i> Search
                                   </button>
                               </div>
							   <div class="error" id="error_txt1" style="display: block;height: 20px;padding-right: 30px;color: rgb(251 189 189);    background-color: transparent;    margin-top: 50px;    margin-left: 232px;;"></div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
		   <script>
			$(document).ready(function(){
				$( ".item-suggest" ).autocomplete({
				  minLength: 0,
				  source: function (request, response) {			
						$.ajax({
							dataType: "json",
							type : 'Get',
							url: '<?php echo base_url();?>home/getCity?q='+request.term,
							success: function(data) { 
								
								response(data);
							},
							error: function(data) {
								$('input.suggest-user').removeClass('ui-autocomplete-loading');  
							}
						});
					},
					select: function(event, ui){
						console.log([ui.item.value]);
					}
				});
			});
		   </script>