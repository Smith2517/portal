<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Modal de Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <input type="hidden" name="idFooter" id="idFooter" value="<?= $data['page_infoFooter']["id"] ?>">
                            <div class="form-group">
                                <label class="control-label" for="txtTitulo">Titulo</label>
                                <input class="form-control" id="txtTitulo" name="txtTitulo" type="text" placeholder="Nombre de el/la/los <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="5" placeholder="Descripción de el/la/los <?= $data['page_name'] ?>"></textarea>
                            </div>

                            <?php
                            if ($data['page_infoFooter']["tipobarras_id"] == 1) {
                            } else {
                            ?>
                                <div class="form-group">
                                    <label class="control-label" for="txtUrl">URL</label>
                                    <input class="form-control" id="txtUrl" name="txtUrl" type="text"  placeholder="URL o Link de el/la/los <?= $data['page_name'] ?>">
                                </div>
                            <?php
                            }
                            ?>

                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->
<!--Modal edit-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Modal de Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdate" name="formUpdate">
                            <input type="hidden" id="id_upd" name="id_upd" value="">
                            <div class="form-group">
                                <label class="control-label" for="txtTitulo_upd">Titulo</label>
                                <input class="form-control" id="txtTitulo_upd" name="txtTitulo_upd" type="text" placeholder="Nombre de el/la/los <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion_upd">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion_upd" name="txtDescripcion_upd" rows="5" placeholder="Descripción de el/la/los <?= $data['page_name'] ?>"></textarea>
                            </div>

                            <?php
                            if ($data['page_infoFooter']["tipobarras_id"] == 1) {
                            } else {
                            ?>
                                <div class="form-group">
                                    <label class="control-label" for="txtUrl_upd">URL</label>
                                    <input class="form-control" id="txtUrl_upd" name="txtUrl_upd" type="text"  placeholder="URL o Link de el/la/los <?= $data['page_name'] ?>">
                                </div>
                                <?php
                            }
                            ?>
                            
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->