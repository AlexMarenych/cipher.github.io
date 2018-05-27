<?php
require "../includes/config.php";
?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Личный кабинет</title>

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
<?php 
                  $rez=mysqli_query($connection,'SELECT * FROM `users` where `id`='.$_SESSION['id']);
                  $row=mysqli_fetch_assoc($rez);
                  $_SESSION['id']=$row['id'];
                   $_SESSION['login']=$row['login'];
                   $_SESSION['name']=$row['name'];
                   $_SESSION['surname']=$row['surname'];
                   $_SESSION['patronymic']=$row['patronymic'];
                   $_SESSION['birthday']=$row['birthday'];
                                ?>
    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h2>Личный кабинет</h2>
              <div class="block__content" >
                <div class="article__image" style="width:170px; height:220px; background-image: url(../avatars/avatars<?php echo $row['login']; ?>.jpg); "></div>

                  <div class="full-text">
                  
                  <?php echo 'Привет, '.$_SESSION['surname'].' '.$_SESSION['name'].' '.$_SESSION['patronymic'];?></br>
                  <?php echo 'Ваш логин: '.$_SESSION['login'];?></br>
                   <?php echo 'Дата рождения - '.$_SESSION['birthday'];?></br>

                   <h3>Ваши статьи</h3>
                   <div class="block__content">
                 <div class="articles articles__horizontal">

                <?php
                  $per_page=5;
                  $page=1;

                  if(isset($_GET['page']))
                  {
                    $page =(int) $_GET['page'];
                  }

                  $total_count_q=mysqli_query($connection,"SELECT COUNT(`id`) AS `total_count` FROM `articles`");
                  $total_count=mysqli_fetch_assoc($total_count_q);
                  $total_count = $total_count['total_count'];

                  $total_pages=ceil($total_count/$per_page);  
                  if( $page <= 1 || $page>$total_pages)
                  {
                    $page=1;
                  }
  
                  $offset=($per_page * $page)-$per_page;
                   $articles=mysqli_query($connection,'SELECT * FROM `articles` WHERE `users_id`='.$row['id'].' ORDER BY `id` DESC LIMIT '.$offset.','.$per_page);
                  
                  $articles_exist=true;
                  if(mysqli_num_rows($articles)<=0)
                  {
                    echo 'Статей нет!';
                    $articles_exist=false;
                  }

                  while($art=mysqli_fetch_assoc($articles))
                  {
                    ?>
                       <article class="article">
                       <div class="article__image" style="background-image: url(/images/<?php echo $art['image']; ?>);"></div>
                        <div class="article__info">
                      <a href="/article.php?id=<?php echo $art['id']; ?>"> <?php echo $art['title']; ?> </a>
                      <div class="article__info__meta">

                        <?php
                          //$art_cat=false;
                          foreach ($categories as $cat) {
                            if($cat['id']==$art['categorie_id'])
                            {
                              $art_cat = $cat;
                              break;
                            }
                            
                          }
                        ?>
                        <small>Категория: <a href="/categorie_articles.php?categorie=<?php echo $art_cat['id'];?>"><?php echo $art_cat['title']; ?></a></small>
                      </div>
                      <div class="article__info__preview"><?php echo  mb_substr(strip_tags($art['text']), 0,100,'utf-8').'...';?><a href="/article.php?id=<?php echo $art['id'];?>">еще</a></div>
                    </div>

                  </article>
                    <?php
                  }
                  ?>
                  </div>

                  
                    <?php
                  
                
                  ?> 
 
              

                
              </div>
                </div>
              </div>
            </div>
            <div class="block">
              <h3>Добавить статью</h3>
              <div class="block__content">
                        <form class="form" method="POST" enctype="multipart/form-data">
                          <?php
                            if( isset($_POST['pub_article']))
                            {
                              $errors=array();
                              if($_POST['title']=='')
                              {
                                $errors[]='Введите тему!';
                              }
                              if($_POST['text']=='')
                              {
                                $errors[]='Введите текст!';
                              }
                              if($_POST['categorie_id']=='')
                              {
                                $errors[]='Выбирите категорию!';
                              }

                              if(empty($errors))  
                              {
                                 $name_files=$_FILES['file']['name'];
                                $uploaddir='D:\OpenServer\OSPanel\domains\cipher111.ru\images\\'. $name_files.'';
                                $uploadfile=$uploaddir.basename($_FILES['file']['name']);
                                $ttt=move_uploaded_file($_FILES['file']['tmp_name'],$uploaddir);
                               

                                mysqli_query($connection, "INSERT INTO `articles` (`title`,`image`,`text`,`categorie_id`,`pubdate`,`users_id`) VALUES ('".$_POST['title']."' ,'".$name_files."','".$_POST['text']."','".$_POST['categorie_id']."',NOW(),'".$_SESSION['id']."')");
                                echo '<span style="color: green; font-weight: bold; margin-bottom: 10px; display: block;"> Комментарий успешно добавлен </span>';
                                $dir='D:\OpenServer\OSPanel\domains\cipher111.ru\images\\'.$image.'';
                               $ttt=move_uploaded_file($_FILES['file']['tmp_name'],$dir);
                                 header("Refresh:0");
                              }else
                              {
                                echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">'. $errors['0'] .'</span>';
                              }
                            }
                          ?>
                          <div class="form__group">
                            <input type="text" class="form__control" name="title" placeholder="Название статьи"/>
                          </div>

                          <div class="form__group">
                            <textarea class="form__control" name="text" placeholder="Текст статьи ..."><?php echo $_POST['text'];?></textarea>
                          </div>
                          
                            
                          <select  name="categorie_id">
                            <option value = "1">История</option>
                            <option value = "2">Главные задачи</option>
                            <option value = "3">Учебные дисциплины</option>
                            <option value = "4">Научная деятельность</option>
                            <option value = "5">Издательская деятельность</option>                          
                          </select>

                          <div class="form__group">
                            <input type="file" name="file"/> 
                          </div> 

                          <div class="form__group">
                            <input type="submit" name="pub_article" value="Добавить статью" class="form__control">
                          </div>
                        </form>
                      </div>
              </div>

          </section>
          <section class="content__right col-md-4">
            <?php  include "../includes/sidebar.php";  ?>
          </section>
        </div>
      </div>
    </div>

   <?php include "../includes/footer.php"; ?>

  </div>

</body>
</html>