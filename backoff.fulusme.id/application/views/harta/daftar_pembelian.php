
<div class="post-body">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pembelian Harta Tetap</h4>
				<div class="pull-right">
        <?php
        echo form_button(array('id' => 'button-addnew', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='" . site_url() . "harta/add_pembelian'"));
        echo form_button(array('id' => 'button-view', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info',  'content' => $this->lang->line('lihat'), 'onClick' => "editAction('" . site_url() . "harta/view_pembelian')"));
        echo form_button(array('id' => 'button-edit', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary',  'content' => $this->lang->line('ubah'), 'onClick' => "editAction('" . site_url() . "harta/edit_pembelian')"));
        echo form_button(array('id' => 'button-delete', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger',  'content' => $this->lang->line('hapus'), 'onClick' => "return confirm('Yakin ingin menghapus?'), editAction('" . site_url() . "harta/delete_pembelian')"));
        ?>
    </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
                    <thead>
                        <tr>
                            <th>No Pembelian</th>
                            <th>Tanggal</th>
                            <th>Suplier</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($user_data) {
                            $i = 0;
                            foreach ($user_data as $row) {
                                echo '<tr>';
                                echo '<td>' . $row->invoiceBuyID . '</td>';
                                echo '<td>' . $row->trxDate . '</td>';
                                echo '<td>' . $row->trxFullName . '</td>';
                                echo '<td>' . number_format( $row->trxTotal ) . '</td>';
                                echo '<td>' . form_hidden($i, $row->trxID) . form_radio('selected_data', $row->trxID, "", "id='" . $row->trxID . "'style='opacity:1;left:0px;position:relative;'") . '</td>';
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