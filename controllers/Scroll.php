<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scroll extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('post');
	}

	public function index(){
		$data['title'] 	= 'Codeigniter 3.1.10 & Bootstrap 4.3.1 | LiNuXiToS';
		$data['tab'] 	= 'index';
		$this->load->view('common/head', $data);
		$this->load->view('common/navbar', $data);
		$this->load->view('scroll', $data);
		$this->load->view('common/foot');
	}

	/**
	 * [loadSecs load section by mymode]
	 * @return [type] [description]
	 */
	public function loadPosts(){
		$data['start'] 		= ($this->input->post('start')) ? $this->input->post('start'): 0;
		$data['limit'] 		= ($this->input->post('limit')) ? $this->input->post('limit'): 5;
		
		$reload 			= base_url()."scroll/loadPosts";
		$posts 			=  $this->post->getPostScroll($data);

		$response['data'] 	= "";
		foreach ($posts as $post) {
			$response['data'] .= '<div class="row mb-2">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-3">
									<img class="img-fluid" src="'.base_url().'assets/app/images/default_post.png">
								</div>
								<div class="col-md-9">
									<div class="card-body">
										<div class="news-content">
											<a href="#"><h2>A crowd walks on a New York street  </h2></a>
											<p>Hub because the aformentioned trio already offers its customers protections when dealing with the virtual currency.</p>
										
										</div>
										<div class="news-footer">
										<div class="news-author">
											<ul class="list-inline list-unstyled">
												<li class="list-inline-item text-secondary">
													<i class="fa fa-user"></i>
													Prashant Singh
												</li>
												<li class="list-inline-item text-secondary">
													<i class="fa fa-user"></i>
													Advice
												</li>
												<li class="list-inline-item text-secondary">
													<i class="fa fa-eye"></i>
													110 Views
												</li>
												<li class="list-inline-item text-secondary">
													<i class="fa fa-calendar"></i>
													26 June 2018
												</li>
											</ul>
										</div>   
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}

		echo json_encode($response);
	}

	public function delReg(){
		$list_ids 	= $this->input->post('list_ids');

		if (empty($list_ids)) {
			$response['tipo'] = "danger";
			$response['icon'] = "fa fa-exclamation-triangle";
			$response['msg'] = "El registro presenta un error en el ID, por favor reinice sesión.";
		}else{
			$bus_sep = explode(',', $list_ids);
			foreach ($bus_sep as $id) {
				if ($this->post->delReg($id)) {
					$response['tipo'] = "success";
					$response['icon'] = "fa fa-check";
					$response['msg'] = "Registro eliminado.";
				}else{
					$response['tipo'] = "danger";
					$response['icon'] = "fa fa-exclamation-triangle";
					$response['msg'] = "Ocurrió un error al eliminar la información del inmueble. Intente más tarde.";
				}
			}
		}
		echo json_encode($response);
	}

	public function addReg(){
		$p = array(
			'nom_post'		=>$this->input->post('txt-nom-reg'),
			'desc_post'		=>$this->input->post('txt-desc-reg'),
		);

		if ($this->post->addReg($p)) {
			$response['tipo'] = "success";
			$response['icon'] = "fa fa-check";
			$response['msg'] = "Registro agregado correctamente.";
		}else{
			$response['tipo'] = "danger";
			$response['icon'] = "fa fa-exclamation-triangle";
			$response['msg'] = "Ocurrió un error al eliminar la información del inmueble. Intente más tarde.";
		}

		echo json_encode($response);
	}
}
