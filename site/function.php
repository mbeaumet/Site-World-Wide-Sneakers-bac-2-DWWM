<?php
session_start();

function isAdmin(){
    if(!$_SESSION["admin"]){
        echo json_encode(["success"=>"false", "error"=>"vous n'ètes pas admin"]);
        die;
    } 
}

function is_connected(){
    if(!$_SESSION["connected"]){
        echo json_encode(["success"=>"false", "error"=>"vous n'ètes pas connecté"]);
        die;
    }
    
}