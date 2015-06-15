<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
 * Created on 22 mai 2014
 * @autor : Azmoud Amina
 * Affichage de l'ensemble des publications des films sur la semaine en cours
-->
<html>
  <head>
    <title>programmation du cinéma</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- Inclure les fichiers css de jquery ainsi du projet -->
    <link rel="stylesheet" type="text/css" media="screen" href="../jquery/themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../jquery/themes/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../jquery/themes/ui.multiselect.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../media/style.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
    </style>
    <!-- Inclure les fichiers javascript du pluging jquery -->
    <script src="../jquery/js/jquery.js" type="text/javascript"></script>
    <script src="../jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="../media/projet.js" type="text/javascript"></script>
	<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	//$.jgrid.useJSON = true;
	</script>
    <script src="../jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../jquery/js/jquery-ui-custom.min.js" type="text/javascript"></script>
 	<script>
		$(function() {
			$( "#datepicker" ).datepicker({
				showOn: "button",
				buttonImage: "../media/calendar.gif",
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
  <div id="text">
  	  <h1>afficher les films par :</h1>
  	  <!-- Zone de recherche : permet la recherche multiple Par Semaine ET par date de publication  
  	  		ainsi par titre du film -->
      <form action="programmefilm.php" method="POST">
	      <table width="750">
			<tr>
				<th>Semaine</th>
				<!-- Semaine (Semaine en cours + 2 semaines) -->
				<td>
				<select name="semaine">
					<?php 
					$semaine = date("W", strtotime(date('Y-m-d')));
					for($i=0; $i < 3; $i++){
						echo '<option ';
						echo (isset($_POST['semaine']) && $_POST['semaine'] == $semaine) ? "selected=\"selected\"" : "";
						echo 'value="'.$semaine.'">semaine '.$semaine.'</option>';
						$semaine ++;
					}			
					?>
				</select>			
				</td>
				 <!-- Date de publication -->
				<th>Date publication</th>
				<td><input type="date" id="datepicker" name="date" value="<?php echo isset($_POST['date'])?$_POST['date']:''?>" /></td>			
			</tr>	
			<tr>
				 <!-- recherche par titre du film  -->
				<th>Titre du film</th>
				<td><input type="text" class="text" name="titre" value="<?php echo isset($_POST['titre'])?$_POST['titre']:''?>" /></td>		
			</tr>
			<tr>
				<td></td>
				<td colSpan=3 ><input type="submit" class="submit button" name="chercher" value="Chercher" /></td>			
			</tr>		
		  </table>
	  </form>
	  <hr />
	  <table width="750">
		<tr>
			<td><h1>Resultat </h1></td>
			<td align="right"><a href="programmefilm.php?trier">Trier le résultat par genre</a></td>
		</tr>
	  </table>
	  <table width="750">
		<?php 
		/**
		 * Action de recherche renvoie vers la même pages
		 * 
		 */
		include('../action/bd-config.php');	
		$requete = "SELECT DISTINCT p.* , f.titre, f.image, s.nom " .
									"FROM publication p, film f, salle_projection s, genre_film g " .
									"WHERE p.ref_film = f.ref_film " .
									"AND p.id_salle = s.id_salle " .
									"AND f.ig_genre = g.id_genre ";
		/**
		 * construire la requete de recherche a partir des données de la formulaire
		 * tous champs sont stockés dans la méthode post
		 */
		if (!empty($_POST['semaine'])) {
			$semaine = trim($_POST['semaine']);
			$requete .= "AND p.semaine = '$semaine' ";
		}else{
			$requete .= "AND p.semaine = WEEK( NOW(), 1) ";
		}
		if (!empty($_POST['titre'])) {
			$titre = trim($_POST['titre']);
			$requete .= "AND f.titre LIKE '%".$titre."%' ";
		}
		if (!empty($_POST['date'])) {
			$date = trim($_POST['date']);
			$requete .= "AND p.date_publication = '$date' ";
		}
		if(!empty($_GET['trier'])){
			$requete .= "ORDER BY  g.genre";
		}
		$result = $conn->prepare($requete);
		$result->execute();
		$nb = 3;
		$i = 1;
		/**
		 * a partir du desultat de la recherche afficher les films trouvés.
		 * affichage de 3 films par ligne
		 */
		while($row = $result->fetch()) {
			if($i == 1) { echo'<tr>'; }
			echo'<td style="width:35%">' .
					'<span><a href="fichefilm.php?id='.$row['ref_film'].'"><img alt="test" src="image/'.$row['image'].'" /></a></span>' .
					'<span class="desc"><p>Titre : '.$row['titre'].'</br>' .
					'Salle : '.$row['nom'].'</br>' .
					'Date : '.$row['date_publication'].'</br>' .
					'Heure : '.$row['horaire'].'</br></p>' .
					'</span>' .
				'</td>';
			$i++;
			if($i > $nb) { echo'</tr>'; $i = 1; }
		}			
		?>
	  </table>
	<div id="text">
</div>
</body>
</html>