<?php
session_start();
include_once '../boundary/empleado.php';
include_once '../boundary/miembro.php';
$miembro = new miembro();
//$activos = $miembro->getAllActiveMiembros();
$login = new empleado();
$login->ValidateSession();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Miembros</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/toastr.css">
    <link rel="icon" type="image/png" href="img/icono.png">
    <style>
        .filas:hover {
            cursor: pointer;
        }

        .opciones:hover {
            cursor: context-menu;
        }

        .item {
            padding: 5px;
        }

        .emp-profile {
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;
        }

        .profile-img {
            text-align: center;
        }

        .profile-img img {
            width: 210px;
           height: 210px;

        }

        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 90%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }

        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .profile-head h5 {
            color: #333;
        }

        .profile-head h6 {
            color: #0062cc;
        }


        .proile-rating {
            font-size: 15px;
            color: #818182;
            margin-top: 5%;
        }

        .proile-rating span {
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }

        .profile-head .nav-tabs {
            margin-bottom: 5%;
        }

        .profile-head .nav-tabs .nav-link {
            font-weight: 600;
            border: none;
        }

        .profile-head .nav-tabs .nav-link.active {
            border: none;
            border-bottom: 2px solid #0062cc;
        }

        .actives {
            border: none;
            border-bottom: 2px solid #0062cc;
        }

        .profile-tab label {
            font-weight: 600;
        }

        .profile-tab p {
            font-weight: 600;
            color: #0062cc;
        }

        body {
            background: url(img/fondoSystem.png) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;

        }
          table{
            background-color:#ffffff;
        }
        
        h3{
            width: 250px;
            background-color:#fbfbfb;
        }
    </style>
</head>

