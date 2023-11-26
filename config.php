<?php

// set expires header
/*header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');

// remove header
header_remove('ETag');
header_remove('Pragma');
header_remove('Cache-Control');
header_remove('Last-Modified');
header_remove('Expires');

// set header
header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0',false);
header('Pragma: no-cache');*/

session_start();

if(!isset($_SESSION['idUser'])){
    header("Location: index.php");
}
require 'user.php';
$objUser = new User();

if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone'])){
    
    $user = $objUser->searchUser($_POST['email']);
    if($user['id'] != $_SESSION['idUser']){
        echo '<script>alert("Error! El correo nuevo ya est&aacute; asociado a otra cuenta")</script>';
    }
    else{
        if(empty($_POST['password'])){
            $password = $_SESSION['passwordUser'];
        }
        else{
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        if(empty($_FILES['avatar']['name'])){
            $target = $_SESSION['avatarUser'];
        }
        else{
            if(!empty($_SESSION['avatarUser'])){
                unlink($_SESSION['avatarUser']);
            }
            $info = pathinfo($_FILES['avatar']['name']);
            $ext = $info['extension'];
            $newName = $_POST['email'].".".$ext;
            $target = "Media/Usuarios_Avatar/".$newName;
            move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
        }
        $resp = $objUser->updateUser($_SESSION['idUser'], $_POST['name'], $_POST['email'], $_POST['phone'], $password, $target);
        $results = $objUser->searchUser($_POST['email']);

        $_SESSION['idUser'] = $results['id'];
        $_SESSION['nameUser'] = $results['name'];
        $_SESSION['emailUser'] = $results['email'];
        $_SESSION['phoneUser'] = $results['phone'];
        $_SESSION['avatarUser'] = $results['avatar'];
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
        <h1>NetFaceBloc</h1>
    </header>
</section>

<section id=main_content>
    <section id=user>
        <?php echo '<img src="'.$_SESSION['avatarUser'].'">' ?>
        <h2><?php echo $_SESSION['nameUser'] ?></h2>
        <p id=button><a href="logout.php">Cerrar Sesi&oacute;n</a></p>
        <p id="button"><a href="delete.php">Eliminar Cuenta</a></p>
    </section>
    <section id=login_form>
        <h2>Datos</h2>
        <form action="config.php" method="POST" enctype="multipart/form-data">
            <p>
                <input id=field type="text" placeholder="Nombre" name="name" value="<?php echo $_SESSION['nameUser'] ?>"> 
            </p>
            <p>
                <input id=field type="text" placeholder="Email" name="email" value="<?php echo $_SESSION['emailUser'] ?>"> 
            </p>
            <p>
                <input id=field type="text" placeholder="Tel&eacute;fono" name="phone" value="<?php echo $_SESSION['phoneUser'] ?>"> 
            </p>
            <p>
                <input id=field type="password" placeholder="Contrase&ntilde;a" name="password">
            </p>
            <p>
                <input id=img_upload type="file" name="avatar" accept=".png, .jpeg, .jpg"> 
            </p>
            <p>
                <input id=button type="submit" value="Actualizar">
            </p>
    </section>
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