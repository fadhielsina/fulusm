<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open($form_act, array('id' => 'anggaran_form','id' => 'anggaran_form', 'class' => 'form-material m-t-40'));


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

	echo form_hidden('module', $module_name);
?>
		
		<table class="table color-table info-table">
		<tr>
			<th><?php echo form_label($this->lang->line('nama_periode').'*',"nama_periode"); ?></th>
			<td>
				<?php 
					$data['name']  = 'nama_periode';
					$data['maxlength'] = '100';
					$data['class'] ='form-control';
					$data['value'] = (set_value("nama_periode") ? set_value("nama_periode") : $periode['nama_periode']);
					$data['title'] = $this->lang->line('valid_nama_periode');
					echo form_input($data);
				?>
			</td>
		</tr>

		<tr>
			<th><?php echo form_label($this->lang->line('nama_anggaran').'*',"mata_anggaran"); ?></th>
			<td>
				<?php
				echo form_dropdown('mata_anggaran', $anggaran, '','class="form-control"');	
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('periode_awal').'*',"periode_awal"); ?></th>
			<td >
				<div class="input-daterange input-group"  >
				    <input type="text" class="input-sm form-control" name="tanggal_awal" id="tanggal_awal"/>
				    <span class="input-group-addon">to</span>
				    <input type="text" class="input-sm form-control" name="tanggal_akhir" id="tanggal_akhir" />
				</div>
			</td>
		</tr>
	</table>
	
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan',$this->lang->line('simpan'), "id = 'button-save'" );
				echo form_reset('reset','Reset', "id = 'button-reset'" );
				echo form_button(array('id' => 'button-cancel', 'content' => $this->lang->line('batal'), 'onClick' => "location.href='".site_url()."anggaran'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel', 'content' => $this->lang->line('kembali'), 'onClick' => "location.href='".site_url()."anggaran'" ));
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
		$('#anggaran_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				mata_anggaran: "required",
				id_nama_anggaran: "required digits"
			}
		});
	
	/*$('.input-daterange').datepicker({
	    // orientation: "bottom left"
	});*/
	 $( function() {
	    var dateFormat = "yyyy/mm/dd",
	      from = $( "#tanggal_awal" )
	        .datepicker({
	          defaultDate: "+1w",
	          changeMonth: true,
	          numberOfMonths: 1
	        })
	        .on( "change", function() {
	          to.datepicker( "option", "minDate", getDate( this ) );
	        }),
	      to = $( "#tanggal_akhir" ).datepicker({
	        defaultDate: "+1w",
	        changeMonth: true,
	        numberOfMonths: 1
	      })
	      .on( "change", function() {
	        from.datepicker( "option", "maxDate", getDate( this ) );
	      });
	 
	    function getDate( element ) {
	      var date;
	      try {
	        date = $.datepicker.parseDate( dateFormat, element.value );
	      } catch( error ) {
	        date = null;
	      }
	 
	      return date;
	    }
	  } );
	});
</script>
