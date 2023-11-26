<?php

session_start();

require 'user.php';
$objUser = new User();

if(isset($_SESSION['user_id'])) {
    $results = $objUser->consulta($_SESSION['user_id']);
    $user = NULL;

    if(count($results) > 0){
        $user = $results;
    }

}

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
    <h2>Iniciar Sesi&oacuten</h2>
    <form action="login.php" method="POST">
        <p>
            <input id=field type="text" placeholder="Email" name="email"> 
        </p>
        <p>
            <input id=field type="password" placeholder="Contrase&ntilde;a" name="password">
        </p>
        <p>
            <input id=button type="submit" value="Ingresar">
        </p>
        <hr>
        <p id=button>
            <a href="register.php">Registrarse</a>
        </p>
    </form>
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