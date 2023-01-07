<?php
/*
Título: Uchagram-perfil
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 22/11/2022
Versión 1.0 #
*/
session_start();
if(!isset($_SESSION["username"])){ //Si no esta el usuario guardado en la sesion redireccione al login
  echo "Error de autenticacion";
  header("Location: index.php");}




if (isset($_POST['cambiar'])) {
  //Recogemos el archivo enviado por el formulario
  $archivo = $_FILES['archivo']['name'];
  //Si el archivo contiene algo y es diferente de vacio
  if (isset($archivo) && $archivo != "") {
     //Obtenemos algunos datos necesarios sobre el archivo
     $tipo = $_FILES['archivo']['type'];
     $tamano = $_FILES['archivo']['size'];
     $temp = $_FILES['archivo']['tmp_name'];
     //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
    if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
       echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
       - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
    }
    else {
       //Si la imagen es correcta en tamaño y tipo
       //Se intenta subir al servidor
       if (move_uploaded_file($temp, 'img_perfil/'.$_SESSION['username'].'.png')) {
       }
       else {
          //Si no se ha podido subir la imagen, mostramos un mensaje de error
          echo 'Ocurrió algún error al subir el fichero. No pudo guardarse';
       }
     }
  }
}




?>
<html>

<head>
  <meta charset="utf-8">
  <title>Preferencias</title>
  
  <?php
  if (isset($_POST['moderacion'])) {
    setcookie('moderacion', true);
  }
  
if (isset($_COOKIE['Tema'])){
  if((($_COOKIE['Tema']==2)||($_POST["tema"][0])==2)){
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/oscuro_theme.css\" />";
  } elseif((($_COOKIE['Tema']==1)||($_POST["tema"][0])==1)||(isset($_POST['default']))){
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/perfil.css\" />";
    } 
}
  
  echo "<style>";
if(isset($_POST['default'])){
    setcookie('Tema', 1);
    setcookie('Fontfam', "Arial");
    setcookie('fontsize', 20);
    ?>
     *{
        font-family: <?php echo "Arial" ?> ;
        font-size: <?php echo 20 ?>px;
      }
      <?php
  }elseif (isset($_POST['modificar'])) {
      $tema = $_POST['tema'][0];
      setcookie('Tema', $tema);
      $fontfam = $_POST['fontfam'][0];
      setcookie('Fontfam', $fontfam);
      $fontsize = $_POST['fontsize'];
      setcookie('fontsize', $fontsize);
      ?>
     *{
        font-family: <?php echo $fontfam ?> ;
        font-size: <?php echo $_POST['fontsize'] ?>px;
      }
      <?php
    }else{
      ?>
      *{
        font-family: <?php echo $_COOKIE['Fontfam'] ?> ;
        font-size: <?php echo $_COOKIE['fontsize'] ?>px;
      }
      <?php
    }
    
   
?>
  
  </style>
</head>

<body>
<?php  
    include("menu.php");
    ?>

  <form action="perfil.php" method="POST" enctype="multipart/form-data">

    <div class="main">
      <h1>Establacer Preferencias</h1>
      <h3>Benvido <?php echo $_SESSION['username'] ?> ,configura tus preferencias </h3>
      <fieldset>
        <legend> Foto de Perfil </legend>
        <img id="avatar" 
        <?php
          if(isset($_POST["default"])){
            echo 'src="img_perfil/default.jpeg">';
          }else{
            echo 'src="'.compruebaPerfil().'">';}
           
        ?>
        
        Añadir imagen: <input name="archivo" id="archivo" type="file"/>
        <button type="submit" name="cambiar">Actualizar</button>
      </fieldset>
      <fieldset>
        <legend>Preferencias</legend>
        <label for="tema">Estilo</label>
        <select name="tema[]">
          <option value="1" <?php if (isset($_POST['tema']) && (in_array("1", $_POST['tema'])))
          echo "selected"; ?>
            >Claro</option>
          <option value="2" <?php if (isset($_POST['tema']) && (in_array("2", $_POST['tema'])))
          echo "selected"; ?>
            >Oscuro</option>
        </select>
        <label for="fontfam">Fuente</label>
        <select name="fontfam[]">
          <option value="Arial" <?php if (isset($_POST['fontfam']) && (in_array("Arial", $_POST['fontfam'])))
          echo "selected";
            ?>>Arial</option>
          <option value="Helvetica" <?php if (isset($_POST['fontfam']) && (in_array("Helvetica", $_POST['fontfam'])))
          echo "selected";
            ?>>Helvetica</option>
          <option value="Verdana" <?php if (isset($_POST['fontfam']) && (in_array("Verdana", $_POST['fontfam'])))
          echo "selected";
            ?>>Verdana</option>
        </select>
        <label for="fontsize">Tamaño</label>
        <input id="fontsize" name="fontsize" type="number"
          value="<?php if (isset($_POST['fontsize']))
          echo $_POST['fontsize'] ?>">
        <br>
      </fieldset>
      <br>
      <button type="submit" name="modificar">Modificar</button>
      <button type="submit" name="default">Valores por Defecto</button>
      <p>Si deseas censurar las palabras malsonantes pulsa<button type="submit" name="moderacion">Aquí</button> </p>
    </div>
  </form>
  <div class="control-table">
  <table>
    <tr>
      <th>Control de Acesso</th>
  </tr>
  <tr>
    <td>Hora conexion</td>
    <?php
    //imprimir las ultimas conexiones
      $hora = getHora();
      for ($i = 0; $i < count($hora); $i++) { 
        echo "<tr><td>";
        echo date("d-m-Y (H:i)",$hora[$i] );
        echo "</td></tr>";
    }
    ?>
  </tr>
  </table>
  </div>
</body>
<?php 
session_write_close();
?>
</html>