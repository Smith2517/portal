<?php
class PackanticorrupcionModel extends Mysql
{
    private $idpersona;
    private $id;
    private $pa_nombre;
    private $pa_archivo;
    private $pa_archivo_original;
    private $pa_orden;
    private $pa_estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectPackanticorrupcion()
    {
        $query = "SELECT * FROM packanticorrupcion ORDER BY pa_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectPackanticorrupcionActivos()
    {
        $query = "SELECT * FROM packanticorrupcion WHERE pa_estado = 1 ORDER BY pa_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertPackanticorrupcion(
        int $idpersona,
        string $nombre,
        string $archivo,
        string $archivo_original,
        int $orden,
        int $estado
    ) {
        $query = "INSERT INTO packanticorrupcion
        (idpersona, pa_nombre, pa_archivo, pa_archivo_original, pa_orden, pa_estado)
        VALUES (?, ?, ?, ?, ?, ?);";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->pa_nombre = $nombre,
            $this->pa_archivo = $archivo,
            $this->pa_archivo_original = $archivo_original,
            $this->pa_orden = $orden,
            $this->pa_estado = $estado
        );

        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function updatePackanticorrupcion(
        int $idpersona,
        string $nombre,
        int $orden,
        int $id
    ) {
        $query = "UPDATE packanticorrupcion SET
        idpersona = ?,
        pa_nombre = ?,
        pa_orden = ?
        WHERE id = ?;";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->pa_nombre = $nombre,
            $this->pa_orden = $orden,
            $this->id = $id
        );

        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateFilePackanticorrupcion(int $id, string $archivo, string $archivo_original)
    {
        $query = "UPDATE packanticorrupcion SET pa_archivo = ?, pa_archivo_original = ? WHERE id = ?;";
        $arrData = array(
            $this->pa_archivo = $archivo,
            $this->pa_archivo_original = $archivo_original,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateEstadoPackanticorrupcion(int $id, int $estado)
    {
        $query = "UPDATE packanticorrupcion SET pa_estado = ? WHERE id = ?;";
        $arrData = array(
            $this->pa_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function deletePackanticorrupcion(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM packanticorrupcion WHERE id = {$this->id};";
        $request = $this->delete($query);
        return $request;
    }
}
