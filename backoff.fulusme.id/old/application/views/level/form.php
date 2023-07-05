<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<?php
	echo form_open($form_act, array('id' => 'level_form', 'class' => 'form-material m-t-40'));
	$data['class'] = 'input';
	if ($act == 'view') $data['disabled'] = TRUE;
?>

	<table class="table">
		
		<?php
			//foreach($field as $index=>$item){	
				echo '<tr>
						<th>'.form_label($this->lang->line('nama_level'),'nama_level').'</th>
						<td>';
						$data['name'] = 'nama_level';
						$data['value'] = (set_value('nama_level')) ? set_value('nama_level') : $asset_data['nama_level'];
						$data['class'] ='form-control';
						$data['title'] = $this->lang->line('nama_level').' '.$this->lang->line('valid_tidak_boleh_kosong');
						echo form_input($data);
						echo '</td>
					</tr>';

			//}
			
			if(isset($sub_content)){
				echo "<tr><th>Menu :</th><td>";
				//$this->load->view($sub_content);
				echo "</td></tr>";
			}	
		?>
		<tr>
			<td><?php echo  $this->lang->line('hak_akses') ?></td>
			<td>
				<input type="button" class="btn btn-primary" id="selectAll" type="checkbox" value="Select All">
				<ul>
				<?php
				$menuAkses = json_decode($asset_data['akses']);
				$active = $this->athoslib->activeLang();

				 if(is_array($dataParentMenu)) {
                        foreach($dataParentMenu as $item){
                           $childMenu = $this->menu_model->get_child_menu($item['id_menu']);    

                          	if ($active['label'] == 'Indonesia') {
                            	$menu_label = $item['menu_label'];
                          	} else {
                            	$menu_label = $item['english_label'];
                          	}

                          	$checked = "";
							if(is_array($menuAkses)){
								if(in_array($item['id_menu'],$menuAkses)){
									$checked = "CHECKED";
								}
							}
							if($item['parent_menu']==""){
								$style="h5";
							}else{
								$style="";
							}
							echo "<li> <input type='checkbox' ".$checked." value='".$item['id_menu']."'  name='UserMenu[]'><span class='".$style."'> ".$menu_label." </span>";
							foreach($childMenu as $item2){
								$checked2 = "";
								if(is_array($menuAkses)){
									if(in_array($item2['id_menu'],$menuAkses)){
										$checked2 = "CHECKED";
									}
									
								}
								if ($active['label'] == 'Indonesia') {
	                            	$menu_label = $item2['menu_label'];
	                          	} else {
	                            	$menu_label = $item2['english_label'];
	                          	}
								echo "<li style='padding-left:20px'> <input type='checkbox' ".$checked2." value='".$item2['id_menu']."'  name='UserMenu[]'><span > ".$menu_label." </span>";
							
							$childMenu2 = $this->menu_model->get_child_menu($item2['id_menu']); 
							if(count($childMenu2) >0){
								echo '<ul>';
								foreach($childMenu2 as $item3){

									$checked3 = "";
									if(is_array($menuAkses)){
										if(in_array($item3['id_menu'],$menuAkses)){
											$checked3 = "CHECKED";
										}
										
									}
									if ($active['label'] == 'Indonesia') {
		                            	$menu_label = $item3['menu_label'];
		                          	} else {
		                            	$menu_label = $item3['english_label'];
		                          	}
									echo "<li style='padding-left:20px'> <input type='checkbox' ".$checked3." value='".$item3['id_menu']."'  name='UserMenu[]'><span > ".$menu_label." </span></li>";
								}
								echo '</ul>';
							}
							}
							echo "</li>";
                      }
                  }

				/*foreach ($menu_data as $key => $value) {

					$checked = "";
					if(is_array($menuAkses)){
						if(in_array($value->id_menu,$menuAkses)){
							$checked = "CHECKED";
						}
					}
					if($value->parent_menu==""){
						$style="h6";
					}else{
						$style="";
					}
					echo "<li> <input type='checkbox' ".$checked." value='".$value->id_menu."'  name='UserMenu[]'><span class='".$style."'> ".$value->menu_label." </span></li>";
				}*/
				?>
				</ul>
			</td>
		</tr>
	</table>
  <hr/>
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan', $this->lang->line('simpan'), "id = 'button-save' class='btn btn-secondary'" );
				echo form_reset('reset','Reset', "id = 'button-reset' class='btn btn-secondary'" );
				if($this->session->userdata('ADMIN'))
					echo form_button(array('id' => 'button-cancel','class' => 'btn btn-secondary', 'content' => $this->lang->line('batal'), 'onClick' => "location.href='".site_url()."level'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-secondary', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."level'" ));
			}
		?>
	</div>

<?php echo form_close(); ?>
</div></div>
</div>
<script type='text/javascript'>
	//Validasi di client
	$(document).ready(function()
	{
		$("#selectAll").click(function(){
			if($(this).val()=="Select All"){
		    	$("input[type=checkbox]").prop('checked',true);
		    	$(this).val("Unselect All");
			}else{
				$("input[type=checkbox]").prop('checked', false);
				$(this).val("Select All");
			}
		    
		});
		$('#user_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				fname: "required lettersonly",
				lname: "required lettersonly",
				username: "required alphanumeric",
				<?php if($act=='add') echo 'password: "required",'; ?>
				cpassword: {
					equalTo: "#password"
				}
			}
		});
	});
</script>