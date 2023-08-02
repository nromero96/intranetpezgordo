$(document).ready(function() {
	showAllRegistro();

	$('#addanew').click(function() {
		$('#modalregistro').modal({backdrop: 'static',});
		$('#formregistro').attr('action', baseUrl + 'OperacionController/registrarMisOperaciones');
		$('#btnsave').text('Guardar');
	});

    $('#transfer').click(function() {
		$('#modalregistrotransferencia').modal({backdrop: 'static',});
		$('#formregistrotransferencia').attr('action', baseUrl + 'OperacionController/registrarMisOperacionesTransferencia');
		$('#btntransf').text('Transferir');
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

    $('#formregistrotransferencia').submit(function(e){
		e.preventDefault();
		var url = $('#formregistrotransferencia').attr('action');
		var data = $('#formregistrotransferencia').serialize();
		$.ajax({
			type:'ajax',
			method: 'post',
			url: url,
			data: data,
			async: false,
			dataType:'json',
			success: function(respuesta){
				$('#modalregistrotransferencia').modal('hide');
				$('#formregistrotransferencia')[0].reset();
				var campaign = $('#campaign').val();
                showAllRegistro(campaign);
			},

			error: function(){
				alert("¡Ups! Algo salió mal!. Intentelo nuevamente");
			}
		});
	});

    $("#btnresettransf").click(function(){
        $("#formregistrotransferencia")[0].reset();
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

    $('#id_afiliador_origen').change(function(){
        var id_afiliador = $(this).val();
        if(id_afiliador != ''){
            show_almaceitem_origen(id_afiliador);
        }else{
            $('#id_almaceitem_origen').html('<option value="">Escoger un afiliador...</option>');
            $('#cantidad_origen').val('');
        }
    });

    $('#id_almaceitem_origen').change(function(){
        var stock = $(this).find(':selected').data('stock');
        $('#cantidad_origen').val(stock);
        $('#cantidad_origen').attr('max', stock);
    });


});

//change campaign select option 
$('#campaign').change(function(){
    var campaign = $(this).val();
    showAllRegistro(campaign);
    listalmacenitemsforselect(campaign);
  });

function showAllRegistro(campaign){

    var url = baseUrl + "OperacionController/misOperaciones";

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
                }else if(data[i].tipo == 'Retorno'){
                    var tipo = '<span class="badge bg-success">'+data[i].tipo+'</span>';
                    var cantidad = '<span class="">'+data[i].cantidad+'</span>';
                }else if(data[i].tipo == 'Entrega'){
                    var tipo = '<span class="badge bg-info">'+data[i].tipo+'</span>';
                    var cantidad = '<span class="">'+data[i].cantidad+'</span>';
                }else{
                    var tipo = '<span class="badge bg-warning">'+data[i].tipo+'</span>';
                    var cantidad = '<span class="">'+data[i].cantidad+'</span>';
                }

                if(data[i].afiliador == null){
                    var afiliador = '<span class="text-danger">No Aplica</span>';
                }else{
                    var afiliador = data[i].afiliador;
                }

                html +='<tr>'+
						'<td>'+data[i].id+'</td>'+
                        '<td class="">'+data[i].supervisor+'</td>'+
                        '<td class="">'+data[i].ciudad+'</td>'+
                        '<td class="">'+tipo+'</td>'+
                        '<td class="">'+afiliador+'</td>'+
                        '<td class="">'+data[i].item+'</td>'+
                        '<td class="text-center">'+cantidad+'</td>'+
						'<td class="">'+data[i].fechahora+'</td>'+
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
              url: url + 'OperacionController/buscarmisOperaciones',
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

                        if(response[i].tipo == 'Salida'){
                            var tipo = '<span class="badge bg-danger">'+response[i].tipo+'</span>';
                            var cantidad = '<span class="text-danger">- '+response[i].cantidad+'</span>';
                        }else if(response[i].tipo == 'Retorno'){
                            var tipo = '<span class="badge bg-success">'+response[i].tipo+'</span>';
                            var cantidad = '<span class="">'+response[i].cantidad+'</span>';
                        }else if(response[i].tipo == 'Entrega'){
                            var tipo = '<span class="badge bg-info">'+response[i].tipo+'</span>';
                            var cantidad = '<span class="">'+response[i].cantidad+'</span>';
                        }else{
                            var tipo = '<span class="badge bg-warning">'+response[i].tipo+'</span>';
                            var cantidad = '<span class="">'+response[i].cantidad+'</span>';
                        }
        
                        if(response[i].afiliador == null){
                            var afiliador = '<span class="text-danger">No Aplica</span>';
                        }else{
                            var afiliador = response[i].afiliador;
                        }
        
                        html +='<tr>'+
                                '<td>'+response[i].id+'</td>'+
                                '<td class="">'+response[i].supervisor+'</td>'+
                                '<td class="">'+response[i].ciudad+'</td>'+
                                '<td class="">'+tipo+'</td>'+
                                '<td class="">'+afiliador+'</td>'+
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


    function show_almaceitem_origen(id_afiliador){

        $('#id_almaceitem_origen').html('<option value="">Cargando...</option>');

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: baseUrl + "AfiliadoresController/mostrarItemsAfiliadorAlmacen",
            data: {id_afiliador: id_afiliador},
            async: false,
            dataType: 'json',
            success: function(data){
                if(data.length > 0){
                    var html = '';
                    html += '<option value="">Seleccione...</option>';
                    var i;
                    var n;
    
                    for(i=0, n=1; i<data.length; i++, n++){
                        html +='<option data-stock="'+data[i].stock+'" value="'+data[i].id+'">'+data[i].item+' - ('+data[i].stock+')</option>';
                    }
    
                    $('#id_almaceitem_origen').html(html);
                }else{
                    $('#id_almaceitem_origen').html('<option value="">El Afiliador no tiene items en su almacén</option>');
                }

                $('#cantidad_origen').val('');
                $('#cantidad_origen').attr('max', '');

            },
            error: function(){
                alert("Erro al listar.");
            }
        });
    
    }


    $('#cantidad_origen').on('keyup', function() {
        var cantidad = parseInt($(this).val());
        var stock = $('#id_almaceitem_origen option:selected').data('stock');
    
        if (cantidad < 1) {
            $(this).val(1);
        } else if (cantidad > stock) {
            $(this).val(stock);
            console.log('Cantidad ajustada al stock disponible');
        }
    });

    function listalmacenitemsforselect(campaign){
        $('#id_almaceitem').html('');
    
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: baseUrl + 'OperacionController/mostrarItemsMyAlmacenSelect',
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









