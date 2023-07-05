	
	<script src="<?php echo base_url(); ?>assets/material/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/javascript.js"></script>
	<script type="text/javascript">
		function commaSeparateNumber(val) {
		    while (/(\d+)(\d{3})/.test(val.toString())) {
		        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
		    }
		    return val;
		}
		function makeParentNumber( $this, start, to ) {
			$this.children('tr[data-level="'+ start +'"]').each(function(){
				var nom = $(this).parent().children('tr[data-level="'+ to +'"]').find('.saldo-now a').map(function(){
					return $(this).text().replace(/\,/g, '');
				}).get(),
					nom_last = $(this).parent().children('tr[data-level="'+ to +'"]').find('.saldo-last a').map(function(){
						return $(this).text().replace(/\,/g, '');
					}).get();

				nom = nom.reduce((a, b) => parseInt(a) + parseInt(b), 0);
				nom_last = nom_last.reduce((a, b) => parseInt(a) + parseInt(b), 0);
				
				if ( typeof nom != 'undefined' ) {
					nom = commaSeparateNumber( nom );
				}
				if ( typeof nom_last != 'undefined' ) {
					nom_last = commaSeparateNumber( nom_last );
				}

				$(this).find('.saldo-last a').text( nom_last ).end().
				find('.saldo-now a').text( nom );
				console.log( nom, nom_last, 'nilai');
			});
		}

		$('.table-nom-parent > tbody').each(function(){
			var $this = $(this);
			$this.children('tr[data-level="2"]').each(function(){
				var nom = $(this).nextUntil('tr[data-level="2"]').find('.saldo-now a').map(function(){
						return $(this).text().replace(/\,/g, '');
					}).get(),
					nom_last = $(this).nextUntil('tr[data-level="2"]').find('.saldo-last a').map(function(){
						return $(this).text().replace(/\,/g, '');
					}).get();
				
				nom = nom.reduce((a, b) => parseInt(a) + parseInt(b), 0);
				nom_last = nom_last.reduce((a, b) => parseInt(a) + parseInt(b), 0);
				
				if ( typeof nom != 'undefined' ) {
					nom = commaSeparateNumber( nom );
				}
				if ( typeof nom_last != 'undefined' ) {
					nom_last = commaSeparateNumber( nom_last );
				}
				
				$(this).find('.saldo-last a').text( nom_last ).end().
				find('.saldo-now a').text( nom );
			});

			makeParentNumber($this, 1, 2);
			//makeParentNumber($this, 1, 2);
			//makeParentNumber($this, 0, 2);
			
		});
	</script>
	</body>
</html>