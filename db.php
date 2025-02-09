<?php

require_once "utils.php";

class DB
{
    private $host;
    private $username;
    private $password;
    private $database_name;
    private $port;
    private static $connection = null;

    function __construct($host = 'localhost', $username = 'root', $password = '', $database_name = 'cerds', $port = '3306')
    {
        $this->setHost($host);
        $this->setDatabaseUsername($username);
        $this->setDatabasePassword($password);
        $this->setDatabaseName($database_name);
        $this->setDatabasePort($port);
    }

    // Getters
    public function getHost()
    {
        return $this->host;
    }
    public function getDatabaseUsername()
    {
        return $this->username;
    }
    private function getDatabasePassword()
    {
        return $this->password;
    }
    public function getDatabaseName()
    {
        return $this->database_name;
    }
    public function getDatabasePort()
    {
        return $this->port;
    }

    // Setters
    public function setHost($host)
    {
        $this->host = $host;
    }
    public function setDatabaseUsername($username)
    {
        $this->username = $username;
    }
    private function setDatabasePassword($password)
    {
        $this->password = $password;
    }
    public function setDatabaseName($database_name)
    {
        $this->database_name = $database_name;
    }
    public function setDatabasePort($port)
    {
        $this->port = $port;
    }
    // Crea y retorna una conexion hacia la base de datos.
    private static function connect()
    {
        if (!self::$connection) {
            $db = new self();
            self::$connection = new \mysqli(
                $db->getHost(),
                $db->getDatabaseUsername(),
                $db->getDatabasePassword(),
                $db->getDatabaseName(),
                $db->getDatabasePort()
            );

            if (self::$connection->connect_error) {
                die("Database connection failed: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }

    public static function test()
    {
        $sql = "SELECT 1";
        $result = self::query($sql);

        if (isset($result['error_code'])) {
            return "Test failed: " . $result['error_message'];
        } else {
            return "Test succeeded: Database connection is working.";
        }
    }

    public static function query($sql, $params = [])
    {
        $conn = self::connect();
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Si hay un error en la preparación de la query, devuelve un error.
            return [
                'error_code' => $conn->errno,
                'error_message' => $conn->error,
                'sql' => $sql,
                'params' => $params
            ];
        }

        if (!empty($params)) {
            // Agrega parametros a la query
            $types = str_repeat('s', count($params)); // Por el momento, solo soporta parametros de tipo string.
            $stmt->bind_param($types, ...$params);
        }

        // Ejecuta la query.
        $stmt->execute();

        if ($stmt->errno) {
            $stmt->close();
            return [
                'error_code' => $stmt->errno,
                'error_message' => $stmt->error,
                'sql' => $sql,
                'params' => $params
            ];
        }

        $result = $stmt->get_result();

        if ($result) {
            // Solo las queries de tipo "SELECT" retornan filas, en tal caso, si existen, se convierten en arreglos.
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $data;
        } else {
            // Para queries de tipo "INSERT", obtenemos el último ID insertado
            if (stripos($sql, "INSERT") === 0) {
                $lastInsertId = $conn->insert_id;
                $stmt->close();
                return $lastInsertId; // Obtiene el ID en caso de que sea un insert.
            }
            // For other queries (UPDATE, DELETE), just check if any rows were affected
            $success = $conn->affected_rows > 0;
            $stmt->close();
            return $success;
        }
    }

    // Funcion que cierra la conexion.
    public function closeConnection()
    {
        if (self::$connection) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}
