$(document).ready(function() {
	showAllUsuarios();

	$('#mitblista').DataTable( {

        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
		},
		
		"order": [],
    	"columnDefs": [ {
      	"targets"  : 'no-sort',
      	"orderable": false,
    	}]
		
	} );
	

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
				alert("Error al cambiar estado!. Intentelo nuvamente.");
			}
		});
		

	});


	$('#email').focusout( function(){
		var email = $('#email').val();
		if(email != ""){
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: baseUrl+"UsuariosController/verificarEmail",
				data: {email: email},
				beforeSend: function(){
					$('#msinfo').html('<span class="text-info"><img src="'+baseUrl+'assets/img/loading_small.gif"> Verificando</span>');
				},
				success: function(respuesta){
					if(respuesta == 'true'){
						$('#msinfo').html('<span class="text-danger">El correo ya está registrado</span>');
						$( "#btnsave" ).prop( "disabled", true );
					}else{
						$('#msinfo').html("");
						$( "#btnsave" ).prop( "disabled", false );
					}
				}
			});
		}
	});
	
	/*Boton agregar nuevo archivo*/
	$('#adduser').click(function() {
		$('#modalusuario').modal({backdrop: 'static',});
		$('#formusuario').attr('action', baseUrl + 'UsuariosController/addUsuario');
		$("#password").attr("required","");
		$('#btnsave').text('Guardar');
		$('#email').prop( "disabled", false );
	});
	
	$('#datalist').on('click', '.btnedit', function(){
		var idu = $(this).attr('data');
		
		$('#modalusuario').modal({backdrop: 'static'});
		$('#formusuario').attr('action', baseUrl + 'UsuariosController/updateUsuario');
		$("#password").removeAttr('required');
		$('#email').prop( "disabled", true );
		
		$.ajax({
			type: 'ajax',
			method: 'get',
			url: baseUrl + "UsuariosController/getUsuarioEdit",
			data: {idu: idu},
			async: false,
			dataType: 'json',
			success: function(data){
				$('input[name=idusuario]').val(data.idusuario);
				$('input[name=nombreyapellido]').val(data.nombreapellido);
				$('input[name=email]').val(data.email);
				$('input[name=numero]').val(data.telefono);
				$('select[name=id_ciudad]').val(data.id_ciudad);
				$('input[name=fecha_ingreso]').val(data.fecha_ingreso);
				$('select[name=rolusuario]').val(data.idrol);
				$('select[name=registradopor]').val(data.registradopor);

			},
			error: function(){
				alert("¡Ups! Algo salió mal!. Intentelo nuevamente");
			}
		});
		
	});


	$('#formusuario').submit(function(e){
		e.preventDefault();
		var url = $('#formusuario').attr('action');
		var data = $('#formusuario').serialize();
		$.ajax({
			type:'ajax',
			method: 'post',
			url: url,
			data: data,
			async: false,
			dataType:'json',
			success: function(respuesta){
				$('#modalusuario').modal('hide');
					$('#formusuario')[0].reset();
					showAllUsuarios();
			},
			error: function(){
				alert("¡Ups! Algo salió mal!. Intentelo nuevamente");
			}
		});
	});
	
	$('.btndelete').click(function() {
		var idu = $(this).attr('data');
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			url: baseUrl + "UsuariosController/deleteUsuario",
			data:{idu:idu},
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
		$("#formusuario")[0].reset();
	});
	
	$("#show_hide_password a").on('click', function(event) {
		event.preventDefault();
		if($('#show_hide_password input').attr("type") == "text"){
			$('#show_hide_password input').attr('type', 'password');
			$('#show_hide_password i').addClass( "fa-eye-slash" );
			$('#show_hide_password i').removeClass( "fa-eye" );
		}else if($('#show_hide_password input').attr("type") == "password"){
			$('#show_hide_password input').attr('type', 'text');
			$('#show_hide_password i').removeClass( "fa-eye-slash" );
			$('#show_hide_password i').addClass( "fa-eye" );
		}
	});


	
} );



function showAllUsuarios(){
	$('#datalist').html('<tr><td colspan="8">Cargando...</td></tr>');
    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "UsuariosController/showAllUsuarios",
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;
            
            for(i=0, n=1; i<data.length; i++, n++){

				if(data[i].bfverificado == 'si'){
					txtverif = '<span class="badge bg-success">Si</span>';
				} else {
					txtverif = '<span class="badge bg-danger">No</span>';
				}
				
				if(data[i].estado == '1'){
					txtestado = '<label for="swestado'+data[i].idusuario+'" class="toggle-switchy" data-size="xs"><input class="cbxestado" checked type="checkbox" value="'+data[i].estado+'" id="swestado'+data[i].idusuario+'" data="'+data[i].idusuario+'"><span class="toggle"><span class="switch"></span></span></label>';
				}else{
					txtestado = '<label for="swestado'+data[i].idusuario+'" class="toggle-switchy" data-size="xs"><input class="cbxestado" type="checkbox" value="'+data[i].estado+'" id="swestado'+data[i].idusuario+'" data="'+data[i].idusuario+'"><span class="toggle"><span class="switch"></span></span></label>';
				}

                html +='<tr>'+
						'<td>'+data[i].idusuario +'</td>'+
						'<td class="text-center">'+txtestado+'</td>'+
						'<td>'+data[i].nombreapellido+'</td>'+
                        '<td>'+data[i].email+'</td>'+
                        '<td>'+data[i].telefono+'</td>'+
						'<td>'+data[i].nombrerol+'</td>'+
						'<td class="text-center">'+txtverif+'</td>'+
						'<td><a href="javascript:;" class="btn btn-primary btn-sm btnedit" data-toggle="tooltip" data-placement="top" title="Editar" data="'+data[i].idusuario+'"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="javascript:;" class="btn btn-danger btn-sm btndelete" data-toggle="deleteconfirm" data="'+data[i].idusuario+'"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>'+
						'</tr>';
                
            }
            $('#datalist').html(html);
            
        },
        error: function(){
            alert("Erro al listar.");
        }
    });
}
