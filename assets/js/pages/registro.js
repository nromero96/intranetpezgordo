$(document).ready(function() {

	showAllRegistro();


	$(".cbxestado").click(function() {

		var valchbx = $(this).val();
		var idu = $(this).attr('data');


		if( $(this).is(':checked') ){
			$(this).val('1');
		} else {
			$(this).val('99');
		}



		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,

			url: baseUrl + "UsuariosController/updateEstadoUsuario",

			data:{idu:idu, valchbx:valchbx},

			success: function(respuesta){

				

			},

			error: function(){

				alert("Error al cambiar estado!. Intentelo nuevamente.");

			}

		});

		



	});



	

	/*Boton agregar nuevo archivo*/

	$('#addnumero').click(function() {

		$('#modalregistro').modal({backdrop: 'static',});

		$('#formregistro').attr('action', baseUrl + 'RegistroController/addNumero');

		$('#btnsave').text('Guardar');

	});

	

	$('#datalist').on('click', '.btnedit', function(){

		var idr = $(this).attr('data');

		

		$('#modalregistro').modal({backdrop: 'static'});

		$('#formregistro').attr('action', baseUrl + 'RegistroController/updateNumero');

		

		$.ajax({

			type: 'ajax',

			method: 'get',

			url: baseUrl + "RegistroController/getRegistroEdit",

			data: {idr: idr},

			async: false,

			dataType: 'json',

			success: function(data){

				$('input[name=idnumero]').val(data.id);

				$('input[name=numero]').val(data.numero);

				$('select[name=estado]').val(data.estado);

			},

			error: function(){

				alert("Ups Algo salió mal. Intentelo nuevamente");

			}

		});

		

	});

	

	

	$('#formregistro').submit(function(e){

		e.preventDefault();

		var url = $('#formregistro').attr('action');

		var data = $('#formregistro').serialize();

		$.ajax({

			type:'ajax',

			method: 'post',

			url: url,

			data: data,

			async: false,

			dataType:'json',

			success: function(respuesta){

				$('#modalregistro').modal('hide');

					$('#formregistro')[0].reset();

					showAllRegistro();

			},

			error: function(){

				alert("¡Ups! Algo salió mal!. Intentelo nuevamente");

			}

		});

	});

	

	

	$("#btnreset").click(function(){

		$("#formregistro")[0].reset();

	});





	

} );







function showAllRegistro(){

    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "RegistroController/showAllRegistro",
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;


            for(i=0, n=1; i<data.length; i++, n++){

                html +='<tr>'+
						'<td>'+data[i].id+'</td>'+
						'<td class="">'+data[i].nombresyapellidos+'</td>'+
						'<td class="">'+data[i].correo+'</td>'+
						'<td class="">'+data[i].estadojuego+'</td>'+
						'<td class="">'+data[i].fechahoraregistro+'</td>'+
						'</tr>';
            }

            $('#datalist').html(html);

            

        },

        error: function(){

            alert("Erro al listar.");

        }

    });

}





   $('#formbuscarregistro').submit(function(e){

        e.preventDefault();

      

          $('#btntext').html('Buscando...');

          var url = baseUrl;

          var user = $('#formbuscarregistro').serialize();



          var login = function(){

            $.ajax({

              type: 'POST',

              url: url + 'RegistroController/buscarregistro',

              dataType: 'json',

              data: user,

              success:function(response){

                $('#message').html(response.message);

                $('#btntext').html('CONSULTAR');

                if(response.error){

                  alert('El teléfono que busca nose encuetra registrado.');

                }else{


					html ='<tr>'+
						'<td>'+response.id+'</td>'+
						'<td class="">'+response.placa+'</td>'+
						'<td class="">'+response.modelo+'</td>'+
						'<td class="">'+response.nombresyapellidos+'</td>'+
						'<td class="">'+response.correo+'</td>'+
						'<td class="">'+response.telefono+'</td>'+
						'<td class="">'+response.ciudad+'</td>'+
						'<td class="">'+response.distrito+'</td>'+
						'<td class="">'+response.estadojuego+'</td>'+
						'</tr>';

					$('#datalist').html(html);

                    

                }

              }

            });

          };

          setTimeout(login, 500);



      });



	  $('#import_form').on('submit', function(event){
		event.preventDefault();

		$('#btnimporttext').html('Espere...');
		$('#progressimport').show();

		var formimport = $('#import_form')[0];

		var importarinfo = function(){

			$.ajax({
				url: baseUrl + 'ExcelImportController/import',
				method:"POST",
				data:new FormData(formimport),
				contentType:false,
				cache:false,
				timeout: 800000,
				processData:false,
				success:function(respuesta){
					$('#btnimporttext').html('Importar');
					$('#file').val('');
					if(respuesta == 'true'){
						$('#progressimport').hide();
						showAllRegistro();
						alert('Los datos se importarón con éxito');
					}else{
						alert('ERROR EN DB: Intente nuevamente');
						$('#progressimport').hide();
					}
				},
				error: function() { 
					$('#btnimporttext').html('Importar');
					$('#progressimport').hide();


        console.log(error);

				}
			})


		};

		setTimeout(importarinfo, 500);

	});







