showAllPersonal();

function showAllPersonal(){
    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "admin/PersonalController/showAllPersonal",
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;
            
            for(i=0, n=1; i<data.length; i++, n++){
                html +='<tr>'+
                        '<td>'+n+'</td>'+
						'<td class="text-uppercase">'+data[i].tipodocumento+'</td>'+
						'<td>'+data[i].numdocumento+'</td>'+
						'<td>'+data[i].apellidos+' '+data[i].nombre+'</td>'+
						'<td><a class="btn btn-success btn-fab btn-round btn-sm btnedit" data="'+data[i].idpersonal+'"><i class="material-icons" style="color: white;">create</i></a> <a class="btn btn-danger btn-fab btn-round btn-sm btndelete" data="'+data[i].idpersonal+'" data-toggle="deleteconfirm"><i class="material-icons" style="color: white;" >delete_forever</i></a> <a class="btn btn-info btn-fab btn-round btn-sm btnschedule" data="'+data[i].idpersonal+'"><i class="material-icons" style="color: white;">calendar_today</i></a></td>'+
						'</tr>';
                
            }
            $('#datalist').html(html);
            
        },
        error: function(){
            alert("Erro al listar.");
        }
    });
}


$('#datalist').on('click', '.btnedit', function(){
    var idpersonal = $(this).attr('data');
    
    $('#modalpersonal').modal({backdrop: 'static'});
    $('#formpersonal').attr('action', baseUrl + 'admin/PersonalController/updatePersonal');
    
    $.ajax({
		type: 'ajax',
		method: 'get',
		url: baseUrl + "admin/PersonalController/getPersonalEdit",
		data: {idp: idpersonal},
		async: false,
		dataType: 'json',
		success: function(data){
			$('input[name=apellidos]').val(data.apellidos);
			$('input[name=nombre]').val(data.nombre);
			$('select[name=tipodocumento]').val(data.tipodocumento);
			$('input[name=numerodocumento]').val(data.numdocumento);
			$('input[name=idpersonal]').val(data.idpersonal);
		},
		error: function(){
		    alert("¡Ups! Algo salió mal!. Intentelo nuevamente");
		}
	});
    
});


$('#btnsave').click(function(){
		var url = $('#formpersonal').attr('action');
		var data = $('#formpersonal').serialize();

		//validar
		var apellidos = $('input[name=apellidos]');
		var nombre = $('input[name=nombre]');
		var tipodocumento = $('select[name=tipodocumento]');
		var numerodocumento = $('input[name=numerodocumento]');
		var resultad = '';

		if(apellidos.val()==''){
			$('#apellidos').prop('required',true);
		}else{
			$('#apellidos').removeClass('has-error');
			resultad +='1';
		}

		if(nombre.val()==''){
			$('#nombre').addClass('has-error');
		}else{
			$('#nombre').removeClass('has-error');
			resultad +='2';
		}

		if(tipodocumento.val()==''){
			$('#tipodocumento').addClass('has-error');
		}else{
			$('#tipodocumento').removeClass('has-error');
			resultad +='3';
		}

		if(numerodocumento.val()==''){
			$('#numerodocumento').addClass('has-error');
		}else{
			$('#numerodocumento').removeClass('has-error');
			resultad +='4';
		}


		if(resultad=='1234'){
				$.ajax({
				type:'ajax',
				method: 'post',
				url: url,
				data: data,
				async: false,
				dataType:'json',
				success: function(respuesta){
					$('#modalpersonal').modal('hide');
						$('#formpersonal')[0].reset();
						showAllPersonal();
				},
				error: function(){
					alert("¡Ups! Algo salió mal!. Intentelo nuevamente");
				}
			});
		    }
	});


// $('#datalist').on('click', '.btndelete', function(){
//     var idp = $(this).attr('data');
//     alert('Hola');
// });
$('.btndelete').click(function() {
    var idp = $(this).attr('data');
    $.ajax({
		type: 'ajax',
		method: 'get',
		async: false,
		url: baseUrl + "admin/PersonalController/deletePersonal",
		data:{idp:idp},
		success: function(respuesta){
			location.reload();
		},
		error: function(){
			alert("Error al eliminar el personal!. Intentelo nuvamente.");
		}
	});
});

$("[data-toggle='deleteconfirm']").popConfirm({
    title: "¿Estas seguro?",
    content: "",
    placement: "bottom",
    yesBtn: 'Si',
    noBtn: 'No'
});


$("#btnreset").click(function(){
	$("#formpersonal")[0].reset();
});