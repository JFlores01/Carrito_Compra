
<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/main.css">
    </head>
    <body>
        <h1>Formulario de Inicio de Sesión</h1>
        <div class="errores">
            <?php
            include '../modules/modulos.php';

            IniciarSesion();
            ?>
        </div>

        <form action='login.php' method="post">

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email"><br><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" name="submit" value="Iniciar Sesión">

            <button> <a href="registro.php">Registrarse</a></button>


        </form> 



    </body>
</html>

