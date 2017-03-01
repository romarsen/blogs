<?php

	function filter($str, $param='i'){
		if($param=='i')
			return (int)$str;
		else
			return trim(strip_tags($str));
	}

	define('DB_HOST','localhost');
	define('DB_LOGIN','root');
	define('DB_PASSWORD','123');
	define('DB_NAME','newforms');

	function zapys($n){
		if($n%10==1 && $n!=11 )
			$zapys="запис )";
		else if($n%10==2 || $n%10==3 || $n%10==4)
			$zapys="записи )";
		else
			$zapys="записів )";
		return $zapys;
	}

	function count_of_notes($id_user){
		$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
		mysqli_query($link,"SET NAMES 'utf8'");
		$sql="SELECT COUNT(id) AS num FROM  msg WHERE id_user = $id_user" or die(mysqli_error());
		$res=mysqli_query($link, $sql) or die(mysqli_error());
		if(!$res)
			echo "<p>bad!".$id_user."</p>";
		$row_count=mysqli_num_rows($res);
		if($row_count>0){
			$row = mysqli_fetch_assoc($res);//" ".zapys($row['num'])."
			echo "<p class='count_of_notes'>Ви створили ".$row['num']." ".zapys($row['num'])."</p>";
		}
		else
			echo "<p class='count_of_notes'>Ви ще не створили жодного запису</p><hr>";
		mysqli_close($link);
	}

	function user_list($id_user){
		$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
		mysqli_query($link,"SET NAMES 'utf8'");
		$sql="SELECT id, message, UNIX_TIMESTAMP(datetime) as dt FROM msg  WHERE id_user = $id_user ORDER BY dt DESC ";
		$res=mysqli_query($link, $sql) or die(mysqli_error());
		$row_count=mysqli_num_rows($res);
		if($row_count>0){
			while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
				$d=date( "Y-m-d H:i:s" , $row['dt']);
				$text="<p class='user_list'>".$d."<br>".$row['message']."</p>";
				$text.="<p><span class='button list_button span_del'><a class='button_a' href=\"../index.php?id=room&del=".$row['id']."\">Видалити</a></span>";
				$text.="<span class='button list_button span_edit'><a class='button_a' href=\"../index.php?id=edit&ed=".$row['id']."\">Редагувати</a></span><br><br></p>";

				echo $text;
			}
		}
		mysqli_close($link);
	}

	if($_SERVER['REQUEST_METHOD']=='GET' AND $_GET['id']=='room'){
		if(isset($_GET['del']) && $_GET['del']!=0){
			$del=filter($_GET['del'], 'i');
			$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
			$sql="DELETE FROM msg WHERE id = $del";
			$res=mysqli_query($link, $sql) or die(mysqli_error($link));
			mysqli_close($link);
			header("Location: " . $_SERVER["HTTP_REFERER"]);
			exit;
		}
	}
	if($_SERVER['REQUEST_METHOD']=='GET' AND $_GET['id']=='edit'){
		if(isset($_GET['ed'])){
			$ed=filter($_GET['ed'], 'i');
			$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
			mysqli_query($link,"SET NAMES 'utf8'");
			$sql="SELECT id, message FROM msg WHERE id = $ed";
			$res=mysqli_query($link, $sql) or die(mysqli_error($link));
			$row_count = mysqli_num_rows($res);
			if($row_count){
				$row = mysqli_fetch_assoc($res);
				$ed_msg=$row['message'];
				$_SESSION['id_msg']=$row['id'];
			}
			mysqli_close($link);
		}

	}

	function all_blogs(){
		$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
		mysqli_query($link,"SET NAMES 'utf8'");
		$sql="SELECT u.login as login, m.message as message, UNIX_TIMESTAMP(m.datetime) as dt FROM users u, msg m WHERE u.id = m.id_user ORDER BY dt DESC";
		$res=mysqli_query($link, $sql) or die(mysqli_error($link));
		$row_count = mysqli_num_rows($res);
		if($row_count){
			while($row = mysqli_fetch_assoc($res)){
				$d1=date( "Y-m-d" , $row['dt']);
				$d2=date( "H:i:s" , $row['dt']);
				$text="<span class='all_list_span'>".$d1." о ".$d2." ".$row['login']." написав: </span><p class='all_list_p'>".$row['message']."<br><br></p>";
				echo $text;
			}
		}

		mysqli_close($link);
	}

	function count_of_messages(){
		$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
		$sql="SELECT COUNT(id) as num FROM msg ";
		$res=mysqli_query($link, $sql) or die(mysqli_error($link));
		$row_count = mysqli_num_rows($res);
		if($row_count){
			$row = mysqli_fetch_assoc($res);
			echo "<p class='count_of_messages'>Наші відвідувачи залишили  ".$row['num']." ".zapys($row['num'])."</p>";
		}	
		mysqli_close($link);	
	}

	if($_SERVER['REQUEST_METHOD']=='GET'){
		if(isset($_SESSION['user']) AND (!isset($_GET['id']))){
			$menu="<a href='index.php?id=room'><li class='outer_li'>Кабінет</li></a>";
		}
		else if(isset($_SESSION['user']) AND ($_GET['id']=='enter')){
			$menu="<a href='index.php?id=out'><li class='outer_li'>Вийти</li></a>";
		}
		else if(isset($_SESSION['user']) AND ($_GET['id']=='reg')){
			$menu="<a href='index.php?id=room'><li class='outer_li'>Кабінет</li></a>";
		}
		else if(isset($_SESSION['user']) AND ($_GET['id']=='room')){
			$menu="<a href='index.php?id=out'><li class='outer_li'>Вийти</li></a>";
		}
		else if(isset($_SESSION['user']) AND ($_GET['id']=='edit')){
			$menu="<a href='index.php?id=out'><li class='outer_li'>Вийти</li></a>";
		}
		else if(!isset($_SESSION['user'])){
			$menu="<a href='index.php?id=enter'><li class='outer_li'>Увійти</li></a>";
		}
		if($_GET['id']=='out'){
			$menu="<a href='index.php?id=enter'><li class='outer_li'>Увійти</li></a>";
			session_unset();
		}
	}
