<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Agregar Nuevo Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <div class="form-group">
                                <label class="control-label" for="flArchivo">Archivo PDF (Máx. 10MB) *</label>
                                <input class="form-control" id="flArchivo" name="flArchivo" type="file" accept="application/pdf" required>
                                <small class="form-text text-muted">Solo se permiten archivos PDF (afiches)</small>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label class="control-label" for="txtNombre">Nombre *</label>
                                    <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Ej: Afiche - Los 12 Principios del SCI" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtOrden">Orden</label>
                                    <input class="form-control" id="txtOrden" name="txtOrden" type="number" value="0" min="0">
                                    <small class="form-text text-muted">Número de orden para mostrar</small>
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
                <h5 class="modal-title" id="titleEdit">Editar Información del Material</h5>
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
                                <div class="form-group col-md-8">
                                    <label class="control-label" for="txtNombre_upd">Nombre *</label>
                                    <input class="form-control" id="txtNombre_upd" name="txtNombre_upd" type="text" placeholder="Ej: Afiche - Los 12 Principios del SCI" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtOrden_upd">Orden</label>
                                    <input class="form-control" id="txtOrden_upd" name="txtOrden_upd" type="number" value="0" min="0">
                                    <small class="form-text text-muted">Número de orden para mostrar</small>
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
                <h5 class="modal-title" id="titleEditFile">Reemplazar Archivo PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateFile" name="formUpdateFile">
                            <input type="hidden" id="id_updFil" name="id_updFil" value="">
                            <input type="hidden" name="fileOld_updFil" id="fileOld_updFil" value="">
                            <div class="form-group">
                                <label class="control-label">Archivo Actual</label>
                                <div class="alert alert-info">
                                    <i class="fas fa-file-pdf"></i> <span id="fileNameOld"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo_upd">Nuevo Archivo PDF (Máx. 10MB) *</label>
                                <input class="form-control" id="flArchivo_upd" name="flArchivo_upd" type="file" accept="application/pdf" required>
                                <small class="form-text text-muted">El archivo actual será reemplazado</small>
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
