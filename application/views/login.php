<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Intranet - El Pez Gordo
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


  <style>
    body{
      font-family: sans-serif;
    }
    .msg-error {
      color: red;
    }
  </style>

  

</head>

<body class="bg-gradient-red">
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-red py-7 py-lg-6">
      <div class="container">
        <div class="header-body text-center mb-6">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">PANEL DE CONTROL</h1>
              <!-- <p class="text-lead text-light">Ingrese con sus credenciales</p> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent">
              <div class="text-muted text-center mt-2 mb-3"><h3>Iniciar sesión</h3></div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" id="loginform">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" name="email" placeholder="Email" type="email">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="password" placeholder="Contraseña" type="password">
                  </div>
                </div>

                <div class="form-group">
                  <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdkliMaAAAAABCNSCRfR8Ymvw56imOSWxO798GS" data-callback="vcc"></div>
                  <span class="msg-error"></span>
                </div>

                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Recuérdame</span>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" id="sbt" class="btn btn-primary my-4"><span id="btntext">Iniciar sesión</span></button>
                </div>
              </form>
              <div id="responsediv" class="alert text-center" style="margin-top:20px; display:none;">
                <button type="button" class="close" id="clearmsg"><span aria-hidden="true">&times;</span></button>
                <span id="message"></span>
              </div> 
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12 text-center">
              <a href="<?= base_url(); ?>new-password" class="text-light"><small>¿Olvidó su contraseña?</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <!--   Core   -->
  <script> var baseUrl = "<?php echo base_url(); ?>";</script>
  <script src="<?php echo base_url();?>assets/js/core/jquery.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="<?php echo base_url();?>assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  
  <script>
    $(document).ready(function(){

      $('#btntext').html('Iniciar sesión');

      $('#loginform').submit(function(e){
        e.preventDefault();
      
          $('#btntext').html('Comprobando...');
          var url = baseUrl;
          var user = $('#loginform').serialize();

          var login = function(){
            $.ajax({
              type: 'POST',
              url: url + 'AuthController/ingresar',
              dataType: 'json',
              data: user,
              success:function(response){
                    $('#message').html(response.message);
                    $('#btntext').html('Iniciar sesión');
                    if(response.error){
                    $('#responsediv').removeClass('alert-success').addClass('alert-danger').show();
                    }else{
                    $('#responsediv').removeClass('alert-danger').addClass('alert-success').show();
                    $('#loginform')[0].reset();
                    location.reload();
                    }
                },
                error : function(){
                    alert("Error: Intentelo en uno minutos.");
                    $('#btntext').html('Iniciar sesión');
                }
            });
          };
          
          setTimeout(login, 500);

      });

		  $(document).on('click', '#clearmsg', function(){
			  $('#responsediv').hide();
		  });

    });
    
  </script>

</body>

</html>