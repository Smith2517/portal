<!-- Modal save-->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleSave">Subir Archivos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formSave" name="formSave">
                            <div class="form-group">
                                <label for="archivo">Selecciona un archivo:</label>
                                <input type="file" class="form-control-file" required id="archivo" name="archivo">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre personalizado (opcional):</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" pattern="^[a-zA-Z0-9\s\-]*$">
                            </div>
                            <button type="submit" class="btn btn-primary">Subir Archivo</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->
<!-- Modal detail-->
<div class="modal fade" id="modalDatail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleDetail">Nombre archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-4 border py-1">Nombre</div>
                            <div class="col-8 border py-1 name-file" id="name-file"></div>
                            <div class="col-4 border py-1">Ubicacion</div>
                            <div class="col-8 border py-1" id="ubicacion-file"></div>
                            <div class="col-4 border py-1">Link - Url</div>
                            <div class="col-8 border py-1"><a href="" target="_blank" class="text-center" rel="noopener noreferrer" id="url-file">Click Aqui</a></div>
                            <div class="col-4 border py-1">Tipo Archivo</div>
                            <div class="col-8 border py-1" id="extension-file"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->