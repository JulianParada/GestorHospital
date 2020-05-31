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
    
                    echo "Medico logueado";
    
                }else if($rol == "administrador"){

                    echo "Administrador Logueado";
                }
    
                echo "<br>";
                echo "<a href=\"login.php\">Cerrar Cesion</a>";
    
            } else {
                echo "Contraseña Incorrecta :(";
                echo "<br>";
                echo "<a href=\"login.php\">Regresar</a>";
            }
    
        }else{
            echo "No existe el nombre de usuario";
            echo "<br>";
            echo "<a href=\"login.php\">Regresar</a>";
        }
    }else{
        header ("Location: login.php");
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
                    echo "No se puede regitrar al medico, el nombre de usuario ya existe";
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
                            echo "Medico registrado correctamente.";
                        }
                    }
                }

            }else{
                echo "No se puede registrar al medico, ya se encuentra en el sistema.";
                echo "<br>";
                echo "<a href=\"RegistroMedico.php\">Regresar</a>";
            }
        }else{
            echo "Error, los correos electronicos no coinciden";
            echo "<br>";
            echo "<a href=\"RegistroMedico.php\">Regresar</a>";
        }
    }else{
        echo "Datos Incorrectos.";
        echo "<br>";
        echo "<a href=\"RegistroMedico.php\">Regresar</a>";

    }
}
?>