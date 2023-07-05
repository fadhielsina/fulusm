
<div class="post-body">
	<div class="box-body table-responsive no-padding">
		<div class="row">
			<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h3 class="text-white"><?php echo $title; ?></h3>
                </div>
                <div class="card-body">
                   
                    <?php
                    if(isset($hidden)){ 
                       echo form_open_multipart($save_url , '', $hidden); 
                    }else{
                       echo form_open_multipart($save_url , ''); 
                    }
                    ?>
                    <!-- <form action="<?php echo $save_url ?>" method="POST" enctype="multipart"> -->
                        <input type="hidden" name="action" value="<?php echo $action ?>">
                        <input type="hidden" name="field_primary" value="<?php echo $field_primary ?>">
                    	<div><?php echo (validation_errors()); ?></div>
                        <div class="form-body">
                        <?php
                        $x=0;
                        foreach($field as $key=>$item){

                        if(isset($data[$key])){
                            $valueItem = $data[$key];
                        }else{
                            $valueItem=set_value($key);
                        }
                        if(is_array($item)){
                            if($item['type']=="combo"){
                                $itemInput = '<label class="control-label">'.$item['label'].'</label>
                                                <select name="'.$key.'" class="form-control" id="'.$key.'" >';
                                                foreach ($item['data'] as $indexItem => $Itemvalue) {
                                                    if($valueItem ==$Itemvalue['value'] ){
                                                        $selected = "selected";
                                                    }else{
                                                        $selected = "";
                                                    }
                                                    $itemInput .= '<option '.$selected.' value="'.$Itemvalue['value'].'">'.$Itemvalue['label'].'</option>';
                                                }
                                $itemInput .= '</select>';
                            }else if($item['type']=="date"){
                                $itemInput = '<label class="control-label">'.$item['label'].'</label>
                                        <input type="date" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="Masukan '.$item['label'].'"
                                        value ="'.$valueItem.'">';
                            }else if($item['type']=="month"){
                                $itemInput = '<label class="control-label">'.$item['label'].'</label>
                                        <input type="month" id="'.$key.'"  name="'.$key.'"    id="'.$key.'" name="'.$key.'" class="form-control" placeholder="Masukan '.$item['label'].'"
                                        value ="'.$valueItem.'">';
                            }else if($item['type']=="file"){
                                $itemInput = '<label class="control-label">'.$item['label'].'</label>
                                        <input type="file" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="Masukan '.$item['label'].'"
                                        value ="'.$valueItem.'">';
                            }
                        }else if($key=="NULL"){
                            $itemInput = '';
                        }else{
                            $itemInput = '<label class="control-label">'.$item.'</label>
                                        <input type="text" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="Masukan '.$item.'" value ="'.$valueItem.'">';
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
                            <?php if(isset($back_url)){ ?>
                                <a href="<?php echo $back_url ?>" class="btn btn-primary" >Cancel</a>
                            <?php
                            }else{
                            ?>
                            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
                            <?php
                            }    
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
	</div>
</div>
