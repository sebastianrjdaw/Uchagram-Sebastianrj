<?php
if (!isset($_SESSION['username'])||!isset($_COOKIE['Codigo'])) {
    header('Location index.php');
}


include('menu.php');
include('publicacion.class.php');
$codigo=$_COOKIE['Codigo'];
$datos = obtenerPublicaciones();
foreach ($datos as $publicacion) {
    if ($publicacion->getCodigo() == $codigo ) {
        $titulo = $publicacion->getTitulo();
        $texto = $publicacion->getTexto();
        $fecha = $publicacion->getDataPublicacion();
        $multimedia=$publicacion->getMultimedia();
    }
}
if (isset($_POST['atras'])) {
    setcookie("Codigo","", time() - 3600);
    header('Location: usuarios.php');
}
?>
<html>
    <head>
        <title>Publicacion</title>
    </head>
    <body>
        <h3>Titulo: <?php echo $titulo?></h3>
        <p>Texto: <?php echo $texto?> </p>
        <p>Fecha: <?php echo date("d-m-Y",$fecha)?></p>
        <p>Mulltimedia : <?php if(isset($multimedia))echo $multimedia; ?>
        <p>Codigo Publicacion: <?php echo $codigo?></p>
        <form method="post" action="publicacion.php">
            <button type="submit" name="atras">Atras</button>
        </form>
    </body>
</html>