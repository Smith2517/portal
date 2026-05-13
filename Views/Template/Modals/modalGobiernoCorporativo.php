<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Agregar Nuevo Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <div class="form-group">
                                <label class="control-label" for="flArchivo">Documento PDF (Máx. 10MB) *</label>
                                <input class="form-control" id="flArchivo" name="flArchivo" type="file" accept="application/pdf" required>
                                <small class="form-text text-muted">Solo se permiten archivos PDF</small>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label class="control-label" for="txtTitulo">Título *</label>
                                    <input class="form-control" id="txtTitulo" name="txtTitulo" type="text" placeholder="Ej: Código de Gobierno Corporativo" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtNumero">Número</label>
                                    <input class="form-control" id="txtNumero" name="txtNumero" type="text" placeholder="Ej: 001-2024">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtFecha">Fecha</label>
                                    <input class="form-control" id="txtFecha" name="txtFecha" type="date">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtCategoria">Categoría</label>
                                    <input class="form-control" id="txtCategoria" name="txtCategoria" type="text" placeholder="Ej: Políticas, Manuales, Directivas">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtTipo">Tipo</label>
                                    <input class="form-control" id="txtTipo" name="txtTipo" type="text" value="PDF" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" placeholder="Descripción del documento"></textarea>
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
                <h5 class="modal-title" id="titleEdit">Editar Información del Documento</h5>
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
                                    <label class="control-label" for="txtTitulo_upd">Título *</label>
                                    <input class="form-control" id="txtTitulo_upd" name="txtTitulo_upd" type="text" placeholder="Ej: Código de Gobierno Corporativo" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtNumero_upd">Número</label>
                                    <input class="form-control" id="txtNumero_upd" name="txtNumero_upd" type="text" placeholder="Ej: 001-2024">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtFecha_upd">Fecha</label>
                                    <input class="form-control" id="txtFecha_upd" name="txtFecha_upd" type="date">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtCategoria_upd">Categoría</label>
                                    <input class="form-control" id="txtCategoria_upd" name="txtCategoria_upd" type="text" placeholder="Ej: Políticas, Manuales, Directivas">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="txtTipo_upd">Tipo</label>
                                    <input class="form-control" id="txtTipo_upd" name="txtTipo_upd" type="text" value="PDF" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion_upd">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion_upd" name="txtDescripcion_upd" rows="4" placeholder="Descripción del documento"></textarea>
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
                <h5 class="modal-title" id="titleEditFile">Reemplazar Documento PDF</h5>
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
                                <label class="control-label" for="flArchivo_upd">Nuevo Documento PDF (Máx. 10MB) *</label>
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
