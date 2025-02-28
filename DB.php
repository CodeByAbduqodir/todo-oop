<?php
declare(strict_types=1);

require 'credentials.php';

class DB {
  private string $host;
  private string $database;
  private string $username;
  private string $password;

  public function __construct() {
    $this->host = $_ENV['DB_HOST'] ?? '';
    $this->database = $_ENV['DB_NAME'] ?? '';
    $this->username = $_ENV['DB_USER'] ?? '';
    $this->password = $_ENV['DB_PASSWORD'] ?? '';
  }

  public function connect(): PDO {
    if (empty($this->host) || empty($this->database) ||
        empty($this->username) || empty($this->password)) {
      throw new RuntimeException('DB connection properties are not set');
    }

    try {
      $pdo = new PDO(
        "mysql:host=$this->host;dbname=$this->database",
        $this->username,
        $this->password
      );

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

      return $pdo;
    } catch (PDOException $e) {
      file_put_contents('logs.txt', $e->getMessage(), FILE_APPEND);
      throw $e;
    }
  }
}
