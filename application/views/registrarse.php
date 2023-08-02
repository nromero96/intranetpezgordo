<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>
    TRIVIA 2022 - TOYOTA GR
  </title>
  <!-- Favicon -->
  <link href="<?php echo base_url();?>assets/img/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="<?php echo base_url();?>assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link href="<?php echo base_url();?>assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

  <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
  <style>
    body{
      background-size: cover;
      background-position: bottom;
    }
    .msg-error {
      color: red;
    }

    .acptc{
      cursor:pointer;
      font-size: 18px;
      font-style: italic;
    }

    .acptc input{
      cursor:pointer;
      width: 18px;
    height: 18px;
    }

    .titbb{
      width: 100%;
    }

    .txtdest1{
      font-size: 32px;
    font-style: italic;
    }

    .btn-jugar {
    border-radius: 11px;
    font-size: 1.7rem;
    font-weight: bold;
    border: none;
    box-shadow: 0px 0px 20px 0px rgb(0 0 0 / 15%);
    color: #ffffff;
    cursor: pointer;
    transition: 0.5s;
    padding: 6px 40px 5px 40px;
    font-style: italic;
    width: 220px;
    background: #1c1c1b;
}


#formdatos .input-group-alternative .form-control, #formdatos .input-group-alternative .input-group-text {
    color: #e30613;
    font-style: italic;
    font-size: 19px;
}

    @media (max-width: 600px) {
      .txtdest1 {
      font-size: 23px;
      line-height: 26px;
      }
    }

  </style>

<meta name="theme-color" content="#c20d19">
</head>

<body style="background-image:url(<?php echo base_url();?>assets/img/bg-1.svg)">

  <div class="main-content">

    <!-- Page content -->
    <form id="formdatos" action="<?php echo base_url();?>RegistrarseController/addRegister" method='POST'>
      <div class="container-fluid mt-5 pb-5">
        <div class="row">
          <div class="col-lg-12 col-md-12">

              <div class="row">
                <div class="col-lg-3 col-md-3 text-center"></div>
                <div class="col-lg-6 col-md-6 text-center">

                  <img src="<?php echo base_url();?>assets/img/tit-bb.svg" class="titbb">
                  <p class="text-white mt-3 txtdest1">Completa tus datos y empieza a jugar.</p>

                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <input class="form-control text-center" name="nombresyapellidos" placeholder="Nombres y apellidos" type="text" autocomplete="fdgdhre" onkeydown="upperCaseF(this)" required>
                    </div>
                  </div>

                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <input class="form-control text-center" name="correo" placeholder="Correo electrónico" type="email" autocomplete="fdgdhre" onkeydown="LowerCaseF(this)" required>
                    </div>
                  </div>

                  <div class="form-group mb-3">
                    <div class="form-check">
                      <label class="form-check-label text-white acptc">
                        <input type="checkbox" name="autorizacion" id="autorizacion" class="form-check-input" value="SI" required>&nbsp;Autoriza que le enviemos información
                      </label>
                    </div>
                  </div>

                  <div class="form-group mb-3">
                    <button type="submit" id="submbt" class="btn-jugar mt-4">JUGAR</button>
                    <div id="submloadi" class="d-none">
                      <svg version="1.1" id="L3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                        <circle fill="none" stroke="#fff" stroke-width="4" cx="50" cy="50" r="44" style="opacity:0.5;"/>
                          <circle fill="#fff" stroke="#e74c3c" stroke-width="3" cx="8" cy="54" r="6" >
                            <animateTransform
                              attributeName="transform"
                              dur="2s"
                              type="rotate"
                              from="0 50 48"
                              to="360 50 52"
                              repeatCount="indefinite" />
                            
                          </circle>
                      </svg>
                    </div>
                  </div>



                </div>
                <div class="col-lg-3 col-md-3 text-center"></div>
              </div>

              <div class="form-group mb-3 mt-5 text-left">
                <img src="<?php echo base_url();?>assets/img/logo-1-2.svg">
              </div>

          </div>

        </div>
      </div>
    </fom>
    <!-- ///End content -->

  </div>


  <!--   Core   -->
  <script> var baseUrl = "<?php echo base_url(); ?>";</script>
  <script src="<?php echo base_url();?>assets/js/core/jquery.min.js"></script>
  <!--   Optional JS   -->


  <script>

  //   $(document).ready(function(){

  //     $('#formdatos').submit(function(e){
  //       e.preventDefault();

  //       $('#submbt').addClass("d-none");
  //       $('#submloadi').removeClass("d-none");
      
  //         var user = $('#formdatos').serialize();

  //           $.ajax({
  //             type: 'POST',
  //             url: baseUrl + 'RegistrarseController/addRegister',
  //             dataType: 'json',
  //             data: user,
  //             success:function(response){
  //               if(response.error){
  //                   $('#submbt').removeClass("d-none");
  //                   $('#submloadi').addClass("d-none");
  //                   alert("Error 412: No se pudo realizar el envío, por favor vuelva a registrarse.");
  //               }else{
  //                 $('#formdatos')[0].reset();
  //                 parent.location = baseUrl+'questions/'+response; 
  //                 console.log('Registrado');
  //               }
  //             }
  //           });
          
  //     });
  // });
  


  function upperCaseF(a){ setTimeout(function(){ a.value = a.value.toUpperCase(); }, 1); }
  
  function LowerCaseF(a){ setTimeout(function(){ a.value = a.value.toLowerCase(); }, 1); }

  


  </script>

</body>

</html>