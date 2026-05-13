<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media(); ?>/images/avatar.png" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">
                <?= $_SESSION['userData']['nombres']; ?>
            </p>
            <p class="app-sidebar__user-designation">
                <?= $_SESSION['userData']['nombrerol']; ?>
            </p>
        </div>
    </div>
    <ul class="app-menu">
        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
            <li>
                <a class="app-menu__item <?= optionActivo($data['page_id'], 1) ?>" href="<?= base_url(); ?>/dashboard">
                    <i class="app-menu__icon fa fa-dashboard"></i>
                    <span class="app-menu__label">Dashboard</span>
                </a>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 2) ?> <?= isExapded($data['page_id'], 0) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
                    <span class="app-menu__label">Usuarios</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 2) ?>" href="<?= base_url(); ?>/usuarios"><i class="icon fa fa-circle-o"></i>
                            Usuarios</a></li>
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 0) ?>" href="<?= base_url(); ?>/roles"><i class="icon fa fa-circle-o"></i>
                            Roles</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php
        if (!empty($_SESSION['permisos'][3]['r'])) {
            if (is_array(normasmunicipales()) && !empty(normasmunicipales())) {
        ?>
                <li class="treeview <?= isExapded($data['page_id'], 3) ?>">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fa fa-file" aria-hidden="true"></i>
                        <span class="app-menu__label">Normas Municipales</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                        foreach (normasmunicipales() as $key => $value) {
                        ?>
                            <li><a class="treeview-item <?= optionActivo($data['page_id'], 3) ?>" href="<?= base_url(); ?>/norma/norma/<?= $value['id'] ?>"><i class="icon fa fa-circle-o"></i>
                                    <?= $value["tn_nombre"] ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
        <?php
            }
        }
        ?>
        <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 4) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-barcode" aria-hidden="true"></i>
                    <span class="app-menu__label">Tipo Norma</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 4) ?>" href="<?= base_url(); ?>/tiponorma"><i class="icon fa fa-circle-o"></i>
                            Tipo Norma</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 5) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-picture-o" aria-hidden="true"></i>
                    <span class="app-menu__label">Carousel</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 5) ?>" href="<?= base_url(); ?>/carousel"><i class="icon fa fa-circle-o"></i>
                            Carousel</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 6) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
                    <span class="app-menu__label">Funcionarios</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 6) ?>" href="<?= base_url(); ?>/funcionarios/grupofuncionarios"><i class="icon fa fa-circle-o"></i>
                            Grupo Funcionarios</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 7) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-sitemap" aria-hidden="true"></i>
                    <span class="app-menu__label">Barras Navegacion</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 7) ?>" href="<?= base_url(); ?>/barrasnavegacion/"><i class="icon fa fa-circle-o"></i>
                            Barras Navegacion</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][8]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 8) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-window-restore" aria-hidden="true"></i>
                    <span class="app-menu__label">Paginas</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 8) ?>" href="<?= base_url(); ?>/paginas/"><i class="icon fa fa-circle-o"></i>
                            Crea o Edita tus paginas</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 9) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-folder" aria-hidden="true"></i>
                    <span class="app-menu__label">Cloud</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 9) ?>" href="<?= base_url(); ?>/administradorfile/"><i class="icon fa fa-circle-o"></i>Administrador de Archivos</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][10]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 10) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-comment" aria-hidden="true"></i>
                    <span class="app-menu__label">Aviso Modal</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 10) ?>" href="<?= base_url(); ?>/modal/"><i class="icon fa fa-circle-o"></i>Crear Avisos Modal</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][11]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 11) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-sticky-note" aria-hidden="true"></i>
                    <span class="app-menu__label">Blog</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 11) ?>" href="<?= base_url(); ?>/blog/categorias"><i class="icon fa fa-circle-o"></i>Categorias</a></li>
                </ul>
                <?php
                if (is_array(categorias()) && !empty(categorias())) { ?>
                    <ul class="treeview-menu">
                        <?php
                        foreach (categorias() as $key => $value) {
                        ?>
                            <li><a class="treeview-item <?= optionActivo($data['page_id'], 3) ?>" href="<?= base_url(); ?>/blog/blog/<?= $value['idCategoria'] ?>"><i class="icon fa fa-bars"></i>
                                    <?= $value["c_Categoria"] ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
            </li>
        <?php
        } ?>
        <?php if (!empty($_SESSION['permisos'][12]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 12) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-balance-scale" aria-hidden="true"></i>
                    <span class="app-menu__label">Gobernabilidad</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 12) ?>" href="<?= base_url(); ?>/gobernabilidad"><i class="icon fa fa-circle-o"></i>
                            Gobernabilidad</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][13]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 13) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-globe-americas" aria-hidden="true"></i>
                    <span class="app-menu__label">Gobernanza</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 13) ?>" href="<?= base_url(); ?>/gobernanza"><i class="icon fa fa-circle-o"></i>
                            Gobernanza</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][14]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 14) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-bullhorn" aria-hidden="true"></i>
                    <span class="app-menu__label">Convocatorias</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 14) ?>" href="<?= base_url(); ?>/convocatorias"><i class="icon fa fa-circle-o"></i>
                            Convocatorias</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][15]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 15) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-broadcast-tower" aria-hidden="true"></i>
                    <span class="app-menu__label">Comunicados</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 15) ?>" href="<?= base_url(); ?>/comunicados"><i class="icon fa fa-circle-o"></i>
                            Comunicados</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][16]['r'])) { ?>
            <li class="treeview <?= isExapded($data['page_id'], 16) ?>">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-shield" aria-hidden="true"></i>
                    <span class="app-menu__label">Control Interno</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 16) ?>" href="<?= base_url(); ?>/integrantessci"><i class="icon fa fa-circle-o"></i>
                            Integrantes SCI</a></li>
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 17) ?>" href="<?= base_url(); ?>/marconormativo"><i class="icon fa fa-circle-o"></i>
                            Marco Normativo</a></li>
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 22) ?>" href="<?= base_url(); ?>/gobiernocorporativo"><i class="icon fa fa-circle-o"></i>
                            Gobierno Corporativo</a></li>
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 18) ?>" href="<?= base_url(); ?>/implementacionsci"><i class="icon fa fa-circle-o"></i>
                            Implementación del SCI</a></li>
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 19) ?>" href="<?= base_url(); ?>/materialdidactico"><i class="icon fa fa-circle-o"></i>
                            Material didáctivo</a></li>
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 20) ?>" href="<?= base_url(); ?>/videosdidacticos"><i class="icon fa fa-circle-o"></i>
                            Videos didácticos</a></li>
                    <li><a class="treeview-item <?= optionActivo($data['page_id'], 21) ?>" href="<?= base_url(); ?>/packanticorrupcion"><i class="icon fa fa-circle-o"></i>
                            Pack anticorrupción</a></li>
                </ul>
            </li>
        <?php } ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/logout">
                <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
                <span class="app-menu__label">Logout</span>
            </a>
        </li>
    </ul>
</aside>