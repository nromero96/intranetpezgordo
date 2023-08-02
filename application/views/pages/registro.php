<?php $this->load->view('layouts/header'); ?>

      <div class="content">

        <div class="row">

          <div class="col-md-12">

            <div class="card">

              <div class="card-header" style="background: #f9f9f9;">

                <div class="row">

                <div class="col-md-4">

                <h4 class="card-title">Últimos <b>20</b> Registros</h4>

                </div>

                <div class="col-md-4">

                    <form id="formbuscarregistro">

                        <div class="input-group no-border">

                          <input type="text" value="" name="searchnumero" id="searchnumero" class="form-control" placeholder="Ingrese la placa...">

                            <div class="input-group-append">

                              <div class="input-group-text">

                                <i class="nc-icon nc-zoom-split"></i>

                              </div>

                            </div>

                          <div class="input-group-append">

                            <button type="submit" id="sbt" class="btn btn-primary my-0"><span id="btntext">Buscar</span></button>

                          </div>

                        </div>

                      

                    </form>

                </div>



                <div class="col-md-4">
<!-- 
                  <button type="button" id="addnumero" class="btn btn-primary btn-md" data-toggle="tooltip" data-placement="left" title="Nuevo Usuario" style="float: right;" ><i class="fa fa-plus-square"></i> Exportar Lista </button> -->

                </div>

                </div>

                

              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" id="mitblista">
                    <thead class=" text-primary">
                      <th class="text-center no-sort">ID</th>
                      
                      <th class="">NOMBRES</th>
                      <th class="">CORREO</th>
                      <th width="50px" class="no-sort">JUEGO</th>
                      <th class="">FECHA</th>
                    </thead>
                    <tbody id="datalist">

                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>

        </div>







       <!--Modal-->

       <div class="modal fade" id="modalregistro" tabindex="-1" role="dialog" aria-hidden="true">
            <form id="formregistro" method="POST">
              <input type="hidden" value="" name="idnumero" id="idnumero">
              <div class="modal-dialog" style="" role="document">

                <div class="modal-content card">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Datos Del Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-6 form-group">
                           <input type="text" name="numero" id="numero" class="form-control" placeholder="Número" required>
                      </div>

                      <div class="col-md-6 form-group">
                        <select name="estado" id="estado" class="form-control" required>
                          <option value="">Seleccione...</option>
                          <option value="1">Activo</option>
                          <option value="2">Suspendido</option>
                          <option value="3">Renovado</option>
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





<script src="<?php echo base_url();?>assets/js/pages/registro.js"></script>

