function init(){
    notifications();
}

$('#newUsers').timer({
    duration: '5s',
    callback: function () {
        console.log("hola"); //you could have a ajax call here instead
        notifications();
        $('#newUsers').timer('reset');
    },
    repeat: true //repeatedly calls the callback you specify
});

function notifications() {
    $.post("../../controladores/notificacion.php?op=notificaciones", {},
        function (data, status) {
            //data = JSON.parse(data);
            $("#notificationes").html(data);
        })
}

init();