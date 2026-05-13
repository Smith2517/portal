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
                            <input type="hidden" id="section_id" name="section_id" value="<?= $data['page_infoSection']['id'] ?>">
                            <div class="form-group">
                                <label class="control-label" for="txtNombre">Nombre</label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese el nombre de la/los/el <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtUrl">URL</label>
                                <input class="form-control" id="txtUrl" name="txtUrl" type="text" placeholder="Url de el/la/los <?= $data['page_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="cbxTarget">Target</label>
                                <select class="form-control" id="cbxTarget" name="cbxTarget" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="_blank">Abrir en otra ventana</option>
                                    <option value="_parent">Abrir en la misma ventana</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtIcon">Icono</label>
                                <p><span class="text-danger">*</span>&nbsp;Para agregar iconos se utiliza la libreria de fontawesome v5</p>
                                <p><span class="text-danger">*</span>&nbsp;Link <a href="https://fontawesome.com/v5/search" target="_blank">fontawesome v5</a></p>
                                <input class="form-control" id="txtIcon" name="txtIcon" type="text" placeholder="Agregar icono de el/la/los <?= $data['page_name'] ?>" required="">
                            </div>
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
                                <label class="control-label" for="txtNombre_upd">Nombre</label>
                                <input class="form-control" id="txtNombre_upd" name="txtNombre_upd" type="text" placeholder="Ingrese el nombre de la/los/el <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtUrl_upd">URL</label>
                                <input class="form-control" id="txtUrl_upd" name="txtUrl_upd" type="text" placeholder="Url de el/la/los <?= $data['page_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="cbxTarget_upd">Target</label>
                                <select class="form-control" id="cbxTarget_upd" name="cbxTarget_upd" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="_blank">Abrir en otra ventana</option>
                                    <option value="_parent">Abrir en la misma ventana</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtIcon_upd">Icono</label>
                                <p><span class="text-danger">*</span>&nbsp;Para agregar iconos se utiliza la libreria de fontawesome v5</p>
                                <p><span class="text-danger">*</span>&nbsp;Link <a href="https://fontawesome.com/v5/search" target="_blank">fontawesome v5</a></p>
                                <input class="form-control" id="txtIcon_upd" name="txtIcon_upd" type="text" placeholder="Agregar icono de el/la/los <?= $data['page_name'] ?>" required="">
                            </div>
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