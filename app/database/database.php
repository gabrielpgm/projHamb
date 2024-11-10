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

    public function getSecureQueryMysql($query, $params = [], $paramTypes = '')
    {
        // Preparar a consulta
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new \Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        // Verifica se há parâmetros a serem vinculados
        if (!empty($params)) {
            // Vincular parâmetros (o primeiro argumento é uma string que representa os tipos de dados)
            $stmt->bind_param($paramTypes, ...$params);
        }

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new \Exception("Erro na execução da consulta: " . $stmt->error);
        }

        // Retorna o resultado
        $result = $stmt->get_result();

        // Se for uma consulta de seleção, retorna o resultado
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return true;
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
