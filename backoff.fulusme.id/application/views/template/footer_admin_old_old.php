 
    </div>
 	
 	<script src="<?php echo base_url(); ?>assets/material/plugins/jqueryui/jquery-ui.min.js"></script>
 	
 	
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/material/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jQuery.print.min.js"></script>
   
    
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url(); ?>assets/material/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url(); ?>assets/material/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url(); ?>assets/material/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo base_url(); ?>assets/material/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/sparkline/jquery.sparkline.min.js"></script>
    
    <!--Custom JavaScript -->
    <script src="<?php echo base_url(); ?>assets/material/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- chartist chart -->
    <script src="<?php echo base_url(); ?>assets/material/plugins/chartist-js/dist/chartist.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 JavaScript -->
    <script src="<?php echo base_url(); ?>assets/material/plugins/d3/d3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/c3-master/c3.min.js"></script>
    <!-- Chart JS -->
    <!-- <script src="js/dashboard1.js"></script> -->
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
       <script src="<?php echo base_url(); ?>assets/material/plugins/wizard/jquery.steps.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/wizard/jquery.validate.min.js"></script>
    <!-- Sweet-Alert  -->
    <script src="<?php echo base_url(); ?>assets/material/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/wizard/steps.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/material/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script> -->
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
	<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.js"></script>
    <!-- <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script> -->
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
	
 	
 	<script src="<?php echo base_url().'assets/material' ?>/plugins/Chart.js/Chart.min.js"></script>
 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/material/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
    

<script language="javascript">
AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
$(document).ready(function() {
    reload_select();
});
function reload_select(){
	$('select.form-control:not(.select2-custom-tags)').select2();
    $('select.select2-custom-tags').select2({
		tags: true,
		createTag: function (params) {
			return {
				id: params.term,
				text: params.term,
			}
		}
    });
}
$('#display_table2').dataTable({
   
    select: {
        style:    'os',
        selector: 'td:first-child',
        style: 'multi'
    },
	dom: 'Bfrtip',
	"bJQueryUI": true,
	"sPaginationType": "full_numbers"
});
</script>
	
<script type="text/javascript">
$(function() {
	$("#datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        regional: "id"
    }).attr('autocomplete', 'off');
    $(".datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		regional: "id"
	}).attr('autocomplete', 'off');
	$("#datepicker2").datepicker({
		dateFormat: "yy-mm-dd",
		regional: "id"
	}).attr('autocomplete', 'off');
	$("#datepicker3").datepicker({
		dateFormat: "yy-mm-dd",
		regional: "id"
	});
	$("#datepicker4").datepicker({
		dateFormat: "yy-mm-dd",
		regional: "id"
	});
	$("#datepicker5").datepicker({
		dateFormat: "yy-mm-dd",
		regional: "id"
	});
});
</script>
<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;
var myTable, myTableCheck, 
    headerStack = [ '', '', '<?php echo (isset($rpt_title)? strip_tags( $rpt_title ):""); ?>'];
    <?php
    if ( isset( $rpt_title ) ) { ?>
        headerStack.push('');
    <?php
    }
    ?>

function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
    }
    return val;
}

