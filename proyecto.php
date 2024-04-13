<?php
include('conexion.php');

// Borrar imagen si se envió el ID
if(isset($_POST['borrar'])) {
    $imagen = $_POST['borrar'];
    $ruta_imagen = 'Backend/imagenes/' . $imagen;
    
    // Eliminar la imagen del sistema de archivos
    if(file_exists($ruta_imagen)) {
        unlink($ruta_imagen);
    }

    // Eliminar la entrada de la imagen de la base de datos
    $query_delete = "DELETE FROM imagenes WHERE imagen = '$imagen'";
    $resultado_delete = mysqli_query($conn, $query_delete);
    if($resultado_delete) {
        $_SESSION['mensaje'] = 'Imagen eliminada correctamente';
        $_SESSION['tipo'] = 'success';
    } else {
        $_SESSION['mensaje'] = 'Error al eliminar la imagen';
        $_SESSION['tipo'] = 'danger';
    }
    header('Location: Pro_html.html'); // Redirecciona a sí mismo para actualizar la página
    exit;
}

$query = "SELECT * FROM imagenes";
$resultado = mysqli_query($conn,$query);
?>

<div class="row">
    <div class="col-lg-4">
        <h1 class="text-primary">Subir imagen</h1>
        <form action="Backend/subir.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="my-input">Seleccione una Imagen</label>
                <input id="my-input" type="file" name="imagen">
            </div>
            <div class="form-group">
                <label for="my-input">Titulo de la Imagen</label>
                <input id="my-input" class="form-control" type="text" name="titulo">
            </div>
            <?php if(isset($_SESSION['mensaje'])){ ?>
            <div class="alert alert-<?php echo $_SESSION['tipo'] ?> alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION['mensaje']; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php session_unset(); } ?>
            <input type="submit" value="Guardar" class="btn btn-primary" name="Guardar">
        </form>
    </div>

    <div class="col-lg-8">
        <h1 class="text-primary">Galeria de Imagenes</h1>
        <hr>
        <div class="card-columns">
            <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
            <div class="card">
                <a href="Backend/imagenes/<?php echo $row['imagen']; ?>" download>
                    <img src="icono2.jpg" class="img-descarga" alt="Icono de descarga">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><strong><?php echo $row['nombre']; ?></strong></h5>
                    <form action="proyecto.php" method="post">
                       
                    </form>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
