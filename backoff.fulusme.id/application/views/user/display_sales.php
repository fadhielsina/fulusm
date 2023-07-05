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

                <div class="pull-right">

                    <?php

                    echo form_button(array('id' => 'button-addnew', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='" . site_url() . "sales/add'"));

                    echo form_button(array('id' => 'button-edit', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary',  'content' => $this->lang->line('ubah'), 'onClick' => "editAction('" . site_url() . "sales/edit')"));

                    echo form_button(array('id' => 'button-view', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger',  'content' => $this->lang->line('hapus'), 'onClick' => "editAction('" . site_url() . "sales/delete')"));

                    ?>

                </div>

                <h4 class="card-title"><?php echo $this->lang->line('detail_data'); ?></h4>


                <table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Nama</th>

                            <th>HP</th>

                            <th>KTP</th>

                            <th>Alamat</th>

                            <th></th>

                        </tr>

                    </thead>

                    <tfoot>

                        <tr>

                            <th>ID</th>

                            <th>Nama</th>

                            <th>HP</th>

                            <th>KTP</th>

                            <th>Alamat</th>

                            <th></th>

                        </tr>

                    </tfoot>

                    <tbody>

                        <?php

                        if ($user_data) {

                            $i = 0;

                            foreach ($user_data as $row) {

                                echo '<tr>';

                                echo '<td>' . $row->id . '</td>';

                                echo '<td>' . $row->nama_depan . ' ' . $row->nama_belakang . '</td>';

                                echo '<td>' . $row->no_hp . '</td>';

                                echo '<td>' . $row->no_ktp . '</td>';

                                echo '<td>' . $row->alamat . '</td>';

                                echo '<td>' . form_hidden($i, $row->login_id) . form_radio('selected_data', $row->login_id, "", "id='" . $row->login_id . "'style='opacity:1;left:0px;position:relative;'") . '</td>';

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