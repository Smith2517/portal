<?php
class MarconormativoModel extends Mysql
{
    private $idpersona;
    private $id;
    private $mn_titulo;
    private $mn_numero;
    private $mn_fecha;
    private $mn_categoria;
    private $mn_descripcion;
    private $mn_archivo;
    private $mn_archivo_original;
    private $mn_estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectMarconormativo()
    {
        $query = "SELECT * FROM marconormativo ORDER BY mn_orden ASC, mn_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectMarconormativoActivos()
    {
        $query = "SELECT * FROM marconormativo WHERE mn_estado = 1 ORDER BY mn_orden ASC, mn_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertMarconormativo(
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
        $query = "INSERT INTO marconormativo 
        (idpersona, mn_titulo, mn_numero, mn_fecha, mn_categoria, mn_descripcion, mn_archivo, mn_archivo_original, mn_estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->mn_titulo = $titulo,
            $this->mn_numero = $numero,
            $this->mn_fecha = $fecha,
            $this->mn_categoria = $categoria,
            $this->mn_descripcion = $descripcion,
            $this->mn_archivo = $archivo,
            $this->mn_archivo_original = $archivo_original,
            $this->mn_estado = $estado
        );
        
        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function updateMarconormativo(
        int $idpersona,
        string $titulo,
        string $numero,
        string $fecha,
        string $categoria,
        string $descripcion,
        int $id
    ) {
        $query = "UPDATE marconormativo SET 
        idpersona = ?,
        mn_titulo = ?,
        mn_numero = ?,
        mn_fecha = ?,
        mn_categoria = ?,
        mn_descripcion = ?
        WHERE id = ?;";
        
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->mn_titulo = $titulo,
            $this->mn_numero = $numero,
            $this->mn_fecha = $fecha,
            $this->mn_categoria = $categoria,
            $this->mn_descripcion = $descripcion,
            $this->id = $id
        );
        
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateFileMarconormativo(int $id, string $archivo, string $archivo_original)
    {
        $query = "UPDATE marconormativo SET mn_archivo = ?, mn_archivo_original = ? WHERE id = ?;";
        $arrData = array(
            $this->mn_archivo = $archivo,
            $this->mn_archivo_original = $archivo_original,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateEstadoMarconormativo(int $id, int $estado)
    {
        $query = "UPDATE marconormativo SET mn_estado = ? WHERE id = ?;";
        $arrData = array(
            $this->mn_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function deleteMarconormativo(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM marconormativo WHERE id = {$this->id};";
        $request = $this->delete($query);
        return $request;
    }
}
