<?php $idNav = 2; ?>
<style>
    /* Estilos para efectos hover y animaciones */
    .nav-link {
        transition: all 0.3s ease;
        position: relative;
        padding: 0.5rem 1rem !important;
    }

    .nav-link:hover {
        color: #0d6efd !important;
        transform: translateY(-2px);
        background-color: rgba(255, 255, 255, 0.1) !important;
        border-radius: 4px;
    }

    .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        transition: all 0.2s ease;
        padding: 0.5rem 1.5rem;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .navbar-brand img {
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
        transform: scale(1.05);
    }

    .social-link {
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }

    .social-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-3px);
        color: #fff !important;
    }

    .contact-link {
        transition: all 0.3s ease;
    }

    .contact-link:hover {
        color: #fff !important;
        text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
    }

    .navbar-nav > li {
        position: relative;
    }

    .navbar-nav > li::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: #0d6efd;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .navbar-nav > li:hover::after {
        width: 70%;
    }

    .navbar {
        transition: all 0.4s ease;
    }

    .navbar.scrolled {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
    }
</style>

<header class="position-fixed top-0 w-100 z-50">
    <nav class="__nav-top navbar navbar-expand-lg bg-primary px-1 px-md-5 py-1 d-none d-md-block">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="__redes d-flex gap-3 justify-content-between align-items-center">
                <a href="https://www.facebook.com/epsriojasa" target="_blank" class="text-white px-1 social-link"><i class="fa-brands fa-facebook"></i></a>
                <a href="" class="text-white px-1 social-link"><i class="fa-brands fa-youtube"></i></a>
                <a href="" class="text-white px-1 social-link"><i class="fa-brands fa-instagram"></i></a>
            </div>
            <div class="__contacto d-flex gap-3 justify-content-between align-items-center">
                <a href="mailto:mesadepartes@epsrioja.com.pe" class="text-white contact-link"><i class="fa-solid fa-envelope"></i>&nbsp;&nbsp;mesadepartes@epsrioja.com.pe</a>
                <a href="tel:+042591323" class="text-white contact-link"><i class="fa-solid fa-phone"></i>&nbsp;&nbsp;042591323</a>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-1 px-md-5 shadow-sm" id="mainNavbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= media() ?>/images/icons/logocompleto.png" loading="lazy" alt="" class="img-fluid" style="max-width: 8rem; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if ((webBarras($idNav, "ASC", "DESC"))) {
                        foreach (webBarras($idNav, "ASC", "DESC")["sections"] as $key => $value) {
                    ?>
                            <li class="nav-item dropdown <?= ($value['sbn_url'] == '' || isset($value["items"])) ? 'hover-dropdown' : '' ?>">
                                <a class="nav-link active <?= ($value['sbn_url'] == '' || isset($value["items"])) ? 'dropdown-toggle' : '' ?> "
                                   <?= ($value['sbn_url'] == '' || isset($value["items"])) ? 'id="navbarDropdown'.$key.'"' : '' ?>
                                   <?= ($value['sbn_url'] == '' || isset($value["items"])) ? 'role="button"' : '' ?>
                                   <?= ($value['sbn_url'] == '' || isset($value["items"])) ? 'data-bs-toggle="dropdown"' : '' ?>
                                   <?= ($value['sbn_url'] == '' || isset($value["items"])) ? 'aria-expanded="false"' : '' ?>
                                   aria-current="page" href="<?= $value["sbn_url"] ?>"><?= $value["sbn_titulo"] ?></a>

                                <?php
                                if (($value['sbn_url'] == "" && isset($value["items"])) ||  isset($value["items"])) {
                                ?>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown<?= $key ?>">
                                        <?php
                                        foreach ($value["items"] as $ky => $val) {
                                        ?>
                                            <li><a class="dropdown-item" target="<?= $val["is_target"] ?>" href="<?= $val["is_link"] ?>"><?= $val["is_icon"] ?>&nbsp;&nbsp;<?= $val["is_nombre"] ?></a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                <?php
                                }
                                ?>
                            </li>
                    <?php
                        }
                    }
                    ?>
                    <li class="d-flex align-items-center">
                        <div>
                            <a href="https://www.transparencia.gob.pe/enlaces/pte_transparencia_enlaces.aspx?id_entidad=17512" target="_Blank">
                                <img src="<?= base_url() ?>/Assets/images/icons/pte_logo.png" loading="lazy" alt="" class="img-fluid" style="max-width: 2rem; height: auto;">
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<br>
<br>
<br>
<br>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('mainNavbar');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
});
</script>