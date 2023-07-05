
<div class="card"> 
<div class="card-header">
    <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
        <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area'));"><i class="mdi mdi-printer"></i></button>
        <!-- <button type="button" class="btn btn-secondary"  onClick="printTable($('#example231'));"><i class="mdi mdi-file-excel"></i></button> -->
        <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area'));"><i class="mdi mdi-file-pdf"></i></button> 
    </div>
    </div>
</div>  
<div class="card-body">
<h3><?php echo $this->lang->line('laporan')." ".ucfirst(str_replace("_"," ",$jenis_laporan)) ?></h3>
<h4>Periode : <?php echo $months." ".$years ?></h4>
  <div class="table-responsive m-t-5"  style="background-color:#767779;padding: 10px; ">
    <table id="report_area" class="table table-bordered no-wrap"  style="background-color:white; ">
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
</div>
</div>

<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog,
    headerStack = [ 'Katingan', 'RSUD Mas Amsyar Kasongan', 'LAPORAN PENDAPATAN BLUD', '<?php echo 'Periode : ' . $months . ' ' . $years; ?>'];

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
    buttons: [
        { extend: 'excelHtml5', footer: true, messageTop: headerStack },
        {
            text: 'Print',
            action: function ( e, dt, node, config ) {
                var myWindow = window.open('<?php echo site_url(); ?>laporan/cetak_print/penerimaan_blud/<?php echo $p_bulan .'/' . $p_tahun; ?>' , '_blank');
                myWindow.focus();
                myWindow.onload = function(){
                    myWindow.print();
                };
            }
        },
        {
            text: 'PDF',
            action: function ( e, dt, node, config ) {
                window.open('<?php echo site_url(); ?>laporan/cetak_pdf/penerimaan_blud/<?php echo $p_bulan .'/' . $p_tahun; ?>', '_blank');
            }
        }
    ],
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
                        '<tr class="group" style="background-color:#007bff;color:#FFFF"><td>'+group+'</td></tr>'
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