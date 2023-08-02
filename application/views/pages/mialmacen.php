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
                            <a href="<?= base_url('mis-operaciones') ?>" class="btn btn-info btn-md my-1" data-toggle="tooltip" data-placement="left" title="Operaciones" style="float: right;" ><i class="fa fa-plus-square"></i> Operaciones </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="mitblista">
                            <thead class=" text-primary">
                                <th class="no-sort" width="50px">ID</th>
                                <th class="">ITEM</th>
                                <th class="">CAMPAÑA</th>
                                <th class="">CATEGORÍA</th>
                                <th class="text-center" width="70px">STOCK</th>
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







       <!--Modal-->

       <div class="modal fade" id="modalregistro" tabindex="-1" role="dialog" aria-hidden="true">
            <form id="formregistro" method="POST">
              <input type="hidden" value="" name="idregist" id="idregist">
              <div class="modal-dialog" style="" role="document">

                <div class="modal-content card">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Items disponibles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label for="id_item">Item:<span class="text-danger">*</span></label>
                        <select name="id_item" id="id_item" class="form-control" required>
                          <option value="">Seleccione...</option>
                          <?php
                            foreach ($activelistitems as $key => $actlistitem) {
                              echo '<option value="'.$actlistitem->id.'">'.$actlistitem->nombre.'</option>';
                            }
                          ?>
                        </select>
                    </div>
                  </div>

                  <div class="modal-footer px-0 py-0">
                    <button type="submit" id="btnsave" class="btn btn-primary">Agregar</button>
                    <button type="button" id="btnreset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!--/.Modal-->


      </div>

<?php $this->load->view('layouts/footer'); ?>

<script src="<?php echo base_url();?>assets/js/pages/mialmacen.js"></script>

