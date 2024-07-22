<?php

namespace app\database;

require_once 'config.php';


class connect {

    /* FUNÇÕES UTILIZADAS PARA FAZER CONEXÃO NO BANCO DE DADOS MYSQL */

    private $conn;

    public function __construct() {
        $this->conn = $this->getConnectMysql();
    }


    public function escapeString($string) {
        return $this->conn->real_escape_string($string);
    }

    public function getConnectMysql() {
        $conn_mysql = new \mysqli(
            config::IP_DATABASE_MYSQL_REDHAT,
            config::USER_DATABASE_MYSQL_REDHAT,
            config::PASS_DATABASE_MYSQL_REDHAT,
            config::NAME_DATABASE_MYSQL_REDHAT
        );

        if ($conn_mysql->connect_errno) {
            throw new \Exception("Falha na conexão com o banco de dados: " . mysqli_connect_error());
        }

        return $conn_mysql;
    }

    public function getQueryMysql($query) {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            throw new \Exception("Erro na consulta: " . mysqli_error($this->conn));
        }

        return $result;
    }

    public function closeConnectMysql() {
        if ($this->conn instanceof \mysqli) {
            $this->conn->close();
        }
    }

    public function getCountMysql($mysqlQuery) {
        return mysqli_num_rows($mysqlQuery);
    }

    public function getInsertId() {
        return mysqli_insert_id($this->conn);
    }

     /* FUNÇÕES UTILIZADAS PARA FAZER CONEXÃO NO BANCO DE DADOS MYSQL */

     public function getConnectPostgres() {
        set_time_limit(0); // Configurar o timeout para 0 para desativar
    
        $conn_pg = pg_connect(
            "host=" . config::IP_DATABASE_DB_ERP .
            " port=" . config::PORT_DATABASE_DB_ERP .
            " dbname=" . config::NAME_DATABASE_DB_ERP .
            " user=" . config::USER_DATABASE_DB_ERP .
            " password=" . config::PASS_DATABASE_DB_ERP
        );
    
        if (!$conn_pg) {
            $conn_pg_error = pg_last_error();
            trigger_error(htmlentities($conn_pg_error['message'], ENT_QUOTES), E_USER_ERROR);
        } else {
            return $conn_pg;
        }
    }


    public function getQueryPostgres($query) {
        $result = pg_query($this->getConnectPostgres(), $query);
        return $result;
    }

    public function closeConnectPostgres($connect) {
        if ($connect) {
            pg_close($connect);
        }
    }

    public function getCountPostgres($postgresQuery) {
        $con_num_row = pg_num_rows($postgresQuery);
        return $con_num_row;
    }


}
