<?php
    /* Mengambil query report*/
        foreach($report as $result){
        $bulan[] = $result->trxDate; //ambil bulan
        $value[] = (float) $result->total; //ambil nilai
          }
    /* end mengambil query*/
     
       ?>

$(function () {

    $('#report').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: false,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'Penjualan Per-hari',
            style: {
                    fontSize: '18px',
                    fontFamily: 'Verdana, sans-serif'
            }
        },
     otOptions: {
            column: {
                depth: 25
            }
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories:  <?php echo json_encode($bulan);?>
        },
        exporting: { 
            enabled: false 
        },
        yAxis: {
            title: {
                text: 'Jumlah Rp.'
            },
        },
        tooltip: {
             formatter: function() {
                 return 'Pendapatan untuk Tanggal <b>' + this.x + '</b> Rp. <b>' + Highcharts.numberFormat(this.y,0) + '</b>,  ';
             }
          },
        series: [{
            name: 'Tanggal',
            data: <?php echo json_encode($value);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#045396',
                align: 'center',
                formatter: function() {
                     return Highcharts.numberFormat(this.y, 0);
                }, // one decimal
                y: 0, // 10 pixels down from the top
                style: {
                    fontSize: '16px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
});
       