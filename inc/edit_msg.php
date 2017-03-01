<p>Мій каібнет</p>
<form class="msg_form" method="post" action="inc/query.php" >
	<!--<label class="msg_label">Додайте запис</label><br>-->
	<textarea class="msg_area" name="message" rows="10"><?= isset($ed_msg) ? $ed_msg : ""?></textarea><br>
	<span class="error_msg"><?= isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : "" ?></span><br />
	<input class="button msg_sub edit_button" type="submit" name="edit_msg" value="Редагувати" />
</form>
