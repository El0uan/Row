<?php
session_start();
        include 'Utilisateur.php';
        include'fonction.php';
        header("Content-Type: text/plain");
        $newi = (isset($_GET["variable1"])) ? $_GET["variable1"] : NULL;
        if($newi){
            $_SESSION['IDActive']=intval($_SESSION['ListeCarte'][$_SESSION['page']*10+$newi-1]);   
        }
        else{echo 'Error';}



