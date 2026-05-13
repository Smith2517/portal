<?php
class ModalModel extends Mysql
{
    private $id;
    private $titulo;
    private $descripcion;
    private $sizeAviso;
    private $fechaInicio;
    private $fechaFin;
    private $incrustacion;
    private $idPersona;
    private $idAviso;
    private $estatico;
    private $estado;
    private $escrolable;
    public function __construct()
    {
        parent::__construct();
    }
    public function insertModal(
        string $titulo,
        string $descripcion,
        string $sizeAviso,
        string $fechaInicio,
        string $fechaFin,
        string $incrustacion,
        int $idPersona,
        string $estatico,
        string $escrolable
    ) {
        if ($fechaFin != "" && $fechaInicio != "") {
            $query = "INSERT INTO `aviso` 
            (`a_Titulo`, `a_Descripcion`, `a_sizeAviso`, `a_fechaInicio`, `a_fechaFin`, `a_Incrustacion`,`a_Estatico`,`a_Escrollable`, `idpersona`) 
            VALUES 
            (?, ?, ?, ?, ?, ? , ? , ? , ?);";
            $arrData = array(
                $this->titulo = $titulo,
                $this->descripcion = $descripcion,
                $this->sizeAviso = $sizeAviso,
                $this->fechaInicio = $fechaInicio,
                $this->fechaFin = $fechaFin,
                $this->incrustacion = $incrustacion,
                $this->estatico = $estatico,
                $this->escrolable = $escrolable,
                $this->idPersona = $idPersona
            );
        } else {
            $query = "INSERT INTO `aviso` 
            (`a_Titulo`, `a_Descripcion`, `a_sizeAviso`, `a_Incrustacion`,`a_Estatico`,`a_Escrollable`, `idpersona`) 
            VALUES 
            (?, ?, ?, ?, ?, ? , ? );";
            $arrData = array(
                $this->titulo = $titulo,
                $this->descripcion = $descripcion,
                $this->sizeAviso = $sizeAviso,
                $this->incrustacion = $incrustacion,
                $this->estatico = $estatico,
                $this->escrolable = $escrolable,
                $this->idPersona = $idPersona
            );
        }

        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function selectAvisos() {
        $query = "SELECT*FROM aviso";
        $request = $this->select_all($query);
        return $request;
    }
    public function updateEstado(int $id, int $estado) {
        $query = "UPDATE `aviso` SET `a_Estado`=? WHERE  `idAviso`=?;";
        $arrData = array($this->estado = $estado, $this->idAviso = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function deleteAviso(int $id) {
        $this->idAviso = $id;
        $query = "DELETE FROM `aviso` WHERE  `idAviso`={$this->idAviso};";
        $request = $this->delete($query);
        return $request;
    }

    public function updateInfo(string $titulo, string $contenido, string $id) {
        $query = "UPDATE `aviso` SET `a_Titulo` = ?, `a_Descripcion` = ? WHERE `aviso`.`idAviso` = ?";
        $arrData = array(
            $this->titulo = $titulo, 
            $this->descripcion = $contenido, 
            $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateEmbed(string $incrustacion, string $id) {
        $query = "UPDATE `aviso` SET `a_Incrustacion` = ? WHERE `aviso`.`idAviso` = ?";
        $arrData = array(
            $this->incrustacion = $incrustacion, 
            $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateSize(string $sizeAviso, string $estatico, string $escrolable, string $id){ 
        $query = "UPDATE `aviso` SET `a_sizeAviso` = ?,  `a_Estatico` = ?, `a_Escrollable` = ? WHERE `aviso`.`idAviso` = ?"; 
        $arrData = array(
            $this->sizeAviso = $sizeAviso, 
            $this->estatico = $estatico, 
            $this->escrolable = $escrolable, 
            $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateFecha( $fechaInicio,  $fechaFin, string $id) {
        $query = "UPDATE `aviso` SET `a_fechaInicio` = ?, `a_fechaFin` = ? WHERE `aviso`.`idAviso` = ?";
        $arrData = array(
            $this->fechaInicio = $fechaInicio, 
            $this->fechaFin = $fechaFin,
            $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
}
