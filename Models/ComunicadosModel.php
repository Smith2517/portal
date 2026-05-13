<?php

class ComunicadosModel extends Mysql
{
	private $intComunicadoId;
	private $strTitulo;
	private $strFechaComunicado;
	private $strDescripcion;
	private $strImagenRuta;
	private $strPdfRuta;
	private $intEstado;
	private $intIdPersona;

	public function __construct()
	{
		parent::__construct();
	}

	public function insertComunicado(string $titulo, string $fechaComunicado, string $descripcion, string $imagenRuta, string $pdfRuta, int $estado, int $idpersona)
	{
		$this->strTitulo = $titulo;
		$this->strFechaComunicado = $fechaComunicado;
		$this->strDescripcion = $descripcion;
		$this->strImagenRuta = $imagenRuta;
		$this->strPdfRuta = $pdfRuta;
		$this->intEstado = $estado;
		$this->intIdPersona = $idpersona;

		$sql = "INSERT INTO comunicados (titulo, fecha_comunicado, descripcion, imagen_ruta, pdf_ruta, estado, idpersona) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$arrData = array($this->strTitulo, $this->strFechaComunicado, $this->strDescripcion, $this->strImagenRuta, $this->strPdfRuta, $this->intEstado, $this->intIdPersona);
		$request = $this->insert($sql, $arrData);

		return $request;
	}

	public function selectComunicados()
	{
		$sql = "SELECT c.*, p.nombres, p.apellidos
				FROM comunicados c
				INNER JOIN persona p ON c.idpersona = p.idpersona
				ORDER BY c.fecha_comunicado DESC, c.id DESC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectComunicado(int $id)
	{
		$this->intComunicadoId = $id;
		$sql = "SELECT * FROM comunicados WHERE id = $this->intComunicadoId";
		$request = $this->select($sql);
		return $request;
	}

	public function updateComunicado(int $id, string $titulo, string $fechaComunicado, string $descripcion, string $imagenRuta, string $pdfRuta, int $estado)
	{
		$this->intComunicadoId = $id;
		$this->strTitulo = $titulo;
		$this->strFechaComunicado = $fechaComunicado;
		$this->strDescripcion = $descripcion;
		$this->intEstado = $estado;

		// Si no se sube nueva imagen/pdf, mantener los anteriores
		if ($imagenRuta == '' && $pdfRuta == '') {
			$sql = "UPDATE comunicados SET titulo = ?, fecha_comunicado = ?, descripcion = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intComunicadoId";
			$arrData = array($this->strTitulo, $this->strFechaComunicado, $this->strDescripcion, $this->intEstado);
		} else {
			$sql = "UPDATE comunicados SET titulo = ?, fecha_comunicado = ?, descripcion = ?, imagen_ruta = ?, pdf_ruta = ?, estado = ?, fecha_actualizacion = NOW() WHERE id = $this->intComunicadoId";
			$arrData = array($this->strTitulo, $this->strFechaComunicado, $this->strDescripcion, $imagenRuta, $pdfRuta, $this->intEstado);
		}

		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteComunicado(int $id)
	{
		$this->intComunicadoId = $id;
		$sql = "DELETE FROM comunicados WHERE id = $this->intComunicadoId";
		$request = $this->delete($sql);
		return $request;
	}
}
