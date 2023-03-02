<?php
  // Abrimos la sesion
  session_start();

  include '../modules/modulos.php';
  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Biblioteca en línea</title>
    
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>
  <body>
    <header>
      <h1 class="text-center">Biblioteca en línea</h1>
      
      <div class="container pedido d-flex justify-content-center">
      <button> <a href="carrito.php">Ver Carrito</a></button>
        </div>
    </header>
    <main>
      <section id="destacados">
        <h2 class="text-center">Libros destacados</h2>
        
     <?php 
            libros();
     ?>

       
    </main>
  </body>
</html>