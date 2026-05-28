<?php
# view/guestbookView.php
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="js/jquery-3.7.1.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TI2 | Livre d'or</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
</head id="top">
<body>

<div class="container">
    <header>
        <h1>TI2 | Livre d'or</h1>
            <div class="header-btns">
                <button id="btnDark">🌙 Dark Mode</button>
            </div>
    </header>

<main>

<?php if(isset($insert)): if($insert===false): ?>
    <div class="echec-message">Problème lors de l'envoi du message
        <script> setTimeout(function() { window.location.href="./"; }, 3000); </script>
    </div>
<?php else: ?>
    <div class="reussite-message">Merci pour votre nouveau message
        <script> setTimeout(function() { window.location.href="./"; }, 3000); </script>
    </div>
<?php endif; endif; ?>

<div class="form-wrapper">

    <section class="form-section">
        <!-- Formulaire d'ajout d'un message -->
        <h2>Ici le formulaire</h2>
        <form id="guestbook-form" method="POST">

            <div class="form-group">
                <label for="firstname">Votre prénom</label>
                <input type="text" id="firstname" name="firstname" placeholder="Votre prénom" required maxlength="20">
            </div>
            <div id="inputFirstname"></div>

            <div class="form-group">
                <label for="lastname">Votre nom</label>
                <input type="text" id="lastname" name="lastname" placeholder="Votre nom" required maxlength="20">
            </div>
            <div id="inputLastname"></div>

            <div class="form-group">
                <label for="usermail">Votre email</label>
                <input type="email" id="usermail" name="usermail" placeholder="Ex : Jeandupont@gmail.com" required maxlength="50">
            </div>
            <div id="inputUsermail"></div>

            <div class="form-group">
                <label for="phone">Votre tel</label>
                <input type="text" id="phone" name="phone" placeholder="Ex : 0464 28 48 50" required maxlength="13">
            </div>
            <div id="inputPhone"></div>

            <div class="form-group">
                <label for="postcode">Votre code postal</label>
                <input type="text" id="postcode" name="postcode" placeholder="Ex : 1190" required maxlength="4">
            </div>
            <div id="inputPostcode"></div>

            <div class="form-group">
                <label for="message">Votre message</label>
                <textarea type="text" id="message" name="message" rows="4" placeholder="Votre message" required maxlength="150"></textarea>
            </div>
            <div id="inputMessage"></div>

            <div class="box-accord">
                <input type="checkbox" name="accord" id="case">
                <label>Acceptez-vous que vos données soient stockées ?</label>
            </div>
            
            <div id="errorCheckbox" style="display:none; color:red; font-size:14px;">
                ⚠️ Vous devez cocher la case avant d'envoyer le formulaire.
            </div>

            <button type="submit" class="submit-btn">Envoyer votre message</button>
        </form>
    </section>

<!-- Si pas de message -->
    <aside class="form-aside">
        <section class="messages-section">
<?php
            $nbMessage = count($messages);
            if(empty($nbMessage)):
?>
            <h3>Vous n'avez aucun message</h3>
<!-- Si 1 message -->
<?php
            elseif($nbMessage === 1):
?>
            <h3>Vous avez 1 message</h3>
<?php
            else:
?>
            <h3>Vous avez <?= $nbMessage ?> messages</h3>

<?php endif; ?>

<?php if(!empty($nbMessage)): foreach($messages as $message): ?>

            <div class="message_card">
                <h3>Ecrit par <?= htmlspecialchars($message['usermail']) ?></h3>
                <p>le <?= date('d-m-Y', strtotime($message['datemessage'])) ?></p>
                <p>Message : <?= htmlspecialchars($message['message']) ?></p>
            </div>

<?php endforeach; endif; ?>

<!-- Pagination (BONUS) -->
<?php if(!empty($paginationHTML)) echo $paginationHTML; ?>

<!-- Liste des messages -->

<!-- Pagination (BONUS) -->
<?php
// À commenter quand on a fini de tester
/*echo "<h3>Nos var_dump() pour le débugage</h3>";
echo '<p>$_POST</p>';
var_dump($_POST);
echo '<p>$_GET</p>';
var_dump($_GET);
var_dump($connectDB);*/
?>

<a href="#top" class="btn-top">⬆</a>

<script src="js/script.js"></script>

</body>
</html>