function EnviarDatos() {
    var http = new XMLHttpRequest();
    http.open("POST", "verificacion.php");
    http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    var correo = document.getElementById("txtCorreo").value;
    var clave = document.getElementById("txtClave").value;
    var json = { "correo": correo, "clave": clave };
    http.send("informacion=" + JSON.stringify(json) + "&queHago=validar");
    http.onreadystatechange = function () {
        if (http.status == 200 && http.readyState == 4) {
            var obj = JSON.parse(http.responseText);
            if (obj.existe) {
                window.location.href = "test_pdf.php";
            }
            else {
                window.location.href = "registro.php";
            }
        }
    };
}
function Registrar() {
    var http = new XMLHttpRequest();
    http.open("POST", "verificacion.php");
    http.setRequestHeader("enctype", "multipart/form-data");
    var form = new FormData();
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var perfil = document.getElementById("perfil").value;
    var correo = document.getElementById("correo").value;
    var clave = document.getElementById("clave").value;
    var foto = document.getElementById("foto");
    var json = { "nombre": nombre, "apellido": apellido, "perfil": perfil, "correo": correo, "clave": clave, "foto": foto };
    form.append("usuario", JSON.stringify(json));
    form.append("foto", foto.files[0]);
    form.append("queHago", "registrar");
    http.send(form);
    http.onreadystatechange = function () {
        if (http.status == 200 && http.readyState == 4) {
            alert(http.responseText);
        }
    };
}
