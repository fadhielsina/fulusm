<?php
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

?>

<div class="card" style="padding-top:25px">
<div class="card-body" style="padding-top:30px">
	<div class="post-title" style="margin-top: 20px;">
		<h4 class="card-title"><?php echo $title ?></h4>
	</div>
	<form id="form_laporan" method="POST"> 
	<?php echo form_hidden('nama_laporan', $nama_laporan); ?>
	<table  cellpadding="2" cellspacing="0" style="width:auto;height: auto;">					
		<tr>
			<th><?php echo form_label($this->lang->line('jenis_laporan'),'jenis_laporan'); ?></th>
			<td>
				<?php 
					$data['id'] = 'jenis_laporan';
					$data['class'] = "form-control";
					$selected = 'laporan_neraca';
					$options = array( 'laporan_harian' => $this->lang->line('harian'),
								  	  'laporan_bulanan' => $this->lang->line('bulanan')
								  	);
					echo form_dropdown('jenis_laporan', $options, $selected, $data);
				?>					
			</td>
		</tr>		
		<tr>
			<th><?php echo form_label($this->lang->line('tgl_laporan'),'tgl_laporan'); ?></th>
			<td >
				<div class="input-daterange input-group" >
				    <input type="text" class="input-sm form-control" name="start"  id="start" />
				    <span class="input-group-addon">to</span>
				    <input type="text" class="input-sm form-control" name="end" id="end" />
				</div>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('poli'),'jenis_poli'); ?></th>
			<td>
				<?php 
					$data['id'] = 'jenis_poli';
					$data['class'] = "form-control";
					$selected = '';
					$poli = array(""=>"Pilih Poli");
					foreach ($listPoli as $key => $dataPoli) {
						$poli[$dataPoli['DEPARTMENT_NAME']] = $dataPoli['DEPARTMENT_NAME'];
					}
					echo form_dropdown('jenis_poli', $poli, $selected, $data);
				?>					
			</td>
		</tr>
		<!-- <tr>
			<th><?php echo form_label($this->lang->line('nama_asuransi'),'nama_asuransi'); ?></th>
			<td>
				<?php 
					$data['id'] = 'nama_asuransi';
					$data['class'] = "form-control";
					$selected = 'all';
					
					$insurance = array(""=>"Pilih Asuransi");
					foreach ($listInsurance as $key => $dataInsurance) {
						$insurance[$dataInsurance['INSURANCE_NAME']] = $dataInsurance['INSURANCE_NAME'];
					}
					echo form_dropdown('nama_asuransi', $insurance, $selected, $data);
				?>					
			</td>
		</tr> -->
		<tr>
			<td>
			</td>
			<td>
				<div class="buttons">
					<?php
						echo form_button(array('id' => 'button-save', 'content' => $this->lang->line('buat_laporan')));
						echo form_button('reset','Reset', "id = 'button-reset'" );
					?>
				</div>
			</td>
		</tr>
	</table>
	</form>
	
</div>
</div>
<div id="content_area">
	
</div>


<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var jenis_laporan = $('#jenis_laporan').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.post("<?php echo site_url()."laporan/"?>"+jenis_laporan,$("#form_laporan").serialize(),function(result){
				$("#content_area").html(result);
			});
			//location.href = '<?php echo site_url();?>laporan_keuangan/'+jenis_laporan+'/'+bulan+'/'+tahun;
		});
	});
	
    /*$('.input-daterange').datepicker({
	     orientation: "bottom left"
	});*/
	$( function() {
	    var dateFormat = "yyyy/mm/dd",
	      from = $( "#start" )
	        .datepicker({
	          defaultDate: "+1w",
	          changeMonth: true,
	          numberOfMonths: 1
	        })
	        .on( "change", function() {
	          to.datepicker( "option", "minDate", getDate( this ) );
	        }),
	      to = $( "#end" ).datepicker({
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

</script>