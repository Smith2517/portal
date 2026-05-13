<?php

class Dashboard extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
// 		echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE); die;
		getPermisos(1);
	}

	public function dashboard()
	{
		$data['page_id'] = 1;
		$data['page_tag'] = "Dashboard - MDESV";
		$data['page_title'] = "Dashboard - MDESV";
		$data['page_name'] = "dashboard";
		$data['page_functions_js'] = "functions_dashboard.js";
		$this->views->getView($this, "dashboard", $data);
	}

}
