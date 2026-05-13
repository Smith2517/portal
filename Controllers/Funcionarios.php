<?php
class Funcionarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(6);
    }

    public function grupofuncionarios($params = null)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $arrData = explode(',', $params);
        $data['page_id'] = 6;
        $data['page_functions_js'] = "functions_grupofuncionarios.js";
        if ($arrData[0] == "add") {
            if (!is_numeric($arrData[1])) {
                header("Location:" . base_url() . '/dashboard');
                die();
            }
            $id = (intval(strClean($arrData[1])));
            $arrDataGF = $this->model->selectInfoGroupFuncionario($id);
            if (!$arrDataGF) {
                header("Location:" . base_url() . '/dashboard');
                die();
            }
            $data['page_tag'] = "Agregar Funcionario - MDESV";
            $data['page_title'] = "Agregar Funcionario - MDESV";
            $data['page_name'] = "Agregar Funcionario";
            $data['page_infoGrupoFuncionario'] = $arrDataGF;
            $this->views->getView($this, "addfuncionarios", $data);
        } else {
            $data['page_tag'] = "Grupo Funcionarios - MDESV";
            $data['page_title'] = "Grupo Funcionarios - MDESV";
            $data['page_name'] = "Grupos Funcionarios";
            $this->views->getView($this, "grupofuncionarios", $data);
        }
    }
    public function getGruposFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $btnRegister = '';
            $request = $this->model->selectGruposFuncionarios();
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["gf_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Activo</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstado"  
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["gf_nombre"] . '" 
                    data-estado="' . (($value["gf_estado"] == 1) ? 0 : 1) . '" ><i class="fa fa-toggle-on"></i></button>';
                } else if ($value["gf_estado"] == 0) {
                    $status = '<span class="badge badge-danger">Inactivo</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstado"
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["gf_nombre"] . '" 
                    data-estado="' . (($value["gf_estado"] == 1) ? 0 : 1) . '"
                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["gf_estado"] = $status;
                $request[$key]["link"] = '<a href="' . base_url() . "/page/funcionarios/" . strtolower(str_replace(" ", "-", $value["gf_nombre"])) . "/" . $value["id"] . '" target="_Blank" >' . base_url() . "/page/funcionarios/" . strtolower(str_replace(" ", "-", $value["gf_nombre"])) . "/" . $value["id"] . '</a>';
                /* if ($_SESSION['permisosMod']['r']) {
                 $btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol"  title="Permisos"><i class="fas fa-eye"></i></button>';
             }*/
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . '
                    <button class="btn btn-primary btn-sm btnEditFile" 
                    data-id="' . $value["id"] . '"
                    data-image="' . $value["gf_foto"] . '"
                    title="Editar"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>

                    <button class="btn btn-primary btn-sm btnEdit" 
                    data-id="' . $value["id"] . '" 
                    data-nombre="' . $value["gf_nombre"] . '" 
                    data-descripcion="' . $value["gf_descripcion"] . '"                     title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['w']) {
                    $btnRegister = '<a href="' . base_url() . '/funcionarios/grupofuncionarios/add/' . $value["id"] . '" class="btn btn-primary btn-sm btnReg" title="Nuevo funcionario"><i class="fa fa-user-o"></i></a>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-file="' . $value["gf_foto"] . '" data-nombre="' . $value["gf_nombre"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' /* $btnView . ' ' */ . $btnEdit . ' ' . $btnRegister . ' ' . $btnDelete . '</div>';
                $request[$key]['cont'] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function getFuncionariosId($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            if (!is_numeric(explode(",", $params)[0])) {
                die();
            }
            $id = intval(explode(",", $params)[0]);
            $request = $this->model->selectFuncionarios($id);
            $cont = 1;
            $estado = "";
            foreach ($request as $key => $value) {
                $request[$key]["trabajador"] = $value['f_nombres'] . ' ' . $value['f_apellidos'];
                if ($value["f_estado"] == 1) {
                    $estado = '<span class="badge badge-primary">Activo</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstadoFuncionario"  
                                    data-id="' . $value["id"] . '" 
                                    data-nombre="' . $value["f_nombres"] . '" 
                                    data-estado="' . (($value["f_estado"] == 1) ? 0 : 1) . '" ><i class="fa fa-toggle-on"></i></button>';
                } else {
                    $estado = '<span class="badge badge-danger">Inactivo</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstadoFuncionario"
                                    data-id="' . $value["id"] . '" 
                                    data-nombre="' . $value["f_nombres"] . '" 
                                    data-estado="' . (($value["f_estado"] == 1) ? 0 : 1) . '"
                                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["f_estado"] = $estado;
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . '
                    <button class="btn btn-primary btn-sm btnEditFileFuncionario" 
                    data-id="' . $value["id"] . '"
                    data-image="' . $value["f_fotoPerfil"] . '"
                    title="Editar"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEditFuncionario" 
                    data-id="' . $value["id"] . '"
                    data-nombres="' . $value["f_nombres"] . '"
                    data-apellidos="' . $value["f_apellidos"] . '"
                    data-dependencia="' . $value["f_despendecia"] . '"
                    data-cargo="' . $value["f_cargo"] . '"
                    data-correo="' . $value["f_correo"] . '"
                    data-celular="' . $value["f_celular"] . '"
                    title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDelFuncionario" data-id="' . $value["id"] . '" data-file="' . $value["f_fotoPerfil"] . '" data-nombre="' . $value["f_nombres"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' /* $btnView . ' ' */ . $btnEdit  . ' ' . $btnDelete . '</div>';

                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function saveGrupoFuncionarios()
    {
        if ($_SESSION['permisosMod']['w']) {
            
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo"])) {
                $arrResponse = array('status' => false, 'msg' => 'Por favor seleccione una imagen');
                json($arrResponse);
                die();
            }
            $arrSize = getimagesize($_FILES["flArchivo"]["tmp_name"]);
            if ($arrSize[0] < 2046 || $arrSize[0] > 2059) {
                $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [2046 - 2059]px, Medida Actual : ' . $arrSize[0] . "px");
                json($arrResponse);
                die();
            }
            if ($arrSize[1] < 746 || $arrSize[1] > 789) {
                $arrResponse = array('status' => false, 'msg' => 'El alto de la imagen no cumple con el rango permitido [746 - 789]px, Medida Actual : ' . $arrSize[1] . "px");
                json($arrResponse);
                die();
            }
            $txtNombre = strClean($_POST["txtNombre"]);
            $flArchivo = $_FILES["flArchivo"]["name"];
            $txtDescripcion = strClean($_POST["txtDescripcion"]);
            $idPersona = $_SESSION['idUser'];
            $estado = 1;
            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $flArchivo;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            if ($txtNombre == "" || $txtDescripcion == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'LLene los campos que son obligatorios de la descripción');
                json($arrResponse);
                die();
            }
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            $request = $this->model->insertGruposFuncionarios($idPersona,  $txtNombre,  $txtDescripcion,  $file,  $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Grupo de funcionarios registrado y publicado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al registrar el carousel');
            }
            json($arrResponse);
        }
    }
    public function deleteGrupoFuncionarios()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            $file = strClean($_POST["file"]);
            if ($id == "" || $file == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->existFuncionariosInGrupo($id);
            if (count($request) > 0) {
                $arrResponse = array('status' => false, 'msg' => 'Grupo de funcionarios ya contiene registros, no se puede eliminar');
                json($arrResponse);
                die();
            }
            if (is_file(path_upload() . 'images/' . $file)) {
                unlink(path_upload()  . 'images/' . $file);
            }
            $request = $this->model->deleteGroupFuncionarios($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
            die();
        }
    }
    public function deleteFuncionario()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            $file = strClean($_POST["file"]);
            if ($id == "" || $file == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            if (is_file(path_upload() . 'images/' . $file)) {
                unlink(path_upload()  . 'images/' . $file);
            }
            $request = $this->model->deleteFuncionario($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
            die();
        }
    }
    public function updateGrupoFuncionarios()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $titulo = strClean($_POST["txtNombregf_upd"]);
            $descripcion = strClean($_POST["txtDescripciongf_upd"]);
            $idpersona = $_SESSION['idUser'];
            $id = intval(strClean($_POST["idgf_upd"]));
            if ($titulo == "" || $idpersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateGropuFuncionarios($idpersona,  $titulo,  $descripcion,  $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualidado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo el actualizado del registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateFuncionario()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["idF_upd"]));
            $nombre = strClean($_POST["txtNombref_upd"]);
            $apellidos = strClean($_POST["txtApellidos_upd"]);
            $idpersona = $_SESSION['idUser'];
            $dependencia = strClean($_POST["txtDependecia_upd"]);
            $cargo = strClean($_POST["txtCargo_upd"]);
            $correo = strClean($_POST["txtMail_upd"]);
            $celular = strClean($_POST["txtPhone_upd"]);
            if ($nombre == "" || $idpersona == "" || $apellidos == "" || $idpersona == "" || $dependencia == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateFuncionario($idpersona,  $nombre,  $apellidos,  $dependencia,  $cargo,  $correo,  $celular,  $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualidado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo el actualizado del registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateFileGroupFuncionarios()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo_updFil"])) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no seleccionado, seleccione un archivo por favor');
                json($arrResponse);
                die();
            }
            $arrSize = getimagesize($_FILES["flArchivo_updFil"]["tmp_name"]);
            if ($arrSize[0] < 2046 || $arrSize[0] > 2059) {
                $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [2046 - 2059]px, Medida Actual : ' . $arrSize[0] . "px");
                json($arrResponse);
                die();
            }
            if ($arrSize[1] < 746 || $arrSize[1] > 789) {
                $arrResponse = array('status' => false, 'msg' => 'El alto de la imagen no cumple con el rango permitido [746 - 789]px, Medida Actual : ' . $arrSize[1] . "px");
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["ip_updFil"]));
            $file = $_FILES["flArchivo_updFil"]["name"];
            $idPersona = $_SESSION['idUser'];
            $fileOld = strClean($_POST["photoOld_updFil"]);
            if ($id == "" || $file == "" || $fileOld == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }
            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $file;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo_updFil"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            if (is_file($ruta . $fileOld) && !unlink($ruta . $fileOld)) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no eliminado');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateFileGroupFuncionarios($id, $file);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Foto de carousel actualizada');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar le registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateEstadoGruposFuncionarios()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id"]));
            $estado = intval(strClean($_POST["estado"]));
            if ($id == "" || $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios por favor llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateEstadoGrupoFuncionarios($id, $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Información actualizada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al actualizar el carousel');
            }
            json($arrResponse);
        }
    }
    public function updateEstadoFuncionario()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id"]));
            $estado = intval(strClean($_POST["estado"]));
            if ($id == "" || $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios por favor llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateEstadoFuncionarios($id, $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Información actualizada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al actualizar la informacion del item');
            }
            json($arrResponse);
        }
    }
    public function saveFuncionario()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivoFuncionario"])) {
                $arrResponse = array('status' => false, 'msg' => 'Por favor seleccione una imagen');
                json($arrResponse);
                die();
            }
            $arrSize = getimagesize($_FILES["flArchivoFuncionario"]["tmp_name"]);
            if ($arrSize[0] < 410 || $arrSize[0] > 450) {
                $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [410 - 449]px, Medida Actual : ' . $arrSize[0] . "px");
                json($arrResponse);
                die();
            }
            if ($arrSize[1] < 510 || $arrSize[1] > 550) {
                $arrResponse = array('status' => false, 'msg' => 'El alto de la imagen no cumple con el rango permitido [511 - 549]px, Medida Actual : ' . $arrSize[1] . "px");
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["idGrupoFuncionarios"]));
            $txtNombre = strClean($_POST["txtNombre"]);
            $flArchivo = $_FILES["flArchivoFuncionario"]["name"];
            $txtApellidos = strClean($_POST["txtApellidos"]);
            $txtDependecia = strClean($_POST["txtDependecia"]);
            $txtCargo = strClean($_POST["txtCargo"]);
            $txtMail = strClean($_POST["txtMail"]);
            $txtPhone = strClean($_POST["txtPhone"]);
            $idPersona = $_SESSION['idUser'];
            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $flArchivo;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            if ($txtNombre == "" || $txtApellidos == "" || $idPersona == "" || $txtDependecia == "" || $txtCargo == "") {
                $arrResponse = array('status' => false, 'msg' => 'LLene los campos que son obligatorios de la descripción');
                json($arrResponse);
                die();
            }
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivoFuncionario"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            $request = $this->model->insertFuncionarios(
                $id,
                $idPersona,
                $txtNombre,
                $txtApellidos,
                $txtDependecia,
                $txtCargo,
                $txtMail,
                $txtPhone,
                $file
            );
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Grupo de funcionarios registrado y publicado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al registrar el carousel');
            }
            json($arrResponse);
        }
    }
    public function updateFileFuncionario()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo_updFilFuncionario"])) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no seleccionado, seleccione un archivo por favor');
                json($arrResponse);
                die();
            }
            $arrSize = getimagesize($_FILES["flArchivo_updFilFuncionario"]["tmp_name"]);
            if ($arrSize[0] < 410 || $arrSize[0] > 450) {
                $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [410 - 449]px, Medida Actual : ' . $arrSize[0] . "px");
                json($arrResponse);
                die();
            }
            if ($arrSize[1] < 510 || $arrSize[1] > 550) {
                $arrResponse = array('status' => false, 'msg' => 'El alto de la imagen no cumple con el rango permitido [511 - 549]px, Medida Actual : ' . $arrSize[1] . "px");
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["ip_updFilFuncionario"]));
            $file = $_FILES["flArchivo_updFilFuncionario"]["name"];
            $idPersona = $_SESSION['idUser'];
            $fileOld = strClean($_POST["photoOld_updFilFuncionario"]);
            if ($id == "" || $file == "" || $fileOld == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }
            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $file;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo_updFilFuncionario"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            if (is_file($ruta . $fileOld) && !unlink($ruta . $fileOld)) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no eliminado');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateFileFuncionario($id, $file);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Foto de carousel actualizada');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar le registro');
                json($arrResponse);
                die();
            }
        }
    }
}
