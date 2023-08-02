<?php $this->load->view('layouts/header'); ?>

<?php 
  $idusuario = $this->session->userdata('idusuario');
  $nombreyapllido = $this->session->userdata('nombreapellido');
  $email = $this->session->userdata('email');
  $telefono = $this->session->userdata('telefono');
  $idrol = $this->session->userdata('idrol');

  if($idrol == '1'){
    $rol = 'Administrador';
  }else if($idrol == '2'){
    $rol = 'Supervisor';
  }else if($idrol == '3'){
    $rol = 'Afiliador';
  }else{
    $rol = 'Usuario';
  }
?>

    <div class="content">
        <div class="row">
          <div class="col-md-4">
            <div class="card card-user">
              <div class="image">
                <img src="<?= base_url(); ?>/assets/img/img-portada.jpg" alt="Insuquimica">
              </div>
              <div class="card-body">
                <div class="author">
                  <a href="#">
                    <img class="avatar border-gray" src="<?= base_url(); ?>/assets/img/img-perfil.png" alt="Mi perfil">
                    <h5 class="title"><?= $nombreyapllido ?></h5>
                  </a>
                  <p class="description">
                  <?= $rol ?>
                  </p>
                </div>
                <p class="description text-center">
                  <?= $email ?>
                  <br>
                  <?= $telefono ?>
                </p>
              </div>
              <div class="card-footer">
                <hr>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Editar Perfil</h5>
              </div>
              <div class="card-body">
                <form id="formperfil" action="<?php echo base_url();?>UsuariosController/updatePerfil">
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Nombre y Apellidos</label>
                        <input type="text" name="nombreyapellido" class="form-control" placeholder="Nombres y Apellidos" value="<?= $nombreyapllido ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Email (disabled)</label>
                        <input type="text" name="email" class="form-control" placeholder="Company" value="<?= $email ?>" disabled="">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="numero" class="form-control" placeholder="Teléfono / Celular" value="<?= $telefono ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Cambiar contraseña</label>
                        <div class="input-group" id="show_hide_password">
                          <input type="password" name="password" id="password" class="form-control" placeholder="ingrese su nueva contraseña">
                          <div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" class="btn btn-primary btn-round">Actualizar Perfil</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php $this->load->view('layouts/footer'); ?>

<script>

$("#show_hide_password a").on('click', function(event) {
	event.preventDefault();
	if($('#show_hide_password input').attr("type") == "text"){
		$('#show_hide_password input').attr('type', 'password');
		$('#show_hide_password i').addClass( "fa-eye-slash" );
		$('#show_hide_password i').removeClass( "fa-eye" );
	}else if($('#show_hide_password input').attr("type") == "password"){
		$('#show_hide_password input').attr('type', 'text');
		$('#show_hide_password i').removeClass( "fa-eye-slash" );
		$('#show_hide_password i').addClass( "fa-eye" );
	}
});

$('#formperfil').submit(function(e){
	e.preventDefault();
	var url = $('#formperfil').attr('action');
	var data = $('#formperfil').serialize();
	$.ajax({
		type:'ajax',
		method: 'post',
		url: url,
		data: data,
		async: false,
		dataType:'json',
		success: function(respuesta){
      window.location.href = baseUrl+"logout";
		},
		error: function(){
			alert("¡Ups! Algo salió mal!. Intentelo nuevamente");
		}
	});
});

</script>