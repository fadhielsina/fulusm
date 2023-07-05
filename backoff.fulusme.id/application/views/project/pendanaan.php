<div class="card">
    <div class="card-body">
        <div class="table-responsive m-t-5">
            <h3><?= $title ?></h3>
            <table id="table_pendana" class="display">
                <thead>
                    <tr>
                        <th>Project Id</th>
                        <th>Nama Project</th>
                        <th>ID / Pengelola Dana</th>
                        <th>ID / Pendana</th>
                        <th>Nominal</th>
                        <th>Total Lembar Saham</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($pendanaan_data) {
                        foreach ($pendanaan_data as $row) {
                            $total_lot = $this->db->select('total_lot')->from('virtual_account')
                                ->where('pendanaan_id', $row['id'])->get()->row()->total_lot;
                            echo '<tr>';
                            echo '<td>' . $row['project_id'] . '</td>';
                            echo '<td>' . $row['nama_project'] . '</td>';
                            echo '<td>' . $row['peminjam_id'] . ' / ' . $row['name'] . '</td>';
                            echo '<td>' . $row['pendana_id'] . ' / ' . $row['full_name'] . '</td>';
                            echo '<td>' . number_format($row['nominal']) . '</td>';
                            echo '<td>' . $total_lot . '</td>';
                            echo '<td>' . $row['status_pendanaan'] . '</td>';
                            echo '<td><a href="' . base_url('data_pendana/pendanaan_detail/') . $row['id'] . '">Detail</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_pendana').DataTable();
    });
</script>