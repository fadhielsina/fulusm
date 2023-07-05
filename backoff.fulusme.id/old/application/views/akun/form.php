<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open('akun/'.$form_act, array('id' => 'jurnal_form','id' => 'akun_form', 'class' => 'form-material m-t-40'));

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
	
		<table class="table color-table info-table">		
		
		<tr>
			<th><?php echo form_label("Parent ".$this->lang->line('akun'),'akun'); ?></th>
			<td>
				<select name="parent_akun" id="parent_akun" class="form-control">
					<option value="" selected="selected"><?php echo $this->lang->line('pilih_satu') ?></option>
				<?php 
					$data['id'] = 'parent_akun';
					
					$data['class'] ='form-control';
					$data['aria-required']='false';
					$data['required'] = 'false';
					$data['title'] = "Parent ".$this->lang->line('akun');

					$dataAkunCmb = array(""=>$this->lang->line('pilih_satu'));
					if(is_array($dataAkun)){
						foreach($dataAkun as $itemAkun){
							//$dataAkunCmb[$itemAkun['id']] = $itemAkun['nama']." - ".$itemAkun['kode'];
							echo '<option value="'.$itemAkun['id'].'">'.$itemAkun['nama']." - ".$itemAkun['kode'].'</option>';
						}
					}
					//echo form_dropdown("parent_akun",$dataAkunCmb,"",$data);
				?>
				</select>
			</td>
		</tr>					  
		<tr>
			<th><?php echo form_label($this->lang->line('nama_akun').'*','nama'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama';
					// added by Adhe on 19.05.2010
					$data['maxlength'] = '120';
					$data['class'] ='form-control';
					$data['value'] = (set_value('nama')) ? set_value('nama') : $account_data['nama'];
					$data['title'] = $this->lang->line('valid_nama_akun');
				
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('kode_akun').'*','kode'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'kode';
					$data['maxlength'] = '100';
					// end
					$data['value'] = (set_value('kode')) ? set_value('kode') : $account_data['kode'];
					$data['title'] = $this->lang->line('valid_kode');					
					echo form_input($data);
				?>													
			</td>
		</tr>				
		<tr>
			<th><?php echo form_label($this->lang->line('kelompok'),'kelompok'); ?></th>
			<td>
				<?php 
					$kelompok['id'] = 'kelompok';		
					$kelompok['class'] ='form-control';
					$selected = (set_value('kelompok')) ? set_value('kelompok') : $account_data['kelompok_akun_id'];
					if ($act == 'view') $kelompok['disabled'] = TRUE;
					echo form_dropdown('kelompok', $account_groups, $selected ,$kelompok);
				?>					
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('kena_pajak'),'pajak'); ?></th>
			<td>
				<?php 
					$pajak['name'] = $pajak['id'] = 'pajak';
					$pajak['value'] = '1';					
					if ($account_data['pajak'] == 1 || set_value('pajak') == 1) $pajak['checked'] = TRUE;
					if ($act == 'view') $pajak['disabled'] = TRUE;
					echo form_checkbox($pajak,"","opacity:1 !important;left:0px !important;position:relative !important;
");
				?>									
			</td>
		</tr>		
		<tr>
			<th><?php echo form_label($this->lang->line('keterangan'),'keterangan'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'keterangan';
					$data['rows'] = "2";
					$data['value'] = (set_value('keterangan')) ? set_value('keterangan') : $account_data['keterangan'];
					unset($data['title']);
					unset($data['maxlength']);
					echo form_textarea($data);
				?>													
			</td>
		</tr>															
	</table>
	
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan',$this->lang->line('simpan'), "id = 'button-save'" );
				echo form_reset('reset','Reset', "id = 'button-reset'" );
				echo form_button(array('id' => 'button-cancel', 'content' => $this->lang->line('batal'), 'onClick' => "location.href='".site_url()."akun'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."akun'" ));
			}
		?>
	</div>

<?php echo form_close(); ?>

</div>
</div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script language="javascript">
/*reload_select_akun();
var jQuery3 = $.noConflict(true);
function reload_select_akun(){
	
	jQuery3(document).ready(function() {
    jQuery3('select.form-control').select2();
});
}*/
</script>
<script type='text/javascript'>
	//Validasi di client
	var $company = $("#id_company");
	var $division = $("#id_division");
	var $departement = $("#id_departement");
	var $parent_akun = $("#parent_akun");

	function LoadDivision(){
	$.getJSON("<?php echo base_url('setting/loadDivision') ?>/"+$company.val(),function(result){
			//clear terlebih dahulu
			$division.val(null).trigger('change');
			$departement.val(null).trigger('change');

			$.each(result,function(index,data){
				var newOption = new Option(data.text, data.id, false, false);
				$division.append(newOption).trigger('change');
			});

			/*$("#id_division").select2({
			  data: result
			}).trigger('change');*/
			
			//validateCoa($company.val(),0);//ambil 0 string dari kode akun yang d textbox
			//loadDepartemen();
		});
	} 
	function loadDepartemen(){
		$.getJSON("<?php echo base_url('setting/loadDepartement') ?>/"+$company.val()+"/"+$division.val(),function(result){
				//clear terlebih dahulu
				$departement.val(null).trigger('change');
				

				$.each(result,function(index,data){
					var newOption = new Option(data.text, data.id, false, false);
					$departement.append(newOption).trigger('change');
				});

				validateCoa($division.val(),2);//ambil 2 string dari kode akun yang d textbox
		});
	}
	$(document).ready(function()
	{
		$division.select2();
		$departement.select2();
		$parent_akun.select2();
		LoadDivision();

		/*$company.on('select2:select', function (e) { 
			LoadDivision();
		});*/
		$division.on('select2:select', function (e) { 
			loadDepartemen();
		});
		
		$departement.on('select2:select', function (e) { 
			validateCoa($departement.val(),4);//ambil 4 string dari kode akun yang d textbox
		});

		

		/*jQuery3('#akun_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				nama: "required",
				kode: "required digits"
			}
		});*/
	});

	function validateCoa(val,len){
		var valNew;
		if(val>10){
			valNew = val;
		}else{
			valNew ="0"+val;
		}

		var KodeAkun = $("#kode").val();
		var res = KodeAkun.substring(0,len);

		$("#kode").val(res+""+valNew);
	}
</script>
