<!DOCTYPE html>

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/main.css">
    </head>
    <body>
        <h1>Formulario de registro</h1>
        <div class="errores">
            <?php
            include '../modules/modulos.php';

            RecogerDatos();
            ?>
        </div>

        <form action='registro.php' method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre"><br><br>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email"><br><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password"><br><br>

            <label for="password">Repetir Contraseña:</label>
            <input type="password" id="password2" name="password2"><br><br>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion"><br><br>

            <input type="submit" name="submit" value="Enviar">

            <button> <a href="login.php">Iniciar sesion </a></button>


        </form> 



    </body>
</html>

