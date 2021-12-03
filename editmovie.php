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

<div id="main-container" class="container-fluid">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6 offset-md-1">
        <h1><?= $movie->title ?></h1>
        <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
        <form action="movie_process.php" method="POST" id="edit-movie-form" enctype="multipart/form-data">
          <input type="hidden" name="type" value="update">
          <input type="hidden" name="id" value="<?= $movie->id ?>">
          <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Digite o título do seu filme" value="<?= $movie->title ?>">
          </div>
          <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" name="image" id="image">
          </div>
          <div class="form-group">
            <label for="length">Duração:</label>
            <input type="text" class="form-control" name="length" id="length" placeholder="Digite a duração do filme" value="<?= $movie->length ?>">
          </div>
          <div class="form-group">
            <label for="category">Categoria:</label>
            <select name="category" id="category" class="form-control">
              <option value="">Selecione</option>
              <option value="Ação" <?= $movie->category === 'Ação' ? 'selected' : ''?>>Ação</option>
              <option value="Drama" <?= $movie->category === 'Drama' ? 'selected' : ''?>Drama</option>
              <option value="Comédia" <?= $movie->category === 'Comédia' ? 'selected' : ''?>Comédia</option>
              <option value="Fantasia / Ficção" <?= $movie->category === 'Fantasia / Ficção' ? 'selected' : ''?>Fantasia / Ficção</option>
              <option value="Romance" <?= $movie->category === 'Romance' ? 'selected' : ''?>Romance</option>
            </select>
          </div>
          <div class="form-group">
            <label for="trailer">Trailer:</label>
            <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer" value="<?= $movie->trailer ?>">
          </div>
          <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme.."><?= $movie->description ?>"</textarea>
          </div>
          <input type="submit" class="btn card-btn" value="Adicionar filme">
        </form>
      </div>
      <div class="col-md-3">
        <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>');"></div>
      </div>
    </div>
  </div>
</div>

<?php
require_once 'templates/footer.php';
?>