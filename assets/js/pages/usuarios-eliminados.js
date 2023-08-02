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


	$('.btnrestore').click(function() {
		var idu = $(this).attr('data');
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			url: baseUrl + "UsuariosController/restaurarUsuario",
			data:{idu:idu},
			success: function(respuesta){
				location.reload();
			},
			error: function(){
				alert("Error al eliminar el personal!. Intentelo nuvamente.");
			}
		});
	});
	
	$("[data-toggle='restoreconfirm']").popConfirm({
		title: "¿Estas seguro?",
		content: "",
		placement: "bottom",
		yesBtn: 'Si',
		noBtn: 'No'
	});

} );


function showAllUsuarios(){
	$('#datalist').html('<tr><td colspan="8">Cargando...</td></tr>');
    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "UsuariosController/showAllUsuariosEliminados",
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

                html +='<tr>'+
						'<td>'+data[i].idusuario +'</td>'+
						'<td>'+data[i].nombreapellido+'</td>'+
                        '<td>'+data[i].email+'</td>'+
                        '<td>'+data[i].telefono+'</td>'+
						'<td>'+data[i].nombrerol+'</td>'+
						'<td class="text-center">'+txtverif+'</td>'+
                        '<td><a href="javascript:;" class="btn btn-danger btn-sm btnrestore" data-toggle="restoreconfirm" data="'+data[i].idusuario+'">Restaurar</td>'+
						'</tr>';
            }
            $('#datalist').html(html);
            
        },
        error: function(){
            alert("Erro al listar.");
        }
    });
}
