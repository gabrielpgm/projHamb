<?php

require_once 'app/database/config.php'; // Incluindo o arquivo de configuração

// A classe que vai fazer a conexão
class DatabaseConnection {
    public static function testConnection() {
        // Configurações do banco de dados
        $host = \app\database\config::IP_DATABASE_MYSQL_REDHAT; // Usando o namespace completo
        $user = \app\database\config::USER_DATABASE_MYSQL_REDHAT;
        $pass = \app\database\config::PASS_DATABASE_MYSQL_REDHAT;
        $dbname = \app\database\config::NAME_DATABASE_MYSQL_REDHAT;
        $port = \app\database\config::PORT_DATABASE_MYSQL_REDHAT;

        // Tentando a conexão
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
            $pdo = new \PDO($dsn, $user, $pass);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo "Conexão bem-sucedida com o banco de dados!";
        } catch (\PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }
}

// Testar a conexão
DatabaseConnection::testConnection();
