<?php

	class HomeModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function selectInfoPageByName(string $nombre)
		{
			// Usar la función de limpieza del sistema
			$nombre = strClean($nombre);
			$query = "SELECT * FROM pagina AS p WHERE p.p_nombre = '{$nombre}' AND p.p_estado = 1;";
			$request = $this->select($query);
			return $request;
		}
	}
 ?>