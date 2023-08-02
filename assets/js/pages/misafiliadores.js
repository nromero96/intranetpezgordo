$(document).ready(function() {
    //querydata select action to showAllRegistro
    $('#querydata').change(function(){
        var id_afiliador = $(this).val();
        if(id_afiliador != ''){
            showAllRegistro(id_afiliador);
        }else{
            alert('Por favor seleccione un afiliador');
            //reset select #querydata
            $('#querydata').val('');
            $('#datalist').html('<tr><td colspan="3" class="text-center">Seleccione un afiliador para ver su almacén</td></tr>');
        }
    });

} );


function showAllRegistro(id_afiliador){

    $('#datalist').html('<tr><td colspan="3" class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></td></tr>');

    //get data ajax from id_afiliador
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
                var i;
                var n;

                for(i=0, n=1; i<data.length; i++, n++){
                    html +='<tr>'+
                                '<td>'+data[i].id+'</td>'+
                                '<td class="">'+data[i].item+'</td>'+
                                '<td class="text-center"><b>'+data[i].stock+'</b></td>'+
                                '</tr>';
                }

                $('#datalist').html(html);
            }else{
                $('#datalist').html('<tr><td colspan="3" class="text-center">El Afiliador no tiene items en su almacén</td></tr>');
            }
        },
        error: function(){
            alert("Erro al listar.");
        }
    });

}