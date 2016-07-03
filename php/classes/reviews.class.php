<?php
/**
 *
 */

include 'connection.class.php';

class Reviews extends Connection
{
  public $name;
  public $email;
  public $message;
  public $position;
  public $url;
  public $id;

  public function sanitizeString($var) {
    $var = strip_tags($var);            //Удаляет HTML и PHP-теги из строки
    $var = htmlentities($var);          //Преобразует символы в HTML-сущности
    $var = stripslashes($var);          //Удаляет экранирование символов
    return $this->db->real_escape_string($var);     //Экранирует необходимые символы
  }

  public function adding() {
    if(!empty($_POST['name']) &&
      !empty($_POST['email']) &&
      !empty($_POST['message']) &&
      isset($_POST['captcha']) &&
      !empty($_POST['captcha']) &&
      $_SESSION['code'] == $_POST['captcha']) {

        $this->name = $_POST['name'];
        $this->email = $_POST['email'];
        $this->message = $_POST['message'];
        $this->position = $_POST['position'];

        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
          $types = array('image/jpeg', 'image/pjpeg', 'image/png');
          if(!in_array($_FILES['image']['type'], $types)) {
            echo "invalid type";
          } else {
            $dir = $_SERVER['DOCUMENT_ROOT'] . "webcom/avatars/";
            $uploadfile = $dir . basename($_FILES['image']['name']);
            $this->url = "avatars/" . basename($_FILES['image']['name']);
            if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
              echo "File sended";
            } else {
              echo "Don't sended";
            }
          }
        } else {
          $uploadfile = "empty";
        }
        $sql = "INSERT INTO messages (name, email, position, message, image)
              VALUES ('$this->name', '$this->email', '$this->position', '$this->message', '$this->url')";
        $this->db->query($sql);
      }
  }

  public function selectId() {
    $sql = "SELECT id FROM messages";
    return $this->db->query($sql)->fetchAll();
  }

  public function reset() {
    $allId = $this->selectId();
    if($this->id == 0) {
      $this->id = $allId;
    } else {
      $this->id++;
    }
    return $this->id;
  }

  public function leafing() {
    $reset = false;
    $this->id = $_POST['id'];
    // $this->id = 11;
    $sql = "SELECT id, name, message, image FROM messages WHERE id = '$this->id'";

    $count = $this->db->query($sql)->rowCount();
    if(!$count) {
      $sqlMax = "SELECT MAX(id) FROM messages";
      $maxId = $this->db->query($sqlMax)->fetchColumn();
      $reset = true;
      if($this->id > $maxId) {
        $this->id = 1;
        $val = 1;
      } elseif ($this->id == 0) {
        $this->id = $maxId;
        $val = $maxId;
      // } else {
      //   do {
      //     ++$this->id;
      //     $sql = "SELECT id, name, message, image FROM messages WHERE id = '$this->id'";
      //     $rows = $this->db->query($sql)->rowCount();
      //   } while ($rows == 0);
      //   $val = $this->id;
      }
    }

    // echo $this->id;
    $sql = "SELECT id, name, message, image FROM messages WHERE id = '$this->id'";
    $rows = $this->db->query($sql);
    foreach($rows as $row) {
      echo json_encode(array("name" => $row['name'], "msg" => $row['message'],
                              "image" => $row['image'], "reset" => $reset,
                            "value" => $val));
    }
  }
}

?>
