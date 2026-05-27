<?php
# view/guestbookView.php
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TI2 | Livre d'or</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>TI2 | Livre d'or</h1>
            <div class="header-btns">
                <button id="btnDark">🌙 Dark Mode</button>
            </div>
    </header>

<!-- Formulaire d'ajout d'un message -->
<h2>Ici le formulaire</h2>

<main>

<?php
    if(isset($insert)):
        if($insert===false):
?>
    <div class="echec-message">Problème lors de l'envoi du message
        <script> setTimeout(
            function() {
                window.location.href="./";
            }, 3000
        );
        </script>
    </div>

<?php
    else:
?>

    <div class="reussite-message">Merci pour votre nouveau message
        <script> setTimeout(
            function() {
                window.location.href="./";
            }, 3000
        );
        </script>
    </div>

<?php   
    endif;
        endif;
?>

    <section class="form-section">
        <form id="guestbook-form" method="POST">

            <div class="form-group">
                <label for="firstname">Votre prénom</label>
                <input type="text" id="firstname" name="firstname" placeholder="Votre prénom">
            </div>

            <div class="form-group">
                <label for="lastname">Votre nom</label>
                <input type="text" id="lastname" name="lastname" placeholder="Votre nom">
            </div>

            <div class="form-group">
                <label for="usermail">Votre email</label>
                <input type="email" id="usermail" name="usermail" placeholder="Ex : Jeandupont@gmail.com">
            </div>

            <div class="form-group">
                <label for="phone">Votre tel</label>
                <input type="text" id="phone" name="phone" placeholder="Ex : 0464 28 48 50">
            </div>

            <div class="form-group">
                <label for="postcode">Votre code postal</label>
                <input type="text" id="postcode" name="postcode" placeholder="Ex : 1190">
            </div>
                   
            <div class="form-group">
                <label for="message">Votre message</label>
                <textarea type="text" id="message" name="message" rows="4" placeholder="Votre message"></textarea>
            </div>
                   
                <button type="submit" class="submit-btn">Envoyer votre message</button>
        </form>
    </section>

<!-- Si pas de message -->
        <section class="messages-section">
 <?php
            $nbMessage = count($messages);
                if(empty($nbMessage)):
 ?>
            <h3>Pas encore de message</h3>
<!-- Si 1 message -->
<?php
            else:
                $pluriel = $nbMessage>1 ? "s" :"";
?>
            <h3>Message<?= $pluriel ?> récent<?= $pluriel ?></h3>

<?php
            foreach($messages as $message):
?>

            <div class="message_card">
                <h3>Ecrit par <?= htmlspecialchars($message['usermail'])?> le 
                <p><?= htmlspecialchars($message['datemessage']) ?></p>
            </div>

<?php
            endforeach;
                endif;
?>
        </section>
    </main>
</div>

<!-- Pagination (BONUS) -->

<!-- Liste des messages -->
<ul>
    <li>
        <p><strong>firstname lastname</strong></p>
        <p><em>datemessage</em></p>
        <p>message</p>
    </li>
    <!-- Autres messages -->
    <li>
        <p><strong>firstname lastname</strong></p>
        <p><em>datemessage</em></p>
        <p>message</p>
    </li>
</ul>
etc ...
<!-- Pagination (BONUS) -->
<?php
// À commenter quand on a fini de tester
/*echo "<h3>Nos var_dump() pour le débugage</h3>";
echo '<p>$_POST</p>';*/
var_dump($_POST);
/*echo '<p>$_GET</p>';
var_dump($_GET);*/
var_dump($connectDB);
?>

<script src="js/scipt.js"></script>
<script src="js/jquery-3.7.1.min.js"></script>
</body>
</html>