<?php

class Paginas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(8);
    }

    public function paginas($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 8;
        $data['page_tag'] = "Lista de paginas creadas - MDESV";
        $data['page_title'] = "Paginas - MDESV";
        $data['page_name'] = "Paginas";
        $data['page_functions_js'] = "functions_paginas.js";

        $this->views->getView($this, "paginas", $data);
    }

    public function content($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $arrData = explode(",", $params);

        if (!is_numeric($arrData[0])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $id = intval(strClean($arrData[0]));

        $data['page_id'] = 8;
        $data['page_tag'] = "Contenido de la pagina - MDESV";
        $data['page_title'] = "Contenido - MDESV";
        $data['page_name'] = "Contenido";
        $data['page_infoPagina'] = $this->model->selectInfoPagina($id);
        $data['page_functions_js'] = "functions_content.js";

        $this->views->getView($this, "content", $data);
    }

    public function getPaginas()
    {
        if ($_SESSION['permisosMod']['r']) {

            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';

            $request = $this->model->selectPaginas();
            $cont = 1;

            foreach ($request as $key => $value) {

                if ($value["p_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Activo</span>';
                    $btnEstado = '
                        <button class="btn btn-primary btn-sm btnEstado"
                            data-id="' . $value["id"] . '"
                            data-titulo="' . $value["p_nombre"] . '"
                            data-estado="0">
                            <i class="fa fa-toggle-on"></i>
                        </button>';
                } else {
                    $status = '<span class="badge badge-danger">Inactivo</span>';
                    $btnEstado = '
                        <button class="btn btn-danger btn-sm btnEstado"
                            data-id="' . $value["id"] . '"
                            data-titulo="' . $value["p_nombre"] . '"
                            data-estado="1">
                            <i class="fa fa-toggle-off"></i>
                        </button>';
                }

                $request[$key]["p_estado"] = $status;

                if ($value["p_contenido"] == "") {
                    $contenido = '<span class="badge badge-danger">Sin contenido</span>';
                } else {
                    $contenido = '<span class="badge badge-primary">Con contenido</span>';
                }

                $request[$key]["p_contenido"] = $contenido;

                $request[$key]["link"] = "
                    <a target='_blank' href='" . base_url() . "/page/" . 
                    str_replace(" ", "-", strtolower($value['p_nombre'])) . "'>
                        " . base_url() . "/page/" . 
                        str_replace(" ", "-", strtolower($value['p_nombre'])) . "
                    </a>";

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '
                        <a class="btn btn-sm btn-secondary text-white"
                            href="' . base_url() . '/paginas/content/' . $value["id"] . '">
                            <i class="fa fa-plus"></i>
                        </a>
                        ' . $btnEstado . '
                        <button class="btn btn-primary btn-sm btnEdit"
                            data-id="' . $value["id"] . '"
                            data-nombre="' . $value["p_nombre"] . '"
                            data-descripcion="' . str_replace('"', '«', $value["p_descripcion"]) . '">
                            <i class="fas fa-pencil-alt"></i>
                        </button>';
                }

                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '
                        <button class="btn btn-danger btn-sm btnDel"
                            data-id="' . $value["id"] . '"
                            data-nombre="' . $value["p_nombre"] . '">
                            <i class="far fa-trash-alt"></i>
                        </button>';
                }

                $request[$key]["acciones"] = '
                    <div class="text-center">
                        ' . $btnEdit . ' ' . $btnDelete . '
                    </div>';

                $request[$key]["cont"] = $cont;
                $cont++;
            }

            json($request);
        }
    }

    public function savePagina()
    {
        if ($_SESSION['permisosMod']['w']) {

            if (!$_POST) {
                json(['status' => false, 'msg' => 'Metodo no encontrado']);
                die();
            }

            $txtNombre = strClean($_POST["txtNombre"]);
            $txtDescripcion = strClean($_POST["txtDescripcion"]);
            $idPersona = $_SESSION['idUser'];

            if ($txtNombre == "" || $idPersona == "") {
                json(['status' => false, 'msg' => 'Campos vacios, llene los campos obligatorios']);
                die();
            }

            $request = $this->model->insertPagina($txtNombre, $txtDescripcion, $idPersona);

            if ($request) {
                json(['status' => true, 'msg' => 'Registro completado correctamente']);
            } else {
                json(['status' => false, 'msg' => 'No se completo de manera correcta el registro']);
            }
        }
    }

    public function saveContent()
    {
        if ($_SESSION['permisosMod']['u']) {

            $id = intval(strClean($_POST["idPagina"]));
            $contenido = $_POST["editor"];

            if ($id == "") {
                json(['status' => false, 'msg' => 'Llene los campos obligatorios']);
                die();
            }

            $request = $this->model->saveContent($contenido, $id);

            if ($request) {
                json(['status' => true, 'msg' => 'Contenido guardado correctamente']);
            } else {
                json(['status' => false, 'msg' => 'Ocurrio un error al actualizar el registro']);
            }
        }
    }

    public function deletePagina()
    {
        if ($_SESSION['permisosMod']['d']) {

            if (!$_POST) {
                json(['status' => false, 'msg' => 'Metodo no encontrado']);
                die();
            }

            $id = strClean($_POST["id"]);

            if ($id == "") {
                json(['status' => false, 'msg' => 'Llene los campos obligatorios']);
                die();
            }

            $request = $this->model->deletePagina($id);

            if ($request) {
                json(['status' => true, 'msg' => 'Datos eliminados correctamente']);
            } else {
                json(['status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos']);
            }
        }
    }

    public function updatePagina()
    {
        if ($_SESSION['permisosMod']['u']) {

            if (!$_POST) {
                json(['status' => false, 'msg' => 'Metodo no encontrado']);
                die();
            }

            $id_upd = strClean($_POST["id_upd"]);
            $txtTitulo_upd = strClean($_POST["txtNombre_upd"]);
            $txtDescripcion_upd = strClean($_POST["txtDescripcion_upd"]);
            $idPersona = $_SESSION['idUser'];

            if ($id_upd == "" || $txtTitulo_upd == "" || $idPersona == "") {
                json(['status' => false, 'msg' => 'Llene los campos obligatorios']);
                die();
            }

            $request = $this->model->updatePagina(
                $txtTitulo_upd,
                $txtDescripcion_upd,
                $idPersona,
                $id_upd
            );

            if ($request) {
                json(['status' => true, 'msg' => 'Registro actualizado correctamente']);
            } else {
                json(['status' => false, 'msg' => 'Ocurrio un error al actualizar el registro']);
            }
        }
    }

    public function updateEstadoPagina()
    {
        if ($_SESSION['permisosMod']['u']) {

            if (!$_POST) {
                json(['status' => false, 'msg' => 'Metodo no encontrado']);
                die();
            }

            $id = intval(strClean($_POST["id"]));
            $estado = intval(strClean($_POST["estado"]));

            if ($id == "" || $estado == "") {
                json(['status' => false, 'msg' => 'Campos vacios por favor llene los campos obligatorios']);
                die();
            }

            $request = $this->model->updateCarouselPagina($id, $estado);

            if ($request) {
                json(['status' => true, 'msg' => 'Información carousel actualizada correctamente']);
            } else {
                json(['status' => false, 'msg' => 'Ocurrio un error al actualizar el carousel']);
            }
        }
    }
}
