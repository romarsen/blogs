<?php
	session_start();

	//include 'lib.inc.php';
?>
<p class="enter_p">Зареєструйтеся, публікуйте власні блоги та читайте інших авторів.</p>
<p class="enter_error"><?=  isset($_SESSION['error_query_reg']) ? $_SESSION['error_query_reg'] : "" ?></p>

<form class="enter_form" method="post" action="inc/query.php" >
	<label class="enter_label">Логін</label><br>
	<input class="enter_input" type="text" name="login"/>
	<span class="enter_error"><?= isset($_SESSION['error_login_reg']) ? $_SESSION['error_login_reg'] : "" ?></span><br><br>
	
	<label class="enter_label">Пароль</label><br>
	<input class="enter_input" type="password" name="pass"/>
	<span class="enter_error"><?= isset($_SESSION['error_pass_reg']) ? $_SESSION['error_pass_reg'] : "" ?></span><br>

	<input class="enter_input" type="password" name="pass1"/>
	<span class="enter_error"><?= isset($_SESSION['error_double_pass']) ? $_SESSION['error_double_pass'] : "" ?></span><br>
	
	<input class="button reg_sub" type="submit" name="reg" value="Зареєструватись"/><br>
</form>

