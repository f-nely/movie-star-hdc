<?php

require_once 'templates/header.php';

// verifica se usuário está autenticado
require_once 'dao/UserDAO.php';
require_once 'models/User.php';

$user = new User();

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);
?>

