$('#dni').on('change', function () {
    var dni = $('#dni').val()
    $("#nombres").val("");
    $("#apepaterno").val("");
    $("#apematerno").val("");
    $.ajax({
        data: {"dni": dni},
        method: 'POST',
        url: '../../controladores/usuario.php?op=validarDNI',
        dataType: 'json',
        success: function (respuesta) {
            data = respuesta.datos;
            if(data){
                data = JSON.parse(data);
                nombre = capitalizarPalabras(htmlEntities(data.nombres));
                apepaterno = capitalizarPalabras(htmlEntities(data.apellidoPaterno));
                apematerno = capitalizarPalabras(htmlEntities(data.apellidoMaterno));
                //alert("nombre");
                $("#nombres").val(nombre);
                $("#apepaterno").val(apepaterno);
                $("#apematerno").val(apematerno);
            }
            $("#validacion").attr("style","float:right; font-weight:bold; color:" + respuesta.color);
            $("#validacion").html(respuesta.mensaje);
        }
    });
});

function htmlEntities(str) {
    return String(str).replace('&Agrave;', 'À')
        .replace('&Aacute;', 'Á')
        .replace('&Acirc;', 'Â')
        .replace('&Atilde;', 'Ã')
        .replace('&Auml;', 'Ä')
        .replace('&Aring;', 'Å')
        .replace('&AElig;', 'Æ')
        .replace('&Ccedil;', 'Ç')
        .replace('&Egrave;', 'È')
        .replace('&Eacute;', 'É')
        .replace('&Ecirc;', 'Ê')
        .replace('&Euml;', 'Ë')
        .replace('&Igrave;', 'Ì')
        .replace('&Iacute;', 'Í')
        .replace('&Icirc;', 'Î')
        .replace('&Iuml;', 'Ï')
        .replace('&ETH;', 'Ð')
        .replace('&Ntilde;', 'Ñ')
        .replace('&Ograve;', 'Ò')
        .replace('&Oacute;', 'Ó')
        .replace('&Ocirc;', 'Ô')
        .replace('&Otilde;', 'Õ')
        .replace('&Ouml;', 'Ö')
        .replace('&Oslash;', 'Ø')
        .replace('&Ugrave;', 'Ù')
        .replace('&Uacute;', 'Ú')
        .replace('&Ucirc;', 'Û')
        .replace('&Uuml;', 'Ü')
        .replace('&Yacute;', 'Ý')
        .replace('&THORN;', 'Þ')
        .replace('&szlig;', 'ß')
}

function capitalizarPalabras(val) {

    return val.toLowerCase()
        .trim()
        .split(' ')
        .map(v => v[0].toUpperCase() + v.substr(1))
        .join(' ');
}