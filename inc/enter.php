<?php
	session_start();
	//include 'lib.inc.php';
?>
<p class="enter_p">Увійдіть в свій акаунт, публікуйте та редагуйте власні блоги.</p>
<p class="enter_error"><?=  isset($_SESSION['error_query']) ? $_SESSION['error_query'] : "" ?></p>

<form class="enter_form" method="post" action="inc/query.php" >
	<label class="enter_label">Логін</label><br>
	<input class="enter_input" type="text" name="login"/>
	<span class="enter_error"><?= isset($_SESSION['error_login']) ? $_SESSION['error_login'] : "" ?></span><br>
	<label class="enter_label">Пароль</label><br>
	<input class="enter_input" type="password" name="pass"/>
	<span class="enter_error"><?= isset($_SESSION['error_pass']) ? $_SESSION['error_pass'] : "" ?></span><br>
	<input class="button enter_sub" type="submit" name="enter" value="Увійти"/><br>
</form>
