<!--Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Nuevo Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <input type="hidden" id="categoria_id" name="categoria_id" value="<?= $data['page_categoria']["idCategoria"]?>">
                            <div class="form-group">
                                <label class="control-label" for="tituloBlog">Título</label>
                                <input class="form-control" id="tituloBlog" name="tituloBlog" type="text" placeholder="Ingrese el título de la noticia" required="" oninput="this.value = this.value.toUpperCase()" maxlength="200">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="subTituloBlog">Subtítulo</label>
                                <input class="form-control" id="subTituloBlog" name="subTituloBlog" type="text" placeholder="Ingrese el subtítulo de la noticia" required="" maxlength="400">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="contenidoBlog">Contenido</label>
                                <textarea class="form-control" name="contenidoBlog" id="contenidoBlog" cols="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ImgBlog">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="ImgBlog" name="ImgBlog" type="file" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="descripcionImg">Descripción de imagen</label>
                                <input class="form-control" id="descripcionImg" name="descripcionImg" type="text" placeholder="Ingrese la descripción de la portada" maxlength="300">
                            </div>
                            
                            <div class="form-group">
                                <label for="embedLink">Incrusta Contenido</label>
                                <input type="txt" class="form-control" id="embedLink" name="embedLink">
                                <input type="hidden" id="urls" name="urls" value="">
                            </div>
                            <div class="embed-responsive embed-responsive-16by9">
                                <div id="previsualizacionMensaje" class="embed-responsive-item text-center">
                                    <p class="text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando previsualización...</p>
                                </div>
                                <iframe id="embedContenido" class="embed-responsive-item" style="display: none;" allowfullscreen></iframe>
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
                                <label class="control-label" for="editTitulo">Título</label>
                                <input class="form-control" id="editTitulo" name="editTitulo" type="text" placeholder="Ingrese el título de la noticia" required="" maxlength="200" oninput="this.value = this.value.toUpperCase()">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="editSubtitulo">Subtítulo</label>
                                <input class="form-control" id="editSubtitulo" name="editSubtitulo" type="text" placeholder="Ingrese el subtítulo de la noticia" required="" maxlength="400">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="editContenido">Contenido</label>
                                <textarea class="form-control" name="editContenido" id="editContenido" cols="5"></textarea>
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
<div class="modal fade" id="modalEditImg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Modal de Editar Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateImg" name="formUpdateImg">
                            <input type="hidden" name="photoOld_updFil" id="photoOld_updFil" value="">
                            <input type="hidden" id="id_updImg" name="id_updImg" value="">
                            <div class="form-group">
                                <img src="<?= media() ?>/images/sinimagen.png" class="img-thumbnail" id="photo_file">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="editImg">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="editImg" name="editImg" type="file" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="editDescImg">Descripción de imagen</label>
                                <input class="form-control" id="editDescImg" name="editDescImg" type="text" placeholder="Ingrese la descripción de la portada" maxlength="300">
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
<!-- Modal edit Embed -->
<div class="modal fade" id="modalEditEmbed" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Modal de Editar Embed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateEmbed" name="formUpdateEmbed">
                            <input type="hidden" id="id_updEmbed" name="id_updEmbed" value="">
                            <div class="form-group">
                                <label for="embedLinky">Incrusta Contenido</label>
                                <input type="input" class="form-control" id="embedLinky" name="embedLinky">
                                <input type="hidden" id="link" name="link" value="">
                            </div>
                            <div class="embed-responsive embed-responsive-16by9">
                                <div id="previsualizacionMensajes" class="embed-responsive-item text-center">
                                    <p class="text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando previsualización...</p>
                                </div>
                                <iframe id="embedContenidoo" class="embed-responsive-item" style="display: none;" allowfullscreen></iframe>
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