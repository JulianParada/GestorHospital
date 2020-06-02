<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <title>Menú Principal</title>
    </head>
    <body>
        <?php
            include_once dirname(__FILE__) . '../../config.php';

            $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
            if (mysqli_connect_errno()) {
                echo "Error en la conexión: " . mysqli_connect_error();
            }

            if(isset($_POST['iniciarsesion'])){

                $usuario = $_POST['Usuario'];
                $password = $_POST['Contrasena'];

                $verify = "SELECT * FROM Usuarios WHERE NombreUsuario = \"$usuario\" ";
                $res = mysqli_query($con, $verify);
                $exists = mysqli_num_rows($res);

                if($_POST['Usuario'] != '' && $_POST['Contrasena'] != ''){
                    if($exists > 0){

                        $fila = mysqli_fetch_array($res);
                        $rol = $fila['Rol'];
                        $hashBD = $fila['Contrasena'];
                        $cedula = $fila['Cedula'];
                
                        if (hash_equals($hashBD, crypt($password, $hashBD))) {
                            
                            if($rol == "medico"){

                                $str_datos = "<div class=\"container-fluid bg-dark text-white\">
                                                <h1 align=\"center\">Menú Principal Médico</h1>
                                                <div class=\"row alert alert-success\" align=\"center\">
                                                    <div class=\"col\">
                                                        <form action='verPacientes.php' method='post'>
                                                            <div class=\"col\">
                                                                <button type=\"submit\" value='$cedula' name='verPacientes' class=\"btn btn-info btn-lg btn-block\" style=\"margin-bottom: 1vw; margin-top: 1vw;\">
                                                                    Ver Pacientes
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <form action='verHabitaciones.php' method='post'>
                                                            <div class=\"col\">
                                                                <button type=\"submit\" value='$cedula' name='verHabitaciones' class=\"btn btn-info btn-lg btn-block\" style=\"margin-bottom: 1vw; margin-top: 1vw;\">
                                                                    Ver Habitaciones
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>  
                                            </div>";
                                echo $str_datos;
                
                            }else if($rol == "administrador"){

                                $str_datos = "<div class=\"container-fluid bg-dark text-white\">
                                                <h1 align=\"center\">Menú Principal Administrador</h1>
                                                <div class=\"row alert alert-success\" align=\"center\">
                                                    <div class=\"col\">
                                                        <form action='agregarAdmin.php' method='post'>
                                                            <div class=\"col\">
                                                                <button type=\"submit\" value='' name='agregarAdmin' class=\"btn btn-info btn-lg btn-block\" style=\"margin-bottom: 1vw; margin-top: 1vw;\">
                                                                    Agregar nuevo administrador
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <form action='agregarHabitacion.php' method='post'>
                                                            <div class=\"col\">
                                                                <button type=\"submit\" value='' name='agregarHabitacion' class=\"btn btn-info btn-lg btn-block\" style=\"margin-bottom: 1vw; margin-top: 1vw;\">
                                                                    Agregar Habitación
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <form action='agregarCama.php' method='post'>
                                                            <div class=\"col\">
                                                                <button type=\"submit\" value='' name='agregarCama' class=\"btn btn-info btn-lg btn-block\" style=\"margin-bottom: 1vw; margin-top: 1vw;\">
                                                                    Agregar Cama
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <form action='verPacientesAdmin.php' method='post'>
                                                        <div class=\"col\">
                                                            <button type=\"submit\" value='' name='verPacientesAdmin' class=\"btn btn-info btn-lg btn-block\" style=\"margin-bottom: 1vw; margin-top: 1vw;\">
                                                                Visualizar pacientes
                                                            </button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>  
                                            </div>";
                                echo "".$str_datos;
                            }
                            echo "<a class=\"btn btn-info\" href=\"login.php\">Cerrar Sesión</a>";
                
                        } else {
                            echo "<h2>Contraseña Incorrecta</h2>";
                            echo "<br>";
                            echo "<a class=\"btn btn-info\" href=\"login.php\">Regresar</a>";
                        }
                
                    }else{
                        echo "<h2>No existe el nombre de usuario</h2>";
                        echo "<br>";
                        echo "<a class=\"btn btn-info\" href=\"login.php\">Regresar</a>";
                    }
                }else{
                    header ("Location: login.php");
                }
            }
        
            if(isset($_POST['nuevoAdmin'])){
                if($_POST['user'] != '' && $_POST['email1'] != '' && $_POST['email2'] != '' 
                    && $_POST['contrasena'] != '' && $_POST['nombre'] != '' && $_POST['apellido'] != '' 
                    && $_POST['cedula'] != ''){

                    $usuario = $_POST['user'];
                    $email1 = $_POST['email1'];
                    $email2 = $_POST['email2'];
                    $password = $_POST['contrasena'];
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $cedula = $_POST['cedula'];

                    if($email1 === $email2){
                        $verify = "SELECT * FROM Personas WHERE Cedula = \"$cedula\" ";
                        $res = mysqli_query($con, $verify);
                        $exists = mysqli_num_rows($res);

                        if($exists == 0){
                            $verify2 = "SELECT * FROM Usuarios WHERE NombreUsuario = \"$nombre\" ";
                            $res2 = mysqli_query($con, $verify2);
                            $exists2 = mysqli_num_rows($res2);

                            if($exists2 > 0){
                                echo "<h2>No se puede regitrar al Administrador, el nombre de usuario ya existe</h2>";
                            }else{
                                $rol = "administrador";

                                if (CRYPT_SHA512 == 1){
                                    $hash = crypt($password, 'saltMeloParaPasswords');
                                }else{
                                    echo "SHA-512 no esta soportado.";
                                }

                                $sql1 = "INSERT INTO Personas (Cedula, Nombre, Apellido, Email) VALUES (\"$cedula\", \"$nombre\", \"$apellido\", \"$email1\")";
                                $sql2 = "INSERT INTO Usuarios (NombreUsuario, Rol, Contrasena, Cedula) VALUES (\"$usuario\", \"$rol\", \"$hash\", \"$cedula\")";
                                
                                if(mysqli_query($con, $sql1)){
                                    if(mysqli_query($con, $sql2)){
                                        echo "<h2>Administrador registrado correctamente.</h2>";
                                    }
                                }
                            }

                        }else{
                            echo "<h2>No se puede registrar al Administrador, ya se encuentra en el sistema.</h2>";
                            echo "<br>";
                            echo "<a class=\"btn btn-info\" href=\"agregarAdmin.php\">Regresar</a>";
                        }
                    }else{
                        echo "<h2>Error, los correos electronicos no coinciden</h2>";
                        echo "<br>";
                        echo "<a class=\"btn btn-info\" href=\"agregarAdmin.php\">Regresar</a>";
                    }
                }else{
                    echo "<h2>Datos Incorrectos.</h2>";
                    echo "<br>";
                    echo "<a class=\"btn btn-info\" href=\"agregarAdmin.php\">Regresar</a>";
                }
            }

            if(isset($_POST['registrarmedico'])){

                if($_POST['user'] != '' && $_POST['email1'] != '' && $_POST['email2'] != '' 
                    && $_POST['contrasena'] != '' && $_POST['nombre'] != '' && $_POST['apellido'] != '' 
                    && $_POST['cedula'] != ''){

                    $usuario = $_POST['user'];
                    $email1 = $_POST['email1'];
                    $email2 = $_POST['email2'];
                    $password = $_POST['contrasena'];
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $cedula = $_POST['cedula'];

                    if($email1 === $email2){
                        $verify = "SELECT * FROM Personas WHERE Cedula = \"$cedula\" ";
                        $res = mysqli_query($con, $verify);
                        $exists = mysqli_num_rows($res);

                        if($exists == 0){
                            $verify2 = "SELECT * FROM Usuarios WHERE NombreUsuario = \"$nombre\" ";
                            $res2 = mysqli_query($con, $verify2);
                            $exists2 = mysqli_num_rows($res2);

                            if($exists2 > 0){
                                echo "<h2>No se puede regitrar al medico, el nombre de usuario ya existe</h2>";
                            }else{
                                $rol = "medico";

                                if (CRYPT_SHA512 == 1){
                                    $hash = crypt($password, 'saltMeloParaPasswords');
                                }else{
                                    echo "SHA-512 no esta soportado.";
                                }

                                $sql1 = "INSERT INTO Personas (Cedula, Nombre, Apellido, Email) VALUES (\"$cedula\", \"$nombre\", \"$apellido\", \"$email1\")";
                                $sql2 = "INSERT INTO Usuarios (NombreUsuario, Rol, Contrasena, Cedula) VALUES (\"$usuario\", \"$rol\", \"$hash\", \"$cedula\")";
                                
                                if(mysqli_query($con, $sql1)){
                                    if(mysqli_query($con, $sql2)){
                                        echo "<h2>Médico registrado correctamente.</h2>";
                                    }
                                }
                            }

                        }else{
                            echo "<h2>No se puede registrar al medico, ya se encuentra en el sistema.</h2>";
                            echo "<br>";
                            echo "<a class=\"btn btn-info\" href=\"RegistroMedico.php\">Regresar</a>";
                        }
                    }else{
                        echo "<h2>Error, los correos electronicos no coinciden</h2>";
                        echo "<br>";
                        echo "<a class=\"btn btn-info\" href=\"RegistroMedico.php\">Regresar</a>";
                    }
                }else{
                    echo "<h2>Datos Incorrectos.</h2>";
                    echo "<br>";
                    echo "<a class=\"btn btn-info\" href=\"RegistroMedico.php\">Regresar</a>";

                }
            }

            if(isset($_POST['agregarHabitacion'])){

                if(isset($_POST['numeroHabitacion']) != ''){
                    $numeroHabitacion = $_POST['numeroHabitacion'];
                    $sql = "SELECT * FROM HABITACIONES WHERE NUMERO = \"$numeroHabitacion\" "; 
                    $res = mysqli_query($con, $sql);
                    $exists = mysqli_num_rows($res);

                    if($exists == 0 ){
                        $sql2 ="INSERT INTO HABITACIONES (NUMERO) VALUES (\"$numeroHabitacion\")";
                        if(mysqli_query($con, $sql2)){
                            echo '<h2>Habitación creada</h2><br>';
                            echo '<a class=\"btn btn-info\" href="Operaciones.php>Regresar</a>"';
                        }
                    }
                    else{
                        echo "<h2>No se puede crear la habitación $numeroHabitacion, ya se encuentra en el sistema.</h2>";
                        echo "<br>";
                        echo "<a class=\"btn btn-info\" href=\"agregarHabitacion.php\">Regresar</a>";
                    }
                }
                else{
                    echo "<h2>Datos Incorrectos.</h2>";
                    echo "<br>";
                    echo "<a class=\"btn btn-info\" href=\"agregarHabitacion.php\">Regresar</a>";
                }
            }

            if(isset($_POST['agregarCama'])){

                if(isset($_POST['habitacion']) != ''){
                $habitacion = $_POST['habitacion'];
                
                    $sql2 ="INSERT INTO CAMAS (HABITACION) VALUES (\"$habitacion\")";
                    if(mysqli_query($con, $sql2)){
                        echo "<h2>Cama agregada a la habitación</h2><br>";
                        echo '<a class=\"btn btn-info\" href="Operaciones.php>Regresar</a>"';
                    }
                }
                else{
                echo "<h2>Datos Incorrectos.</h2>";
                echo "<br>";
                echo "<a class=\"btn btn-info\" href=\"agregarHabitacion.php\">Regresar</a>";
                }
                
            }

            if(isset($_GET['idPaciente']) && isset($_GET['idInventario'])){
                
                $idPaciente = $_GET['idPaciente'];
                $idInventario = $_GET['idInventario'];

                $sqlDelete = "DELETE FROM PacientesXInventario WHERE Paciente = \"$idPaciente\" AND Item = \"$idInventario\";
                UPDATE Inventario set Cantidad = Cantidad + 1 where Id =\"$idInventario\"";

                if (mysqli_multi_query($con, $sqlDelete)) {
                    echo "<h2>Equipo Eliminado correctamente.</h2>";
                    echo "<br>";
                    echo '<a class="btn btn-info" href=\'singlePaciente.php?cc='.$idPaciente.'\'>'. 'Regresar' . '</a>';
                } 
                else {
                    echo "Error al borrar el equipo" . mysqli_error($con);
                }
            }

            if(isset($_POST['asignarPaciente'])){
                $cedulaPaciente = $_POST['cedulaPaciente'];
                $nombrePaciente = $_POST['nombrePaciente'];
                $apellidoPaciente = $_POST['apellidoPaciente'];
                $diagnosticoPaciente = $_POST['diagnosticoPaciente'];
                $prioridadPaciente = $_POST['prioridadPaciente'];
                $fechaPaciente = date('Y-m-d',strtotime($_POST['fechaPaciente']));
                $duracionPaciente = $_POST['duracionPaciente'];
                $idCamaPaciente = $_POST['idCamaPaciente'];
                $idMedicoPaciente = $_POST['idMedicoPaciente'];

                $sqlInsertPaciente = "INSERT INTO PACIENTES
                (Nombre,
                Apellido,
                Cedula,
                Duracion,
                Diagnostico,
                FechaIngreso,
                Prioridad,
                Medico,
                Cama)
                Values (\"$nombrePaciente\",
                \"$apellidoPaciente\",
                \"$cedulaPaciente\",
                \"$duracionPaciente\",
                \"$diagnosticoPaciente\",
                \"$fechaPaciente\",
                \"$prioridadPaciente\",
                \"$idMedicoPaciente\",
                \"$idCamaPaciente\");
                UPDATE CAMAS SET Estado = \"Ocupado\" WHERE ID = \"$idCamaPaciente\";";

                if (mysqli_multi_query($con, $sqlInsertPaciente)) {
                    echo "<h2>Paciente Asignado</h2>";
                    echo "<br>";
                } 
                else {
                    echo "Error al Asignar el paciente" . mysqli_error($con);
                }
            }

            if(isset($_POST['agregarRecursoPaciente'])){

                $nrecurso = $_POST['recurso'];
                $crecurso = $_POST['cantidadRe'];
                $idp = $_POST['idpac'];
                $idmed = $_POST['idmed'];
                $fyh = $_POST['fyh'];

                $sqlPaciente = "SELECT * FROM PACIENTES WHERE Idp = \"$idp\"";
                $resPaciente = mysqli_query($con,$sqlPaciente);
                $filaPaciente = mysqli_fetch_array($resPaciente);
                $cedulap = $filaPaciente['Cedula'];

                $sqlSuministro = "SELECT * FROM Inventario WHERE Nombre = \"$nrecurso\"";
                $resSuministro = mysqli_query($con,$sqlSuministro);
                $filaSuministro = mysqli_fetch_array($resSuministro);
                $idsum = $filaSuministro['Id'];

                // echo ' '.$cedulap.' '.$idp.' '.$idmed.' '.$fyh.' '.$idsum.' '.$crecurso;

                $sqlSolicitud = "INSERT INTO Solicitudes (IdSolicitud, Paciente, Medico, FechaSolicitud, Suministro, Cantidad, Estado)
                                VALUES (\"$cedulap\", \"$idp\", \"$idmed\", \"$fyh\", \"$idsum\", \"$crecurso\", 'No aprovado')";

                if (mysqli_query($con, $sqlSolicitud)) {
                    echo "<h2>Recurso agregado a la solicitud</h2>";
                    echo "<br>";
                    echo "<a class=\"btn btn-info\" href=\"agregarRecursos.php?cc=".$idp."&ccm=".$idmed."\">Regresar y agregar mas recursos</a>";
                } 
                else {
                    echo "Error al Asignar el paciente" . mysqli_error($con);
                }
            }
        ?>
    </body>
</html>