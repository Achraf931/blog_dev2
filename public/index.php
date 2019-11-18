<?php
require_once __DIR__ . '/../vendor/autoload.php';
include_once('./tools/commons.php');

use League\Csv\Writer;

//Export to csv
if (isset($_POST['export'])) {
    $sth = $db->prepare("SELECT * FROM articles WHERE id = ?");
    $sth->execute(array($_POST['idExport']));
    $csv = Writer::createFromFileObject(new SplTempFileObject());
    $csv->insertOne(['Article']);
    $csv->insertAll($sth);
    $csv->output('article' . $_POST['idExport'] . '.csv');
    die;
}

//Get articles
$query = $db->query('SELECT * FROM articles');
$articles = $query->fetchAll();

//New articles faker
if (isset($_POST['newArticle'])) {
    $query = $db->prepare('INSERT INTO articles(title, image, description, faker, published_at) VALUES (?, ?, ?, ?, NOW())');
    $newArticle = $query->execute([
        $faker->catchphrase,
        $faker->imageUrl(),
        $faker->realText(),
        "faker"
    ]);

    if ($newArticle) {
        header('Location:index.php');
        exit;
    }
}

//Delete article
if (isset($_GET['article_id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $selectImage = $db->prepare('SELECT image FROM articles WHERE id = ?');
    $selectImage->execute([
        $_GET['article_id']
    ]);

    $recupImage = $selectImage->fetch();

    $query = $db->prepare('DELETE FROM articles WHERE id = ?');
    $result = $query->execute([
        $_GET['article_id']
    ]);

    $pathDelete = './assets/img/';

    $verif = $pathDelete . $recupImage['image'];
    if (file_exists($verif)) {
        unlink($pathDelete . $recupImage['image']);
    }
    if ($result) {
        header('Location:index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script rel="stylesheet" src="./assets/css/fa-5.11.2-web/css/all.min.css"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <script rel="stylesheet" src="./assets/css/index.css"></script>
    <title>Blog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            font-family: ITCavant;
        }
        @font-face {
            src: url('./assets/css/ITCAvantGardeStd-Md.otf');
            font-family: "ITCavant";
        }
        body {
            background-color: #1F1F1F;
        }

        button, a {
            padding: 15px;
            background-color: #ED9902;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            margin: 0 10px;
            border: none;
            font-size: 15px;
            text-decoration: none;
            text-align: center;
        }

        main {
            width: 100vw;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
        }

        header {
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: #1C1C1C;
            align-items: center;
            border-bottom: 1px solid black;
            padding: 20px 0;
            margin-bottom: 20px;
        }

        article {
            max-width: 400px;
            height: fit-content;
            border-radius: 5px;
            padding-bottom: 7px;
            text-align: center;
            margin: 0 auto 20px auto;
            border: none;
            background-color: white;
            position: relative;
        }

        article > img {
            width: 100%;
            height: 200px;
            border-radius: 5px 5px 0 0;
            object-fit: cover;
        }

        article > p {
            padding: 10px;
        }
        .date {
            position: absolute;
            right: 0px;
            font-size: 10px;
            bottom: -5px;
        }

        section {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            padding: 0 100px 50px 100px;
        }
    </style>
</head>
<body>
<main>
    <header>
        <a href="article.php">Nouvel article</a>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <button name="newArticle">Nouvel article Faker</button>
        </form>
        <a href="contact.php">Contact</a>
    </header>
    <section>
            <?php foreach ($articles as $article): ?>
                <article>
                    <a href="index.php?article_id=<?= $article['id']; ?>&action=delete" style="position: absolute; right: 0; top: 5px; color: red; padding: 0; background-color: unset; font-size: 25px"><i class="fas fa-window-close"></i></a>
                    <form action="index.php" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="<?= $article['id']; ?>" name="idExport">
                        <button type="submit" name="export" style="position: absolute; right: 0; top: <?= !empty($article['faker']) ? '35px' : '65px'; ?>; color: #004bff; padding: 0; background-color: unset; font-size: 25px"><i class="fas fa-download"></i></button>
                    </form>
                    <?php if (empty($article['faker'])): ?>
                        <a href="article.php?article_id=<?= $article['id']; ?>&action=edit" style="position: absolute; right: 0; top: <?= !empty($article['faker']) ? '5px' : '35px'; ?>; color: orange; padding: 0; background-color: unset; font-size: 30px"><i class="fas fa-pen-square"></i></a>
                    <?php endif;?>
                    <img src="<?= empty($article['faker']) ? './assets/img/' : ''; ?><?= $article['image']; ?>" alt="">
                    <?= $Parsedown->text('###' . $article['title']); ?>
                    <?= $Parsedown->text($article['description']); ?>
                    <p class="date"><?= \Carbon\Carbon::createFromDate($article['published_at'])->locale('fr')->diffForHumans(); ?></p>
                </article>
            <?php endforeach; ?>
    </section>
</main>
</body>
</html>
