$(document).ready(function() {

  //-----------------
  //При отправки формы, что бы страница не перезагружалась
  //воспользуемся технологией AJAX
  //-----------------
  $("#sendBtn").bind("click", function() {

    $("#form1").each(function() {
      //Проверяем, все ли поля введены
      if($("input[type=text]").val() == '' ||
        $("input[type=email]").val() == '' ||
        $("textarea").val() == '') {
          //Если какое-то поле пустое,
          //то об этом сообщит сообщение под формой красного цвета
        $(".result").css("color", "red").text("Не все поля заполнены");
        $(".result").fadeIn("slow").delay(2000).fadeOut("slow");

      }
      else {
        // Если все поля введены, то срабатывает AJAX-запрос

        $.ajax({
          url: 'php/addmessage.php',
          type: 'POST',
          contentType: false,
          cache: false,
          processData: false,
          data: new FormData(this),
          success: clean,    //Функция очистки полей формы
          error: function (request, error) {
            console.log(arguments);
            alert(" Can't do because: " + error);
          }
        });
      }
    });
  });

  //Функция для листания и отображения отзывов
  var id = 1;
  function generate() {
    $.ajax({
      url:'php/leafing.php',
      type: 'POST',
      dataType: 'html',
      data: ({id}),
      success: display,
      // error: function (request, error) {
      //   console.log(arguments);
      //   alert(" Can't do because: " + error);
      // }
    });
  }

  //Функция вызывает при загрузке страницы, что бы сразу отоброжался отзыв
  generate();

  //При нажитии на стрелку вправо или влево, происходит движение по отзывам
  $(".arrow-right").bind("click", function() {
    ++id;
    console.log(id);
    generate();
  });
  $(".arrow-left").bind("click", function() {
    --id;
    console.log(id);
    generate();
  });

  //Функция для отображения данных при успешном AJAX-запросе
  function display(data) {
    data = JSON.parse(data);            //Преобразуем формат JSON в объект
    $(".fn").text(data['name']);        //Отображаем полученное имя отправителя
    $(".review").text(data['msg']);     //и его сообщение
    if(data['image'] == "" || data['image'] == null) {
      $(".ava").attr("src", "avatars/default.png");
    } else {
      $(".ava").attr("src", data['image']);
    }

    //Если все отзывы просмотрели, то получаем об этом сигнал
    //и сбрасываем счетчик в 1
    if(data['reset'] == true) {
      console.log(data['value']);
      id = data['value'];
    }
  }


  //Воспользуемся регулярным выражением, что бы функция срабатывала только на якори
  $("a[href^='#']").on("click", function(e) {

      //Отменяет действие по умолчанию, что бы браузер сразу не прыгнул к нужному месту
      e.preventDefault();

      //Выбираем из ссылки нужный якорь, например останется #main или #rew
	    var target = this.hash;
	    var $target = $(target);

      //---------------------
      //Функция для плавной прокрутки
      //Нашел ее в гугле, но сейчас попытаюсь объяснить принцип работы
      //--------------------
	    $("html, body").animate({
        //Возвращает координату верхней позиции экрана
	        "scrollTop": $target.offset().top
          //Устанавливаем за какое время должна произойти прокрутка(700мс),
          //Указываем значение для функции плавности
          //swing стоит по умолчанию, но в прнципе разница между swing и linear
          //заметна только если указать время прокрутки больше
          //станет заметно что при linear оно крутит страницу с одной и тойже скоростью
          //при swing скорость будет увеличиваться и уменьшаться
	    }, 700, "swing", function () {
          //в этой функции добавляем к нашей ссылке адрес якоря
	        window.location.hash = target;
	    });
	});

  //Функция для очистки полей формы
  function clean(data) {
    $("#form1").each(function() {
      this.reset();     //Эквивалентна кнопки reset
    });
    //Если AJAX-запрос завершился успешно, выводим об этом сообщеие
    $(".result").css("color", "#33FF66").text("Отзыв успешно отправлен");
    $(".result").fadeIn(3000).delay(5000).fadeOut(3000);
  }

  //Applied magic
  //В html в главном блоке(#main) имеется два блока
  //При нажатии на стрелки они поочередно исчезают и появлются
  $(".right-big, .left-big").on("click", function() {
    if($(".two").css("display") == "block") {
      $(".two").fadeOut("slow", function() {
        $(".two").css("display", "none");
      });
      $(".one").delay(1000).fadeIn("slow", function() {
        $(".one").css("display", "block");
      });
    } else {
        $(".one").fadeOut("slow", function() {
          $(".one").css("display", "none");
        });
        $(".two").delay(1000).fadeIn("slow", function() {
            $(".two").css("display", "block");
        });
    }
  });

  //Сворачивание меню после клика
  $("#top-nav a").on("click", function() {
    $('input[type=checkbox]').attr('checked',false);
  });
});
