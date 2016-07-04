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

    include 'classes/paginate.class.php';
    $paginate = new Paginate;
    $paginate->showTable();
    echo "</table>";
    $paginate->showPages();

    ?>
    <br><br>
    <a href="/info_page">Назад</a>
  </body>
</html>
