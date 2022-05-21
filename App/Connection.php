<?php

  
  namespace App;

  class Connection {

  	  public static function getDb() {

  	  	 try{
            
            //PDO é uma classe nativa do php por isso tem essa barra para que o php busque ela na raiz
            // como eu estou usando namespace App se eue não colocar a barra vai dar erro porque essa classe nao existe
            // dentro da pasta App

            $conn = new \PDO("mysql:host=localhost;dbname=mvc;charset=utf8","root","");

            return $conn;


  	  	 }catch( \PDOException $e){ 

  	  	 	echo "Erro".$e->getMessage();
  	  	 }
  	  
  	  }


  }



?>