<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Agregar Recursos</title>
</head>
<body>
    <div class="container-fluid">
        <?php 

            include_once dirname(__FILE__) . '../../config.php';

            $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
            if (mysqli_connect_errno()) {
                echo "Error en la conexión: " . mysqli_connect_error();
            }

            $idPaciente = $_GET['cc'];
            $idMedico = $_GET['ccm'];

            $sqlPaciente = "SELECT * FROM PACIENTES WHERE Idp = \"$idPaciente\"";
            $resPaciente = mysqli_query($con,$sqlPaciente);
            $filaPaciente = mysqli_fetch_array($resPaciente);
            $nombrePaciente = $filaPaciente['Nombre'];

            $sqlMedico = "SELECT * FROM USUARIOS INNER JOIN PERSONAS ON USUARIOS.Cedula = PERSONAS.Cedula WHERE USUARIOS.Id = \"$idMedico\" ";
            $resMedico = mysqli_query($con,$sqlMedico);
            $filaMedico = mysqli_fetch_array($resMedico);
            $nombreMedico = $filaMedico['Nombre'];

            $sql = "SELECT * FROM Inventario WHERE Tipo='Enseres' AND Cantidad > 0";
            $res = mysqli_query($con,$sql);
            $exists = mysqli_num_rows($res);

            if($exists > 0) {
                
                echo $nombrePaciente;
                echo $nombreMedico;

            } else {
                echo "No hay recursos disponibles en el sistema";
                echo "<br>";
                echo "<a class=\"btn btn-info\" href=\"Operaciones.php\">Regresar</a>";
    
            }
        ?>


    </div>
</body>
</html>