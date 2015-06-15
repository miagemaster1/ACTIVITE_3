<?php
include("communs.php");
if(!isset($_SESSION['login'])){
 	redirige("connexion.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>ajouter un film</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../jquery/themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../jquery/themes/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../jquery/themes/ui.multiselect.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../media/style.css" />
    <script src="../../jquery/js/jquery.js" type="text/javascript"></script>
    <script src="../../jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="../../media/projet.js" type="text/javascript"></script>
    <script src="../../jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../../jquery/js/jquery-ui-custom.min.js" type="text/javascript"></script>
 	<script>
		$(function() {
			$( "#datepicker" ).datepicker({
				showOn: "button",
				buttonImage: "../../media/calendar.gif",
				buttonImageOnly: true,
				dateFormat:'yy-mm-dd'			
			});
		});
	</script>    
  </head>
  <body>
<div id="wrapper">
   <div id="header">
    <!-- header-div starts -->
    <h1>Cinémathèque</h1>
  </div>
  <!-- header-div ends -->
  <div id="nav">
    <!-- Navigation div starts -->
    <a href="../../admin.php">Accueil</a>
	<a href="listefilm.php">gestion des films</a>
	<a href="listepublication.php">publication des films</a>
	<a href="deconnexion.php">deconnexion</a>
  </div>
 <div id="text">
 <h1>ajouter une nouvelle publication</h1>
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
	<form action="ajouterpublication.php" method="post">
	<table>  
		<tr>
			<td>Titre du film</td>
			<td>
				<select name="film">
				<?php 
				include('../../action/bd-config.php');	
				$result = $conn->prepare("SELECT ref_film, titre FROM film ORDER BY titre ASC");
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					echo '<option value="'.$row['ref_film'].'">'.$row['titre'].'</option>';
				}			
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Salle de projection</td>
			<td>
				<select name="salle">
				<?php
				$result = $conn->prepare("SELECT id_salle, nom FROM salle_projection ORDER BY nom ASC");
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					echo '<option value="'.$row['id_salle'].'">'.$row['nom'].'</option>';
				}			
				?>
				</select>			
			</td>
		</tr>
		<tr>
			<td>Date de publication</td>
			<td><input type="date" id="datepicker" name="date" value="" size="" maxlength="" /></td>
		</tr>
		<tr>
			<td>Heure de publication</td>
			<td><input type="text" class="text" name="heure" value="" size="" maxlength="" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" class="submit button" name="publier" value="publier" />
			<input type="submit" class="submit button" name="annuler" value="annuler" /></td>
		</tr>	
	</table>
	</form> 
 </div>	
<?php 
if(isset($_POST['annuler'])){
	redirige("listepublication.php");
}
if(isset($_POST['publier'])){
	$film = $_POST['film'];
	$salle = $_POST['salle'];
	$date = $_POST['date'];
	$heure = $_POST['heure'];
	$errflag = false;
	if($film == '') {
		$errmsg_arr[] = 'le titre du film est obligatoire';
		$errflag = true;
	}
	if($salle == '') {
		$errmsg_arr[] = 'la salle est obligatoire';
		$errflag = true;
	}
	if($date == '') {
		$errmsg_arr[] = 'la date de publication du film est obligatoir';
		$errflag = true;
	}
	if($heure == '') {
		$errmsg_arr[] = 'l\'heure de publiation du film est obligatoir';
		$errflag = true;
	}
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		redirige("ajouterpublication.php");
		exit();
	}
	//apartir de la date de publication déduire automatiquememtn la semaine en cours de publication
	//pour faciliter la recherche aprés
	$semaine = date("W", strtotime($date));
	// inclure la configiration de la base de données
	require_once '../../action/bd-config.php';
	try {
		$sql = "INSERT INTO publication (ref_film, id_salle, date_publication, horaire, semaine ) VALUES (:1,:2,:3, :4, :5)";
		$q = $conn->prepare($sql);
		$q->execute(array(':1'=>$film,':2'=>$salle,':3'=>$date, ':4'=>$heure, ':5'=>$semaine));
		redirige("listepublication.php");
	}
	catch( Exception $e ) {
		var_dump($e);
	}
}
?>
</body>
</html>