<?php
headerAdmin($data);
getModal('modalConvocatorias', $data);
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fas fa-bullhorn"></i> <?= $data['page_title'] ?>
        <?php if ($_SESSION['permisosMod']['w']) { ?>
          <button class="btn btn-primary btn-save" id="btn-save" type="button" onclick="openModal()">
            <i class="fas fa-plus-circle"></i> Nueva Convocatoria
          </button>
        <?php } ?>
      </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/convocatorias"><?= $data['page_title'] ?></a></li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tableConvocatorias">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Título</th>
                  <th>Descripción</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal para Convocatorias -->
<div class="modal fade" id="modalFormConvocatoria" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Convocatoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formConvocatoria" name="formConvocatoria">
          <input type="hidden" id="idConvocatoria" name="idConvocatoria" value="">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtTitulo">Título *</label>
                <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtFechaInicio">Fecha Inicio *</label>
                <input type="date" class="form-control" id="txtFechaInicio" name="txtFechaInicio" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtFechaFin">Fecha Fin *</label>
                <input type="date" class="form-control" id="txtFechaFin" name="txtFechaFin" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="listEstado">Estado *</label>
                <select class="form-control" id="listEstado" name="listEstado" required>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="txtDescripcion">Descripción</label>
            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3"></textarea>
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

<!-- Modal para Items -->
<div class="modal fade" id="modalFormItem" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Item de Convocatoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formItem" name="formItem">
          <input type="hidden" id="idItem" name="idItem" value="">
          <input type="hidden" id="txtConvocatoriaIdItem" name="txtConvocatoriaIdItem" value="">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtNombreItem">Nombre *</label>
                <input type="text" class="form-control" id="txtNombreItem" name="txtNombreItem" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtOrdenItem">Orden</label>
                <input type="number" class="form-control" id="txtOrdenItem" name="txtOrdenItem" value="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="txtDescripcionItem">Descripción</label>
            <textarea class="form-control" id="txtDescripcionItem" name="txtDescripcionItem" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="listEstadoItem">Estado *</label>
            <select class="form-control" id="listEstadoItem" name="listEstadoItem" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="tile-footer">
            <button id="btnActionFormItem" class="btn btn-success" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnTextItem">Guardar</span>
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

<!-- Modal para Documentos -->
<div class="modal fade" id="modalFormDocumento" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Documento de Convocatoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formDocumento" name="formDocumento" enctype="multipart/form-data">
          <input type="hidden" id="idDocumento" name="idDocumento" value="">
          <input type="hidden" id="txtItemIdDocumento" name="txtItemIdDocumento" value="">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtTituloDocumento">Título *</label>
                <input type="text" class="form-control" id="txtTituloDocumento" name="txtTituloDocumento" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtOrdenDocumento">Orden</label>
                <input type="number" class="form-control" id="txtOrdenDocumento" name="txtOrdenDocumento" value="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="txtDescripcionDocumento">Descripción</label>
            <textarea class="form-control" id="txtDescripcionDocumento" name="txtDescripcionDocumento" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="archivoDocumento">Archivo</label>
            <input type="file" class="form-control" id="archivoDocumento" name="archivoDocumento" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">
            <small class="form-text text-muted">Formatos permitidos: PDF, DOC, XLS, JPG, PNG, GIF</small>
          </div>

          <div class="form-group">
            <label for="listEstadoDocumento">Estado *</label>
            <select class="form-control" id="listEstadoDocumento" name="listEstadoDocumento" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="tile-footer">
            <button id="btnActionFormDocumento" class="btn btn-success" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnTextDocumento">Guardar</span>
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

<!-- Modal para ver documentos de un item -->
<div class="modal fade" id="modalDocumentosItem" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Documentos del Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 id="tituloItem">Documentos del Item</h5>
          <button type="button" class="btn btn-primary btn-sm" onclick="openModalDocumentoPorItem()">
            <i class="fas fa-plus-circle"></i> Nuevo Documento
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered" id="tablaDocumentosItem">
            <thead>
              <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Ruta del Archivo</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="cuerpoTablaDocumentos"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para ver estructura jerárquica -->
<div class="modal fade" id="modalEstructura" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Estructura de Convocatorias</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="estructuraConvocatorias"></div>
      </div>
    </div>
  </div>
</div>

<?php footerAdmin($data); ?>