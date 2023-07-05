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

                    echo form_button(array('id' => 'button-addnew', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='" . site_url() . "mitra/add'"));

                    echo form_button(array('id' => 'button-edit', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary',  'content' => $this->lang->line('ubah'), 'onClick' => "editAction('" . site_url() . "mitra/edit')"));

                    echo form_button(array('id' => 'button-view', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger',  'content' => $this->lang->line('hapus'), 'onClick' => "editAction('" . site_url() . "mitra/delete')"));

                    ?>

                </div>

                <table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Nama</th>

                            <th></th>

                        </tr>

                    </thead>

                    <tfoot>

                        <tr>

                            <th>ID</th>

                            <th>Nama</th>

                            <th></th>

                        </tr>

                    </tfoot>

                    <tbody>

                        <?php

                        if ($mitra_data) {

                            $i = 0;

                            foreach ($mitra_data as $row) {

                                echo '<tr>';

                                echo '<td>' . $row->id_koperasi . '</td>';

                                echo '<td>' . $row->nama_koperasi . '</td>';

                                echo '<td>' . form_hidden($i, $row->id_koperasi) . form_radio('selected_data', $row->id_koperasi, "", "id='" . $row->id_koperasi . "'style='opacity:1;left:0px;position:relative;'") . '</td>';

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