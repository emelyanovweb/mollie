<?php 

// Подключение к базе данных  
    try {  
        $db = new PDO('mysql:host=localhost;dbname=db', 'db', 'pass');  
        $db->query('set names utf8');
    } catch (PDOException $e) {  
        echo $e->getMessage();  
        exit;  
    }  
 $db = new PDO('mysql:host=localhost;dbname=db', 'db', 'pass');  
 $db->query('set names utf8');
$apiKey = ""; //токен агрегатора

?>