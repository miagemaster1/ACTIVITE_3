<?php
session_start();
function redirige($url)
{
   die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}
?>
