<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <!-- Page title -->
    <title><?php echo $this->config->item("company_name"); ?></title>

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/material/css/style.css" rel="stylesheet">

    <style type="text/css">
        /*! normalize.css v7.0.0 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,footer,header,nav,section{display:block}h1{font-size:2em;margin:.67em 0}figcaption,figure,main{display:block}figure{margin:1em 40px}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent;-webkit-text-decoration-skip:objects}abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}b,strong{font-weight:inherit}b,strong{font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}dfn{font-style:italic}mark{background-color:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}audio,video{display:inline-block}audio:not([controls]){display:none;height:0}img{border-style:none}svg:not(:root){overflow:hidden}button,input,optgroup,select,textarea{font-family:sans-serif;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}[type=reset],[type=submit],button,html [type=button]{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{border-style:none;padding:0}[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:.35em .75em .625em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{display:inline-block;vertical-align:baseline}textarea{overflow:auto}[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details,menu{display:block}summary{display:list-item}canvas{display:inline-block}template{display:none}[hidden]{display:none}/*# sourceMappingURL=normalize.min.css.map */
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-uppercase {
            text-transform: uppercase;
        }
        .bold {
            font-weight: bold;
        }
        .border-top {
            border-top: 1px solid #000;
            padding-top: 8px;
        }
        .indent-1 {
            padding-left: 10px;
        }
        .indent-2 {
            padding-left: 20px;
        }
        .indent-3 {
            padding-left: 30px;
        }
        .indent-4 {
            padding-left: 40px;
        }
        .indent-5 {
            padding-left: 50px;
        }
        .indent-6 {
            padding-left: 60px;
        }
        .indent-7 {
            padding-left: 70px;
        }
        * {
            box-sizing: border-box;
        }
        .row {
            height: auto;
            position: relative;
            display: block;
        }
        .row::after {
            content: "";
            clear: both;
            display: table;
        }
        .row [class*="col-"] {
            float: left;
            padding: 15px;
        }
        .row.no-gutters > [class*="col-"] {
            padding: 0;
        }
        .row > .col-1 {width: 8.33%;}
        .row > .col-2 {width: 16.66%;}
        .row > .col-3 {width: 25%;}
        .row > .col-4 {width: 33.33%;}
        .row > .col-5 {width: 41.66%;}
        .row > .col-6 {width: 50%;}
        .row > .col-7 {width: 58.33%;}
        .row > .col-8 {width: 66.66%;}
        .row > .col-9 {width: 75%;}
        .row > .col-10 {width: 83.33%;}
        .row > .col-11 {width: 91.66%;}
        .row > .col-12 {width: 100%;}
        table {
            border-collapse: separate;
            border-spacing: 15px 7px;
            font-size: 12px;
            width: 100%;
        }
        .th-head {
            border-bottom:1px solid #003366;
            color:#003366;
            padding-bottom: 8px;
        }
        .treegrid-indent {
            width: 0px;
            height: 16px;
            display: inline-block;
            position: relative;
        }
        .treegrid-expander {
            width: 0px;
            height: 16px;
            display: inline-block;
            position: relative;
            left: -17px;
            cursor: pointer;
        }
        .d-none {
            display: none;
        }
    </style>

    <base target="_blank">
</head>
<body>