<?php
  // Se abre la sesión
  session_start();

  include '../modules/modulos.php';
  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>
  <body>
    <header>
      
      
    </header>
    <main>
      <section id="destacados">
        <h1 class="text-center">Mi Carrito</h1>
        <div class="container pedido d-flex justify-content-center">
        <button class="text-center"> <a href="pagina_principal.php">Página Principal</a></button>
        
        </div>
        <div class="container pedido d-flex justify-content-center">
        
        <button class="text-center"> <a href="pedidos.php">Ver Pedidos</a></button>
        </div>
        
     <?php 
            VerCarrito();
     ?>

       
    </main>
  </body>
</html>