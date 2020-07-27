<?php 
				$mandatory='';
				foreach($records as $group_records)		
				{
					
					if($group_records[0]->is_display)
					echo "<h4>".$group_records[0]->group_name."</h4>";
					foreach($group_records as $data)		
					{		
						if($data->is_mandatory)
						{					
							if($data->validation_message)
							{
								$msg=$data->validation_message;
							}else{
								$msg="Please Enter".$data->name;
							}
							$lable='<label id="msg_'.$data->id.'" class="error" style="display:none;">'.$msg.'</label>';		
						}else{
							$lable='';
						}
					
						if($data->type=='text')
						{
						?>
						<p>
							<label><?php echo $data->name?><?php if($data->is_mandatory){echo "<font color='red'>*</font>";$mandatory.="form_field_$data->id: 'required',";}?></label>
							<span class="field">
								<input type="text"  class="longinput <?php  if($data->is_mandatory){ echo "required_fields";}else{echo "";}?>" name='form_field_<?php echo $data->id?>' id='<?php echo $data->id?>' value="<?php echo $attr_records[$data->id]->values?>" />
								<?php echo $lable ?>
							</span>					
						</p>
						<?php 
						}						
						if($data->type=='textarea')
						{
						?>
						<p>
							<label><?php echo $data->name?><?php if($data->is_mandatory){echo "<font color='red'>*</font>";$mandatory.="form_field_$data->id : 'required',";}?></label>
							<span class="field">
								<textarea class="<?php if($data->is_mandatory){ echo "required_fields";}else{echo "";}?>" name='form_field_<?php echo $data->id?>' id='<?php echo $data->id?>' rows="5" cols="60" ><?php echo $attr_records[$data->id]->values ?></textarea>
							<?php echo $lable ?>	
							</span>					
						</p>
						<?php
						}
						if($data->type=='selectbox')
						{
						$element=explode(',',$data->element);						
						?>
						<p>
							<label><?php echo $data->name?><?php if($data->is_mandatory){echo "<font color='red'>*</font>";$mandatory.="form_field_$data->id: 'required',";}?></label>
							<span class="field">
								<select class=" <?php if($data->is_mandatory){ echo "required_fields";}else{echo "";}?>" name='form_field_<?php echo $data->id?>' id='<?php echo $data->id?>'>
							<option value="">Select</option>
							<?php
							foreach($element as $element_record)
							{
										$selected=($attr_records[$data->id]->values==$element_record)?'selected':'';
								echo "<option $selected>$element_record</option>";
							}
							?>
							</select>
							<?php echo $lable ?>
							</span>					
						</p>
						<?php
						
						}
						if($data->type=='checkbox')
						{
						$element=explode(',',$data->element);						
						?>
						 <p>
                        	<label><?php echo $data->name?><?php if($data->is_mandatory){echo "<font color='red'>*</font>";$mandatory.="'form_field_$data->id[]' : 'required',";}?></label>
                            <span class="formwrapper">
                            	<?php 
								$i=1;
								$r=0;
								foreach($element as $element_record)
								{
									
									if($data->is_mandatory)
									{ 
										$class= "required_fields";
									}else{
									   $class= "";
									}
									
									
								$checked=(in_array($element_record,explode(',',$attr_records[$data->id]->values)))?'checked':'';
								if($checked!='')
								{
									$r++;
								}
								
									echo " <span class='col-group1'><input onclick='checkboxval($i,$data->id)' class='checkboxval_$data->id' name='form_field_$data->id[]'  id='".$i."_".$data->id."'  type='checkbox' value='$element_record' $checked>$element_record </span>";
								}
								?>
									<?php
							if($r<=0)
								{
									$rval='';
								}else{
									$rval='yes';
								}
							if($data->is_mandatory==1){
							?>
								<input type="hidden" value="<?php echo $rval; ?>" class="required_fields" name="checkbox_required_<?php echo $data->id;?>" id="<?php echo $data->id;?>">
							<?php } ?>
								<?php echo $lable ?>
								
                            </span>
                        </p>
						<?php						
						}
						if($data->type=='radio')
						{	$i=1;
						$element=explode(',',$data->element);						
						?>
						<p>
                        	<label><?php echo $data->name?><?php if($data->is_mandatory){echo "<font color='red'>*</font>";$mandatory.="'form_field_$data->id' : 'required',";}?></label>
                            <span class="formwrapper">
                            	<?php $r=0;
								foreach($element as $element_record)
								{
								if($data->is_mandatory)
									{ 
										$class= "required_fields";
									}else{
									   $class= "";
									}	
								$checked=($attr_records[$data->id]->values==$element_record)?'checked':'';
					
								if($checked!='')
								{
									$r++;
								}	
								echo "<span class='col-group1'>
										<input class='checkboxval_$data->id' onclick='checkboxval($data->id)' name='form_field_$data->id' id='".$i."_".$data->id."' type='radio' value='$element_record' $checked>$element_record</span>
										
								";
								}
								?>
									<?php
								if($r<=0)
								{
									$rval='';
								}else{
									$rval='yes';
								}
								
							if($data->is_mandatory==1){
							?>
								<input type="hidden" value="<?php echo $rval;?>" class="required_fields" name="radio_required<?php echo $data->id;?>" id="<?php echo $data->id;?>">
							<?php } ?>
								<?php echo $lable ?>
                            </span>
                        </p>
						<?php
						}
					}
					
				}
				?>