<?php

class Database {
    private $connection;
    
    public function __construct() {
        // ✅ Database URL without password + correct database name
        $database_url = "mysql://root:@127.0.0.1:3306/ticketingsystem";
        
        if (!$database_url) {
            die("DATABASE_URL environment variable is not set");
        }
        
        $url_parts = parse_url($database_url);
        
        $host = $url_parts['host'] ?? 'localhost';
        $port = $url_parts['port'] ?? 3306;
        $dbname = ltrim($url_parts['path'] ?? 'ticketingsystem', '/');
        $user = $url_parts['user'] ?? 'root';
        $password = ""; // ✅ removed password
        
        $query_params = [];
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $query_params);
        }
        
        // 👇 MySQL DSN
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        
        if (isset($query_params['sslmode']) && $query_params['sslmode'] === 'require') {
            $dsn .= ";sslmode=require";
        }
        
        try {
            $this->connection = new PDO($dsn, $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            return false;
        }
    }
    
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : [];
    }
    
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : null;
    }
    
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}
