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

                        <div class="col-md-4">
                            <button type="button" id="addanew" class="btn btn-primary btn-md my-1" data-toggle="tooltip" data-placement="left" title="Nuevo" style="float: right;" ><i class="fa fa-plus-square"></i> Agregar </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="mitblista">
                            <thead class=" text-primary">
                                <th class="no-sort">ID</th>
                                <th class="">NOMBRE</th>
                                <th class="">DESCRIPCIÓN</th>
                                <th width="100px" class=""></th>
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
                    <h5 class="modal-title font-weight-bold">Datos de la ciudad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label>Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre completo" required>
                      </div>
                      <div class="col-md-12 form-group">
                        <label>Descripción:</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Escriba una descripcion (Opcional)">
                      </div>

                    </div>

                  </div>

                  <div class="modal-footer">
                    <button type="submit" id="btnsave" class="btn btn-sm btn-primary">Agregar</button>
                    <button type="button" id="btnreset" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!--/.Modal-->









      </div>

<?php $this->load->view('layouts/footer'); ?>





<script src="<?php echo base_url();?>assets/js/pages/campaign.js"></script>

