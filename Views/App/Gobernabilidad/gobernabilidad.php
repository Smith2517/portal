<?php
headerAdmin($data);
getModal('modalGobernabilidad', $data);
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fas fa-balance-scale"></i> <?= $data['page_title'] ?>
        <?php if ($_SESSION['permisosMod']['w']) { ?>
          <button class="btn btn-primary btn-save" id="btn-save" type="button" onclick="openModal()">
            <i class="fas fa-plus-circle"></i> Nuevo
          </button>
        <?php } ?>
      </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/gobernabilidad"><?= $data['page_title'] ?></a></li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tableGobernabilidad">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
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

<!-- Modal para Items -->
<div class="modal fade" id="modalFormGobernabilidad" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Item de Gobernabilidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGobernabilidad" name="formGobernabilidad">
          <input type="hidden" id="idItem" name="idItem" value="">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtNombre">Nombre *</label>
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtOrden">Orden</label>
                <input type="number" class="form-control" id="txtOrden" name="txtOrden" value="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="txtDescripcion">Descripción</label>
            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="listEstado">Estado *</label>
            <select class="form-control" id="listEstado" name="listEstado" required>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
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

<!-- Modal para Indicadores -->
<div class="modal fade" id="modalFormIndicador" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Indicador de Gobernabilidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formIndicador" name="formIndicador">
          <input type="hidden" id="idIndicador" name="idIndicador" value="">
          <input type="hidden" id="txtItemIdIndicador" name="txtItemIdIndicador" value="">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtNombreIndicador">Nombre *</label>
                <input type="text" class="form-control" id="txtNombreIndicador" name="txtNombreIndicador" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtOrdenIndicador">Orden</label>
                <input type="number" class="form-control" id="txtOrdenIndicador" name="txtOrdenIndicador" value="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="txtDescripcionIndicador">Descripción</label>
            <textarea class="form-control" id="txtDescripcionIndicador" name="txtDescripcionIndicador" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="listEstadoIndicador">Estado *</label>
            <select class="form-control" id="listEstadoIndicador" name="listEstadoIndicador" required>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
          </div>

          <div class="tile-footer">
            <button id="btnActionFormIndicador" class="btn btn-success" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnTextIndicador">Guardar</span>
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

<!-- Modal para Archivos -->
<div class="modal fade" id="modalFormArchivo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Archivo de Gobernabilidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formArchivo" name="formArchivo" enctype="multipart/form-data">
          <input type="hidden" id="idArchivo" name="idArchivo" value="">
          <input type="hidden" id="txtIndicadorIdArchivo" name="txtIndicadorIdArchivo" value="">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtTituloArchivo">Título *</label>
                <input type="text" class="form-control" id="txtTituloArchivo" name="txtTituloArchivo" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtOrdenArchivo">Orden</label>
                <input type="number" class="form-control" id="txtOrdenArchivo" name="txtOrdenArchivo" value="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="txtDescripcionArchivo">Descripción</label>
            <textarea class="form-control" id="txtDescripcionArchivo" name="txtDescripcionArchivo" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="archivoPdf">Archivo PDF</label>
            <input type="file" class="form-control" id="archivoPdf" name="archivoPdf" accept=".pdf">
            <small class="form-text text-muted">Solo se permiten archivos PDF de máximo 10MB</small>
          </div>

          <div class="form-group">
            <label for="listEstadoArchivo">Estado *</label>
            <select class="form-control" id="listEstadoArchivo" name="listEstadoArchivo" required>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
          </div>

          <div class="tile-footer">
            <button id="btnActionFormArchivo" class="btn btn-success" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnTextArchivo">Guardar</span>
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

<!-- Modal para ver archivos de un indicador -->
<div class="modal fade" id="modalArchivosIndicador" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Archivos del Indicador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 id="tituloIndicador">Archivos del Indicador</h5>
          <button type="button" class="btn btn-primary btn-sm" onclick="openModalArchivoPorIndicador()">
            <i class="fas fa-plus-circle"></i> Nuevo Archivo
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered" id="tablaArchivosIndicador">
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
            <tbody id="cuerpoTablaArchivos"></tbody>
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
        <h5 class="modal-title">Estructura de Gobernabilidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="estructuraGobernabilidad"></div>
      </div>
    </div>
  </div>
</div>

<?php footerAdmin($data); ?>
