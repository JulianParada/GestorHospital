<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cama</title>
</head>
<body>
    <div>
        <form action="Operaciones.php" method="post">
            <?php
                include_once dirname(__FILE__) . '../../config.php';
                include_once dirname(__FILE__) . '/utils.php';

                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
                if (mysqli_connect_errno()) {
                    echo "Error en la conexión: " . mysqli_connect_error();
                }

                $sql ="SELECT * FROM HABITACIONES";
                $res = mysqli_query($con, $sql);
                $exists = mysqli_num_rows($res);
                if($exists > 0){
                    $habitaciones = array();
                    while($fila = mysqli_fetch_array($res)){
                        $habitaciones["'".$fila['Id']."'"] = $fila['Numero'];
                    }
                    $selectHabitaciones = crearSelect('Habitacion', 'habitacion',$habitaciones);
                    echo $selectHabitaciones;
                }
                else{
                    echo "No hay habitaciones disponibles, inserte una habitacion primero";
                    echo "<br>";
                    echo "<a href=\"Operaciones.php\">Regresar</a>";
                }
            ?>

            <button type = "submit" name="agregarCama" >Agregar Cama</button>
        </form>
    </div>
</body>
</html>