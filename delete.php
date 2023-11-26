<?php
session_start();

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
        <h1></h1>
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
$objUser = new User();
$objUser->deleteUser($_SESSION['idUser']);

session_unset();

session_destroy();

?>