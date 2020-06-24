<?php
// general connection singleton class
// stolen from https://phpenthusiast.com/blog/the-singleton-design-pattern-in-php
class Connection
{
  // hold the class instance.
  private static $instance = null;
  private $connection;

  // connection setup variables
  private $protocol = "mysql";
  private $servername = "localhost";
  private $database = "mbs";
  private $username = "root";
  private $password = "toor";

  // the constructor is private to prevent initiation with outer code.
  private function __construct()
  {

    try {
      // create new PDO based on the "connection setup variables"
      $this->connection = new PDO("{$this->protocol}:host={$this->servername};dbname={$this->database}", $this->username, $this->password);

      // set the PDO error mode to exception
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  // the object is created from within the class itself only if the class has no instance.
  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new Connection();
    }

    return self::$instance;
  }

  public function getConnection() {
    return $this->connection;
  }
}
