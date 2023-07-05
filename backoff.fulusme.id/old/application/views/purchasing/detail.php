<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var bln = $('#bulan').val();
			var thn = $('#tahun').val();
			oTable.fnClearTable();
			$.post('<?php echo site_url().'invoice/search' ?>',
				  { bulan : bln, tahun : thn},
				  function(msg){
					if(msg) {
						msg = eval(msg);
						oTable.fnAddData(msg);
					}
				  }
			  );
		});
	});
</script>

<div class="post-title"><h2><a href="#"><?php echo $title; ?></a></h2></div>

<div class="post-body">

<fieldset>
<table width="100%">
<tr>
	<td width="33%" valign="top">
        <table width="100%">
        <tr>
            <td width="20%">No Invoice</td>
            <td width="5">:</td>
            <td>
            <input  type="hidden" name="trxID" value="<?= $trx->trxID ?>" id="trxID" size="20" maxlength="20" />
            <label><b><?= $trx->invoiceID ?></b></label>
            </td>
        </tr>
        <tr>    
            <td>Nama Costumer</td>
            <td>:</td>
            <td>
            <label><b><?= $trx->trxFullName ?></b></label>
            </td>
        </tr>
        <tr>
            <td width="20%">Alamat</td>
            <td width="5">:</td>
            <td>
             <label><b><?= $trx->trxAddress ?></b></label>
            </td>
        </tr>
        <tr>    
            <td>Telepon</td>
            <td>:</td>
            <td>
             <label><b><?= $trx->trxPhone ?></b></label>
            </td>
        </tr>
        </table>
	</td>
    <td width="35%" valign="top">
        <table width="100%">
        <tr>
            <td width="40%">Merek Mobil</td>
            <td width="5">:</td>
            <td>
             <label><b><?= $trx->merk ?></b></label>
            </td>
        </tr>
        <tr>    
            <td>Tahun Mobil</td>
            <td>:</td>
            <td>
             <label><b><?= $trx->year_vech ?></b></label>
            </td>
        </tr>
         <tr>    
            <td>No Plat</td>
            <td>:</td>
            <td>
             <label><b><?= $trx->nopol ?></b></label>
            </td>
        </tr>
          <tr>    
            <td>No Chasis</td>
            <td>:</td>
            <td>
             <label><b><?= $trx->chasis_no ?></b></label>
            </td>
        </tr>

          <tr>    
            <td>No Engine</td>
            <td>:</td>
            <td>
             <label><b><?= $trx->engine_no ?></b></label>
            </td>
        </tr>
        </table>
	</td>
	<td width="33%" valign="top">
        <table width="100%">
        <tr>
            <td width="40%">Tanggal Keluar</td>
            <td width="5">:</td>
            <td>
             <label><b><?= $this->app_model->tgl_indo($trx->trxInDate) ?></b></label>
            </td>
        </tr>
        <tr>    
            <td>Tanggal Masuk</td>
            <td>:</td>
            <td>
             <label><b><?= $this->app_model->tgl_indo($trx->trxOutDate) ?></b></label>
            </td>
        </tr>
         <tr>    
            <td>Kilometer</td>
            <td>:</td>
            <td>
             <label><b><?= $trx->kilometer ?></b> <sup>km</sup></label>
            </td>
        
        </table>
	</td>
</tr>
</table>            
</fieldset><br/>
</div>		
