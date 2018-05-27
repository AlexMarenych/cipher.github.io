<div class="block">
  <div class="block__content_watch">
    <?php

  $error =array();
  if($_POST['submit'])
  {
    $login=$_POST['login'];
    $password=$_POST['password'];

    $rez=mysqli_query($connection,'SELECT * FROM `users` where `login` = "'.$login.'" and `password` = "'.$password.'"');
    $row=mysqli_fetch_assoc($rez);
    if (($login=$row['login'])&&($password=$row['password'])){
     $_SESSION['id']=$row['id'];
     $_SESSION['login']=$row['login'];
     $_SESSION['name']=$row['name'];
     $_SESSION['surname']=$row['surname'];
     $_SESSION['patronymic']=$row['patronymic'];
     $_SESSION['birthday']=$row['birthday'];

      echo '<span style="color:green;">Вы вошли</span></br>';
      ini_set('session.gc_maxlifetime',1440);
       header("Refresh:0");
    }else {
    echo '<span style="color:red;">Вы ввели неверные данные</span>';
  }    
  }

  if($_POST['submitOUT'])
  {
    unset($_SESSION['id']);
    unset($_SESSION['login']);
    echo "Вы вышли";
    header("Refresh:0");
  } 

if (empty($_SESSION['id'])) 
 {
  ?>

<form action="" method="POST"  style="text-align: center;">
        <h2><center>Авторизация</h2></center><br>
        <input type="text" name="login" placeholder="Логин" value="<?php echo $login; ?>"/><br><br>
        <input type="password" name="password" placeholder="Пароль" value="<?php echo $_POST['password']; ?>"/><br><br>
        <div class="os"></div>
        <input type="submit" name="submit" style="width: 120px;" value="Вход" />
        <div class="os"></div>
        <div style="font-size: 14px; color: #777;">
            <a href="/pages/registration.php">Зарегистрироваться</a>
        </div>
    </form>
    <?php
}
else if(isset($_SESSION['login']))
{
   echo 'Привет, любимый '.$_SESSION['name'].'!<br><br><a href="/pages/about_me.php">Личный кабинет</a>';
?>
<form method="POST" > 

 </br><input type = "submit"  value = "Выйти" name ="submitOUT"/>
  </form>';
<?php
}
?>
  

  </div>
</div>

<div class="block">
  <h3>Топ читаемых статей</h3>
  <div class="block__content">
    <div class="articles articles__vertical">
         <?php
           $articles=mysqli_query($connection,"SELECT * FROM `articles` ORDER BY `views` DESC LIMIT 5");
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
  </div>
</div>

<div class="block">
  <h3>Новые комментарии:</h3>
  <div class="block__content">
    <div class="articles articles__vertical">
      <?php
           $comments=mysqli_query($connection,"SELECT * FROM `users`,`comments` WHERE `comments`.`users_id` = `users`.`id` ORDER BY `comments`.`id` DESC LIMIT 5" );
          while($comment=mysqli_fetch_assoc($comments))
          {
            ?>
               <article class="article">
               <div class="article__image" style="background-image: url(../avatars/avatars<?php echo $comment['login']; ?>.jpg);"></div>
                <div class="article__info">
              <a href="/article.php?id=<?php echo $comment['articles_id']; ?>"> <?php echo $comment['surname']; ?> </a>
              <div class="article__info__meta">
              </div>
              <div class="article__info__preview"><?php echo  mb_substr(strip_tags($comment['text']), 0,100,'utf-8').'...'?></div>
            </div>
          </article>
            <?php
          }
        ?>
    </div>
  </div>
</div>