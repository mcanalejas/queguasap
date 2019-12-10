<?php
error_reporting(E_ALL);			// directivas para activar 
ini_set('display_errors', '1');	// la notificación de errores

session_start();
include_once 'model/bd.inc.php';
include_once 'view/header.inc.php';
include_once 'view/footer.inc.php';
include_once 'controller/controller.inc.php';
include_once 'view/show_view.php';

actualizar_sesion();

show_header();
show_menu();
show_content();
show_footer();


?>
