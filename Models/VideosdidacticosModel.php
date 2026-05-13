<?php
class VideosdidacticosModel extends Mysql
{
    private $idpersona;
    private $id;
    private $vd_nombre;
    private $vd_enlace;
    private $vd_thumbnail;
    private $vd_orden;
    private $vd_estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectVideosdidacticos()
    {
        $query = "SELECT * FROM videosdidacticos ORDER BY vd_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectVideosdidacticosActivos()
    {
        $query = "SELECT * FROM videosdidacticos WHERE vd_estado = 1 ORDER BY vd_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertVideosdidacticos(
        int $idpersona,
        string $nombre,
        string $enlace,
        string $thumbnail,
        int $orden,
        int $estado
    ) {
        $query = "INSERT INTO videosdidacticos
        (idpersona, vd_nombre, vd_enlace, vd_thumbnail, vd_orden, vd_estado)
        VALUES (?, ?, ?, ?, ?, ?);";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->vd_nombre = $nombre,
            $this->vd_enlace = $enlace,
            $this->vd_thumbnail = $thumbnail,
            $this->vd_orden = $orden,
            $this->vd_estado = $estado
        );

        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function updateVideosdidacticos(
        int $idpersona,
        string $nombre,
        string $enlace,
        string $thumbnail,
        int $orden,
        int $id
    ) {
        $query = "UPDATE videosdidacticos SET
        idpersona = ?,
        vd_nombre = ?,
        vd_enlace = ?,
        vd_thumbnail = ?,
        vd_orden = ?
        WHERE id = ?;";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->vd_nombre = $nombre,
            $this->vd_enlace = $enlace,
            $this->vd_thumbnail = $thumbnail,
            $this->vd_orden = $orden,
            $this->id = $id
        );

        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateEstadoVideosdidacticos(int $id, int $estado)
    {
        $query = "UPDATE videosdidacticos SET vd_estado = ? WHERE id = ?;";
        $arrData = array(
            $this->vd_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function deleteVideosdidacticos(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM videosdidacticos WHERE id = {$this->id};";
        $request = $this->delete($query);
        return $request;
    }
}
