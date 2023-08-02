<?php $this->load->view('layouts/header'); ?>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                <div class="col-md-6">
                <h4 class="card-title">Lista de 100 últimos consumos</h4>
                </div>

                <div class="col-md-6">
                  <a href="<?= base_url('importar-consumos'); ?>" class="btn btn-alert btn-md" data-toggle="tooltip" data-placement="top" title="Importar consumo" style="float: right;"><i class="fa fa-file" aria-hidden="true"></i></a>
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
                        Supervisor
                      </th>
                      <th>
                        Categoria
                      </th>
                      <th>
                        Campana
                      </th>
                      <th>
                        Afiliador
                      </th>
                      <th>
                        QR
                      </th>
                      <th>
                        F_Referencia
                      </th>
                      
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

      </div>
<?php $this->load->view('layouts/footer'); ?>


<script src="<?php echo base_url();?>assets/js/pages/consumos.js"></script>

<script src="<?php echo base_url();?>assets/js/plugins/datatables/datatables.min.js"></script>