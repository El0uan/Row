<?php
session_start();
include 'Utilisateur.php';
include'fonction.php';
header("Content-Type: text/plain");
$newi = (isset($_GET["variable1"])) ? $_GET["variable1"] : NULL;
if($newi){
    if($_SESSION['materia']==1){
        $_SESSION['IDFus1']=intval($_SESSION['ListeCarte'][$_SESSION['page']*10+$newi-1]);
        $_SESSION['materia']=2;
    } 
    else if($_SESSION['materia']==2){
        $_SESSION['IDFus2']=intval($_SESSION['ListeCarte'][$_SESSION['page']*10+$newi-1]);  
        $_SESSION['materia']=1;
    } 
}
else{echo 'Error';}

$fusion = (isset($_GET["fusion"])) ? $_GET["fusion"] : NULL;
if($fusion){
    fonction::Fusion($_SESSION['IDFus1'], $_SESSION['IDFus2']);
}
else{echo 'Error';}
