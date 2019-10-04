/// <reference path="node_modules/@types/jquery/index.d.ts" />

function mostrarMensaje()
    {
        let mensaje = $("#txtMensaje").val();

        let respuesta;
        let form = new FormData();
        let archivo = $("#archivo");
        alert(archivo);
        form.append("mensaje", mensaje.toString());
        form.append("archivo",archivo.prop("files")[0]);
        form.append("queHago", "1");


        let ajax = $.ajax({ //CREO UNA INSTANCIA DEL AJAX CON JQUERY DONDE TENGO TODOS LOS METODOS

            type: "POST",
            url: "./clases/administracion.php",
            cache: false,
            contentType: false,
            processData : false,
            data: form,
            dataType: "JSON"

        })

        ajax.done(function(respuesta)
        {
            $("#divMensaje").html(respuesta.mensaje + " - " + respuesta.fecha);
            $("#divMensaje").html($("#archivo").attr("src"));
        })
        ajax.fail(function(){

            alert("se ha producido un error");
        })

    }