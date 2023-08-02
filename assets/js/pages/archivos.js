$('#addfile').click(function() {
    $('#modalfile').modal({backdrop: 'static'});
    $('#formfile').attr('action', baseUrl + 'ArchivosController/addFile');
    $("#datafile").attr("required","");
});


$('#formfile').submit(function(e){
	e.preventDefault();
	var url = $('#formfile').attr('action');
    var formData = new FormData($('#formfile')[0]);

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: url,
        data: formData, 
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        dataType: 'json',
        success: function(respuesta) {
            $('#modalfile').modal('hide');
            $('#formfile')[0].reset();
            if (respuesta.type == 'add') {
                var type = 'Agregado';
            } else if (respuesta.type == 'update') {
                var type = 'Actualizado';
            }
            location.reload();

        },

        error: function() {
            alert("Algo salió mal!. Intentelo nuevamente");
            
        }
    });
});

$('.editfile').click(function() {
    var idf = $(this).attr('data');
    $('#modalfile').modal({backdrop: 'static'});
    $('#formfile').attr('action', baseUrl + 'ArchivosController/updateFile');
    $('#datafile').removeAttr('required');
    $.ajax({
        type: 'ajax',
        method: 'get',
        url: baseUrl + "ArchivosController/getSingleFile",
        data: {idf: idf},
        async: false,
        dataType: 'json',
        success: function(data){
            $('input[name=idfile]').val(data.idarchivo);
            $('select[name=categoria]').val(data.idacategoria);
            $('select[name=subcategoria]').val(data.idsubcategoria);
			$('input[name=titulo]').val(data.titulo);
        },
        error: function(){
            alert("Algo salió mal!. Intentelo nuevamente");
        }
    });
});

$('.deletefile').click(function() {
    var id = $(this).attr('data');
    $.ajax({
		type: 'ajax',
		method: 'get',
		async: false,
		url: baseUrl + "ArchivosController/deleteFile",
		data:{id:id},
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
    $("#formfile")[0].reset();
});

$("#btclose").click(function(){
    $("#formfile")[0].reset();
});


$('#btncompartir').click(function() {
    $('#modalshare').modal({backdrop: 'static'});
});
