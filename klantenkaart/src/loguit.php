<?php  
// maakt de sessie onbruikbaar
session_destroy();
// $_SESSION['inlog'] = NULL;
// $_SESSION['id'] = NULL;
// $_SESSION['rol'] = NULL;
header('Location: ../index.php') ;

?>