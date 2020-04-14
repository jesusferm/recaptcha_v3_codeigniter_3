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
			<h2 class="mt-2 mb-3 text-center">Paginación en tablas utilizando AJAX, CodeIgniter 3.1.10 & Bootstrap 4.3.1!</h2>
		</div>
	</div>
	<div class="row mt-3 mb-3">
		<div class="col-12">
			<p>
				Siguiendo con los ejemplos con ajax, codeigniter 3.1.10 y bootstrap 4.3.1. En ésta ocasión les traigo paginación en tablas utilizando ajax, así como las funciones de ordenamiento, filtrado, seleccionando el total a mostrar y búsqueda de registros.
			</p>
		</div>
	</div>

	<div class="form-row mt-2 mb-3">
		<div class="col-md-2 col-sm-2 col-3">
			<div class="select-show input-group-prepend">
				<button id="btn-list-show" type="button" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown">
					<span class="fa fa-list-ol"></span> <span id="spn-list-show">5</span>
				</button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#5">5</a>
					<a class="dropdown-item" href="#10">10</a>
					<a class="dropdown-item" href="#20">20</a>
					<a class="dropdown-item" href="#30">30</a>
					<a class="dropdown-item" href="#40">40</a>
					<a class="dropdown-item" href="#50">50</a>
				</div>
			</div>
		</div>						

		<div class="col-md-8 col-sm-10 col-9">
			<form class="form" role="form" method="post" enctype="multipart/form-data" accept-charset="utf-8" id="form-search" name="form-search">
				<div class="input-group">
					<div class="search-panel input-group-prepend">
						<button id="btn-search-on" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
							<i class="fas fa-check"></i> <span class="d-none d-lg-inline-block">Activos</span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#2">
								<i class="fas fa-clock"></i> <span class="d-none d-lg-inline-block">Activos</span>
							</a>
							<a class="dropdown-item" href="#1">
								<i class="fas fa-trash-alt"></i> <span class="d-none d-lg-inline-block">Eliminados</span>
							</a>
						</div>
					</div>
					<input type="text" class="form-control txt-search-nv" name="txt-search" id="txt-search" placeholder="Buscar...">
					<div class="input-group-append">
						<button type="submit" class="btn btn-search-nav" name="btn-search" id="btn-search">
							<i class="fal fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-2 col-sm-2 col-2">
			<button class="btn btn-block btn-success" title="Agregar Sección" data-toggle="modal" data-target="#mdl-add-reg">
				<i class="fa fa-plus-circle"></i> Agregar Registro
			</button>
		</div>
	</div>

	<!--div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="tbl-chk has-controls table table-striped table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Descripción</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">
								<input type="checkbox" /> Check 01
								<input id="select-files-5" type="checkbox" class="selectCheckBox checkbox">
								<label for="select-files-5">
									<div class="thumbnail" style="background-image:url(assets/app/images/filetypes/folder.svg); background-size: 32px;"></div>
								</label>
							</th>
							<td>Mark</td>
						</tr>
						<tr>
							<th scope="row">
								<input type="checkbox" /> Check 02
								<input id="select-files-5" type="checkbox" class="selectCheckBox checkbox">
								<label for="select-files-5">
									<div class="thumbnail" style="background-image:url(assets/app/images/filetypes/folder.svg); background-size: 32px;"></div>
								</label>
							</th>
							<td>Jacob</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div-->

	<div class="row">
		<div class="col-md-12">
			<table id="filestable" class="has-controls table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col" class="text-center">
							#
						</th>
						<th scope="col">Descripción</th>
					</tr>
				</thead>
				<tbody id="fileList">
					<tr data-id="5" data-type="dir" data-size="445182" data-file="Documents" data-mime="httpd/unix-directory" data-mtime="1573266899000" data-etag="5dc625d407762" data-permissions="31" data-path="/" data-share-permissions="31" class="ui-droppable">
						<td class="filename">
							<input id="select-files-5" type="checkbox" class="selectCheckBox checkbox">
							<label for="select-files-5">
								<div class="thumbnail" style="background-image:url(assets/app/images/filetypes/folder-drag-accept.svg); background-size: 32px;"></div>
							</label>
						</td>
						<td>
							<label for="select-files-5">
								Holis https://jsfiddle.net/ganesh16889/62h554av/
							</label>
						</td>
					</tr>
					<tr data-id="7" data-type="dir" data-size="678556" data-file="Photos" data-mime="httpd/unix-directory" data-mtime="1573266563000" data-etag="5dc62483c543f" data-permissions="31" data-path="/" data-share-permissions="31" class="ui-droppable">
						<td class="filename">
							<input id="select-files-7" type="checkbox" class="selectCheckBox checkbox">
							<label for="select-files-7">
								<div class="thumbnail" style="background-image:url(assets/app/images/filetypes/application-pdf.svg); background-size: 32px;"></div>
							</label>
						</td>
						<td>
							<label for="select-files-7">
							Holis
						</label>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 text-right">
			<h5 id="h5-cnt-total"></h5>
		</div>
	</div>
	<div class="row">
		<div id="div-cnt-load" class="col-md-12"></div>
	</div>
	<!-- /content ajax load pagination -->
</div>

<script src="<?php echo base_url();?>assets/app/ajax/ajxtablepage.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		load(0);
	});
</script>