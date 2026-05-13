<?php 
	
	class Mysql extends Conexion
	{
		private $conexion;
		private $strquery;
		private $arrValues;

		function __construct()
		{
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}

		//Insertar un registro
		public function insert(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
        	$insert = $this->conexion->prepare($this->strquery);
        	$resInsert = $insert->execute($this->arrVAlues);
        	if($resInsert)
	        {
	        	$lastInsert = $this->conexion->lastInsertId();
	        }else{
	        	$lastInsert = 0;
	        }
	        return $lastInsert; 
		}
		//Busca un registro
		public function select(string $query, array $arrValues = [])
		{
			$this->strquery = $query;
			$this->arrValues = $arrValues;
        	$result = $this->conexion->prepare($this->strquery);
			$result->execute($this->arrValues);
        	$data = $result->fetch(PDO::FETCH_ASSOC);
        	return $data;
		}
		//Devuelve todos los registros
		public function select_all(string $query, array $arrValues = [])
		{
			$this->strquery = $query;
			$this->arrValues = $arrValues;
        	$result = $this->conexion->prepare($this->strquery);
			$result->execute($this->arrValues);
        	$data = $result->fetchall(PDO::FETCH_ASSOC);
        	return $data;
		}
		//Actualiza registros
		public function update(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrVAlues);
	        return $resExecute;
		}
		//Buscar categoría por nombre
		public function selectOne(string $query, array $arrValues = [])
	{
		$this->strquery = $query;
		$this->arrValues = $arrValues;
		$result = $this->conexion->prepare($this->strquery);
		$result->execute($this->arrValues);
		return $result->fetch(PDO::FETCH_ASSOC);
	}
		//Eliminar un registros
		public function delete(string $query, array $arrValues = [])
		{
			$this->strquery = $query;
			$this->arrValues = $arrValues;
        	$result = $this->conexion->prepare($this->strquery);
			$del = $result->execute($this->arrValues);
        	return $del;
		}
	}


 ?>

