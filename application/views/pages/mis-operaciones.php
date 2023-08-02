<?php $this->load->view('layouts/header'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: #f9f9f9;">
                    <div class="row">
                        <div class="col-md-3">
                            <p class="card-title">Últimos <b>20</b> Operaciones</p>
                        </div>
                        <div class="col-md-4">
                            <form id="formbuscarregistro">
                                <div class="input-group no-border my-1">
                                    <input type="text" value="" name="querydata" id="querydata" class="form-control" placeholder="Buscar...">
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

                        <div class="col-md-3 py-1">
                          <select name="campaign" id="campaign" class="form-control">
                              <option value="">Ver por campaña...</option>
                              <?php foreach ($campaigns as $campaign) { ?>
                                <option value="<?php echo $campaign->id; ?>"><?php echo $campaign->nombre; ?></option>
                              <?php } ?>
                          </select>
                        </div>

                        <div class="col-md-2">
                            <button type="button" id="addanew" class="btn btn-primary btn-md my-1 px-3" data-toggle="tooltip" data-placement="top" title="Nueva operación" style="float: right;" ><i class="fa fa-plus"></i></button>
                            <button type="button" id="transfer" class="btn btn-info btn-md my-1 mx-2 px-3" data-toggle="tooltip" data-placement="top" title="Transferir entre afiliadores" style="float: right;" ><i class="fa fa-exchange"></i></button>
                          </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="mitblista">
                            <thead class=" text-primary">
                                <th class="no-sort">ID</th>
                                <th class="">SUPERVISOR</th>
                                <th class="">CIUDAD</th>
                                <th width="75px" >TIPO</th>
                                <th class="">AFILIADOR</th>
                                <th class="">ITEM</th>
                                <th class="text-center">CANTIDAD</th>
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
</div>







       <!--Modal Información de la operación-->

       <div class="modal fade" id="modalregistro" tabindex="-1" role="dialog" aria-hidden="true">
            <form id="formregistro" method="POST">
              <input type="hidden" value="" name="idregist" id="idregist">
              <div class="modal-dialog modal-lg" style="" role="document">

                <div class="modal-content card">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Información de la operación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                    <div class="row">
                      <div class="col-md-12 form-group text-center">
                        <label for="">Tipo:<span class="text-danger">*</span></label><br>
                        <div class="custom-control custom-radio cursor-pointer custom-control-inline">
                          <input type="radio" id="tipo1" name="tipo" class="custom-control-input" value="Salida" checked>
                          <label class="custom-control-label" for="tipo1">Salida</label>
                        </div>
                        <div class="custom-control custom-radio cursor-pointer custom-control-inline">
                          <input type="radio" id="tipo2" name="tipo" class="custom-control-input" value="Retorno">
                          <label class="custom-control-label" for="tipo2">Retorno</label>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="row p-3">

                          <div class="col-md-5 border rounded text-center justify-content-center align-self-center pt-3 pb-3">
                            <input type="text" class="form-control text-center" name="encargado" id="encargado" value="<?php echo $this->session->userdata('nombreapellido'); ?>" readonly>
                          </div>

                          <div class="col-md-2 text-center justify-content-center align-self-center pt-3 pb-3">
                            <div id="guiaiconosdesktop">
                              <i class="nc-icon icnoperacion nc-minimal-right salidadesktop" id="icndeskguia"></i>
                            </div>
                            <div id="guiaiconosmovil">
                              <i class="nc-icon icnoperacion nc-minimal-down salidamovil" id="icnmovlguia"></i>
                            </div>
                          </div>

                          <div class="col-md-5 form-group border rounded">
                          
                            <div class="form-group">
                              <label for="id_ciudad">Ciudad:<spa class="text-danger">*</spa></label>
                              <select class="form-control" name="id_ciudad" id="id_ciudad" required>
                                <?php 
                                  $userciudad = $this->session->userdata('id_ciudad');
                                  foreach ($ciudades as $ciudad) {
                                  //get id_ciudad user logued
                                  if($userciudad == $ciudad->id){
                                    ?>
                                    <option value="<?php echo $ciudad->id; ?>" ><?php echo $ciudad->nombre; ?></option>
                                  <?php 
                                  }
                                } 
                              ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="id_afiliador">Afiliador:<spa class="text-danger">*</spa></label>
                              <select class="form-control" name="id_afiliador" id="id_afiliador" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($afiliadores as $afiliador) { ?>
                                  <option value="<?php echo $afiliador->idusuario; ?>"><?php echo $afiliador->nombreapellido; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="id_almaceitem">Item:<spa class="text-danger">*</spa></label>
                              <select class="form-control" name="id_almaceitem" id="id_almaceitem" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($almacenitems as $item) { ?>
                                  <option data-stock="<?php echo $item->stock; ?>" value="<?php echo $item->id; ?>"><?php echo $item->item . ' - <strong>(' . $item->stock . ')</strong>' ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="cantidad">Cantida:<spa class="text-danger">*</spa></label>
                              <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                            </div>

                          </div>

                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="modal-footer">
                  <button type="button" id="btnreset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnsave" class="btn btn-primary">Agregar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!--/.Modal Información de la operación-->


        <!--Modal transferencia-->
       <div class="modal fade" id="modalregistrotransferencia" tabindex="-1" role="dialog" aria-hidden="true">
            <form id="formregistrotransferencia" method="POST">
              <div class="modal-dialog modal-lg" style="" role="document">
                <div class="modal-content card">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Información de la transferencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                    <div class="row">
                      <div class="col-md-12">
                        <div class="row p-3">

                        <div class="col-md-5 form-group border rounded">
                          <div class="form-group">
                            <label for="id_ciudad_origen">Ciudad:<spa class="text-danger">*</spa></label>
                            <select class="form-control" name="id_ciudad_origen" id="id_ciudad_origen" required>
                              <?php 
                                $userciudad = $this->session->userdata('id_ciudad');
                                foreach ($ciudades as $ciudad) {
                                //get id_ciudad user logued
                                if($userciudad == $ciudad->id){
                                  ?>
                                  <option value="<?php echo $ciudad->id; ?>" ><?php echo $ciudad->nombre; ?></option>
                                <?php 
                                }
                              } 
                            ?>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="id_afiliador_origen">Afiliador:<spa class="text-danger">*</spa></label>
                            <select class="form-control" name="id_afiliador_origen" id="id_afiliador_origen" required>
                              <option value="">Seleccione...</option>
                              <?php foreach ($afiliadores as $afiliador) { ?>
                                <option value="<?php echo $afiliador->idusuario; ?>"><?php echo $afiliador->nombreapellido; ?></option>
                              <?php } ?>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="id_almaceitem_origen">Item:<spa class="text-danger">*</spa></label>
                            <select class="form-control" name="id_almaceitem_origen" id="id_almaceitem_origen" required>
                              <option value="">Escoger un afiliador...</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="cantidad_origen">Cantida:<spa class="text-danger">*</spa></label>
                            <input type="number" class="form-control" name="cantidad_origen" id="cantidad_origen" required>
                          </div>

                        </div>

                          <div class="col-md-2 text-center justify-content-center align-self-center pt-3 pb-3">
                            <div id="guiaiconosdesktop">
                              <i class="nc-icon icnoperacion nc-minimal-right salidadesktop" id="icndeskguia"></i>
                            </div>
                            <div id="guiaiconosmovil">
                              <i class="nc-icon icnoperacion nc-minimal-down salidamovil" id="icnmovlguia"></i>
                            </div>
                          </div>

                          <div class="col-md-5 form-group border rounded justify-content-center align-self-center">
                          
                            <div class="form-group">
                              <label for="id_ciudad_destino">Ciudad:<spa class="text-danger">*</spa></label>
                              <select class="form-control" name="id_ciudad_destino" id="id_ciudad_destino" required>
                                <?php 
                                  $userciudad = $this->session->userdata('id_ciudad');
                                  foreach ($ciudades as $ciudad) {
                                  //get id_ciudad user logued
                                  if($userciudad == $ciudad->id){
                                    ?>
                                    <option value="<?php echo $ciudad->id; ?>" ><?php echo $ciudad->nombre; ?></option>
                                  <?php 
                                  }
                                } 
                              ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="id_afiliador_destino">Afiliador:<spa class="text-danger">*</spa></label>
                              <select class="form-control" name="id_afiliador_destino" id="id_afiliador_destino" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($afiliadores as $afiliador) { ?>
                                  <option value="<?php echo $afiliador->idusuario; ?>"><?php echo $afiliador->nombreapellido; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="modal-footer">
                  <button type="button" id="btnresettransf" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btntransf" class="btn btn-primary">Transferir</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!--/.Modal Información de la operación-->
        







      </div>

<?php $this->load->view('layouts/footer'); ?>





<script src="<?php echo base_url();?>assets/js/pages/mis-operaciones.js"></script>

