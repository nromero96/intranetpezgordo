<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    <?= $page_title ?> - PezGordo
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url();?>assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
  
  <link href="<?php echo base_url();?>assets/js/plugins/datatables/datatables.min.css" rel="stylesheet" />

  <link href="<?php echo base_url();?>assets/css/toggle-switchy.css" rel="stylesheet" />
  

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url();?>assets/app/app.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="<?= base_url(); ?>" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="<?php echo base_url();?>/assets/img/favicon.png">
          </div>
        </a>
        <a href="<?= base_url(); ?>" class="simple-text logo-normal">
          <b>INTRANET</b>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <?php 
          $idroluser = $this->session->userdata('idrol'); 
        ?>
        <ul class="nav">
            <!--Menu Administrador-->
            <li <?php if ($this->uri->segment(1) == 'panel') {?> class="active" <?php }?>>
                <a href="<?php echo base_url();?>panel">
                    <i class="nc-icon nc-bank"></i>
                    <p>Panel</p>
                </a>
            </li>

            <?php if($idroluser=='1'){?>
            <li <?php if ($this->uri->segment(1) == 'usuarios') {?> class="active" <?php }?> >
                <a href="<?php echo base_url();?>usuarios">
                    <i class="nc-icon nc-single-02"></i>
                    <p>Usuarios</p>
                </a>
            </li>
            <?php } ?>

            <?php if($idroluser=='1'){?>
            <li <?php if ($this->uri->segment(1) == 'campaign' || $this->uri->segment(1) == 'campaign') {?> class="active" <?php }?> >
                <a href="<?php echo base_url();?>campaign">
                    <i class="nc-icon nc-spaceship"></i>
                    <p>Campañas</p>
                </a>
            </li>
            <?php } ?>

            <?php if($idroluser=='1'){?>
            <li <?php if ($this->uri->segment(1) == 'items') {?> class="active" <?php }?> >
                <a href="<?php echo base_url();?>items">
                    <i class="nc-icon nc-bag-16"></i>
                    <p>Items</p>
                </a>
            </li>
            <?php } ?>

            <?php if($idroluser=='1'){?>
            <li <?php if ($this->uri->segment(1) == 'almacen' || $this->uri->segment(1) == 'operaciones') {?> class="active" <?php }?> >
                <a href="<?php echo base_url();?>almacen">
                    <i class="nc-icon nc-box-2"></i>
                    <p>Almacén</p>
                </a>
            </li>

            <li <?php if ($this->uri->segment(1) == 'reportes' || $this->uri->segment(1) == 'reporte-usuarios') {?> class="active" <?php }?> >
                <a href="<?php echo base_url();?>reportes">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    <p>Reportes</p>
                </a>
            </li>

            <?php } ?>

            <?php if($idroluser=='2'){?> 
            <li <?php if ($this->uri->segment(1) == 'mialmacen' || $this->uri->segment(1) == 'mis-operaciones') {?> class="active" <?php }?> >
                <a href="<?php echo base_url();?>mialmacen">
                    <i class="nc-icon nc-box-2"></i>
                    <p>Mi almacén</p>
                </a>
            </li>

            <li <?php if ($this->uri->segment(1) == 'misafiliadores') {?> class="active" <?php }?> >
                <a href="<?php echo base_url();?>misafiliadores">
                    <i class="nc-icon nc-user-run"></i>
                    <p>Afiliadores</p>
                </a>
            </li>
            <?php } ?>

            <li <?php if ($this->uri->segment(1) == 'perfil') {?> class="active" <?php }?>>
                <a href="<?php echo base_url();?>perfil">
                    <i class="nc-icon nc-satisfied"></i>
                    <p>Perfil</p> 
                </a>
            </li>
            
            <?php if($idroluser=='1'){?>
            <li <?php if ($this->uri->segment(1) == 'ciudades' || $this->uri->segment(1) == 'almacenes' || $this->uri->segment(1) == 'categorias' || $this->uri->segment(1) == 'consumos') {?> class="active" <?php }?>>
              <a data-toggle="collapse" href="#tablesExamples" class="" aria-expanded="true">
                <i class="nc-icon nc-settings-gear-65"></i>
                <p>Ajustes<b class="caret"></b></p>
              </a>
              <div class="collapse in" id="tablesExamples" aria-expanded="true" style="">
                <ul class="nav">
                  <li>
                    <a href="<?php echo base_url();?>ciudades">
                      <span class="sidebar-mini">CD</span>
                      <span class="sidebar-normal">Ciudades</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>categorias">
                      <span class="sidebar-mini">CT</span>
                      <span class="sidebar-normal">Categorías</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>consumos">
                      <span class="sidebar-mini">CS</span>
                      <span class="sidebar-normal">Consumos</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php } ?>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>

            

            <a class="navbar-brand" href="#"><?= $page_title ?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="#" class="nav-link btn-magnify">
                  <?php
                    echo 'HOLA, '.$this->session->userdata('nombreapellido');
                  ?>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-magnify" href="panel">
                  <i class="nc-icon nc-layout-11"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Panel</span>
                  </p>
                </a>
              </li>
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Cofiguración</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="perfil">Editar Perfil</a>
                  <a class="dropdown-item" href="#">Ayuda</a>
                  <a class="dropdown-item" href="<?php echo base_url();?>logout">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->