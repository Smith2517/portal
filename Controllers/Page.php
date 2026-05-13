<?php
class Page extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
    public function page($params)
    {
        if (empty($params)) {
            notFound();
            die();
        }
    
        $arrParams = explode(",", $params);
        $slug = $arrParams[0];
    
        // Soporte para URL amigable /page/slug
        if (!isset($arrParams[1])) {
            $request = $this->model->selectInfoPageBySlug($slug);
        } else {
            // Soporte legacy (URL con ID al final)
            $id = intval($arrParams[1]);
            $request = $this->model->selectInfoPage($id);
        }
    
        if (!$request || $request["p_estado"] == 0) {
            notFound();
            die();
        }
    
        $data['page_infoPage'] = $request;
        $data['page_id'] = 1;
        $data['page_tag'] = $request['p_nombre'];
        $data['page_title'] = $request['p_nombre'];
        $data['page_name'] = "page";
        $data['page_functions_js'] = "functions_page.js";
    
        $this->views->getView($this, "page", $data);
    }
    public function normasmunicipales($params)
    {
        $arrParams = explode(",", $params);
        $id = (isset($arrParams[0]) && !empty($arrParams[0])) ? $arrParams[0] : 0;
        $year = (isset($arrParams[1]) && !empty($arrParams[1])) ? $arrParams[1] : 0;
        $id = strClean($id);
        $year = strClean($year);
        $data['page_id'] = 1;
        $data['page_tag'] = "Normas Municipales";
        $data['page_title'] = "Normas Municipales";
        $data['page_name'] = "normasmunicipales";
        $data['page_content'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, quis. Perspiciatis repellat perferendis accusamus, ea natus id omnis, ratione alias quo dolore tempore dicta cum aliquid corrupti enim deserunt voluptas.";
        $data['page_arrData'] = array(
            "id" => $id,
            "year" => $this->model->getYearNormasMunicipales($id),
            "description" => $this->model->getInfoNormaMunicipal($id),
            "thisYear" => $year
        );
        $data['page_functions_js'] = "functions_normasmunicipales.js";
        $this->views->getView($this, "normasmunicipales", $data);
    }
    public function getnormas($params)
    {
        $arrParams = explode(",", $params);
        $id = (isset($arrParams[0]) && !empty($arrParams[0])) ? $arrParams[0] : 0;
        $year = (isset($arrParams[1]) && !empty($arrParams[1])) ? $arrParams[1] : 0;
        $id = is_numeric($id) ? strClean($id) : 0;
        $year = is_numeric($year) ? strClean($year) : 0;
        $request = $this->model->getAllNormasMunicipales($id, $year);
        $cont = 1;
        foreach ($request as $key => $value) {
            $toast = "";
            if (getDaysTranscurridos(date("Y-m-d H:i:s"), $value["nm_fechaRegistro"]) <= 3) {
                $toast = '&nbsp;&nbsp;<span class="badge bg-secondary">Nuevo</span> ';
            }
            $request[$key]["nm_nombre"] = $value["nm_nombre"] . $toast;
            $request[$key]["cont"] = $cont;
            $request[$key]["nm_descripcion"] = limitar_cadena($value["nm_descripcion"], 200, "...");
            $request[$key]["nm_file"] = '<button class="btn btn-danger open-pdf" data-nombre="' . $value["nm_nombre"] . '" data-url="' . $value["nm_file"] . '" data-publicador="' . $value["nombres"] . " " . $value["apellidos"] . '" data-description="' . str_replace('"', '«', $value["nm_descripcion"]) . '"><i class="fa-solid fa-file-pdf"></i></button>';
            $cont++;
        }
        json($request);
    }
    public function funcionarios($params = null)
    {
        if ($params == null) {
            notFound();
            die();
        }
        $arrParams = explode(",", $params);
        if (!is_array($arrParams)) {
            notFound();
            die();
        }
        if (!is_numeric(($arrParams[1]))) {
            notFound();
            die();
        }
        $data['page_id'] = 1;
        $data['page_tag'] = "Funcionarios";
        $data['page_title'] = "Página de los funcionarios";
        $data['page_name'] = "funcionarios";
        $data['page_content'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, quis. Perspiciatis repellat perferendis accusamus, ea natus id omnis, ratione alias quo dolore tempore dicta cum aliquid corrupti enim deserunt voluptas.";
        $data['page_functions_js'] = "functions_funcionarios.js";
        $data['page_funcionarios'] = array("info" => $this->model->selectInfoGrupoFuncionario(($arrParams[1])), "data" => $this->model->selectFuncionarios(($arrParams[1])));
        $this->views->getView($this, "funcionarios", $data);
    }

    public function integrantessci($params = null)
    {
        $data['page_id'] = 16;
        $data['page_tag'] = "Integrantes SCI - MDESV";
        $data['page_title'] = "Integrantes del Sistema de Control Interno";
        $data['page_name'] = "integrantessci";
        $data['page_functions_js'] = "functions_integrantessci.js";
        require_once("Models/PageModel.php");
        $pageModel = new PageModel();
        $data['page_integrantes'] = $pageModel->selectIntegrantesSciActivos();
        $this->views->getView($this, "integrantessci", $data);
    }

    public function marconormativo($params = null)
    {
        $data['page_id'] = 17;
        $data['page_tag'] = "Marco Normativo - MDESV";
        $data['page_title'] = "Marco Normativo de Control Interno";
        $data['page_name'] = "marconormativo";
        $data['page_functions_js'] = "functions_marconormativo.js";
        require_once("Models/PageModel.php");
        $pageModel = new PageModel();
        $data['page_documentos'] = $pageModel->selectMarconormativoActivos();
        $this->views->getView($this, "marconormativo", $data);
    }

    public function gobiernocorporativo($params = null)
    {
        $data['page_id'] = 22;
        $data['page_tag'] = "Gobierno Corporativo - MDESV";
        $data['page_title'] = "Gobierno Corporativo";
        $data['page_name'] = "gobiernocorporativo";
        $data['page_functions_js'] = "functions_gobiernocorporativo.js";
        require_once("Models/PageModel.php");
        $pageModel = new PageModel();
        $data['page_documentos'] = $pageModel->selectGobiernoCorporativoActivos();
        $this->views->getView($this, "gobiernocorporativo", $data);
    }

    public function implementacionsci($params = null)
    {
        $data['page_id'] = 18;
        $data['page_tag'] = "Implementación SCI - MDESV";
        $data['page_title'] = "Implementación del Sistema de Control Interno";
        $data['page_name'] = "implementacionsci";
        $data['page_functions_js'] = "functions_implementacionsci.js";
        require_once("Models/PageModel.php");
        $pageModel = new PageModel();
        $data['page_documentos'] = $pageModel->selectImplementacionsciActivos();
        $this->views->getView($this, "implementacionsci", $data);
    }

    public function materialdidactico($params = null)
    {
        $data['page_id'] = 19;
        $data['page_tag'] = "Material Didáctico - MDESV";
        $data['page_title'] = "Material Didáctico de Control Interno";
        $data['page_name'] = "materialdidactico";
        $data['page_functions_js'] = "functions_materialdidactico.js";
        require_once("Models/PageModel.php");
        $pageModel = new PageModel();
        $data['page_documentos'] = $pageModel->selectMaterialdidacticoActivos();
        $this->views->getView($this, "materialdidactico", $data);
    }

    public function videosdidacticos($params = null)
    {
        $data['page_id'] = 20;
        $data['page_tag'] = "Videos Didácticos - MDESV";
        $data['page_title'] = "Videos Didácticos de Control Interno";
        $data['page_name'] = "videosdidacticos";
        $data['page_functions_js'] = "functions_videosdidacticos.js";
        require_once("Models/PageModel.php");
        $pageModel = new PageModel();
        $data['page_documentos'] = $pageModel->selectVideosdidacticosActivos();
        $this->views->getView($this, "videosdidacticos", $data);
    }

    public function packanticorrupcion($params = null)
    {
        $data['page_id'] = 21;
        $data['page_tag'] = "Pack Anticorrupción - MDESV";
        $data['page_title'] = "Pack Anticorrupción";
        $data['page_name'] = "packanticorrupcion";
        $data['page_functions_js'] = "functions_packanticorrupcion.js";
        require_once("Models/PageModel.php");
        $pageModel = new PageModel();
        $data['page_documentos'] = $pageModel->selectPackanticorrupcionActivos();
        $this->views->getView($this, "packanticorrupcion", $data);
    }

    public function b($params = null)
    {
        $arrParams = explode(",", $params);

        if (!is_array($arrParams)) {
            notFound();
            die();
        }
        $count = count($arrParams);
        $data['page_id'] = 1;
        $data['page_tag'] = "Blog";
        $data['page_title'] = "Pagina de blog";
        $data['page_name'] = "Blog";
        $data['page_content'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, quis. Perspiciatis repellat perferendis accusamus, ea natus id omnis, ratione alias quo dolore tempore dicta cum aliquid corrupti enim deserunt voluptas.";
        if (!empty($arrParams[0]) && $count == 1) {
            $id = is_numeric($arrParams[0]) ? $arrParams[0] : 0;
            $data["page_infoCategoria"] = $this->model->selectinfoCategoria($id);
            $data['page_functions_js'] = "functions_listablogcategoria.js";
            $this->views->getView($this, "listablogcategoria", $data);
        } else if (!empty($arrParams[0]) && !empty($arrParams[1]) && $count == 2) {
            $tituloguion = is_string($arrParams[1]) ? $arrParams[1] : "";
            $data['page_infoBlog'] = $this->model->selecInfoBlog($tituloguion);
            $data['page_functions_js'] = "functions_blogInfo.js";
            $this->views->getView($this, "blog", $data);
        } else {
            $data['page_functions_js'] = "functions_categoria.js";
            $this->views->getView($this, "categoria", $data);
        }
    }
    //apis de consulta externas, falta agregar mas metodos de seguridad tener en cuenta eso
    public function getCategoriasBlog()
    {
        if (isset($_GET["_page"]) && isset($_GET["_limit"])) {
            $inicio = is_numeric($_GET["_page"]) ? $_GET["_page"] : 0;
            $limite = is_numeric($_GET["_limit"]) ? $_GET["_limit"] : 0;
            $arrData = $this->model->selectCategorias($inicio, $limite);
            foreach ($arrData as $key => $value) {
                $arrData[$key]["c_Descripcion"] = limitar_cadena($value["c_Descripcion"], 25, "...+");
            }
            json($arrData);
        }
    }
    public function getBlogs()
    {
        if (isset($_GET["__cat"]) && isset($_GET["_page"]) && isset($_GET["_limit"])) {
            $inicio = is_numeric($_GET["_page"]) ? $_GET["_page"] : 0;
            $cat = is_numeric($_GET["__cat"]) ? $_GET["__cat"] : 0;
            $limite = is_numeric($_GET["_limit"]) ? $_GET["_limit"] : 0;
            $arrData = $this->model->selectBlogs($cat, $inicio, $limite);
            json($arrData);
        }
    }

    public function gobernabilidad()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Gobernabilidad";
        $data['page_title'] = "Gobernabilidad";
        $data['page_name'] = "gobernabilidad";
        $data['page_content'] = "Información sobre la gobernabilidad de la institución.";

        // Cargar el modelo de gobernabilidad para obtener los datos
        require_once("Models/GobernabilidadModel.php");
        $gobernabilidadModel = new GobernabilidadModel();
        $data['gobernabilidad'] = $gobernabilidadModel->getEstructuraGobernabilidad();

        // Reorganizar los datos en una estructura jerárquica
        $estructura = array();
        if (!empty($data['gobernabilidad'])) {
            foreach ($data['gobernabilidad'] as $registro) {
                $itemId = $registro['item_id'];

                // Si aún no existe este item en la estructura, créalo
                if (!isset($estructura[$itemId])) {
                    $estructura[$itemId] = array(
                        'id' => $registro['item_id'],
                        'nombre' => $registro['item_nombre'],
                        'descripcion' => $registro['item_descripcion'],
                        'indicadores' => array()
                    );
                }

                // Si hay un indicador en este registro, agrégalo
                if (!empty($registro['indicador_id'])) {
                    $indicadorId = $registro['indicador_id'];

                    // Si aún no existe este indicador en el item, créalo
                    if (!isset($estructura[$itemId]['indicadores'][$indicadorId])) {
                        $estructura[$itemId]['indicadores'][$indicadorId] = array(
                            'id' => $registro['indicador_id'],
                            'nombre' => $registro['indicador_nombre'],
                            'descripcion' => $registro['indicador_descripcion'],
                            'archivos' => array()
                        );
                    }

                    // Si hay un archivo en este registro, agrégalo
                    if (!empty($registro['archivo_id'])) {
                        $estructura[$itemId]['indicadores'][$indicadorId]['archivos'][] = array(
                            'id' => $registro['archivo_id'],
                            'titulo' => $registro['archivo_titulo'],
                            'descripcion' => $registro['archivo_descripcion'],
                            'archivo_ruta' => $registro['archivo_ruta']
                        );
                    }
                }
            }

            // Reorganizar arrays en lugar de índices asociativos
            $estructuraFinal = array();
            foreach ($estructura as $item) {
                $item['indicadores'] = array_values($item['indicadores']);
                foreach ($item['indicadores'] as &$indicador) {
                    $indicador['archivos'] = array_values($indicador['archivos']);
                }
                $estructuraFinal[] = $item;
            }

            $data['gobernabilidad'] = $estructuraFinal;
        }

        $data['page_functions_js'] = "functions_gobernabilidad_public.js";
        $this->views->getView($this, "web_gobernabilidad", $data);
    }
    
    public function gobernanza()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Gobernanza";
        $data['page_title'] = "Gobernanza";
        $data['page_name'] = "gobernanza";
        $data['page_content'] = "Información sobre la gobernanza de la institución.";

        // Cargar el modelo de gobernanza para obtener los datos
        require_once("Models/GobernanzaModel.php");
        $gobernanzaModel = new GobernanzaModel();
        $data['gobernanza'] = $gobernanzaModel->getEstructuraGobernanza();

        // Reorganizar los datos en una estructura jerárquica
        $estructura = array();
        if (!empty($data['gobernanza'])) {
            foreach ($data['gobernanza'] as $registro) {
                $itemId = $registro['item_id'];

                // Si aún no existe este item en la estructura, créalo
                if (!isset($estructura[$itemId])) {
                    $estructura[$itemId] = array(
                        'id' => $registro['item_id'],
                        'nombre' => $registro['item_nombre'],
                        'descripcion' => $registro['item_descripcion'],
                        'indicadores' => array()
                    );
                }

                // Si hay un indicador en este registro, agrégalo
                if (!empty($registro['indicador_id'])) {
                    $indicadorId = $registro['indicador_id'];

                    // Si aún no existe este indicador en el item, créalo
                    if (!isset($estructura[$itemId]['indicadores'][$indicadorId])) {
                        $estructura[$itemId]['indicadores'][$indicadorId] = array(
                            'id' => $registro['indicador_id'],
                            'nombre' => $registro['indicador_nombre'],
                            'descripcion' => $registro['indicador_descripcion'],
                            'archivos' => array()
                        );
                    }

                    // Si hay un archivo en este registro, agrégalo
                    if (!empty($registro['archivo_id'])) {
                        $estructura[$itemId]['indicadores'][$indicadorId]['archivos'][] = array(
                            'id' => $registro['archivo_id'],
                            'titulo' => $registro['archivo_titulo'],
                            'descripcion' => $registro['archivo_descripcion'],
                            'archivo_ruta' => $registro['archivo_ruta']
                        );
                    }
                }
            }

            // Reorganizar arrays en lugar de índices asociativos
            $estructuraFinal = array();
            foreach ($estructura as $item) {
                $item['indicadores'] = array_values($item['indicadores']);
                foreach ($item['indicadores'] as &$indicador) {
                    $indicador['archivos'] = array_values($indicador['archivos']);
                }
                $estructuraFinal[] = $item;
            }

            $data['gobernanza'] = $estructuraFinal;
        }

        $data['page_functions_js'] = "functions_gobernanza_public.js";
        $this->views->getView($this, "web_gobernanza", $data);
    }
    
    public function convocatorias()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Convocatorias";
        $data['page_title'] = "Convocatorias";
        $data['page_name'] = "convocatorias";
        $data['page_content'] = "Información sobre las convocatorias de la institución.";

        // Cargar el modelo de convocatorias para obtener los datos
        require_once("Models/ConvocatoriasModel.php");
        $convocatoriasModel = new ConvocatoriasModel();
        $data['convocatorias'] = $convocatoriasModel->getEstructuraConvocatorias();

        // Reorganizar los datos en una estructura jerárquica
        $estructura = array();
        if (!empty($data['convocatorias'])) {
            foreach ($data['convocatorias'] as $registro) {
                $convocatoriaId = $registro['convocatoria_id'];

                // Si aún no existe esta convocatoria en la estructura, créala
                if (!isset($estructura[$convocatoriaId])) {
                    $estructura[$convocatoriaId] = array(
                        'id' => $registro['convocatoria_id'],
                        'titulo' => $registro['convocatoria_titulo'],
                        'descripcion' => $registro['convocatoria_descripcion'],
                        'fecha_inicio' => $registro['convocatoria_fecha_inicio'],
                        'fecha_fin' => $registro['convocatoria_fecha_fin'],
                        'estado' => $registro['convocatoria_estado'],
                        'items' => array()
                    );
                }

                // Si hay un item en este registro, agrégalo
                if (!empty($registro['item_id']) && $registro['item_estado'] == '1') {
                    $itemId = $registro['item_id'];

                    // Verificar si el item ya existe en la lista
                    $itemExists = false;
                    foreach ($estructura[$convocatoriaId]['items'] as $key => $item) {
                        if ($item['id'] == $itemId) {
                            $itemExists = true;
                            break;
                        }
                    }

                    if (!$itemExists) {
                        $estructura[$convocatoriaId]['items'][] = array(
                            'id' => $registro['item_id'],
                            'nombre' => $registro['item_nombre'],
                            'descripcion' => $registro['item_descripcion'],
                            'documentos' => array()
                        );
                    }
                }

                // Si hay un documento en este registro, agrégalo al item correspondiente
                if (!empty($registro['documento_id']) && $registro['documento_estado'] == '1') {
                    // Encontrar el item correspondiente y agregar el documento
                    foreach ($estructura[$convocatoriaId]['items'] as $key => $item) {
                        if ($item['id'] == $registro['item_id']) {
                            $estructura[$convocatoriaId]['items'][$key]['documentos'][] = array(
                                'id' => $registro['documento_id'],
                                'titulo' => $registro['documento_titulo'],
                                'descripcion' => $registro['documento_descripcion'],
                                'ruta' => $registro['documento_ruta']
                            );
                            break;
                        }
                    }
                }
            }

            // Reorganizar en array numérico
            $estructuraFinal = array_values($estructura);

            $data['convocatorias'] = $estructuraFinal;
        }

        $data['page_functions_js'] = "functions_convocatorias_public.js";
        $this->views->getView($this, "web_convocatorias", $data);
    }

    public function comunicados()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Comunicados";
        $data['page_title'] = "Comunicados";
        $data['page_name'] = "comunicados";
        $data['page_content'] = "Información sobre los comunicados de la institución.";
        $data['page_functions_js'] = "functions_comunicados_public.js";
        $this->views->getView($this, "web_comunicados", $data);
    }
}
