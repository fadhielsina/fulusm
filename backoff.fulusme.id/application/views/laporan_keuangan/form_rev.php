<div class="card">
<div class="card-body">
<h3 class="card-title" ><a href="#"><?php echo $title; ?></a></h3>
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
	<form id="form_laporan" method="POST" action="<?php echo ((isset($action))?$action:"laporan/laporan_keuangan") ?>">
	<?php echo form_hidden('jenis_laporan', $jenis_laporan); ?>
	<table cellpadding="2" cellspacing="0" style="width:100%;height:auto">						  		
		
		<tr>
			<th><?php echo form_label($this->lang->line('tanggal_laporan'),'tgl_laporan'); ?></th>
			<td >
				<div class="input-daterange input-group" >
				    <input type="text" class="input-sm form-control" name="start"  id="start" autocomplete="off" />
				    <span class="input-group-addon">to</span>
				    <input type="text" class="input-sm form-control" name="end" id="end" autocomplete="off" />
				</div>
			</td>
		</tr>		
		
		<?php
		//jika admin tampilkan Seluruh Data Perusahaan
		if($this->session->userdata('ADMIN')){
		?>
			<!-- <tr>
			<th><?php echo form_label($this->lang->line('company'),'company'); ?></th>
			<td>
				<?php 
					$data['id'] = 'tahun';
					$selected = date("Y");
					$company = array("All Hospital","Hospital A","Hospital B","Hospital C");
					echo form_dropdown('company', $company, "", $data);
				?>					
			</td>
			</tr> -->
		<?php
		}
		?>							
	</table>
	
	<div class="buttons">
		<?php
			echo form_button(array('id' => 'button-save', 'content' => $this->lang->line('buat_laporan')));
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
	
</div>
</div>
<div id="content_area" ></div>
<?php

?>

<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var jenis_laporan = $('#jenis_laporan').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.post("<?php echo site_url()."laporan/laporan_keuangan"?>",$("#form_laporan").serialize(),function(result){
				$("#content_area").html(result);
			});
			//location.href = '<?php echo site_url();?>laporan_keuangan/'+jenis_laporan+'/'+bulan+'/'+tahun;
		});
	});

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