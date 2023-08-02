$(document).ready(function() {
	showAllRegistro();

	$('#addanew').click(function() {
		$('#modalregistro').modal({backdrop: 'static',});
		$('#formregistro').attr('action', baseUrl + 'ItemController/addRegistro');
		$('#btnsave').text('Guardar');
	});

	$('#datalist').on('click', '.btnedit', function(){
		var idr = $(this).attr('data');
		$('#modalregistro').modal({backdrop: 'static'});
		$('#formregistro').attr('action', baseUrl + 'ItemController/updateRegistro');
        $('#btnsave').text('Actualizar');
		$.ajax({
			type: 'ajax',
			method: 'get',
			url: baseUrl + "ItemController/getRegistroEdit",
			data: {idr: idr},
			async: false,
			dataType: 'json',
			success: function(data){
				$('input[name=idregist]').val(data.id);
				$('input[name=nombre]').val(data.nombre);
                $('input[name=id_campaign]').val(data.id_campaign);
                $('select[name=id_categoria]').val(data.id_categoria);
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


//change campaign select option 
$('#campaign').change(function(){
    var campaign = $(this).val();
    showAllRegistro(campaign);
  });


function showAllRegistro(campaign){

    var url = baseUrl + "ItemController/showAllRegistro";

    if (campaign !== "" && typeof campaign !== "undefined") {
        url += "?campaign=" + campaign;
    }

    $.ajax({
        type: 'ajax',
        method: 'get',
        url: url,
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;

            for(i=0, n=1; i<data.length; i++, n++){

                if(data[i].estado == 'Activo'){
                    var estado = '<span class="badge bg-success">Activo</span>';
                }else if(data[i].estado == 'Inactivo'){
                    var estado = '<span class="badge bg-danger">Inactivo</span>';
                }

                if(data[i].campaign != null){
                    var campaign = data[i].campaign;
                }else{
                    var campaign = 'N/A';
                }

                html +='<tr>'+
						'<td>'+data[i].id+'</td>'+
						'<td class="">'+data[i].nombre+'</td>'+
                        '<td class="">'+ campaign +'</td>'+
                        '<td class="">'+data[i].categoria+'</td>'+
                        '<td class="">'+estado+'</td>'+
						'<td><a href="javascript:;" class="btn btn-primary btn-sm btnedit" data-toggle="tooltip" data-placement="top" title="Editar" data="'+data[i].id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>'+
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
              url: url + 'ItemController/buscarRegistro',
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
                        if(response[i].estado == 'Activo'){
                            var estado = '<span class="badge bg-success">Activo</span>';
                        }else if(response[i].estado == 'Inactivo'){
                            var estado = '<span class="badge bg-danger">Inactivo</span>';
                        }
                        html +='<tr>'+
                            '<td>'+response[i].id+'</td>'+
                            '<td class="">'+response[i].nombre+'</td>'+
                            '<td class="">'+response[i].campaign+'</td>'+
                            '<td class="">'+response[i].categoria+'</td>'+
                            '<td class="">'+estado+'</td>'+
                            '<td><a href="javascript:;" class="btn btn-primary btn-sm btnedit" data-toggle="tooltip" data-placement="top" title="Editar" data="'+response[i].id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+
                            '</tr>';
                    }
                    $('#datalist').html(html);
                }
              }
            });
          };
          setTimeout(login, 500);
      });