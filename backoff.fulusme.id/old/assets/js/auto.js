
    
	//Auto Produk
	$(function () {
        $("#kode").autocomplete({    
            minLength:0,
            delay:0,
            source:'<?php echo site_url('auto/get_produk'); ?>', 
            select:function(event, ui){
                $('#nama').val(ui.item.nama);
                $('#ibukota').val(ui.item.ibukota);
                $('#ket').val(ui.item.keterangan);
                }
            });
        });