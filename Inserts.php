<?php
include_once dirname(__FILE__) . '../../config.php';
$con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);

if (CRYPT_SHA512 == 1){
    $hash1 = crypt('juanm', 'saltMeloParaPasswords');
    $hash2 = crypt('danielam', 'saltMeloParaPasswords');
}else{
    echo "SHA-512 no esta soportado.";
}

$sql = "INSERT INTO Personas (Cedula, Nombre, Apellido, Email) VALUES (12345, 'Juan D', 'Vera P', 'juanm@gmail.com');
        INSERT INTO Usuarios (NombreUsuario, Rol, Contrasena, Cedula) VALUES ('juanm', 'medico', \"$hash1\", 12345);

        INSERT INTO Personas (Cedula, Nombre, Apellido, Email) VALUES (67890, 'Daniela A', 'Vera P', 'danielam@gmail.com');
        INSERT INTO Usuarios (NombreUsuario, Rol, Contrasena, Cedula) VALUES ('danielam', 'medico', \"$hash2\", 67890);
        
        INSERT INTO Habitaciones (Numero) VALUES (901);
        INSERT INTO Habitaciones (Numero) VALUES (902);

        INSERT INTO Camas (Habitacion) VALUES (1);
        INSERT INTO Camas (Habitacion) VALUES (1);
        INSERT INTO Camas (Habitacion) VALUES (2);
        INSERT INTO Camas (Habitacion) VALUES (2);
        
        INSERT INTO Pacientes (Nombre, Apellido, Prioridad, Medico, Cama) VALUES ('Juanito', 'Camachutra', 3, 12345, 1);
        INSERT INTO Pacientes (Nombre, Apellido, Prioridad, Medico, Cama) VALUES ('JuCami', 'Deschaflo', 2, 12345, 2);
        INSERT INTO Pacientes (Nombre, Apellido, Prioridad, Medico, Cama) VALUES ('Juliancho', 'Stop', 1, 12345, 3);

        INSERT INTO Pacientes (Nombre, Apellido, Prioridad, Medico, Cama) VALUES ('Rien', 'Sptm', 2, 67890, 4);

        ";
if (mysqli_multi_query($con, $sql)) {
    echo "Inserts hechos correctamente";
} else {
    echo "Error en la creacion " . mysqli_error($con);
}

?>