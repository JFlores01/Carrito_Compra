<?php


//Función mediante la cual se validan los campos del registro y se muestran los mensajes de error.
function validate($nombre, $email, $password, $password2, $direccion) {

    $arrayerror = array();

    if (!filter_var($nombre, FILTER_SANITIZE_STRING)) {
        $arrayerror[] = '<span style="color:blue" >Nombre incorrecto</span>';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $arrayerror[] = '<span style="color:blue" >Email incorrecto</span>';
    }
    if (strlen($password < 4)) {
        $arrayerror[] = '<span style="color:blue" >Contraseña incorrecto</span>';
    }
    if ($password != $password2) {
        $arrayerror[] = '<span style="color:blue" >Contraseñas no coinciden</span>';
    }
    if (!filter_var($direccion, FILTER_SANITIZE_STRING)) {
        $arrayerror[] = '<span style="color:blue" >Direccion incorrecto</span>';
    }
    return $arrayerror;
}

//Función mediante la cual se recogen los campos del formulario registro y se crea una sesión.

function RecogerDatos() {



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $direccion = $_POST['direccion'];

        $arrayerror = validate($nombre, $email, $password, $password2, $direccion);

        if (count($arrayerror) > 0) {
            foreach ($arrayerror as $error) {
                echo $error . '<br>';
                
            }
        } else {

            echo "hola";

            $password = md5($password);
            session_start();

            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            RegistrarUsuarioBD($nombre, $email, $password, $direccion);

            header('Location: pagina_principal.php');
        }
    }
}


    //Función para la conexión a la base de datos.
function conexionBD() {

    

    $server = "localhost";
    $usuario = "root";
    $password = "";
    $bd = "libros_db";

    $con = mysqli_connect($server, $usuario, $password, $bd);
    if (!$con) {
        die("Error de conexion" . mysqli_connect_error());
    }
    return $con;
}


    //Función para insertar los datos de los usuarios en la base de datos.
function RegistrarUsuarioBD($nombre, $email, $password, $direccion) {

    $con = conexionBD();

    $INSERT = "INSERT INTO `usuario`(`nombre`, `correo`, `password`, `fecha_registro`, `direccion`) VALUES ('$nombre','$email','$password',NOW() ,'$direccion')";
    if (mysqli_query($con, $INSERT)) {
        echo "Usuario registrado";
    } else {
        echo "Error";
    }
    mysqli_close($con);
    
}

    //Función para mostrar los libros de la base de datos en la página web, añade un boton de añadir libros al carrito.

function libros(){
    
    $con =  conexionBD();
    
    $sql = "SELECT * FROM libro";
    $resultado = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($resultado)> 0){
       
        echo "<table class=table table-striped table-bordered>";
        
        echo "<tr><th>ID</th><th>Título</th><th>Autor</th><th>Editorial</th><th>Fecha de publicación</th><th>Género</th><th>Precio</th><th>Imagen</th><th>Descripcion</th></tr>";

        
    
        while ($row = mysqli_fetch_assoc($resultado)) {
           
          echo  "<tr>";
          echo  "<td>" . $row['id'] . "</td>";
          echo  "<td>" . $row['titulo'] . "</td>";
          echo  "<td>" . $row['autor'] . "</td>";
          echo  "<td>" . $row['editorial'] . "</td>";
          echo  "<td>" . $row['fecha_publicacion'] . "</td>";
          echo  "<td>" . $row['genero'] . "</td>";
          echo  "<td>" . $row['precio'] . "</td>";
          echo  "<td>" . $row['imagen'] . "</td>";
          echo  "<td>" . $row['descripcion'] . "</td>";
          echo  "<td><form method='post' action=''>";
          echo  "<input type='hidden' name='titulo' value='" . $row['titulo'] . "'/>";
          echo  "<input type='hidden' name='precio' value='" . $row['precio'] . "'/>";
          echo  "<input type='hidden' name='usuario' value='<?php echo ".$_SESSION['nombre']. "?>'/>";
          echo  "<button name='añadirCarrito'>Añadir al carrito</button>";
          echo  "</form></td>";
      
          echo  "</tr>";
        }
        echo  "</table>";
    }else{

        echo  "No se encontraron resultados";
    }
      
    if (isset($_POST['añadirCarrito'])) {
        $fechaActual = date('Y-m-d');
        $usuario = $_SESSION['nombre'];
        $nombreLibro = $_POST['titulo'];
        $precio = $_POST['precio'];
        $sentencia = $con->prepare("SELECT * FROM carrito WHERE libros = ? AND usuario = ?");
        $sentencia->bind_param("ss", $nombreLibro, $usuario);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
    
        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            $id = $fila['id'];
            $total = $fila['total'] + $precio;
    
            $sentencia = $con->prepare("UPDATE carrito SET total = ? WHERE id = ?");
            $sentencia->bind_param("ii", $total, $id);
            $sentencia->execute();
        } else {
            $sentencia = $con->prepare("INSERT INTO carrito(libros, total, usuario, fecha_pedido) VALUES (?, ?, ?, ?)");
            $sentencia->execute([$nombreLibro, $precio, $usuario, $fechaActual]);
        }
    }
    mysqli_close($con);
    }



            //Función para mostrar los productos que se han añadido a la tabla carrito
            //mediante la funcion anterior. Añade dos botones, uno de comprar, el cual traslada el producto a la tabla pedidos, y otro
            //de borrar carrito, que elimina el producto de la tabla carrito.
