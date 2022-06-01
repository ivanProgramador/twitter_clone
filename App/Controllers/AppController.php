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

                $usuario = Container::getModel('Usuario');
                $usuario->__set('id',$_SESSION['id']);

	              $this->view->info_usuario    =  $usuario-> getInfoUsuario();
	              $this->view->total_tweets    =  $usuario-> getTotalTweets();
	              $this->view->total_seguindo  =  $usuario-> getTotalSeguindo();
	              $this->view->info_seguidores =  $usuario-> getTotalSeguidores();




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



		public function quemSeguir(){

			$this->validaAutenticacao();

			 $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

			 $usuarios = array();

			

			 if ($pesquisarPor != '') {
			 	
			 	$usuario = Container::getModel('Usuario');
			 	$usuario->__set('nome',$pesquisarPor);
			 	$usuario->__set('id', $_SESSION['id']);
			 	$usuarios = $usuario->getAll();

			 }


            $this->view->usuarios = $usuarios;
			$this->render('quemSeguir');



		}


		public function acao(){

			$this->validaAutenticacao();

			$acao = isset($_GET['acao'])?$_GET['acao']:'';
			$id_usuario_seguindo = isset($_GET['id_usuario'])?$_GET['id_usuario']:'';

			$usuario = Container::getModel('Usuario');

			$usuario->__set('id',$_SESSION['id']);

			if ($acao == 'seguir' ) {

				$usuario->seguirUsuario($id_usuario_seguindo);
				
			}else if($acao == 'deixar_de_seguir'){

				$usuario->deixarSeguirUsuario($id_usuario_seguindo);

			}

			header('Location: /quem_seguir');







            
		}


		public function remover(){


			$this->validaAutenticacao();

			$usuario = Container::getModel('Usuario');

			$id_usuario = $_GET['id_usuario_'];

			$usuario->removerTweet($id_usuario);

			header('Location: /timeline');



		}














	}
?>