<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
 * Created on 22 mai 2014
 * @autor : Azmoud Amina
 * afficher la fiche d'un film selectionné a partir de la liste des films de la page des programme
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
    <!-- Inclure les fichiers javascript de jquery-->
    <script src="../jquery/js/jquery.js" type="text/javascript"></script>
    <script src="../jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="../media/projet.js" type="text/javascript"></script>
	<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	//$.jgrid.useJSON = true;
	</script>
    <script src="../jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../jquery/js/jquery-ui-custom.min.js" type="text/javascript"></script>
  </head>
  <body>
  <div id="wrapper">
  <div id="header">
    <!-- header-div starts -->
    <h1>Cinémathèque</h1>
  </div>
  <div id="text">  
  <h1>Fiche du film </h1>
	  <table width="750">
		<?php 
		if(isset($_GET['id'])){
			include('../action/bd-config.php');
			$id_film = $_GET['id'];	
			$result = $conn->prepare("SELECT DISTINCT f.* , g.genre " .
										"FROM film f, genre_film g " .
										"WHERE f.ig_genre = g.id_genre " .
										"AND f.ref_film = ".$id_film);
			$result->execute();
			while($row = $result->fetch()) {
				echo '<tr>';
				echo '<td colSpan=2><h1>'.$row['titre'].'</h1></td>';
				echo '</tr>';				
				echo '<tr>';
				echo '<td><span><img alt=" " src="image/'.$row['image'].'" /></span></td>';
				echo '<td>' .
						'<span class="lighten"> Date de sortie : </span>'.$row['date_sortie'].'</br>' .
						'<span class="lighten"> Réalisé Par : </span>'.$row['realisateur'].'</br>' .
						'<span class="lighten"> Avec : </span>'.$row['acteur'].'</br>' .
						'<span class="lighten"> Genre : </span>'.$row['genre'].'</br>' .
					 '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td colSpan=2><h2>Synopsis et détails </h2></br>' .
					 '<p>'.$row['resume'].'</p></td>';
				echo '</tr>';
			}			
		}
		?>
	  <tr>
	  	<td colspan = 2 align="right">
	  		<a href="programmefilm.php"><input type="button" class="button" name="Retour" value="Retour" />  </a>	
	  	</td>
	  </tr>
	  </table>
	</div>
	</div>
</body>
</html>