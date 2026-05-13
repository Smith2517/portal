<?php
class IntegrantessciModel extends Mysql
{
    private $idpersona;
    private $id;
    private $i_nombres;
    private $i_apellidos;
    private $i_cargo;
    private $i_dependencia;
    private $i_correo;
    private $i_celular;
    private $i_foto;
    private $i_estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectIntegrantesSci()
    {
        $query = "SELECT * FROM integrantessci ORDER BY i_orden ASC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectIntegrantesSciActivos()
    {
        $query = "SELECT * FROM integrantessci WHERE i_estado = 1 ORDER BY i_orden ASC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertIntegranteSci(
        int $idpersona,
        string $nombres,
        string $apellidos,
        string $cargo,
        string $dependencia,
        string $correo,
        string $celular,
        string $foto,
        int $estado
    ) {
        $query = "INSERT INTO integrantessci 
        (idpersona, i_nombres, i_apellidos, i_cargo, i_dependencia, i_correo, i_celular, i_foto, i_estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->i_nombres = $nombres,
            $this->i_apellidos = $apellidos,
            $this->i_cargo = $cargo,
            $this->i_dependencia = $dependencia,
            $this->i_correo = $correo,
            $this->i_celular = $celular,
            $this->i_foto = $foto,
            $this->i_estado = $estado
        );
        
        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function updateIntegranteSci(
        int $idpersona,
        string $nombres,
        string $apellidos,
        string $cargo,
        string $dependencia,
        string $correo,
        string $celular,
        int $id
    ) {
        $query = "UPDATE integrantessci SET 
        idpersona = ?,
        i_nombres = ?,
        i_apellidos = ?,
        i_cargo = ?,
        i_dependencia = ?,
        i_correo = ?,
        i_celular = ?
        WHERE id = ?;";
        
        $arrData = array(
            $this->idpersona = $idpersona,
            $this->i_nombres = $nombres,
            $this->i_apellidos = $apellidos,
            $this->i_cargo = $cargo,
            $this->i_dependencia = $dependencia,
            $this->i_correo = $correo,
            $this->i_celular = $celular,
            $this->id = $id
        );
        
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateFileIntegranteSci(int $id, string $file)
    {
        $query = "UPDATE integrantessci SET i_foto = ? WHERE id = ?;";
        $arrData = array(
            $this->i_foto = $file,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function updateEstadoIntegranteSci(int $id, int $estado)
    {
        $query = "UPDATE integrantessci SET i_estado = ? WHERE id = ?;";
        $arrData = array(
            $this->i_estado = $estado,
            $this->id = $id
        );
        $request = $this->update($query, $arrData);
        return $request;
    }

    public function deleteIntegranteSci(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM integrantessci WHERE id = {$this->id};";
        $request = $this->delete($query);
        return $request;
    }
}
