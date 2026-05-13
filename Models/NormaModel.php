<?php

class NormaModel extends Mysql
{
    private $id;
    private $nm_numeroDocumento;
    private $nm_file;
    private $year;
    private $tiponorma_id;
    private $nombre;
    private $descripcion;
    private $file;
    private $idPeronsa;
    private $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectNormas(int $id)
    {
        $this->id = $id;
        $sql = "SELECT*FROM anio AS a
        inner join normasmunicipales  AS nm ON a.id=nm.anio_id 
        inner join persona as p on p.idpersona=nm.idpersona
        WHERE nm.tiponorma_id={$this->id} order by nm.id ASC;";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertNorma(int $numeroDoc, int $year, int $tiponorma_id, string $nombre, string $descripcion, string $file, int $idPersona)
    {
        $query = "INSERT INTO `normasmunicipales` 
        (`nm_numeroDocumento`,`anio_id`, `tiponorma_id`, `nm_nombre`, `nm_descripcion`, `nm_file`, `idpersona`) 
        VALUES 
        (?,?, ?, ?, ?, ?, ?);";
        $arrData = array(
            $this->nm_numeroDocumento = $numeroDoc,
            $this->year = $year,
            $this->tiponorma_id = $tiponorma_id,
            $this->nombre = $nombre,
            $this->descripcion = $descripcion,
            $this->file = $file,
            $this->idPeronsa = $idPersona
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function selectYear()
    {
        $query = "SELECT*FROM anio AS a WHERE a.a_estado=1 ORDER BY a.a_anio DESC;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectTipoNorma(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM tiponorma AS tn WHERE tn.id={$this->id} AND tn.tn_estado=1;";
        $request = $this->select($query);
        return $request;
    }
    public function deleteNorma(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `normasmunicipales` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function updateNorma(int $numeroDoc, int $year, string $nombre, string $descripcion, int $estado, int $iduser, int $id)
    {
        $query = "UPDATE `normasmunicipales` SET `nm_numeroDocumento`=?,
        `anio_id`=?, 
        `nm_nombre`=?, 
        `nm_descripcion`=?, 
        `nm_estado`=?, 
        `idpersona`=?
         WHERE  `id`=?;";
        $arrData = array(
            $this->nm_numeroDocumento = $numeroDoc,
            $this->year = $year,
            $this->nombre = $nombre,
            $this->descripcion = $descripcion,
            $this->estado = $estado,
            $this->idPeronsa = $iduser,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function selectNorma(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM normasmunicipales AS nm WHERE nm.id={$this->id}";
        $request = $this->select($query);
        return $request;
    }
    public function updatefilenorma(int $id, string $file, int $idpersona)
    {
        $query = "UPDATE `normasmunicipales` SET `nm_file`=?, `idpersona`=? WHERE  `id`=?;";
        $arrData = array(
            $this->nm_file = $file,
            $this->idPeronsa = $idpersona,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
}
