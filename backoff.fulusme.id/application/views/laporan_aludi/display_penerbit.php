<br />
<div class="post-body">
    <?php echo $this->session->flashdata('message'); ?>
    <?php
    if ($this->session->userdata('SUCCESSMSG')) {
        echo "<div class='success'>" . $this->session->userdata('SUCCESSMSG') . "</div>";
        $this->session->unset_userdata('SUCCESSMSG');
    }
    ?>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $this->lang->line('detail_data'); ?></h4>
                <div class="pull-right">
                    <?php
                    echo form_button(array('id' => 'button-addnew', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='" . site_url() . "aludi/penerbit_add'"));
                    echo form_button(array('id' => 'button-edit', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary',  'content' => $this->lang->line('ubah'), 'onClick' => "editAction('" . site_url() . "aludi/penerbit_edit')"));
                    ?>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
                    <thead>
                        <tr>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Brand</th>
                            <th>Bidang Usaha</th>
                            <th>Total Pendanaan</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Brand</th>
                            <th>Bidang Usaha</th>
                            <th>Total Pendanaan</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        if ($penerbit_data) {
                            $i = 0;
                            foreach ($penerbit_data as $row) {
                                echo '<tr>';
                                echo '<td>' . $row->nomor_telepon . '</td>';
                                echo '<td>' . $row->email . '</td>';
                                echo '<td>' . $row->nama_perusahaan . '</td>';
                                echo '<td>' . $row->nama_brand . '</td>';
                                echo '<td>' . $row->bidang_usaha . '</td>';
                                echo '<td>' . number_format($row->total_pendanaan) . '</td>';
                                echo '<td>' . $row->status_name . '</td>';
                                echo '<td>' . $row->deskripsi . '</td>';
                                echo '<td>' . form_hidden($i, $row->kode) . form_radio('selected_data', $row->kode, "", "id='" . $row->kode . "'style='opacity:1;left:0px;position:relative;'") . '</td>';
                                echo '</tr>';
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>