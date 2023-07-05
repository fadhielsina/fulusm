<br>
<div class="col-lg-12">
    <?php
    if ($this->session->userdata('SUCCESSMSG')) {
        echo "<div class='success'>" . $this->session->userdata('SUCCESSMSG') . "</div>";
        $this->session->unset_userdata('SUCCESSMSG');
    }
    ?>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><?= $title ?></h4>
            <?= form_open('kas/history_kas'); ?>
            <div class="row">
                <div class="col-4 text-center">
                    <label>Akun</label>
                    <select class="form-control" name="akun" id="akun" required>
                        <option disabled value="">Cari dan Pilih</option>
                        <?php foreach ($all_kas as $row) : ?>
                            <option value="<?= $row->id ?>"<?php echo $row->id == $selected_akun ? ' selected' : ''; ?>><?= $row->kode . ' - ' . $row->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-3 text-center p-0 pr-2">
                    <label> Tanggal </label>
                    <input class="form-control" type="date" id="tgl1" name="tgl1" value="<?= date('Y-m-01'); ?>">
                </div>
                <span>
                    <label></label>
                    <h5 class="mt-3">s/d</h5>
                </span>
                <div class="col-3 text-center p-0 pl-2">
                    <label> Tanggal </label>
                    <input class="form-control" type="date" id="tgl2" name="tgl2" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="col-1">
                    <label>Filter</label>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-responsive display" id="table_bank">
                <thead>
                    <tr>
                        <th style="display: none">id</th>
                        <th>No.Trx</th>
                        <th>Tanggal</th>
                        <th>No Sumber</th>
                        <th>No Doc</th>
                        <th>Jenis Transaksi</th>
                        <th>Keterangan</th>
                        <th>Mutasi</th>
                        <th>Tipe</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php

                    $sum = 0;
				if ($account_data['saldo_awal'] != 0)
				{
					$sum = $account_data['saldo_awal'];
					if ($sum < 0)
					{
						$d = '';
						$k = number_format(-$sum, 0, '', '.');
						$dk = 'K';
					}
					else
					{
						$d = number_format($sum, 0, '', '.');
						$k = '';
						$dk = 'D';
					}
					echo '<tr>';
                   echo '<td>'.$account_data['no'].'</td>';
					echo '<td>'.$account_data['tanggal'].'</td>';
                    echo '<td>-</td>';
					echo '<td>'.$account_data['sa_trx_no'].'</td>';
                    echo '<td>SA</td>';
					 echo '<td>Saldo Awal</td>';
					echo '<td>'.$d.'</td>';	
					 echo '<td>Saldo Awal</td>';
					echo '<td>'.number_format(abs($sum), 0, '', '.').'</td>';				
					echo '</tr>';
				}

                    if ($histori_data) : ?>
                        <?php foreach ($histori_data as $row) : 
						
						if($row->jns_trans == 'KM')
						{
							$sum += $row->jumlah;
							
						}
						else if($row->jns_trans == 'TK' && $row->untuk_kas_id == $akun)
						{
							$sum += $row->jumlah;
							
						}
						else
						{
							$sum -= $row->jumlah;
						
						}
						?>
                            <tr>
                                <td style="display: none"><?= $row->id ?></td>
                                <td><?= $row->no_trx_kas ?></td>
                                <td><?= $row->tgl_catat ?></td>
                                <td><?= $row->dok ?></td>
                                <td><?= $row->no_dok ?></td>
                                <td><?= $row->jns_trans ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td><?= number_format($row->jumlah) ?></td>
                                <td><?= $row->akun ?></td>
                                <td><?= number_format($sum) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#table_bank').DataTable({
            "order": [
                [0, "asc"]
            ]
        });

        $('#table_bank tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            location.replace("<?= base_url('Kas/detail_data_in/') ?>" + data[0])
        });
    });
</script>