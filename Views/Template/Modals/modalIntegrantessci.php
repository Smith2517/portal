<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Agregar Nuevo Integrante SCI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <div class="form-group d-flex justify-content-center">
                                <img src="<?= media() ?>/images/sinimagen.png" class="img-thumbnail" id="file-img" alt="" width="150" height="150">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo">Imagen (Se redimensiona automáticamente a 413x531px)</label>
                                <input class="form-control" id="flArchivo" name="flArchivo" type="file" accept="image/*" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtNombres">Nombres *</label>
                                    <input class="form-control" id="txtNombres" name="txtNombres" type="text" placeholder="Ingrese los nombres" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtApellidos">Apellidos *</label>
                                    <input class="form-control" id="txtApellidos" name="txtApellidos" type="text" placeholder="Ingrese los apellidos" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCargo">Cargo *</label>
                                    <input class="form-control" id="txtCargo" name="txtCargo" type="text" placeholder="Ingrese el cargo" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtDependencia">Dependencia/Gestión</label>
                                    <input class="form-control" id="txtDependencia" name="txtDependencia" type="text" placeholder="Ingrese la dependencia o área">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCorreo">Correo Electrónico</label>
                                    <input class="form-control" id="txtCorreo" name="txtCorreo" type="email" placeholder="correo@ejemplo.com">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCelular">Celular</label>
                                    <input class="form-control" id="txtCelular" name="txtCelular" type="number" min="900000000" maxlength="999999999" placeholder="999 999 999">
                                </div>
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
                <h5 class="modal-title" id="titleEdit">Editar Información del Integrante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdate" name="formUpdate">
                            <input type="hidden" id="id_upd" name="id_upd" value="">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtNombres_upd">Nombres *</label>
                                    <input class="form-control" id="txtNombres_upd" name="txtNombres_upd" type="text" placeholder="Ingrese los nombres" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtApellidos_upd">Apellidos *</label>
                                    <input class="form-control" id="txtApellidos_upd" name="txtApellidos_upd" type="text" placeholder="Ingrese los apellidos" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCargo_upd">Cargo *</label>
                                    <input class="form-control" id="txtCargo_upd" name="txtCargo_upd" type="text" placeholder="Ingrese el cargo" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtDependencia_upd">Dependencia/Gestión</label>
                                    <input class="form-control" id="txtDependencia_upd" name="txtDependencia_upd" type="text" placeholder="Ingrese la dependencia o área">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCorreo_upd">Correo Electrónico</label>
                                    <input class="form-control" id="txtCorreo_upd" name="txtCorreo_upd" type="email" placeholder="correo@ejemplo.com">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCelular_upd">Celular</label>
                                    <input class="form-control" id="txtCelular_upd" name="txtCelular_upd" type="number" min="900000000" maxlength="999999999" placeholder="999 999 999">
                                </div>
                            </div>
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--Modal edit file-->
<div class="modal fade" id="modalEditFile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEditFile">Editar Foto del Integrante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateFile" name="formUpdateFile">
                            <input type="hidden" id="id_updFil" name="id_updFil" value="">
                            <input type="hidden" name="photoOld_updFil" id="photoOld_updFil" value="">
                            <div class="form-group d-flex justify-content-center">
                                <img src="" class="img-thumbnail" id="photo_file" alt="" width="150" height="150">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo_upd">Imagen (Se redimensiona automáticamente a 413x531px)</label>
                                <input class="form-control" id="flArchivo_upd" name="flArchivo_upd" type="file" accept="image/*" required>
                            </div>
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->
