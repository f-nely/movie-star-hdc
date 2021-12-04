<?php

require_once 'templates/header.php';
require_once 'models/User.php';
require_once 'dao/UserDAO.php';
require_once 'dao/MovieDAO.php';

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

// receber id do usuário
$id = filter_input(INPUT_GET, 'id');

if (empty($id)) {

  if (!empty($userData)) {
    $id = $userData->id;
  } else {
    $message->setMessage('Usuário não encontrado!', 'error', 'index.php');
  }

} else {

  $userData = $userDao->findById($id);

  // se não encontrar usuário
  if (!$userData) {
    $message->setMessage('Usuário não encontrado!', 'error', 'index.php');
  }
  
}

$fullName = $user->getFullName($userData);

if ($userData->image == '') {
  $userData->image = 'user.png';
}

// filmes que o usuário adicionou
$userMovies = $movieDao->getMoviesByUserId($id);

?>

<div id="main-container" class="container-fluid edit-profile-page">

</div>

<?php
require_once 'templates/footer.php';
?>