<body>
    <?php include_once("navbar.php"); ?>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3>Buscar Miembro:</h3>
                    <input id="buscador" class="form-control basicAutoSelect" style="width: 70%; float: left;" placeholder="Ingrese nombre del miembro..." onkeypress="return lettersOnly(event);" autocomplete="off" />
                    <button id="btn_buscar" style="float: left;" class="btn btn-secondary">Filtrar</button>
                    <div class="btn-group">
                        <button id="btn_estado" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Estado
                        </button>
                        <div id="estado_opciones" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                            <!--button class="dropdown-item" type="button">Action</button-->
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
            <br>
            <table id="tablaMiembros" class="table text-center table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Fotograf&iacute;a</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Membres&iacute;a</th>
                        <th scope="col">Inicio</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    <tr>
                        <td colspan="6" class="text-center text-secondary">No se encontraron miembros</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-2"></div>
    </div>
    <!-- Large modal -->
    <div class="modal fade bd-example-modal-lg" id="modalDatos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card" style="border: none;">
                    <div class="card-header  text-center" style="background-color: #4B515D; color:white; ">
                        <button type="button" class="close " style="color:white; " onclick="cerrar();" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>
                            <p class="lead">Informaci&oacute;n del miembro</p>
                        </strong>

                    </div>
                    <div class="card-body" id="cargando" style="display:none">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <br><br><br>
                                <img src="img/cargando3.gif" width="230" alt="Cargando..." />>
                                <br><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="datos">
                        <div class="container emp-profile">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-img">
                                        <img id="fotografia" class="rounded-circle shadow-lg" alt="Miembro" />
                                    </div>
                                </div>
                                <div class="col-md-7 text-center">
                                    <div class="profile-head">
                                        <br>
                                        <h2 id="nombre">
                                        </h2>
                                        <h4 id="apellidos" class="text-center">

                                        </h3>
                                        <h5 class="proile-rating"><span id="fecha"></span></h5>
                                        <br>

                                        <div class="row .nav-tabs">

                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="tab-proximos-a-pagar" data-toggle="tab" href="#proximos-a-pagar" role="tab" aria-controls="proximos-a-pagar" aria-selected="true">Informaci&oacute;n Personal</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="tab-pagos-en-proceso" data-toggle="tab" href="#pagos-en-proceso" role="tab" aria-controls="pagos-en-proceso" aria-selected="false">Informaci&oacute;n Gimnasio</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="proximos-a-pagar" role="tabpanel" aria-labelledby="tab-proximos-a-pagar">
                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <div id="personal">
                                                            <div class="row profile-tab">
                                                                <div class="col-md-5">
                                                                    <label>Usuario:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="user"></p>
                                                                </div>
                                                            </div>
                                                            <div class="row profile-tab">
                                                                <div class=" col-md-5">
                                                                    <label>G&eacute;nero:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="genero"></p>
                                                                </div>
                                                            </div>
                                                            <div class="row profile-tab">
                                                                <div class=" col-md-5">
                                                                    <label>Correo:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="correo" style="font-size: 14px;"></p>
                                                                </div>
                                                            </div>
                                                            <div class="row profile-tab">
                                                                <div class=" col-md-5">
                                                                    <label>Tel&eacute;fono:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="telefono"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="pagos-en-proceso" role="tabpanel" aria-labelledby="tab-pagos-en-proceso">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <div id="profile">
                                                            <div class="row profile-tab">
                                                                <div class=" col-md-5">
                                                                    <label>Fecha inicio:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="fecha_inicio"></p>
                                                                </div>
                                                            </div>

                                                            <div class="row profile-tab">
                                                                <div class=" col-md-5">
                                                                    <label>Altura:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="altura"></p>
                                                                </div>
                                                            </div>

                                                            <div class="row profile-tab">
                                                                <div class=" col-md-5">
                                                                    <label>Peso:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="peso"></p>
                                                                </div>
                                                            </div>
                                                            <div class="row profile-tab">
                                                                <div class=" col-md-5">
                                                                    <label>Estado:</label>
                                                                </div>
                                                                <div class="col-md-7 text-md-left text-sm-center">
                                                                    <p id="estado"></p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jQuery-3-4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/toastr.js"></script>
    <script>
        function mostrarPersonal() {
            $("#personal").css("display", "block");
            $("#perfil").css("display", "none");

            $("#link-personal").css("color", "#0062cc");
            $("#link-personal").css("font-weight", "bold");
            $("#link-personal").addClass("actives");

            $("#link-gimnasio").css("color", "#000000");
            $("#link-gimnasio").css("font-weight", "normal");
            $("#link-gimnasio").removeClass("actives");
        }

        function mostrarExtra() {
            $("#personal").css("display", "none");
            $("#perfil").css("display", "block");
            $("#link-gimnasio").css("color", "#0062cc");
            $("#link-gimnasio").css("font-weight", "bold");
            $("#link-gimnasio").addClass("actives");

            $("#link-personal").css("color", "#000000");
            $("#link-personal").css("font-weight", "normal");
            $("#link-personal").removeClass("actives");
        }

        function cerrar() {
            $("#modalDatos").modal('toggle');
        }
    </script>
    <script>
        function eventoSeleccionar() {
            $('.filas').click(function() {
                var id = $(this).attr('id');
                cargarDatos(id);
            });
        }

        function cargarDatos(selectedIdMiembro) {
            $("#modalDatos").modal('show');
            //var dataString = 'id=' + $(this).attr('id') + '&getMiembro=1';
            var dataString = 'id=' + selectedIdMiembro + '&getMiembro=1';
            $.ajax({
                type: "POST",
                url: "../controller/miembroController.php",
                data: dataString,
                beforeSend: function() {
                    $("#datos").css("display", "none");
                    $("#cargando").css("display", "block");
                },
                success: function(response) {
                    $("#datos").css("display", "block");
                    $("#cargando").css("display", "none");

                    $("#personal").css("display", "block");
                    $("#link-personal").css("color", "#0062cc");
                    $("#link-personal").css("font-weight", "bold");
                    $("#link-personal").addClass("actives");

                    $("#perfil").css("display", "none");
                    $("#link-gimnasio").css("color", "#000000");

                    selected = jQuery.parseJSON(response)
                    $("#fotografia").attr("src", "../recursos/fotografias/" +
                        selected.foto);
                    $("#fotografia").attr("alt", selected.user);
                    if (selected.segundo_nombre != null) {
                        $("#nombre").html(selected.primer_nombre + " " + selected
                        .segundo_nombre);
                    }else{
                        $("#nombre").html(selected.primer_nombre );
                    }
                    if (selected.segundo_apellido != null) {
                        $("#apellidos").html(selected.primer_apellido + " " + selected
                        .segundo_apellido);
                    }else{
                        $("#apellidos").html(selected.primer_apellido);
                    }
                   
                    $("#user").html(selected.usuario);
                    if (selected.correo != "") {
                        $("#correo").html(selected.correo);
                    } else {
                        $("#correo").html('No registrado');
                    }

                    $("#telefono").html(selected.telefono);
                    edad = calcularEdad(selected.fecha_nacimiento)
                    $("#fecha").html(edad + " años");
                    if (selected.genero == "t") {
                        genero = "Masculino";
                    } else {
                        genero = "Femenino";
                    }
                    $("#genero").html(genero);
                    $("#fecha_inicio").html(selected.fecha_inicio);

                    if (selected.altura != 0) {
                        $("#altura").html(selected.altura + ' cm');
                    } else {
                        $("#altura").html('No registrada');
                    }

                    if (selected.peso != 0) {
                        $("#peso").html(selected.peso + ' lb');
                    } else {
                        $("#peso").html('No registrado');
                    }



                    if (selected.activo) {
                        estado = "Activo";
                    } else {
                        estado = "Inactivo";
                    }
                    $("#estado").html(estado);
                }
            });
        }


        function calcularEdad(fecha) {
            var hoy = new Date();
            var cumpleanos = new Date(fecha);
            var edad = hoy.getFullYear() - cumpleanos.getFullYear();
            var m = hoy.getMonth() - cumpleanos.getMonth();
            if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                edad--;
            }
            return edad;
        }
    </script>
    <?php
    $idbuscado =  "<script>document.write(localStorage.getItem('id'));</script>";
    echo $identificador;
    ?>

    <?php

    if (isset($_SESSION['AM'])) {
        if ($_SESSION['AM'] == 1) { ?>
            <script>
                toastr.options.timeOut = 2000; //1.5s
                toastr.options.closeButton = true;
                toastr.remove();
                toastr.success('El miembro fue registrado con exito!');
            </script>
        <?php
                unset($_SESSION['AM']);
            } else if ($_SESSION['AM'] == 2) { ?>
            <script>
                toastr.options.timeOut = 2000; //1.5s
                toastr.options.closeButton = true;
                toastr.remove();
                toastr.error('Ah ocurrido un Error al registrar el miembro');
            </script>
    <?php
            unset($_SESSION['AM']);
        }
    }
    ?>
    <script src="js/bootstrap-autocomplete.min.js"></script>
    <script>
        <?php
        include_once '../boundary/estado.php';
        include_once '../boundary/tipo_membresia.php';
        $facadeEstado = new estado;
        $facadeTipoMembrecia = new tipo_membresia;
        ?>
        var estados = <?php echo json_encode($facadeEstado->findAll()); ?>;
        var tipoMembrecias = <?php echo json_encode($facadeTipoMembrecia->getAllTipoMembresia()); ?>;

        function findEstado(idEstado) {
            for (e of estados) {
                if (e.id_estado == idEstado) {
                    return e;
                }
            }
        }

        function findTipoMebresia(idTipoMebrecia) {
            for (tm of tipoMembrecias) {
                if (tm.id_tipo_membresia == idTipoMebrecia) {
                    return tm;
                }
            }
        }

        $('#buscador').autoComplete({
            minLength: 1,
            noResultsText: "Sin resultados",
            events: {
                searchPost: function(resultFromServer) {
                    var txt = $('#buscador').val();
                    var list = searchList(txt);
                    var formatList = [];
                    $.each(list, function(key, value) {
                        var text = value.primer_nombre + " " + value.segundo_nombre + " " + value.primer_apellido + " " + value.segundo_apellido + " - " + value.usuario;
                        var item = {
                            "value": value.id_miembro,
                            "text": text
                        };
                        formatList.push(item);
                    });
                    return formatList;
                }
            }
        });
        $('#buscador').on('autocomplete.select', function(evt, item) {
            cargarDatos(item.value);
        });

        function searchList(txt) {
            var id_empleado = <?php echo $_SESSION['idEmpleado']; ?>;
            //var txt = $('#buscador').val();
            var list = [];
            $.ajax({
                type: "POST",
                async: false,
                url: "../controller/miembroController.php?filtrar=true",
                data: JSON.stringify({
                    "id_empleado": id_empleado,
                    "txt": txt
                }),
                success: function(data) {
                    var response = jQuery.parseJSON(data);
                    if (typeof response.code !== 'undefined') {
                        toastr.error(response.message);
                    } else {
                        list = response;
                    }
                }
            });
            return list;
        }

        $('#btn_buscar').click(function() {
            var txt = $('#buscador').val();
            updateTable(txt, 0);
        });

        function updateTable(txt, id_estado) {
            var listTable = searchList(txt);
            if (listTable.length > 0) {
                //Vaciar la tabla
                var tabla = $("#table_body");
                tabla.html("");
                //Llenar la tabla
                $.each(listTable, function(key, value) {
                    if (value.id_estado == id_estado || id_estado == 0) {
                        var tr = createTableRowWith(value);
                        tabla.append(tr);
                    }
                });
                eventoSeleccionar();
            } else if (listTable == false && txt.length > 0) {
                toastr.warning('No se han encontrado resultados');
            }
        }

        function createTableRowWith(value) {
            var tr = document.createElement("tr");
            tr.id = value.id_miembro;
            tr.classList.add("filas");
            var td1 = document.createElement("th");
            var img = document.createElement("img");
            var td2 = document.createElement("td");
            var td3 = document.createElement("td");
            var td4 = document.createElement("td");
            var td5 = document.createElement("td");
            var td6 = document.createElement("td");
            td1.setAttribute("scope", "row");
            td1.setAttribute("style", "padding-top: 5px; padding-bottom: 5px;");
            img.setAttribute("src", "../recursos/fotografias/" + value.foto);
            img.setAttribute("class", "rounded-circle");
            img.setAttribute("width", "50");
            img.setAttribute("height", "50");
            img.setAttribute("alt", value.usuario);
            img.setAttribute("title", value.usuario);
            td1.append(img);
            td2.setAttribute("style", "padding-top: 17px;");
            td2.innerText = value.primer_nombre + " " + value.primer_apellido;
            td3.setAttribute("style", "padding-top: 17px;");
            td3.innerText = value.telefono;
            td4.setAttribute("style", "padding-top: 17px;");
            var tm = findTipoMebresia(value.id_tipo_membresia);
            if (typeof tm === 'undefined') {
                td4.innerText = "Ninguna";
            } else {
                td4.innerText = tm.nombre;
            }
            td5.setAttribute("style", "padding-top: 17px;");
            td5.innerText = value.fecha_inicio;
            td6.setAttribute("style", "padding-top: 17px;");
            var estado = findEstado(value.id_estado);
            td6.innerText = estado.nombre;
            tr.append(td1, td2, td3, td4, td5, td6);
            return tr;
        }

        $(document).ready(function() {
            //Cuando cargue la pagina buscar todos con el filtro vacio
            updateTable("", 0);
            cargarEstados();
        });

        function lettersOnly(e) {
            if (String.fromCharCode(e.which).match(/^[A-Za-z0-9 \x08]$/)) {
                return true;
            }
            return false;
        }

        function cargarEstados() {
            $('#estado_opciones').html('');
            var allBtn = document.createElement("button");
            allBtn.setAttribute("class", "dropdown-item");
            allBtn.setAttribute("type", "button");
            allBtn.innerText = "Todos";
            allBtn.setAttribute("onclick", "updateTable('', 0)");
            $('#estado_opciones').append(allBtn);
            for (e of estados) {
                var button = document.createElement("button");
                button.setAttribute("class", "dropdown-item");
                button.setAttribute("type", "button");
                button.innerText = e.nombre;
                button.setAttribute("onclick", "updateTable('','" + e.id_estado + "')");
                $('#estado_opciones').append(button);
            }
        }

        $('#buscador').keypress(function(e) {
            if (e.which == 13) {
                $('#btn_buscar').click();
            }
        });
    </script>

    <script>
        /*
        $('#miembrosOptions').hover(function() {
            $('#navbarDropdownMiembros').trigger('click')
        })

        $('#cuentaOptions').hover(function() {
            $('#navbarDropdownCuenta').trigger('click')
        })
        $('#empleadosOptions').hover(function() {
            $('#empleados').trigger('click')
        })
        */
    </script>
</body>

</html>