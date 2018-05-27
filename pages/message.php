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
              <h3 style="text-align: center;">Переписка с <?php
                $user=mysqli_query($connection,"SELECT * FROM `users` WHERE `id`=".$_GET['id']);
                $user=mysqli_fetch_assoc($user);
                echo $user['name'].'ом';

               ?></h3>
              <div class="block__content">
                <div class="articles articles__vertical">

                <?php

                   $messagess=mysqli_query($connection,"SELECT * FROM `messages` WHERE (`id_from`='".$_SESSION['id']."' AND `id_to`='".$_GET['id']."') OR(`id_from`='".$_GET['id']."' AND `id_to`='".$_SESSION['id']."') ORDER BY `id` LIMIT 20");

                  while($message=mysqli_fetch_assoc($messagess))
                  {
                    if($message['id_to']==$_GET['id'])
                    {
                      $user_from=mysqli_query($connection,"SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
                      $user_array_from=mysqli_fetch_assoc($user_from);
                      ?>

                      <article class="article">
                       <div class="article__image" style="background-image: url(/avatars/avatars<?php echo $user_array_from['login']; ?>.jpg);text-align: left; height: 80px; font-size: 30px;border-radius: 100%; padding: 30px 15px;"></div>
                        <div class="article__info" >
                      <font size="+2" face="monospace" color="#1D4887"><b><strong><?php echo $user_array_from['name']?> </strong></b></font>  <font size="0">  <?php echo $message['data'].'</font>'.' <br><br>'.' <font size="+2" face="monospace" color="black">'.$message['message'].'</font>'; ?>
                      </div>
                      </article>
                      <?php
                    }
                    else if($message['id_from']==$_GET['id'])
                    {
                      $user_to=mysqli_query($connection,"SELECT * FROM `users` WHERE `id`='".$_GET['id']."'");

                      $user_array_to=mysqli_fetch_assoc($user_to);
                      ?>

                      <article class="article">
                       <div class="article__image" style="background-image: url(/avatars/avatars<?php echo $user_array_to['login']; ?>.jpg); float:right; height: 80px; font-size: 30px;border-radius: 100%; padding: 30px 15px;"></div>
                        <div class="article__info" style="text-align: right;">
                      <?php echo '<font size="+2" face="monospace" color="#1D4887"><b><strong>'.$user_array_to['name'].'</strong></b></font>'.' <font size="0">'.$message['data'].'</font>'.'<br><br><font size="+2" face="monospace" color="black">'.$message['message'].'</font>'; ?> 
                      </div>
                      </article>
                      <?php
                    }
                  }
                ?>

               
                </div>
                 <form class="form" method="POST" enctype="multipart/form-data">
                          <?php
                          echo '<br/>';
                            if( isset($_POST['pub_message']))
                            {
                              $errors=array();
                              if($_POST['text']=='')
                              {
                                $errors[]='Введите текст!';
                              }

                              if(empty($errors))  
                              {
                                mysqli_query($connection, "INSERT INTO `messages` (`data`,`id_from`,`id_to`,`message`) VALUES (NOW(),'".$_SESSION['id']."','".$_GET['id']."','".$_POST['text']."')");
                                echo '<span style="color: green; font-weight: bold; margin-bottom: 10px;"> Сообщение отправлено </span>';
                                 header("Refresh:0");
                              }else
                              {
                                echo '<span style="color: red; font-weight: bold; margin-bottom: 10px;">'. $errors['0'] .'</span>';
                              }
                            }
                          ?>

                          <div class="form__group">
                            <textarea class="form__control" name="text" placeholder="Текст сообщения ..."></textarea>
                          </div>

                          <div class="form__group">
                            <input type="submit" name="pub_message" value="Отправить сообщение" class="form__control">
                          </div>
                        </form>
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