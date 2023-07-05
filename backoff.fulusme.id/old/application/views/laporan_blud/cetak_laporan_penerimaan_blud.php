<?php
    $this->load->view('template/header_head_cetak');
?>
<style>
table td{
    padding: 0px;
}    
.tbl_border td,
.tbl_border th{
    border: solid 1px #000000 !important;
    padding: 2px 1px;
    border-collapse: separate;
}
.tbl_no_border td{
    border: solid 0px #000000;
    padding-left: 5px;
    text-align: left;
}
</style>

<div class="card">
<div class="card-body">

<table style="width:100%;border-collapse: collapse;">
    <tr>
        <td style="border-bottom:2px solid #000;"><img src="<?php echo site_url(); ?>assets/img/logo_katingan.jpg" width="100"></td>
        <td style="border-bottom:2px solid #000;">
            <h4 class="text-center" style="margin-bottom: 2px;">PEMERINTAH KABUPATEN KATINGAN</h4>
            <h5 class="text-center" style="margin-bottom: 0;margin-top:0;">BADAN LAYANAN UMUM DAERAH<br>RSUD MAS AMSYAR KASONGAN</h5>
            <p class="text-center" style="margin-bottom: 0;margin-top: 0;"><i>Jalan Tjilik Riwut Kasongan - Telp/Fax (0536) 404104</i></p>
            <p class="text-center" style="margin-top: 0;margin-bottom: 0;">E-mail: rsud@katingankab.go.id website: http://rsud.katingankab.go.id</p>
            <p class="text-center" style="margin-top: 0;margin-bottom: 1px;"><strong>KASONGAN 74412</strong></p> 
        </td>
        <td style="border-bottom:2px solid #000;">
            <img src="<?php echo site_url(); ?>assets/img/logo_rsud_katingan.png" width="100">
        </td>
    </tr>
</table>

<h3><?php echo $this->lang->line('laporan')." ".ucfirst(str_replace("_"," ",$jenis_laporan)) ?></h3>
<h5 class="text-center">LAPORAN PENDAPATAN PEMERINTAH DAERAH<br>
KABUPATEN KATINGAN<br>
BLUD RSUD MAS AMSYAR KASONGAN<br>
LAPORAN PENDAPATAN BLUD RSUD MAS AMSYAR KASONGAN<br>
<?php echo $months." ".$years ?></h5>
 <div class="table-responsive m-t-5">
    <table id="example231" class="table display table-bordered table-striped table-responsive tbl_border" style="width: 100%;">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('anggaran') ?></th>
		<th >Uraian</th>
		<th >Anggaran Dalam DPA BLUD</th>
		<th ><?= $this->lang->line('realisasi') ?> Bulan Lalu</th>
		<th ><?= $this->lang->line('realisasi') ?> Bulan Ini</th>
		<th ><?= $this->lang->line('realisasi') ?> S.d Bulan Ini</th>
	</tr>
	</thead>	
	<tbody>
	<?php
    $jumlah_anggaran = 0;
    $jumlah_realisasi_bln_lalu = 0;
    $jumlah_realisasi_bln_ini = 0;
    $jumlah_realisasi_sd_bln_ini = 0;
	foreach ($dataLaporan as $key => $value) {
		$jumlah_anggaran += $value['nominal'];
        $jumlah_realisasi_bln_lalu += $value['last_kredit']-$value['last_debit'];
        $jumlah_realisasi_bln_ini += $value['kredit']-$value['debit'];
        $jumlah_realisasi_sd_bln_ini += $value['todate_kredit']-$value['todate_debit'];
		echo '<tr>';
		echo '<td>'.$value['mata_anggaran']." - ".$value['nama_periode'].'</td>';
		echo '<td>'.$value['nama_akun'].'</td>';
		echo '<td>'.number_format( $value['nominal'] ).'</td>';
		echo '<td>'.number_format( ($value['last_kredit']-$value['last_debit']) ).'</td>';
		echo '<td>'.number_format( ($value['kredit']-$value['debit']) ).'</td>';
		echo '<td>'.number_format( ($value['todate_kredit']-$value['todate_debit']) ).'</td>';
		echo '</tr>';
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th ><?= $this->lang->line('anggaran') ?></th>
		<th >Jumlah</th>
		<th ><?php echo number_format( $jumlah_anggaran ); ?></th>
		<th ><?php echo number_format( $jumlah_realisasi_bln_lalu ); ?></th>
        <th ><?php echo number_format( $jumlah_realisasi_bln_ini ); ?></th>
        <th ><?php echo number_format( $jumlah_realisasi_sd_bln_ini ); ?></th>
	</tr>
	</tfoot>
</table>
</div>

<table style="float:right;">
    <tr>
        <td class="text-center">
            <p>Kasongan, <?php echo date('d F Y'); ?></p>
            <p></p>
            <p>Direktur RSUD Mas Amsyar Kasongan<br>Selaku Pimpinan BLUD</p>
            <p>&nbsp;</p><p>&nbsp;</p>

            <h4 style="text-decoration: underline;"><strong>dr. AGNES NISSA PAULINA</strong></h4>
            <p>Penata Tk.I</p>
            <p>NIP. 19781118 200904 2 001</p>
        </td>
    </tr>
</table>
<div style="clear: float;"></div>

</div>
</div>

<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;

$(document).ready(function() {
$(function () {
var table = $('#example231').DataTable({
	language: {
        "decimal": ",",
        "thousands": "."
    },
	"columnDefs": [{
	"visible": false,
	"targets": 0
	}],
    dom: 'Bfrtip',
    buttons: [],
    paging: false,
    info: false,
    ordering: false,
    bFilter: false,
    "drawCallback": function (settings) {

            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
            var colonne = api.row(0).data().length;
            var totale = new Array();
            totale['Totale']= new Array();
            var groupid = -1;
            var subtotale = new Array();

                
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {     
                if ( last !== group ) {
                    groupid++;
                    $(rows).eq( i ).before(
                        '<tr class="group"><td><strong>'+group+'</strong></td></tr>'
                    );
                    last = group;
                }
                
                val = api.row(api.row($(rows).eq( i )).index()).data();      //current order index
                $.each(val,function(index2,val2){
                        if (typeof subtotale[groupid] =='undefined'){
                            subtotale[groupid] = new Array();
                        }
                        if (typeof subtotale[groupid][index2] =='undefined'){
                            subtotale[groupid][index2] = 0;
                        }
                        if (typeof totale['Totale'][index2] =='undefined'){ totale['Totale'][index2] = 0; }
                        
                        valore = Number(val2.replace('€',"").replace(/[.]/g,"").replace(/[,]/g,""));
                        subtotale[groupid][index2] += valore;
                        totale['Totale'][index2] += valore;
                });
                
            } );                

            var display_cur = $.fn.dataTable.render.number( ',', '.', 0 ).display;
			$('tbody').find('.group').each(function (i,v) {
                    var rowCount = $(this).nextUntil('.group').length;
        		$(this).find('td:first').append($('<span />', { 'class': 'rowCount-grid' }).append($('<b />', { 'text': '' })));
                         var subtd = '';
                        for (var a=2;a<colonne;a++)
                        { 
                            subtd += '<td>'+ display_cur( subtotale[i][a] )+' '+'</td>';
                        }
                        $(this).append(subtd);
                });
	}
	});
});
});
</script>

<div>
<?php  $this->load->view("template/footer_admin"); ?>