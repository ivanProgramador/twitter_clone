<?php

 //importando as classes e recurusos necessarios
 namespace MF\Model;
 use App\Connection;



 class Container{

 	public static function getModel($model){

 		//essa função tem como objetivo retornat os dados do model
 		//com a conexao ja estabelecida

 		//instancia do modelo

 		$class ="\\App\\Models\\".ucfirst($model);

 		//instancia da conexao

 		$conn = Connection::getDb();

 		//retorno da classe com a coenxao ja estabelecida

 		return new $class($conn);






 	}
 }


?>