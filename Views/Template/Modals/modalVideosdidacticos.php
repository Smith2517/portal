<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Agregar Nuevo Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <div class="form-group">
                                <label class="control-label" for="txtEnlace">Enlace de YouTube *</label>
                                <input class="form-control" id="txtEnlace" name="txtEnlace" type="url" placeholder="Ej: https://www.youtube.com/watch?v=XXXXXXXXXXX" required="">
                                <small class="form-text text-muted">Ingrese el enlace completo del video de YouTube</small>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label class="control-label" for="txtNombre">Nombre *</label>
                                    <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Ej: Introducción al Control Interno" required="">
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
                <h5 class="modal-title" id="titleEdit">Editar Información del Video</h5>
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
                                <label class="control-label" for="txtEnlace_upd">Enlace de YouTube *</label>
                                <input class="form-control" id="txtEnlace_upd" name="txtEnlace_upd" type="url" placeholder="Ej: https://www.youtube.com/watch?v=XXXXXXXXXXX" required="">
                                <small class="form-text text-muted">Ingrese el enlace completo del video de YouTube</small>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label class="control-label" for="txtNombre_upd">Nombre *</label>
                                    <input class="form-control" id="txtNombre_upd" name="txtNombre_upd" type="text" placeholder="Ej: Introducción al Control Interno" required="">
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
