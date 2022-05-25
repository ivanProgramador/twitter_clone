<?php

	namespace App\Controllers;

	//os recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;

	class AppController extends Action{

		public function timeline(){

						
			    $this->validaAutenticacao();

				//recuperando os tweets

				$tweet = Container::getModel('Tweet');
				
				$tweet->__set('id_usuario', $_SESSION['id']);

				$tweets = $tweet->getAll();
                
                $this->view->tweets = $tweets;

				$this->render('timeline');
				
		

			
		}



		public function tweet(){


			    $this->validaAutenticacao();

			
				$tweet = Container::getModel('tweet');

				$tweet->__set('tweet', $_POST['tweet']);

				$tweet->__set('id_usuario', $_SESSION['id']);

				$tweet->salvar();

				header('Location: /timeline');


			
		}


		public function validaAutenticacao(){

			session_start();

			//testando se o susrio antes de entrar passou pelo processo de autenticação
			//se ele não tiver passado esses indices vão estar vazios porque ele não 
			//preencheu o formulario se estiver vazia o header vai direcionar ele ao formulario de 
			//autenticação


			if(!isset($_SESSION['id']) || $_SESSION['id'] == '' && !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {

				header('Location: /?login=erro');
                

			}
		}


	}
?>