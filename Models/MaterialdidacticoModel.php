<?php
class MaterialdidacticoModel extends Mysql
{
    private $idpersona;
    private $id;
    private $md_nombre;
    private $md_archivo;
    private $md_archivo_original;
    private $md_orden;
    private $md_estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectMaterialdidactico()
    {
        $query = "SELECT * FROM materialdidactico ORDER BY md_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectMaterialdidacticoActivos()
    {
        $query = "SELECT * FROM materialdidactico WHERE md_estado = 1 ORDER BY md_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertMaterialdidactico(
        int $idpersona,
        string $nombre,
        string $archivo,
        string $archivo_original,
        int $orden,
        int $estado
    ) {
        $query = "INSERT INTO materialdidactico
        (idpersona, md_nombre, md_archivo, md_archivo_original, md_orden, md_estado)
        VALUES (?, ?, ?, ?, ?, ?);";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->md_nombre = $nombre,
            $this->md_archivo = $archivo,
            $this->md_archivo_original = $archivo_original,
            $this->md_orden = $orden,
            $this->md_estado = $estado
        );

        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function updateMaterialdidactico(
        int $idpersona,
        string $nombre,
        int $orden,
        int $id
    ) {
        $query = "UPDATE materialdidactico SET
        idpersona = ?,
        md_nombre = ?,
        md_orden = ?
        WHERE id = ?;";

        $arrData = array(
            $this->idpersona = $idpersona,
            $this->md_nombre = $nombre,
            $this->md_orden = $orden,
            $this->id = $id
        );

        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateFileMaterialdidactico(int $id, string $archivo, string $archivo_original)
    {
        $query = "UPDATE materialdidactico SET md_archivo = ?, md_archivo_original = ? WHERE id = ?;";
        $arrData = array(
            $this->md_archivo = $archivo,
            $this->md_archivo_original = $archivo_original,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateEstadoMaterialdidactico(int $id, int $estado)
    {
        $query = "UPDATE materialdidactico SET md_estado = ? WHERE id = ?;";
        $arrData = array(
            $this->md_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function deleteMaterialdidactico(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM materialdidactico WHERE id = {$this->id};";
        $request = $this->delete($query);
        return $request;
    }
}
