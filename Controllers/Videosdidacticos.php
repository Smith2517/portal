<?php
class Videosdidacticos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(20);
    }

    public function videosdidacticos()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 20;
        $data['page_tag'] = "Videos Didácticos - MDESV";
        $data['page_title'] = "Videos Didácticos de Control Interno";
        $data['page_name'] = "Videos Didácticos";
        $data['page_functions_js'] = "functions_videosdidacticos.js";
        $this->views->getView($this, "videosdidacticos", $data);
    }

    public function getVideosdidacticos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectVideosdidacticos();
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["vd_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Activo</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["vd_nombre"] . '"
                    data-estado="' . (($value["vd_estado"] == 1) ? 0 : 1) . '" ><i class="fa fa-toggle-on"></i></button>';
                } else if ($value["vd_estado"] == 0) {
                    $status = '<span class="badge badge-danger">Inactivo</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["vd_nombre"] . '"
                    data-estado="' . (($value["vd_estado"] == 1) ? 0 : 1) . '"
                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["vd_estado"] = $status;

                $videoBtn = '<a href="' . $value["vd_enlace"] . '" target="_blank" class="btn btn-info btn-sm" title="Ver video"><i class="fas fa-play"></i></a>';

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . '
                    <button class="btn btn-primary btn-sm btnEdit"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["vd_nombre"] . '"
                    data-enlace="' . $value["vd_enlace"] . '"
                    data-orden="' . $value["vd_orden"] . '"
                    title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-nombre="' . $value["vd_nombre"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' . $videoBtn . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }

    public function saveVideosdidacticos()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }

            $txtNombre = strClean($_POST["txtNombre"]);
            $txtEnlace = strClean($_POST["txtEnlace"]);
            $txtOrden = strClean($_POST["txtOrden"]);
            $idPersona = $_SESSION['idUser'];
            $estado = 1;

            // Extraer ID del video de YouTube
            $videoId = $this->extractVideoId($txtEnlace);
            $thumbnail = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : "";

            if ($txtNombre == "" || $txtEnlace == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $request = $this->model->insertVideosdidacticos(
                $idPersona,
                $txtNombre,
                $txtEnlace,
                $thumbnail,
                $txtOrden,
                $estado
            );

            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Video registrado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al registrar el video');
            }
            json($arrResponse);
        }
    }

    private function extractVideoId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }

    public function updateVideosdidacticos()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id_upd"]));
            $txtNombre = strClean($_POST["txtNombre_upd"]);
            $txtEnlace = strClean($_POST["txtEnlace_upd"]);
            $txtOrden = strClean($_POST["txtOrden_upd"]);
            $idPersona = $_SESSION['idUser'];

            if ($id == "" || $txtNombre == "" || $txtEnlace == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            // Extraer ID del video de YouTube
            $videoId = $this->extractVideoId($txtEnlace);
            $thumbnail = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : "";

            $request = $this->model->updateVideosdidacticos(
                $idPersona,
                $txtNombre,
                $txtEnlace,
                $thumbnail,
                $txtOrden,
                $id
            );

            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Video actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al actualizar el video');
            }
            json($arrResponse);
        }
    }

    public function updateEstadoVideosdidacticos()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id"]));
            $estado = intval(strClean($_POST["estado"]));

            if ($id == "" || $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacíos');
                json($arrResponse);
                die();
            }

            $request = $this->model->updateEstadoVideosdidacticos($id, $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Estado actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al actualizar el estado');
            }
            json($arrResponse);
        }
    }

    public function deleteVideosdidacticos()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);

            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $request = $this->model->deleteVideosdidacticos($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
}
