$(document).ready(function() {
	showAllRegistro();

	$(".cbxasistencia").click(function() {
        var valchbx = $(this).val();
        var idu = $(this).attr('data');
        if( $(this).is(':checked') ){
            $(this).val('si');
        } else {
            $(this).val('no');
        }
        $.ajax({
            type: 'ajax',
            method: 'get',
            async: false,
            dataType: 'json',
            url: baseUrl + "AsistenciaController/updateAsistencia",
            data:{idu:idu, valchbx:valchbx},
            success: function(respuesta){
    
                //get this row
                var row = $("#swasistencia"+idu).closest("tr");
                //get the date
                var date = row.find(".fecharegistro");
                //print the date
                date.text(respuesta.fechayhora);
            },
            error: function(){
                alert("Error al cambiar estado!. Intentelo nuvamente.");
            }
        });
    });


	$('#addasistente').click(function() {
		$('#modalregistro').modal({backdrop: 'static',});
		$('#formregistro').attr('action', baseUrl + 'AsistenciaController/addAsistente');
		$('#btnsave').text('Guardar');
	});

	

	// $('#datalist').on('click', '.btnedit', function(){
	// 	var idr = $(this).attr('data');
	// 	$('#modalregistro').modal({backdrop: 'static'});
	// 	$('#formregistro').attr('action', baseUrl + 'AsistenciaController/updateNumero');

	// 	$.ajax({
	// 		type: 'ajax',
	// 		method: 'get',
	// 		url: baseUrl + "RegistroController/getRegistroEdit",
	// 		data: {idr: idr},
	// 		async: false,
	// 		dataType: 'json',
	// 		success: function(data){
	// 			$('input[name=idnumero]').val(data.id);
	// 			$('input[name=numero]').val(data.numero);
	// 			$('select[name=estado]').val(data.estado);

	// 		},

	// 		error: function(){
	// 			alert("Ups Algo salió mal. Intentelo nuevamente");
	// 		}
	// 	});
	// });


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

                    $(".cbxasistencia").click(function() {
                        var valchbx = $(this).val();
                        var idu = $(this).attr('data');
                        if( $(this).is(':checked') ){
                            $(this).val('si');
                        } else {
                            $(this).val('no');
                        }
                        $.ajax({
                            type: 'ajax',
                            method: 'get',
                            async: false,
                            dataType: 'json',
                            url: baseUrl + "AsistenciaController/updateAsistencia",
                            data:{idu:idu, valchbx:valchbx},
                            success: function(respuesta){
                    
                                //get this row
                                var row = $("#swasistencia"+idu).closest("tr");
                                //get the date
                                var date = row.find(".fecharegistro");
                                //print the date
                                date.text(respuesta.fechayhora);
                            },
                            error: function(){
                                alert("Error al cambiar estado!. Intentelo nuvamente.");
                            }
                        });
                    });

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
        url: baseUrl + "AsistenciaController/showAllRegistro",
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;

            for(i=0, n=1; i<data.length; i++, n++){
                if(data[i].ingreso == 'si'){
					switchasistencia = '<label for="swasistencia'+data[i].id+'" class="toggle-switchy" data-size="xs"><input class="cbxasistencia" checked type="checkbox" value="'+data[i].ingreso+'" id="swasistencia'+data[i].id+'" data="'+data[i].id+'"><span class="toggle"><span class="switch"></span></span></label>';
				}else{
					switchasistencia = '<label for="swasistencia'+data[i].id+'" class="toggle-switchy" data-size="xs"><input class="cbxasistencia" type="checkbox" value="'+data[i].ingreso+'" id="swasistencia'+data[i].id+'" data="'+data[i].id+'"><span class="toggle"><span class="switch"></span></span></label>';
				}

                html +='<tr>'+
						'<td>'+data[i].id+'</td>'+
						'<td class="">'+data[i].nombre+'</td>'+
                        '<td class="text-uppercase">'+data[i].tipo+'</td>'+
						'<td class="">'+switchasistencia+'</td>'+
						'<td class="fecharegistro">'+data[i].fechayhora+'</td>'+
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
          var datsearch = $('#formbuscarregistro').serialize();
            $.ajax({
              type: 'POST',
              url: url + 'AsistenciaController/buscarAsistente',
              dataType: 'json',
              data: datsearch,
              success:function(response){
                $('#message').html(response.message);
                $('#btntext').html('CONSULTAR');
                if(response.error){
                   alert('El nombre que está buscando no se encuetra registrado.');
                }else{
                    var html = '';
                    var i;
                    var n;
                    for(i=0, n=1; i<response.length; i++, n++){
                        if(response[i].ingreso == 'si'){
                            switchasistencia = '<label for="swasistencia'+response[i].id+'" class="toggle-switchy" data-size="xs"><input class="cbxasistencia" checked type="checkbox" value="'+response[i].ingreso+'" id="swasistencia'+response[i].id+'" data="'+response[i].id+'"><span class="toggle"><span class="switch"></span></span></label>';
                        }else{
                            switchasistencia = '<label for="swasistencia'+response[i].id+'" class="toggle-switchy" data-size="xs"><input class="cbxasistencia" type="checkbox" value="'+response[i].ingreso+'" id="swasistencia'+response[i].id+'" data="'+response[i].id+'"><span class="toggle"><span class="switch"></span></span></label>';
                        }
                        html +='<tr>'+
                            '<td>'+response[i].id+'</td>'+
                            '<td class="">'+response[i].nombre+'</td>'+
                            '<td class="text-uppercase">'+response[i].tipo+'</td>'+
                            '<td class="">'+switchasistencia+'</td>'+
                            '<td class="fecharegistro">'+response[i].fechayhora+'</td>'+
                            '</tr>';
                    }
                    $('#datalist').html(html);

                    ///////////////////////////
                    $(".cbxasistencia").click(function() {
                        var valchbx = $(this).val();
                        var idu = $(this).attr('data');
                        if( $(this).is(':checked') ){
                            $(this).val('si');
                        } else {
                            $(this).val('no');
                        }
                        $.ajax({
                            type: 'ajax',
                            method: 'get',
                            async: false,
                            dataType: 'json',
                            url: baseUrl + "AsistenciaController/updateAsistencia",
                            data:{idu:idu, valchbx:valchbx},
                            success: function(respuesta){
                    
                                //get this row
                                var row = $("#swasistencia"+idu).closest("tr");
                                //get the date
                                var date = row.find(".fecharegistro");
                                //print the date
                                date.text(respuesta.fechayhora);
                            },
                            error: function(){
                                alert("Error al cambiar estado!. Intentelo nuvamente.");
                            }
                        });
                    });

                }
              }
            });

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







