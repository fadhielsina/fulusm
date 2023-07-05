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

<div class="card" style="padding-top:35px">
<div class="card-body" style="padding-top:30px">
<div class="post-title" style="margin-top: 20px;">
<h4 class="card-title"><?php echo $title ?></h4>
</div>
	<form id="form_laporan" method="POST"> 
	<?php echo form_hidden('nama_laporan', $nama_laporan); ?>
	<table  cellpadding="2" cellspacing="0" style="width:100%;height: auto;">					
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
			<th><?php echo form_label($this->lang->line('tanggal_laporan'),'tgl_laporan'); ?></th>
			<td >
				<div class="input-daterange input-group" >
				    <input type="text" class="input-sm form-control" name="start"  id="start" />
				    <span class="input-group-addon">to</span>
				    <input type="text" class="input-sm form-control" name="end" id="end" />
				</div>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('nama_kasir'),'nama_kasir'); ?></th>
			<td >
				<input type="text" class="input-sm form-control" name="nama_kasir" id="nama_kasir" />
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('nama_asuransi'),'nama_asuransi'); ?></th>
			<td>
				<?php 
					$data['id'] = 'nama_asuransi';
					$data['class'] = "form-control";
					$selected = 'all';
					$options = array( 'all' => $this->lang->line('semua'),
								  	  'askes'=>'ASKES',
										'askes pns'=>'ASKES PNS',
										'axa mandiri'=>'AXA Mandiri',
										'b n i'=>'B N I',
										'bpjs non pbi'=>'BPJS NON PBI',
										'bpjs non pbi + kai'=>'BPJS NON PBI + KAI',
										'bpjs pbi'=>'BPJS PBI',
										'in health '=>'IN HEALTH ',
										'jalinan kasih'=>'JALINAN KASIH',
										'jampersal'=>'JAMPERSAL',
										'jasa raharja'=>'JASA RAHARJA',
										'karyawan pku'=>'KARYAWAN PKU',
										'prudential'=>'PRUDENTIAL',
										'pt. telkom'=>'PT. TELKOM'
								  	);
					echo form_dropdown($this->lang->line('nama_asuransi'), $options, $selected, $data);
				?>					
			</td>
		</tr>
		<tr>
			<th><?php echo form_label('No RM','no_rm'); ?></th>
			<td >
			    <input type="text" class="input-sm form-control" name="no_rm" id="no_rm" />
			</td>
		</tr>		
	</table>
	</form>
	<div class="buttons">
		<?php
			echo form_button(array('id' => 'button-save', 'content' => $this->lang->line('buat_laporan')));
			echo form_button('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
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