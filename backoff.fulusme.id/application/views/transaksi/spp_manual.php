<div class="post-title"><h2><a href="#"><?php echo $title; ?></a></h2></div>
<div class="post-body">
	<div class="box-body table-responsive no-padding">
		<div class="row">
			<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Form SPP Manual</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo site_url("procurement/proses_insert_manual") ?>" method="POST">
                    	<div><?php echo (validation_errors()); ?></div>
                        <div class="form-body">
                        <?php
                        $x=0;
                        foreach($field as $key=>$item){
                        if(is_array($item)){
                            if($item['type']=="combo"){
                                $select_class = isset( $item['class'] ) ? $item['class'] : '';

                                $itemInput = '<label class="control-label">'.$item['label'].'</label>
                                                <select name="'.$key.'" class="form-control '. $select_class .'">';
                                                if ( isset( $item['empty']) && true === $item['empty'] ) {
                                                    $itemInput .= '<option>Pilih PPTK</option>';
                                                }
                                                foreach ($item['data'] as $indexItem => $Itemvalue) {
                                                    $itemInput .= '<option value="'.$Itemvalue['value'].'">'.$Itemvalue['label'].'</option>';
                                                }
                                $itemInput .= '</select>';
                            }else if($item['type']=="date"){
                                $itemInput = '<label class="control-label">'.$item['label'].'</label>
                                        <input type="date" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="Masukan '.$item['label'].'">';
                            }
                        }else{
                            $itemInput = '<label class="control-label">'.$item.'</label>
                                        <input type="text" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="Masukan '.$item.'">';
                        }
                        if($x%2==0){
                        ?>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group m-0">
                                        <?php echo $itemInput; ?>
                                    </div>
                                </div>
                              
                        <?php
                    	}else{
                    	?>
                    		 <div class="col-md-6">
                                    <div class="form-group m-0">
                                        <?php echo $itemInput; ?>
                                    </div>
                                </div>
                               
                            </div>
                    	<?php	
                    	}	
                        $x++;
                        }
                        ?>  
                        </div>
                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <button type="button" class="btn btn-inverse">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
	</div>
</div>
