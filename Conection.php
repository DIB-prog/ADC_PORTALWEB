<?php



class Conection{
    private $servername = "hostingmysql321.nominalia.com";
    private $username = "dibcli";
    private $password = "DibParaClientes";
    private $database = "clients";
    private $conexion;
    
    public function conect(){  
         $this->conexion = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->database
        );


        if ($this->conexion->connect_error){
            die("Error de conexion ". $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");

        return $this->conexion;

}

     public function close(){
        if ($this->conexion){
            $this->conexion->close();

     }
   
}
}


?>