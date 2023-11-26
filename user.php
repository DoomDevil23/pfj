<?php
require 'database.php';

class User{
    private $id;
    private $name;
    private $email;
    private $phone;
    private $password;
    private $avatar;
    private $objDataBase;

    public function createUser($name, $email, $phone, $password, $avatar){
        $objDataBase  = new DataBase();
        $conn = $objDataBase->conexion();
        if(!$conn){
           return false;
        }
        else{
            $query = "INSERT INTO users (name, email, phone, password, avatar) VALUES (:name, :email, :phone, :password, :avatar)";
            
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
            $stmt->bindValue(':avatar', $avatar);

            if( $stmt->execute() ):
                $message = 'Nuevo usuario creado con éxito';
            else:
                $message = 'Disculpe, debe de haber ocurrido un problema al crear la cuenta';
            endif;
            return $message;
        }
    }

    public function searchUser($email){
        $objDataBase  = new DataBase();
        $conn = $objDataBase->conexion();
        if(!$conn){
            return false;
        }
        else{
            $query = "SELECT * FROM users WHERE email = :email";
            
            $records = $conn->prepare($query);
            $records->bindValue(':email', $email);
            $records->execute();
            return $records->fetch(PDO::FETCH_ASSOC);
        }
    }
    
    public function updateUser($id, $name, $email, $phone, $password, $avatar){
        $objDataBase  = new DataBase();
        $conn = $objDataBase->conexion();
        $message="";
        if(!$conn):
            return false;
        else:
            $query = "UPDATE users SET name = :name, email = :email, phone = :phone, password = :password, avatar = :avatar WHERE id = :id";
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
            $stmt->bindValue(':avatar', $avatar);
            $stmt->bindValue(':id', $id);

            if( $stmt->execute() ):
                $message = 'Actualizaci&oacute;n completada con &eacute;xito';
            else:
                $message = 'Disculpe, debe de haber ocurrido un problema al actualizar la cuenta';
            endif;
             
        endif;
        return $message;
    }

    public function deleteUser($id, $name, $email, $phone, $password, $avatar){

    }
}
?>