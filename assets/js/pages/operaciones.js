$(document).ready(function() {
	showAllRegistro();

	$('#addanew').click(function() {
		$('#modalregistro').modal({backdrop: 'static',});
		$('#formregistro').attr('action', baseUrl + 'OperacionController/addRegistro');
		$('#btnsave').text('Guardar');
	});

	$('#datalist').on('click', '.btnedit', function(){
		var idr = $(this).attr('data');
		$('#modalregistro').modal({backdrop: 'static'});
		$('#formregistro').attr('action', baseUrl + 'OperacionController/updateRegistro');
        $('#btnsave').text('Actualizar');
		$.ajax({
			type: 'ajax',
			method: 'get',
			url: baseUrl + "OperacionController/getRegistroEdit",
			data: {idr: idr},
			async: false,
			dataType: 'json',
			success: function(data){
				$('input[name=idregist]').val(data.id);
				$('input[name=nombre]').val(data.nombre);
                $('select[name="id_ciudad"]').val(data.id_ciudad);
			},

			error: function(){
				alert("Ups Algo salió mal. Intentelo nuevamente");
			}

		});
	});


	$('#formregistro').submit(function(e){
		e.preventDefault();

        var cantidad = $('#cantidad').val();

        if(cantidad == 0){
            alert("La cantidad no puede ser 0");
            return false;
        }

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
                    var campaign = $('#campaign').val();
					showAllRegistro(campaign);
                    listalmacenitemsforselect(campaign);
                    $('#formregistro')[0].reset();
			},

			error: function(){
				alert("¡Ups! Algo salió mal!. Intentelo nuevamente");
			}
		});
	});

	$("#btnreset").click(function(){
		$("#formregistro")[0].reset();
	});

    //clic radio button tipo 
    $('input[type=radio][name=tipo]').change(function() {
        if(this.value == 'Salida') {
            $('#icndeskguia').removeClass('nc-minimal-left entradadesktop');
            $('#icndeskguia').addClass('nc-minimal-right salidadesktop');

            $('#icnmovlguia').removeClass('nc-minimal-up entradamovil');
            $('#icnmovlguia').addClass('nc-minimal-down salidamovil');

        } else if (this.value == 'Retorno') {
            $('#icndeskguia').removeClass('nc-minimal-right salidadesktop');
            $('#icndeskguia').addClass('nc-minimal-left entradadesktop');

            $('#icnmovlguia').removeClass('nc-minimal-down salidamovil');
            $('#icnmovlguia').addClass('nc-minimal-up entradamovil');
        }
    });

});

//change campaign select option 
$('#campaign').change(function(){
    var campaign = $(this).val();
    showAllRegistro(campaign);
    listalmacenitemsforselect(campaign);
  });

function listalmacenitemsforselect(campaign){
    $('#id_almaceitem').html('');

    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + 'AlmacenController/listalmacenitemsforselect',
        data: {campaign: campaign},
        async: false,
        dataType: 'json',
        success: function(data){
          var html = '';
          var i;
          var n;
          for(i=0, n=1; i<data.length; i++, n++){
            html += '<option data-stock="'+data[i].stock+'" value="'+data[i].id+'">'+data[i].item+' - ('+data[i].stock+')</option>';
          }
          $('#id_almaceitem').html(html);
        },
        error: function(){
          alert('No se pudo obtener la lista de items.');
        }
    });
}


function showAllRegistro(campaign){

    var url = baseUrl + "OperacionController/showAllRegistro";

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

                if(data[i].tipo == 'Salida'){
                    var tipo = '<span class="badge bg-danger">'+data[i].tipo+'</span>';
                    var cantidad = '<span class="text-danger">- '+data[i].cantidad+'</span>';
                }else{
                    var tipo = '<span class="badge bg-success">'+data[i].tipo+'</span>';
                    var cantidad = '<span class="">'+data[i].cantidad+'</span>';
                }

                html +='<tr>'+
						'<td>'+data[i].id+'</td>'+
                        '<td class="">'+data[i].administrador+'</td>'+
                        '<td class="">'+data[i].ciudad+'</td>'+
                        '<td class="">'+tipo+'</td>'+
                        '<td class="">'+data[i].supervisor+'</td>'+
                        '<td class="">'+data[i].item+'</td>'+
                        '<td class="text-center">'+cantidad+'</td>'+
						'<td class="">'+data[i].fechahora+'</td>'+
						'</tr>';
            }

            $('#datalist').html(html);
        },

        error: function(){
            alert("Erro al listar los registros");
        }
    });
}

    $('#id_almaceitem').on('change', function() {
        var stock = $('#id_almaceitem option:selected').data('stock');
        $('#cantidad').attr('max', stock);
        $('#cantidad').val('');
    });


    $('#cantidad').on('keyup', function() {
        var cantidad = parseInt($(this).val());
        var stock = $('#id_almaceitem option:selected').data('stock');
    
        if (cantidad < 1) {
            $(this).val(1);
        } else if (cantidad > stock) {
            $(this).val(stock);
            console.log('Cantidad ajustada al stock disponible');
        }
    });
    



    $('#formbuscarregistro').submit(function(e){
        e.preventDefault();
          $('#btntext').html('Buscando...');
          var url = baseUrl;
          var user = $('#formbuscarregistro').serialize();
          var login = function(){
            $.ajax({
              type: 'POST',
              url: url + 'OperacionController/buscarRegistro',
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

                        if(data[i].tipo == 'Salida'){
                            var tipo = '<span class="badge bg-danger">'+data[i].tipo+'</span>';
                            var cantidad = '<span class="text-danger">- '+data[i].cantidad+'</span>';
                        }else{
                            var tipo = '<span class="badge bg-success">'+data[i].tipo+'</span>';
                            var cantidad = '<span class="">'+data[i].cantidad+'</span>';
                        }

                        html +='<tr>'+
                                '<td>'+response[i].id+'</td>'+
                                '<td class="">'+response[i].supervisor+'</td>'+
                                '<td class="">'+response[i].ciudad+'</td>'+
                                '<td class="">'+tipo+'</td>'+
                                '<td class="">'+response[i].afiliador+'</td>'+
                                '<td class="">'+response[i].item+'</td>'+
                                '<td class="text-center">'+cantidad+'</td>'+
                                '<td class="">'+response[i].fechahora+'</td>'+
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
                url: baseUrl + "OperacionController/deleteRegistro",
                data:{idreg:idu},
                success: function(respuesta){
                    location.reload();
                },
                error: function(){
                    alert("Error al eliminar operación!. Intentelo nuvamente.");
                }
            });
        }else{
            return false;
        }
    });








