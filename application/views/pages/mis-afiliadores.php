<?php $this->load->view('layouts/header'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: #f9f9f9;">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="formbuscarregistro">
                                <div class="input-group no-border my-1">
                                    <select name="querydata" id="querydata" class="form-control">
                                        <option value="">Ver su alamcén de...</option>
                                        <?php
                                            foreach ($misafiliadores as $afiliador) {
                                                echo '<option value="'.$afiliador->idusuario.'">'.$afiliador->nombreapellido.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <a href="<?= base_url('mialmacen') ?>" class="btn btn-primary btn-md my-1" data-toggle="tooltip" data-placement="left" title="Mi Almacen" style="float: right;" >Ir a Mi Almacen</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="mitblista">
                            <thead class=" text-primary">
                                <th class="no-sort" width="50px">ID</th>
                                <th class="">ITEM</th>
                                <th class="text-center" width="70px">STOCK</th>
                            </thead>
                            <tbody id="datalist">
                                <tr>
                                    <td colspan="3" class="text-center">Seleccione un afiliador para ver su almacén</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


      </div>

<?php $this->load->view('layouts/footer'); ?>

<script src="<?php echo base_url();?>assets/js/pages/misafiliadores.js"></script>