function VerCarrito(){

    $con =  conexionBD();
    $usuario = $_SESSION['nombre'];
    $sql = "SELECT * FROM carrito WHERE `usuario`= '$usuario'";
    $resultado = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($resultado)> 0){
       
        echo "<table class=table table-striped table-bordered>";
        
        echo "<tr><th>ID</th><th>Título</th><th>Total</th><th>Usuario</th><th>Fecha de publicaciónl</th></tr>";

        
    
        while ($row = mysqli_fetch_assoc($resultado)) {
           
          echo  "<tr>";
          echo  "<td>" . $row['id'] . "</td>";
          echo  "<td>" . $row['libros'] . "</td>";
          echo  "<td>" . $row['total'] . "</td>";
          echo  "<td>" . $row['usuario'] . "</td>";
          echo  "<td>" . $row['fecha_pedido'] . "</td>";
          echo  "<td><form method='post' action=''>";
          echo  "<input type='hidden' name='id' value='" . $row['id'] . "'/>";
          echo  "<input type='hidden' name='libros' value='" . $row['libros'] . "'/>";
          echo  "<input type='hidden' name='usuario' value='<?php echo ".$_SESSION['nombre']. "?>'/>";
          echo  "<button name='comprar'>Comprar</button>";
          echo  "<button type='submit' name='BorrarCarrito'>Borrar del carrito</button>";
          echo  "</form></td>";
      
          echo  "</tr>";
        }
        echo  "</table>";
    }else{

        echo  "No se encontraron resultados";
    }

    if (isset($_POST['BorrarCarrito'])){
        $id = $_POST['id'];
        $sentencia = $con->prepare("DELETE FROM carrito WHERE `carrito`.`id` = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();

        header("Location: carrito.php");
            exit();

    }

    if (isset($_POST['comprar'])) {
        $usuario = $_SESSION['nombre'];
        $id = $_POST['id'];
        tomarPedido($id, $usuario);
        $nombreLibro = $_SESSION['carrito'][0];
        $cantidad = 1;
        $precio = $_SESSION['carrito'][1];
        $direccion = $_SESSION['carrito'][2];
        $fechaActual = date('Y-m-d');

        $sentencia = $con->prepare("SELECT * FROM pedido WHERE libros = ? AND usuario = ?");
        $sentencia->bind_param("ss", $nombreLibro, $usuario);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        if (mysqli_num_rows($resultado)>0){
            $fila = mysqli_fetch_assoc($resultado);
            $idPedido = $fila['id'];
            $total = $precio + $precio;
            $recuento = $cantidad+1;
            $sentencia = $con->prepare("UPDATE pedido SET precio = ? WHERE id= ?");
            $sentenciatotal = $con->prepare("UPDATE pedido SET total = ? WHERE id= ?");
            $sentencia->bind_param("ii", $total, $idPedido);
            $sentenciatotal->bind_param("ii", $recuento, $idPedido);
            $sentencia->execute();
            $sentenciatotal->execute();

        }else{
            $sentencia = $con->prepare("INSERT INTO pedido(libros, precio, total, usuario, direccion, fecha) VALUES (?, ?, ?, ?, ?, ?)");
            $sentencia->execute([$nombreLibro, $precio, $cantidad, $usuario, $direccion, $fechaActual]);
        }

        return true;


    }

    mysqli_close($con);


}

    //Esta función toma el pedido de cada usuario y lo guarda en una sesión, para que cada ususario solo pueda ver su carrito.

