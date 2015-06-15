<?php
// inclure la configiration de la base de données
require_once 'bd-config.php';
// inclure les classes du jqGrid
require_once ABSPATH . "../jquery/php/jqGrid.php";
// inclure le pilote pdo de connexion de la base de données
require_once ABSPATH . "../jquery/php/jqGridPdo.php";
// definir le charset
$conn->query("SET NAMES utf8");
// creer l'instance de jquery
$grid = new jqGridRender($conn);
// Data from this SQL is 1252 encoded, so we need to tell the grid
// Set the SQL Data source
$grid->SelectCommand = 'SELECT p.semaine, p.id_publication, f.titre, s.nom, p.date_publication, p.horaire ' .
		'FROM publication p, film f, salle_projection s where p.ref_film = f.ref_film ' .
		'AND p.id_salle = s.id_salle ';
//table de supression
$grid->table = 'publication';
$grid->setPrimaryKeyId("id_publication");
$grid->serialKey = false;
// set the ouput format to XML$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// set labels in the header
//$grid->setColProperty("ref_film", array("label"=>"ID"));
$grid->setColProperty("titre", array (
	"label" => "Titre du film",
	"width" => "150"
));
$grid->setColProperty('nom', 
        array("label" => "nom de la salle" )
);
$grid->setColProperty("date_publication", array (
	"label" => "date de publication",
	"width" => "150"
));
$grid->setColProperty("horaire", array (
	"label" => "heure de publication",
	"width" => "150"
));
// We can hide some columns
$grid->setColProperty("id_publication", array (
	"hidden" => true
));
$grid->setColProperty("semaine", array (
	"hidden" => true
));
// Set the url from where we obtain the data
$grid->setUrl('../../action/publicationgrid.php');
// Enable navigator
$grid->navigator = true;
// Enable only editing
$grid->setNavOptions('navigator', array (
	"excel" => false,
	"add" => false,
	"edit" => false,
	"del" => false,
	"refresh" => true,
	"search" => false
));
// Set some grid options
$grid->setGridOptions(array (
	"width"=>750,
	"scroll"=>1,
	"rowNum" => 10,
	"rowList" => array (
		10,
		20,
		30
	),
	"sortname" => "semaine",
	"grouping"=>true, 
    "groupingView"=>array(
        "groupField" => array('semaine'),
//        "groupColumnShow" => array(true),
        "groupText" =>array('<b>{0}</b>'),
//        "groupDataSorted" => true,
//        "groupSummary" => array(true)
    )  	
));
// Enable toolbar searching
$grid->toolbarfilter = true;
$grid->setFilterOptions(array (
	"stringResult" => true
));
// Enjoy
$grid->renderGrid('#grid', '#pager', true, null, null, true, true);
$conn = null;
?>