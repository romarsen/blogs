<?php
	session_start();
	header("Content-type: text/html; charset=utf-8");

	require 'inc/lib.inc.php';

	if($_SERVER['REQUEST_METHOD']=='GET' AND $_GET['id']=='enter'){
		unset($_SESSION['user']);
	}
?>
<!DOCTYPE html>
<html >
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
		<link href='styles/styles.css' rel='stylesheet'>
	</head>
	<body>
		<div class="container">
			<header>
				<h1>БЛОГИ</h1>
				<p class="welcome">Вітаємо, <?= isset($_SESSION['user']) ? $_SESSION['user']."!" : " гість!" ?></p>
				<nav>
					<ul class="outer_ul">
						<a href="index.php"><li class="outer_li" >Головна</li></a>
						<a href="index.php?id=reg"><li class="outer_li">Зареєструватись</li></a>
						<?=$menu?>
					</ul>
				</nav>

			</header>
			<main>
				<section>
				<?php
					include 'inc/routing.php';
				?>
				</section>
			</main>
		</div>
	</body>
</html>