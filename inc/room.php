<?php
	session_start();
	
?>
<p>Мій каібнет</p>
<p><?= isset($_SESSION['user']) ? $_SESSION['user'].", додайте запис до свого блогу." : "" ?></p>
<form class="msg_form" method="post" action="inc/query.php" >
	<!--<label class="msg_label">Додайте запис</label><br>-->
	<textarea class="msg_area" name="message" rows="10"><?= isset($_SESSION['msg']) ? $_SESSION['msg'] : ""?></textarea><br>
	<span class="error_msg"><?= isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : "" ?></span><br />
	<input class="button msg_sub" type="submit" name="msg" value="Додати" />
</form>

<?php
	count_of_notes($_SESSION['id_user']);
	echo "<br>";
	user_list($_SESSION['id_user']);
	unset($_SESSION['msg']);
?>
