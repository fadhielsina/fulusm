<br/><br/>
<div class="col-lg-12">	<h3 class="badge badge-info"><?php echo $title; ?></h3></div><br/><br/><br/>
<div class="post-body">
	<div class="panel panel-info">
  <div class="panel-heading">FORM TAMBAH DATA</div>
  <div class="panel-body">

<?php
	echo form_open('vehicles/'.$form_act, 'id="vehicles_form"');

	echo "<div id='error' class='error-message' ";

	if($this->session->userdata('ERRMSG_ARR'))
	{
		echo ">";
		echo $this->session->userdata('ERRMSG_ARR');
		$this->session->unset_userdata('ERRMSG_ARR');
	}
	else
	{
		echo "style='display:none'>";
	}
	
	echo "</div>";

	$data['class'] = 'input';
	if ($act == 'view') $data['disabled'] = TRUE;
?>
	
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">	
		
		<tr>
			<th><?php echo form_label('Merk *','merk'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'merk';
					$data['value'] = (set_value('merk')) ? set_value('merk') : $vehicles_data['merk'];
					$data['placeholder'] = "Contoh : Toyota";
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Type','identitasno'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'type';
					$data['value'] = (set_value('type')) ? set_value('type') : $vehicles_data['type'];
					$data['placeholder'] = "Contoh : Avanza";						
					echo form_input($data);
				?>
			</td>
		</tr>			
		
		<tr>
			<th><?php echo form_label('Series','email'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'series';
					$data['value'] = (set_value('series')) ? set_value('series') : $vehicles_data['series'];
					$data['placeholder'] = "Contoh : Veloz";			
					echo form_input($data);
				?>
			</td>
		</tr>																																													
	</table>
	
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan','Simpan', "id = 'button-save'" );
				echo form_reset('reset','Reset', "id = 'button-reset'" );
				echo form_button(array('id' => 'button-cancel', 'content' => 'Batal', 'onClick' => "location.href='".site_url()."klien'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."klien'" ));
			}
		?>				
	</div>

<?php echo form_close(); ?>

</div>	
</div>	
</div>	

<script type='text/javascript'>
	//Validasi di client
	$(document).ready(function()
	{
		$('#klien_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				merk: "required"
			}
		});
	});
</script>
