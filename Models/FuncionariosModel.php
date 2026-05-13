<?php
class FuncionariosModel extends Mysql
{
    private $idpersona;
    private $id;
    private $gf_nombre;
    private $gf_descripcion;
    private $gf_foto;
    private $gf_estado;
    private $f_nombres;
    private $f_apellidos;
    private $f_despendecia;
    private $f_cargo;
    private $f_correo;
    private $f_celular;
    private $f_fotoPerfil;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectGruposFuncionarios()
    {
        $query = "SELECT*FROM grupofuncionarios AS gf;";
        $request = $this->select_all($query);
        return $request;
    }
    public function insertGruposFuncionarios(int $idpersona, string $nombre, string $descripcion, string $foto, int $estado)
    {
        $query = "INSERT INTO `grupofuncionarios` 
        (`idpersona`, `gf_nombre`, `gf_descripcion`, `gf_foto`, `gf_estado`) 
        VALUES 
        (?, ?, ?, ?, ?);";
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->gf_nombre = $nombre,
            $this->gf_descripcion = $descripcion,
            $this->gf_foto = $foto,
            $this->gf_estado = $estado
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function updateGrupoFuncionariosActivos(int $estado)
    {
        $query = "UPDATE `grupofuncionarios` SET `gf_estado`=?;";
        $arrData = array(
            $this->gf_estado = $estado
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function deleteGroupFuncionarios(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `grupofuncionarios` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function existFuncionariosInGrupo(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM funcionarios AS f WHERE f.grupofuncionarios_id={$this->id};";
        $request = $this->select_all($query);
        return $request;
    }
    public function updateGropuFuncionarios(int $idpersona, string $titulo, string $descripcion, int $id)
    {
        $query = "UPDATE `grupofuncionarios` 
        SET 
        `idpersona`=?, 
        `gf_nombre`=?, 
        `gf_descripcion`=? 
        WHERE  
        `id`=?;";
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->gf_nombre = $titulo,
            $this->gf_descripcion = $descripcion,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateFileGroupFuncionarios(int $id, string $file)
    {
        $query = "UPDATE `grupofuncionarios` SET `gf_foto`=? WHERE  `id`=?;";
        $arrData = array(
            $this->gf_foto = $file,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateEstadoGrupoFuncionarios(int $id, int $estado)
    {
        $query = "UPDATE `grupofuncionarios` SET `gf_estado`=? WHERE  `id`=?;";
        $arrData = array(
            $this->gf_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateEstadoFuncionarios(int $id, int $estado)
    {
        $query = "UPDATE `funcionarios` SET `f_estado`=? WHERE  `id`=?;";
        $arrData = array(
            $this->gf_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function selectInfoGroupFuncionario(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM grupofuncionarios AS gf WHERE gf.id={$this->id}";
        $request = $this->select($query);
        return $request;
    }
    public function selectFuncionarios(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM funcionarios AS f WHERE f.grupofuncionarios_id={$this->id} ORDER BY f.id DESC;";
        $request = $this->select_all($query);
        return $request;
    }
    public function insertFuncionarios(
        int $id,
        int $idpersona,
        string $nombres,
        string $apellidos,
        string $dependencia,
        string $cargo,
        string $correo,
        string $phone,
        string $foto
    ) {
        $query = "INSERT INTO `funcionarios` 
        (`grupofuncionarios_id`, 
        `idpersona`, 
        `f_nombres`, 
        `f_apellidos`, 
        `f_despendecia`, 
        `f_cargo`, 
        `f_correo`, 
        `f_celular`, 
        `f_fotoPerfil`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $arrData = array(
            $this->id = $id,
            $this->idpersona = $idpersona,
            $this->f_nombres = $nombres,
            $this->f_apellidos = $apellidos,
            $this->f_despendecia = $dependencia,
            $this->f_cargo = $cargo,
            $this->f_correo = $correo,
            $this->f_celular = $phone,
            $this->f_fotoPerfil = $foto
        );
        $request = $this->insert($query, $arrData);
        return $request;
    }
    public function deleteFuncionario(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM `funcionarios` WHERE  `id`={$this->id};";
        $request = $this->delete($query);
        return $request;
    }
    public function updateFuncionario(int $idpersona, string $nombre, string $apellidos, string $dependencia, string $cargo, string $correo, string $celular, int $id)
    {
        $query = "UPDATE `funcionarios` SET 
        `idpersona`=?, 
        `f_nombres`=?, 
        `f_apellidos`=?, 
        `f_despendecia`=?, 
        `f_cargo`=?, 
        `f_correo`=?, 
        `f_celular`=? 
        WHERE  
        `id`=?;";
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->f_nombres = $nombre,
            $this->f_apellidos = $apellidos,
            $this->f_despendecia = $dependencia,
            $this->f_cargo = $cargo,
            $this->f_correo = $correo,
            $this->f_celular = $celular,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
    public function updateFileFuncionario(int $id, string $file)
    {
        $query = "UPDATE `funcionarios` SET `f_fotoPerfil`=? WHERE  `id`=?;";
        $arrData = array(
            $this->f_fotoPerfil = $file, $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }
}
