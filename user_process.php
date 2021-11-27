<?php

require_once 'globals.php';
require_once 'db.php';
require_once 'models/User.php';
require_once 'models/Message.php';
require_once 'dao/UserDAO.php';

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

// resgata o tipo do formulário
$type = filter_input(INPUT_POST, 'type');

// atualizar usuário
if ($type === 'update') {
  // resgata dados do usuário
  $userData = $userDao->verifyToken();

  // receber dados do post
  $name = filter_input(INPUT_POST, 'name');
  $lastname = filter_input(INPUT_POST, 'lastname');
  $email = filter_input(INPUT_POST, 'email');
  $bio = filter_input(INPUT_POST, 'bio');

  // criar um novo objeto de usuário
  $user = new User();

  // preencher os dados do usuário
  $userData->name = $name;
  $userData->lastname = $lastname;
  $userData->email = $email;
  $userData->bio = $bio;

  // upload da imagem
  if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
    
    $image = $_FILES['image'];
    $imageTypes = ['image/jpgeg', 'image/jpg', 'image/png'];
    $jpgArray = ['image/jpgeg', 'image/jpg'];

    // checagem de tipo de imagem
    if (in_array($image['type'], $imageTypes)) {

      // checar se jpg
      if (in_array($image, $jpgArray)) {

        $imageFile = imagecreatefromjpeg($image['tmp_name']);
      // imagem é png
      } else {
        $imageFile = imagecreatefrompng($image['tmp_name']);
      }

      $imageName = $user->imageGenerateName();

      imagejpeg($imageFile, "./img/users/" . $imageName, 100);

      $userData->image = $imageName;

    } else {
      $message->setMessage('Tipo inválido de imagem, insira png ou jpg!', 'error', 'back');
    }
  }

  $userDao->update($userData);

  // atualizar senha do usuário
} else if ($type === 'changepassword') {

} else {
  $message->setMessage('Informações inválidas!', 'error', 'index.php');
}