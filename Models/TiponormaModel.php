<?php
class TiponormaModel extends Mysql
{
    private $tn_nombre;
    private $tn_descripcion;
    private $tn_foto;
    private $tn_estado;
    private $idpersona;
    private $id;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectTipoNormas()
    {
        $query = "SELECT*FROM tiponorma AS tn ;";
        $request = $this->select_all($query);
        return  $request;
    }
    public function insertTipoNorma(string $nombre, string $descripcion, string $foto, int $idPersona)
    {
        $query = "INSERT INTO `tiponorma` (`tn_nombre`, `tn_descripcion`, `tn_foto`, `idpersona`) VALUES (?, ?, ?, ?);";
        $arrData = array(
            $this->tn_nombre = $nombre,
            $this->tn_descripcion = $descripcion,
            $this->tn_foto = $foto,
            $this->idpersona = $idPersona
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function updateTipoNorma(string $nombre, string $descripcion, int $estado, int $idpersona, int $id)
    {
        $query = "UPDATE `tiponorma` SET 
        `tn_nombre`=?, 
        `tn_descripcion`=?, 
        `tn_estado`=?, 
        `idpersona`=? 
        WHERE  
        `id`=?;";
        $arrData = array(
            $this->tn_nombre = $nombre,
            $this->tn_descripcion = $descripcion,
            $this->tn_estado = $estado,
            $this->idpersona = $idpersona,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateFotoTipoNorma(int $id, string $foto)
    {
        $query = "UPDATE `tiponorma` 
        SET `tn_foto`=? WHERE  `id`=?;";
        $arrData = array($this->tn_foto = $foto, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function deleteTipoNorma(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `tiponorma` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function selectNormasMunicipales(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM normasmunicipales AS nm WHERE nm.tiponorma_id={$this->id};";
        $request = $this->select_all($query);
        return $request;
    }
}
