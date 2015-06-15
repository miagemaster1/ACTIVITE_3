<?php
include("communs.php");
if(isset($_SESSION['login'])){
unset($_SESSION['login']);
redirige("../../admin.php");
}
?>