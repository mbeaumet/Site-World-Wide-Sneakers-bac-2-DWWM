<?php
session_start();
require_once("db_connect.php");


if ((!isset($_POST["email"]) || empty(trim($_POST["email"])) && (!isset($_POST["user_name"]) || empty(trim($_POST["user_name"])) ))) {
        echo json_encode(["success" => false, "error" => "donnée manquant"]);
        die;
}

if (!isset($_POST["pwd"]) || empty(trim($_POST["pwd"]))){
    echo json_encode(["success" => false, "error" => "Données manquantes"]);
    die;
}

$req = $db->prepare("SELECT pwd,users_id,admin FROM users WHERE email = ? OR user_name=?");
$req->execute([$_POST["email"],$_POST["user_name"]]);
$user = $req->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($_POST["pwd"], $user["pwd"])) {
    $_SESSION["connected"] = true;
    $_SESSION["users_id"] = $user["users_id"];
    $_SESSION["admin"] = $user["admin"];
    echo json_encode(["success" => true]);
    echo json_encode(["sucess" => true, "msg" => "connecté"]);
    die;
} else {
    $_SESSION = [];
    echo json_encode(["success" => false, "error" => "Utilisateur introuvable"]);
}



