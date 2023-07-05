
	</section>

	<!-- Site Footer --><footer class="site-footer" style="color: white;
    background-color: #671316;">
		<!-- dbdae5 -->

		

		<div class="container">

			<div class="row">

				<div class="col-sm-6">
					<span>Copyright &copy; fulusme.id <?php echo date("Y"); ?></span>
				</div>

				<div class="col-sm-6">

					<ul class="social-networks text-right">
						<li>
							<a href="#">
								<i class="entypo-instagram"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="entypo-twitter"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="entypo-facebook"></i>
							</a>
						</li>
					</ul>

				</div>

			</div>

		</div>

	</footer>	
</div>


<!-- Bottom Scripts -->
<script src="<?= base_url('assetsprofile/')?>asset/js/gsap/main-gsap.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?= base_url('assetsprofile/')?>asset/js/joinable.js"></script>
<script src="<?= base_url('assetsprofile/')?>asset/js/resizeable.js"></script>
<script src="<?= base_url('assetsprofile/')?>asset/js/neon-slider.js"></script>
<script src="<?= base_url('assetsprofile/')?>asset/js/neon-custom.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
<script>

	$("#min0").click(function(){
		var nilaiAwal = $("#val0").html().replace('Rp.','').replace('.','').replace('.','').replace('.','');
		var nilaiLot = $("#nilaiLot0").html();
		var unit = $("#unit0").val();
		if(parseInt($("#unit0").val()) >= 2 ){
			nilaiAwal = parseInt(nilaiAwal) - parseInt(nilaiLot)
			unit = nilaiAwal/nilaiLot
			$("#unit0").val(nilaiAwal/nilaiLot)
			$("#val0").html("Rp."+nilaiAwal.toLocaleString().replace(',','.').replace(',','.'));
		}
	});

	$("#unit0").change(function(){
		if($("#unit0").val()>parseInt($("#jumlot0").html())){
			$("#unit0").val(parseInt($("#jumlot0").html()));
		}else if ($("#unit0").val()<=0 || $("#unit0").val() === "" ){
			$("#unit0").val(1);
		}
		var nilaiLot = parseInt($("#unit0").val()) * parseInt($("#nilaiLot0").html()) ;
		$("#val0").html("Rp."+nilaiLot.toLocaleString().replace(',','.').toLocaleString().replace(',','.').toLocaleString().replace(',','.'));

	});

	$("#add0").click(function(){
		var nilaiAwal = $("#val0").html().replace('Rp.','').replace('.','').replace('.','').replace('.','');
		var nilaiLot = $("#nilaiLot0").html();
		var unit = $("#unit0").val();
		if(parseInt($("#unit0").val()) < parseInt($("#jumlot0").html())){
			nilaiAwal = parseInt(nilaiAwal) + parseInt(nilaiLot)
			unit = nilaiAwal/nilaiLot
			$("#unit0").val(nilaiAwal/nilaiLot)
			$("#val0").html("Rp."+nilaiAwal.toLocaleString().replace(',','.').replace(',','.'));
		}
	});


	$("#min1").click(function(){
		var nilaiAwal = $("#val1").html().replace('Rp.','').replace('.','').replace('.','').replace('.','');
		var nilaiLot = $("#nilaiLot1").html();
		var unit = $("#unit1").val();
		if(parseInt($("#unit1").val()) >= 2 ){
			nilaiAwal = parseInt(nilaiAwal) - parseInt(nilaiLot)
			unit = nilaiAwal/nilaiLot
			$("#unit1").val(nilaiAwal/nilaiLot)
			$("#val1").html("Rp."+nilaiAwal.toLocaleString().replace(',','.').replace(',','.'));
		}
	});

	$("#unit1").change(function(){
		if($("#unit1").val()>parseInt($("#jumlot1").html())){
			$("#unit1").val(parseInt($("#jumlot1").html()));
		}else if ($("#unit1").val()<=0 || $("#unit1").val() === "" ){
			$("#unit1").val(1);
		}
		var nilaiLot = parseInt($("#unit1").val()) * parseInt($("#nilaiLot1").html()) ;
		$("#val1").html("Rp."+nilaiLot.toLocaleString().replace(',','.').toLocaleString().replace(',','.').toLocaleString().replace(',','.'));

	});

	$("#add1").click(function(){
		var nilaiAwal = $("#val1").html().replace('Rp.','').replace('.','').replace('.','').replace('.','');
		var nilaiLot = $("#nilaiLot1").html();
		var unit = $("#unit1").val();
		if(parseInt($("#unit1").val()) < parseInt($("#jumlot1").html())){
			nilaiAwal = parseInt(nilaiAwal) + parseInt(nilaiLot)
			unit = nilaiAwal/nilaiLot
			$("#unit1").val(nilaiAwal/nilaiLot)
			$("#val1").html("Rp."+nilaiAwal.toLocaleString().replace(',','.').replace(',','.'));
		}
	});


	$("#min2").click(function(){
		var nilaiAwal = $("#val2").html().replace('Rp.','').replace('.','').replace('.','').replace('.','');
		var nilaiLot = $("#nilaiLot2").html();
		var unit = $("#unit2").val();
		if(parseInt($("#unit2").val()) >= 2 ){
			nilaiAwal = parseInt(nilaiAwal) - parseInt(nilaiLot)
			unit = nilaiAwal/nilaiLot
			$("#unit2").val(nilaiAwal/nilaiLot)
			$("#val2").html("Rp."+nilaiAwal.toLocaleString().replace(',','.').replace(',','.'));
		}
	});

	$("#unit2").change(function(){
		if($("#unit2").val()>parseInt($("#jumlot2").html())){
			$("#unit2").val(parseInt($("#jumlot2").html()));
		}else if ($("#unit2").val()<=0 || $("#unit2").val() === "" ){
			$("#unit2").val(1);
		}
		var nilaiLot = parseInt($("#unit2").val()) * parseInt($("#nilaiLot2").html()) ;
		$("#val2").html("Rp."+nilaiLot.toLocaleString().replace(',','.').toLocaleString().replace(',','.').toLocaleString().replace(',','.'));

	});

	$("#add2").click(function(){
		var nilaiAwal = $("#val2").html().replace('Rp.','').replace('.','').replace('.','').replace('.','');
		var nilaiLot = $("#nilaiLot2").html();
		var unit = $("#unit2").val();
		if(parseInt($("#unit2").val()) < parseInt($("#jumlot2").html())){
			nilaiAwal = parseInt(nilaiAwal) + parseInt(nilaiLot)
			unit = nilaiAwal/nilaiLot
			$("#unit2").val(nilaiAwal/nilaiLot)
			$("#val2").html("Rp."+nilaiAwal.toLocaleString().replace(',','.').replace(',','.'));
		}
	});



	$('.content_project').hover(function(){
   $("#myCarousel").carousel('pause');
},function(){
   $("#myCarousel").carousel('cycle');
});
	
</script>
</body>

<!-- Mirrored from dealfintech.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 27 Mar 2019 10:24:37 GMT -->
</html>