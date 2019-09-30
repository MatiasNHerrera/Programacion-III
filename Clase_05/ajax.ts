
function EnviarDatos() : void
{
    var http = new XMLHttpRequest();

    http.open("POST", "verificacion.php");

    http.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    let correo = (<HTMLInputElement>document.getElementById("txtCorreo")).value;
    let clave = (<HTMLInputElement>document.getElementById("txtClave")).value;
    let json = {"correo" : correo, "clave" : clave };
    http.send("informacion=" + JSON.stringify(json) + "&queHago=validar");

    http.onreadystatechange = () =>
    {
        if(http.status == 200 && http.readyState == 4)
        {
            let obj : any = JSON.parse(http.responseText);

            if(obj.existe)
            {
                window.location.href = "test_pdf.php";
            }
            else
            {
                alert("no registrado");
            }
        }
    }

}

function Registrar()
{
    var http = new XMLHttpRequest();
    http.open("POST", "verificacion.php");
    http.setRequestHeader("enctype", "multipart/form-data");
    let form : FormData = new FormData();

    let nombre = (<HTMLInputElement>document.getElementById("nombre")).value;
    let apellido = (<HTMLInputElement>document.getElementById("apellido")).value;
    let perfil = (<HTMLInputElement>document.getElementById("perfil")).value;
    let correo = (<HTMLInputElement>document.getElementById("correo")).value;
    let clave = (<HTMLInputElement>document.getElementById("clave")).value;
    let foto : any = (<HTMLInputElement>document.getElementById("foto"));

    let json = {"nombre" : nombre, "apellido" : apellido, "perfil" : perfil, "correo" : correo, "clave" : clave, "foto" : foto};

    form.append("usuario", JSON.stringify(json));
    form.append("foto", foto.files[0]);
    form.append("queHago", "registrar");

    http.send(form);

    http.onreadystatechange = () =>
    {
        if(http.status == 200 && http.readyState == 4)
        {
            alert(http.responseText);
        }
    }

}

