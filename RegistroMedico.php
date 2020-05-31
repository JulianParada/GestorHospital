<!DOCTYPE html>
<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. createTable.php
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title> Registrar Medico </title>
        <h1>Registrar Medico</h1>
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
	    <input type="submit" value='Registrarse' name='registrarmedico'>
        </form>
        <br>
    </div>

    <br>
    <a href="Login.php">Regresar</a>

    </body>
</html>