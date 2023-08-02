<!DOCTYPE html>

<html lang="es">



<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>
    TRIVIA 2022 - NISSAN
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

  <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
  <meta name="theme-color" content="#c3002f">


  <style>
    
    body{
      background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    height: 98vh;
    }

    .logop{
      max-width: 100%;
    }

    .txtganastes{
      color: #222221;
      background: white;
      font-size: 96px;
      margin-bottom: 90px;
      font-style: italic;
      clip-path: polygon(3% 0%, 100% 0%, 97% 100%, 0% 100%);
    }

    .btnirhm{
      border-radius: 11px;
    font-size: 2rem;
    font-weight: bold;
    border: none;
    box-shadow: 0px 0px 20px 0px rgb(0 0 0 / 15%);
    color: #c20d19 !important;
    cursor: pointer;
    transition: 0.5s;
    padding: 7px 40px 7px 40px;
    font-style: italic;
    background: white;
    }


    @media (max-width: 600px) {
      .logop{
      max-width: 75%;
      }

    }



  </style>



</head>


<body style="background-image:url(<?php echo base_url();?>assets/img/bg-ganaste.jpg)">



  <div class="main-content">

    <!-- Page content -->

    <div class="container mt-3 pb-5">
      <div class="row">

        <div class="col-lg-12 col-md-12  pt-4 pb-5 text-center align-self-center">
          <img src="<?php echo base_url();?>assets/img/logo-1-1.svg" alt="LOGO" class="mb-5 mt-5 logop">


          <h2 class="txtganastes">!GANASTE¡</h2>

          <a class="btnirhm" href="<?php echo base_url();?>">INICIO</a>

        </div>
      </div>
    </div>
  </div>

  <div class="js-container containerall"></div>

  <!--   Core   -->
  <script> var baseUrl = "<?php echo base_url(); ?>";</script>
  <script src="<?php echo base_url();?>assets/js/core/jquery.min.js"></script>
  <!--   Optional JS   -->

  <!--   Argon JS   -->
  <script src="<?php echo base_url();?>assets/js/argon-dashboard.min.js?v=1.1.0"></script>

  
  <script>

$(document).ready(function(){

const Confettiful = function(el) {
  this.el = el;
  this.containerEl = null;
  
  this.confettiFrequency = 3;
  this.confettiColors = ['#fce18a', '#ff726d', '#b48def', '#f4306d'];
  this.confettiAnimations = ['slow', 'medium', 'fast'];
  
  this._setupElements();
  this._renderConfetti();
};

Confettiful.prototype._setupElements = function() {
    const containerEl = document.createElement('div');
  const elPosition = this.el.style.position;
  
//   if (elPosition !== 'relative' || elPosition !== 'absolute') {
//     this.el.style.position = 'relative';
//   }
  
  containerEl.classList.add('confetti-container');
  
  this.el.appendChild(containerEl);
  
  this.containerEl = containerEl;
};

Confettiful.prototype._renderConfetti = function() {
  this.confettiInterval = setInterval(() => {
    const confettiEl = document.createElement('div');
    const confettiSize = (Math.floor(Math.random() * 3) + 7) + 'px';
    const confettiBackground = this.confettiColors[Math.floor(Math.random() * this.confettiColors.length)];
    const confettiLeft = (Math.floor(Math.random() * this.el.offsetWidth)) + 'px';
    const confettiAnimation = this.confettiAnimations[Math.floor(Math.random() * this.confettiAnimations.length)];
    
    confettiEl.classList.add('confetti', 'confetti--animation-' + confettiAnimation);
    confettiEl.style.left = confettiLeft;
    confettiEl.style.width = confettiSize;
    confettiEl.style.height = confettiSize;
    confettiEl.style.backgroundColor = confettiBackground;
    
    confettiEl.removeTimeout = setTimeout(function() {
      confettiEl.parentNode.removeChild(confettiEl);
    }, 3000);
    
    this.containerEl.appendChild(confettiEl);
  }, 25);
};

window.confettiful = new Confettiful(document.querySelector('.js-container'));

});

  </script>

</body>

</html>