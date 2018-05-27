<footer id="footer">
    <div class="container">
      <div class="footer__logo">
        <h1>ГЕОТЕХНИКА</h1>
       <script src="http://101widgets.com/w1506684969-11082016amc109pr&312&101"></script>
      </div>
      
      <nav class="footer__menu">
        <ul>
          <li><a href="/">Главная</a></li>
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
  </footer>