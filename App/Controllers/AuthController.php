<?php

	namespace App\Controllers;

	//os recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;

	class AuthController extends Action{

		public function autenticar(){



			$usuario = Container::getModel('Usuario');

			$usuario->__set('email',$_POST['email']);
			$usuario->__set('senha',$_POST['senha']);

		    $usuario->autenticar();

		    if($usuario->__get('id') != '' && $usuario->__get('nome') != ''){

		    	// usando a session para manter o usuario autenticado 
		    	// a session e como um array superglobal dinamico
		    	// eu posso colocar os indices que eu queiser dentro dela
		    	//e preencher com os dados que eu precisar 
		    	//no caso eu criar os indices e preencher com os dados do usuario

		    	session_start();
                
                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['nome'] = $usuario->__get('nome');
                
                //ja que os atributos estão preenchidos segnifica que o cliente foi autenticado
                //agora ele vai pra timeline

                header('Location: /timeline');
		    	
		    }else{

		    	header('Location: /?login=erro');

		    }
          
		}

        //Essa função tem como unica finalidade deslogar o usuario 
        //limpando os dados da cessão dele e redirecionando apara a pagina inicial

		public function sair(){

			session_start();

			session_destroy();

			header('Location: /');
		}




       

	}





?>