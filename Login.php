<!DOCTYPE html>
<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. createTables.php
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title> Login </title>
        <h1>Login</h1>
    </head>
    <body>

    <div>
        <br>
        <form action='Operaciones.php' method='post'>
	        <table>
                Usuario: <input type="text" name="Usuario"><br>
                Contraseña: <input type="password" name="Contrasena"><br>
	        </table>
        <br>
	    <input type="submit" value='Iniciar Sesion' name='iniciarsesion'>
        </form>
        <br>
    </div>

    <form action='RegistroMedico.php' method='post'>
        <input type="submit" value='Registrar Medico' name='registrarmedico'>
    </form>

    </body>
</html>