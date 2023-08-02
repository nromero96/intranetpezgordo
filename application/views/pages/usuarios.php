<?php $this->load->view('layouts/header'); ?>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                <div class="col-md-6">
                <h4 class="card-title">Lista de usuarios</h4>
                </div>

                <div class="col-md-6">
                  <button type="button" id="adduser" class="btn btn-primary btn-md" data-toggle="tooltip" data-placement="top" title="Nuevo Usuario" style="float: right;" ><i class="fa fa-plus-square"></i> NUEVO </button>
                  <a href="<?= base_url('historial-login'); ?>" class="btn btn-info btn-md" data-toggle="tooltip" data-placement="top" title="Historial de Acessos" style="float: right;" ><i class="fa fa-history" aria-hidden="true"></i></a>
                  <a href="<?= base_url('importar-usurios-afiliadores'); ?>" class="btn btn-alert btn-md" data-toggle="tooltip" data-placement="top" title="Importar afiliadores" style="float: right;"><i class="fa fa-file" aria-hidden="true"></i></a>
                </div>
                </div>
                
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" id="mitblista">
                    <thead class=" text-primary">
                      <th class="no-sort">
                        #
                      </th>
                      <th class="text-center">
                        Estado
                      </th>
                      <th>
                        Nombres
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Teléfono
                      </th>
                      <th>
                        Tipo
                      </th>
                      <th class="text-center">
                        Verif.
                      </th>
                      <th class="no-sort">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </thead>
                    <tbody id="datalist">

                      <tr>
                        <td colspan="8" class="text-center">Cargando...</td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <p><a href="<?= base_url('/usuarios-elimiados'); ?>" class="btn btn-info">VER USUARIOS ELIMINADOS</a></p>
          </div>
        </div>



       <!--Modal-->
       <div class="modal fade" id="modalusuario" tabindex="-1" role="dialog" aria-hidden="true">
            <form id="formusuario" method="POST">
              <input type="hidden" value="" name="idusuario" id="idpersonal">
              <div class="modal-dialog" style="" role="document">
                <div class="modal-content card">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Datos Del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12 form-group">
                          <label for="nombreyapellido">Nombre y Apellidos:<span class="text-danger">*</span> </label>
                          <input type="text" name="nombreyapellido" id="nombreyapellido" class="form-control" placeholder="" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                          <label for="email">Correo Navego:<span class="text-danger">*</span></label>
                          <input type="email" name="email" id="email" class="form-control" required>
                          <small class="txtms" id="msinfo"></small>
                      </div>
                      <div class="col-md-6 form-group">
                          <label for="email">Teléfono:<span class="text-danger">*</span></label>
                          <input type="text" name="numero" id="numero" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="id_ciudad">Ciudad:<span class="text-danger">*</span></label>
                        <select class="form-control" name="id_ciudad" id="id_ciudad" required>
                          <option value="">Seleccione</option>
                          <?php foreach ($ciudades as $ciudad) { ?>
                            <option value="<?php echo $ciudad->id; ?>"><?php echo $ciudad->nombre; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="fecha_ingreso">Fecha de ingreso:<span class="text-danger">*</span></label>
                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" placeholder="Número">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="rolusuario">Tipo de personal:<span class="text-danger">*</span></label>
                        <select name="rolusuario" id="rolusuario" class="form-control" required>
                          <option value="">Seleccione...</option>
                          <option value="1">Administrador</option>
                          <option value="2">Supervisor</option>
                          <option value="3">Afiliador</option>
                        </select>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="password">Contraseña:<span class="text-danger">*</span></label>
                        <div class="input-group" id="show_hide_password">
                          <input type="password" name="password" id="password" class="form-control" placeholder="" required>
                          <div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                          </div>
                         </div>
                      </div>
                    </div>

                    <div class="row" id="selectlistsupervisores">
                      <div class="col-md-6 form-group">
                        <label for="registradopor">Supervisor Asignado:</label>
                        <select name="registradopor" id="registradopor" class="form-control">
                          <option value="0">Ninguna</option>
                          <?php
                            foreach ($supervisores as $supervisor) {
                              echo '<option value="'.$supervisor->idusuario.'">'.$supervisor->nombreapellido.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="submit" id="btnsave" class="btn btn-sm btn-primary">Guardar</button>
                    <button type="button" id="btnreset" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!--/.Modal-->




      </div>
<?php $this->load->view('layouts/footer'); ?>


<script src="<?php echo base_url();?>assets/js/pages/usuarios.js"></script>

<script src="<?php echo base_url();?>assets/js/plugins/datatables/datatables.min.js"></script>