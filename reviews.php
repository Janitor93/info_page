<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Отзывы</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/function.js"></script>
  </head>
  <body>
    <table border="1" class="reviews">
      <thead>
        <tr>
          <th>id</th>
          <th>Имя</th>
          <th>E-mail</th>
          <th>Должность</th>
          <th>Отзыв</th>
        </tr>
      </thead>

    <?php

    require_once 'functions.php';

    //сейчас будет пагинация

    $start = 0;       //Откуда начинать отсчет для запроса к БД
    $limit = 5;       //Указываем сколько строк будет выводиться на странице
    if(isset($_GET['id'])) {              //Если в ссылке присутствует ?id=,
      $id = $_GET['id'];                  //значит мы находимся на определенной странце
      $start = $id * $limit - $limit;     //Следовательно, отсчет нужно задать новый отсчет
    } else {
      $id = 1;
    }

    $reviews = mysqli_query($connection, "SELECT * FROM messages LIMIT $start, $limit");

    //Вытаскиваем по одной строке из из результатирующего набора и строим таблицу
    while($row = $reviews->fetch_array(MYSQLI_ASSOC)) {
      echo "<tr><td class='idrew'>" . $row['id'] . "</td><td>" . $row['name'] .
      "</td><td>" . $row['email'] . "</td><td>" . $row['position'] .
      "</td><td>" . $row['message'] ."</td></tr>";
    }

    //Для отображения количества страниц производим рассчеты
    $rows = mysqli_query($connection, "SELECT * FROM messages");
    $count = $rows->num_rows;
    $pages = ceil($count/$limit);
    ?>
    </table>

    <?php
    //Выводим номера страниц
    for($i = 1; $i <= $pages; $i++) {
      echo "<a href='?id=" . $i . "'>" . $i ."</a> ";
    }

    ?>
    <a href="/webcom">Назад</a>
  </body>
</html>
