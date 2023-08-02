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
  <link href="<?php echo base_url();?>assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link href="<?php echo base_url();?>assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

  <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->

  <meta name="theme-color" content="#c3002f">

  <style>
    .msg-error {
      color: red;
    }

    body{
      background-size: cover;
      background-position: bottom;
    }

    .questionswiz .question {
    font-size: 1.8rem;
    font-style: italic;
}

.questionswiz .number span {
  border-radius:0px;
    background: #e30613;
    width: 78px;
    height: 84px;
    color: #ffffff;
    box-shadow: 0px 0px 40px rgb(0 0 0 / 11%);
    clip-path: polygon(10% 0, 100% 0%, 90% 100%, 0% 100%);
    font-style: italic;
}

.answers label .text {
    font-size: 1.6rem;
    font-style: italic;
}

  </style>


</head>


<body style="background-image:url(<?php echo base_url();?>assets/img/bg-2.svg)">
  <div class="main-content">

    <!-- Page content -->

    <div class="container mt-2 pb-2">
      <div class="row">
        <div class="col-lg-12 col-md-12  pt-3">
            <div class="questionswiz steps_wizard">

                <form id="preguntasform" action="<?php echo base_url();?>QuestionsController/validarespuestas" method='POST'>

                    <input type="hidden" name="idregtrivia" value="<?= $detailinsc->id ?>">

                    <?php 
                        $num = 1;
                        foreach($preguntas as $pregunta){
                        ?>

                        <div class="tab">
                            <h1 class="number text-center mb-3"><span><?= $num ?></span></h1>
                            <h2 class="question text-white text-center"><?= $pregunta->pregunta ?></h2>

                            <div class="answers mt-5 mb-2" id="respscheck<?= $num ?>">

                                <?php 
                                    $pregnum = 1;
                                    foreach($respuestas as $respuesta){
                                        
                                      if($respuesta->correcto=='si'){
                                        $estadoresp = 'si';
                                      } else {
                                        $estadoresp = '';
                                      }


                                        if($respuesta->idpregunta == $pregunta->id){
                                        ?>

                                        <label>
                                            <input type="radio" value="<?= $respuesta->id ?>" name="pregunta<?= $num ?>" class="<?= $estadoresp ?>" required />
                                            <span class="silbopts"><?php if($pregnum=='1'){ echo "A"; }else if($pregnum=='2'){ echo "B"; }else if( $pregnum=='3'){ echo "C"; }else{} ?></span><span class="text text-white"><?= $respuesta->respuesta ?></span>
                                        </label>
                                        <br/>

                                        <?php 
                                        $pregnum ++;
                                        
                                    }
                                } 
                            ?>

                            </div>
                        
                        
                            <div id="nextprevious" class="text-center">
                              <div class="submbt ">
                                  <button type="button" id="prevBtn" onclick="nextPrev(-1)">ANTERIOR</button>
                                  <?php if($num=='5'){ ?>
                                      <button type="submit" id="nextBtn" onclick="verificarenvio();">ENVIAR</button>
                                  <?php }else{ ?>
                                      <button type="button" id="nextBtn" onclick="nextPrev(1)">SIGUIENTE</button>
                                  <?php } ?>
                              </div>

                              <div class="submloadi d-none">
                                <svg version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                  viewBox="0 0 50 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                  <circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
                                    <animate
                                      attributeName="opacity"
                                      dur="1s"
                                      values="0;1;0"
                                      repeatCount="indefinite"
                                      begin="0.1"/>    
                                  </circle>
                                  <circle fill="#fff" stroke="none" cx="26" cy="50" r="6">
                                    <animate
                                      attributeName="opacity"
                                      dur="1s"
                                      values="0;1;0"
                                      repeatCount="indefinite" 
                                      begin="0.2"/>       
                                  </circle>
                                  <circle fill="#fff" stroke="none" cx="46" cy="50" r="6">
                                    <animate
                                      attributeName="opacity"
                                      dur="1s"
                                      values="0;1;0"
                                      repeatCount="indefinite" 
                                      begin="0.3"/>     
                                  </circle>
                                </svg>
                              </div>

                            </div>
                        </div>
                        
                        <?php
                        $num ++;
                        }
                    ?>
                
                </form>
  
            </div>
        </div>
      </div>
    </div>

    <div class="container-fluid pb-2 pt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="<?php echo base_url();?>assets/img/logo-1-2.svg" alt="LOGO" class="mb-5" >
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

      $(document).bind("contextmenu",function(e){
        return false;
      });


      function verificarenvio(){
        
        //$('.submloadi').removeClass("d-none");
        
        var resp1 = $("input[name='pregunta1']:checked").val();
        var resp2 = $("input[name='pregunta2']:checked").val();
        var resp3 = $("input[name='pregunta3']:checked").val();
        var resp4 = $("input[name='pregunta4']:checked").val();
        var resp5 = $("input[name='pregunta5']:checked").val();

        if(resp1 == ''){
          alert('Porfavor responda la pregunta 1');
        }

        if(resp2 == ''){
          alert('Porfavor responda la pregunta 2');
        }
        if(resp3 == ''){
          alert('Porfavor responda la pregunta 3');
        }
        if(resp4 == ''){
          alert('Porfavor responda la pregunta 4');
        }
        if(resp5 == ''){
          alert('Porfavor responda la pregunta 5');
        }
        
        
      };

      
  });


function disableClick(e) {
    e.target.checked = false; // clear current radio button
    e.preventDefault();
    return false;
}

$('input[type=radio][name=pregunta1]').change(function() {
  const listresp1 = document.querySelector('#respscheck1')  
  listresp1.addEventListener('click', (event) => {  
    event.preventDefault();  
  });
});

$('input[type=radio][name=pregunta2]').change(function() {
  const listresp2 = document.querySelector('#respscheck2')  
  listresp2.addEventListener('click', (event) => {  
    event.preventDefault();  
  });
});

$('input[type=radio][name=pregunta3]').change(function() {
  const listresp3 = document.querySelector('#respscheck3')  
  listresp3.addEventListener('click', (event) => {  
    event.preventDefault();  
  });
});

$('input[type=radio][name=pregunta4]').change(function() {
  const listresp4 = document.querySelector('#respscheck4')  
  listresp4.addEventListener('click', (event) => {  
    event.preventDefault();  
  });
});

$('input[type=radio][name=pregunta5]').change(function() {
  const listresp5 = document.querySelector('#respscheck5')  
  listresp5.addEventListener('click', (event) => {  
    event.preventDefault();  
  });
});


  var currentTab = 0;
  document.addEventListener("DOMContentLoaded", function (event) {
    showTab(currentTab);
  });
  function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      document.getElementById("nextBtn").innerHTML = "ENVIAR";
    } else {
      document.getElementById("nextBtn").innerHTML = "SIGUIENTE";
    }
    
  }

  function nextPrev(n) {
    var x = document.getElementsByClassName("tab");
    // if (n == 1 && !validateForm()) return false;
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
      // document.getElementById("regForm").submit();
      // return false;
      //alert("sdf");
      document.getElementById("nextprevious").style.display = "none";
      document.getElementById("register").style.display = "none";

    }
    showTab(currentTab);

  }





  </script>

</body>

</html>