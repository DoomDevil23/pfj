<?php
class DataBase{
    private $server = 'localhost';
    private $username = 'root'; 
    private $password = '';
    private $database = 'auth';

    public function conexion(){
        try{
                $conn = new PDO("mysql:host=$this->server; dbname=$this->database;", $this->username, $this->password);
                //$conn = new PDO("mysql:host=localhost; dbname=auth;", $this->$username, $this->$password);
                return $conn;
            } catch(PDOException $e){
                return false;
                //die( "Conexión falló: " . $e->getMessage());
            }
    }

    public function consulta($id){
        $conn = $this->conexion();
        $query;
        $result;
        if(!$conn){
            //echo ("La conexion falló");
            $result=false;
        }
        else {
            $query = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
            $query->bindParam(':id', $id);
            $query->execute();
            $result=$query->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
}
/*$objDataBase = new DataBase();
$result=$objDataBase->consulta(1);
echo "Resultado: ";
echo($result['email']);*/
?>