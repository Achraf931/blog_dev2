<?php
require_once __DIR__ . '/../vendor/autoload.php';
require('./tools/commons.php');

$messages = [];
//New article
if (isset($_POST['newArticle'])) {
    $allowed_extensions = array('jpg', 'jpeg', 'png');
    $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    if (empty($_POST['title'])) {
        $messages['title'] = 'Le titre est obligatoire !';
    }
    if (empty($_POST['description'])) {
        $messages['description'] = 'La description est obligatoire !';
    }
    if ($_FILES['image']['error'] !== 0) {
        $messages['image'] = 'L\'image est obligatoire !';
    }
    if ($_FILES['image']['error'] == 0 AND !in_array($my_file_extension, $allowed_extensions)) {
        $messages['imageExt'] = 'L\'extension est invalide !';
    }
    if (empty($messages)) {
        do {
            $new_file_name = md5(rand());
            $destination = './assets/img/' . $new_file_name . '.' . $my_file_extension;
        } while (file_exists($destination));

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        $query = $db->prepare('INSERT INTO articles(title, image, description, published_at) VALUES (?, ?, ?, NOW())');
        $query->execute([
            $_POST['title'],
            $new_file_name . '.' . $my_file_extension,
            $_POST['description']
        ]);

        if ($query) {
            $_SESSION['message'] = 'Evénement ajouté !';
            header('location:index.php');
            exit;
        }
    }
}

//Update Article
if (isset($_POST['update'])) {
    $selectImage = $db->prepare('SELECT image FROM articles WHERE id = ?');
    $selectImage->execute([
        $_GET['article_id']
    ]);
    $recupImage = $selectImage->fetch();

    $allowed_extensions = array('jpg', 'jpeg', 'png');
    $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    if (empty($_POST['title'])) {
        $messages['title'] = 'Le titre est obligatoire !';
    }
    if (empty($_POST['description'])) {
        $messages['description'] = 'La description est obligatoire !';
    }
    if ($_FILES['image']['error'] == 0 AND !in_array($my_file_extension, $allowed_extensions)) {
        $messages['imageExt'] = 'L\'extension est invalide !';
    }
    if (empty($messages)) {
        if ($_FILES['image']['error'] == 0){
            do {
                $new_file_name = md5(rand());
                $destination = './assets/img/' . $new_file_name . '.' . $my_file_extension;
                $image = $new_file_name . '.' . $my_file_extension;
            } while (file_exists($destination));
        } else{
            $image = $_POST['imgExist'];
        }

        $queryUpdt = $db->prepare('UPDATE articles SET title = :title, description = :description, published_at = NOW(), image = :image WHERE id = :id');

        $resultArticle = $queryUpdt->execute([
            'title' => htmlspecialchars($_POST['title']),
            'description' => htmlspecialchars($_POST['description']),
            'image' => htmlspecialchars($image),
            'id' => $_POST['id']
        ]);

        if ($image != $_POST['imgExist']){
            $pathImg = './assets/img/';
            unlink($pathImg . $recupImage['image']);
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }

        if ($resultArticle) {
            $_SESSION['message'] = 'Evénement mis à jour !';
            header('location:index.php');
            exit;
        } else {
            $_SESSION['message'] = 'Erreur.';
        }
    }
}
if (isset($_GET['article_id']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
    $queryEvent = $db->prepare('SELECT * FROM articles WHERE id = ?');
    $queryEvent->execute(array($_GET['article_id']));
    $article = $queryEvent->fetch();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            font-family: ITCavant;
        }
        body {
            background-color: #141414;
        }
        @font-face {
            src: url('./assets/css/ITCAvantGardeStd-Md.otf');
            font-family: "ITCavant";
        }
        h3 {
            color: white;
            text-decoration: none;
            margin: 0;
        }
        input, textarea {
            padding: 15px 20px;
            border-radius: 5px;
            background-color: white;
            border: 1px solid #e6e6e6;
            margin: 10px 0;
        }
        button {
            background-color: #ED9902;
            color: white;
            max-width: 150px;
            padding: 14px;
            margin: 8px 0;
            border: none;
            border-radius: 10px;
            font-size: 100%;
            cursor: pointer;
        }
        .containerForm {
            height: 100vh;
            width: 100vw;
            background-image: url("./assets/img/ipad.jpg");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .containerForm > form {
            display: grid;
            font-weight: bold;
        }
        span {
            color: red;
        }
        .goHome {
            background-color: #ED9902;
            color: white;
            max-width: 200px;
            padding: 14px;
            margin: 8px 0;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-size: 100%;
            cursor: pointer;
        }
        form {
            display: grid;
            max-width: 600px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="containerForm">
    <form action="article.php<?= isset($article) ? '?article_id=' . $article['id'] . '&action=edit' : ''; ?>" enctype="multipart/form-data" method="post">
        <h3><?php if (isset($article)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un article</h3>
        <input type="text" placeholder="Titre" name="title" value="<?= isset($article) ? $article['title'] : ''; ?>">
        <span><?= isset($messages['title']) ? $messages['title'] : ''; ?></span>
        <input type="file" name="image">
        <span><?= isset($messages['image']) ? $messages['image'] : ''; ?></span>
        <span><?= isset($messages['imageExt']) ? $messages['imageExt'] : ''; ?></span>
        <img style="width: 100%;" src="./assets/img/<?= isset($article) ? $article['image'] : ''; ?>" alt="">
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <span><?= isset($messages['description']) ? $messages['description'] : ''; ?></span>
        <div style="display: flex; justify-content: space-between">
            <?php if (isset($article)): ?>
                <button style="background-color: forestgreen" type="submit" name="update">Edit Article</button>
                <input type="hidden" name="id" value="<?= $article['id']; ?>">
                <input type="hidden" name="imgExist" value="<?= $article['image']; ?>">
            <?php else: ?>
                <button style="background-color: forestgreen" type="submit" name="newArticle">New Article</button>
            <?php endif; ?>
            <a href="index.php" class="goHome">Revenir à l'accueil</a>
        </div>
    </form>
</div>
</body>
</html>
