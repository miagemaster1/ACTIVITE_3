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
$grid->SelectCommand = 'SELECT f.*, g.genre FROM film f, genre_film g where g.id_genre = f.ig_genre';
//table de supression
$grid->table = 'film';
$grid->setPrimaryKeyId("ref_film");
$grid->serialKey = false;
// set the ouput format to XML$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
$grid->addCol(array (
	"name" => "actions",
	"formatter" => "actions",
	"editable" => false,
	"sortable" => false,
	"resizable" => false,
	"searchable" => false,
	"fixed" => true,
	"width" => 60,
	"search"=>false,
	// use keys to save or cancel a row.
	"formatoptions" => array (
		"keys" => true,
		"edit"=>false
	)
), "first");
// set labels in the header
//$grid->setColProperty("ref_film", array("label"=>"ID"));
$grid->setColProperty("titre", array (
	"label" => "Titre",
	"width" => "150"
));
$grid->setColProperty('date_sortie', 
        array("label" => "Date de sortie",
			"formatter"=>"date",
            "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s", "newformat"=>"Y-m-d"),
            "editoptions"=>array("dataInit"=>
                "js:function(elm){setTimeout(function(){
                    jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
                    jQuery('.ui-datepicker').css({'zIndex':'1200','font-size':'75%'});},100);}")
            )); 
$grid->setColProperty("realisateur", array (
	"label" => "Réalisateur",
//	"width" => "150"
));
$grid->setColProperty("acteur", array (
	"label" => "Acteur",
//	"width" => "150"
));
$grid->setColProperty("genre", array (
	"label" => "Genre"
));
$grid->setColProperty("resume", array (
	"label" => "Résumé",
//	"width" => 300
));
//$grid->setSelect("genre","SELECT DISTINCT id_genre, genre FROM genre_film ORDER BY genre", true, true, false); 
//$grid->setColProperty("UnitPrice", array("label"=>"Unit Price"));
// We can hide some columns
$grid->setColProperty("ref_film", array (
	"hidden" => true
));
$grid->setColProperty("ig_genre", array (
	"hidden" => true
));
$grid->setColProperty("image", array (
	"hidden" => true
));
// Set the url from where we obtain the data
$grid->setUrl('../../action/filmlistegrid.php');
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
$grid->setNavOptions('add', array (
	"height" => 'auto',
	"dataheight" => 'auto',
	"closeAfterEdit" => true
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
	"sortname" => "ref_film"
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