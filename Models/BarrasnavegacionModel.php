<?php
class BarrasnavegacionModel extends Mysql
{
    private $idpersona;
    private $id;
    private $titulo;
    private $descripcion;
    private $estado;
    private $sectionfooter_id;
    private $is_nombre;
    private $is_link;
    private $is_target;
    private $is_icon;
    private $tipobarras_id;
    private $txtUrl;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectBarrasNavegacion()
    {
        $query = "SELECT bn.bn_titulo,bn.bn_descripcion,tb.tb_nombre,bn.tipobarras_id,bn.id,bn.bn_estado FROM barrasnavegacion AS bn 
        INNER JOIN tipobarras AS tb ON tb.id=bn.tipobarras_id
        ORDER BY bn.id DESC;";
        $request = $this->select_all($query);
        return $request;
    }
    public function tipobarras()
    {
        $query = "SELECT*FROM tipobarras WHERE tipobarras.tb_estado=1;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectSection(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM sectionbarrasnavegacion AS sf WHERE sf.barrasnavegacion_id={$this->id};";
        $resquest = $this->select_all($query);
        return $resquest;
    }
    public function insertBarraNavegacion(int $idpersona, string $titulo, string $descripcion, int $idTB)
    {
        $query = "INSERT INTO `barrasnavegacion` (`idpersona`, `bn_titulo`, `bn_descripcion`, `tipobarras_id`) VALUES (?, ?, ?, ?);";
        $arrData = array($this->idpersona = $idpersona, $this->titulo = $titulo, $this->descripcion = $descripcion, $this->tipobarras_id = $idTB);
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function insertSection(int $id, int $idpersona, string $titulo, string $descripcion, string $txtUrl)
    {
        $query = "INSERT INTO `sectionbarrasnavegacion` (`barrasnavegacion_id`, `idpersona`, `sbn_titulo`, `sbn_descripcion`,`sbn_url`) VALUES (?,?,?,?,?);";
        $arrData = array($this->id = $id, $this->idpersona = $idpersona, $this->titulo = $titulo, $this->descripcion = $descripcion, $this->txtUrl = $txtUrl);
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function insertItem(int $idSection, int $idpersona, string $nombre, string $link, string $target, string $icon)
    {
        $query = "INSERT INTO `itemsecction` 
        (`sectionfooter_id`, `idpersona`, `is_nombre`, `is_link`, `is_target`, `is_icon`) 
        VALUES 
        (?, ?, ?, ?, ?, ?);";
        $arrData = array(
            $this->sectionfooter_id = $idSection,
            $this->idpersona = $idpersona,
            $this->is_nombre = $nombre,
            $this->is_link = $link,
            $this->is_target = $target,
            $this->is_icon = $icon
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function updateEstado(int $estado, int $idTB)
    {
        $query = "UPDATE barrasnavegacion SET `bn_estado`=? WHERE barrasnavegacion.tipobarras_id=?";
        $arrData = array($this->estado = $estado, $this->tipobarras_id = $idTB);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function deleteBarraNavegacion(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM barrasnavegacion WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function deleteSection(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `sectionbarrasnavegacion` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function deleteItem(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `itemsecction` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function updateBarraNavegacion(int $idpersona, string $titulo, string $descripcion, int $id)
    {
        $query = "UPDATE `barrasnavegacion` SET `idpersona`=?, `bn_titulo`=?, `bn_descripcion`=? WHERE  `id`=?;";
        $arrData = array($this->idpersona = $idpersona, $this->titulo = $titulo, $this->descripcion = $descripcion, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateSection(int $idpersona, string $titulo, string $descripcion, string $txtUrl, int $id)
    {
        $query = "UPDATE `sectionbarrasnavegacion` SET 
        `idpersona`=?, 
        `sbn_titulo`=?, 
        `sbn_descripcion`=? ,
        `sbn_url`=? 
        WHERE  
        `id`=?;";
        $arrData = array($this->idpersona = $idpersona, $this->titulo = $titulo, $this->descripcion = $descripcion, $this->txtUrl = $txtUrl, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateItem(int $idpersona, string $nombre, string $link, string $target, string $icon, int $id)
    {
        $query = "UPDATE `itemsecction` SET 
        `idpersona`=?, 
        `is_nombre`=?, 
        `is_link`=?, 
        `is_target`=?, 
        `is_icon`=? 
        WHERE  
        `id`=?;";
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->is_nombre = $nombre,
            $this->is_link = $link,
            $this->is_target = $target,
            $this->is_icon = $icon,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateEstadoBarraNavegacion(int $estado, int $id)
    {
        $query = "UPDATE `barrasnavegacion` SET `bn_estado`=? WHERE  `id`=?;";
        $arrData = array($this->estado = $estado, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateEstadoSection(int $estado, int $id)
    {
        $query = "UPDATE `sectionbarrasnavegacion` SET `sbn_estado`=? WHERE  `id`=?;";
        $arrData = array($this->estado = $estado, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function selectBarraNavegacionInfo(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM barrasnavegacion AS bn WHERE bn.id={$this->id};";
        $request = $this->select($query);
        return $request;
    }
    public function selectSectionInfo(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM sectionbarrasnavegacion AS sf WHERE sf.id={$this->id};";
        $request = $this->select($query);
        return $request;
    }
    public function selectItems(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM itemsecction AS isec WHERE isec.sectionfooter_id={$this->id};";
        $request = $this->select_all($query);
        return $request;
    }
}
