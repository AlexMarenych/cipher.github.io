<?php

$connection=mysqli_connect(
	$config['db']['sever'],
	$config['db']['username'],
	$config['db']['password'],
	$config['db']['name']
);

if($connection==false)
{
	echo'Не удалось подключиться к БД! <br>';
	echo mysql_connect_error();
	exit();
}
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$id_user = $_SESSION['id'];

?>