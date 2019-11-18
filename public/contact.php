<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once('./tools/commons.php');

use Mailgun\Mailgun;

$messages = [];
if (isset($_POST['send'])) {
    if (empty($_POST['name'])) {
        $messages['name'] = 'Le nom est obligatoire !';
    }
    if (empty($_POST['email'])) {
        $messages['email'] = 'L\'adresse e-mail est obligatoire !';
    }
    if (empty($_POST['content'])) {
        $messages['content'] = 'Le contenu du message est obligatoire !';
    }
    if (empty($messages)) {
        $query = $db->prepare('INSERT INTO contact(name, email, content) VALUES (?, ?, ?)');
        $query->execute(array($_POST['name'], $_POST['email'], $_POST['content']));
        if ($query) {
            $_SESSION['message'] = 'Message envoyé avec succès !';

            $mgClient = Mailgun::create('e7e9fe44c644b0f17f236c4b9eca0347-1df6ec32-27c1d9a8');
            $domain = "sandbox58a98ca1870f4830813ced03767165c0.mailgun.org";

            $mgClient->messages()->send($domain, [
                'from' => 'Hamrouni <mailgun@sandbox58a98ca1870f4830813ced03767165c0.mailgun.org>',
                'to' => $_POST['email'],
                'subject' => 'Blog Test',
                'text' => $_POST['content']
            ]);
        } else {
            $_SESSION['message'] = 'Erreur lors de l\'envoi du message';
        }
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script rel="stylesheet" src="./assets/css/fa-5.11.2-web/css/all.min.css"></script>
    <script rel="stylesheet" src="./assets/css/index.css"></script>
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

        h1 {
            color: white;
        }

        .container {
            height: 100vh;
            width: 100vw;
            background-image: url("./assets/img/wallC.jpg");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #ED9902;
            color: white;
            max-width: 100px;
            padding: 14px;
            margin: 8px 0;
            border: none;
            border-radius: 10px;
            font-size: 100%;
            cursor: pointer;
        }

        h3 {
            color: #ED9902;
            text-decoration: none;
            margin: 0;
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
        span {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">

        <form action="contact.php" enctype="multipart/form-data" method="post">
            <h3>Contactez-nous</h3>
            <input type="text" placeholder="Nom" name="name">
            <span><?= isset($messages['name']) ? $messages['name'] : ''; ?></span>
            <input type="email" placeholder="E-mail" name="email">
            <span><?= isset($messages['email']) ? $messages['email'] : ''; ?></span>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
            <span><?= isset($messages['content']) ? $messages['content'] : ''; ?></span>
            <div style="display: flex; justify-content: space-between">
                <button style="background-color: forestgreen" type="submit" name="send">Envoyer</button>
                <a href="index.php" class="goHome">Revenir à l'accueil</a>
            </div>
            <?php if (isset($_SESSION['message'])): ?>
                <span style="color: forestgreen; text-align: center"><?= $_SESSION['message']; ?></span>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
