<?php
class PaginasModel extends Mysql
{
    private $id;
    private $p_nombre;
    private $p_descripcion;
    private $persona_id;
    private $p_estado;
    private $p_contenido;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectPaginas()
    {
        $sql = "SELECT*FROM pagina ORDER BY id ASC;";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertPagina(string $nombre, string $descripcion, int $idpersona)
    {
        $query = "INSERT INTO `pagina` (`p_nombre`, `p_descripcion`, `persona_id`) VALUES (?,?,?);";
        $arrData = array($this->p_nombre = $nombre, $this->p_descripcion = $descripcion, $this->persona_id = $idpersona);
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function deletePagina(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `pagina` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function updatePagina(string $nombre, string $descripcion, int $idpersona, int $id)
    {
        $query = "UPDATE `pagina` SET `p_nombre`=?, `p_descripcion`=?, `persona_id`=? WHERE  `id`=?;";
        $arrData = array($this->p_nombre = $nombre, $this->p_descripcion = $descripcion, $this->persona_id = $idpersona, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateCarouselPagina(int $id, int $estado)
    {
        $query = "UPDATE `pagina` SET `p_estado`=? WHERE  `id`=?;";
        $arrData = array($this->p_estado = $estado, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function selectInfoPagina(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM pagina AS p WHERE p.id={$this->id};";
        $request = $this->select($query);
        return $request;
    }
    public function saveContent(string $contenido, int $id)
    {
        $query = "UPDATE `pagina` SET `p_contenido`=? WHERE  `id`=?;";
        $arrData = array($this->p_contenido = $contenido, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
}
