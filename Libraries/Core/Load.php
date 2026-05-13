<?php
$controller = ucwords($controller);
$controllerFile = "Controllers/" . $controller . ".php";
if (file_exists($controllerFile)) {
	require_once($controllerFile);
	$controller = new $controller();
	if (method_exists($controller, $method)) {
		$controller->{$method}($params);
	} else {
		// Soporte para URLs cortas del CMS (/page/nombre)
		if (get_class($controller) === 'Page') {
			$controller->page($method);
		} else {
			notFound();
		}
	}
} else {
	notFound();
}
