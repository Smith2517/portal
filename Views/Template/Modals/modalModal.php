<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Diseñar Modal de Avisos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <div class="tile-footer">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Datos Generales
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="txtTitulo">Título</label>
                                                    <input type="text" class="form-control" name="txtTitulo" id="txtTitulo" pattern="[a-zA-Z0-9 ]{1,100}" required oninput="this.value = this.value.toUpperCase()">
                                                    <small id="tituloHelp" class="form-text text-muted">Solo se permiten caracteres alfabéticos y numéricos, hasta 100 caracteres.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtContenido">Contenido</label>
                                                    <textarea class="form-control" name="txtContenido" id="txtContenido" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Configuración
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="activarFechas" id="activarFechas">
                                                        <label class="form-check-label" for="activarFechas">Activar fechas</label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="fechaInicio">Fecha y hora de inicio</label>
                                                        <input type="datetime-local" class="form-control transition-opacity" name="fechaInicio" id="fechaInicio" disabled min="<?php echo date('Y-m-d\TH:i'); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="fechaFin">Fecha y hora de fin</label>
                                                        <input type="datetime-local" class="form-control transition-opacity" name="fechaFin" id="fechaFin" disabled min="<?php echo date('Y-m-d\TH:i', strtotime('+1 hour')); ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tamanoAviso">Tamaño del aviso</label>
                                                    <select class="form-control" name="tamanoAviso" id="tamanoAviso" required>
                                                        <option value="sm">Pequeño (sm)</option>
                                                        <option value="lg">Grande (lg)</option>
                                                        <option value="xl">Extra Grande (xl)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="modalEstatico" id="modalEstatico">
                                                        <label class="form-check-label" for="modalEstatico">Modal Estatico</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="modalEscrolable" id="modalEscrolable">
                                                        <label class="form-check-label" for="modalEscrolable">Modal Escrollable</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Incrusta contenido
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="embedLink">Incrusta Contenido</label>
                                                    <input type="input" class="form-control" id="embedLink" name="embedLink">
                                                    <input type="hidden" id="urls" name="urls" value="">
                                                </div>
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <div id="previsualizacionMensaje" class="embed-responsive-item text-center">
                                                        <p class="text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando previsualización...</p>
                                                    </div>
                                                    <iframe id="embedContenido" class="embed-responsive-item" style="display: none;" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingFour">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                    Enlaces de redireccion
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <!-- Sección para agregar más inputs -->
                                                <div id="dynamicInputs">
                                                    <!-- Inputs dinámicos se agregarán aquí -->
                                                </div>
                                                <!-- Botones para agregar y borrar inputs -->
                                                <div class="text-center mt-3">
                                                    <button type="button" class="btn btn-primary" id="addInput">Agregar Enlace</button>
                                                    <button type="button" class="btn btn-danger" id="removeInput">Borrar Último Enlace</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <br>
                                <!-- Campo de imagen oculto (se convierte a base64 para enviar) -->
                                <div class="form-group">
                                    <label><i class="fas fa-image mr-1"></i> Imagen del Aviso <small class="text-muted">(Opcional — JPG, PNG, GIF — máx. 10MB)</small></label>
                                    <input type="file" class="form-control-file" id="imagenAviso" name="imagenAviso" accept="image/jpeg,image/png,image/gif">
                                    <div id="previewImagenAviso" class="mt-2" style="display:none;">
                                        <p class="small text-muted mb-1">Vista previa:</p>
                                        <img id="imgPreviewAviso" src="" alt="Vista previa" style="max-width:200px; max-height:160px; border-radius:6px; border:1px solid #dee2e6;">
                                    </div>
                                </div>
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

<!--Modal edit Datos Gen-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Modal de Editar Datos Generales</h5>
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
                                <label class="control-label" for="tituloEditModal">Titulo</label>
                                <input class="form-control" id="tituloEditModal" name="tituloEditModal" type="text" placeholder="Ingrese el titulo de la/los/el <?= $data['page_name'] ?>" pattern="[a-zA-Z0-9 ]{1,100}" required oninput="this.value = this.value.toUpperCase()">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="txtDescripcion_upd">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion_upd" name="txtDescripcion_upd" rows="5" placeholder="Descripción de el/la/los <?= $data['page_name'] ?>"></textarea>
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

<!--Modal edit Embed-->
<div class="modal fade" id="modalEditEmbed" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEditEmbed">Modal de Editar Embed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateEmed" name="formUpdateEmed">
                            <input type="hidden" id="id_upde" name="id_upde" value="">
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="embedLinky">Incrusta Contenido</label>
                                    <input type="input" class="form-control" id="embedLinky" name="embedLinky">
                                    <input type="hidden" id="url" name="url" value="">
                                </div>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <div id="previsualizacionMensajes" class="embed-responsive-item text-center">
                                        <p class="text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando previsualización...</p>
                                    </div>
                                    <iframe id="embedContenidoo" class="embed-responsive-item" style="display: none;" allowfullscreen></iframe>
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

<!--Modal edit Configuración-->
<div class="modal fade" id="modalEditSize" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Modal de Editar Configuración</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formupdateSize" name="formupdateSize">
                            <input type="hidden" id="id_upds" name="id_upds" value="">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tamAvi">Tamaño del aviso</label>
                                    <select class="form-control" name="tamAvi" id="tamAvi" required>
                                        <option value="sm">Pequeño (sm)</option>
                                        <option value="lg">Grande (lg)</option>
                                        <option value="xl">Extra Grande (xl)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="modalEstatic" id="modalEstatic">
                                        <label class="form-check-label" for="modalEstatic">Modal Estatico</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="modalEscrol" id="modalEscrol">
                                        <label class="form-check-label" for="modalEscrol">Modal Escrollable</label>
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

<!--Modal edit Fecha/Hora-->
<div class="modal fade" id="modalEditFecha" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleEdit">Modal de Editar Fecha/Hora</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateFecha" name="formUpdateFecha">
                            <input type="hidden" id="id_updfh" name="id_updfh" value="">
                                <!--
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="activFechas" id="activFechas">
                                        <label class="form-check-label" for="activFechas">Activar fechas</label>
                                    </div>
                                </div>-->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="fechaIni">Fecha y hora de inicio</label>
                                        <input type="datetime-local" class="form-control transition-opacity" name="fechaIni" id="fechaIni" min="<?php echo date('Y-m-d\TH:i'); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fechaEnd">Fecha y hora de fin</label>
                                        <input type="datetime-local" class="form-control transition-opacity" name="fechaEnd" id="fechaEnd" min="<?php echo date('Y-m-d\TH:i', strtotime('+1 hour')); ?>">
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

<!--Modal edit Imagen-->
<div class="modal fade" id="modalEditImagen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Editar Imagen del Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUpdateImagen" name="formUpdateImagen">
                            <input type="hidden" id="id_updimg" name="id_updimg" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="imagenAvisoEdit">Nueva Imagen (JPG, PNG, GIF — máx. 2MB)</label>
                                    <input type="file" class="form-control-file" id="imagenAvisoEdit" name="imagenAvisoEdit" accept="image/jpeg,image/png,image/gif" required>
                                    <small class="form-text text-muted">Seleccione una imagen para reemplazar la actual.</small>
                                </div>
                                <div id="previewImagenAvisoEdit" class="mt-2" style="display:none;">
                                    <p class="small text-muted mb-1">Vista previa:</p>
                                    <img id="imgPreviewAvisoEdit" src="" alt="Vista previa" style="max-width:200px; max-height:160px; border-radius:6px; border:1px solid #dee2e6;">
                                </div>
                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Guardar Imagen</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->