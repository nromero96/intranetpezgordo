<?php $this->load->view('layouts/header'); ?>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Lista de usuarios eliminados</h4>
                    </div>

                    <div class="col-md-6">
                  
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
          </div>
        </div>

      </div>
<?php $this->load->view('layouts/footer'); ?>


<script src="<?php echo base_url();?>assets/js/pages/usuarios-eliminados.js"></script>

<script src="<?php echo base_url();?>assets/js/plugins/datatables/datatables.min.js"></script>