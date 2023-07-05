<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>

<script type="text/javascript" charset="utf-8">

	function cekAkun()
	{
		var tbl = $('#tblDetail');
		var lastRow = tbl.find("tr").length;
		var debitSum = 0;
		var kreditSum = 0;

		for (i=1; i<lastRow; i++) 
		{
			if (typeof($("#debit"+i).val()) != 'undefined') debitSum += parseInt($("#debit"+i).val());
			if (typeof($("#kredit"+i).val()) != 'undefined') kreditSum += parseInt($("#kredit"+i).val());
		}
		if(debitSum != kreditSum) {
			oDialog.html("Jumlah debit harus sama dengan jumlah kredit.");
			oDialog.dialog('open');
			return false;
		} else {
			return true;
		}
	}
	
</script>

<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<br/>

<?php
	echo form_open('akun/input_saldo_awal_bulk', array('id' => 'saldo_awal_form'));

	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}

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

	if($account_data)
	{
		echo '<table name="tblDetail" class="table color-table info-table">';
		echo '<tr>';
		echo '<th>Akun</th>';
		echo '<th>Debit</th>';
		echo '<th>Kredit</th>';
		echo '</tr>';

		$i = 1;
		$kelompok_akun = "";
		$dataInputField = array();
		$totalDebit=0;
		$totalKredit=0;
		foreach ($account_data as $row)
		{			
			//if($row->kelompok_akun_id != 4 && $row->kelompok_akun_id != 5)
			//{
				$debit = 0;
				$kredit = 0;
				$debit_disable = FALSE;
				$kredit_disable = FALSE;

				//tampilkan header
				if($kelompok_akun != $row->groups_name){
					echo '<tr>
						<td colspan="3"><h3>'.$row->groups_name.'</h3></td>
					</tr>';
				}
				
				echo '<tr>';
				echo '<td>';
				echo form_hidden('id[]', $row->id);
				if($row->child>0){
					echo "<h6 style='padding-left:5px;'><small>".$row->kode."</small> - ".$row->nama."</h6>";
				}else{
					echo  "<span style='padding-left:20px;'><small>".$row->kode."</small> - ".$row->nama."</span>";
				}
				echo '</td>';

				if ($row->saldo_awal < 0)
				{
					$kredit = -($row->saldo_awal);
					$debit_disable = TRUE;
				}
				elseif ($row->saldo_awal > 0)
				{
					$debit = $row->saldo_awal;
					$kredit_disable = TRUE;
				}
				echo '<td>';
				if(isset($action) && $action=="input" ){ 
					if($row->child<=0){
						$dataInputField['debit'][] = $row->id;
						$totalDebit =$totalDebit+ $debit;

						$data['id'] = 'debit'.$row->id;
						$data['name'] = 'debit'.$row->id;
						$data['class'] = 'form-control';
						$data['value'] = (set_value('debit'.$i)) ? set_value('debit'.$i) : $debit;
						if ($debit_disable) $data['disabled'] = TRUE;
						$data['onBlur'] = "calculate($i)";
						$data['title'] = "Debit harus diisi dengan angka";
						echo form_input($data);
					}
				}else{
					echo number_format($debit);
				}
				echo '</td>';
				//unset($data['disabled']);

				echo '<td>';
				if(isset($action) && $action=="input" ){ 
					if($row->child<=0  ){
						$dataInputField['kredit'][] = $row->id;
						$totalKredit =$totalKredit+ $kredit;

						$dataKredit['id'] = 'kredit'.$row->id;
						$dataKredit['name'] = 'kredit'.$row->id;
						$dataKredit['class'] = 'form-control';
						$dataKredit['value'] = (set_value('kredit'.$i)) ? set_value('kredit'.$i) : $kredit;
						if ($kredit_disable) $dataKredit['disabled'] = TRUE;
						$dataKredit['onBlur'] = "calculate($i)";
						$dataKredit['title'] = "Kredit harus diisi dengan angka";
						echo form_input($dataKredit);
					}
				}else{
					
					echo number_format($kredit);
					
				}
				echo '</td>';
				//unset($data['disabled']);

				echo '</tr>';
				$i++;
			/*}
			else
			{
				$dis_data['class'] = 'form-control';
				$dis_data['value'] = 0;
				$dis_data['disabled'] = TRUE;
				echo '<tr>';
				echo '<td>'.$row->groups_name.' - '.$row->nama.'</td>';
				echo '<td>'.number_format($dis_data).'</td>';
				echo '<td>'.number_format($dis_data).'</td>';
				echo '</tr>';
			}*/
			$kelompok_akun = $row->groups_name;
		}
		echo "
		<tr id='hrtotal'>
			<td><h4>TOTAL </h4></td>
			<td><h4 id='balanceDebit'></h4></td>
			<td><h4 id='balanceKredit'></h4></td>
		</tr>
		";
		echo '</table>';
		echo '** Saldo Awal yang diinput adalah saldo setelah penutupan pada periode sebelumnya. maka harus balanca antara debit dan kredit';
		echo '<br/>';
		
		echo '<div class="buttons">';
		echo form_submit('simpan', 'Simpan', "id = 'button-save'" );
		echo form_reset('reset','Reset', "id = 'button-reset'" );
		
		echo '</div>';
	}
	else
	{
		echo '<div class="notice">Anda belum membuat data pada akun</div>';
	}
?>

<?php echo form_close(); ?>

</div>
</div>
</div>

<script type='text/javascript'>
	//Validasi di client
	
	var inputField = JSON.parse('<?php echo json_encode($dataInputField)?>');
	var AllDebit = <?php echo (int)$totalDebit ?>;
	var AllKredit = <?php echo (int)$totalKredit ?>;
	calculate(1);
	function calculate(obj){ 
		var totalDebit = 0;
		var totalKredit = 0;
		$.each(inputField.debit,function(index,val){
				var valueKredit = $("#kredit"+val).val();
				var valueDebit = $("#debit"+val).val(); 
				totalDebit = totalDebit + parseInt(valueDebit);
				totalKredit = totalKredit + parseInt(valueKredit); 
				$("#balanceDebit").html(parseInt(totalDebit));
				$("#balanceKredit").html(parseInt(totalKredit));
			 
		});
		AllDebit = totalDebit;
		AllKredit = totalKredit;
		if(AllDebit !=AllKredit){
			$("#hrtotal").css("background-color","rgb(216 147 147)");
		}else{
			$("#hrtotal").css("background-color","white");
		}
	}
	$(document).ready(function()
	{
		$("#tblDetail").DataTable();

		/*$('#saldo_awal_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules:
			{
				<?php 
					for ($j = 1; $j < $i; $j++) 
					{
						echo 'debit'.$j.': "integer",';
						echo 'kredit'.$j.': "integer",';
					}
				?>
			}
		});*/

	$("#saldo_awal_form").submit(function(){
		if(AllDebit !=AllKredit){
			swal("Total  masih belum sama/balance antara debit dan kredit !!");
			return false
		}else{
			var conf  = confirm("apakah anda sudah yakin dengan data yang anda masukan ??");
			if(conf){
				return true;
			}else{
				return false;
			}
		}
	});

	});
	
</script>