<?php

class Home extends Controllers
{
	public function __construct()
	{
		parent::__construct();
	}

	public function home()
	{
		$data['page_id'] = 1;
		$data['page_tag'] = "Home";
		$data['page_title'] = "Página principal";
		$data['page_name'] = "home";
		$data['page_content'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, quis. Perspiciatis repellat perferendis accusamus, ea natus id omnis, ratione alias quo dolore tempore dicta cum aliquid corrupti enim deserunt voluptas.";

		// Obtener contenido dinámico para la página principal si existe
		$pagina_principal = $this->model->selectInfoPageByName('home');
		if ($pagina_principal && $pagina_principal['p_estado'] == 1) {
			$data['page_infoPage'] = $pagina_principal;
		}

		$data['page_functions_js'] = "functions_home.js";
		$this->views->getView($this, "home", $data);
	}

}
