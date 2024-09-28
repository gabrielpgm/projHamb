<?php

namespace app\database;

require_once 'config.php';


class connect
{


    private $conn;

    public function __construct()
    {
        $this->conn = $this->getConnectMysql();
    }


    public function escapeString($string)
    {
        return $this->conn->real_escape_string($string);
    }

    public function getConnectMysql()
    {
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

    public function getQueryMysql($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            throw new \Exception("Erro na consulta: " . mysqli_error($this->conn));
        }

        return $result;
    }

    public function closeConnectMysql()
    {
        if ($this->conn instanceof \mysqli) {
            $this->conn->close();
        }
    }

    public function getCountMysql($mysqlQuery)
    {
        return mysqli_num_rows($mysqlQuery);
    }

    public function getInsertId()
    {
        return mysqli_insert_id($this->conn);
    }
}
