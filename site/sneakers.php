<?php

require_once("db_connect.php");
require("function.php");
is_connected();

if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
else $method = $_GET;


switch($method["opt"]){
    case 'select':

        $req = $db->query("SELECT s.* FROM sneakers s ");
        $articles = $req->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "articles" => $articles]);
        break;

    case 'select_id':
        if (isset($_SESSION["users_id"])){
        
            $req=$db->prepare("SELECT * FROM sneakers WHERE users_id=?");
            $req->execute([$_SESSION["users_id"]]);
            $sneakers=$req->fetch(PDO::FETCH_ASSOC);
            echo json_encode(["success"=>true,"sneakers"=>$sneakers]);
                
        } else{
            echo json_encode(["success"=>false,"error"=>"error données manquantes"]);
        }
    
        break;


    case 'insert':
        if (isset($_POST["size"],$_POST["color"],$_POST["brand"],$_POST["states"],$_POST["price"],$_POST["stock"]) && !empty(trim($_POST["size"])) && !empty(trim($_POST["color"])) && !empty(trim($_POST["brand"])) && !empty(trim($_POST["states"])) && !empty(trim($_POST["price"])) && !empty(trim($_POST["stock"]))){
            
            $req= $db->prepare("INSERT INTO sneakers (brand,color,price,size,states,image,stock,users_id) VALUES (:brand,:color,:price,:size,:states,:image,:stock,:users_id)");

            $req->bindValue(":brand", $_POST["brand"]);
            $req->bindValue(":color", $_POST["color"]);
            $req->bindValue(":price", $_POST["price"]);
            $req->bindValue(":size", $_POST["size"]);
            $req->bindValue(":states", $_POST["state"]);
            $req->bindValue(":image",$_POST["image"]);

            $img = false; // Je défini img à false par défaut
            // fonction upload définis dans function.php
            if (isset($_FILES["image"]["name"])) $img = upload($_FILES); // Je récupère la réponse de l'upload
                
            if ($img) $req->bindValue(":image", "/asset/product_img".$img); // Je bind le chemin si la réponse de upload() n'est pas false
            else $req->bindValue(":image", null); // Je bind null sinon



            $req->bindValue(":stock", $_POST["stock"]);
            $req->bindValue(":users_id",$_SESSION["users_id"]);
            //$req->bindValue(":image", $_POST["image"]);
            $req->execute();
            echo json_encode((["success"=>true]));
    
        }else {
            echo json_encode((["success"=>false, "error"=>"erreur lors de l'insertion"]));
        }
    
        break;

    case 'update_id':
        if (isset($_POST["size"],$_POST["color"],$_POST["brand"],$_POST["states"],$_POST["price"],$_POST["image"],$_POST["stock"]) && !empty(trim($_POST["size"])) && !empty(trim($_POST["color"])) && !empty(trim($_POST["brand"])) && !empty(trim($_POST["states"])) && !empty(trim($_POST["states"])) && !empty(trim($_POST["image"])) && !empty(trim($_POST["price"])) && !empty(trim($_POST["stock"]))){
            $req= $db->prepare("UPDATE sneakers SET size=:size,color=:color,brand=:brand,states=:states,image=:image,price=:price,stock=:stock WHERE users_id = :users_id");
            $req->bindValue(":size",$_POST["size"]);
            $req->bindValue(":color",$_POST["color"]);
            $req->bindValue(":brand",$_POST["brand"]);
            $req->bindValue(":states",$_POST["states"]);
            $req->bindValue(":price" ,$_POST["price"]);
            $req->bindValue(":image",$_POST["image"]);
            $req->bindValue(":stock",$_POST["stock"]);
            $req->bindValue(":users_id",$_SESSION["users_id"]);
            $req->execute();
            echo json_encode(["success"=>true]);
        }else{
            echo json_encode((["success"=>false, "error"=>"erreur lors de la mise a jour"]));
        }
           
        break;

    case 'delete_id':
        if (isset($_SESSION["users_id"]) && !empty(trim($_SESSION["users_id"]))){
            $req=$db->prepare("DELETE FROM sneakers WHERE users_id=?");
            $req->execute([$_SESSION["users_id"]]);
            echo json_encode((["success"=>true ]));

        }else{
            echo json_encode((["success"=>false, "error"=>"erreur de suppression"]));
        }
    
        break;
    
    default:
        echo json_encode(["success" => false, "error" => "Demande inconnue"]);
        break;
}