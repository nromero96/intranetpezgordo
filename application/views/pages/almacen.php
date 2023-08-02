<?php $this->load->view('layouts/header'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: #f9f9f9;">
                    <div class="row">
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

                        <div class="col-md-5">
                            <a href="<?php echo base_url();?>operaciones" class="btn btn-primary btn-md my-1" data-toggle="tooltip" data-placement="left" title="Operaciones" style="float: right;" ><i class="fa fa-plus-square"></i> Operaciones </a>
                            <button type="button" id="ddstock" class="btn btn-info btn-md my-1" data-toggle="tooltip" data-placement="left" title="Agregar Stock" style="float: right;" ><i class="fa fa-plus-square"></i> Agregar Stock </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="mitblista">
                            <thead class=" text-primary">
                                <th class="no-sort">ID</th>
                                <th class="">ITEM</th>
                                <th class="">CAMPAÑA</th>
                                <th  width="70px" class="text-center"></th>
                                <th width="70px" class="text-center">STOCK</th>
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


      <!--Modal Agregar Stock-->
       <div class="modal fade" id="modaladdstock" tabindex="-1" role="dialog" aria-hidden="true">
            <form id="formaddstock" method="POST">
              <div class="modal-dialog" style="" role="document">
                <div class="modal-content card">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Agregar Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label>Item:<span class="text-danger">*</span></label>
                        <select class="form-control" name="id_item" id="id_item" required>
                          <option value="">Seleccione</option>

                          <?php foreach ($categorias as $categoria) { ?>
                            <optgroup label="<?php echo $categoria->nombre; ?>">
                              <?php foreach ($listitems as $item) { 
                                if($item->id_categoria == $categoria->id){
                                  ?>
                                  <option value="<?php echo $item->id; ?>"><?php echo $item->nombre; ?></option>
                                  <?php
                                  }
                                }
                              ?>
                            </optgroup>
                          <?php } ?>

                        </select>
                      </div>
                      <div class="col-md-12 form-group">
                        <label for="cantidad">Cantidad:<span class="text-danger">*</span></label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" required>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer pt-0 pb-1">
                    <button type="submit" id="btnsavestock" class="btn btn-primary">Agregar</button>
                    <button type="button" id="btnresetstock" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!--/.Modal-->

          <!--Modal Historial Stock-->
        <div class="modal fade" id="modalhistorialstock" tabindex="-1" role="dialog" aria-hidden="true">
            <form id="formhistorialstock" method="POST">
              <div class="modal-dialog" style="" role="document">
                <div class="modal-content card">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Historial Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label><b id="nombreitem"></b></label>
                        <div class="table-responsive">
                          <table class="table" id="mitblistahistorial">
                              <thead class=" text-primary">
                                  <th class="no-sort">ID</th>
                                  <th class="">Admin.</th>
                                  <th  width="90px" class="text-center">Cantidad</th>
                                  <th width="160px" class="text-center">Fecha</th>
                              </thead>
                              <tbody id="datalisthistorial">

                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!--/.Modal-->









      </div>

<?php $this->load->view('layouts/footer'); ?>





<script src="<?php echo base_url();?>assets/js/pages/almacen.js"></script>

