<?php
require "../includes/config.php";
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


   <?php include "../includes/header.php" ?>
    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <div class="block__content">


                 <?php

                 
                if(isset($_POST['submitReg']))
                    {
                        $surname=$_POST['surname'];
                        $name=$_POST['name'];
                        $patronymic=$_POST['patronymic'];
                        $birthday=$_POST['birthday'];
                        $login=$_POST['login'];
                        $password=$_POST['password'];
                        $password_retry=$_POST['password_retry'];
                        $sex=$_POST['sex'];
                        $status=$_POST['status'];
                        $telephone=$_POST['telephone'];
                        $date_registration=$_POST['date_registration'];
                        
                        $dir='D:\OpenServer\OSPanel\domains\cipher111.ru\avatars'.$login.'.jpg';
                        
                        $ttt=move_uploaded_file($_FILES['file']['tmp_name'],$dir);

                        if($password==$password_retry){
                        $res = mysqli_query ($connection,"INSERT INTO users (surname,name,patronymic,birthday,login,password,sex,telephone,date_registration,status) VALUES('$surname','$name','$patronymic','$birthday','$login','$password','$sex','$telephone',NOW(),1)");}
                            else {echo'неверно ввели пароль';}  
                    }
                ?>

                <h1 style="text-align: center;"> Регистрация </h1>
                <form method="POST" enctype="multipart/form-data" style="text-align: center;"> 

                <br/>&nbsp;Фамилия:<br/>
                <input type = "text" name ="surname"/><br/>
                <br/>&nbsp;Имя:<br/>
                <input type = "text"  name= "name" /><br/>
                <br/>&nbsp;Отчество:<br/>
                <input type = "text"   name= "patronymic"/><br/>
                <br/>&nbsp;Дата Рождения:<br/>
                <input type = "date"   name="birthday"/><br/>

                <br/>&nbsp;Логин:<br/>
                <input type = "text"  name="login"/><br/>

                <br/>&nbsp;Пароль:<br/>
                <input type = "password"  name="password"/><br/>

                <br/>&nbsp;Подтвердите пароль:<br/>
                <input type = "password"  name="password_retry"/><br/>

                <br/>&nbsp;Пол:<br/>
                <select  name="sex">
                    <option value = "1">М</option>
                    <option value = "0">Ж</option>
                </select><br/>

                <br/>&nbsp;Телефон:<br/>
                <input type = "text" name="telephone"/>
                <br/> <br/>

                <input type="file" name="file"/> 
                </br></br><input type = "submit"  value = "Зарегистрироваться" name ="submitReg"/>
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
    
          