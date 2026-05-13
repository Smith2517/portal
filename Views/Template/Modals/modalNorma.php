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
                            <input type="hidden" id="tiponorma_id" name="tiponorma_id" value="<?= $data['page_tipoNorma']['id'] ?>">
                            <div class="form-group">
                                <label class="control-label" for="intNumeroDoc">N° Documento</label>
                                <input class="form-control" id="intNumeroDoc" name="intNumeroDoc" type="number" placeholder="Ingrese el numero de la/los/el <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtNombre">Nombre Documento</label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre de el/la/los <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion">Descripción Documento</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="10" placeholder="Descripción de el/la/los <?= $data['page_name'] ?>" required=""></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="cbxYear">Año</label>
                                <select class="form-control" id="cbxYear" name="cbxYear" required>
                                    <option value="" disabled selected>Seleccione un año</option>
                                    <?php
                                    $arrYear = $data["page_year"];
                                    $option = null;
                                    foreach ($arrYear as $key => $value) {
                                        $option .= "<option value='" . $value["id"] . "'>" . $value["a_anio"] . "</option>";
                                    }
                                    echo $option;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo">Archivo</label>
                                <input class="form-control" id="flArchivo" name="flArchivo" type="file" accept="application/pdf" required>
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
                                <label class="control-label" for="intNumeroDoc_upd">N° Documento</label>
                                <input class="form-control" id="intNumeroDoc_upd" name="intNumeroDoc_upd" type="number" placeholder="Ingrese el numero de la/los/el <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtNombre_upd">Nombre</label>
                                <input class="form-control" id="txtNombre_upd" name="txtNombre_upd" type="text" placeholder="Nombre de el/la/los <?= $data['page_name'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion_upd">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion_upd" name="txtDescripcion_upd" rows="10" placeholder="Descripción de el/la/los <?= $data['page_name'] ?>" required=""></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="cbxYear_upd">Año</label>
                                <select class="form-control" id="cbxYear_upd" name="cbxYear_upd" required>
                                    <option value="" disabled selected>Seleccione un año</option>
                                    <?php
                                    $arrYear = $data["page_year"];
                                    $option = null;
                                    foreach ($arrYear as $key => $value) {
                                        $option .= "<option value='" . $value["id"] . "'>" . $value["a_anio"] . "</option>";
                                    }
                                    echo $option;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cbxEstado_upd">Estado</label>
                                <select class="form-control" id="cbxEstado_upd" name="cbxEstado_upd" required="">
                                    <option value="" disabled selected>Seleccione una opcion</option>

                                    <option value="0">No publicado</option>
                                    <option value="1">Publicado</option>



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
<div class="modal fade" id="modalEditUpload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEditFile">Cambiar Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateFile" name="formUpdateFile">
                            <input type="hidden" id="idFile_upd" name="idFile_upd" value="">
                            <embed class="container input-pdf" type="application/pdf" id="input-pdf" src="" style="height: 30rem;"></embed>
                            <div class="form-group">
                                <label class="control-label" for="flArchivoFile_upd">Archivo</label>
                                <input class="form-control" id="flArchivoFile_upd" name="flArchivoFile_upd" type="file" accept="application/pdf" required>
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