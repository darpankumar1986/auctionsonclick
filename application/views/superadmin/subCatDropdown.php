<?php if($view=='list_page'){?>
&nbsp;
	<select name="sub_category_id" id="sub_category_id" style="width:70%;">
		<option value="">Select Sub Category</option>
		<?php
			foreach($category as $cat){
			($cat->id==$subcat_id)?$selected='selected':$selected='';
				?>
				<option value="<?php echo $cat->id; ?>" <?php echo $selected ?>><?php echo $cat->name; ?></option>
				<?php
			}
		?>
	</select>

<?php }else{?>
<label>Sub Category<font color='red'>*</font></label>
<span class="field">
	<select name="sub_category_id" id="sub_category_id">
		<option value="">Select Sub Category</option>
		<?php
			foreach($category as $cat){
				?>
				<option value="<?php echo $cat->id; ?>" <?php echo $selected ?>><?php echo $cat->name; ?></option>
				<?php
			}
		?>
	</select>
</span>
<?php }?>