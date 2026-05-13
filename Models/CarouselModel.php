<?php

class CarouselModel extends Mysql
{
    private $c_estado;
    private $c_titulo;
    private $c_colorTitulo;
    private $c_descripcion;
    private $c_colorDescripcion;
    private $c_archivo;
    private $c_textoOculto;
    private $c_botonOculto;
    private $c_nombreBoton;
    private $c_colorBoton;
    private $c_linkBoton;
    private $idpersona;
    private $id;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectCarousel()
    {
        $query = "SELECT*FROM carousel ;";
        $request = $this->select_all($query);
        return $request;
    }
    public function insertCarousel(
        string $titulo,
        string $colorTitulo,
        string $descripcion,
        string $colorDescripcion,
        string $archivo,
        int $textoOculo,
        int $botonOculto,
        string $nameBtn,
        string $colorBtn,
        string $linkBtn,
        int $idPersona
    ) {
        $query = "INSERT INTO `carousel` (`c_titulo`, `c_colorTitulo`, `c_descripcion`, `c_colorDescripcion`, `c_archivo`, `c_textoOculto`, `c_botonOculto`, `c_nombreBoton`, `c_colorBoton`, `c_linkBoton`, `idpersona`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $arrData = array(
            $this->c_titulo = $titulo,
            $this->c_colorTitulo = $colorTitulo,
            $this->c_descripcion = $descripcion,
            $this->c_colorDescripcion = $colorDescripcion,
            $this->c_archivo = $archivo,
            $this->c_textoOculto = $textoOculo,
            $this->c_botonOculto = $botonOculto,
            $this->c_nombreBoton = $nameBtn,
            $this->c_colorBoton = $colorBtn,
            $this->c_linkBoton = $linkBtn,
            $this->idpersona = $idPersona
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function deleteCarousel(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `carousel` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function updateCarouselConten(
        string $titulo,
        string $colorTitulo,
        string $descripcion,
        string $colorDescripcion,
        int $contentHide,
        int $btnHide,
        string $nameBtn,
        string $color,
        string $link,
        int $idpersona,
        int $id
    ) {
        $query = "UPDATE `carousel` 
        SET 
        `c_titulo`=?, 
        `c_colorTitulo`=?, 
        `c_descripcion`=?, 
        `c_colorDescripcion`=?, 
        `c_textoOculto`=?, 
        `c_botonOculto`=?, 
        `c_nombreBoton`=?, 
        `c_colorBoton`=?, 
        `c_linkBoton`=?, 
        `idpersona`=? 
        WHERE  
        `id`=?;";
        $arrData = array(
            $this->c_titulo = $titulo,
            $this->c_colorTitulo = $colorTitulo,
            $this->c_descripcion = $descripcion,
            $this->c_colorDescripcion = $colorDescripcion,
            $this->c_textoOculto = $contentHide,
            $this->c_botonOculto = $btnHide,
            $this->c_nombreBoton = $nameBtn,
            $this->c_colorBoton = $color,
            $this->c_linkBoton = $link,
            $this->idpersona = $idpersona,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateCarouselEstado(int $id, int $estado)
    {
        $query = "UPDATE `carousel` SET `c_estado`=? WHERE  `id`=?;";
        $arrData = array(
            $this->c_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateFotoCarousel(int $id, string $file)
    {
        $query = "UPDATE `carousel` SET `c_archivo`=? WHERE  `id`=?;";
        $arrData = array($this->c_archivo = $file, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
}
