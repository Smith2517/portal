<?php

class BlogModel extends Mysql
{
    private $name;
    private $titulo;
    private $tituloGuion;
    private $subtitulo;
    private $contenido;
    private $img;
    private $descripcion;
    private $file;
    private $idpersona;
    private $id;
    private $idCategoria;
    private $idBlog;
    private $estado;
    private $c_imagen;
    private $b_imagen;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectCategorias()
    {
        $query = "SELECT*FROM categorias;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectBlogs(int $id)
    {
        $this->id = $id;
        $sql = "SELECT*FROM blog AS b 
        inner join persona AS p ON p.idpersona=b.idpersona
        inner join categorias AS c ON c.idCategoria=b.idCategoria
        WHERE b.idCategoria={$this->id} ORDER BY b.idBlog ASC;";
        $request = $this->select_all($sql);
        return $request;
    }
    public function getCategoriaByName($name)
    {
        return $this->selectOne("SELECT * FROM categorias WHERE c_Categoria = ?", [$name]);
    }
    public function insertCategoria(string $categoria, string $descripcion, string $imagen, int $idpersona)
    {
        $query = "INSERT INTO `categorias` (`c_Categoria`, `c_Descripcion`, `c_Imagen`, `idpersona`) VALUES (?, ?, ?, ?);";
        $arrData = array(
            $this->name = $categoria,
            $this->descripcion = $descripcion,
            $this->c_imagen = $imagen,
            $this->idpersona = $idpersona
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function insertBlog(string $tituloBlog, string $subtitulo, string $contenido, string $imagen, string $descripcionImg, string $file, int $categoria_id, int $idPersona)
    {
        $query = "INSERT INTO `blog` 
        (`b_Titulo`,`b_tituloGuion`, `b_subTitulo`, `b_Contenido`, `b_Imagen`, `b_descripcionImagen`, `b_Embed`, `idCategoria`, `idpersona`) 
        VALUES 
        (?, ?,?, ?, ?, ?, ?, ?, ?);";
        $arrData = array(
            $this->titulo = $tituloBlog,
            $this->tituloGuion = str_replace(" ", "-", strtolower($tituloBlog)),
            $this->subtitulo = $subtitulo,
            $this->contenido = $contenido,
            $this->img = $imagen,
            $this->descripcion = $descripcionImg,
            $this->file = $file,
            $this->idCategoria = $categoria_id,
            $this->idpersona = $idPersona
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function updateEstado(int $id, int $estado)
    {
        $query = "UPDATE `categorias` SET `c_Estado`=? WHERE  `idCategoria`=?;";
        $arrData = array($this->estado = $estado, $this->idCategoria = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateEstadoBlog(int $id, int $estado)
    {
        $query = "UPDATE `blog` SET `b_Estado`=? WHERE  `idBlog`=?;";
        $arrData = array($this->estado = $estado, $this->idBlog = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function deleteCategoria(int $id)
    {
        $this->idCategoria = $id;
        $query = "DELETE FROM `categorias` WHERE `idCategoria`={$this->idCategoria};";
        $request = $this->delete($query);
        return $request;
    }
    public function deleteBlog(int $id)
    {
        $this->idCategoria = $id;
        $query = "DELETE FROM `blog` WHERE `idBlog`={$this->idCategoria};";
        $request = $this->delete($query);
        return $request;
    }

    public function editCategoria(string $name, string $descripcion, string $id)
    {
        $query = "UPDATE `categorias` SET `c_Categoria` = ? , `c_Descripcion` = ? WHERE `categorias`.`idCategoria` = ?";
        $arrData = array(
            $this->name = $name,
            $this->descripcion = $descripcion,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function editFileCategoria(int $id, string $imagen)
    {
        $query = "UPDATE `categorias` 
        SET `c_Imagen`=? WHERE  `idCategoria`=?;";
        $arrData = array($this->c_imagen = $imagen, $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function selectcategoria()
    {
        $query = "SELECT*FROM categorias AS c WHERE c.c_Estado=1;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectCategoriaInfo(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM categorias AS c WHERE c.idCategoria={$this->id}  AND c.c_Estado=1;";
        $request = $this->select($query);
        return $request;
    }
    public function verificarRegVinculadosBlog(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM blog AS b WHERE b.idCategoria={$this->id};";
        $request = $this->select_all($query);
        return $request;
    }

    public function editarInfoBlog(string $titulo, string $subtitulo, string $contenido, string $id)
    {
        $query = "UPDATE `blog` SET `b_Titulo` = ? , `b_subTitulo` = ? , `b_Contenido` = ? WHERE `blog`.`idBlog` = ?";
        $arrData = array(
            $this->titulo = $titulo,
            $this->subtitulo = $subtitulo,
            $this->contenido = $contenido,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function editarImgBlog(int $id, string $imagen, $descripcion)
    {
        $query = "UPDATE `blog` 
        SET `b_Imagen`=? , `b_descripcionImagen`=? WHERE  `idBlog`=?;";
        $arrData = array(
            $this->b_imagen = $imagen,
            $this->descripcion = $descripcion, 
            $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function editarEmbedBlog(string $embed, string $id) {
        $query = "UPDATE `blog` SET `b_Embed` = ? WHERE `blog`.`idBlog` = ?";
        $arrData = array(
            $this->file = $embed, 
            $this->id = $id);
        $request = $this->update($query, $arrData);
        return $request;
    }
}
