<?php
// Se abre la sesión
session_start();

include '../modules/modulos.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Mis Pedidos</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
    <header>


    </header>
    <main>
        <section id="destacados">
            <h1 class="text-center">Mis Pedidos</h1>

            <div class="container pedido d-flex justify-content-center">
                <button> <a href="carrito.php">Ver Carrito</a></button>
            </div>


            
            

            <?php
            Pedidos();
            ?>


    </main>
</body>

</html>