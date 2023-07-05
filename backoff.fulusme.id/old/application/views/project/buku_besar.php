<style>
    .color-table.info-table thead th {

        color: #67757C;

    }
</style>

<script type="text/javascript" src="<?php echo base_url(); ?>js/group_table.js"></script>

<div class="col-lg-12">

    <div class="card">

        <div class="card-body">

            <h4 class="card-title">DETAIL</h4>

            <table class="table color-table info-table" id="display_table">

                <thead>

                    <tr>

                        <th>ID Project</th>

                        <th>Nama Project</th>

                        <th>Dana Terkirim</th>

                        <th>Dana DIkembalikan</th>

                        <th>Nisbah</th>

                        <th>Ujrah</th>

                        <th></th>

                    </tr>

                </thead>

                <tfoot>

                    <tr>

                        <th>ID Project</th>

                        <th>Nama Project</th>

                        <th>Dana Terkirim</th>

                        <th>Dana DIkembalikan</th>

                        <th>Nisbah</th>

                        <th>Ujrah</th>

                        <th></th>

                    </tr>

                </tfoot>

                <tbody>

                    <?php

                    if ($project) {

                        foreach ($project as $row) {

                            $ujrah = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $row->id_project])->row()->ujrah;

                            echo '<tr>';

                            echo '<td>' . $row->id_project . '</td>';

                            echo '<td>' . $row->nama_project . '</td>';

                            echo '<td>' . number_format($row->nominal_pengembalian) . '</td>';

                            echo '<td>' . number_format($row->dana_terkumpul) . '</td>';

                            echo '<td>' . number_format($row->dana_nisbah) . '</td>';

                            echo '<td>' . number_format($ujrah) . '</td>';

                            echo '<td>' . anchor(site_url('project/detail_buku_besar/' . $row->id_project . ''), 'Detail') . '</td>';

                            echo '</tr>';
                        }
                    }

                    ?>

                </tbody>

            </table>

        </div>



    </div>



</div>