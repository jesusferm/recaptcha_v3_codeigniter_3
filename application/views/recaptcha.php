<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type='text/javascript'>
var base_url = "<?=base_url();?>";
</script>
<div id="container" class="container mt-5">
	<div class="row">
		<div class="col-md-12 mt-4">
			<h2 class="mt-2 mb-3 text-center">Recaptcha v2 & ajax</h2>
		</div>
	</div>
	<div class="row mt-3 mb-3">
		<div class="col-12">
			<p>
				Siguiendo con los ejemplos con ajax, codeigniter 3.1.10 y bootstrap 4.3.1. La implementación de recaptcha v2 con codeigniter.
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form name="form-signup" id="form-login" name="form-login" class="form-signin" role="form" method="post" enctype="multipart/form-data"  accept-charset="utf-8">
				<div class="row">
					<div id="div-cnt-login" class="col-md-12"></div>
				</div>
				<div class="row">
					<div class="col-md-12 mt-1 mb-2">
						<div class="input-group">
							<span class="has-float-label">
								<input type="email" class="form-control" name="txt-email" id="txt-email" placeholder="Correo electrónico" required="">
								<label for="txt-email">Email</label>
								<i class="fa fa-user form-control-feedback"></i>
							</span>
						</div>
					</div>
					<div class="col-md-12 mt-1 mb-2">
						<div class="input-group">
							<span class="has-float-label">
								<input type="password" class="form-control" name="txt-password" id="txt-password" placeholder="Contraseña" required="">
								<label for="txt-email">Contraseña</label>
								<i class="fa fa-lock form-control-feedback"></i>
							</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 text-left mt-2 mb-2">
						<div class="g-recaptcha" data-sitekey="<?=$this->config->item('site_key');?>"></div>
					</div>
					<div class="col-md-12 mt-2 mb-2">
						<button class="btn btn-primary btn-block" type="submit" id="btn-login" name="btn-login">
							<i class="fas fa-sign-in-alt"></i> Iniciar sesión
						</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-4"></div>
	</div>
	<!-- /content ajax load pagination -->
</div>

<script type="text/javascript">
	$("#form-login").submit(function( event ) {
		$('#btn-login').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			data: parametros,
			url: base_url+'recaptcha/login',
			method: "POST",
			dataType: 'json',
			beforeSend: function(objeto){
				$("#btn-login").html('<span class="spinner-border spin-x" role="status" aria-hidden="true"></span> Validando...');
			},
			success: function(data){
				$("#btn-login").html('<i class="fas fa-sign-in-alt"></i> Iniciar sesión');
				$('#btn-login').attr("disabled", false);
				$("#div-cnt-login").html('<div class="alert alert-'+data.tipo+'" role="alert"> <i class="'+data.icon+'"></i> '+data.msg+'</div>');
				setTimeout(function(){
					$("#div-cnt-login").html("");
				}, 2000);
			},
			error: function(e){
				$("#btn-login").html('<i class="fas fa-sign-in-alt"></i> Iniciar sesión');
				$('#btn-login').attr("disabled", false);
				$("#div-cnt-login").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
					'<strong><i class="fa fa-times"></i></strong> Error interno, intente más tarde.<button type="button" '+
					'class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}
		});
		event.preventDefault();
	});
</script>