<?php
	$id=strtolower(strip_tags(trim($_GET['id'])));
	switch($id){
		case 'enter': include 'inc/enter.php'; break;
		case 'reg': include 'inc/reg.php'; break;
		case 'room': include 'inc/room.php'; break;
		case 'edit': include 'inc/edit_msg.php'; break;
		default: include 'inc/index.inc.php';
}	