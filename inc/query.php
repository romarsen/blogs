<?php
	session_start();
	//session_destroy();
$_SESSION['error_query'] = "";
$_SESSION['error_query_reg'] = "";
$_SESSION['error_login'] = "";
$_SESSION['error_pass'] = "";
$_SESSION['error_login_reg'] = "";
$_SESSION['error_pass_reg'] = "";
$_SESSION['error_double_pass'] = "";


	require 'lib.inc.php';
	$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
	mysqli_query($link,"SET NAMES 'utf8'");

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['enter'])){
		session_unset();
		if($_POST['login']=="" || $_POST['pass']==""){
			if($_POST['login']=="")
				$_SESSION['error_login']="Введіть логін";
			if($_POST['pass']=="")
				$_SESSION['error_pass']="Введіть пароль";
			header("Location: ../index.php?id=enter");
			exit;
		}
		else{
			$login=filter($_POST['login'],'s');
			$pass=filter($_POST['pass'],'s');

			$login=mysqli_real_escape_string($link, $login);

			$sql="SELECT id, login, password FROM users WHERE login ='".$login."'";
			$res=mysqli_query($link, $sql) or die(mysqli_error($link));
			mysqli_close($link);

			$row_count=mysqli_num_rows($res);
			if(!$row_count){
				$_SESSION['error_query']="Невірний логін або пароль!";
				header("Location: ../index.php?id=enter");
				exit;
			}
			else {
				$row = mysqli_fetch_assoc($res);
				if(password_verify($pass, $row['password'])){
					$_SESSION['user']=$row['login'];
					$_SESSION['id_user']=$row['id'];
					header("Location: ../index.php?id=room");
					exit;
				}
				else{
					$_SESSION['error_query']="Невірний логін або пароль!";
					header("Location: ../index.php?id=enter");
					exit;
				}
			}



		}
	}

	if(($_SERVER['REQUEST_METHOD']=='POST') AND (isset($_POST['reg']))){
		session_unset();
		if($_POST['login']=="" || $_POST['pass']==""){
			if($_POST['login']=="")
				$_SESSION['error_login_reg']="Введіть логін";
			if($_POST['pass']=="")
				$_SESSION['error_pass_reg']="Введіть пароль";
			header("Location: ../index.php?id=reg");
			exit;
		}

		else{
			$login=filter($_POST['login'], 's');
			$login=mysqli_real_escape_string($link, $login);
			$pass=filter($_POST['pass'], 's');

			$pass1=filter($_POST['pass1'], 's');

			if($pass != $pass1) {
				$_SESSION['error_double_pass'] = "Вказані паролі не співпадають!";
				header("Location: ../index.php?id=reg");
				exit;
			}

			else {
				$_SESSION['error_double_pass'] = "";
				$hash=password_hash($pass, PASSWORD_BCRYPT);

				$sql="SELECT id, login FROM users WHERE login ='".$login."'";
				$res=mysqli_query($link, $sql) or die(mysqli_error($link));
				$row_count = mysqli_num_rows($res);
				
				if(!$row_count){
					$sql="INSERT INTO users(login, password) VALUE(?, ?)";
					$stmt=mysqli_prepare($link, $sql);
					mysqli_stmt_bind_param($stmt, "ss", $login, $hash);
					mysqli_stmt_execute($stmt);
					mysqli_close($link);
					session_destroy();
					header("Location: ../index.php?id=enter");
					exit;
				}
				else{
					$_SESSION['error_query_reg']="Користувач з таким логіном вже зареєстрований!";
					header("Location: ../index.php?id=reg");
					exit;
				}
			}
		}
	}

	if(($_SERVER['REQUEST_METHOD']=='POST') AND (isset($_POST['msg']))){
		if($_POST['message']==""){
			$_SESSION['error_msg']="Заповніть поле.";
			header("Location: ../index.php?id=room");
			exit;
		}
		else{
			if(isset($_SESSION['id_user'])){
				unset($_SESSION['error_msg']);
				$msg=filter($_POST['message'],'s');

				$id_user=filter($_SESSION['id_user'], 'i');

				$sql="INSERT INTO msg (message, id_user) VALUE (?,?)";
				$stmt=mysqli_prepare($link, $sql);
				mysqli_stmt_bind_param($stmt, "si", $msg, $id_user);
				mysqli_stmt_execute($stmt) or die(mysqli_error($link));
				mysqli_close($link);
				header("Location: ../index.php?id=room");
				exit;
			}
			else{
				header("Location: ../index.php?id=enter");
				exit;
			}

		}

	}

	if(($_SERVER['REQUEST_METHOD']=='POST') AND (isset($_POST['edit_msg']))){
		if($_POST['message']==""){
			$_SESSION['error_msg']="Заповніть поле.";
			header("Location: ../index.php?id=edit");
			exit;
		}
		else{
			if(isset($_SESSION['id_user'])){
				unset($_SESSION['error_msg']);
				$msg=filter($_POST['message'],'s');

				$sql="UPDATE msg SET message=? WHERE id=".$_SESSION['id_msg'];
				$stmt=mysqli_prepare($link, $sql);
				mysqli_stmt_bind_param($stmt, "s", $msg);
				mysqli_stmt_execute($stmt) or die(mysqli_error($link));
				mysqli_close($link);
				header("Location: ../index.php?id=room");
				exit;
			}
			else{
				header("Location: ../index.php?id=enter");
				exit;
			}

		}

	}
