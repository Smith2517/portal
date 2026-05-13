<?php

class GobernanzaModel extends Mysql
{
	private $intItemId;
	private $intIndicadorId;
	private $intArchivoId;
	private $strNombre;
	private $strDescripcion;
	private $intOrden;
	private $intEstado;
	private $intIdPersona;
	private $strTitulo;
	private $strArchivoRuta;

	public function __construct()
	{
		parent::__construct();
	}

	// Métodos para Items principales
	public function insertItem(string $nombre, string $descripcion, int $orden, int $estado, int $idpersona)
	{
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intOrden = $orden;
		$this->intEstado = $estado;
		$this->intIdPersona = $idpersona;

		$sql = "INSERT INTO gobernanza_items (nombre, descripcion, orden, estado, idpersona) VALUES (?, ?, ?, ?, ?)";
		$arrData = array($this->strNombre, $this->strDescripcion, $this->intOrden, $this->intEstado, $this->intIdPersona);
		$request = $this->insert($sql, $arrData);
		return $request;
	}

	public function selectItems()
	{
		$sql = "SELECT gi.*, p.nombres, p.apellidos
				FROM gobernanza_items gi
				INNER JOIN persona p ON gi.idpersona = p.idpersona
				WHERE gi.estado != 0
				ORDER BY gi.orden ASC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectItem(int $id)
	{
		$this->intItemId = $id;
		$sql = "SELECT * FROM gobernanza_items WHERE id = $this->intItemId";
		$request = $this->select($sql);
		return $request;
	}

	public function updateItem(int $id, string $nombre, string $descripcion, int $orden, int $estado)
	{
		$this->intItemId = $id;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intOrden = $orden;
		$this->intEstado = $estado;

		$sql = "UPDATE gobernanza_items SET nombre = ?, descripcion = ?, orden = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intItemId";
		$arrData = array($this->strNombre, $this->strDescripcion, $this->intOrden, $this->intEstado);
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteItem(int $id)
	{
		$this->intItemId = $id;
		$sql = "DELETE FROM gobernanza_items WHERE id = $this->intItemId";
		$request = $this->delete($sql);
		return $request;
	}

	// Métodos para Indicadores
	public function insertIndicador(int $itemId, string $nombre, string $descripcion, int $orden, int $estado, int $idpersona)
	{
		$this->intItemId = $itemId;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intOrden = $orden;
		$this->intEstado = $estado;
		$this->intIdPersona = $idpersona;

		$sql = "INSERT INTO gobernanza_indicadores (item_id, nombre, descripcion, orden, estado, idpersona) VALUES (?, ?, ?, ?, ?, ?)";
		$arrData = array($this->intItemId, $this->strNombre, $this->strDescripcion, $this->intOrden, $this->intEstado, $this->intIdPersona);
		$request = $this->insert($sql, $arrData);
		return $request;
	}

	public function selectIndicadoresByItem(int $itemId)
	{
		$this->intItemId = $itemId;
		$sql = "SELECT gi.*, p.nombres, p.apellidos
				FROM gobernanza_indicadores gi
				INNER JOIN persona p ON gi.idpersona = p.idpersona
				WHERE gi.item_id = $this->intItemId AND gi.estado != 0
				ORDER BY gi.orden ASC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectIndicador(int $id)
	{
		$this->intIndicadorId = $id;
		$sql = "SELECT * FROM gobernanza_indicadores WHERE id = $this->intIndicadorId";
		$request = $this->select($sql);
		return $request;
	}

	public function updateIndicador(int $id, int $itemId, string $nombre, string $descripcion, int $orden, int $estado)
	{
		$this->intIndicadorId = $id;
		$this->intItemId = $itemId;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intOrden = $orden;
		$this->intEstado = $estado;

		$sql = "UPDATE gobernanza_indicadores SET item_id = ?, nombre = ?, descripcion = ?, orden = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intIndicadorId";
		$arrData = array($this->intItemId, $this->strNombre, $this->strDescripcion, $this->intOrden, $this->intEstado);
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteIndicador(int $id)
	{
		$this->intIndicadorId = $id;
		$sql = "DELETE FROM gobernanza_indicadores WHERE id = $this->intIndicadorId";
		$request = $this->delete($sql);
		return $request;
	}

	// Métodos para Archivos
	public function insertArchivo(int $indicadorId, string $titulo, string $descripcion, string $archivoRuta, int $orden, int $estado, int $idpersona)
	{
		$this->intIndicadorId = $indicadorId;
		$this->strTitulo = $titulo;
		$this->strDescripcion = $descripcion;
		$this->strArchivoRuta = $archivoRuta;
		$this->intOrden = $orden;
		$this->intEstado = $estado;
		$this->intIdPersona = $idpersona;

		$sql = "INSERT INTO gobernanza_archivos (indicador_id, titulo, descripcion, archivo_ruta, orden, estado, idpersona) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$arrData = array($this->intIndicadorId, $this->strTitulo, $this->strDescripcion, $this->strArchivoRuta, $this->intOrden, $this->intEstado, $this->intIdPersona);
		$request = $this->insert($sql, $arrData);
		return $request;
	}

	public function selectArchivosByIndicador(int $indicadorId)
	{
		$this->intIndicadorId = $indicadorId;
		$sql = "SELECT ga.*, p.nombres, p.apellidos
				FROM gobernanza_archivos ga
				INNER JOIN persona p ON ga.idpersona = p.idpersona
				WHERE ga.indicador_id = $this->intIndicadorId AND ga.estado != 0
				ORDER BY ga.orden ASC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectArchivo(int $id)
	{
		$this->intArchivoId = $id;
		$sql = "SELECT * FROM gobernanza_archivos WHERE id = $this->intArchivoId";
		$request = $this->select($sql);
		return $request;
	}

	public function updateArchivo(int $id, int $indicadorId, string $titulo, string $descripcion, string $archivoRuta, int $orden, int $estado)
	{
		$this->intArchivoId = $id;
		$this->intIndicadorId = $indicadorId;
		$this->strTitulo = $titulo;
		$this->strDescripcion = $descripcion;
		$this->strArchivoRuta = $archivoRuta;
		$this->intOrden = $orden;
		$this->intEstado = $estado;

		$sql = "UPDATE gobernanza_archivos SET indicador_id = ?, titulo = ?, descripcion = ?, archivo_ruta = ?, orden = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intArchivoId";

		if ($archivoRuta != '') {
			$arrData = array($this->intIndicadorId, $this->strTitulo, $this->strDescripcion, $this->strArchivoRuta, $this->intOrden, $this->intEstado);
		} else {
			$sql = "UPDATE gobernanza_archivos SET indicador_id = ?, titulo = ?, descripcion = ?, orden = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intArchivoId";
			$arrData = array($this->intIndicadorId, $this->strTitulo, $this->strDescripcion, $this->intOrden, $this->intEstado);
		}

		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteArchivo(int $id)
	{
		$this->intArchivoId = $id;
		$sql = "DELETE FROM gobernanza_archivos WHERE id = $this->intArchivoId";
		$request = $this->delete($sql);
		return $request;
	}

	// Método para obtener toda la estructura jerárquica
	public function getEstructuraGobernanza()
	{
		$sql = "SELECT
					gi.id as item_id,
					gi.nombre as item_nombre,
					gi.descripcion as item_descripcion,
					gi.orden as item_orden,
					gi.estado as item_estado,
					gi.fecha_registro as item_fecha_registro,
					gi.fecha_actualizacion as item_fecha_actualizacion,
					gi.idpersona as item_idpersona,
					gin.id as indicador_id,
					gin.nombre as indicador_nombre,
					gin.descripcion as indicador_descripcion,
					gin.orden as indicador_orden,
					gin.estado as indicador_estado,
					gin.fecha_registro as indicador_fecha_registro,
					gin.fecha_actualizacion as indicador_fecha_actualizacion,
					gin.idpersona as indicador_idpersona,
					ga.id as archivo_id,
					ga.titulo as archivo_titulo,
					ga.descripcion as archivo_descripcion,
					ga.archivo_ruta as archivo_ruta,
					ga.orden as archivo_orden,
					ga.estado as archivo_estado,
					ga.fecha_registro as archivo_fecha_registro,
					ga.fecha_actualizacion as archivo_fecha_actualizacion,
					ga.idpersona as archivo_idpersona
				FROM gobernanza_items gi
				LEFT JOIN gobernanza_indicadores gin ON gi.id = gin.item_id AND gin.estado=1
				LEFT JOIN gobernanza_archivos ga ON gin.id = ga.indicador_id AND ga.estado=1
				WHERE gi.estado = 1
				ORDER BY gi.orden ASC, gin.orden ASC, ga.orden ASC";

		$request = $this->select_all($sql);
		return $request;
	}
}

?>