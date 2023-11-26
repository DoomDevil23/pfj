<?php

session_start();
//VALIDAMOS QUE SE HAYA LLEGADO A ESTA PAGINA DESPUES DE HABER INICIADO SESION. EN CASO CONTRARIO, EL USUARIO ES REDIRIGIDO A AL INDEX.PHP PARA QUE INICIE SESION
if(!isset($_SESSION['idUser'])){
    header("Location: index.php");
}

require 'user.php';
?>

<!DOCTYPE html> 
<html>
<head>
<title>NetFaceBloc</title>
<link rel="stylesheet" type="text/css" href="Style/style.css">
<link href='http://fonts.googleapis.com/css?family-Confortas' rel='stylesheet' type='text/css'>
</head>
<body>
<section id=header>
    <header>
        <h1>NetFaceBloc</h1>
    </header>
</section>

<section id=login_form>
        <h2>Adios</h2>
        <h3><?php echo $_SESSION['nameUser'] ?></h3>
        <p>Su cuenta ha sido eliminada permanentemente!</p>
    <?php
        echo '<meta http-equiv="refresh" content="6;url=http://localhost:80/pfj/"> ';
    ?>
</section>

<section id=footer>
    <footer>
        <h4>Elaborado por</h4>
        <p>Estudiante1</p>|
        <p>Estudiante2</p>|
        <p>Estudiante3</p>|
        <p>Estudiante4</p>
    </footer>
</section>
</body>
</html>

<?php
//DESPUES DE CARGAR LA PAGINA CON LOS VALORES NECESARIOS DE $_SESSION PROCEDEMOS A BORRAR AL USUARIO DE LA BASE DE DATOS Y A ELIMINAR LA SESION ACTUAL
$objUser = new User();
$objUser->deleteUser($_SESSION['idUser']);

session_unset();

session_destroy();

?>