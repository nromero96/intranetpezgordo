<?php $this->load->view('layouts/header'); ?>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="card-title">Historial de Acessos</h4>
                    </div>

                    <div class="col-md-2">
                        <button type="button" id="adduser" class="btn btn-primary btn-md" data-toggle="tooltip" data-placement="left" title="Nuevo Usuario" style="float: right;" ><i class="fa fa-plus-square"></i> NUEVO </button>
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
                      <th>
                        Nombres
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        IP
                      </th>
                      <th class="text-center">
                        Fecha y Hora
                      </th>
                    </thead>
                    <tbody id="datalist">
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Cantidad de accesos</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" id="mitbcantidad">
                    <thead class=" text-primary">
                      <th class="no-sort">
                        #
                      </th>
                      <th>
                        Nombres
                      </th>
                      <th>
                        Email
                      </th>
                      <th class="text-center">
                        Cant.
                      </th>
                    </thead>
                    <tbody id="listcantidad">
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">-</h4>
              </div>
              <div class="card-body">
                
              </div>
            </div>
          </div>

        </div>


      </div>

<?php $this->load->view('layouts/footer'); ?>


<script src="<?php echo base_url();?>assets/js/pages/historial-login.js"></script>

<script src="<?php echo base_url();?>assets/js/plugins/datatables/datatables.min.js"></script>