$(document).ready(function() {
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
     
     myTable =  $('#display_table_check').DataTable({
            columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                }],
            select: {
                style:    'os',
                selector: 'td:first-child',
                style: 'multi'
            },
		dom: 'Bfrtip',
		buttons: [
		  { 
            extend: 'excelHtml5', 
            footer: true, 
            messageTop: headerStack
          }, {
                text: 'PDF',
                action: function ( dt ) {
                    pdfTable($("#display_table_check"));
                }
            }, //{ extend: 'print', footer: true },
            {
                text: 'Print',
                action: function ( dt ) {
                    printTable($("#display_table_check"));
                }
            },'selectAll','selectNone'
		],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	});
    $("#post_all").click(function(){
        console.log(myTable);
    })
    Table =  $('.display_table_check').dataTable({
            columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                }],
            select: {
                style:    'os',
                selector: 'td:first-child',
                style: 'multi'
            },
		dom: 'Bfrtip',
		buttons: [
		  { 
            extend: 'excelHtml5', 
            footer: true, 
            messageTop: headerStack
          }, {
                text: 'PDF',
                action: function ( dt ) {
                    pdfTable($("#display_table_check"));
                }
            }, //{ extend: 'print', footer: true },
            {
                text: 'Print',
                action: function ( dt ) {
                    printTable($("#display_table_check"));
                }
            },'selectAll','selectNone'
		],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	});
    $("#post_all").click(function(){
        console.log(myTable);
    })
                        

	oTable = $('#display_table').dataTable({
		language: {
            "decimal": ",",
            "thousands": "."
        },
		dom: 'Bfrtip',
        "aaSorting": [],
		 buttons: [
            //{ extend: 'print', footer: true },
            {
                text: 'Print',
                action: function ( dt ) {
                    printTable($('#display_table'));
                }
            },
            {
                text: 'PDF',
                action: function ( dt ) {
                    pdfTable($('#display_table'));
                }
            },
            { extend: 'excelHtml5', footer: true, messageTop: headerStack }
        ],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	});

	$('.display_datatable').dataTable({
		language: {
            "decimal": ",",
            "thousands": "."
        },
		dom: 'Bfrtip',
		 buttons: [
            //{ extend: 'print', footer: true },
            {
                text: 'Print',
                action: function ( dt ) {
                    printTable($('.display_datatable'));
                }
            }, 
            { extend: 'excelHtml5', footer: true, messageTop: headerStack },
            {
                text: 'PDF',
                action: function ( dt ) {
                    pdfTable($('.display_datatable'));
                }
            }
        ],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"aaSorting": []
	});

    var boTable = $('#display_table_pembelian').dataTable({
        language: {
            "decimal": ",",
            "thousands": "."
        },
        dom: 'Bfrtip',
        "aaSorting": [],
         buttons: [
            //{ extend: 'print', footer: true },
            {
                text: 'Print',
                action: function ( dt ) {
                    printTable($('#display_table_pembelian'));
                }
            },
            {
                text: 'PDF',
                action: function ( dt ) {
                    pdfTable($('#display_table_pembelian'));
                }
            },
            { extend: 'excelHtml5', footer: true, messageTop: headerStack },
            {
                text: 'Koreksi',
                action: function ( dt ) {
                    $('#edit-jurnal-toggle').toggleClass('d-none');
                    $("html, body").animate({ scrollTop: $('#edit-jurnal-toggle').offset().top }, 600);
                }
            },
        ],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });

	oDialog = $('<div></div>')
		.dialog({
			autoOpen: false,
			title: 'Konfirmasi',
			resizable: false,
			width: 500,
			height: 150,
			modal: true,
			buttons: {
				OK: function() {
					$(this).dialog('close');
				}
			}
		});

    var timeout;
    $('body').on('change', '.number-format-val', function( event ){
        var $this = $(this);
        clearTimeout(timeout);
        timeout = setTimeout(function(){
            var formatted = commaSeparateNumber( $this.val() );
            $this.val(formatted);
        }, 800);
    });

    
});
</script>		
<script>
function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    //Add a zero in front of numbers<10
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
    var time = setTimeout(function(){ startTime() }, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}


function load_FO_data(){
    $.getJSON("<?php echo site_url() ?>/Procurement/load_FO_data",function(result){
        alert(result.message);
        $("#load_FO").show("fast");
        $("#loading_message").hide("fast")
        if(result.error==0){
            location.reload();
        }
    });
}
$(document).ready(function() {
     
    $("#load_FO").click(function(){
        $("#load_FO").hide("fast");
        $("#loading_message").show("fast")
        load_FO_data();
    })

}) 

var server_url = "<?php echo site_url() ?>";
</script>
<?php 
if(isset($js_file) && $js_file!=""){
    echo '<script src="'.base_url('assets/js/'.$js_file).'"></script>';
}
//load function fot custom datatable button
$this->load->view("template/data_table_button");
?>
	
</body>

</html>
