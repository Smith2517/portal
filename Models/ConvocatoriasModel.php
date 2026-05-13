<?php

class ConvocatoriasModel extends Mysql
{
	private $intConvocatoriaId;
	private $intItemId;
	private $intDocumentoId;
	private $strTitulo;
	private $strDescripcion;
	private $strFechaInicio;
	private $strFechaFin;
	private $intOrden;
	private $intEstado;
	private $intIdPersona;
	private $strNombre;
	private $strTituloDocumento;
	private $strDescripcionDocumento;
	private $strArchivoRuta;

	public function __construct()
	{
		parent::__construct();
	}

	// Métodos para Convocatorias principales
	public function insertConvocatoria(string $titulo, string $descripcion, string $fechaInicio, string $fechaFin, int $estado, int $idpersona)
	{
		$this->strTitulo = $titulo;
		$this->strDescripcion = $descripcion;
		$this->strFechaInicio = $fechaInicio;
		$this->strFechaFin = $fechaFin;
		$this->intEstado = $estado;
		$this->intIdPersona = $idpersona;

		$sql = "INSERT INTO convocatorias (titulo, descripcion, fecha_inicio, fecha_fin, estado, idpersona) VALUES (?, ?, ?, ?, ?, ?)";
		$arrData = array($this->strTitulo, $this->strDescripcion, $this->strFechaInicio, $this->strFechaFin, $this->intEstado, $this->intIdPersona);
		$request = $this->insert($sql, $arrData);

		// Si se creó la convocatoria, crear los items automáticos
		if ($request > 0) {
			$this->crearItemsAutomaticos($request, $idpersona);
		}

		return $request;
	}

	// Método para crear los items automáticos
	private function crearItemsAutomaticos(int $convocatoriaId, int $idpersona)
	{
		$itemsAutomaticos = [
			['nombre' => 'Bases', 'descripcion' => 'Documentos de las bases de la convocatoria'],
			['nombre' => 'Resultados de Evaluación Curricular', 'descripcion' => 'Resultados de la evaluación curricular'],
			['nombre' => 'Resultados de Evaluación de Conocimientos', 'descripcion' => 'Resultados de la evaluación de conocimientos'],
			['nombre' => 'Resultados de Entrevista Personal', 'descripcion' => 'Resultados de la entrevista personal'],
			['nombre' => 'Resultados Finales', 'descripcion' => 'Resultados finales de la convocatoria']
		];

		foreach ($itemsAutomaticos as $item) {
			$sql = "INSERT INTO convocatoria_items (convocatoria_id, nombre, descripcion, estado, idpersona) VALUES (?, ?, ?, ?, ?)";
			$arrData = array($convocatoriaId, $item['nombre'], $item['descripcion'], 1, $idpersona);
			$this->insert($sql, $arrData);
		}
	}

