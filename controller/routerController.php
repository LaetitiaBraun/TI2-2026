<?php
# controller/routerController.php

require URL_BASE."/model/guestbookModel.php";

try{
    $connectDB = new PDO(DB_DSN, DB_LOGIN, DB_PWD);
}catch(Exception $e){
    die($e->getMessage());
}

if(isset($_POST['usermail'], $_POST['message'])){
    $insert = insertMessage($connectDB, $_POST['usermail'], $_POST['message']);
}

$messages = selectAllMessage($connectDB);

$connectDB = null;

include URL_BASE."/view/guestbookView.php";
?>