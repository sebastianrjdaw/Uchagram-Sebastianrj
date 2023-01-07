<?php
/*
Título: Uchagram-usuarios
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 22/11/2022
Versión 1.0 #
*/
session_start();
if (!isset($_SESSION["username"])) { //Si no esta el usuario guardado en la sesion redireccione al login
    echo "Error de autenticacion";
    header("Location: index.php");
}


include('usuario.class.php');
include('publicacion.class.php');
include('menu.php');

//Gestion de Usuarios

$datos=obtenerUsuarios();
if(isset($_GET['eliminar'])){
    $filaEliminar=$_GET['eliminar'];
    unset($datos[$filaEliminar]);
}

if(isset($_POST['add'])){
  $valido = 'false';
  $errores = array();
  $datosValidos[]=$_POST['rol'][0];
    vNombre($_POST['username'],$valido);
    vPassword(($_POST['password']),($_POST['password']),$valido);
    $datosValidos[]=count(obtenerUsuarios());
    if (empty($errores)) {
      $datos[] = $usuario = new Usuario($datosValidos[0],$datosValidos[1],$datosValidos[2],$datosValidos[3]);
  } elseif(empty($errores)&&!empty($_POST['rol'])) {
    if (empty($_POST['rol'])) {
      $errores[] = 'Añade rol';
    }
    //hola
    print_r($errores);
  }
}
escribirUsuarios($datos);


//Gestion de Publicaciones
$datos2 = obtenerPublicaciones();
if (isset($_GET['eliminar2'])) {
  $filaEliminar2 = $_GET['eliminar2'];
  unset($datos2[$filaEliminar2]);
}

//Vista de Publicaciones
if (isset($_GET['ver'])) {
  $filaVer = $_GET['ver'];
  $cod = $filaVer[0];
  setcookie('Codigo', $cod);
  var_dump($filaVer);
  var_dump($cod);
   header('Location: publicacion.php');
}

escribirPublicaciones($datos2);




?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Administracion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
    <link
      rel="stylesheet"
      type="text/css"
      media="screen"
      href="css/usuarios.css"
    />
  </head>
  <body>
      <h2>GESTION DE USUARIOS</h2>
      <div class="form-body">
      <form action="usuarios.php" method="post" id="registro">
        <input type="text" name="username" placeholder="Nombre de Usuario" />
        <input type="password" name="password" placeholder="Introduce Contraseña" />
        <select name="rol[]" class="option-select">
          <option value="admin" <?php if (isset($_POST['rol']) && (in_array("admin", $_POST['rol'])))
                              echo "selected";
                            ?>>admin</option>
          <option value="user" <?php if (isset($_POST['rol']) && (in_array("user", $_POST['rol'])))
                              echo "selected";
                            ?>>client</option>
        </select>                    
        <button class="boton" type="sumbit" name="add">AÑADIR</button>
      </form>
      </div>  
      <div class="lista-users">
        <table>
          <tr>
            <th>NOMBRE</th>
            <th>CONTRASEÑA</th>
            <th>ROL</th>
            <th>CODIGO</th>
            <th> X </th>
          </tr>
          <?php
            $contFila=0;
            foreach($datos as $usuario) {
          ?>
          <tr>
            <td><?php echo $usuario->getUsername();?></td>
            <td><?php echo $usuario->getPassword();?></td>
            <td><?php echo $usuario->getRol();?></td>
            <td><?php echo $usuario->getCodigo();?></td>
            <td><a href="usuarios.php?eliminar=<?php echo $contFila++; ?>">Eliminar</a></td>     
          </tr>
          <?php } ?>
        </table>

        <h2>GESTION DE PUBLICACIONES</h2>

        <table>
          <tr>
            <th>CODIGO</th>
            <th>TITULO</th>
            <th>DATA</th>
            <th>PUBLICADO</th>
            <th>OPERACION</th>
          </tr>
          <?php
          $datos2 = obtenerPublicaciones();
          $contFila2=0;
          $ver = 0;
            foreach($datos2 as $publicacion) {
          ?>
          <tr>
            <td><?php echo $publicacion->getCodigo()?></td>
            <td><?php echo $publicacion->getTitulo()?></td>
            <td><?php $hora = $publicacion->getDataPublicacion(); echo date("d-m-Y",$hora);?></td>
            <td><?php var_dump($publicacion->publicado($hora)) ; ?></td>
            <td><a href="usuarios.php?eliminar2=<?php echo $contFila2++; ?>">Eliminar /</a><a href="usuarios.php?ver=<?php echo $ver++; ?>"> Ver</a></td>     
          </tr>
          <?php } ?>
        </table>

      </div>
      <div class="back-button">
        <button
          class="boton"
          id="salir"
          role="link"
          onclick="window.location='index.php'"
        >
          ATRAS
        </button>
      </div>
      
  </body>
</html>