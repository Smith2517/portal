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
                            <div class="form-group">
                                <img src="<?= media() ?>/images/sinimagen.png" class="img-thumbnail" id="file-img" alt="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo">Imagen [Med. Recomendada(2048x776px)]</label>
                                <input class="form-control" id="flArchivo" name="flArchivo" type="file" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtNombre">Nombre</label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del tipo de norma" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="5" placeholder="Descripción del tipo de norma" required=""></textarea>
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
                        <form id="formUpdateGrupoFuncionario" name="formUpdateGrupoFuncionario">
                            <input type="hidden" id="idgf_upd" name="idgf_upd" value="">
                            <div class="form-group">
                                <label class="control-label" for="txtNombregf_upd">Titulo </label>
                                <input class="form-control" id="txtNombregf_upd" name="txtNombregf_upd" type="text" placeholder="Titulo del grupo de funcionarios" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripciongf_upd">Descripción</label>
                                <textarea class="form-control" id="txtDescripciongf_upd" name="txtDescripciongf_upd" rows="5" placeholder="Descripción del grupo de funcionarios" required=""></textarea>
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
<!-- Modal save-->
<div class="modal fade" id="modalSaveAddFuncionarios" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Agregar Nuevo Funcionario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSaveFuncionario" name="formSaveFuncionario">
                            <input type="hidden" name="idGrupoFuncionarios" value="<?= $data['page_infoGrupoFuncionario']['id'] ?>">
                            <div class="form-group d-flex justify-content-center">
                                <img src="<?= media() ?>/images/sinimagen.png" class="img-thumbnail" id="file-imgFuncionario" alt="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivoFuncionario">Imagen [Med. Recomendada(413x531px) 300 DPI]</label>
                                <input class="form-control" id="flArchivoFuncionario" name="flArchivoFuncionario" type="file" accept="image/*" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtNombre">Nombres</label>
                                    <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese los nombres del funcionario" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtApellidos">Apellidos</label>
                                    <input class="form-control" id="txtApellidos" name="txtApellidos" type="text" placeholder="Ingrese los apellidos del funcionario" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtDependecia">Dependencia/Gestion</label>
                                    <input class="form-control" id="txtDependecia" name="txtDependecia" type="text" placeholder="Ingrese nombre de la Dependecia o area que pertenece y/o gestion" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCargo">Cargo</label>
                                    <input class="form-control" id="txtCargo" name="txtCargo" type="text" placeholder="Ingrese el cargo que tiene el funcionario">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtMail">Correo Electronico</label>
                                    <input class="form-control" id="txtMail" name="txtMail" type="email" placeholder="Ingrese su correo electronico">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtPhone">Numero Celular</label>
                                    <input class="form-control" id="txtPhone" name="txtPhone" type="number" min="900000000" maxlength="999999999" placeholder="999 999 999">
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
<div class="modal fade" id="modalEditFuncionarios" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Editar informacion del funcionario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateFuncionario" name="formUpdateFuncionario">
                            <input type="hidden" id="idF_upd" name="idF_upd" value="">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtNombref_upd">Nombres</label>
                                    <input class="form-control" id="txtNombref_upd" name="txtNombref_upd" type="text" placeholder="Ingrese los nombres del funcionario" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtApellidos_upd">Apellidos</label>
                                    <input class="form-control" id="txtApellidos_upd" name="txtApellidos_upd" type="text" placeholder="Ingrese los apellidos del funcionario" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtDependecia_upd">Dependencia/Gestion</label>
                                    <input class="form-control" id="txtDependecia_upd" name="txtDependecia_upd" type="text" placeholder="Ingrese nombre de la Dependecia o area que pertenece y/o gestion" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtCargo_upd">Cargo</label>
                                    <input class="form-control" id="txtCargo_upd" name="txtCargo_upd" type="text" placeholder="Ingrese el cargo que tiene el funcionario" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtMail_upd">Correo Electronico</label>
                                    <input class="form-control" id="txtMail_upd" name="txtMail_upd" type="email" placeholder="Ingrese su correo electronico">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="txtPhone_upd">Numero Celular</label>
                                    <input class="form-control" id="txtPhone_upd" name="txtPhone_upd" type="number" min="900000000" maxlength="999999999" placeholder="999 999 999">
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
<div class="modal fade" id="modalEditFileFuncionario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Editar Foto Funcionario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateFileFuncionario" name="formUpdateFileFuncionario">
                            <input type="hidden" id="ip_updFilFuncionario" name="ip_updFilFuncionario" value="">
                            <input type="hidden" name="photoOld_updFilFuncionario" id="photoOld_updFilFuncionario" value="">
                            <div class="form-group d-flex justify-content-center">
                                <img src="" class="img-thumbnail" id="photo_fileFuncionario" alt="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="flArchivo_updFilFuncionario">Imagen [Med. Recomendada(413x531px) 300DPI]</label>
                                <input class="form-control" id="flArchivo_updFilFuncionario" name="flArchivo_updFilFuncionario" type="file" accept="image/*" required>
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