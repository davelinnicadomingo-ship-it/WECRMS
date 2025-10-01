<?php
/**
 * Database Configuration
 * PostgreSQL Connection using PDO
 */

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            // Get database credentials from environment variables
            $host = getenv('PGHOST');
            $port = getenv('PGPORT');
            $dbname = getenv('PGDATABASE');
            $user = getenv('PGUSER');
            $password = getenv('PGPASSWORD');
            
            // Create PDO connection string
            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
            
            // Set PDO options
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            // Create connection
            $this->connection = new PDO($dsn, $user, $password, $options);
            
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Helper method to execute queries
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            return false;
        }
    }
    
    // Fetch all results
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : [];
    }
    
    // Fetch single row
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : null;
    }
}
?>
