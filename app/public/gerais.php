<?php

    namespace app\public_;

    include_once(__DIR__ . "/../database/database.php");

    use app\database\connect;

    class gerais{


        public function printErro($err){
            
            echo "<pre>".print_r($err,true)."</pre>";

        }
        public function imprimir($str){
            echo "$str";
        }

        public function get_js($path)
        {
            $this->imprimir('<script src="' . $path . '"></script>');
        }

        public function doc_json()
        {
            header("Content-Type: application/json");
        }

        function getCookie($name) {
            if(isset($_COOKIE[$name])) {
                return $_COOKIE[$name];
            } else {
                return null;
            }
        }


        public function getAddressIP() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP'])){
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            }else if(isset($_SERVER['HTTP_FORWARDED'])){
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            }else if(isset($_SERVER['REMOTE_ADDR'])){
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            }else{
                $ipaddress = 'UNKNOWN';
            }
                
            return $ipaddress;

        }

        function get_imp_user($user){

            $bd = new connect();

            $return = null;

            $query = "SELECT imp.descricao AS impressora, lyt.descricao AS layout
            FROM txc_tb_acesso a
            INNER JOIN	txc_tb_config_imp cfg ON (cfg.usuario = a.ID)
            INNER JOIN	txc_tb_impressoras imp ON (imp.id = cfg.impressora)
            INNER JOIN txc_tb_layout lyt ON (lyt.id = cfg.layout)
            WHERE a.USUARIO = '$user'";

            $con = $bd->getQueryMysql($query);

            if($con)
            {

                $row = $con->fetch_assoc();
                $imp = $row['impressora'];
                $lyt = $row['layout'];

                $return = array("impressora" => "$imp", "layout" => "$lyt");
            }

            return $return;

        }

    }
    class seguranca
    {
        function setCustomCookie($name, $value, $expire = 31536000, $path = "/", $domain = "", $secure = false, $httponly = true) {
            $expireTime = time() + $expire;
        
            setcookie($name, $value, $expireTime, $path, $domain, $secure, $httponly);
        }


        function encryptString($string, $algorithm) {
            switch (strtolower($algorithm)) {
                case 'md5':
                    return md5($string);
                case 'sha256':
                    return hash('sha256', $string);
                default:
                    return "Erro: Algoritmo não suportado. Use 'md5' ou 'sha256'.";
            }
        }



    }


