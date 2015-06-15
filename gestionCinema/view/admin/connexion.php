<?php
include("communs.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<!--
 * Created on 22 mai 2014
 *
 * @autor : Azmoud Amina
-->
 <head>
  <title>home</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ANSI" />
	<link rel="stylesheet" type="text/css" media="screen" href="../../media/style.css" />
 </head>
 <body>
<?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
echo '<ul style="padding:0; color:red;">';
foreach($_SESSION['ERRMSG_ARR'] as $msg) {
echo '<li>',$msg,'</li>'; 
}
echo '</ul>';
unset($_SESSION['ERRMSG_ARR']);
}
?>
<div id="wrapper">
   <div id="header">
    <!-- header-div starts -->
    <h1>Cinémathéque</h1>
  </div>
<form action="connexion.php" method="POST">
<div id="text">
	<table>
		<tr>
			<th>Identifiant</th>
			<td><input type="text" class="text" name="login" value="" size="" maxlength="" /></td>
		</tr>
		<tr>
			<th>Mot de passe</th>
			<td><input type="password" class="password" name="password" size="size" maxlength="size" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" class="submit button" name="connexion" value="connexion" /></td>
		</tr>
	</table>
</div>
</form>
</div>
<?php
if(isset($_POST['connexion'])){
		$login = $_POST['login'];
		$pass = $_POST['password'];
		$errflag = false;
		if($login == '') {
			$errmsg_arr[] = 'le login du film est obligatoire';
			$errflag = true;
		}	
		if($pass == '') {
			$errmsg_arr[] = 'le password du film est obligatoire';
			$errflag = true;
		}	
		if($errflag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			redirige("connexion.php");
			exit();
		}
		require_once '../../action/bd-config.php';
		$sql = "SELECT * FROM utilisateur WHERE login = '".$login."' AND password = '".$pass."'";
		$result = $conn->prepare($sql);
		$result->execute();
		$row = $result->fetch();
		if($row != false && is_array($row)){
			$_SESSION['login'] = $row;
			redirige("../../admin.php");			
		}
	}
?>
</body>
</html>
