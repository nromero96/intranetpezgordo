<!-- Código HTML y CSS -->
<?php $this->load->view('layouts/header'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Descargar Reportes</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                <h5 class="mt-0 mb-1">Reporte consumos</h5>
                <form method="post" action="<?= base_url('ConsumosController/exportar_datos') ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_inicio">Desde:</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin">Hasta:</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Exportar</button>
                        </div>
                    </div>       
                </form>

                <hr>
                <h5 class="mt-0 mb-1">Reporte operaciones</h5>
                <form method="post" action="<?= base_url('ReportesController/exportar_operaciones_excel') ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_inicio_operacion">Desde:</label>
                            <input type="date" id="fecha_inicio_operacion" name="fecha_inicio_operacion" class="form-control" required>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin_operacion">Hasta:</label>
                            <input type="date" id="fecha_fin_operacion" name="fecha_fin_operacion" class="form-control" required>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Exportar</button>
                        </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
