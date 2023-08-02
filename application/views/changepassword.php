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

  <style>

    .confirmacion{background:#C6FFD5;border:1px solid green;font-size: 13px;height: 20px;border-radius: 0px 5px 0px 0px;}
    .negacion{background:#ffcccc;border:1px solid red;font-size: 13px;height: 20px;border-radius: 0px 5px 0px 0px;}

  </style>

</head>

<body class="bg-danger">
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-blue py-7 py-lg-6">
      <div class="container">
        <div class="header-body text-center mb-6">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Actualizar Contraseña</h1>
              <p class="text-lead text-light">Ingrese una contraseña segura.</p>
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
              <div class="text-muted text-center mt-2 mb-3"><h3 id="titcard">Ingrese su nueva contraseña</h3></div>
            </div>
            <div class="card-body px-lg-5 py-lg-5" id="contntcard">
              <form role="form" id="rnpform">

                <input type="hidden" name="tokenkey" id="tokenkey" value="<?= $_GET['token'] ?>">

                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="password1" id="password1" placeholder="Nueva Contraseña" type="password">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="password2" id="password2" placeholder="Repetir Contraseña" type="password">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block my-4"><span id="btntext">Actualizar</span></button>
                </div>
              </form>
              <div id="responsediv" class="alert text-center" style="margin-top:20px; display:none;">
                <button type="button" class="close" id="clearmsg"><span aria-hidden="true">&times;</span></button>
                <span id="message"></span>
              </div> 
            </div>
          </div>
          <div class="row mt-3">
            
          </div>
        </div>
      </div>
    </div>
    <footer class="py-5">
      <div class="container">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-12">
            <div class="copyright text-center text-xl-center text-center" style="color:white;">
              © <script>document.write(new Date().getFullYear())</script> INSUQUIMICA S.A.C.
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

      $(':input[type="submit"]').prop('disabled', true);

      //variables
      var pass1 = $('[name=password1]');
      var pass2 = $('[name=password2]');
      var confirmacion = "Las contraseñas si coinciden";
      var longitud = "La contraseña debe estar formada entre 6-10 carácteres (ambos inclusive)";
      var negacion = "No coinciden las contraseñas";
      var vacio = "La contraseña no puede estar vacía";
      //oculto por defecto el elemento span
      var span = $('<span class="msmpass"></span>').insertAfter(pass2);
      span.hide();
      //función que comprueba las dos contraseñas
      function coincidePassword(){
      var valor1 = pass1.val();
      var valor2 = pass2.val();
      //muestro el span
      span.show().removeClass();
      //condiciones dentro de la función
      if(valor1 != valor2){
      span.text(negacion).addClass('negacion');	
      }
      if(valor1.length==0 || valor1==""){
      span.text(vacio).addClass('negacion');	
      }
      if(valor1.length<6 || valor1.length>10){
      span.text(longitud).addClass('negacion');
      }
      if(valor1.length!=0 && valor1==valor2){

          span.text(confirmacion).removeClass("negacion").addClass('confirmacion');
          $(':input[type="submit"]').prop('disabled', false);

      }
      }
      //ejecuto la función al soltar la tecla
      pass2.keyup(function(){
      coincidePassword();
      });







		$('#btntext').html('Actualizar');
		
		$('#rnpform').submit(function(e){
			e.preventDefault();
			
			var tokenkey = $('#tokenkey').val();
      var pass = $('#password1').val();

      $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl+"RegistrarseController/updatePassword",
        data: {token: tokenkey, password: pass},
        success: function(respuesta){
          $('#titcard').text('Contraseña Actualizado.');
          $('#contntcard').html('<div class="text-center"><img src="'+baseUrl+'uploads/check-insuquim.gif" style="width: 80px;" ><p>Su contraseña fue actualizado correctamente.</p> <a href="/" class="btn btn-primary">Ingresar a mi cuenta</a></div>');
                
        },
	      error: function() {
          $('#titcard').text('Actualizar');
          alert("Error: Intente nuevamente.");
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