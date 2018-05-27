<?php
session_start();
require "../includes/config.php";

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Геотехника</title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

  <div id="wrapper">

   <?php include "../includes/header.php" ?>
    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h3>Список пользователей</h3>
              <div class="block__content">
                <div class="articles articles__vertical">

                <?php
                   $articles=mysqli_query($connection,"SELECT * FROM `users` ORDER BY `id` DESC LIMIT 10");
                  while($art=mysqli_fetch_assoc($articles))
                  {
                    ?>
                       <article class="article">
                       <div class="article__image" style="background-image: url(../avatars/avatars<?php echo $art['login']; ?>.jpg);"></div>
                        <div class="article__info">
                      <a href="/pages/profile.php?id=<?php echo $art['id'];?>"> <?php echo $art['surname'].' '.$art['name'].' '.$art['patronymic']; ?> </a>
                      <div class="article__info__meta">

                        <small>Дата рождения: <?php echo $art['birthday']; ?></small><br/><br/>
                         <small>Номер телефона: <?php echo $art['telephone']; ?></small>
                      </div>
                     <?php if(isset($_SESSION['id']))
                  { ?> <div class="article__info__preview"><a href="message.php?id=<?php echo $art['id'];?>">Написать сообщение</a></div>
                  <?php } ?>
                    </div>
                  </article>
                    <?php
                  }
                ?>


              

                </div>
              </div>
            </div>

          </section>
          <section class="content__right col-md-4">
            <?php include "../includes/sidebar.php"; ?>
          </section>
        </div>
      </div>
    </div>

   <?php include "../includes/footer.php"; ?>

  </div>

</body>
</html>