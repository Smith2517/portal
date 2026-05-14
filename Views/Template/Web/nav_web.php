<?php $idNav = 2; ?>


<header class="sticky-top w-100 z-50">
    <nav class="__nav-top navbar navbar-expand-lg bg-water-900 px-1 px-md-5 py-2 d-none d-md-block text-white">
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
    <nav class="navbar navbar-expand-lg bg-white px-1 px-md-5 border-bottom border-slate-100 shadow-sm" id="mainNavbar">
        <div class="container-fluid py-1">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url() ?>">
                <div class="logo-circle">
                    <i class="fa-solid fa-droplet text-xl"></i>
                </div>
                <div>
                    <h1 class="font-heading fw-bold text-water-900 mb-0 lh-1" style="font-size: 1.5rem; letter-spacing: -0.05em;">EPS RIOJA</h1>
                    <span class="text-uppercase fw-bold text-water-500 d-block" style="font-size: 0.65rem; letter-spacing: 0.1em;">Saneamiento y Vida</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
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