$(document).ready(function() {
	showAllConsumo();

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

} );



function showAllConsumo(){
	$('#datalist').html('<tr><td colspan="8">Cargando...</td></tr>');
    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "ConsumosController/showAllConsumos",
        async: false,
        dataType: 'json',
        success: function(data){
            var html = '';
            var i;
            var n;
            
            for(i=0, n=1; i<data.length; i++, n++){

                html +='<tr>'+
						'<td>'+data[i].Id +'</td>'+
						'<td>'+data[i].Supervisor+'</td>'+
                        '<td>'+data[i].Categoria+'</td>'+
                        '<td>'+data[i].Campana+'</td>'+
						'<td>'+data[i].Afiliador+'</td>'+
                        '<td>'+data[i].QR+'</td>'+
                        '<td>'+data[i].F_Referencia+'</td>'+
						'</tr>';
                
            }
            $('#datalist').html(html);
            
        },
        error: function(){
            alert("Erro al listar.");
        }
    });
}
