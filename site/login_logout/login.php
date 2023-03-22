<?php
session_start();
require_once("../db_connect.php");


// if ((!isset($_POST["email"])) && (!(isset($_POST["user_name"])))) {
//         echo json_encode(["success" => false, "error" => "donnée manquant"]);
//         die;
// }

// if (!isset($_POST["pwd"]) || !empty(trim($_POST["pwd"]))){
//     echo json_encode(["success" => false, "error" => "Données manquantes"]);
//     die;
// }

if((isset($_POST["username_email"])) && isset($_POST["pwd"]) && !empty(trim($_POST["username_email"])) && (!empty(trim($_POST["pwd"])))){
    $req = $db->prepare("SELECT pwd,users_id,admin FROM users WHERE email=? OR user_name=?");
    $req->execute([$_POST["username_email"],$_POST["username_email"]]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST["pwd"], $user["pwd"])) {
        $_SESSION["connected"] = true;
        $_SESSION["users_id"] = $user["users_id"];
        $_SESSION["admin"] = $user["admin"];
        echo json_encode(["success" => true, "msg" => "connecté"]);
        die;
    } else {
        echo json_encode(["success"=>false, "error"=>"mot de passe érroné"]);
    }
    // } else {
    //     $_SESSION = [];
    //     echo json_encode(["success" => false, "error" => "Utilisateur introuvable"]);
    // }
} else {
    $_SESSION = [];
    echo json_encode(["success" => false, "error" => "donnée manquante"]);
} 
    
// }else if ((!isset($_POST["user_name"]) && (!empty(trim($_POST["user_name"]))))){
//     $req = $db->prepare("SELECT pwd,users_id,admin FROM users WHERE user_name=?");
//     $req->execute([$_POST["user_name"]]);
//     $user = $req->fetch(PDO::FETCH_ASSOC);    

//     if ($user && password_verify($_POST["pwd"], $user["pwd"])) {
//         $_SESSION["connected"] = true;
//         $_SESSION["users_id"] = $user["users_id"];
//         $_SESSION["admin"] = $user["admin"];
//         echo json_encode(["success" => true]);
//         echo json_encode(["success" => true, "msg" => "connecté"]);
//         die;
//     } else {
//         $_SESSION = [];
//         echo json_encode(["success" => false, "error" => "Utilisateur introuvable"]);
//     }
// }else{
//     echo json_encode(["success"=>true, "msg"=>"connecter"]);
// }


