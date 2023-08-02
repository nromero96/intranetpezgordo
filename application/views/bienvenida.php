<!DOCTYPE html>

<html lang="es">



<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>
    Asistencia - El Pez Gordo
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
  <meta name="theme-color" content="#c3002f">

  <style>
    .colimgbg{
      background: #000;
      padding: 0px;
      padding-top: 35em;
      padding-bottom: 8em;
      clip-path: polygon(19% 0, 100% 0, 100% 100%, 0% 100%);
      background-size: cover;
    background-repeat: no-repeat;
    }
    .tittriv{
      background:#fff;
      font-size: 4em;
      color:#222221;
      text-align:center;
    }

    .logop{
      width: 150px;
    }

    .imgtxttriv{
      max-width: 300px;
    }


    @media (max-width: 600px) {
      .colimgbg{
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
      }

      .logop{
        width: 130px;
      }

      .imgtxttriv{
      max-width: 70%;
    }

    }



  </style>

</head>


<body>
  <div class="container-fluid">

    <div class="row" style="background: #e30613;height: 100vh;">
        <!-- Page content -->
        <div class="col-lg-12 col-md-12  pt-5 pb-5 text-center align-self-center">
          <img src="<?php echo base_url();?>assets/img/asistencia-icono-web-2323.svg" alt="LOGO" class="mb-3 mt-5 logop">
          <br>
          <button class="btn-jugar mb-2 mt-5" onclick="window.location.href='<?= base_url(); ?>/login'">
              INGRESAR
          </button>


        </div>
    <div>

  </div>

  <!--   Core   -->
  <script src="<?php echo base_url();?>assets/js/core/jquery.min.js"></script>
  <!--   Optional JS   -->


</body>

</html>