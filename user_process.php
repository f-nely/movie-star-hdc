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

  $userDao->update($userData);

  // atualizar senha do usuário
} else if ($type === 'changepassword') {

} else {
  $message->setMessage('Informações inválidas!', 'error', 'index.php');
}