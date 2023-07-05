<div class="card">
  <div class="card-body">
    <h3><?php echo ucfirst(str_replace("_", " ", "Laporan Jatuh Tempo")) ?></h3>
    <h4><?= $this->lang->line('periode') ?> : <?php echo $months . " " . $years ?></h4>
    <div class="table-responsive m-t-5">
      <table id="table_id" class="display">
        <thead>
          <tr>
            <th>Nama Project</th>
            <th>Nama Peminjam</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Tempo</th>
            <th>Lama Pinjam / s.d</th>
            <th>Jumlah Tagihan</th>
            <th>Jumlah Cicilan</th>
            <th>Dibayar</th>
            <th>Sisa Tagian</th>
            <th></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Nama Project</th>
            <th>Nama Peminjam</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Tempo</th>
            <th>Lama Pinjam / s.d</th>
            <th>Jumlah Tagihan</th>
            <th>Jumlah Cicilan</th>
            <th>Dibayar</th>
            <th>Sisa Tagian</th>
            <th></th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach ($project as $row) : ?>
            <?php if ($row->status == 0) : ?>
              <?php $query = $this->db->get_where('trx_pengembalian_dana', ['id_project' => $row->id_project])->result();
                  $dibayar = 0;
                  foreach ($query as $col) {
                    $dibayar += $col->nominal;
                  } ?>
              <tr>
                <td><?= $row->nama_project ?></td>
                <td><?= $row->peminjam ?></td>
                <td><?= $row->tgl_pinjam ?></td>
                <td class="text-center"><?= date('d', strtotime($row->tgl_pinjam)) ?></td>
                <?php if ($row->tipe_angsuran == 'Di Akhir') : ?>
                  <td><?= date('Y-m-d', $row->angsuran) ?></td>
                  <?php $cicilan = 'Dibayar Akhir'; ?>
                <?php else : ?>
                  <td><?= $row->angsuran ?> Bulan</td>
                  <?php $cicilan = number_format($row->cicilan); ?>
                <?php endif; ?>
                <td><?= number_format($row->jumlah_pinjaman) ?></td>
                <td><?= $cicilan; ?></td>
                <td><?= number_format($dibayar) ?></td>
                <td><?= number_format($row->jumlah_pinjaman - $dibayar) ?></td>
                <td>
                  <h3><a href="<?= base_url('transaksi/form_bayar') ?>/<?= $row->id_project ?>"><i class="mdi mdi-arrow-right-bold-circle"></i></a></h3>
                </td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#table_id').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'excel', 'pdf', 'print'
      ]
    });
  });
</script>