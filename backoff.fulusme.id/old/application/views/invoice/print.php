<!-- Content Wrapper. Contains page content -->
<style>
table {
  border: 1px solid #4286f4;
  width:100%;
  margin-bottom:0.2em;
  font-size:0.7em;
  font-family: Arial, Helvetica, sans-serif;
}

table.sum {
 background: #4286f4;
 padding:6px;
  width:100%;
  margin-bottom:0.2em;
  font-size:0.6em;
  color:#fff;
  font-weight:bold;
}
</style>     
	 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
         
          <ol class="breadcrumb">
           
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          	<div class="row">          	
          	<div class="col-xs-12">
          		<div class="box">
                <div class="box-header">
                  <h3 class="box-title">
				  
                  </h3>
                  <div class="box-tools">
                  
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
				<h1 style="font-size:1.4em;color:#4286f4;text-shadow: 4px 4px 2px rgba(150, 150, 150, 1);"><b>KWITANSI</b></h1>
				<div class="col-md-12">
				<table width="100%" >
				<tr>
					  <td >Sudah Terima Dari : <b> <?php echo $customer; ?></b></td>
					  </tr>
				</table>
				  <table >
						<tr >
						<td>
						<b>Banyaknya Uang : </b>
						
						<i><?php echo terbilang($total); ?> </i>
						</td>
						</tr>
				  </table>
				  <table >
						<tr >
						<td >
						<b>Untuk Pembayaran : </b>
						
						<p></p>
						<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
						</td>
						</tr>
				  </table>
				  <table >
						<tr >
						<td >
						<h2>RP &nbsp;&nbsp;&nbsp; <b class="border: 1px solid #4286f4;"><?php echo number_format($total); ?></b></h2>
						<br/><br/>
						<p>Bank &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :.............................................</p>
						<p>No Rek. &nbsp;&nbsp;&nbsp;&nbsp; :.............................................</p>
						<p>Tanggal &nbsp;&nbsp;&nbsp;&nbsp; :.............................................</p>
						</td>
						<td align="center">
						Bandung, <?php echo mediumdate_indo($tgltrx); ?>
						<br/><br/><br/><br/><br/><br/><br/>
						<b class="border-bottom:2px solid #000;">DIDA WIRAMIHARDJA<b/><br/>
						Direktur
						</td>
						</tr>
				  </table>
				   <table class="sum">
						<tr >
						<td >
						<center>KWITANSI INI ADALAH SAH APABILA CEK/GIRO YANG DITITIPKAN DAPAT DICAIRKAN/DIUANGKAN</center>
						</td>
						
						</tr>
				  </table>
                </div><!-- /.box-body -->
                </div>
             </div>
          </div>
        

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