	public function selectConvocatorias()
	{
		$sql = "SELECT c.*, p.nombres, p.apellidos
				FROM convocatorias c
				INNER JOIN persona p ON c.idpersona = p.idpersona
				
				ORDER BY c.fecha_inicio DESC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectConvocatoria(int $id)
	{
		$this->intConvocatoriaId = $id;
		$sql = "SELECT * FROM convocatorias WHERE id = $this->intConvocatoriaId";
		$request = $this->select($sql);
		return $request;
	}

	public function updateConvocatoria(int $id, string $titulo, string $descripcion, string $fechaInicio, string $fechaFin, int $estado)
	{
		$this->intConvocatoriaId = $id;
		$this->strTitulo = $titulo;
		$this->strDescripcion = $descripcion;
		$this->strFechaInicio = $fechaInicio;
		$this->strFechaFin = $fechaFin;
		$this->intEstado = $estado;

		$sql = "UPDATE convocatorias SET titulo = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intConvocatoriaId";
		$arrData = array($this->strTitulo, $this->strDescripcion, $this->strFechaInicio, $this->strFechaFin, $this->intEstado);
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteConvocatoria(int $id)
	{
		$this->intConvocatoriaId = $id;
		$sql = "DELETE FROM convocatorias WHERE id = $this->intConvocatoriaId";
		$request = $this->delete($sql);
		return $request;
	}

	// Métodos para Items
	public function insertItem(int $convocatoriaId, string $nombre, string $descripcion, int $orden, int $estado, int $idpersona)
	{
		$this->intConvocatoriaId = $convocatoriaId;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intOrden = $orden;
		$this->intEstado = $estado;
		$this->intIdPersona = $idpersona;

		$sql = "INSERT INTO convocatoria_items (convocatoria_id, nombre, descripcion, orden, estado, idpersona) VALUES (?, ?, ?, ?, ?, ?)";
		$arrData = array($this->intConvocatoriaId, $this->strNombre, $this->strDescripcion, $this->intOrden, $this->intEstado, $this->intIdPersona);
		$request = $this->insert($sql, $arrData);
		return $request;
	}

	public function selectItemsByConvocatoria(int $convocatoriaId)
	{
		$this->intConvocatoriaId = $convocatoriaId;
		$sql = "SELECT ci.*, p.nombres, p.apellidos
				FROM convocatoria_items ci
				INNER JOIN persona p ON ci.idpersona = p.idpersona
				WHERE ci.convocatoria_id = $this->intConvocatoriaId AND ci.estado != 0
				ORDER BY ci.orden ASC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectItem(int $id)
	{
		$this->intItemId = $id;
		$sql = "SELECT * FROM convocatoria_items WHERE id = $this->intItemId";
		$request = $this->select($sql);
		return $request;
	}

	public function updateItem(int $id, int $convocatoriaId, string $nombre, string $descripcion, int $orden, int $estado)
	{
		$this->intItemId = $id;
		$this->intConvocatoriaId = $convocatoriaId;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intOrden = $orden;
		$this->intEstado = $estado;

		$sql = "UPDATE convocatoria_items SET convocatoria_id = ?, nombre = ?, descripcion = ?, orden = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intItemId";
		$arrData = array($this->intConvocatoriaId, $this->strNombre, $this->strDescripcion, $this->intOrden, $this->intEstado);
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteItem(int $id)
	{
		$this->intItemId = $id;
		$sql = "DELETE FROM convocatoria_items WHERE id = $this->intItemId";
		$request = $this->delete($sql);
		return $request;
	}

	// Métodos para Documentos
	public function insertDocumento(int $itemId, string $tituloDocumento, string $descripcionDocumento, string $archivoRuta, int $orden, int $estado, int $idpersona)
	{
		$this->intItemId = $itemId;
		$this->strTituloDocumento = $tituloDocumento;
		$this->strDescripcionDocumento = $descripcionDocumento;
		$this->strArchivoRuta = $archivoRuta;
		$this->intOrden = $orden;
		$this->intEstado = $estado;
		$this->intIdPersona = $idpersona;

		$sql = "INSERT INTO convocatoria_documentos (item_id, titulo_documento, descripcion_documento, archivo_ruta, orden, estado, idpersona) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$arrData = array($this->intItemId, $this->strTituloDocumento, $this->strDescripcionDocumento, $this->strArchivoRuta, $this->intOrden, $this->intEstado, $this->intIdPersona);
		$request = $this->insert($sql, $arrData);
		return $request;
	}

	public function selectDocumentosByItem(int $itemId)
	{
		$this->intItemId = $itemId;
		$sql = "SELECT cd.*, p.nombres, p.apellidos
				FROM convocatoria_documentos cd
				INNER JOIN persona p ON cd.idpersona = p.idpersona
				WHERE cd.item_id = $this->intItemId AND cd.estado != 0
				ORDER BY cd.orden ASC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectDocumento(int $id)
	{
		$this->intDocumentoId = $id;
		$sql = "SELECT * FROM convocatoria_documentos WHERE id = $this->intDocumentoId";
		$request = $this->select($sql);
		return $request;
	}

	public function updateDocumento(int $id, int $itemId, string $tituloDocumento, string $descripcionDocumento, string $archivoRuta, int $orden, int $estado)
	{
		$this->intDocumentoId = $id;
		$this->intItemId = $itemId;
		$this->strTituloDocumento = $tituloDocumento;
		$this->strDescripcionDocumento = $descripcionDocumento;
		$this->strArchivoRuta = $archivoRuta;
		$this->intOrden = $orden;
		$this->intEstado = $estado;

		$sql = "UPDATE convocatoria_documentos SET item_id = ?, titulo_documento = ?, descripcion_documento = ?, archivo_ruta = ?, orden = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intDocumentoId";

		if ($archivoRuta != '') {
			$arrData = array($this->intItemId, $this->strTituloDocumento, $this->strDescripcionDocumento, $this->strArchivoRuta, $this->intOrden, $this->intEstado);
		} else {
			$sql = "UPDATE convocatoria_documentos SET item_id = ?, titulo_documento = ?, descripcion_documento = ?, orden = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intDocumentoId";
			$arrData = array($this->intItemId, $this->strTituloDocumento, $this->strDescripcionDocumento, $this->intOrden, $this->intEstado);
		}

		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteDocumento(int $id)
	{
		$this->intDocumentoId = $id;
		$sql = "DELETE FROM convocatoria_documentos WHERE id = $this->intDocumentoId";
		$request = $this->delete($sql);
		return $request;
	}

	// Método para obtener toda la estructura jerárquica
	public function getEstructuraConvocatorias()
	{
		$sql = "SELECT
                c.id as convocatoria_id,
                c.titulo as convocatoria_titulo,
                c.descripcion as convocatoria_descripcion,
                c.fecha_inicio as convocatoria_fecha_inicio,
                c.fecha_fin as convocatoria_fecha_fin,
                c.estado as convocatoria_estado,
                c.fecha_registro as convocatoria_fecha_registro,
                c.fecha_actualizacion as convocatoria_fecha_actualizacion,
                c.idpersona as convocatoria_idpersona,

                ci.id as item_id,
                ci.nombre as item_nombre,
                ci.descripcion as item_descripcion,
                ci.orden as item_orden,
                ci.estado as item_estado,
                ci.fecha_registro as item_fecha_registro,
                ci.fecha_actualizacion as item_fecha_actualizacion,
                ci.idpersona as item_idpersona,

                cd.id as documento_id,
                cd.titulo_documento as documento_titulo,
                cd.descripcion_documento as documento_descripcion,
                cd.archivo_ruta as documento_ruta,
                cd.orden as documento_orden,
                cd.estado as documento_estado,
                cd.fecha_registro as documento_fecha_registro,
                cd.fecha_actualizacion as documento_fecha_actualizacion,
                cd.idpersona as documento_idpersona
            FROM convocatorias c
            LEFT JOIN convocatoria_items ci
                ON c.id = ci.convocatoria_id
            LEFT JOIN convocatoria_documentos cd
                ON ci.id = cd.item_id
           ORDER BY c.id DESC, ci.orden ASC, cd.orden ASC";

		return $this->select_all($sql);
	}
}
