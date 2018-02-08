<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
    session_destroy ();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Deconnection</title>
        <script>
            window.location.replace("index.php");
            document.location.href = "index.php";
        </script>
    </head>
    <body>
        
    </body>
</html>
