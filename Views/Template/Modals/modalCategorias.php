<!--Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Nueva Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <div class="form-group">
                                <label class="control-label" for="txtNombreCategoria">Nombre</label>
                                <input class="form-control" id="txtNombreCategoria" name="txtNombreCategoria" type="text" placeholder="Ingrese un nombre para la categoria" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcionCategoria">Descripcion</label>
                                <textarea class="form-control" name="txtDescripcionCategoria" id="txtDescripcionCategoria" cols="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ImgArchiv">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="ImgArchiv" name="ImgArchiv" type="file" accept="image/*" required>
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

<!--Modal edit Datos-->
<div class="modal fade" id="modalEditCat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Modal de Editar Datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formCatUpdate" name="formCatUpdate">
                            <input type="hidden" id="id_Catupd" name="id_Catupd" value="">

                            <div class="form-group">
                                <label class="control-label" for="txtNombCat">Nombre</label>
                                <input class="form-control" id="txtNombCat" name="txtNombCat" type="text" placeholder="Ingrese un nombre para la categoria" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescCat">Descripcion</label>
                                <textarea class="form-control" name="txtDescCat" id="txtDescCat" cols="5"></textarea>
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
<!--Modal edit File-->
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
                                <label class="control-label" for="ImgArchivo">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="ImgArchivo" name="ImgArchivo" type="file" accept="image/*" required>
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