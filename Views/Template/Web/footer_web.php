<?php
$idfooter = 1;
if (is_array(webBarras($idfooter, "DESC", "DESC"))) {
?>
    <footer class="text-center text-lg-start text-white w-100 bg-primary pt-4 mt-auto">
        <!-- Grid container -->
        <div class="pb-0 px-1 px-md-5">
            <!-- Section: Links -->
            <section class="container">
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-12 col-md-6 col-lg-4 mb-4 mb-md-0">
                        <h5 class="text-uppercase"><?= webBarras($idfooter, "DESC", "DESC")["bn_titulo"] ?></h5>
                        <p>
                            <?= webBarras($idfooter, "DESC", "DESC")["bn_descripcion"] ?>
                        </p>
                    </div>
                    <!--Grid column-->
                    <?php
                    foreach (webBarras($idfooter, "DESC", "DESC")["sections"] as $key => $value) {
                    ?>
                        <!--Grid column-->
                        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-md-0">
                            <h5 class="text-uppercase"><?= $value["sbn_titulo"] ?></h5>
                            <ul class="list-unstyled mb-0">
                                <?php
                                if (isset($value["items"]) && is_array($value["items"])) {
                                    foreach ($value["items"] as $key => $val) {
                                ?>
                                        <li class="mb-2">
                                            <a href="<?= $val["is_link"] ?>" target="<?= $val["is_target"] ?>" class="text-white"><?= $val["is_icon"] ?>&nbsp;&nbsp;<?= $val["is_nombre"] ?></a>
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <!--Grid column-->
                    <?php
                    }
                    ?>
                </div>
                <!--Grid row-->
            </section>
            <!-- Section: Links -->
            <hr class="mb-4" />
            <!-- Section: CTA
            <section class="">
                <p class="d-flex justify-content-center align-items-center">
                    <span class="me-3">Register for free</span>
                    <button type="button" class="btn btn-outline-light btn-rounded">
                        Sign up!
                    </button>
                </p>
            </section>
            Section: CTA
            <hr class="mb-4" />
            Section: Social media -
            <section class="mb-4 text-center">
                 Facebook
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fa-brands fa-facebook"></i></a>

                 Instagram
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fa-brands fa-youtube"></i></a>

                 Youtube
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fa-brands fa-instagram"></i></a>


            </section>
             Section: Social media -->
        </div>
        <!-- Grid container -->
        <!-- Copyright -->
        <div class="text-center p-3 transparent-black">
            © Copyright <?= date("Y") ?> - EPS RIOJA 2026 - Todos los derechos reservados
        </div>
        <!-- Copyright -->
    </footer>
<?php } ?>
<script>
    const base_url = "<?= base_url() ?>"
</script>
<!-- Essential javascripts for application to work-->
<script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script><!-- Footer -->
<script src="<?= media() ?>/js/jspw/bootstrap.min.js"></script>
<script src="<?= media() ?>/js/jspw/datatables.min.js"></script>
<script src="<?= media() ?>/js/jspw/fontawesome.min.js"></script>
<script src="<?= media() ?>/js/jspw/brands.min.js"></script>
<script src="<?= media() ?>/js/jspw/regular.min.js"></script>
<script src="<?= media() ?>/js/jspw/solid.min.js"></script>
<script src="<?= media() ?>/js/jspw/main.js?version=<?= getVersion() ?>"></script>
<script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>?version=<?= getVersion() ?>"></script>
</body>

</html>