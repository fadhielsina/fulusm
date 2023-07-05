<div class="card">    <div class="card-body">        <div class="row">            <div class="col-md-6">                <h3><?= $title ?></h3>            </div>            <div class="col-md-6 text-right">            </div>        </div>        <div class="table-responsive m-t-5">            <table id="table_all_project" class="display">                <thead>                    <tr>                        <th>Nama Penerbit</th>                        <th>Nama Project</th>                        <th>Tgl Pinjam</th>                        <th>Durasi Pinjam</th>                        <th>Jumlah Tagihan</th>                        <th>Dibayar</th>                        <th>Sisa Tagihan</th>                        <th>Status</th>                        <th></th>                    </tr>                </thead>                <tbody>                    <?php if ($project) : ?>                        <?php foreach ($project as $row) : ?>                            <?php $query = $this->db->get_where('trx_pengembalian_dana', ['id_project' => $row->id_project])->result();                                    $dibayar = 0;                                    foreach ($query as $col) {                                        $dibayar += $col->nominal;                                    }                                    $notif = ['warna' => 'info', 'pesan' => 'Sedang Proses'];                                    if ($row->jumlah_pinjaman <= $dibayar) {                                        $notif = ['warna' => 'success', 'pesan' => 'Pengembalian Selesai'];                                    } ?>                            <tr>                                <td><?= $row->peminjam ?></td>                                <td><?= $row->nama_project ?></td>                                <td><?= $row->tgl_pinjam ?></td>                                <td><?= $row->tenor ?> Hari</td>                                <td><?= number_format($row->jumlah_pinjaman) ?></td>                                <td><?= number_format($dibayar); ?></td>                                <td><?= number_format($row->jumlah_pinjaman - $dibayar) ?></td>                                <td>                                    <h5><span class="badge badge-<?= $notif['warna'] ?>"><?= $notif['pesan'] ?></span></h5>                                </td>                                <td>                                    <h3><a href="<?= base_url('transaksi/form_bayar') ?>/<?= $row->id_project ?>"><i class="mdi mdi-arrow-right-bold-circle"></i></a></h3>                                </td>                            </tr>                        <?php endforeach; ?>                    <?php endif; ?>                </tbody>            </table>        </div>    </div></div><script type="text/javascript">    $(document).ready(function() {        $('#table_all_project').DataTable({            "order": [                [2, "desc"]            ]        });    });</script>