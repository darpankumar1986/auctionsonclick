<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-ui-1.12.1.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<?php if($this->session->flashdata('msg_reg') != ''){ ?>
    <script>
    swal('', 'You have successfully registered & logged in!', 'success');
    </script>
<?php } ?>
<div class="container-fluid">
    <div class="row">
        <div class="banner-section">
            <div class="banner-img">
                <div class="banner-text">
                        <div class="home_form_wrap form_wrap_anction_search form-wrap">
                            <h3>Find your desired property here</h3>
                            <p>Properties at lower prices than the market rates</p>
                            <form class="form_desc">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="category_text_button">Category
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu assetsType">
                                        <?php $parentCat = $this->home_model->getAllCategory(0); ?>
                                            <?php foreach($parentCat as $key => $parCat){ ?>
                                            <li class="dropdown-header">
                                            <input type="radio" id="test<?php echo $key; ?>" class="s_parent_id" s-data-parent-id="<?php echo $parCat->id;?>" name="parentCat" value="<?php echo $parCat->id;?>">
                                                <label for="test<?php echo $key; ?>"><?php //echo ($parCat->name != 'Others')?'All ':'';?><?php echo $parCat->name; ?></label></li>
                                                <?php $Cats = $this->home_model->getAllCategory($parCat->id); ?>
                                                <?php foreach($Cats as $cat){ ?>
                                                    <li><label class="checkbox-inline"><input type="checkbox" s-data-parent="<?php echo $parCat->id;?>" name="s_sub_id" value="<?php echo $cat->id;?>" data-text="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></label></li>
                                                <?php } ?>
                                            <?php } ?>
                                        <li class="clear_filter"><label>Clear</label></li>
                                    </ul>
                                    <input type="hidden" name="assetsTypeId" id="assetsTypeId" value="0"/>
                                </div>
                                <div class="custom-dropdown-select1">
                                   <div class="custom-select1">
                                        <input type="text" id="txt-search" class="form-control item-suggest btn-default dropdown-toggle select-selected" name="x" placeholder="Type City" value="" style="border-left: 1px solid #ccc;">
                                   </div>
                               </div>
                               <?php $allbank = $this->home_model->getAllBank(); ?>
                               <div class="custom-dropdown-select">
                                   <div class="custom-select">
                                       <select name="bank" id="bank">
                                           <option value="">Select Bank</option>
                                           <option value="">Select Bank</option>
                                           <?php foreach($allbank as $bank){ ?>
                                               <option value="<?php echo $bank->id; ?>"><?php echo $bank->name; ?></option>
                                           <?php } ?>
                                       </select>
                                   </div>
                               </div>
                               <div class="search_btn_section">
                                   <button class="btn btn-default btn-search searhcbtn" type="button" onclick="goForSearch(this)">
                                        <i class="fa fa-search"></i> Search
                                   </button>
                               </div>
                            </form>
                            <div class="error" id="error_txt" style="margin-top:0;background-color: #00000073;display: block;height: 20px;padding-right: 30px;color: #e41b1b;margin-left:0;"></div>
                        </div>
                </div><!--banner-text-->
            </div><!--banner-img-->
        </div><!--banner-section-->
    </div><!--row-->
    <div class="row benefits_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="auction_heading">Benefits of buying auctioned properties</h3>
                </div>
            </div><!--row-->
            <div class="row">
                <div class="col-sm-2">
                    <div class="benefit_box">
                        <div class="benefit_img">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/price_icon.png">
                        </div><!--benefit_img-->
                        <div class="box_desc">
                            <h4>Cost Benefit</h4>
                            <p>Bank auction properties are potentially 20-30% cheaper than the prevailing market price</p>
                        </div><!--box_desc-->
                    </div><!--benefit_box-->
                </div>
                <div class="col-sm-2">
                    <div class="benefit_box">
                        <div class="benefit_img">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/legally_icon.png">
                        </div><!--benefit_img-->
                        <div class="box_desc">
                            <h4>Legitimate Assurance</h4>
                            <p>The Bank Auctions are conducted within the SARFAESI Act and DRT Act's guidelines. The bank/financial institutions loan approvals are subject to verification of all legal aspects. </p>
                        </div><!--box_desc-->
                    </div><!--benefit_box-->
                </div>
                <div class="col-sm-2">
                    <div class="benefit_box">
                        <div class="benefit_img">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/credibility_icon.png">
                        </div><!--benefit_img-->
                        <div class="box_desc">
                            <h4>Credible Sellers</h4>
                            <p>The bank/financial institutions are authorized by Govt. of India, hence it is safe to purchase such properties.</p>
                        </div><!--box_desc-->
                    </div><!--benefit_box-->
                </div>
                <div class="col-sm-2">
                    <div class="benefit_box">
                        <div class="benefit_img">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/icon-hassle-free-process.png">
                        </div><!--benefit_img-->
                        <div class="box_desc">
                            <h4>Hassle-Free Process</h4>
                            <p>The buyer will have lesser burden of going through the legal liabilities of the property.</p>
                        </div><!--box_desc-->
                    </div><!--benefit_box-->
                </div>
                <div class="col-sm-2">
                    <div class="benefit_box">
                        <div class="benefit_img">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/transparency_icon.png">
                        </div><!--benefit_img-->
                        <div class="box_desc">
                            <h4>Transparency</h4>
                            <p>100 % transparent transaction and absolutely secure.</p>
                        </div><!--box_desc-->
                    </div><!--benefit_box-->
                </div>
            </div><!--row-->
        </div><!--container-->
    </div><!--row-->
</div><!--container-fluid-->