function tomarPedido($id, $usuario){
$con = conexionBD();
$sentencia = $con->prepare("SELECT * FROM carrito WHERE id = ?");
$sentencia->bind_param("s", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$nombreLibro="";
$total=0;
$direccion=obtenerDireccion($usuario);
if ($fila = mysqli_fetch_assoc($resultado)) {
    $nombreLibro = $fila['libros'];
    $total = $fila['total'];
}

$_SESSION['carrito'][0] = $nombreLibro;
$_SESSION['carrito'][1] = $total;
$_SESSION['carrito'][2] = $direccion;

mysqli_close($con);

}

//Función para obtener la direccion del ususario

function obtenerDireccion($usuario) {
    $con = conexionBd();
    $sentencia = $con->prepare("SELECT direccion FROM usuario WHERE nombre = ?");
    $sentencia->bind_param("s", $usuario);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $direccion = "";
    if ($fila = mysqli_fetch_assoc($resultado)) {
        $direccion = $fila['direccion'];
    }
    mysqli_close($con);
    return $direccion;
}


    //Función que muestra los productos que se encuentran en la tabla de pedidos, añade dos botones, uno que borra el pedido
    //y otro el cual procede a pagar, que muestra un mensaje en pantalla de que el pago se realiza correctamente.
function Pedidos(){
    
    $con =  conexionBD();
    $usuario = $_SESSION['nombre'];
    $sql = "SELECT * FROM `pedido` WHERE `usuario`= '$usuario'";
    $resultado = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($resultado)> 0){
       
        echo "<table class=table table-striped table-bordered>";
        
        echo "<tr><th>ID</th><th>Título</th><th>Precio</th><th>Total</th><th>Usuario</th><th>Direccion</th><th>Fecha</th><th>Acciones</th></tr>";

        
    
        while ($row = mysqli_fetch_assoc($resultado)) {
           
          echo  "<tr>";
          echo  "<td>" . $row['id'] . "</td>";
          echo  "<td>" . $row['libros'] . "</td>";
          echo  "<td>" . $row['precio'] . "</td>";
          echo  "<td>" . $row['total'] . "</td>";
          echo  "<td>" . $row['usuario'] . "</td>";
          echo  "<td>" . $row['direccion'] . "</td>";
          echo  "<td>" . $row['fecha'] . "</td>";
          echo  "<td><form method='post' action=''>";
          echo  "<input type='hidden' name='id' value='" . $row['id'] . "'/>";
          echo  "<input type='hidden' name='total' value='" . $row['total'] . "'/>";
          echo  "<input type='hidden' name='usuario' value='<?php echo ".$_SESSION['nombre']. "?>'/>";
          echo  "<button type='submit' name='pagarpedido'>Pagar</button>";
          echo  "<button type='submit' name='borrarpedido'>Borrar producto</button>";
          echo  "</form></td>";
      
          echo  "</tr>";
        }
        echo  "</table>";
    }else{

        echo  "<div class='alert alert-warning' role='alert'>No se encontraron resultados</div>";
    }

    if (isset($_POST['borrarpedido'])){
        $id = $_POST['id'];
        

        $sentencia = $con->prepare("DELETE FROM pedido WHERE `pedido`.`id` = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();

        header("Location: ../php/pedidos.php");
        exit();

    }

    if (isset($_POST['pagarpedido'])) {
        $total = $_POST['total'];
        $usuario = $_SESSION['nombre'];
        $fechaActual = date('Y-m-');
        $metodo_pago = "tarjeta";

        $con = conexionBD();
        $sentencia = $con->prepare("INSERT INTO `pago` (`monto`, `fecha`, `usuario`, `metodo`) VALUES (?, ?, ?, ?)");
        if($sentencia->execute([$total, $fechaActual, $usuario, $metodo_pago])){
            echo "<div class='alert alert-success' role='alert'>El pago se ha realizado correctamente</div>";
        }

    }

    mysqli_close($con);


}





function IniciarSesion() {


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $server = "localhost";
        $usuario = "root";
        $passwordbd = "";
        $bd = "libros_db";

// Crear conexión
        $conn = new mysqli($server, $usuario, $passwordbd, $bd);

// Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT correo, password FROM usuario WHERE correo LIKE '$email' AND password LIKE '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Inicio de sesión exitoso";
            header("Location: pagina_principal.php");
            exit;
        } else {
            // Inicio de sesión fallido
            // Aquí puedes enviar un mensaje de error al usuario
            echo "Inicio de sesion fallido";
        }

        $conn->close();
    }
}

?>