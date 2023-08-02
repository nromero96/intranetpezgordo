$(document).ready(function() {
	showAllRegistro();

  $('#ddstock').click(function() {
		$('#modaladdstock').modal({backdrop: 'static',});
		$('#formaddstock').attr('action', baseUrl + 'AlmacenController/addStockAlmacenItem');
		$('#btnsavestock').text('Guardar');
	});

	$('#formaddstock').submit(function(e){
		e.preventDefault();

    //get value select option by id id_item selected
    var campaign = $('select[name=campaign]').val();


		var url = $('#formaddstock').attr('action');
		var data = $('#formaddstock').serialize();
		$.ajax({
			type:'ajax',
			method: 'post',
			url: url,
			data: data,
			async: false,
			dataType:'json',
			success: function(respuesta){
				$('#modaladdstock').modal('hide');
					$('#formaddstock')[0].reset();
					showAllRegistro(campaign);
			},
			error: function(){
				alert("Ocurrió un error al agregar stock, por favor intente nuevamente.");
			}
		});
	});

	$("#btnreset").click(function(){
		$("#formregistro")[0].reset();
	});

});

  //change campaign select option 
  $('#campaign').change(function(){
    var campaign = $(this).val();
    showAllRegistro(campaign);
    getItems(campaign);
  });



  function showAllRegistro(campaign) {
    var url = baseUrl + "AlmacenController/showAllRegistro";

    if (campaign !== "" && typeof campaign !== "undefined") {
        url += "?campaign=" + campaign;
    }

    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            var n;

            for (i = 0, n = 1; i < data.length; i++, n++) {
                html += '<tr>' +
                    '<td>' + data[i].id + '</td>' +
                    '<td class="">' + data[i].item + '</td>' +
                    '<td class="">' + data[i].campaign + '</td>' +
                    '<td class="text-center"><a href="javascript:;" class="btn btn-info btn-sm btnverhistorial" data-toggle="tooltip" data-placement="top" data-original-title="Historial Stock" data="' + data[i].id + '"><i class="fa fa-history" aria-hidden="true"></i></a></td>' +
                    '<td class="text-center"><b>' + data[i].stock + '</b></td>' +
                    '</tr>';
            }

            $('#datalist').html(html);
            $('[data-toggle="tooltip"]').tooltip();
        },

        error: function () {
            alert("Error al listar.");
        }
    });
  }

  //obtner la lista de items para poner como options en el select id_item
  function getItems(campaign){
    $('#id_item').html('');
    $.ajax({
      type: 'ajax',
      method: 'get',
      url: baseUrl + 'ItemController/showItemsList',
      data: {campaign: campaign},
      async: false,
      dataType: 'json',
      success: function(data){
        var html = '';
        var i;
        var n;
        for(i=0, n=1; i<data.length; i++, n++){
          html += '<option value="'+data[i].id+'">'+data[i].nombre+'</option>';
        }
        $('#id_item').html(html);
      },
      error: function(){
        alert('No se pudo obtener la lista de items.');
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
              url: url + 'AlmacenController/buscarRegistro',
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
                            '<td class="text-center"><a href="javascript:;" class="btn btn-info btn-sm btnverhistorial" data-toggle="tooltip" data-placement="top" data-original-title="Hostorial Stock" data="'+response[i].id+'"><i class="fa fa-history" aria-hidden="true"></i></a></td>'+
                            '<td class="text-center"><b>'+response[i].stock+'</b></td>'+
                            '</tr>';
                    }
                    $('#datalist').html(html);
                    $('[data-toggle="tooltip"]').tooltip();
                }
              }
            });

          };
          setTimeout(login, 500);
      });

      //clic en el boton ver historial
      $('#datalist').on('click', '.btnverhistorial', function(){
        var id = $(this).attr('data');
        var item = $(this).parent().parent().children('td:eq(1)').text();
        $('#nombreitem').text(''+item+'');

        $('#modalhistorialstock').modal('show');
        $.ajax({
          type: 'ajax',
          method: 'get',
          url: baseUrl + 'AlmacenController/verHistorialStock',
          data: {idalmacenitem: id},
          async: false,
          dataType: 'json',
          success: function(data){
            var html = '';
            var i;
            var n;
            for(i=0, n=1; i<data.length; i++, n++){

              if(data[i].tipo == 'Ingreso'){
                  cantidad = '<span class="badge badge-success">'+data[i].cantidad+'</span>';
              }else if(data[i].tipo == 'Entrega'){
                  cantidad = '<span class="badge badge-danger">-'+data[i].cantidad+'</span>';
              }

              html +='<tr>'+
                '<td>'+data[i].id+'</td>'+
                '<td>'+data[i].usuario+'</td>'+
                '<td>'+cantidad+'</td>'+
                '<td>'+data[i].fecharegistro+'</td>'+
                '</tr>';
            }
            $('#datalisthistorial').html(html);
          },
          error: function(){
            alert('No se pudo obtener el historial de stock.');
          }
        });
      }
    );








