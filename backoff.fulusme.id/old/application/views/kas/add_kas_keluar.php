<script type="text/javascript" src="<?php echo base_url(); ?>js/jurnal.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
<br />
<div class="col-lg-12">
	<h3 class="pull-left"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
	<br />
	<div class="post-body">
		<?php echo form_open('jurnal/insert_kas_keluar', array('id' => 'jurnal_form', 'class' => 'form-material m-t-40'));
		echo "<div id='error' class='error-message' ";
		if ($this->session->userdata('ERRMSG_ARR')) {
			echo ">";
			echo $this->session->userdata('ERRMSG_ARR');
			$this->session->unset_userdata('ERRMSG_ARR');
		} else {
			echo "style='display:none'>";
		}
		echo "</div>"; ?>
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>

				<table class="table color-table info-table">
					<input type="hidden" class="form-control" name="jns" id="jns" value="KK" />
					<input type="hidden" class="form-control" name="identity_id" id="identity_id" value="<?php echo $identity_id; ?>" />
					<input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>" />
					<input type="hidden" class="form-control" name="tipe_trx" id="tipe_trx" value="add" />
					<tr>
						  <td width="30%">Tgl Transaksi</td>
						  <td><input type="text" name="tanggal" id="datepicker" size="30" maxlength="30" class="form-control" value="<?php echo date('Y-m-d'); ?>" required /></td>
					</tr>
					</tr>
					<tr>
					  <td  style="vertical-align: top;">Dibayarkan kepada</td>
					  <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="kepada" id="kepada" required=""  />
					  </td>
					</tr>
					<tr>
						<td style="vertical-align: top;">Dari Kas / Bank</td>
						<td style="vertical-align: top;" colspan="3">
							<select class="form-control" name="dari_akun" required="">
								<?php foreach ($all_kas as $row) : ?>
									<option value="<?= $row->id ?>"><?= $row->nama . ' - ' . $row->kode ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;"><?= $this->lang->line('catatan') ?></td>
						<td style="vertical-align: top;" colspan="3">
							<textarea name="catatan" value="2" class="form-control" required=""></textarea>
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;"><?= $this->lang->line('sesuai_dokumen') ?></td>
						<td style="vertical-align: top;"><input type="text" class="form-control" name="dokumen" id="dokumen" />
						<td style="vertical-align: top;" class="pull-right"><?= $this->lang->line('no_dokumen') ?></td>
						<td style="vertical-align: top;"><input type="text" class="form-control" name="no_dokumen" id="no_dokumen" />
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;">Bukti Transaksi</td>
						<td style="vertical-align: top;" colspan="3"><input type="file" class="form-control" name="bukti_transaksi" id="bukti_transaksi" /> 
						</td>
					</tr>
				</table>
				<div class="row">
			<div class="col">
			<?php echo form_label('Jenis Jurnal','jenis'); ?>
			<select name="jnsjrn" id="jnsjrn" class="form-control col-md-4">
					<option value="k" selected> Kas</option>	
					<option value="b">Bank</option>
										</select>
			</div>
			
			</div>
			<hr/>

			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Pengeluaran Untuk</h4>

				<?php
				echo form_hidden('f_id', $f_id);
				echo form_hidden('goto', current_url());
				$data['class'] = 'input';
				?>

				<div class="col-lg-12">
					<table id="tblDetail" name="tblDetail" class="data-table">
						<tr>
							<th style="width: 415px;"><?= $this->lang->line('akun') ?></th>
							<th class="text-center" style="width: 250px;">Nilai</th>
							<th class="text-center" style="width: 250px;"><?= $this->lang->line('keterangan') ?></th>
						</tr>
						<tr>
							<td>
								<?php
								echo form_dropdown('akun[]', $nama_akun, '' , array(
									'class' => 'form-control',
									'id' => 'akun1'
								));
								?>
							</td>
							<td>
								<input type="text" class="form-control text-center" id="nilai[]" name="nilai[]" onkeyup="formatNumber(this);">
							</td>
							<td>
								<input type="text" class="form-control" id="keterangan[]" name="keterangan[]">
							</td>
						</tr>
					</table>
					<br />
					<div class="pull-right"><a href="javascript:void(0);" id="tambah_baris" class="btn btn-danger btn-sm"><span style="color:#fff;"><?= $this->lang->line('tambah_baris') ?></span></a></div>

					<div class="pull-left">
						<button type="submit">Post</button>
						<button type="reset" id="btn-reset">Reset</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<input type="hidden" id="jumlah-form" value="1">

	<script>
		$(document).ready(function() { // Ketika halaman sudah diload dan siap
			$("#tambah_baris").click(function() { // Ketika tombol Tambah Data Form di klik
				var option_select = $('#akun1').html();
				$("#tblDetail").append("<tr><td><select class='form-control' name='akun[]'>"+ option_select +"</select></td><td><input type='text' class='form-control text-center' id='nilai[]' name='nilai[]' onkeyup='formatNumber(this);'></td><td><input type='text' class='form-control' id='keterangan[]' name='keterangan[]'></td></tr>");
				reload_select();
			});
			// Buat fungsi untuk mereset form ke semula
			$("#btn-reset").click(function() {
				$("#table_div").html(""); // Kita kosongkan isi dari div insert-form
				$("#jumlah-form").val("1"); // Ubah kembali value jumlah form menjadi 1
			});
		});
	</script>

	<script>
	</script>

	<script>
		$('#jumlah').keyup(function() {
			var bilangan = parseFloat($('#jumlah').val().split(",").join(""));
			if (isNaN(bilangan)) {
				alert('Yang anda tulis bukan bilangan')
				return false;
			}
			$('#terbilang').val(terbilang(bilangan));
		});
		function terbilang(bilangan) {
			bilangan = String(bilangan);
			var angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
			var kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
			var tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');
			var panjang_bilangan = bilangan.length;
			/* pengujian panjang bilangan */
			if (panjang_bilangan > 15) {
				kaLimat = "Diluar Batas";
				return kaLimat;
			}
			/* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
			for (i = 1; i <= panjang_bilangan; i++) {
				angka[i] = bilangan.substr(-(i), 1);
			}
			i = 1;
			j = 0;
			kaLimat = "";
			/* mulai proses iterasi terhadap array angka */
			while (i <= panjang_bilangan) {
				subkaLimat = "";
				kata1 = "";
				kata2 = "";
				kata3 = "";
				/* untuk Ratusan */
				if (angka[i + 2] != "0") {
					if (angka[i + 2] == "1") {
						kata1 = "Seratus";
					} else {
						kata1 = kata[angka[i + 2]] + " Ratus";
					}
				}
				/* untuk Puluhan atau Belasan */
				if (angka[i + 1] != "0") {
					if (angka[i + 1] == "1") {
						if (angka[i] == "0") {
							kata2 = "Sepuluh";
						} else if (angka[i] == "1") {
							kata2 = "Sebelas";
						} else {
							kata2 = kata[angka[i]] + " Belas";
						}
					} else {
						kata2 = kata[angka[i + 1]] + " Puluh";
					}
				}
				/* untuk Satuan */
				if (angka[i] != "0") {
					if (angka[i + 1] != "1") {
						kata3 = kata[angka[i]];
					}
				}
				/* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
				if ((angka[i] != "0") || (angka[i + 1] != "0") || (angka[i + 2] != "0")) {
					subkaLimat = kata1 + " " + kata2 + " " + kata3 + " " + tingkat[j] + " ";
				}
				/* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
				kaLimat = subkaLimat + kaLimat;
				i = i + 3;
				j = j + 1;
			}
			/* mengganti Satu Ribu jadi Seribu jika diperlukan */
			if ((angka[5] == "0") && (angka[6] == "0")) {
				kaLimat = kaLimat.replace("Satu Ribu", "Seribu");
			}
			return kaLimat + "Rupiah";
		}
	</script>

	<script>
		$(function() {
			$("#tabs").tabs();
		});
	</script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/jurnal.js"></script>

	<script type='text/javascript'>
		//Validasi di client
		$(document).ready(function() {
			$('#jurnal_form').validate({
				errorLabelContainer: "#error",
				wrapper: "li",
				rules: {
					nomor: "required",
					tanggal: "required dateISO",
					deskripsi: "required"
				}
			});
		});
	</script>

	<script type="text/javascript">
		$('#trxStatus').on('change', function() {
			val = this.value;
			if (val == 2)
				$('#termin').fadeIn();
			else
				$('#termin').fadeOut();
		});
	</script>

	<script type="text/javascript" charset="utf-8">
		$(function() {
			$('#dialog-form').load('<?php echo site_url(); ?>klien/popup');
			$("#dialog-form").dialog({
				autoOpen: false,
				title: 'Klien',
				height: 520,
				width: 900,
				modal: true,
				buttons: {
					'OK': function() {
						var chkIdx = $('input:radio:checked').val();
						var aData = popup_table.fnGetData(chkIdx);
						$("#memberID").val(aData[0]);
						$("#memberCode").val(aData[1]);
						$("#trxFullName").val(aData[2]);
						$("#memberAddress").val(aData[3]);
						$("#memberPhone").val(aData[4]);
						$(this).dialog('close');
					},
					'Batal': function() {
						$(this).dialog('close');
					}
				},
			});
			$('#trxFullName').focus(function() {
				$('#dialog-form').dialog('open');
			});
		});
		$('#trxSparepartTotal').keyup(function() {
			updateSubTotal();
		});
		$('#trxJasaTotal').keyup(function() {
			updateSubTotal();
		});
		var updateSubTotal = function() {
			trxSparepartTotal = parseInt($('#trxSparepartTotal').val());
			trxJasaTotal = parseInt($('#trxJasaTotal').val());
			// alert(trxJasaTotal);
			if (isNaN(trxSparepartTotal) || isNaN(trxJasaTotal)) {
				if (!trxJasaTotal) {
					$('#trxSubtotal').val($('#trxSparepartTotal').val());
				}
				if (!trxSparepartTotal) {
					$('#trxSubtotal').val($('#trxJasaTotal').val());
				}
			} else {
				$('#trxSubtotal').val(trxJasaTotal + trxSparepartTotal);
			}
		};
	</script>

	<script>
		function formatNumber(input) {
			var num = input.value.replace(/\,/g, '');
			if (!isNaN(num)) {
				if (num.indexOf('.') > -1) {
					num = num.split('.');
					num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('').reverse().join('').replace(/^[\,]/, '');
					if (num[1].length > 2) {
						alert('You may only enter two decimals!');
						num[1] = num[1].substring(0, num[1].length - 1);
					}
					input.value = num[0] + '.' + num[1];
				} else {
					input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('').reverse().join('').replace(/^[\,]/, '')
				};
			} else {
				alert('Anda hanya diperbolehkan memasukkan angka!');
				input.value = input.value.substring(0, input.value.length - 1);
			}
		}
	</script>
	
		
<script>  
 $("#divbank").hide();
$(document).ready(function(){
    $('#jnsjrn').on('change', function() {
      if ( this.value == 'b')
      {
        $("#divbank").show();
      }
      else
      {
        $("#divbank").hide();
      }
    });
});
</script>