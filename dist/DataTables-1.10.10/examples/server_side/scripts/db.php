<?php
    mysql_connect("localhost","root","coquetteic");
    mysql_select_db("impagnet_netic");
    class conexion
    {
        private $host;
        private $usuario;
        private $password;

        public function conexion()
        {
            $this->host = "127.0.0.1";
            $this->usuario = "root";
            $this->password = "coquetteic";
        }

        public function Conectar()
        {
            $conectar = mysql_connect($this->host, $this->usuario, $this->password);
            mysql_select_db("impagnet_netic", $conectar);
            return $conectar;
        }
    }
?>
