<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include("mdls/mdl_posts.php");
?>
<script type='text/javascript'>
var base_url = "<?php echo base_url();?>";
</script>
<div id="container" class="container mt-5">
	<div class="row">
		<div class="col-md-12 mt-4">
			<h2 class="mt-2 mb-3 text-center">Cargar contenido al hacer scroll en div específico</h2>
		</div>
	</div>
	<div class="row mt-3 mb-3">
		<div class="col-12">
			<p>
				Siguiendo con los ejemplos con ajax, codeigniter 3.1.10 y bootstrap 4.3.1. En ésta ocasión les traigo carga de contenido al hacer scroll dentro de un div específico.
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12" id="div-cnt-post" style="height: 450px; overflow-x: none; overflow-y: auto;">
			<div id="load_data"></div>
			<div id="load_data_message"></div>
		</div>
	</div>
	<!-- /content ajax load pagination -->
</div>

<!--script src="<?php echo base_url();?>assets/app/ajax/ajxtablepage.js"></script-->
<script type="text/javascript">
	$(document).ready(function() {
		//load(0);
		var start 	= 0;
		var limit 	= 5;
		var action 	= 'inactive';
		function load_country_data(limit, start){
			$.ajax({
				url: 	base_url+"scroll/loadPosts",/*"fetch.php",*/
				method: "POST",
				dataType: 'JSON',
				type: "POST",
				data:{
					start: start,
					limit: limit
				},
				cache:false,
				beforeSend: function(objeto){
					$("#load_data_message").html('<div class="timeline-item"><div class="animated-background"><div class="background-masker m-2" style="height: 85%; width: 10%; "></div><div class="background-masker mt-2" style="height: 25%; width: 50%; margin-left: 12%;"></div><div class="background-masker mt-5" style="height: 10%; width: 80%; margin-left: 12%;"></div><div class="background-masker" style="height: 10%; width: 80%; margin-top:65px; margin-left: 12%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 12%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 23%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 34%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 46%;"></div></div></div>');
				},
				success:function(data){
					$('#load_data').append(data.data);
					if(data.data == ''){
			 			$('#load_data_message').html('<div class="text-center"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> No hay más elementos para cargar.</div></div>');
						action = 'active';
					}else{
						/*$('#load_data_message').html('<div class="text-center"><img src="assets/app/images/loading.gif" width="30px"> Cargando más contenido...</div>');*/
						$("#load_data_message").html('<div class="timeline-item"><div class="animated-background"><div class="background-masker m-2" style="height: 85%; width: 10%; "></div><div class="background-masker mt-2" style="height: 25%; width: 50%; margin-left: 12%;"></div><div class="background-masker mt-5" style="height: 10%; width: 80%; margin-left: 12%;"></div><div class="background-masker" style="height: 10%; width: 80%; margin-top:65px; margin-left: 12%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 12%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 23%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 34%;"></div><div class="background-masker" style="height: 10%; width: 10%; margin-top:80px; margin-left: 46%;"></div></div></div>');
						action = "inactive";
					}
				}
			});
		}

		if(action == 'inactive'){
			action = 'active';
			load_country_data(limit, start);
		}

		$("#div-cnt-post").scroll(function(){
			/*this change for window in cas use all window for scroll and not a specific div*/
			if($("#div-cnt-post").scrollTop() + $("#div-cnt-post").height() > $("#load_data").height() && action == 'inactive'){
				action = 'active';
				start = start + limit;
				setTimeout(function(){
					load_country_data(limit, start);
				}, 400);
			}
		});
	});
</script>