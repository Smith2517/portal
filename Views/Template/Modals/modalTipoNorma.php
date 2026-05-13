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
                            <input type="hidden" name="idPersona" id="idPersona" value="<?= $_SESSION['idUser'] ?>">
                            <div class="form-group">
                                <label class="control-label" for="txtNombre">Nombre</label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del tipo de norma" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="5" placeholder="Descripción del tipo de norma" required=""></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="flArchivo" name="flArchivo" type="file" accept="image/*" required>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                                <input class="form-control" id="txtNombre_upd" name="txtNombre_upd" type="text" placeholder="Nombre del tipo de norma" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion_upd">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion_upd" name="txtDescripcion_upd" rows="5" placeholder="Descripción del tipo de norma" required=""></textarea>
                            </div>
                            <div class="form-group">
                                <label for="cbxEstado_upd">Estado</label>
                                <select class="form-control" id="cbxEstado_upd" name="cbxEstado_upd" required="">
                                    <option value="" disabled selected>Seleccione una opcion</option>
                                    <option value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                </select>
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
<div class="modal fade" id="modalEditFile" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <form id="formUpdateFile" name="formUpdateFile">
                            <input type="hidden" id="ip_updFil" name="ip_updFil" value="">
                            <input type="hidden" name="photoOld_updFil" id="photoOld_updFil" value="">
                            <div class="form-group">
                                <img src="<?= media() ?>/images/sinimagen.png" class="img-thumbnail" id="photo_file">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo_updFil">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="flArchivo_updFil" name="flArchivo_updFil" type="file" accept="image/*" required>
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