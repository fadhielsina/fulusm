
<div class="card">
<div class="card-body">
<h3><?= $this->lang->line('laporan_operasional') ?> </h3>
<h4>Period : <?php echo $months." ".$years ?></h4>
<br>
<br>
 <div class="table-responsive m-t-5">
 	<?php
 	//$Operasional = 0;
 	//foreach($dataLaporan as $index=>$item){
 	?>

 	<h3><?php //echo strtoupper($index) ?></h3>
 	<table id="example23" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		
		 
		<th width="10%"> </th>
		<th width="30%"><?= $this->lang->line('nama_akun') ?></th>
		<th width="20%"><?= $this->lang->line('debit') ?></th>
		<th width="20%"><?= $this->lang->line('kredit') ?></th>
		<th width="20%"  class="text-right"><?= $this->lang->line('total') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
		$no = 1;
		$Totsaldo = 0;

		foreach ($dataLaporan as $key => $value) {
			//var_dump($value);die();
			echo '<tr>';	
			$saldo = $value['kredit'] - $value['debit'];
			echo '
				 
				<td >'.$value['grouping'].'</td>
				
				<td >'.$value['nama'].'</td>
				<td >'.($value['debit']).'</td>
				<td >'.($value['kredit']).'</td>
				<td align="right">'.number_format($saldo).'</td>';
			echo '</tr>';		

			$Totsaldo += $saldo;
		}
		/*if($index =="kewajiban"){
			$Operasional -= $Totsaldo;
		}else{
			$Operasional += $Totsaldo;
		}*/
	?>
	</tbody>
	<tfoot>
	<tr>
		<th colspan="4">Total Operasional <?php //echo $index ?></th>
		<th class="text-right"><?php echo ($Totsaldo) ?></th>
	</tr>
	</tfoot>
	</table>
<?php
//}
?>
<!-- <div class="row" style="background:#1e88e5;color:#FFFF;font-size: 25px;">
	<div class="col-md-9 text-right "><?= $this->lang->line('total_operasional') ?></div>
	<div class = "col-md-3 text-right ">Rp. <?php //echo number_format($Operasional) ?></div>
</div> -->
</div>
</div>
</div>

<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;

$(document).ready(function() {
  var table = $('#example23').DataTable({
	"columnDefs": [{
		"visible": false,
		"targets": 0
		},
		{
			"targets":2,
			"render": $.fn.dataTable.render.number(  ',', '.', 2, ''  )
		}
		],
	
	
		dom: 'Bfrtip',
					buttons: [
         {
            text: 'Print',
            action: function ( dt ) {
                printTable($('#example23'));
            }
        },
        { extend: 'excelHtml5', footer: true },
        {
            text: 'PDF',
            action: function ( dt ) {
                pdfTable($('#example23'));
            }
        }
    ],
	 "displayLength": 2000,
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
                        '<tr class="group" colspan="3" style="background-color:#007bff;color:#FFFF"><td>'+group+'</td></tr>'
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
                        
                        valore = Number(val2.replace('€',"").replace('.',"").replace(',',"."));
                        subtotale[groupid][index2] += valore;
                        totale['Totale'][index2] += valore;
                });
                
            } );                
			$('tbody').find('.group').each(function (i,v) {
                    var rowCount = $(this).nextUntil('.group').length;
        		$(this).find('td:first').append($('<span />', { 'class': 'rowCount-grid' }).append($('<b />', { 'text': ' ' })));
                         var subtd = '';
                        for (var a=2;a<colonne;a++)
                        { 
                            subtd += '<td colspan="">'+subtotale[i][a]+' '+'</td>';
                        }
                        $(this).append(subtd);
                });
	}
	});

});

var HeaderRpt ="<?php echo '<h2 style=\'text-align:center\'>Katingan <br> RSUD MAS AMSYAR KASONGAN </h2>'; echo (isset($rpt_title)?str_replace('"',"'", $rpt_title):"") ?><hr>";

	function printTable($table,$titel=""){
		//alert($table);
		if($titel!=""){
			HeaderRptCetak = $titel;
		}else{
			HeaderRptCetak = HeaderRpt
		}
		$($table).print({
		    addGlobalStyles : true,
		    stylesheet : null,
		    rejectWindow : true,
		    noPrintSelector : ".no-print",
		    iframe : true,
		    append : null,
		    prepend : HeaderRptCetak
		});
	}
	function pdfTable($table){

		var cnt = $table.clone().wrap('<p>').parent().html();
		cntContent = $(cnt).find(".no-print").remove().end().wrap('<p>').parent().html();
		var data = {
			table :HeaderRpt +""+cntContent,
			rpt_name :""
		}
		$.post("<?php echo site_url('laporan/cetak_pdf_from_table') ?>",data,function(resultData){
			result = JSON.parse(resultData)
			if(result.error==0){
				var myWindow = window.open("<?php echo base_url() ?>/"+result.data, HeaderRpt, "width=1000,height=800");
			}
		})
		 
	}
</script>