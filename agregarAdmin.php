<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Administrador</title>
</head>
<body>
    <div>
        <br>
        <form action='Operaciones.php' method='post'>
            <table>
                Usuario: <input type="text" name="user" ><br>
                Email: <input type="email" name="email1" ><br>
                Confirmar Email: <input type="email" name="email2" ><br>
                Contraseña: <input type="password" name="contrasena" ><br>
                Nombre: <input type="text" name="nombre" ><br>
                Apellido: <input type="text" name="apellido" ><br>
                Cedula: <input type="number" name="cedula" ><br>
            </table>
        <input type="submit" value='Agregar Administrador' name='nuevoAdmin'>
        </form>
        <br>
    </div>

    <br>
    <a href="Operaciones.php">Regresar</a>
</body>
</html>