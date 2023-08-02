<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Zona Clientes - Insuquimica
  </title>
  <!-- Favicon -->
  <link href="<?php echo base_url();?>assets/img/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="<?php echo base_url();?>assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="<?php echo base_url();?>assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?php echo base_url();?>assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>

<body class="bg-danger">
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-blue py-7 py-lg-6">
      <div class="container">
        <div class="header-body text-center mb-6">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Recuperar contraseña</h1>
              <p class="text-lead text-light">Enviaremos un enlace de recuperación a su correo electrónico.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-danger" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent">
              <div class="text-muted text-center mt-2 mb-3"><h3 id="titcard">Ingrese su correo electrónico</h3></div>
            </div>
            <div class="card-body px-lg-5 py-lg-5" id="contntcard">
              <form role="form" id="rnpform">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" name="email" id="email" placeholder="Correo Electrónico" type="email">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block my-4"><span id="btntext">Solicitar</span></button>
                </div>
              </form>
              <div id="responsediv" class="alert text-center" style="margin-top:20px; display:none;">
                <button type="button" class="close" id="clearmsg"><span aria-hidden="true">&times;</span></button>
                <span id="message"></span>
              </div> 
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="/login" class="text-light"><small>Iniciar sesión</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="registrarse" class="text-light"><small>Registrarse</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="py-5">
      <div class="container">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-12">
            <div class="copyright text-center text-xl-center text-center" style="color:white;">
              © <script>document.write(new Date().getFullYear())</script> NISSAN TRIVIA 2022
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <!--   Core   -->
  <script> var baseUrl = "<?php echo base_url(); ?>";</script>
  <script src="<?php echo base_url();?>assets/js/core/jquery.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="<?php echo base_url();?>assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  
  <script>
    $(document).ready(function(){
		$('#btntext').html('Solicitar');
		
		$('#rnpform').submit(function(e){
			e.preventDefault();
			
			var email = $('#email').val();
	
			$.ajax({
            type: 'ajax',
            method: 'get',
            url: baseUrl+"RegistrarseController/verificarEmail",
            data: {email: email},
            beforeSend: function(){
                $('#btntext').html('Comprobando...');
            },
            success: function(respuesta){
                if(respuesta == 'true'){
                      $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: baseUrl+"RegistrarseController/requestNewPassword",
                        data: {email: email},
                        success: function(respuesta){
                            $('#titcard').text('Correo envíado correctamente.');
                            $('#contntcard').html('<div class="text-center"><img src="'+baseUrl+'uploads/check-insuquim.gif" style="width: 80px;" ><p>Revise su bandeja de entrada o en correos no deseados el link generado para actualizar su contraseña.</p></div>');
                            
                        }
                      });
                    
                }else{
                    
                    $('#btntext').html('Solicitar');
                    $('#message').text('El correo no se encuentra registrado.');
                    $('#responsediv').removeClass('alert-success').addClass('alert-danger').show();
                    
                    
                }
            }
            });
			
		});

		$(document).on('click', '#clearmsg', function(){
			$('#responsediv').hide();
		});

	});
  </script>

</body>

</html>