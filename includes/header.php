<header id="header">
  <div class="header__top">
    <div class="container">
      <div class="header__top__logo">
        <h1><?php echo $config['title'];?></h1>
      </div>
      <nav class="header__top__menu">
        <ul>
          <li>
            <a href="/">Главная</a></li>
          <?php
              if (empty($_SESSION['id'])){
                 echo '<li><a href="/pages/registration.php">Регистрация</a></li>';
                }
              if (isset($_SESSION['id'])){
                echo '<li><a href="/pages/about_me.php">Личный кабинет</a></li>';
              }         
          ?>
           <li> <a href="/pages/users.php">Список пользователей</a></li>
        </ul>
      </nav>
    </div>
  </div>
  <?php
   $categories=mysqli_query($connection,"SELECT * FROM `articles_categories`");
   $categories_q=array();
   while($cat = mysqli_fetch_assoc($categories))
   {
    $categories_q[]=$cat;//Будет добавлять все категории в массив
   }
  ?>
  <div class="header__bottom">
    <div class="container">
      <nav>
        <ul>
          <?php
            foreach($categories_q as $cat)//while($cat=mysqli_fetch_assoc($categories))
            {
              ?>
                <li><a href="/categorie_articles.php?categorie=<?php echo $cat['id']; ?>"><?php echo $cat['title'];?></a></li>
              <?php
            }
          ?>
          
        </ul>
      </nav>
    </div>
  </div>
</header>
