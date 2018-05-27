<?php
require "includes/config.php";
session_start();
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

  <?php include "includes/header.php" ?>
  <?php
    $article=mysqli_query($connection, "SELECT * FROM `articles` WHERE `id`=" . (int) $_GET['id']);

    if(mysqli_num_rows($article)<=0)
    {
      ?>
      <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h3>Статья не найдена!</h3>
              <div class="block__content">
                <div class="full-text">
                  Запрашивая вами статья не найдена!

                </div>
              </div>
            </div>
          </section>
          <section class="content__right col-md-4">
            <?php include "includes/sidebar.php"; ?>
          </section>
        </div>
      </div>
    </div>
      <?php
    }else
    {
      $art=mysqli_fetch_assoc($article);
      mysqli_query($connection, "UPDATE `articles` SET `views`=`views` + 1 WHERE `id`= ". (int) $art['id']);
      ?>
        <div id="content">
              <div class="container">
                <div class="row">
                  <section class="content__left col-md-8">
                    <div class="block">
                      <a><?php echo $art['views'];?> просмотров </a>
                      <h3><?php echo $art['title']; ?>  </h3>
                      <div class="block__content">
                        <img src="/images/<?php echo $art['image'];?>" style="max-width:100%;">
                        <div class="full-text">
                            <?php echo $art['text']; ?>
                        </div>
                      </div>
                    </div>



                    <div class="block">
                      <a href="#comment-add-form"> <?php if(isset($_SESSION['id']))
                  { ?> Добавить свой <?php } ?></a>
                      <h3>Комментарии</h3>
                      <div class="block__content">
                        <div class="articles articles__vertical">
                          <?php

                               $comments = mysqli_query($connection, "SELECT * FROM `comments`,`users` WHERE `comments`.`articles_id` = ".$art['id'] . " AND `comments`.`users_id` = `users`.`id` ORDER BY `comments`.`id` DESC");
                               

                               if( mysqli_num_rows($comments) <= 0)
                               {
                                echo "Нет комментариев!";
                               }
                              while($comment=mysqli_fetch_assoc($comments))
                              {
                                   ?>
                                   <article class="article">
                                   <div class="article__image" style="background-image: url(../avatars/avatars<?php echo $comment['login']; ?>.jpg);"></div>
                                    <div class="article__info">
                                  <a href="/article.php?id=<?php echo $comment['articles_id']; ?>"> <?php echo $comment['surname']; ?> </a>
                                  <div class="article__info__meta">
                                  </div>
                                  <div class="article__info__preview"><?php echo  $comment['text']?></div>
                                </div>
                              </article>
                                <?php
                              }
                            ?>
                        </div>
                      </div>
                    </div>
                  <?php if(isset($_SESSION['id']))
                  { ?>
                    <div id="comment-add-form" class="block">
                      <h3>Добавить комментарий</h3>
                      <div class="block__content">
                        <form class="form" method="POST" action="article.php?id=<?php echo $art['id'];?>#comment-add-form">
                          <?php
                            if( isset($_POST['do_post']))
                            {
                              $errors=array();

                              if($_POST['text']=='')
                              {
                                $errors[]='Введите текст!';
                              }
                              if(empty($errors))  
                              {
                                mysqli_query($connection, "INSERT INTO `comments` (`users_id`,`text`,`pubtime`,`articles_id`) VALUES ('".$_SESSION['id']."','".$_POST['text']."',NOW(), '".$art['id']."')");
                                echo '<span style="color: green; font-weight: bold; margin-bottom: 10px; display: block;"> Комментарий успешно добавлен </span>';
                                 header("Refresh:0");
                              }else
                              {
                                echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">'. $errors['0'] .'</span>';
                              }
                            }
                          ?>

                          <div class="form__group">
                            <textarea class="form__control" name="text" placeholder="Текст комментария ..."><?php echo $_POST['text'];?></textarea>
                          </div>
                          <div class="form__group">
                            <input type="submit" name="do_post" value="Добавить комментарий" class="form__control">
                          </div>
                        </form>
                      </div>
                    </div>
                    <?php } else { ?>
                     <div class="block__content">
                      Чтобы оставить комментарий, Вам нужно <a href="/pages/registration.php">зарегистрироваться</a>
                    </div>

                      <?php }  ?>
                    </section>
          <section class="content__right col-md-4">
            <?php include "includes/sidebar.php"; ?>
          </section>
        </div>
      </div>
    </div>  
      <?php
      
    }
    ?>
  

    

           

   <?php include "includes/footer.php"; ?>

  </div>

</body>
</html>