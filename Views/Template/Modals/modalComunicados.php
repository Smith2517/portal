<!-- Modal para Comunicados -->
<div class="modal fade" id="modalFormComunicado" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comunicado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formComunicado" name="formComunicado" enctype="multipart/form-data">
          <input type="hidden" id="idComunicado" name="idComunicado" value="">

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="txtTitulo">Título *</label>
                <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="txtFechaComunicado">Fecha *</label>
                <input type="date" class="form-control" id="txtFechaComunicado" name="txtFechaComunicado" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="txtDescripcion">Descripción</label>
            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4"></textarea>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="imagenComunicado">Imagen *</label>
                <input type="file" class="form-control" id="imagenComunicado" name="imagenComunicado" accept="image/*">
                <small class="form-text text-muted">Formatos: JPG, JPEG, PNG, GIF, WEBP (Max 5MB)</small>
                <div id="imagenPreview" class="mt-2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="pdfComunicado">PDF (Opcional)</label>
                <input type="file" class="form-control" id="pdfComunicado" name="pdfComunicado" accept=".pdf">
                <small class="form-text text-muted">Solo PDF (Max 10MB)</small>
                <div id="pdfPreview" class="mt-2"></div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="listEstado">Estado *</label>
            <select class="form-control" id="listEstado" name="listEstado" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-success" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
            </button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="#" data-dismiss="modal">
              <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
