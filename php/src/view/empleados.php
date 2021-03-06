<?php
session_start();
include_once '../boundary/empleado.php';
$login = new empleado();
$login->ValidateSession();
if ($_SESSION['tipoEmpleado'] != 1) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Empleados</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/toastr.css">
    <link rel="icon" type="image/png" href="img/icono.png">
    <style>
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
            background-color:#fbfbfb;
        }
    </style>
</head>

<body>
    <?php include_once("navbar.php"); ?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <br>
            <button id="btn_editar" type="button" data-target="#editarModal" data-toggle="modal" class="btn btn-info float-right" title="Seleccione un Empleado" disabled="true">Editar Empleado</button>
            <button id="btn_eliminarModal" type="button" data-target="#eliminarModal" data-toggle="modal" class="btn btn-secondary float-right mr-2" title="Seleccione un Empleado" disabled="true">Eliminar Empleado</button>
            <table class="table text-center table-striped table-hover">
                <thead class="thead-dark text-center">
                    <tr>
                        <th colspan="7">
                            <h5>Empleados registrados en el sistema</h5>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">Usuario</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Coreo</th>
                        <th scope="col">Tel&eacute;fono</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Puesto</th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    <tr>
                        <td colspan="7" class="text-center text-secondary">No se encontraron empleados</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Editar Trabajador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_editar" class="needs-validation" autocomplete="off">
                        <div class="form-group row">
                            <label for="usuario" class="col-sm-4 col-form-label">ID:</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="id_empleado" name="id_empleado" placeholder="ID..." onDrag="return false" onDrop="return false" onPaste="return false" readonly="readonly" required />
                                <div class="invalid-feedback">
                                    ID no valido
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tipoEmpleado" class="col-sm-4 col-form-label">Tipo Empleado:</label>
                            <div class="col-sm-8">
                                <select id="id_tipo_empleado" name="id_tipo_empleado" class="form-control" required>
                                    <!--option>EJEMPLO</option-->
                                    <?php
                                    include_once '../boundary/tipo_empleado.php.php';
                                    $te = new tipo_empleado();
                                   
                                    $tiposEmpleados = $te->getAllTipoEmpleado();
                                    if (!is_null($tiposEmpleados)) {
                                        foreach ($tiposEmpleados as $tipoEmpleado) {
                                            echo "<option value='" . $tipoEmpleado["id_tipo_empleado"] . "'>" . $tipoEmpleado["nombre"] . "</option>";
                                        }
                                    } else {
                                        echo "<option disabled>No se encontraron resultados</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="usuario" class="col-sm-4 col-form-label">Usuario:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="usuario" name="usuario" maxlength="32" placeholder="Usuario..." onDrag="return false" onDrop="return false" onPaste="return false" onkeypress="return username(event);" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombres" class="col-sm-4 col-form-label">Primer Nombre:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" maxlength="32" placeholder="Primer Nombre..." onDrag="return false" onDrop="return false" onPaste="return false" onkeypress="return notNumbers(event);" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombres" class="col-sm-4 col-form-label">Segundo Nombre:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" maxlength="64" placeholder="Segundo Nombre..." onDrag="return false" onDrop="return false" onPaste="return false" onkeypress="return notNumbers(event);" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apellidos" class="col-sm-4 col-form-label">Primer Apellido:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" maxlength="32" placeholder="Primer Apellido..." onDrag="return false" onDrop="return false" onPaste="return false" onkeypress="return notNumbers(event);" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apellidos" class="col-sm-4 col-form-label">Apellidos:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" maxlength="32" placeholder="Segundo Apellido..." onDrag="return false" onDrop="return false" onPaste="return false" onkeypress="return notNumbers(event);" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="correo" class="col-sm-4 col-form-label">Correo:</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="correo" name="correo" maxlength="64" placeholder="Correo..." onDrag="return false" onDrop="return false" onPaste="return false" required />
                            </div>
                        </div>
                        <div id="changePassDiv" class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Contraseña:</label>
                            <div class="col-sm-8">
                                <button id="btn_password" type="button" class="btn btn-warning" title="Sustituirá la contraseña actual por una nueva">Cambiar Contraseña</button>
                            </div>
                        </div>
                        <div id="passDiv" class="form-group row d-none">
                            <label for="password" class="col-sm-4 col-form-label">Contraseña:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" name="password" maxlength="60" placeholder="Contraseña..." onDrag="return false" onDrop="return false" onPaste="return false" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="genero" class="col-sm-4 col-form-label">Genero:</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="genero" id="genero" value="1" />
                                    <label class="form-check-label" for="genero">Hombre</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="genero" id="genero2" value="0" />
                                    <label class="form-check-label" for="genero2">Mujer</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-sm-4 col-form-label">Telefono:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="8" placeholder="Telefono..." onDrag="return false" onDrop="return false" onPaste="return false" onkeypress="return justNumbers(event);" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fecha_nacimiento" class="col-sm-4 col-form-label">Fecha Nacimiendo:</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="date" value="" id="fecha_nacimiento" name="fecha_nacimiento" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button id="btn_guardar" type="submit" class="btn btn-info">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="eliminarInfo" class="modal-body">
                    Mensaje
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_eliminar" class="btn btn-info">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jQuery-3-4.1.min.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/toastr.js"></script>
    <script>
        var selectedEmpleado = null;
        /*
        NOTA: EL id_empleado NO ES LA FORMA MAS CONVENIENTE PARA DETERMINAR SI
        EL EMPLEADO ES DE TIPO ADMINISTRADOR POR CUESTIONES DE SEGURIDAD, CUALQUIERA
        PODRIA REPLICAR UN ID DIFERENTE PARA CAMBIARSE PERMISOS.
        PROBLEMAS: OBTENER $_SESSION['tipoEmpleado'] CAUSARA PROBLEMAS A LA HORA DE
        QUE SE MODIFIQUE DETERMINAR EMPLEADO DADO, QUE LA ASIGNACION SOLO OCURRE AL
        INICIAR SESION Y QUE $_SESSION['tipoEmpleado'] SOLO PUEDE SER MODIFICADA CON PHP.
        -PARA CORREGIR ESTO SE DEBE CREAR UNA KEY POR USUARIO QUE PERMITA ESTOS ACCESOS.
        -OTRA FORMA SERIA SOLICITAR Y ENVIAR LA CONTRASEÑA PARA COMPROBAR DESDE EL CONTROLLER.
        */
        var id_empleado = <?php echo $_SESSION['idEmpleado']; ?>;

        //Funcion para cargar la tabla
        function updateTable() {
            //NOTA BUSCAR FORMA DE OBTENER EL id_empleado de la Session
            $.ajax({
                type: "POST",
                url: "../controller/empleadoController.php?allEmpleados=true",
                data: JSON.stringify({
                    "id_empleado": id_empleado
                }),
                success: function(data) {
                    var response = jQuery.parseJSON(data);
                    if (typeof response.code !== 'undefined') {
                        toastr.error(response.message);
                    } else {
                        //Vaciar la tabla
                        $("#table_body").html("");
                        //Lenar la tabla
                        jQuery.each(response, function(i, val) {
                            edad = calcularEdad(val.fecha_nacimiento);
                            var tr =
                                "<tr id='" + val.usuario + "' data-id_empleado='" + val.id_empleado + "'>" +
                                "<td>" + val.usuario + "</td>" +
                                "<td>" + val.primer_nombre + ' ' + val.segundo_nombre + "</td>" +
                                "<td>" + val.primer_apellido + ' ' + val.segundo_apellido + "</td>" +
                                "<td>" + val.correo + "</td>" +
                                "<td>" + val.telefono + "</td>" +
                                "<td>" + edad+ " años</td>" +
                                "<td>" + val.nombre_puesto + "</td>" +
                                "</tr>";
                            $("#table_body").append(tr);
                        });
                        //Agregar Evento de click por cada item de la tabla
                        eventoSeleccionar();
                    }
                }
            });
        }
        //Funcion para evento de click a una fila
        function eventoSeleccionar() {
            //Evento del click de un tr obteniendo su id_empleado del atributo data-id_empleado
            $("#table_body tr").click(function() {
                //Agregar color hover del mouse a la tabla
                $(this).addClass('table-info').siblings().removeClass('table-info');
                //Variable selectedEmpleado contiene el id_empleado
                selectedEmpleado = jQuery.parseJSON($(this).attr("data-id_empleado"));
                $.ajax({
                    type: "POST",
                    url: "../controller/empleadoController.php?findEmpleado=true",
                    data: JSON.stringify({
                        "id_empleado": id_empleado,
                        "find_id_empleado": selectedEmpleado
                    }),
                    success: function(data) {
                        var response = jQuery.parseJSON(data);
                        if (typeof response.code !== 'undefined') {
                            toastr.error(response.message);
                        } else {
                            //selectedEmpleado se convierte en el objeto completo
                            selectedEmpleado = response;
                            //Cargamos el formulario modal con los datos del objeto
                            cargarDatos(selectedEmpleado);
                        }
                    }
                });


            });
        }

        function cargarDatos(selectedEmpleado) {
            $("#btn_editar").prop('disabled', false);
            $("#btn_eliminarModal").prop('disabled', false);
            if (selectedEmpleado !== null) {
                $("#id_empleado").val(selectedEmpleado.id_empleado);
                $("#id_tipo_empleado").val(selectedEmpleado.id_tipo_empleado);
                $("#usuario").val(selectedEmpleado.usuario);
                $("#primer_nombre").val(selectedEmpleado.primer_nombre);
                $("#segundo_nombre").val(selectedEmpleado.segundo_nombre);
                $("#primer_apellido").val(selectedEmpleado.primer_apellido);
                $("#segundo_apellido").val(selectedEmpleado.segundo_apellido);
                $("#correo").val(selectedEmpleado.correo);
                $("#password").val("");
                $("#genero").prop('checked', selectedEmpleado.genero == 't');
                $("#genero2").prop('checked', selectedEmpleado.genero == 'f');
                $("#telefono").val(selectedEmpleado.telefono);
                $("#fecha_nacimiento").val(selectedEmpleado.fecha_nacimiento);
            } else {
                alert("Usuario Invalido");
            }
        }

        function restablecerSeleccion() {
            $("#editarModal").modal('hide');
            $("#eliminarModal").modal('hide');
            $("#btn_editar").prop('disabled', true);
            $("#btn_eliminarModal").prop('disabled', true);
        }

        //Al Carga el documento cargar la tabla
        $(document).ready(function() {
            //Cargar Tabla
            updateTable();
        });

        $("#btn_editar").click(function() {
            $("#passDiv").addClass('d-none');
            $("#changePassDiv").removeClass('d-none');
            $("#password").val("");
            $("#password").prop("disabled", true);
            setTimeout(function() {
                $("#form_editar").valid();
            }, 500);
        });
        $("#btn_password").click(function() {
            $("#passDiv").removeClass('d-none');
            $("#changePassDiv").addClass('d-none');
            $("#password").prop("disabled", false);
        });
        $("#btn_guardar").click(function() {
            if (selectedEmpleado !== null) {
                //Validar campos y Enviar Usuario
                var formIsValid = $("#form_editar").valid();
                var password = $("#password");
                if (!password.prop("disabled") && password.val().length == 0) {
                    toastr.warning("Favor ingrese contraseña nueva");
                    formIsValid = false;
                }

                if (formIsValid) {
                    selectedEmpleado.id_tipo_empleado = $("#id_tipo_empleado").val();
                    selectedEmpleado.usuario = $("#usuario").val();
                    selectedEmpleado.primer_nombre = $("#primer_nombre").val();
                    selectedEmpleado.segundo_nombre = $("#segundo_nombre").val();
                    selectedEmpleado.primer_apellido = $("#primer_apellido").val();
                    selectedEmpleado.segundo_apellido = $("#segundo_apellido").val();
                    selectedEmpleado.correo = $("#correo").val();
                    selectedEmpleado.activo = true;
                    selectedEmpleado.password = $("#password").val();
                    selectedEmpleado.genero = $('#genero').prop('checked');
                    selectedEmpleado.telefono = $("#telefono").val();
                    selectedEmpleado.fecha_nacimiento = $("#fecha_nacimiento").val();
                    $.ajax({
                        type: "POST",
                        url: "../controller/empleadoController.php?editEmpleado=true",
                        data: JSON.stringify(selectedEmpleado),
                        success: function(data) {
                            var response = jQuery.parseJSON(data);
                            if (response.code == 1) {
                                toastr.success(response.message);
                                updateTable();
                                restablecerSeleccion();
                            } else if (response.code == 2) {
                                toastr.error(response.message);
                            }
                        }
                    });
                } else {
                    toastr.warning("Favor complete todos los campos");
                }
            } else {
                alert("No se ha seleccionado un empleado");
            }
        });
        $("#btn_eliminarModal").click(function() {
            if (selectedEmpleado !== null) {
                var name = selectedEmpleado.primer_nombre + " " + selectedEmpleado.segundo_nombre;
                $("#eliminarInfo").text("Desea eliminar a " + name + " de la base de datos?");
            } else {
                alert("No se ha seleccionado un empleado");
            }
        });
        $("#btn_eliminar").click(function() {
            if (selectedEmpleado !== null && selectedEmpleado.id_empleado != null) {
                //Eliminar
                $.ajax({
                    type: "POST",
                    url: "../controller/empleadoController.php?disableEmpleado=true",
                    data: JSON.stringify({
                        "id_empleado": id_empleado,
                        "disable_id_empleado": selectedEmpleado.id_empleado
                    }),
                    success: function(data) {
                        var response = jQuery.parseJSON(data);
                        if (response.code == 1) {
                            toastr.success(response.message);
                            updateTable();
                            restablecerSeleccion();
                        } else if (response.code == 2) {
                            toastr.error(response.message);
                        }
                    }
                });
            } else {
                alert("No se ha seleccionado un empleado");
            }
        });
        jQuery.validator.setDefaults({
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        $("#form_editar").validate({
            rules: {
                "id_empleado": {
                    required: true,
                    minlength: 1,
                    digits: true
                },
                "id_tipo_empleado": {
                    required: true
                },
                "usuario": {
                    required: true,
                    minlength: 3
                },
                "primer_nombre": {
                    required: true,
                    minlength: 3
                },
                "segundo_nombre": {
                    required: true,
                    minlength: 3
                },
                "primer_apellido": {
                    required: true,
                    minlength: 3
                },
                "segundo_apellido": {
                    required: true,
                    minlength: 3
                },
                "correo": {
                    required: true,
                    email: true
                },
                "password": {
                    minlength: 3
                },
                "telefono": {
                    required: true,
                    minlength: 8,
                    digits: true
                }
            },
            messages: {
                "id_empleado": {
                    required: "Campo Requerido",
                    minlength: "Digitos minimos 1",
                    digits: "Solo se permiten numeros"
                },
                "id_tipo_empleado": {
                    required: "Campo Requerido"
                },
                "usuario": {
                    required: "Campo Requerido",
                    minlength: "Digitos minimos 3"
                },
                "primer_nombre": {
                    required: "Campo Requerido",
                    minlength: "Digitos minimos 3"
                },
                "segundo_nombre": {
                    required: "Campo Requerido",
                    minlength: "Digitos minimos 3"
                },
                "primer_apellido": {
                    required: "Campo Requerido",
                    minlength: "Digitos minimos 3"
                },
                "segundo_apellido": {
                    required: "Campo Requerido",
                    minlength: "Digitos minimos 3"
                },
                "correo": {
                    required: "Ingrese correo",
                    email: "Correo invalido"
                },
                "password": {
                    minlength: "Caracteres minimos 3"
                },
                "telefono": {
                    required: "Ingrese numero de telefono",
                    minlength: "Numeros minimos 8",
                    digits: "Solo se permiten Numeros"
                }
            }
        });

        function justNumbers(e) {
            if (String.fromCharCode(e.which).match(/^[0-9\x08]$/)) {
                return true;
            }
            return false;
        }

        function notNumbers(e) {
            if (String.fromCharCode(e.which).match(/^[A-Za-z\x08]$/)) {
                return true;
            }
            return false;
        }

        function username(e) {
            if (String.fromCharCode(e.which).match(/^[A-Za-z0-9\x08]$/)) {
                return true;
            }
            return false;
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