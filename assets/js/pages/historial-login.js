$(document).ready(function(){
    showAllHistorial();
    showCantidadLogin();

    $('#mitblista, #mitbcantidad').DataTable( {

        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
		},
		
		"order": [],
    	"columnDefs": [ {
      	"targets"  : 'no-sort',
      	"orderable": false,
    	}]
		
	} );


});







function showAllHistorial(){
    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "UsuariosController/showHistorialLogin",
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
						'<td><i class="nc-icon tblist-icon nc-circle-10"></i></td>'+
						'<td>'+data[i].nombreapellido+'</td>'+
                        '<td>'+data[i].email+'</td>'+
                        '<td>'+data[i].ip+'</td>'+
						'<td class="text-center">'+data[i].fechahora+'</td>'+
						'</tr>';
                
            }
            $('#datalist').html(html);
            
        },
        error: function(){
            alert("Erro al listar.");
        }
    });
}


function showCantidadLogin(){
    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "UsuariosController/showCantidadLogin",
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;
            
            for(i=0, n=1; i<data.length; i++, n++){

                html +='<tr>'+
						'<td><i class="nc-icon tblist-icon nc-circle-10"></i></td>'+
						'<td>'+data[i].nombreapellido+'</td>'+
                        '<td>'+data[i].email+'</td>'+
						'<td class="text-center"><span class="badge bg-primary">'+data[i].cantidadlogin+'</span></td>'+
						'</tr>';
                
            }
            $('#listcantidad').html(html);
            
        },
        error: function(){
            alert("Erro al listar.");
        }
    });
}