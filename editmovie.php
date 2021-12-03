<?php

require_once 'templates/header.php';

// verifica se usuário está autenticado
require_once 'dao/UserDAO.php';
require_once 'dao/MovieDAO.php';
require_once 'models/User.php';

$user = new User();

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

$movieDao = new MovieDAO($conn, $BASE_URL);

$id = filter_input(INPUT_GET, 'id');

if (empty($id)) {
  $message->setMessage('O filme não foi encontrafo!', 'error', 'index.php');
} else {
  $movie = $movieDao->findById($id);

  // verifica se filme existe
  if (!$movie) {
    $message->setMessage('O filme não foi encontrafo!', 'error', 'index.php');
  }
}

// checar se o filme tem imagem
if ($movie->image === '') {
  $movie->image = 'movie_cover.png';
}

?>

<?php
require_once 'templates/footer.php';
?>