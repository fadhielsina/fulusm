<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>FulusMeBackend</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
    <link href="<?php echo base_url(); ?>assets/material/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- chartist CSS -->
    <link href="<?php echo base_url(); ?>assets/material/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/material/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/material/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="<?php echo base_url(); ?>assets/material/plugins/c3-master/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/material/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url(); ?>assets/material/css/colors/purple-dark.css" id="theme" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/material/plugins/wizard/steps.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="<?php echo base_url(); ?>assets/material/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url(); ?>assets/material/plugins/jquery/jquery.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/material/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <style>
        [type="radio"] {
            opacity: 1 !important;
            left: 0px !important;
            position: relative !important;
        }

        .laporan-iframe {
            background: rgb(102, 102, 102);
            padding: 20px 60px;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .laporan-iframe iframe {
            width: 100%;
            height: 100%;
            background: #fff;
        }

        .table-harta-tetap input[type="text"] {
            width: 100%;
        }

        span.d-pop {
            border-bottom: 1px dashed #428bca;
        }

        .custom-checkbox label {
            position: relative;
        }

        .custom-checkbox [type="checkbox"]:not(:checked),
        .custom-checkbox [type="checkbox"]:checked {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }
    </style>
    <link href="<?php echo base_url(); ?>assets/material/plugins/jqueryui/jquery-ui.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <link href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>js/action.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jurnal.js"></script>
    <link href="<?php echo base_url(); ?>assets/material/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/material/plugins/jqueryui/jquery-ui.min.js"></script>