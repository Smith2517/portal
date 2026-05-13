<!-- Modal save -->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formSave" name="formSave" class="form-horizontal">
          <p class="text-primary">Todos los campos son obligatorios.</p>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtIdentificacion">Identificación</label>
              <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombre">Nombres</label>
              <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellido">Apellidos</label>
              <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtTelefono">Teléfono</label>
              <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
            </div>
            <div class="form-group col-md-6">
              <label for="txtEmail">Email</label>
              <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="listRolid">Tipo usuario</label>
              <select class="form-control" data-live-search="true" id="listRolid" name="listRolid" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <?php
                $option = null;
                if (is_array($data['page_roles'])) {
                  foreach ($data['page_roles'] as $key => $value) {
                    $option .= "<option value='" . $value['idrol'] . "' >" . $value["nombrerol"] . "</option>";
                  }
                  echo $option;
                }

                ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="listStatus">Status</label>
              <select class="form-control" id="listStatus" name="listStatus" required>
                <option value="0">Inactivo</option>
                <option value="1" selected>Activo</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtPassword">Password</label>
              <input type="password" class="form-control" id="txtPassword" name="txtPassword">
            </div>
          </div>
          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--End modal-->
<!-- Modal edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEdit" name="formEdit" class="form-horizontal">
          <input type="hidden" name="idEdit" id="idEdit">
          <p class="text-primary">Todos los campos son obligatorios.</p>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtIdentificacionEdit">Identificación</label>
              <input type="text" class="form-control" id="txtIdentificacionEdit" name="txtIdentificacionEdit" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombreEdit">Nombres</label>
              <input type="text" class="form-control valid validText" id="txtNombreEdit" name="txtNombreEdit" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellidoEdit">Apellidos</label>
              <input type="text" class="form-control valid validText" id="txtApellidoEdit" name="txtApellidoEdit" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtTelefonoEdit">Teléfono</label>
              <input type="text" class="form-control valid validNumber" id="txtTelefonoEdit" name="txtTelefonoEdit" required="" onkeypress="return controlTag(event);">
            </div>
            <div class="form-group col-md-6">
              <label for="txtEmailEdit">Email</label>
              <input type="email" class="form-control valid validEmail" id="txtEmailEdit" name="txtEmailEdit" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="listRolidEdit">Tipo usuario</label>
              <select class="form-control" data-live-search="true" id="listRolidEdit" name="listRolidEdit" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <?php
                $option = null;
                if (is_array($data['page_roles'])) {
                  foreach ($data['page_roles'] as $key => $value) {
                    $option .= "<option value='" . $value['idrol'] . "' >" . $value["nombrerol"] . "</option>";
                  }
                  echo $option;
                }
                ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="listStatusEdit">Status</label>
              <select class="form-control" id="listStatusEdit" name="listStatusEdit" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="0">Inactivo</option>
                <option value="1">Activo</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtPasswordEdit">Password</label>
              <input type="password" class="form-control" id="txtPasswordEdit" name="txtPasswordEdit">
            </div>
          </div>
          <div class="tile-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Guardar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--End modal-->
<!-- Modal -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="viewIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="viewNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="viewApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="viewTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="viewEmail">Larry</td>
            </tr>
            <tr>
              <td>Tipo Usuario:</td>
              <td id="viewTipoUsuario">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="viewEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="viewFechaRegistro">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>