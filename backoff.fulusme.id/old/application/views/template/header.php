<?php
$this->load->view('template/header_head');
?>
		
		<script type="text/javascript">
		$(function() {
			var dates = $('#datepicker-from, #datepicker-to').datepicker({
				defaultDate: "+1w",
				dateFormat: "yy-mm-dd",
				regional: "id",
				changeMonth: true,
				numberOfMonths: 3,
				onSelect: function(selectedDate) {
					var option = this.id == "datepicker-from" ? "minDate" : "maxDate";
					var instance = $(this).data("datepicker");
					var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
					dates.not(this).datepicker("option", option, date);
				}
			});
		});
		</script>
		<script type="text/javascript" charset="utf-8">
		$(function() {
				$('#button-view').button({
					icons: {
						primary: 'ui-icon-document'
					}
				});
				$('#button-edit').button({
					icons: {
						primary: 'ui-icon-pencil'
					}
				});
				$('#button-delete').button({
					icons: {
						primary: 'ui-icon-trash'
					}
				});
				$('#button-addnew').button({
					icons: {
						primary: 'ui-icon-plus'
					}
				});
				$('#button-save').button();
				$('#button-cancel').button();
				$('#button-print').button();
				$('#button-reset').button();
			});
		</script>
		
		
</head>

   
<body class="fix-header fix-sidebar card-no-border" onload="startTime()">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">