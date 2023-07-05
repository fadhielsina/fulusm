
<script src="<?php echo base_url(); ?>js/jquery.table2excel.min.js"></script>
<script type="text/javascript">
var oTable;
var oDialog;

$(document).ready(function() {
$(function () {
if ( ! $.fn.DataTable.isDataTable( '#example23' ) ) {
	
	var regex = /^[0-9]+(\.[0-9]{1,3})+(\.[0-9]{1,3})?$/,
		table = $('#example23').DataTable({
		"columnDefs": [{
		"visible": true,
		"targets": 0
		},
		{
			"render": function (data, type, row) { 
				if ( 'export' == type && regex.test(data) ) {
					return data.replace( /[$,.]/g, '' );
				}
				if(typeof data == 'number'){
                	return commaSeparateNumber(data);
             	}else{
             		return data;
             	}
	        },
	        "targets": '_all'
		}],
		'aaSorting' : [],
	    language: {
	        "decimal": ",",
	        "thousands": "."
	    },
		dom: 'Bfrtip',
		buttons: [
	        {
	            text: 'Print',
	            action: function ( dt ) {
	                printTable($('#example23'));
	            }
	        },
	        { extend: 'excelHtml5', footer: true, exportOptions: { orthogonal: 'export' } },
	        {
	            text: 'PDF',
	            action: function ( dt ) {
	                pdfTable($('#example23'));
	            }
	        }
	    ]
		});
}
});

});

	var headerImg = '<table style="width:100%;text-align:center;border-collapse: separate;border-spacing: 15px 4px;">'+
    		'<tr><td><img src="<?php echo base_url(); ?>assets/img/logo_amor.png" width="120"></td>'+
        	'<td>'+
            '<h5 align="center" style="margin:0;color:#000;">CV. Amor Group</h5>'+
            '<p align="center" style="margin:0;font-size:10px;color:#000;"><i>Jalan Pajagalan Kompleks, Ruko Danalaga Square Blok I-22</i></p>'+
            '<p align="center" style="margin:0;font-size:10px;color:#000;">Telpon: 0857-9413-8333</p>'+
            '<p align="center" style="margin:0;font-size:10px;color:#000;"><strong>Kelurahan, Nyomplong, Kec. Warudoyong, Kota Sukabumi, Jawa Barat 43131</strong></p> '+
        	'</td><td style="text-align:right;">'+
            '</td></tr></table><hr>';
	var HeaderRpt = headerImg +"<?php echo (isset($rpt_title)?str_replace("h1", "h3", str_replace("h3", "h4", $rpt_title)):((isset($title))?"<h4 align='center' style='color:#000;'>".$title."</h4>":"")) ?>";

	function printTable($table,$titel=""){
		//alert($table);
		if($titel!=""){
			HeaderRptCetak = headerImg+$titel;
		}else{
			HeaderRptCetak = HeaderRpt
		}
		$($table).print({
		    addGlobalStyles : true,
		    stylesheet : "<?php echo base_url(); ?>assets/css/print_area.css",
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
		//cntContent = $(cnt).removeAttr("style").wrap('<p>').parent().html();
		//cntContent = $(cnt).attr("width","80%").wrap('<p>').parent().html();
		//cntContent = $(cnt).attr("style","width:80% !important").wrap('<p>').parent().html();
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
	function excelTable($table) {
		var cnt = $table.clone().wrap('<p>').parent().html(); 
		cntContent = $(cnt).find(".no-print").remove().end().wrap('<p>').parent().html();
 
		var table = cntContent
		//if(table && table.length){
			//var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
			$(table).table2excel({
				exclude: ".noExl",
				name: "Excel Document Name",
				filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
				fileext: ".xls",
				exclude_img: true,
				exclude_links: true,
				exclude_inputs: true,
				//preserveColors: preserveColors
			});
		//}
		
	}

	$(function () {
		var cetak_type = 'view';
		$('#laporan-iframe').on('load', function(){
			$('#spinner-loader').hide();
			$('#laporan-card').slideDown();
			$(this).height($(this)[0].contentWindow.document.body.scrollHeight + 60 +'px' );
		});
		
		$('#form_laporan').on('submit', function( event ){
			if ( 'view' === cetak_type ) {
				event.preventDefault();
				$('#spinner-loader').show();
				$('#laporan-card').slideUp();
				$.post($(this).prop('action'), $(this).serialize(),function(result){
					$("#laporan-iframe").prop('srcdoc', result);
				});
			}
		});

		$('.btn-laporan-export').on('click', function( event ){
			event.preventDefault();
			var type = $(this).data('export');
			if ( 'print' === type ) {
				printTable($('#laporan-iframe').contents().find("table"));
			}
			if ( 'pdf' === type ) {
				pdfTable($('#laporan-iframe').contents().find("table"));
			}
			if ( 'excel' === type ) {
				excelTable($('#laporan-iframe').contents().find("table"));
			}
		});
	});
	
</script>