<style type="text/css">
	.hide-penyesuaian .t-penyesuaian {
		visibility: hidden;
	}
</style>
<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<?php
	echo form_open('jurnal_template/'.$form_act, array('id' => 'jurnal_form','id' => 'user_form', 'class' => 'form-material m-t-40'));

	$data['class'] = 'input';
	if ($act == 'view') $data['disabled'] = TRUE;
?>

	<table class="table no-border">
		<tr>
			<th><?php echo form_label('Nama Template','nama'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama';
					$data['value'] = (set_value('nama')) ? set_value('nama') : $user_data['nama_template'];
					$data['class'] ='form-control';
					$data['title'] = $this->lang->line('valid_nama');
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label('Type Template','nama'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'type_template';
					$data['selected'] = (set_value('type_template')) ? set_value('type_template') : $user_data['type_template'];
					$data['class'] ='form-control';
					$data['title'] = 'Type Template';
					echo form_dropdown('type_template', $type_template, $data['selected'], $data );
				?>
			</td>
		</tr>
	</table>

	<table id="tblDetail" name="tblDetail" class="table">
		<tr>
			<th width="49%"><?= $this->lang->line('akun') ?></th>
			<th width="29%">Posisi</th>			
			<th width="20%" class="t-penyesuaian">Nilai</th>
		</tr>
		
		<?php
		$data_akuns = array();
		if ( 'edit' == $act ) {
			$data_akuns = json_decode( $user_data['akun_data'], true );
		}


		if ( is_array($data_akuns) && count( $data_akuns ) > 0 ):
		
			foreach( $data_akuns as $i => $ak ):
				$i = $i+1;
		?>
			<tr>
				<td>
					<?php 
						$data['id'] = 'akun'.$i;
						$data['name'] = 'akun'.$i;
						$data['class'] = 'form-control';
						echo form_dropdown('akun[]', $accounts, $ak['akun_id'] ,$data);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'position'.$i;
						$data['name'] = 'position'.$i;
						echo form_dropdown('position[]', $positions, $ak['debit_kredit'],$data);
					?>
				</td>
				<td class="t-penyesuaian">
					<?php
						$data['id'] = 'nilai'.$i;
						$data['name'] = 'nilai[]';
						$data['value'] = isset( $ak['nilai'] ) ? $ak['nilai'] : '';
						echo form_input($data);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php else: ?>
			<?php for ($i = 1; $i <= 2; $i++) { ?>
			<tr>
				<td>
					<?php 
						$data['id'] = 'akun'.$i;
						$data['name'] = 'akun'.$i;
						$data['class'] = 'form-control';
						echo form_dropdown('akun[]', $accounts, '' ,$data);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'position'.$i;
						$data['name'] = 'position'.$i;
						echo form_dropdown('position[]', $positions, 1,$data);
					?>
				</td>
				<td class="t-penyesuaian">
					<?php 
						$data['id'] = 'nilai'.$i;
						$data['name'] = 'nilai[]';
						echo form_input($data);
					?>
				</td>
			</tr>
			<?php } ?>

		<?php endif; ?>
	</table>
	<br/>
	<div class="pull-right"><a href="javascript:addRowTemplate();" class="btn btn-danger btn-sm"><span style="color:#fff;"><?= $this->lang->line('tambah_baris') ?></span></a></div>
  	
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan', $this->lang->line('simpan'), "id = 'button-save' class='btn btn-secondary'" );
				echo form_reset('reset','Reset', "id = 'button-reset' class='btn btn-secondary'" );
				if($this->session->userdata('ADMIN'))
					echo form_button(array('id' => 'button-cancel','class' => 'btn btn-secondary', 'content' => $this->lang->line('batal'), 'onClick' => "location.href='".site_url('jurnal_template')."'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel','class' => 'btn-secondary', 'content' => 'Kembali', 'onClick' => "location.href='".site_url('jurnal_template')."'" ));
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
		$('#user_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				nama: "required"
			}
		});

		if ( $('#type_template').val() == 1 ) {
			$('body').addClass('hide-penyesuaian');	
		}
		$('#type_template').on('select2:select', function (e) {
		    var data = e.params.data;
		    $('body').toggleClass('hide-penyesuaian');
		});

	});

	function addRowTemplate() {
		var tbl = $('#tblDetail');
		var lastRow = tbl.find("tr").length;
		var emptyrows = 0;
		for (i=1; i<lastRow; i++) {
			if ($("#debit"+i).val() == '' && $("#kredit"+i).val() == '') {
				emptyrows += 1;
			}
		}	
		if (emptyrows == 0 ) {
			var ddlAkun = '<select name="akun[]" id="akun'+lastRow+'" class="form-control form-control-line" >';
			ddlAkun += $("#akun1").html();
			ddlAkun += '</select>';

			var ddlPos = '<select name="position[]" id="position'+lastRow+'" class="form-control form-control-line" >';
			ddlPos += $("#position1").html();
			ddlPos += '</select>';

			var ddlNilai = '<input type="text" name="nilai[]" id="nilai'+lastRow+'" class="form-control form-control-line">';
			
			tbl.children().append("<tr><td>"+ddlAkun+"</td><td>"+ddlPos+"</td><td class='t-penyesuaian'>"+ddlNilai+"</td></tr>");
			reload_select();
		} else {
			oDialog.html("Silahkan mengisi data pada baris yang tersedia terlebih dahulu, sebelum menambah baris.");
			oDialog.dialog('open');
		}
	}
</script>