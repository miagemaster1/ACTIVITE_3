<?php
session_start();
if(!isset($_SESSION['login'])){
header("location: view/admin/connexion.php");
}?>
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="media/style.css" />
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
  <div id="nav">
    <!-- Navigation div starts -->
    <a href="admin.php">Accueil</a>
	<a href="view/admin/listefilm.php">gestion des films</a>
	<a href="view/admin/listepublication.php">publication des films</a>
	<a href="view/admin/deconnexion.php">deconnexion</a>
  </div>
  </div>
 <div id="text">
 <h1>Bienvenue</h1>
 <p>Binvenue dans le backOffice de l'application.
 Ce rubrique vous permettra de gerer les films, ainsi de faire la pulication des informations des films sur le site</p>	
 </div>			
</div>
</body>
</html>
