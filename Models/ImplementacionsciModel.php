<?php
class ImplementacionsciModel extends Mysql
{
    private $idpersona;
    private $id;
    private $is_titulo;
    private $is_numero;
    private $is_fecha;
    private $is_categoria;
    private $is_descripcion;
    private $is_archivo;
    private $is_archivo_original;
    private $is_estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectImplementacionsci()
    {
        $query = "SELECT * FROM implementacionsci ORDER BY is_orden ASC, is_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectImplementacionsciActivos()
    {
        $query = "SELECT * FROM implementacionsci WHERE is_estado = 1 ORDER BY is_orden ASC, is_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertImplementacionsci(
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
        $query = "INSERT INTO implementacionsci
        (idpersona, is_titulo, is_numero, is_fecha, is_categoria, is_descripcion, is_archivo, is_archivo_original, is_estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->is_titulo = $titulo,
            $this->is_numero = $numero,
            $this->is_fecha = $fecha,
            $this->is_categoria = $categoria,
            $this->is_descripcion = $descripcion,
            $this->is_archivo = $archivo,
            $this->is_archivo_original = $archivo_original,
            $this->is_estado = $estado
        );

        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function updateImplementacionsci(
        int $idpersona,
        string $titulo,
        string $numero,
        string $fecha,
        string $categoria,
        string $descripcion,
        int $id
    ) {
        $query = "UPDATE implementacionsci SET
        idpersona = ?,
        is_titulo = ?,
        is_numero = ?,
        is_fecha = ?,
        is_categoria = ?,
        is_descripcion = ?
        WHERE id = ?;";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->is_titulo = $titulo,
            $this->is_numero = $numero,
            $this->is_fecha = $fecha,
            $this->is_categoria = $categoria,
            $this->is_descripcion = $descripcion,
            $this->id = $id
        );

        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateFileImplementacionsci(int $id, string $archivo, string $archivo_original)
    {
        $query = "UPDATE implementacionsci SET is_archivo = ?, is_archivo_original = ? WHERE id = ?;";
        $arrData = array(
            $this->is_archivo = $archivo,
            $this->is_archivo_original = $archivo_original,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateEstadoImplementacionsci(int $id, int $estado)
    {
        $query = "UPDATE implementacionsci SET is_estado = ? WHERE id = ?;";
        $arrData = array(
            $this->is_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function deleteImplementacionsci(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM implementacionsci WHERE id = {$this->id};";
        $request = $this->delete($query);
        return $request;
    }
}
