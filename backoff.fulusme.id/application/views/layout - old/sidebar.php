<div class="right sidebar" id="sidebar">

	<?php if($this->session->userdata('ADMIN')) { ?>
		<div class="section">

			<div class="section-title">Manajemen</div>

			<div class="section-content">

				<ul class="nice-list">
					<li><?php echo anchor(site_url()."user", 'Pengguna &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."pajak", 'Data Wajib Pajak &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."akun", 'Akun &#187;', 'class="more"'); ?></li>												
					<li><?php echo anchor(site_url()."akun/saldo_awal", 'Saldo Awal &#187;', 'class="more"'); ?></li>												
				</ul>

			</div>

		</div>
	<?php } ?>
	<div class="section">

			<div class="section-title">Master</div>
			<div class="section-content">
				<ul class="nice-list">
					<li><?php echo anchor(site_url()."klien", 'Klien &#187;', 'class="more"'); ?></li>	
					<li><?php echo anchor(site_url()."vehicles", 'Kendaraan &#187;', 'class="more"'); ?></li>						
				</ul>
			</div>

		</div>
	<div class="section">

			<div class="section-title">Transaksi / Invoice</div>

			<div class="section-content">

				<ul class="nice-list">
					<li><?php echo anchor(site_url()."invoice", 'Data Invoice &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."invoice/invoice_add", 'Tambah Invoice &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."invoice/invoice_kasir", 'Invoice Pending &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."invoice/invoice_piutang", 'Buku Piutang &#187;', 'class="more"'); ?></li>					
				</ul>

			</div>

		</div>
		<div class="section">

			<div class="section-title">KAS</div>

			<div class="section-content">

				<ul class="nice-list">
					<li><?php echo anchor(site_url()."akun/detail_akun", 'Kas Masuk &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal", 'Kas Keluar &#187;', 'class="more"'); ?></li>					
				</ul>

			</div>

		</div>
		<div class="section">

			<div class="section-title">Akuntansi</div>

			<div class="section-content">

				<ul class="nice-list">
					<li><?php echo anchor(site_url()."akun/detail_akun", 'Buku Besar &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal", 'Jurnal &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal/jurnal_umum", 'Jurnal Umum &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal/jurnal_penyesuaian", 'Jurnal Penyesuaian &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal/jurnal_penutup", 'Jurnal Penutup &#187;', 'class="more"'); ?></li>							
				</ul>

			</div>

		</div>
		
		<div class="section">

			<div class="section-title">Laporan</div>

			<div class="section-content">

				<ul class="nice-list">
					<li><?php echo anchor(site_url()."laporan_keuangan/lap_pendapatan", 'Laporan KAS &#187;', 'class="more"'); ?></li>	
					<li><?php echo anchor(site_url()."laporan_keuangan/lap_pendapatan_bank", 'Laporan Pendapatan &#187;', 'class="more"'); ?></li>		</ul>

			</div>

		</div>
						
</div>
