<?php
include("communs.php");
require_once '../../jquery/tabs.php';
if(!isset($_SESSION['login'])){
 	redirige("connexion.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>gestion des films</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../jquery/themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../jquery/themes/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../jquery/themes/ui.multiselect.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../media/style.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
    </style>
    <script src="../../jquery/js/jquery.js" type="text/javascript"></script>
    <script src="../../jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="../../media/projet.js" type="text/javascript"></script>
	<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	//$.jgrid.useJSON = true;
	</script>
    <script src="../../jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../../jquery/js/jquery-ui-custom.min.js" type="text/javascript"></script>
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
	<h1>Publication des films</h1>
    <?php include ("../../action/publicationgrid.php");?>
      <div style="margin:13px 0;">
           		<a style="margin:1px 0px 0px 0px;" href="ajouterpublication.php" class="button">
           			<span class="excel">ajouter un nouvelle publication</span>
				</a>
	  </div>
  </div>
</body>
</html>