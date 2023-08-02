$(document).ready(function() {
	showAllRegistro();

	$('#addanew').click(function() {
		$('#modalregistro').modal({backdrop: 'static',});
		$('#formregistro').attr('action', baseUrl + 'AlmacenController/asociarItemMyAlmacen');
		$('#btnsave').text('Guardar');
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

    var url = baseUrl + "AlmacenController/mostrarItemsMyAlmacen";

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
                html +='<tr>'+
						    '<td>'+data[i].id+'</td>'+
						    '<td class="">'+data[i].item+'</td>'+
                '<td>'+data[i].campaign+'</td>'+
                '<td>'+data[i].categoria+'</td>'+
                '<td class="text-center"><b>'+data[i].stock+'</b></td>'+
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
              url: url + 'AlmacenController/buscarItemsMyAlmacen',
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
                      '<td class="">'+response[i].item+'</td>'+
                      '<td>'+response[i].campaign+'</td>'+
                      '<td>'+response[i].categoria+'</td>'+
                      '<td class="text-center"><b>'+response[i].stock+'</b></td>'+
                      '</tr>';
                    }
                    $('#datalist').html(html);
                }
              }
            });
          };
          setTimeout(login, 500);
      });