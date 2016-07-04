<?php
/**
 *
 */
include 'reviews.class.php';

class Paginate extends Reviews
{
  public $id;
  public $start = 0;
  public $limit = 5;
  public $pages;

  public function showTable() {
    if(isset($_GET['id'])) {
      $this->id = $_GET['id'];
      $this->start = $this->id * $this->limit - $this->limit;
    } else {
      $this->id = 1;
    }

    $sql = "SELECT * FROM messages LIMIT $this->start, $this->limit";

    $rows = $this->db->query($sql);

    foreach($rows as $row) {
      echo "<tr><td class='idrew'>" . $row['id'] . "</td><td>" . $row['name'] .
      "</td><td>" . $row['email'] . "</td><td>" . $row['position'] .
      "</td><td>" . $row['message'] ."</td></tr>";
    }
  }

  public function showPages() {
    $sql = "SELECT * FROM messages";
    $rows = $this->db->query($sql)->rowCount();
    $this->pages = ceil($rows/$this->limit);
    for($i = 1; $i <= $this->pages; $i++) {
      echo "<a href='?id=" . $i . "'>" . $i ."</a> ";
    }
  }
}

?>
