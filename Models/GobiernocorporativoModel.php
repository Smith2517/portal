<?php
class GobiernocorporativoModel extends Mysql
{
    private $intIdpersona;
    private $intId;
    private $strTitulo;
    private $strNumero;
    private $strFecha;
    private $strCategoria;
    private $strDescripcion;
    private $strArchivo;
    private $strArchivoOriginal;
    private $intEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectGobiernocorporativo()
    {
        $query = "SELECT * FROM gobiernocorporativo ORDER BY gc_orden ASC, gc_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectGobiernocorporativoActivos()
    {
        $query = "SELECT * FROM gobiernocorporativo WHERE gc_estado = 1 ORDER BY gc_orden ASC, gc_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertGobiernocorporativo(
        int $idpersona,
        string $titulo,
        string $numero,
        string $fecha,
        string $categoria,
        string $descripcion,
        string $archivo,
        string $archivo_original,
        int $estado
    ) {
        $query = "INSERT INTO gobiernocorporativo
        (idpersona, gc_titulo, gc_numero, gc_fecha, gc_categoria, gc_descripcion, gc_archivo, gc_archivo_original, gc_estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $arrData = array(
            $this->intIdpersona = $idpersona,
            $this->strTitulo = $titulo,
            $this->strNumero = $numero,
            $this->strFecha = $fecha,
            $this->strCategoria = $categoria,
            $this->strDescripcion = $descripcion,
            $this->strArchivo = $archivo,
            $this->strArchivoOriginal = $archivo_original,
            $this->intEstado = $estado
        );

        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function updateGobiernocorporativo(
        int $idpersona,
        string $titulo,
        string $numero,
        string $fecha,
        string $categoria,
        string $descripcion,
        int $id
    ) {
        $query = "UPDATE gobiernocorporativo SET
        idpersona = ?,
        gc_titulo = ?,
        gc_numero = ?,
        gc_fecha = ?,
        gc_categoria = ?,
        gc_descripcion = ?
        WHERE id = ?;";

        $arrData = array(
            $this->intIdpersona = $idpersona,
            $this->strTitulo = $titulo,
            $this->strNumero = $numero,
            $this->strFecha = $fecha,
            $this->strCategoria = $categoria,
            $this->strDescripcion = $descripcion,
            $this->intId = $id
        );

        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateFileGobiernocorporativo(int $id, string $archivo, string $archivo_original)
    {
        $query = "UPDATE gobiernocorporativo SET gc_archivo = ?, gc_archivo_original = ? WHERE id = ?;";
        $arrData = array(
            $this->strArchivo = $archivo,
            $this->strArchivoOriginal = $archivo_original,
            $this->intId = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateEstadoGobiernocorporativo(int $id, int $estado)
    {
        $query = "UPDATE gobiernocorporativo SET gc_estado = ? WHERE id = ?;";
        $arrData = array(
            $this->intEstado = $estado,
            $this->intId = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function deleteGobiernocorporativo(int $id)
    {
        $this->intId = $id;
        $query = "DELETE FROM gobiernocorporativo WHERE id = {$this->intId};";
        $request = $this->delete($query);
        return $request;
    }
}
