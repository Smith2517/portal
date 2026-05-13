<?php
class Barrasnavegacion extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(7);
    }

    public function barrasnavegacion($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 7;
        $data['page_tag'] =  "Barra Navegacion - MDESV";
        $data['page_title'] = "Barra Navegacion - MDESV";
        $data['page_name'] = "Barra Navegacion";
        $data['page_functions_js'] = "functions_barrasnavegacion.js";
        $data['page_cbxTipoBarras'] = $this->model->tipobarras();
        $this->views->getView($this, "barrasnavegacion", $data);
    }
    public function sections($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $arrParams = explode(",", $params);
        if (!is_numeric($arrParams[0])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $id = $arrParams[0];
        $request = $this->model->selectBarraNavegacionInfo($id);
        if (!$request) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 7;
        $data['page_tag'] =  "Secciones - MDESV";
        $data['page_title'] = "Secciones - MDESV";
        $data['page_name'] = "Secciones";
        $data['page_infoFooter'] = $request;
        $data['page_functions_js'] = "functions_secciones.js";
        $this->views->getView($this, "secciones", $data);
    }
    public function items($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $arrParams = explode(",", $params);
        if (!is_numeric($arrParams[0])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $id = $arrParams[0];
        $request = $this->model->selectSectionInfo($id);
        if (!$request) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 7;
        $data['page_tag'] =  "Items - MDESV";
        $data['page_title'] = "Items - MDESV";
        $data['page_name'] = "Items";
        $data['page_infoSection'] = $request;
        $data['page_functions_js'] = "functions_items.js";
        $this->views->getView($this, "items", $data);
    }
    public function getBarrasnavegacion()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectBarrasNavegacion();
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["bn_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Publicado</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstadoFooter"  
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["bn_titulo"] . '" 
                    data-estado="' . (($value["bn_estado"] == 1) ? 0 : 1) . '"
                    data-idtipobarras="' . $value["tipobarras_id"] . '"
                    ><i class="fa fa-toggle-on"></i></button>';
                } else if ($value["bn_estado"] == 0) {
                    $status = '<span class="badge badge-danger">No publicado</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstadoFooter"
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["bn_titulo"] . '" 
                    data-estado="' . (($value["bn_estado"] == 1) ? 0 : 1) . '"
                    data-idtipobarras="' . $value["tipobarras_id"] . '"
                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["bn_estado"] = $status;
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<a href="' . base_url() . '/barrasnavegacion/sections/' . $value["id"] . '/' . strtolower(str_replace(" ", "-", $value["bn_titulo"])) . '" class="btn btn-primary btn-sm" ><i class="fa fa-window-maximize" aria-hidden="true"></i></a>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . ' <button class="btn btn-primary btn-sm btnEdit" data-tipobarra="' . $value["tb_nombre"] . '" data-id="' . $value["id"] . '" data-titulo="' . $value["bn_titulo"] . '" data-descripcion="' .  str_replace('"', "«", $value["bn_descripcion"]) . '" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-titulo="' . $value["bn_titulo"] . '" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                                    </div>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' .  $btnView . ' '  . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function getSection($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrParams = explode(",", $params);
            if (!is_numeric($arrParams[0])) {
                header("Location:" . base_url() . '/dashboard');
                die();
            }
            $id = $arrParams[0];
            $request = $this->model->selectSection($id);
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["sbn_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Publicado</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstadoFooter"  
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["sbn_titulo"] . '" 
                    data-estado="' . (($value["sbn_estado"] == 1) ? 0 : 1) . '" ><i class="fa fa-toggle-on"></i></button>';
                } else if ($value["sbn_estado"] == 0) {
                    $status = '<span class="badge badge-danger">No publicado</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstadoFooter"
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["sbn_titulo"] . '" 
                    data-estado="' . (($value["sbn_estado"] == 1) ? 0 : 1) . '"
                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["sbn_estado"] = $status;
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<a href="' . base_url() . '/barrasnavegacion/items/' . $value["id"] . '/' . strtolower(str_replace(" ", "-", $value["sbn_titulo"])) . '" class="btn btn-primary btn-sm" ><i class="fa fa-window-maximize" aria-hidden="true"></i></a>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . ' <button class="btn btn-primary btn-sm btnEdit" data-id="' . $value["id"] . '" data-titulo="' . $value["sbn_titulo"] . '" data-descripcion="' .  str_replace('"', "«", $value["sbn_descripcion"]) . '" data-url="' . $value["sbn_url"] . '" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-titulo="' . $value["sbn_titulo"] . '" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                                    </div>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' .  $btnView . ' '  . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function getItems($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrParams = explode(",", $params);
            if (!is_numeric($arrParams[0])) {
                header("Location:" . base_url() . '/dashboard');
                die();
            }
            $id = $arrParams[0];
            $request = $this->model->selectItems($id);
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["is_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Publicado</span>';
                } else if ($value["is_estado"] == 0) {
                    $status = '<span class="badge badge-danger">No publicado</span>';
                }
                $request[$key]["is_estado"] = $status;
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = ' <button class="btn btn-primary btn-sm btnEdit" data-id="' . $value["id"] . '" data-nombre="' . $value["is_nombre"] . '" data-url="' . $value["is_link"] . '"  data-target="' . $value["is_target"] . '" data-icon="' . str_replace('"', '«', $value["is_icon"]) . '"  title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-nombre="' . $value["is_nombre"] . '" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                                    </div>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' .  $btnView . ' '  . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function saveBarraNavegacion()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $txtTitulo = strClean($_POST["txtTitulo"]);
            $txtDescripcion = strClean($_POST["txtDescripcion"]);
            $idPersona = $_SESSION['idUser'];
            $cbxListEstatus = intval(strClean($_POST["cbxListEstatus"]));
            if ($txtTitulo == ""  || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios, llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateEstado(0, $cbxListEstatus);
            $request = $this->model->insertBarraNavegacion($idPersona, $txtTitulo, $txtDescripcion, $cbxListEstatus);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro completado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo de manera correcta el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function saveSection()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $txtTitulo = strClean($_POST["txtTitulo"]);
            $txtDescripcion = strClean($_POST["txtDescripcion"]);
            $idPersona = $_SESSION['idUser'];
            $idFooter = intval(strClean($_POST["idFooter"]));
            $txtUrl = isset($_POST["txtUrl"]) ? strClean($_POST["txtUrl"]) : "";
            if ($txtTitulo == ""  || $idPersona == "" || $idFooter == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios, llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->insertSection($idFooter, $idPersona, $txtTitulo, $txtDescripcion, $txtUrl);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro completado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo de manera correcta el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function saveItems()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $txtNombre = strClean($_POST["txtNombre"]);
            $txtUrl = strClean($_POST["txtUrl"]);
            $cbxTarget = strClean($_POST["cbxTarget"]);
            $txtIcon = strClean($_POST["txtIcon"]);
            $idPersona = $_SESSION['idUser'];
            $section_id = intval(strClean($_POST["section_id"]));
            if ($txtNombre == ""  || $idPersona == "" || $section_id == ""  || $cbxTarget == "" || $txtIcon == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios, llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->insertItem($section_id,  $idPersona,  $txtNombre,  $txtUrl,  $cbxTarget,  $txtIcon);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro completado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo de manera correcta el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function delBarraNavegacion()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->deleteBarraNavegacion($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
    public function deleteSections()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->deleteSection($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
    public function deleteItem()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->deleteItem($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
    public function updateBarraNavegacion()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id_upd = strClean($_POST["id_upd"]);
            $txtTitulo_upd = strClean($_POST["txtTitulo_upd"]);
            $txtDescripcion_upd = strClean($_POST["txtDescripcion_upd"]);
            $idPersona = $_SESSION['idUser'];
            if ($id_upd == "" || $txtTitulo_upd == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateBarraNavegacion($idPersona,  $txtTitulo_upd,  $txtDescripcion_upd,  $id_upd);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al actualizar el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateSection()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id_upd = strClean($_POST["id_upd"]);
            $txtTitulo_upd = strClean($_POST["txtTitulo_upd"]);
            $txtDescripcion_upd = strClean($_POST["txtDescripcion_upd"]);
            $idPersona = $_SESSION['idUser'];
            $txtUrl_upd = isset($_POST["txtUrl_upd"]) ? strClean($_POST["txtUrl_upd"]) : "";
            if ($id_upd == "" || $txtTitulo_upd == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateSection($idPersona,  $txtTitulo_upd,  $txtDescripcion_upd, $txtUrl_upd, $id_upd);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al actualizar el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateItem()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id_upd = strClean($_POST["id_upd"]);
            $txtNombre_upd = strClean($_POST["txtNombre_upd"]);
            $txtUrl_upd = strClean($_POST["txtUrl_upd"]);
            $cbxTarget_upd = strClean($_POST["cbxTarget_upd"]);
            $txtIcon_upd = strClean($_POST["txtIcon_upd"]);
            $idPersona = $_SESSION['idUser'];
            if ($id_upd == "" || $txtNombre_upd == "" || $txtNombre_upd == "" || $txtUrl_upd == "" || $cbxTarget_upd == "" || $txtIcon_upd == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateItem($idPersona,  $txtNombre_upd,  $txtUrl_upd,  $cbxTarget_upd,  $txtIcon_upd,  $id_upd);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al actualizar el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateEstadoBarraNavegacion()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id"]));
            $estado = strClean($_POST["estado"]);
            $idtipobarras = intval(strClean($_POST["idtipobarras"]));
            if ($id == "" || $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos que son obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateEstado(0, $idtipobarras);
            $request = $this->model->updateEstadoBarraNavegacion($estado, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Estado actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error inesperado, al actualizar el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateEstadoSection()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id"]));
            $estado = strClean($_POST["estado"]);
            if ($id == "" || $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos que son obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateEstadoSection($estado, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Estado actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error inesperado, al actualizar el registro');
                json($arrResponse);
                die();
            }
        }
    }
}
