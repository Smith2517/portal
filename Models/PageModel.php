<?php
class PageModel extends Mysql
{
    private $tiponorma_id;
    private $tituloguion;
    private $id;
    private $year;
    private $inicio;
    private $limite;
    public function __construct()
    {
        parent::__construct();
    }
    public function getYearNormasMunicipales(int $id)
    {
        $query = "SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';";
        $this->select($query);
        $this->tiponorma_id = $id;
        $query = "SELECT a.a_anio,COUNT(nm.id) AS total_nm,a.id, nm.tiponorma_id FROM normasmunicipales AS nm 
        inner JOIN anio AS a ON a.id=nm.anio_id
        WHERE nm.tiponorma_id={$this->tiponorma_id} GROUP BY a.a_anio ORDER BY a.a_anio DESC;";
        $request = $this->select_all($query);
        if (isset($request) && $request) {
            return $request;
        } else {
            return null;
        }
    }
    public function getInfoNormaMunicipal(int $id)
    {
        $this->tiponorma_id = $id;
        $query = "SELECT*FROM tiponorma AS tn WHERE tn.id={$this->tiponorma_id} and tn.tn_estado=1;";
        $request = $this->select($query);
        if (isset($request) && $request) {
            return $request;
        } else {
            return null;
        }
    }
    public function getAllNormasMunicipales(int $idTN, int $year)
    {
        $this->tiponorma_id = $idTN;
        $this->year = $year;
        $query = "SELECT*FROM normasmunicipales AS nm 
        INNER JOIN anio AS a ON a.id=nm.anio_id
        INNER JOIN persona as p on p.idpersona=nm.idpersona
        WHERE nm.tiponorma_id={$this->tiponorma_id} AND a.a_anio={$this->year} AND nm.nm_estado=1 ORDER BY nm.nm_numeroDocumento DESC;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectNormasMunicipales()
    {
        $query = "SELECT*FROM tiponorma AS tn WHERE tn.tn_estado=1;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectCarouselActive()
    {
        $query = "SELECT*FROM carousel AS c WHERE c.c_estado=1 ORDER BY c.id DESC;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectGrupoFuncionario()
    {
        $query = "SELECT*FROM grupofuncionarios AS gf WHERE gf.gf_estado=1;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectInfoGrupoFuncionario(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM grupofuncionarios AS gf WHERE gf.id={$this->id} AND  gf.gf_estado=1;";
        $request = $this->select($query);
        return $request;
    }
    public function selectFuncionarios(int $idGF)
    {
        $this->id = $idGF;
        $query = "SELECT*FROM funcionarios AS f 
        INNER JOIN grupofuncionarios AS gf ON gf.id=f.grupofuncionarios_id WHERE f.grupofuncionarios_id={$this->id} AND f.f_estado=1 AND gf.gf_estado=1 order by f.id DESC;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectBarras(int $id, string $orderSection, string $orderItems)
    {
        $this->id = $id;
        $query = "SELECT*FROM barrasnavegacion AS bn WHERE bn.bn_estado=1 and bn.tipobarras_id={$this->id};";
        $arrFooter = $this->select($query);
        if ($arrFooter) {
            $id = $arrFooter["id"];
            $query = "SELECT*FROM sectionbarrasnavegacion AS sbn WHERE sbn.barrasnavegacion_id={$id} and sbn.sbn_estado=1 ORDER BY sbn.id " . $orderSection . ";";
            $arrSecctions = $this->select_all($query);
            foreach ($arrSecctions as $key => $value) {
                $queryItems = "SELECT*FROM itemsecction AS ise WHERE ise.sectionfooter_id={$value['id']} and ise.is_estado=1 ORDER BY ise.id " . $orderItems . ";";
                $arrItems = $this->select_all($queryItems);
                if ($arrItems) {
                    $arrSecctions[$key]["items"] = $arrItems;
                }
            }
            $arrDataFoter = $arrFooter;
            $arrDataFoter["sections"] = $arrSecctions;
            return $arrDataFoter;
        }
    }
    public function selectInfoPage(int $id)
    {
        $this->id = $id;
        $query = "SELECT*FROM pagina AS p WHERE p.id='{$this->id}';";
        $request = $this->select($query);
        return $request;
    }
    public function selectInfoPageBySlug(string $slug)
    {
        $query = "SELECT * FROM pagina AS p WHERE REPLACE(LOWER(p.p_nombre), ' ', '-') = ?";
        $request = $this->select($query, [$slug]);
        return $request;
    }
    public function getAvisos()
    {
        $query = "SELECT*FROM aviso AS a WHERE a.a_Estado=1;";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectCategorias(int $inicio, int $limite)
    {
        $this->inicio = $inicio;
        $this->limite = $limite;
        $query = "SELECT*FROM categorias AS c WHERE c.c_Estado='1' ORDER BY idCategoria DESC LIMIT {$this->inicio},{$this->limite};";
        $request = $this->select_all($query);
        return $request;
    }
    public function selectinfoCategoria(int $id)
    {
        $this->id = $id;
        $sql = "SELECT * FROM categorias AS c where c.idCategoria={$this->id}";
        $request = $this->selectOne($sql);
        return $request;
    }
    public function selectBlogs(int $id, int $inicio, int $limite)
    {
        $this->id = $id;
        $this->inicio = $inicio;
        $this->limite = $limite;
        $sql = "SELECT*FROM blog AS b WHERE b.idCategoria={$this->id} ORDER BY b.idBlog DESC LIMIT {$this->inicio},{$this->limite} ;";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selecInfoBlog(string $tituloguion)
    {
        $this->tituloguion = $tituloguion;
        $sql = "SELECT*FROM blog AS b
        INNER JOIN categorias AS c ON c.idCategoria=b.idCategoria
        WHERE b.b_tituloGuion='{$this->tituloguion}' AND b.b_Estado=1;";
        $request = $this->selectOne($sql);
        return $request;
    }

    public function selectIntegrantesSciActivos()
    {
        $query = "SELECT * FROM integrantessci WHERE i_estado = 1 ORDER BY i_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectMarconormativoActivos()
    {
        $query = "SELECT * FROM marconormativo WHERE mn_estado = 1 ORDER BY mn_orden ASC, mn_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectGobiernoCorporativoActivos()
    {
        $query = "SELECT * FROM gobiernocorporativo WHERE gc_estado = 1 ORDER BY gc_orden ASC, gc_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectImplementacionsciActivos()
    {
        $query = "SELECT * FROM implementacionsci WHERE is_estado = 1 ORDER BY is_orden ASC, is_fecha DESC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectMaterialdidacticoActivos()
    {
        $query = "SELECT * FROM materialdidactico WHERE md_estado = 1 ORDER BY md_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectVideosdidacticosActivos()
    {
        $query = "SELECT * FROM videosdidacticos WHERE vd_estado = 1 ORDER BY vd_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectPackanticorrupcionActivos()
    {
        $query = "SELECT * FROM packanticorrupcion WHERE pa_estado = 1 ORDER BY pa_orden ASC, id DESC;";
        $request = $this->select_all($query);
        return $request;
    }
}
