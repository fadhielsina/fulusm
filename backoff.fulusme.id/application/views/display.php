<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header text-white">
                <a href="<?php echo $add_url ?>" class="btn btn-lg btn-primary pull-right"> Tambah Data</a> 
                <a href="<?php echo $back_url ?>" title="kembali" class="btn btn-lg btn-warning pull-right"> << </a> 
                <h2 class="text-white"><?php echo $title; ?></h2>  
            </div>
            <div class="card-body">
                <?php
                if($this->session->flashdata("message")!=""){
                    echo '<div class="alert alert-primary" role="alert">
                          '.$this->session->flashdata("message").'
                        </div>';
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="mytable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                        <?php
                                        foreach($field as $key=>$item){
                                            if(is_array($item)){  
                                                echo '<th>'.$item['label'].'</th>';
                                            }else{
                                                echo '<th>'.$item.'</th>';
                                            }
                                        }
                                        echo '<td></td>';
                                        ?>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                    <?php
                                    $x=1;
                                    foreach($list_data as $index=>$value){
                                        echo '<tr><td>'.$x.'</td>';
                                        foreach($field as $key=>$item){
                                            echo '<td>'.$value[$key].'</td>';
                                        }
                                        echo '<td>';
                                        if(Isset($edit_url)){
                                        echo '
                                            <a href="'.$edit_url.'/'.$value[$field_primary].'"><i class="fa fa-edit"></i></a>';
                                        }
                                        if(Isset($detail_url)){
                                        echo '    <a href="'.$detail_url.'/'.$value[$field_primary].'"><i class="fa fa-table"></i></a>';
                                        }
                                        if(Isset($delete_url)){
                                        echo '     <a href="'.$delete_url.'/'.$value[$field_primary].'" onClick="return confirm(\'Apakah anda yakin akan menghapus data? \')"><i class="fa fa-trash-o"></i></a>';
                                        }
                                        echo '</td>';
                                        echo '</tr>';
                                        $x++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
                    
