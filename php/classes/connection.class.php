<?php
/**
 *
 */
class Connection
{
  //константы для подключения к бд
  public $db;
  private $dbhost = 'localhost';
  private $dbuser = 'root';
  private $dbpass = '';
  private $dbname = 'webcom';

  public function __construct() {
    $this->db = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
  }

  public function __destruct() {
    $this->db = null;
  }

  public function query($sql) {
    $result = $this->db->query($sql);
    return $result;
  }
}

?>
