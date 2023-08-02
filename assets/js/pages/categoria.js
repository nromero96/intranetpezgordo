$(document).ready(function() {
	showAllRegistro();

	$('#addanew').click(function() {
		$('#modalregistro').modal({backdrop: 'static',});
		$('#formregistro').attr('action', baseUrl + 'CategoriaController/addRegistro');
		$('#btnsave').text('Guardar');
	});

	$('#datalist').on('click', '.btnedit', function(){
		var idr = $(this).attr('data');
		$('#modalregistro').modal({backdrop: 'static'});
		$('#formregistro').attr('action', baseUrl + 'CategoriaController/updateRegistro');
        $('#btnsave').text('Actualizar');
		$.ajax({
			type: 'ajax',
			method: 'get',
			url: baseUrl + "CategoriaController/getRegistroEdit",
			data: {idr: idr},
			async: false,
			dataType: 'json',
			success: function(data){
				$('input[name=idregist]').val(data.id);
				$('input[name=nombre]').val(data.nombre);
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
        url: baseUrl + "CategoriaController/showAllRegistro",
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;

            for(i=0, n=1; i<data.length; i++, n++){
                html +='<tr>'+
						'<td>'+data[i].id+'</td>'+
						'<td class="">'+data[i].nombre+'</td>'+
						'<td><a href="javascript:;" class="btn btn-primary btn-sm btnedit" data-toggle="tooltip" data-placement="top" title="Editar" data="'+data[i].id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="javascript:;" class="btn btn-danger btn-sm btndelete" data-toggle="deleteconfirm" data="'+data[i].id+'"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>'+
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
              url: url + 'CategoriaController/buscarRegistro',
              dataType: 'json',
              data: user,
              success:function(response){
                $('#message').html(response.message);
                $('#btntext').html('CONSULTAR');

                if(response.error){
                  alert('No hay lo que está buscando.');
                }else{
                    var html = '';
                    var i;
                    var n;
                    for(i=0, n=1; i<response.length; i++, n++){
                        html +='<tr>'+
                            '<td>'+response[i].id+'</td>'+
                            '<td class="">'+response[i].nombre+'</td>'+
                            '<td><a href="javascript:;" class="btn btn-primary btn-sm btnedit" data-toggle="tooltip" data-placement="top" title="Editar" data="'+response[i].id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="javascript:;" class="btn btn-danger btn-sm btndelete" data-toggle="deleteconfirm" data="'+response[i].id+'"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>'+
                            '</tr>';
                    }
                    $('#datalist').html(html);
                }
              }
            });
          };
          setTimeout(login, 500);
      });
      

    $('#datalist').on('click', '.btndelete', function(){

        //validate confirm delete
        var confirmar = confirm("¿Está seguro de eliminar este registro?");
        if(confirmar == true){
            var idu = $(this).attr('data');
            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                url: baseUrl + "CategoriaController/deleteRegistro",
                data:{idreg:idu},
                success: function(respuesta){
                    location.reload();
                },
                error: function(){
                    alert("Error al eliminar el personal!. Intentelo nuvamente.");
                }
            });
        }else{
            return false;
        }
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







