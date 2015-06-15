<?php
include("communs.php");
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
    <a href="../../admin.php">accueil</a>
	<a href="listefilm.php">gestion des films</a>
	<a href="listepublication.php">publication des films</a>
	<a href="deconnexion.php">deconnexion</a>
  </div>
 <div id="text">
 <h1>ajouter un nouveau film</h1>
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
	<form action="ajouterFilm.php" method="post" enctype="multipart/form-data">
	<table>  
		<tr>
			<td>Titre</td>
			<td><input type="text" class="text" name="titre" value="" size="" maxlength="" /></td>
		</tr>
		<tr>
			<td>date de sortie</td>
			<td><input type="date" id="datepicker" name="date" value="" size="" maxlength="" /></td>
		</tr>
		<tr>
			<td>Réalisateur</td>
			<td><input type="text" class="text" name="realisateur" value="" size="" maxlength="" /></td>
		</tr>
		<tr>
			<td>Acteur</td>
			<td><input type="text" class="text" name="acteur" value="" size="" maxlength="" /></td>
		</tr>
		<tr>
			<td>genre</td>
			<td><select name="genre">
			<?php 
			include('../../action/bd-config.php');	
			$result = $conn->prepare("SELECT id_genre, genre FROM genre_film ORDER BY genre ASC");
			$result->execute();
			for($i=0; $row = $result->fetch(); $i++){
				echo '<option value="'.$row['id_genre'].'">'.$row['genre'].'</option>';
			}			
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td>Résumé</td>
			<td><textarea name="resume" rows="10" cols="50" wrap="off"></textarea></td>
		</tr>
		<tr>
			<td>Image</td>
			<td><input type="file" name="image" /></td>
		</tr>		
		<tr>
			<td></td>
			<td><input type="submit" class="submit button" name="ajouter" value="ajouter" />
			<input type="submit" class="submit button" name="annuler" value="annuler" /></td>
		</tr>	
	</table>
	</form>
</div>
</div>	
<?php 
if(isset($_POST['annuler'])){
	redirige("listefilm.php");
}
if(isset($_POST['ajouter'])){
	$titre = $_POST['titre'];
	$date = $_POST['date'];
	$realisateur = $_POST['realisateur'];
	$acteur = $_POST['acteur'];
	$genre = $_POST['genre'];
	$resume = $_POST['resume'];
	$errflag = false;
	if($titre == '') {
		$errmsg_arr[] = 'le titre du film est obligatoire';
		$errflag = true;
	}
	if($date == '') {
		$errmsg_arr[] = 'la date de sortie du film est obligatoire';
		$errflag = true;
	}
	if($acteur == '') {
		$errmsg_arr[] = 'l\'acteur principale du film est obligatoir';
		$errflag = true;
	}
	if($realisateur == '') {
		$errmsg_arr[] = 'le réalisateur du film est obligatoir';
		$errflag = true;
	}
	if($resume == '') {
		$errmsg_arr[] = 'le résumé du film est obligatoir';
		$errflag = true;
	}
	if ($_FILES['image']['error']) {     
	          switch ($_FILES['image']['error']){     
	                   case 1: // UPLOAD_ERR_INI_SIZE     
	                   $errmsg_arr[] = "Le fichier dÃ©passe la limite autorisÃ©e par le serveur";     
	                   $errflag = true;
	                   break;     
	                   case 2: // UPLOAD_ERR_FORM_SIZE     
	                   $errmsg_arr[] =  "Le fichier dÃ©passe la limite autorisÃ©e dans le formulaire HTML !"; 
	                   $errflag = true;
	                   break;     
	                   case 3: // UPLOAD_ERR_PARTIAL     
	                   $errmsg_arr[] = "L'envoi du fichier a Ã©tÃ© interrompu pendant le transfert !";     
	                   $errflag = true;
	                   break;     
	                   case 4: // UPLOAD_ERR_NO_FILE     
	                   $errmsg_arr[] = "Le fichier que vous avez envoyÃ© a une taille nulle !"; 
	                   $errflag = true;
	                   break;     
	          }     
	}		
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		redirige("ajouterFilm.php");
		exit();
	}
	//enregistrement de l'image du film sur le repertoire upload
	$chemin_destination = '../image/';
	if ((isset($_FILES['image']['tmp_name'])&&($_FILES['image']['error'] == UPLOAD_ERR_OK))) {     
		$chemin_destination = $chemin_destination.$_FILES['image']['name'];     
		move_uploaded_file($_FILES['image']['tmp_name'], $chemin_destination);     
	} 	
	// query
	// inclure la configiration de la base de données
	require_once '../../action/bd-config.php';
	try {
		$sql = "INSERT INTO film (titre, date_sortie, realisateur, acteur, ig_genre, resume, image) VALUES (:1,:2,:3, :4, :5, :6, :7)";
		$q = $conn->prepare($sql);
		$q->execute(array(':1'=>$titre,':2'=>$date,':3'=>$realisateur, ':4'=>$acteur, ':5'=>$genre, ':6'=>$resume, ':7'=>$_FILES['image']['name']));
		redirige("listefilm.php");
	}
	catch( Exception $e ) {
		var_dump($e);
	}
}
?>
</body>
</html>