<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered modal-dialog-scrollable" role="document">
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
                            <div class="form-group">
                                <img src="<?= media() ?>/images/sinimagen.png" class="img-thumbnail" id="file_carousel" alt="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="flArchivo" name="flArchivo" type="file" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="chcbxTexto">¿Desea agregar contenido descriptivo a la imagen?</label>
                                <div class="toggle-flip">
                                    <label>
                                        <input type="checkbox" id="chcbxTexto" name="chcbxTexto"><span class="flip-indecator" data-toggle-on="Si" data-toggle-off="No"></span>
                                    </label>
                                </div>
                            </div>
                            <div id="sectionTextoSave" class="d-none">
                                <h4>Contenido descriptivo</h4>
                                <div class="form-group">
                                    <label class="control-label" for="txtTitulo">Titulo</label>
                                    <input class="form-control" id="txtTitulo" name="txtTitulo" type="text" placeholder="Titulo de la publicación">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="clrTitulo">Color de texto del Titulo</label>
                                    <input class="form-control" id="clrTitulo" name="clrTitulo" type="color" placeholder="Seleccione un color para el boton">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="txtDescripcion">Descripción</label>
                                    <textarea class="form-control form-control-color" id="txtDescripcion" name="txtDescripcion" rows="5" placeholder="Breve descripción de la publicación"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="clrDescripcion">Color de texto de la Descripción</label>
                                    <input class="form-control form-control-color" id="clrDescripcion" name="clrDescripcion" type="color" placeholder="Seleccione un color para el boton">
                                </div>
                                <div class="form-group">
                                    <label for="chbxBtn">¿Desea agregar un boton de enlace?</label>
                                    <div class="toggle-flip">
                                        <label>
                                            <input type="checkbox" id="chbxBtn" name="chbxBtn"><span class="flip-indecator" data-toggle-on="Si" data-toggle-off="No"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="sectionBtnSave d-none" id="sectionBtnSave">
                                    <h4>Configuración de boton</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label class="control-label" for="txtBtn">Texto del boton</label>
                                        <input class="form-control" id="txtBtn" name="txtBtn" type="text" placeholder="Texto que va ir en el boton">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="txtUrlBtn">URL del boton</label>
                                        <input class="form-control" id="txtUrlBtn" name="txtUrlBtn" type="text" placeholder="Link a donde redirecciona el boton">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="clrBtn">Color del Boton</label>
                                        <input class="form-control form-control-color" id="clrBtn" name="clrBtn" type="color" placeholder="Seleccione un color para el boton">
                                    </div>
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
                <h5 class="modal-title" id="titleEdit">Modal de Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdate" name="formUpdate">
                            <input type="hidden" name="idCarousel" id="idCarousel">
                            <div class="form-group">
                                <label for="chbxConetenidoEdit">¿Desea agregar contenido descriptivo a la imagen?</label>
                                <div class="toggle-flip">
                                    <label>
                                        <input type="checkbox" id="chbxConetenidoEdit" name="chbxConetenidoEdit"><span class="flip-indecator" data-toggle-on="Si" data-toggle-off="No"></span>
                                    </label>
                                </div>
                            </div>
                            <div id="sectionTextoSaveEdit" class="d-none">
                                <h4>Contenido descriptivo</h4>
                                <div class="form-group">
                                    <label class="control-label" for="txtTituloEdit">Titulo</label>
                                    <input class="form-control" id="txtTituloEdit" name="txtTituloEdit" type="text" placeholder="Titulo de la publicación">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="clrTituloEdit">Color de texto del Titulo</label>
                                    <input class="form-control" id="clrTituloEdit" name="clrTituloEdit" type="color" placeholder="Seleccione un color para el boton">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="txtDescripcionEdit">Descripción</label>
                                    <textarea class="form-control" id="txtDescripcionEdit" name="txtDescripcionEdit" rows="5" placeholder="Breve descripción de la publicación"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="clrDescripcionEdit">Color de texto de la Descripción</label>
                                    <input class="form-control form-control-color" id="clrDescripcionEdit" name="clrDescripcionEdit" type="color" placeholder="Seleccione un color para el boton">
                                </div>
                                <div class="form-group">
                                    <label for="chbxBtnEdit">¿Desea agregar un boton de enlace?</label>
                                    <div class="toggle-flip">
                                        <label>
                                            <input type="checkbox" id="chbxBtnEdit" name="chbxBtnEdit"><span class="flip-indecator" data-toggle-on="Si" data-toggle-off="No"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="sectionBtnSaveEdit d-none" id="sectionBtnSaveEdit">
                                    <h4>Configuración de boton</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label class="control-label" for="txtBtnEdit">Texto del boton</label>
                                        <input class="form-control" id="txtBtnEdit" name="txtBtnEdit" type="text" placeholder="Texto que va ir en el boton">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="txtUrlBtnEdit">URL del boton</label>
                                        <input class="form-control" id="txtUrlBtnEdit" name="txtUrlBtnEdit" type="text" placeholder="Link a donde redirecciona el boton">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="clrBtnEdit">Color del Boton</label>
                                        <input class="form-control" id="clrBtnEdit" name="clrBtnEdit" type="color" placeholder="Seleccione un color para el boton">
                                    </div>
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
                                <img src="" class="img-thumbnail" id="photo_file" alt="">
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