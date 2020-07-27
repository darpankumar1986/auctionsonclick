<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

	<span id="captcha-img">
	  <?php echo $image; ?>
	  </span>
	  <a title="reload" class="reload-captcha" href="#">reload</a> 
	</div>
	<div class="row">
		<?php //echo form_input('captcha', '', 'class="field text captcha"')?>
		<input id="captcha" name="captcha" type="text" class="input"/>
	</div>
 <script>
     
         $(function(){
    var base_url = '<?php echo base_url(); ?>';
    $('.reload-captcha').click(function(event){
        event.preventDefault();
        $.ajax({
           url:base_url+'registration/refresh_captcha',
           success:function(data){
              $('#captcha-img').html(data);
           }
        });            
    });
});
      
 </script>